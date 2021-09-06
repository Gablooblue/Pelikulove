<?php

namespace App\Http\Controllers;

use Notifications;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;


use Auth;


use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Service;
use App\Models\User;
use App\Models\Invoice;
use App\Models\LearnerCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class AccountingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     

    public function index()
    {
    
    	$invoices =  Invoice::orderBy('created_at')->get();
    	
        return view('accounting.index', ['invoices' => $invoices]); 
        
        
    }

    

    /**
     * Display the specified resource.
     *
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    public function monthly($year, $month)
	{
		
        $sales =  Order::where('payment_status', 'S')->whereMonth('created_at', $month)
     		->whereYear('created_at', $year)->orderBy('created_at')->get();
    	
    	$ta = 0; $tsf = 0;
    	foreach($sales as $value) :
    	
        	$a = $value->amount; $sf = 0;
            if ($value->amount > 1666 && $value->billable == 1)  $sf = $value->amount * .03;
            if ($value->amount <= 1666 && $value->billable == 1) $sf = 50;
            $ta = $ta + $a; $tsf = $tsf + $sf; 
         endforeach;
        $period = \Carbon\Carbon::parse($year . '-'. $month. '-01')->format('F Y');
     
       
                               	 
        return view('accounting.show', ['sales' => $sales, 'period' => $period, 'ta' => $ta, 'tsf' => $tsf]); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    
}
