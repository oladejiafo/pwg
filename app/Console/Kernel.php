<?php

namespace App\Console;

use App\Models\notifications;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Carbon\Carbon; 

class Kernel extends ConsoleKernel
{

     /**
    * The Artisan commands provided by your application.
    *
    * @var array
    */
    protected $commands = [
        Commands\ClearNotify::class,
        Commands\ReminderEmail::class,
        Commands\QuickbookCron::class

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->call(function () {
        //     notifications::where('updated_at', '<', Carbon::now()->subDays(1))->delete();
        // })->everyMinute();

        $schedule->command('week:delete')
                ->weekly();

        $schedule->command('reminder:email')
                ->daily();
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
