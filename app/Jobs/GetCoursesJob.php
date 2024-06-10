<?php

namespace App\Jobs;

use App\Services\API\BankService;
use App\Services\API\TelegramService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GetCoursesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $bankService = new BankService();
        $courses = $bankService->getExchangeRates();
        $telegramService = new TelegramService();
        $telegramService->sendMessage($courses);

        Log::info('Работа запущена и выполнена. Результат запроса:' . $courses);
    }

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
