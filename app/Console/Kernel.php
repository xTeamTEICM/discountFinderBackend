<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */


    /*
      gia na doulepsi  prepei na valoume tin entoli  php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1   ws cron ston server
      From  link https://laravel.com/docs/5.5/scheduling
      helpful link:https://stackoverflow.com/questions/32283517/how-to-run-artisan-command-schedulerun-on-hosting-server-laravel-5-1
      sthn synarthsh schedule vazoume oti theloume na trexei ston server sugkekrimenes wres
    */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            DB::table('oauth_access_tokens')->where('expires_at', '<', Carbon::now())->delete();
            DB::table('oauth_refresh_tokens')->where('expires_at', '<', Carbon::now())->delete();
        })->everyMinute();


    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
