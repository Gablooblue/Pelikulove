<?php

namespace App\Console\Commands;

use Auth;

use Carbon\Carbon;

use App\Models\Order;
use App\Models\Service;
use App\Models\LearnerCourse;

use Illuminate\Console\Command;

class EnroleeExpiryChecker extends Command
{
    
    protected $signature = 'enrolee:expire';
    
    protected $description = 'Disable expired enrolees';
    
    public function __construct()
    {
        parent::__construct();       
    }
    
    public function handle()
    {   
        $log = Carbon::now()->toDateTimeString() . " - ";

        $learners = LearnerCourse::where('status', 1)
        ->get();

        $cnt = 0;

        foreach ($learners as $learner) {      	
            $order = Order::find($learner->order_id);
            $service = Service::find($order->service_id);
            $duration = $service->duration;
            if (Carbon::now()->gt($learner->created_at->addDays($duration))) {
                    $cnt++;
                // Check if User is included in 2019 Enrollment Extension
                // if (self::ifUserisExtendable2019($learner)) {	
                //     $transaction_id = Auth::User()->id.time().mt_rand(10000000,99999999);        
                //     $exist = Order::where('transaction_id', $transaction_id)->first();
                //     while (isset($exist)) {
                //         $transaction_id = Auth::User()->id.time().mt_rand(10000000,99999999);
                //         $exist = Order::where('transaction_id', $transaction_id)->first();
                //     }	

                //     $order = new Order;
                //     $order->user_id = Auth::User()->id;  	
                //     $order->service_id = 1;					
                //     $order->transaction_id = $transaction_id;
                //     $order->ref_no = '2019Extension-1Year';
                //     $order->amount = 0;
                //     $order->payment_status= 'S';
                //     $order->payment_id =  4;
                //     $order->billable = 1;
                //     $order->save();

                //     $learnercourse  = new LearnerCourse;
                //     $learnercourse->user_id = Auth::User()->id;
                //     $learnercourse->course_id = 1;
                //     $learnercourse->order_id = $order->id;
                    
                //     $learnercourse->save();
                    
                //     $learner->status = 0;
                //     $learner->save();

                //     return true;
                // } else {
                    $learner->status = 0;
                    $learner->save();
                // }
            }
        }
        
        $log .= Carbon::now()->toDateTimeString() . ": " . $cnt . " Enrollees Expired \n";
        echo $log;   
    }
}
