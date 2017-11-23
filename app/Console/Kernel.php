<?php

namespace App\Console;

//use DB;
use Carbon\Carbon;
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
        //
        //\App\Console\Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        
        $schedule->call(function () {
            $rezervace = \App\Rezervace::get();
            foreach ($rezervace as $rez) {
                $time1 = new Carbon($rez->created_at);
                $timenow = Carbon::now();
                if($time1->diff($timenow)->days>1){
                    \App\Rezervace::destroy($rez->id_rezervace);
                }
            }

        })->everyMinute();

    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
