<?php

namespace App\Services\Finance;

use GuzzleHttp\Client;
use OpenAI;

class AIAnalyzer
{
    private string $apiKey;
    private string $proxy;
    private Client $guzzle;

    public function __construct()
    {
        $this->apiKey = config('services.openai.api_key');
        $this->proxy = config('services.bright_data.proxy_url');

        $this->guzzle = new Client([
            'base_uri' => 'https://api.openai.com/v1/',
            'verify' => false,
            'proxy' => $this->proxy,
            'timeout' => 120,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ]
        ]);
    }

    /**
     * Основной метод анализа портфеля
     *
     * @param string $report - строка с данными по портфелю
     * @param bool $webSearch - использовать интернет для расширенного анализа
     * @return string - готовый текст с рекомендациями
     */
    public function analyze(string $report, bool $webSearch = false): string
    {
        $message = $webSearch
            ? $this->analyzeWithWebSearch($report)
            : $this->analyzeLocalReport($report);

        return "\n\nРекомендация по бумагам от OPENAI:\n\n$message\n\n";
    }

    /**
     * Локальный анализ (без интернета)
     */
    private function analyzeLocalReport(string $report): string
    {
//        $client = OpenAI::client($this->apiKey);

//        $response = $client->chat()->create([
//            'model' => 'gpt-5-mini',
//            'messages' => [
//                [
//                    'role' => 'user',
//                    'content' => $this->buildPrompt($report),
//                ]
//            ]
//        ]);

        $response = $this->guzzle->post('chat/completions', [
            'json' => [
                'model' => 'gpt-5-mini',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $this->buildPrompt($report),
                    ]
                ]
            ]
        ]);
        $body = json_decode($response->getBody()->getContents(), true);

        return $body['choices'][0]['message']['content'] ?? 'Ошибка анализа';
    }

    /**
     * Анализ с интернетом через Responses API
     */
    private function analyzeWithWebSearch(string $report): string
    {
        $response = $this->guzzle->post('responses', [
            'json' => [
                'model' => 'gpt-4o-mini', // для web_search
                'tools' => [
                    ['type' => 'web_search_preview'],
                ],
                'input' => [
                    [
                        'role' => 'user',
                        'content' => $this->buildPrompt($report, true)
                    ]
                ]
            ]
        ]);

        $body = json_decode($response->getBody()->getContents(), true);

        return $this->extractOutputText($body);
    }

    /**
     * Формируем prompt для модели
     */
    private function buildPrompt(string $report, bool $withWeb = false): string
    {
        $prompt = "Сделай глубокий прогноз по портфелю, учти волатильность и объём торгов при рекомендации
        и дай короткую рекомендацию по каждой позиции в формате 'позиция - рекомендация':\n$report";

        if ($withWeb) {
            $prompt .= "\nДополни анализ актуальными новостями и факторами, влияющими на акции,
            используя интернет (web search). Укажи, есть ли риски или положительные события.";
        }

        return $prompt;
    }

    /**
     * Универсальный метод для вытаскивания текста из Responses API
     */
    private function extractOutputText(array $body): string
    {
        $text = '';
        foreach ($body['output'] ?? [] as $item) {
            if ($item['type'] === 'message' && isset($item['content'])) {
                foreach ($item['content'] as $content) {
                    if ($content['type'] === 'output_text') {
                        $text .= $content['text'] . "\n";
                    }
                }
            }
        }
        return trim($text);
    }

    public function chatWithWebSearch(string $message): string
    {
        $response = $this->guzzle->post('responses', [
            'json' => [
                'model' => 'gpt-4o-mini', // для web_search
                'tools' => [
                    ['type' => 'web_search_preview'],
                ],
                'input' => [
                    [
                        'role' => 'user',
                        'content' => $message
                    ]
                ]
            ]
        ]);

        $body = json_decode($response->getBody()->getContents(), true);

        return $this->extractOutputText($body);
    }
}
