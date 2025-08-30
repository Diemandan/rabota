<?php

namespace App\Services\Finance;

use Illuminate\Support\Facades\Http;
use OpenAI;

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
                'id' => $symbol,
                'count' => -1,
                'timeframe' => $timeframe,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'intervalMode' => 'ClosedRay'
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
        $aiReport = '';
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

            $history = $this->getTradernetHistory($symbol, 30);
            $historyString = implode(', ', array_map(function($item) {
                return "{$item['date']} {$item['close']}({$item['volume']})";
            }, $history));

            $report .= "$name ($symbol)\n";
            $report .= "Кол-во: $qty, Цена покупки: $priceBuy, Тек. цена: $currPrice\n";
            $report .= "Прибыль/убыток: " . number_format($profit, 2) . " $curr\n\n";
            $aiReport .= "$name ($symbol) $qty x $priceBuy, (" . number_format($profit,2) . " {$pos['curr']}) | History: {$historyString}\n";
        }

        $report .= "Общая прибыль/убыток: " . number_format($totalProfit, 2) . " USD";

        return ['report' => $report, 'ai_report' => $aiReport];
    }

    public function AIAnalize($report)
    {
        $apiKey = config('services.openai.api_key');
        $client = OpenAI::client($apiKey);

        $response = $client->chat()->create([
            'model' => 'gpt-5-mini',
//            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => "Сделай глубокий прогноз по портфелю, Учти волатильность и объём торгов при рекомендации и дай короткую рекомендацию по каждой позиции в формате 'позиция - рекомендация': " . $report
                ]
            ]
        ]);

        $message = $response['choices'][0]['message']['content'] ?? 'Возникла проблема в обработке либо в коде';

        $aiReport = "\n\nРекомендация по бумагам от OPENAI:\n\n $message\n\n";

        return $aiReport;
    }

    private function getTradernetHistory(string $symbol, int $days, int $timeframe = 1440)
    {
        $dateFrom = now()->subDays($days)->format('Y-m-d h:m');
        $dateTo = now()->format('Y-m-d h:m');

        $hlocData = $this->getHloc($symbol, $dateFrom, $dateTo, $timeframe);

        // Преобразуем данные в компактный массив ['date' => 'YYYY-MM-DD', 'close' => цена]
        $history = [];
        if (isset($hlocData['hloc'][$symbol]) && isset($hlocData['xSeries'][$symbol])) {
            $hlocs = $hlocData['hloc'][$symbol];
            $timestamps = $hlocData['xSeries'][$symbol];
            $volumes = $hlocData['vl'][$symbol] ?? [];

            foreach ($hlocs as $index => $ohlc) {
                $date = date('Y-m-d', $timestamps[$index]);
                $close = $ohlc[3]; // close price
                $volume = $volumes[$index] ?? 0;

                $history[] = [
                    'date' => $date,
                    'close' => $close,
                    'volume' => $volume,
                ];
            }
        }

        return $history;
    }
}
