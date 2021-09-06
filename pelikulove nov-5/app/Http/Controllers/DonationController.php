<?php

namespace App\Http\Controllers;

use Validator;

use Auth;

use App\Models\User;
use App\Models\Service;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Models\Donation;
use App\Models\DonationCause;

use Illuminate\Http\Request;


class DonationController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $donations = Donation::join('orders', 'donations.order_id', '=', 'orders.id')
        ->join('users', 'donations.user_id', '=', 'users.id')
        ->join('payment_methods', 'orders.payment_id', '=', 'payment_methods.id')
        ->select('donations.*', 
        'orders.amount', 'orders.payment_id', 
        'users.name as username', 'users.first_name', 'users.last_name', 'users.email', 
        'payment_methods.name as p_name')
        ->where('donations.paid', '1')
        ->orderBy('donations.created_at', 'desc')->get();        

        // dd($donations);
         		
        return view('donations.index', compact('donations')); 
    }

    public function show($id)
    {
        $donation = Donation::join('orders', 'donations.order_id', '=', 'orders.id')
        ->join('users', 'donations.user_id', '=', 'users.id')
        ->join('payment_methods', 'orders.payment_id', '=', 'payment_methods.id')
        ->select('donations.*', 
        'donations_causes.title as cause_title', 
        'orders.amount', 'orders.payment_id', 
        'users.name as username', 'users.first_name', 'users.last_name', 'users.email', 
        'payment_methods.name as p_name')
        ->where('donations.id', $id)
        ->orderBy('donations.created_at', 'desc')->first();

        // dd($donation);
         		
        return view('donations.show', compact('donation')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        		 
    	$payments = PaymentMethod::all();
    	$donationCauses = DonationCause::all();
        return view('payments.donation-form', compact('payments', 'donationCauses')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
    	$request->validate([
            'payment' => 'required',
            'amount' => 'required'
        ]);
   
		if ($request->input('order_id') != null) 
		   	$order = Order::find(decrypt($request->input('order_id')));
   		else  {
   			$order = new Order;
   			$transaction_id = Auth::User()->id.time().mt_rand(10000000,99999999);
        
        	$exist = Order::where('transaction_id', $transaction_id)->first();
        	while (isset($exist)) {
        		$transaction_id = Auth::User()->id.time().mt_rand(10000000,99999999);
        		$exist = Order::where('transaction_id', $transaction_id)->first();
        	}	
        	$order->transaction_id = $transaction_id;
        	$order->user_id = Auth::User()->id;  
   		}
   			
   		$payment = $request->input('payment');
		$service = Service::findOrFail(15);	  

		if ($service->available != 1) {
			return redirect()->route('course.enroll', $service->course_id)->with([
                'message' => "The package you have chosen: <strong>'" . $service->name . "'</strong> is not available!", 'status' => 'danger'
            ]);
        }
    
    	$order->service_id = $service->id;
       	$order->payment_id =  $request->input('payment');
       	$order->amount =  $request->input('amount');
		$order->billable = 0;
     		
     	// if enrollment is pending 
     	if (isset($order)) :     			
            $order->save();

            $donation = new Donation;
            $donation->user_id = Auth::User()->id;
            $donation->order_id = $order->id;

            if ($request->input('cause_id') == 0) {
                $donation->cause_id = null;
            } else {
                $donation->cause_id = $request->input('cause_id');
            }

            $donation->paid = 0;
            $donation->notes = $request->input('note');
            $donation->save();

            
     		if ($payment == 1):
                 return redirect()->route('checkout.payment.dragonpay', ['transaction_id' => encrypt($transaction_id)]);
                 
     		elseif ($payment == 4):     			
     			return redirect()->route('checkout.payment.paypal', ['order_id' => encrypt($order->id)]);
     		
     		else:
                $order->payment_status= 'P';
                
                Notification::send(Auth::User(), new SendDonationPaymentInstructionEmail($order));
                    
                \Session::flash('message', 'Your enrollment is pending. Please follow the email instructions sent.'); 
                \Session::flash('status', 'info'); 
     			return redirect()->route('course.show', $service->course_id);
     		
     		endif;
     	else :
     			\Session::flash('error', 'Order not found.'); 
     		return redirect()->route('donations.create');
     	endif;  
    
    }
}
