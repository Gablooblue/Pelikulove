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
        // Commands\DeleteExpiredActivations::class,
        // Commands\MailDailyUserStats::class,
        // Commands\MailWeeklyUserStats::class,
        Commands\GenerateSitemap::class,
        Commands\GenerateAnalytics::class,
        // Commands\CallCommandSet1::class,
        // Commands\CallCommandSet2::class,
        // Commands\EnroleeExtender::class,
        Commands\MailDailyStats::class,
        Commands\MailWeeklyStats::class,
        Commands\MailMonthlyBilling::class,
        Commands\EnroleeExpiryChecker::class,
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
    // Fast Commands Start
        // SITEMAP
        $schedule->command('sitemap:generate')
            ->timezone('Asia/Manila')
            ->daily()
            ->appendOutputTo(storage_path('logs/cron.log'));

        // OLD EMAIL STATS
        // $schedule->command('dailyuserstats:mail')
        //     ->daily()
        //     ->timezone('Asia/Manila')
        //     ->appendOutputTo(storage_path('logs/cron.log'));

        // $schedule->command('weeklyuserstats:mail')
        //     ->timezone('Asia/Manila')
        //     ->weekly()
        //     ->saturdays()
        //     ->appendOutputTo(storage_path('logs/cron.log'));  
            
        // NEW EMAIL STATS
        $schedule->command('dailystats:mail')
            ->daily()
            ->at('08:00')
            ->timezone('Asia/Manila')
            ->appendOutputTo(storage_path('logs/cron.log'));

        $schedule->command('weeklystats:mail')
            ->timezone('Asia/Manila')
            ->weekly()
            ->saturdays()
            ->at('08:00')
            ->appendOutputTo(storage_path('logs/cron.log'));  

        $schedule->command('monthlybilling:mail')
            ->timezone('Asia/Manila')
            ->monthly()
            ->at('08:00')
            ->appendOutputTo(storage_path('logs/cron.log'));             
    // Fast Commands End

    // Slow Commands Start    
        // Analytics Summary Generation
        $schedule->command('analytics:generate')
            ->timezone('Asia/Manila')
            ->dailyAt('03:00')
            ->appendOutputTo(storage_path('logs/cron.log'));    

        // Enrolee Expiry Checker
        $schedule->command('enrolee:expire')
            ->timezone('Asia/Manila')
            ->dailyAt('03:00')
            ->appendOutputTo(storage_path('logs/cron.log'));    
    // Slow Commands End
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
