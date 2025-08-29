<?php

namespace App\Services\Finance;

use App\Models\Finance\SignalsHistory;

class SignalService
{
    // Расчет RSI
    public function calculateRSI(array $closes, int $period = 14): float
    {
        $gains = [];
        $losses = [];

        for ($i = 1; $i < count($closes); $i++) {
            $diff = $closes[$i] - $closes[$i - 1];
            if ($diff > 0) {
                $gains[] = $diff;
                $losses[] = 0;
            } else {
                $gains[] = 0;
                $losses[] = abs($diff);
            }
        }

        $avgGain = array_sum(array_slice($gains, -$period)) / $period;
        $avgLoss = array_sum(array_slice($losses, -$period)) / $period;

        if ($avgLoss == 0) {
            return 100;
        }

        $rs = $avgGain / $avgLoss;
        return 100 - (100 / (1 + $rs));
    }

    // Получение сигнала buy/sell/hold
    public function getSignal(float $rsi): string
    {
        if ($rsi < 30) {
            return 'buy';
        } elseif ($rsi > 70) {
            return 'sell';
        }
        return 'hold';
    }

    // Сохранение сигнала в историю
    public function saveSignal(string $symbol, string $signalType, float $rsi, float $price)
    {
        return SignalsHistory::create([
            'symbol' => $symbol,
            'signal_type' => $signalType,
            'rsi' => $rsi,
            'price' => $price,
            'sent_at' => now()
        ]);
    }
}
