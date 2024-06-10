<?php


namespace App\Services\API;


use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BankService
{
    public function getExchangeRates()
    {
        try {
            $currentDate = Carbon::now();
            $formattedDate = $currentDate->toDateString();
            $responseDate = $currentDate->toDateTimeString();

            $response = Http::get('https://www.nbrb.by/API/ExRates/Rates/431', [
                'onDate' => $formattedDate,
                'Periodicity' => 0,
            ]);

            if ($response->successful()) {
                $data = json_decode($response->body(), true);
                $bgpbCourses = $this->getUsdExchangeRateBGPB();
                $alfaBankMessage = $this->getUsdExchangeRateAlfaBank();
                $bgpbBuy = $bgpbCourses['buy'] ?? 'нет данных';
                $bgpbSell = $bgpbCourses['sell'] ?? 'нет данных';

                $message = "Курс валют НБРБ по состоянию на {$responseDate}:
                	Валюта: {$data['Cur_Name']}
                	Курс: {$data['Cur_OfficialRate']}

                	Курс USD БГПБ по состоянию на {$responseDate}:
                	Покупка: {$bgpbBuy}
                	Продажа: {$bgpbSell}" . $alfaBankMessage;

                return $message;
            } elseif ($response->clientError()) {
                return 'ОБНОВЛЕНИЕ КУРСОВ ВАЛЮТ: /n Client error: ' . $response->body();
            } elseif ($response->serverError()) {
                return 'ОБНОВЛЕНИЕ КУРСОВ ВАЛЮТ: Server error ' . $response->body();
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return 'ОБНОВЛЕНИЕ КУРСОВ ВАЛЮТ: Connection timed out or other error';
        }
    }

    public function getUsdExchangeRateBGPB()
    {
        $html = file_get_contents('https://belgazprombank.by/about/kursi_valjut/');

        $dom = new \DOMDocument();
        @$dom->loadHTML($html);

        $xpath = new \DOMXPath($dom);

        $rows = $xpath->query("//div[@data-course-container='courses']//table//tr");

        $usdExchangeRate = [];

        foreach ($rows as $row) {
            $currencyName = $xpath->query(".//td/div[contains(@class, 'currency-name')]/div[@class='currency_desc']/span", $row);
            if ($currencyName->length > 0 && trim($currencyName->item(0)->nodeValue) === 'USD') {
                $buyRate = $xpath->query(".//td[2]/div", $row);
                $sellRate = $xpath->query(".//td[3]/div", $row);
                if ($buyRate->length > 0 && $sellRate->length > 0) {
                    $usdExchangeRate['buy'] = trim($buyRate->item(0)->nodeValue);
                    $usdExchangeRate['sell'] = trim($sellRate->item(0)->nodeValue);
                }
            }
        }

        return $usdExchangeRate;
    }

    public function getUsdExchangeRateAlfaBank()
    {
        $message = '';
        $url = 'https://developerhub.alfabank.by:8273/partner/1.0.0/public/nationalRates';
        $url = 'https://developerhub.alfabank.by:8273/partner/1.0.0/public/rates';
        $params = [
            'currencyCode' => '840,978',
        ];

        $response = Http::get($url, $params);
        if ($response->successful()) {
            $data = json_decode($response->body(), true);
            foreach ($data['rates'] as $value) {
                if ($value['sellIso'] == 'USD' && $value['buyIso'] == 'BYN') {
                    $message = "
            Курс валют Альфа Банк бизнес:
                    {$value['sellIso']}:
                	Покупка: {$value['buyRate']}
                	Продажа: {$value['sellRate']}
                	";
                }
            }

        }
        return $message;
    }
}
