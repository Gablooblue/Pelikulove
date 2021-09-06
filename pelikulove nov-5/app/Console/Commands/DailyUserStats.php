<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Order;
use App\Models\User;
use App\Models\LearnerCourse;

use Notifications;
use App\Notifications\SendDailyUserStats;
use Illuminate\Support\Facades\Notification;


class DailyUserStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dailyuserstats:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description =  'Send a daily stats of registered and enrolled users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
	users = null;
        $enrolled = null;

        $users = User::whereRaw('DATE(created_at) = DATE_ADD(CURDATE(), INTERVAL -1 DAY)')
                  ->get();

        $enrolled = LearnerCourse::whereRaw('DATE(created_at) = DATE_ADD(CURDATE(), INTERVAL -1 DAY)')
                          ->get();

        $orders = Order::whereRaw('Date(updated_at) = DATE_ADD(CURDATE(), INTERVAL -1 DAY)')
                                ->where('amount', '>', 0)
                                ->where('payment_status', 'S')
                                ->where('payment_id', '!=', 6)
                            ->get();

	
        $admins = [1, 7, 10, 16, 87];
        foreach ($admins as $a) :
                $admin = User::find($a);
                if (count($admin) > 0) Notification::send($admin, new SendDailyUserStats($users, $enrolled, $orders));

        endforeach;
        echo "Sent daily stats";
	Log::info('Sent Daily stats of registered and enrolled users.');


    }
}

