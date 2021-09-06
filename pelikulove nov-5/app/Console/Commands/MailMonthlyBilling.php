<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\User;
use App\Models\Invoice;
use App\Models\LearnerCourse;

use Notifications;
use App\Notifications\SendMonthlyBilling;
use Illuminate\Support\Facades\Notification;

use Carbon\Carbon;

use Illuminate\Console\Command;


class MailMonthlyBilling extends Command
{
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monthlybilling:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send monthly billing';

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
        $log = Carbon::now()->toDateTimeString() . " - ";

    	$users = null;
    	$enrolled = null;
    	$sales = $net_servicefee = $net_amount = 0.00;
    
    	$start = \Carbon\Carbon::now()->subMonth()->startOfMonth();
    	$end =  \Carbon\Carbon::now()->subMonth()->endOfMonth();
    	$period = \Carbon\Carbon::parse(now()->subMonth())->format('M Y');
    	echo $period;
    	echo "\n\r";
    	echo $start;
    	echo "\n\r";
    	echo $end;
    
        $users = User::whereBetween('created_at', [$start, $end])
                    ->get();
                  
        $enrolled = LearnerCourse::whereBetween('created_at', [$start, $end])
        		  	->get();
        		  
        $orders = Order::whereBetween('created_at', [$start, $end])
        			->where('payment_status', 'S')
        		    ->get();
        		 
        $s1 = $orders->where('amount', '>', 1666)->where('billable', 1)->sum('amount') * .03;
    	$s2 = $orders->where('amount', '<=', 1666)->where('billable', 1)->count() * 50;
    	
    	$sales = $orders->sum('amount');
    	$net_servicefee = $s1+$s2;
    	$net_amount = $sales - $net_servicefee;
    	
    	echo "\n\r";
    	echo "count " . count($orders); 
    	echo "\n\r";
    	echo "sales " . $sales;
    	echo "\n\r";
    	echo $net_servicefee;   
        
        
        $data = array ('period' => $period, 'sales' => $sales, 'orders' => count($orders), 'net_amount' => $net_amount, 'net_servicefee' => $net_servicefee);
        $inv = Invoice::saveInvoice($data);
        
      	$invoice = Invoice::find($inv);
      	
      	$admins = [1, 10, 12, 87, 412];
        
        //$admins = [1];
        
        foreach ($admins as $a) :
        	$admin = User::find($a);		  	          
            if (isset($admin)) 
                Notification::send($admin, new SendMonthlyBilling($users, $enrolled, $invoice));
      		
        endforeach;

        $log .= Carbon::now()->toDateTimeString() . ": Sent Monthly Billing \n";  
        echo $log;      
    }
}
