<?php


namespace App\Services\API;


use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class BankService
{
    public function getExchangeRates()
    {
        try {
            $currentDate = Carbon::now();
            $formattedDate = $currentDate->toDateString();

            $response = Http::get('https://www.nbrb.by/API/ExRates/Rates/431', [
                'onDate' => $formattedDate,
                'Periodicity' => 0,
            ]);

            if ($response->successful()) {
                $data = json_decode($response->body(), true);
                $message = "Курс валют по состоянию на {$data['Date']}:
                	Валюта: {$data['Cur_Name']}
                	Курс: {$data['Cur_OfficialRate']}";
                return $message;
            } elseif ($response->clientError()) {
                return 'ОБНОВЛЕНИЕ КУРСОВ ВАЛЮТ: /n Client error: ' . $response->body();
            } elseif ($response->serverError()) {
                return 'ОБНОВЛЕНИЕ КУРСОВ ВАЛЮТ: Server error ' . $response->body() ;
            }
        } catch (\Exception $e) {
            return 'ОБНОВЛЕНИЕ КУРСОВ ВАЛЮТ: Connection timed out or other error';
        }
    }
}