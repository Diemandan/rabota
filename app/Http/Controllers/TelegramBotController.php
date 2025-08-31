<?php

namespace App\Http\Controllers;

use App\Models\Finance\UserSettings;
use App\Services\API\TelegramService;
use App\Services\Finance\AIAnalyzer;
use Illuminate\Http\Request;
use App\Services\Finance\TradernetService;
use App\Services\Finance\SignalService;
use App\Models\Finance\Portfolio;
use Illuminate\Support\Facades\Log;

class TelegramBotController extends Controller
{
    protected TradernetService $tradernet;
    protected SignalService $signal;
    protected TelegramService $telegramService;

    public function __construct(TradernetService $tradernet, SignalService $signal)
    {
        $this->tradernet = $tradernet;
        $this->signal = $signal;
        $userSettings = UserSettings::first() ?? config('services.telegram.token');
        $this->telegramService = new TelegramService($userSettings->telegram_api_key);
    }

    public function getUpdate()
    {
        return $this->telegramService->getUpdate();
    }

    public function sendMessage(TelegramService $service)
    {
        $service->sendMessage('test');
    }

    public function webhookUpdates(Request $request)
    {
        $aiAnalyzer = new AIAnalyzer();
        $update = $request->all();

        $clientMessage = $this->telegramService->processUpdate($update);
        $aiAnswer = $aiAnalyzer->chatWithWebSearch($clientMessage);
        $this->telegramService->sendMessage($aiAnswer);

        return response()->json(['status' => 'ok']);
    }

    public function getPortfolioReport(Request $request)
    {
        $aiAnalyzer = new AIAnalyzer();

        $withWeb = $request->input('withWeb', false);

        $report = $this->tradernet->getPortfolioReport();
        $aiReport = $aiAnalyzer->analyze($report['ai_report'], $withWeb);

        $finalReport = $report['report'] . $aiReport;

        $this->telegramService->sendMessage($finalReport);

        return response()->json(['success' => true], 204);
    }

    // Добавление бумаги в портфель
    public function addAsset(Request $request)
    {
        $symbol = $request->input('symbol');
        $type = $request->input('type', 'stock');

        $asset = Portfolio::updateOrCreate(
            ['symbol' => $symbol],
            ['type' => $type, 'added_at' => now()]
        );

        return response()->json(['message' => 'Добавлено', 'asset' => $asset]);
    }

    // Получение портфеля с сигналами
    public function getPortfolio()
    {
        $portfolio = Portfolio::all();
        $result = [];

        foreach ($portfolio as $asset) {
            $hloc = $this->tradernet->getHloc($asset->symbol, now()->subDays(30)->format('d.m.Y 00:00'), now()->format('d.m.Y 00:00'));
            $closes = array_column($hloc['hloc'][$asset->symbol] ?? [], 3);

            if (!empty($closes)) {
                $rsi = $this->signal->calculateRSI($closes);
                $signal = $this->signal->getSignal($rsi);
            } else {
                $rsi = null;
                $signal = 'нет данных';
            }

            $result[] = [
                'symbol' => $asset->symbol,
                'rsi' => $rsi,
                'signal' => $signal,
                'current_price' => end($closes) ?? null
            ];
        }

        return response()->json($result);
    }
}
