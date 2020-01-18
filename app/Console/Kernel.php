<?php

namespace App\Console;

use App\Console\Commands\Country;
use App\Console\Commands\ReceiptCopy;
use App\Console\Commands\Tracking;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\ReceiptPull::class,
        Country::class,
        ReceiptCopy::class,
        Tracking::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('receipt:pull')->hourly();
    }
}
