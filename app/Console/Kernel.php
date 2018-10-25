<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\App;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\CheckIp::class,
        Commands\GetSourceIp::class,
        Commands\DelSourceIp::class,
        Commands\ParseCatchInfo::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->command('command:check_ip')
                  ->everyMinute()->withoutOverlapping()->runInBackground();
         $schedule->command('command:get_source_ip')
                  ->hourly()->runInBackground();
         $schedule->command('command:parse_catch_info')
                  ->hourly()->runInBackground();
         $schedule->command('command:del_source_ip')
                  ->daily()->runInBackground();
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
