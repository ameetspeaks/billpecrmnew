<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\Opening::class,
        \App\Console\Commands\Report::class,
        \App\Console\Commands\VenderDue::class,
        \App\Console\Commands\CustomerDue::class,
        \App\Console\Commands\LowStock::class,
        \App\Console\Commands\DeleteActivity::class,
    ];
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('app:opening')->dailyAt('08:00');
        $schedule->command('app:report')->dailyAt('22:00');
        $schedule->command('app:vender-due')->dailyAt('11:00');
        $schedule->command('app:customer-due')->dailyAt('12:00');
        $schedule->command('app:low-stock')->dailyAt('14:00');
        $schedule->command('app:delete-activity')->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
