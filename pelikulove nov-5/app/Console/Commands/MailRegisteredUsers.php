<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\User;
use App\Models\LearnerCourse;

use Notifications;
use App\Notifications\SendRegisteredUsers;
use Illuminate\Support\Facades\Notification;

use Carbon\Carbon;

use Illuminate\Console\Command;


class MailRegisteredUsers extends Command
{
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'registeredusers:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email of registered and enrolled users';

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
    	
        $users = User::whereRaw('Date(created_at) = DATE_ADD(CURDATE(), INTERVAL -1 DAY)')
                  ->get();
                  
        $enrolled = LearnerCourse::whereRaw('Date(created_at) = DATE_ADD(CURDATE(), INTERVAL -1 DAY)')
        		  ->get();
        		  
        $orders = Order::whereRaw('Date(updated_at) = DATE_ADD(CURDATE(), INTERVAL -1 DAY)')
        			->where('amount', '>', 0)
        			->where('payment_status', 'S')
        			->where('payment_id', '!=', 6)
        		    ->get();
        			  
        		  	          
        $admin = User::find(1);
    	
        if (isset($admin)) 
            Notification::send($admin, new SendRegisteredUsers($users, $enrolled, $orders));

          
      
    }
}
