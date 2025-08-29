<?php

namespace App\Services\API;


use App\Models\Finance\TelegramMessage;
use Illuminate\Support\Facades\Cache;
use Telegram\Bot\Api;

class TelegramService
{
    protected $botApi;
    public function __construct($token = null)
    {
        $this->botApi = new Api($token ?? config('services.telegram.token'));
    }
    public function getUpdate()
    {
        $lastUpdateId = Cache::get('telegram_last_update_id', 0);

        $updates = $this->botApi->getUpdates([
            'offset' => $lastUpdateId + 1,
            'timeout' => 1,
        ]);

        foreach ($updates as $update) {
            $chatId = $update->message->chat->id ?? null;
            $username = $update->message->chat->username ?? null;
            $text = $update->message->text ?? null;
            $updateId = $update->update_id;

            if ($chatId && $text) {
                TelegramMessage::create([
                    'chat_id' => $chatId,
                    'username' => $username,
                    'message' => $text,
                    'update_id' => $updateId,
                ]);

                Cache::put('telegram_last_update_id', $updateId);
            }
        }

        return $this->sendMessage('Ваше сообщение получено и будет обработано в ближайшее время!');
    }

    public function processUpdate(array $update)
    {
        $chatId = $update['message']['chat']['id'] ?? null;
        $username = $update['message']['chat']['username'] ?? null;
        $text = $update['message']['text'] ?? null;
        $updateId = $update['update_id'] ?? null;

        if ($chatId && $text && $updateId) {
            TelegramMessage::updateOrCreate(
                ['update_id' => $updateId],
                [
                    'chat_id' => $chatId,
                    'username' => $username,
                    'message' => $text,
                ]
            );
        }

        return $this->sendMessage('Ваше сообщение получено и будет обработано в ближайшее время!');
    }

    public function sendMessage($text)
    {
        $this->botApi->sendMessage([
            'chat_id' => env('TELEGRAM_CHAT_ID'),
            'text' => $text
        ]);
    }
}
