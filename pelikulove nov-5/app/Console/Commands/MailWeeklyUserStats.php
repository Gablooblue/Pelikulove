<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\User;
use App\Models\LearnerCourse;

use Notifications;
use App\Notifications\SendWeeklyUserStats;
use Illuminate\Support\Facades\Notification;


use Illuminate\Console\Command;


class MailWeeklyUserStats extends Command
{
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weeklyuserstats:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a weekly stats of registered and enrolled users';

    /**
     * Create a new command instance.
     *
     * DeleteExpiredActivations constructor.
     *
     * @param ActivationRepository $activationRepository
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
    	$users = null;
    	$enrolled = null;
    	
    
        $users = User::whereRaw('Date(created_at) < CURDATE()')
                    ->get();
                  
        $enrolled = LearnerCourse::whereRaw('Date(created_at) < CURDATE()')
        		  	->get();
        		  
        $orders = Order::whereRaw('Date(updated_at) < CURDATE()')
        			->where('amount', '>', 0)
        			->where('payment_status', 'S')
        			->where('payment_id', '!=', 6)
        		    ->get();
        			  
        $admins = [1, 7, 10, 16, 87, 413];
        foreach ($admins as $a) :
        	$admin = User::find($a);		  	          
      		if (count($admin) > 0) Notification::send($admin, new SendWeeklyUserStats($users, $enrolled, $orders));
      		
		endforeach;
        echo "Sent weekly stats";  
      
    }
}
