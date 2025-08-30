<?php

namespace App\Console;

use App\Jobs\GetCoursesJob;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(new GetCoursesJob())->twiceDaily(8, 15)->when(function () {
            $currentDay = Carbon::now()->day;
            return $currentDay >= 8 && $currentDay <= 15;
        });
        $schedule->command('db:backup')->monthly();
        $schedule->command('portfolio:send-report')->dailyAt('8:20');
        $schedule->command('portfolio:send-report')->dailyAt('15:20');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
