<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // Run the expiry update command daily
        $schedule->command('users:update-expired')->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        // Load all commands from app/Console/Commands
        $this->load(__DIR__.'/Commands');

        // You can also define console routes here
        require base_path('routes/console.php');
    }
}
