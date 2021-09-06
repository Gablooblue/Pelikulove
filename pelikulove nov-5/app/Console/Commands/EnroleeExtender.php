<?php

namespace App\Console\Commands;

use Auth;

use Carbon\Carbon;

use App\Models\Order;
use App\Models\LearnerCourse;

use Illuminate\Console\Command;

class EnroleeExtender extends Command
{
    
    protected $signature = 'enroleeextender:yearone';
    
    protected $description = 'Extends selected 2019 Enrolees to 1 more year';
    
    public function __construct()
    {
        parent::__construct();       
    }
    
    public function handle()
    {   
		$orderIdList = collect([349,350,351,352,353,358,359,357,354,356,355,363,367,360,361,362,366,365,364,368,344,
		345,346,347,348,370,369,371,423,424,425,499,436,449,450,451,452,453,454,500,472,473,477,479,480,483,
		485,492,496,497,511,515,498,504,503,502,501,505,506,507,508,532,536,519,520,525,517,528,530,512,514,
		521,522,523,533,539,540,560,561,562,564,513,524,534,537,565,566,567,568,569,575,578,580,581,585,584,
		585,587,588,590,591,593,594,600,601,605,606,607,610,611,612,614,617,621,624,625,626,627,629,630,638,
		639,640,641,646,647,648,650,653,654,657,658,660,661,665,666,669,671,673,675,676,677,678,682,683,684,
		688,690,693,694,695,696,697,698,700,702,706,710,712,713,714,715,718,719,722,723,455,724,458,459,460,
        461,462,463]);
		// $orderIdList = collect([833]);
        
        foreach ($orderIdList as $orderID) {            
            $learner = LearnerCourse::where('order_id', '=', $orderID)
            ->orderBy('created_at', 'desc')
            ->first();

            if (isset($learner)) {
                $created_at = Carbon::parse($learner->created_at);

                if ($learner->status == 0 && $created_at->addYear()->format('Y-m-d') == Carbon::now()->format('Y-m-d')) {
                    $transaction_id = $learner->user_id.time().mt_rand(10000000,99999999);
                    $exist = Order::where('transaction_id', $transaction_id)->first();
                    while (isset($exist)) {
                        $transaction_id = $learner->user_id.time().mt_rand(10000000,99999999);
                        $exist = Order::where('transaction_id', $transaction_id)->first();
                    }	
            
                    $order = new Order;
                    $order->user_id = $learner->user_id;
                    $order->service_id = 1;
                    $order->transaction_id = $transaction_id;
                    $order->ref_no = '2019Extension-1Year';
                    $order->amount = 0;
                    $order->payment_status= 'S';
                    $order->payment_id =  4;
                    $order->billable = 1;
                    $order->save();
            
                    $learnercourse  = new LearnerCourse;
                    $learnercourse->user_id = $learner->user_id;
                    $learnercourse->course_id = 1;
                    $learnercourse->order_id = $order->id;
                   
                    $learnercourse->save();
                }
            } 
        }  
    }
}
