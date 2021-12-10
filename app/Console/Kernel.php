<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\ShiftCheck::class,
        Commands\PatrolCheck::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $this->info("Working");
        })->everyMinute();
        $schedule->command('shift:check')->dailyAt('06:15')->appendOutputTo('shift.log');
        $schedule->command('shift:check')->dailyAt('18:15')->appendOutputTo('shift.log');
        $schedule->command('patrol:check')->hourly()->appendOutputTo('shift.log');

    }

    public function scheduleTimezone()
    {
        return 'Africa/Nairobi';
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
