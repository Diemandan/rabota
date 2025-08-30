<?php

namespace App\Console\Commands;

use App\Models\Finance\UserSettings;
use Illuminate\Console\Command;
use App\Services\Finance\TradernetService;
use App\Services\API\TelegramService;

class SendPortfolioReport extends Command
{
    /**
     * Название команды для консоли
     */
    protected $signature = 'portfolio:send-report';

    /**
     * Описание команды
     */
    protected $description = 'Отправка актуального отчёта по портфелю в Telegram';

    public function handle()
    {
        $userSettings = UserSettings::first();

        $telegram = new TelegramService($userSettings->telegram_api_key);
        $tradernet = new TradernetService();

        $report = $tradernet->getPortfolioReport();
        $telegram->sendMessage($report);

        $this->info('Отчёт отправлен в Telegram.');
    }
}
