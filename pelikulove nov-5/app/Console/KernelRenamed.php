<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class KernelRenamed extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //Commands\DeleteExpiredActivations::class,
        Commands\MailDailyUserStats::class,
        Commands\MailWeeklyUserStats::class,
        Commands\MailMonthlyBilling::class,
        Commands\GenerateSitemap::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // SITEMAP
        $schedule->command('sitemap:generate')
                    ->timezone('Asia/Manila')
                    ->daily();

        // STATS
        $schedule->command('dailyuserstats:mail')
                    ->daily()
                    ->timezone('Asia/Manila')
                    ->appendOutputTo(storage_path('logs/cron.log'));

        $schedule->command('weeklyuserstats:mail')
        			->timezone('Asia/Manila')
                    ->weekly()
                    ->saturdays()
                    ->appendOutputTo(storage_path('logs/cron.log'));  

        $schedule->command('monthlybilling:mail')
        			->timezone('Asia/Manila')
                    ->monthly()
                    ->appendOutputTo(storage_path('logs/cron.log')); 
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
