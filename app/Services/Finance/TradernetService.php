<?php

namespace App\Services\Finance;

use Illuminate\Support\Facades\Http;

class TradernetService
{
    protected TradernetApiClient $client;

    public function __construct()
    {
        $this->client = new TradernetApiClient(config('services.tradernet.api_key'), config('services.tradernet.api_secret'));
    }

    // Метод получения исторических котировок
    public function getHloc(string $symbol, string $dateFrom, string $dateTo, int $timeframe = 1440)
    {
        $params = [
            'cmd' => 'getHloc',
            'params' => [
                'id' => $symbol,
                'count' => -1,
                'timeframe' => $timeframe,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'intervalMode' => 'ClosedRay'
            ]
        ];

        return $this->client->sendRequest('getHloc', $params, 'array');
    }

    public function getPortfolioReport()
    {
        $response = $this->client->sendRequest('getPositionJson', [], 'array');

        if (!isset($response['result']['ps']['pos'])) {
            return "Нет данных по портфелю";
        }

        $positions = $response['result']['ps']['pos'];
        $report = "Портфель на " . now()->format('d.m.Y H:i') . "\n\n";
        $totalProfit = 0;

        foreach ($positions as $pos) {
            $symbol = $pos['i'];
            $name = $pos['name'];
            $qty = $pos['q'];
            $priceBuy = $pos['price_a'];
            $currPrice = $pos['close_price'];
            $curr = $pos['curr'];

            $profit = ($currPrice - $priceBuy) * $qty;
            $totalProfit += $profit;

            $report .= "$name ($symbol)\n";
            $report .= "Кол-во: $qty, Цена покупки: $priceBuy, Тек. цена: $currPrice\n";
            $report .= "Прибыль/убыток: " . number_format($profit, 2) . " $curr\n\n";
        }

        $report .= "Общая прибыль/убыток: " . number_format($totalProfit, 2) . " USD";

        return $report;
    }
}
