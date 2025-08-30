<?php

namespace App\Console\Commands;

use App\Models\Finance\UserSettings;
use App\Services\Finance\AIAnalyzer;
use Illuminate\Console\Command;
use App\Services\Finance\TradernetService;
use App\Services\API\TelegramService;
use Illuminate\Support\Facades\Log;

class SendPortfolioReport extends Command
{
    /**
     * Название команды для консоли
     */
    protected $signature = 'portfolio:send-report';

    /**
     * Описание команды
     */
    protected $description = 'Отправка актуального отчёта по портфелю в Telegram';

    public function handle()
    {
        try {
            $now = now()->format('H:i');
            $webSearchTimes = config('openai.web_search_times', []);
            $withWebSearch = in_array($now, $webSearchTimes);

            $userSettings = UserSettings::first();
            $telegram = new TelegramService($userSettings->telegram_api_key);
            $tradernet = new TradernetService();
            $aiAnalyzer = new AiAnalyzer();

            $report = $tradernet->getPortfolioReport();
            $aiReport = $aiAnalyzer->analyze($report['ai_report'], $withWebSearch);
            $finalReport = $report['report'] . $aiReport;
            $telegram->sendMessage($finalReport);

            $this->info('Отчёт отправлен в Telegram.');
        } catch (\Exception $exception) {
            Log::error('ОШИБКА ПРОВЕРКИ АКЦИЙ: ' . $exception->getMessage());
        }

    }
}
