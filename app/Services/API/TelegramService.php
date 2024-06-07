<?php

namespace App\Services\API;


use TelegramBot\Api\BotApi;

class TelegramService

{
    public function getUpdate()
    {
        $bot = new BotApi(env('TELEGRAM_BOT_TOKEN'));

            $updates = $bot->getUpdates();

            dd($updates);
    }

    public function sendMessage($text)
    {
        $bot = new BotApi(env('TELEGRAM_BOT_TOKEN'));
        $bot->sendMessage(env('TELEGRAM_CHAT_ID'), $text);
    }
}
