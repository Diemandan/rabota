<?php

namespace App\Http\Controllers;

use App\Services\API\BankService;
use App\Services\API\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IntegrationController
{
    public function amoRedirect(Request $request)
    {
        Log::info(json_encode($request->all()));
    }

    public function getList(TelegramService $service)
    {
        $service->getupdate();
    }

    public function sendMessage(TelegramService $service)
    {
        $service->sendMessage('test');
    }

    public function getCourses(BankService $bankService, TelegramService $service)
    {
        $response = $bankService->getExchangeRates();
        $service->sendMessage($response);
        dd($response);
    }
}
