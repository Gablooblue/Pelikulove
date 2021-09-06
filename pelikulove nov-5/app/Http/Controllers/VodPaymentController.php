<?php 

namespace App\Http\Controllers;

use Notifications;
use App\Notifications\SendPaymentInstructionEmail;
use App\Notifications\SendVodPaymentInstructionEmail;

use Auth;
use View;
use Validator;
use App\Traits\CaptureIpTrait;
use App\Models\User;
use App\Models\Service;
use App\Models\Order;
use App\Models\Vod;
use App\Models\VodCategory;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Models\VodPurchase;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Notification;

class VodPaymentController extends Controller
{

	public function __construct()
    {
        //$this->middleware('auth');
    }
	
    public function form ($vod_id, $order_id = null)
    {
		$vod = Vod::findorfail($vod_id);

        // $owned = VodPurchase::ifOwned($vod->id, Auth::user()->id);
        
        // if ($owned && $vod->paid == 1) :
        //     return redirect()->route('vod.show', ['vod_id' => $vod->id]);	
        // endif;
		
		if (!isset($vod)) :			
			return back()->with('danger', 'Vod does not exist.');		
		endif;

		// Check if vod is paid 
		if ($vod->paid == 1) {
			// If Paid 
			$order = null;
			$payments = PaymentMethod::all();
			$services = Service::where('vod_id', '=', $vod->id)
						->where('available', '=', 1)
						->orderBy('sorder', 'asc')
						->get();
			
			if ($order_id) $order = Order::find(decrypt($order_id));  	
		
			$owned = VodPurchase::ifOwned($vod->id, Auth::User()->id);

			if ($owned) :
				return redirect()->route('vod.show', $vod->id);
			endif;
				
			if (Order::ifVodPending($vod->id, Auth::user()->id)) :
				\Session::flash('message', 'Already purchased but with pending payment. Contact pelikuloveofficial@gmail.com for support.'); 
				\Session::flash('status', 'info'); 
				return redirect()->route('vod.index');
			endif;

			return view('payments/vod-form', compact('services', 'payments', 'vod', 'order'));
		} else {	
			// If Free 				
			return redirect()->route('vod.show', compact('vod'));
		}
    }
  
    public function process (Request $request)
    {    	
        $validator = Validator::make($request->all(),
            [
				'service_id'				=>	'required',
				'payment' 					=> 	'required',
				'amount' 					=> 	'required',
				'vod_id' 					=> 	'required|exists:vods,id',
            ],
            [
				'service_id.required'		=>	"Service Package is required", 
				'payment.required'          => 	"Payment Method is required.",
                'amount.required'          	=> 	"Description of the service is required.",
				'vod_id.required' 			=> 	"The Video does not exist.",
				'vod_id.exists' 			=> 	"The Video does not exist.",
            ]
		);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
		}
		
		$order_id = $request->input('order_id');
   
		if (isset($order_id)) {
			$order = Order::find(decrypt($request->input('order_id')));
		}
		else {
   			$order = new Order;
   			$transaction_id = Auth::User()->id.time().mt_rand(10000000,99999999);
			
			//Remake Tid until it is unique
        	$exist = Order::where('transaction_id', $transaction_id)->first();
        	while (isset($exist)) {
        		$transaction_id = Auth::User()->id.time().mt_rand(10000000,99999999);
        		$exist = Order::where('transaction_id', $transaction_id)->first();
			}	
			
        	$order->transaction_id = $transaction_id;
        	$order->user_id = Auth::User()->id;  
   		}
   			
   		$payment = $request->input('payment');
    
		$order->service_id = $request->input('service_id');
		$service = Service::find($request->input('service_id'));
		
		$vod = Vod::find($service->vod_id);
		
		if (($request->input('donation') * 0 == 0) && $request->input('donation') > 0) {
			$donation = $request->input('donation');
			$order->donation = $donation;
		} else {
			$donation = null;
			$order->donation = $donation;
		}

       	$order->payment_id = $request->input('payment');
		$order->billable = 1;
		
		$order->amount = $service->amount + $donation;
		   
        $owned = VodPurchase::ifOwned($vod->id, Auth::User()->id);
     	if ($owned) :
     		\Session::flash('message', 'Already purchased this video.'); 
     		\Session::flash('status', 'info'); 
     		return redirect()->route('vod.index');
     	endif;
     		
     	// if enrollment is pending 
		if (isset($order)) :			
     		if ($payment == 1): // DRAGONPAY     			
     			$order->save();
				 return redirect()->route('checkout.payment.dragonpay', ['transaction_id' => encrypt($transaction_id)]);			
     		elseif ($payment == 4): // PAYPAL     			
     			$order->save();     			
     			return redirect()->route('checkout.payment.paypal', ['order_id' => encrypt($order->id)]);     		
     		else:
     			$order->payment_status= 'P';     			
     			$order->save();
     			 Notification::send(Auth::User(), new SendVodPaymentInstructionEmail($order));
     			\Session::flash('message', 'Your purchase is pending. Please follow the email instructions sent.'); 
				\Session::flash('status', 'info'); 
				return redirect()->route('vod.index');
     		
     		endif;
     	else :
     		\Session::flash('error', 'Order not found.'); 
     		return redirect()->route('vod.index');
     	endif;  	
    }
}
