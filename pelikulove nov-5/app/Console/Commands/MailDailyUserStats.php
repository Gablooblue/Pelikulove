<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\User;
use App\Models\LearnerCourse;

use Notifications;
use App\Notifications\SendDailyUserStats;
use Illuminate\Support\Facades\Notification;


use Illuminate\Console\Command;


class MailDailyUserStats extends Command
{
    
    protected $signature = 'dailyuserstats:mail';
    
    protected $description = 'Send a daily stats of registered and enrolled users';
    
    public function __construct()
    {
        parent::__construct();
       
    }
    
    public function handle()
    {
    	$users = null;
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
        			  
        $admins = [1, 10, 12, 16, 87, 412];
        foreach ($admins as $a) :
        	$admin = User::find($a);
    		if (count($admin) > 0) Notification::send($admin, new SendDailyUserStats($users, $enrolled, $orders));

        endforeach;	  	          
        echo "Sent daily stats";  
          
      
    }
}
