<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\RMS\Config\Config;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        '\App\Console\Commands\BookingReservation',
        '\App\Console\Commands\BackupDB',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $config = Config::first();

        if($config->backup_frequency == 1){
            $schedule->command('db:backup')->everyMinute(); // every hour
        }

        if($config->backup_frequency == 2){
            $schedule->command('db:backup')->cron('0 */2 * * *'); //every two hour
        }

        if($config->backup_frequency == 5){
            $schedule->command('db:backup')->cron('0 */5 * * *'); // every five hour
        }

        if($config->backup_frequency == 12){
            $schedule->command('db:backup')->cron('0 */12 * * *'); // every twelve hour
        }

        // $schedule->command('db:backup')
        //       ->everyMinute();
    }
}
