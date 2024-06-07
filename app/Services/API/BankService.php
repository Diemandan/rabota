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

            $response = Http::timeout(120)->get('https://www.nbrb.by/API/ExRates/Rates', [
                'onDate' => $formattedDate
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return response()->json($data);
            } elseif ($response->clientError()) {
                return 'ОБНОВЛЕНИЕ КУРСОВ ВАЛЮТ: <br> Client error';
            } elseif ($response->serverError()) {
                return 'ОБНОВЛЕНИЕ КУРСОВ ВАЛЮТ: <br> Server error';
            }
        } catch (\Exception $e) {
            return 'ОБНОВЛЕНИЕ КУРСОВ ВАЛЮТ: Connection timed out or other error';
        }
    }
}
