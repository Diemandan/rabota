<?php

namespace App\Services\Finance;

use Illuminate\Support\Facades\Http;

class TradernetService
{
    protected string $baseUrl = 'https://tradernet.com/api/';

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

        $response = Http::get($this->baseUrl, [
            'q' => json_encode($params)
        ]);

        return $response->json();
    }
}
