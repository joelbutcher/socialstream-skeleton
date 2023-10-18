<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('app:backup-db')
            ->hourlyAt(0);

        $schedule->command('migrate:fresh', ['--step', '--seed'])
            ->hourlyAt(1);

        $schedule->command('app:restore-db')
            ->hourlyAt(2)
            ->thenPing(config('services.envoyer.heartbeats.refresh-database'));
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
    }
}
