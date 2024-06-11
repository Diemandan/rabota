<?php

namespace App\Http\Controllers;

use App\Services\API\BankService;
use App\Services\API\TelegramService;
use GuzzleHttp\Client;
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

    public function getCoursesBGPB(BankService $bankService, TelegramService $service)
    {
        $response = $bankService->getUsdExchangeRateBGPB();
        $service->sendMessage(json_encode($response));
        dd($response);
    }

    public function sendTestEmail()
    {
        $client = new Client();

        $response = $client->request('POST', 'https://api.eu.mailgun.net/v3/zp-tir.of.by/messages', [
            'auth' => ['api', env('MAILGUN_SECRET')],
            'form_params' => [
                'from' => 'Excited User <mailgun@яз-ешкющаюин>',
                'to' => 'diemandan63@gmail.com',
                'subject' => 'Hello',
                'text' => 'Testing some Mailgun awesomeness!'
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            return "Email sent successfully!";
        } else {
            return "Failed to send email.";
        }
    }
}
