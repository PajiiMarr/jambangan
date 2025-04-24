<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\UpdateEventStatuses;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Register your custom commands here
        UpdateEventStatuses::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Schedule your tasks here
        $schedule->command('events:update-event-statuses')->everyMinute()->evenInMaintenanceMode()->runInBackground()->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        // This loads all commands in the app/Console/Commands directory
        $this->load(__DIR__.'/Commands');

        // Make sure to include routes/console.php for other Artisan commands
        require base_path('routes/console.php');
    }
}
