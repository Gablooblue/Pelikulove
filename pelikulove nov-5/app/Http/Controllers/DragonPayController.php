<?php 

namespace App\Http\Controllers;

use Notifications;
use App\Notifications\SendPaymentEmail;
use App\Notifications\SendPaymentInstructionEmail;
use App\Notifications\SendPaymentNotifyEmail;
use App\Notifications\SendVodPaymentEmail;
use App\Notifications\SendVodPaymentInstructionEmail;
use App\Notifications\SendVodPaymentNotifyEmail;
use App\Notifications\SendDonationPaymentEmail;
use App\Notifications\SendDonationPaymentInstructionEmail;
use App\Notifications\SendDonationPaymentNotifyEmail;

use Auth;
use Validator;
use View;

use App\Traits\ActivationTrait;
use App\Traits\CaptchaTrait;
use App\Traits\CaptureIpTrait;
use App\Models\User;
use App\Models\Course;
use App\Models\Vod;
use App\Models\Service;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Models\LearnerCourse;
use App\Models\VodPurchase;
use App\Models\Donation;
use App\Models\DonationCause;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Notification;

use Crazymeeks\Foundation\PaymentGateway\Dragonpay;
use Crazymeeks\Foundation\PaymentGateway\Dragonpay\Token;

class DragonPayController extends Controller
{

	public function __construct()
    {
        //$this->middleware('auth');
    }
    
	
	// Depreciated?? Start
	// Duplicate of PaymentController/VodPaymentController
	public function form($course_id)
    {
		$course = Course::find($course_id);
        $services = Service::where('course_id', '=', $course_id)->get();
    	$payments = PaymentMethod::all();    	

        // the above order is just for example.
        $enrolled = LearnerCourse::ifEnrolled($course->id, Auth::User()->id);
     	if ($enrolled) :
     		\Session::flash('message', 'Already enrolled in this course.'); 
     		\Session::flash('status', 'info'); 
     		return redirect()->route('course.show', $course->id);
     	endif;
     		
     	if (Order::ifVodPending($course->id, Auth::user()->id)) :
     		\Session::flash('message', 'Already enrolled but with pending payment.'); 
     		\Session::flash('status', 'info'); 
     		return redirect()->route('course.show', $course->id);
     	endif;
     		
        return view('dragonpay/form', compact('services','transaction_id', 'payments', 'course'));
    }
	// Depreciated?? End
    
	// Depreciated?? Start
    public function process(Request $request)
    {
		// dd($request);
		$service = Service::find($request->input('service_id'));

		if (isset($service->course_id)) {
			$request->validate([
				'service_id'=>'required',
				'payment' => 'required',
				'amount' => 'required'
			]);
	   
			$payment = $request->input('payment');
		
			$order = new Order;
			$transaction_id = Auth::User()->id.time().mt_rand(10000000,99999999);
			
			$exist = Order::where('transaction_id', $transaction_id)->first();
			while (count($exist) > 0) {
				$transaction_id = Auth::User()->id.time().mt_rand(10000000,99999999);
				$exist = Order::where('transaction_id', $transaction_id)->first();
			}
			
			$order->user_id = Auth::User()->id;  
			$order->transaction_id = $transaction_id;
			$order->service_id    = $request->input('service_id');
			$order->payment_id =  $request->input('payment');
			$order->code =  $request->input('code');
			$order->amount =  $request->input('amount');
			$order->billable = 1;
	
			// the above order is just for example.
			$enrolled = LearnerCourse::ifEnrolled($service->course->id, Auth::User()->id);
			if ($enrolled) :
				\Session::flash('message', 'Already enrolled in this course.'); 
				\Session::flash('status', 'info'); 
				return redirect()->route('course.show', $service->course_id);
			endif;
				
			// if enrollment is pending 
			if (count($order) > 0) :
				if ($payment == 1):
					
					$order->save();
					return redirect()->route('checkout.payment.dragonpay', ['transaction_id' => encrypt($transaction_id)]);
					
				else:
					$order->payment_status= 'P';
					
					$order->save();
					Notification::send(Auth::User(), new SendPaymentInstructionEmail($order));
					\Session::flash('message', 'Your enrollment is pending. Please follow the email instructions sent.'); 
				\Session::flash('status', 'info'); 
					return redirect()->route('course.show', $service->course_id);
				
				endif;
			else :
					\Session::flash('error', 'Order not found.'); 
				return redirect()->route('course.show', $service->course_id);
			endif;
		} else if (isset($service->vod_id)) {
			$validator = Validator::make($request->all(),
				[
					'service_id'				=>  'required',
					'payment' 					=> 	'required',
					'amount' 					=> 	'required',
				],
				[
					'service_id.required'       => "Rate/Package is required.",
					'payment.required'          => "Payment Method is required.",
					'amount.required'          	=> "Description of the service is required."
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
			
			$vod = Vod::find($service->vod_id);
	
			$order->payment_id = $request->input('payment');
			$order->amount = $vod->amount;
			$order->billable = 1;      
	
			// the above order is just for example.
			$owned = VodPurchase::ifOwned($vod->id, Auth::User()->id);
			if ($owned) :
				\Session::flash('message', 'Already purchased this video.'); 
				\Session::flash('status', 'info'); 
				return redirect()->route('vod.index');
			endif;

			if (isset($order)) :			
				if ($payment == 1): // DRAGONPAY     			
					$order->save();
					return redirect()->route('checkout.payment.dragonpay', ['transaction_id' => encrypt($transaction_id)]);			
				elseif ($payment == 4): // PAYPAL     			
					$order->save();     			
					return redirect()->route('checkout.payment.paypal', ['order_id' => encrypt($order->id)]);     		
				else:				 
				// if enrollment is pending 
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
		} else {	
			return redirect()->back()->with([
				'status' => 'danger', 
				'message' => "Product is not available. Please Contact pelikuloveofficial@gmail.com for support"
				]);
		}
	} 
	// Depreciated?? End	

    public function checkout($transaction_id, Request $request)
     {
		$order = Order::where('transaction_id', decrypt($transaction_id))->first(); 
		
		if (isset($order->service->course_id)) {
			$param1 = Course::findorfail($order->service->course_id);
     	      	
			$parameters = [
				'merchantTxnId' => $order->transaction_id, # Varchar(40) A unique id identifying this specific transaction from the merchant site
				'amount' => $order->amount, # Numeric(12,2) The amount to get from the end-user (XXXX.XX)
				'ccy' => 'PHP', # Char(3) The currency of the amount
				'description' => $order->service->name, # Varchar(128) A brief description of what the payment is for
				'email' => Auth::User()->email, # Varchar(40) email address of customer
				'param1' => $param1->title, # Varchar(80) [OPTIONAL] value that will be posted back to the merchant url when completed
				'param2' => 'param2', # Varchar(80) [OPTIONAL] value that will be posted back to the merchant url when completed
			];
		} elseif (isset($order->service->vod_id)) {
			$param1 = Vod::findorfail($order->service->vod_id);
     	      	
			$parameters = [
				'merchantTxnId' => $order->transaction_id, # Varchar(40) A unique id identifying this specific transaction from the merchant site
				'amount' => $order->amount, # Numeric(12,2) The amount to get from the end-user (XXXX.XX)
				'ccy' => 'PHP', # Char(3) The currency of the amount
				'description' => $param1->title, # Varchar(128) A brief description of what the payment is for
				'email' => Auth::User()->email, # Varchar(40) email address of customer
				'param1' => $param1->title, # Varchar(80) [OPTIONAL] value that will be posted back to the merchant url when completed
				'param2' => 'param2', # Varchar(80) [OPTIONAL] value that will be posted back to the merchant url when completed
			];
		} elseif ($order->service->id == 15) {
			$donation = Donation::where('order_id', $order->id)->first();
			if (isset($donation->cause_id)) {
				$d_cause = DonationCause::find($donation->cause_id);
				$desc = "Donation for " . $d_cause->title;
			} else {
				$desc = "Donation" ;
			}
				
			$parameters = [
				'merchantTxnId' => $order->transaction_id, # Varchar(40) A unique id identifying this specific transaction from the merchant site
				'amount' => $order->amount, # Numeric(12,2) The amount to get from the end-user (XXXX.XX)
				'ccy' => 'PHP', # Char(3) The currency of the amount
				'description' => $desc, # Varchar(128) A brief description of what the payment is for
				'email' => Auth::User()->email, # Varchar(40) email address of customer
				'param1' => 'param1', # Varchar(80) [OPTIONAL] value that will be posted back to the merchant url when completed
				'param2' => 'param2', # Varchar(80) [OPTIONAL] value that will be posted back to the merchant url when completed
			];
		} else {
			return redirect()->back()->with([
				'status' => 'danger', 
				'message' => "Product is not available. Please Contact pelikuloveofficial@gmail.com for support"
				]);
		}

        $merchant_account = [
              'merchantId' => 'PELIKULOVE',
              'password'   => 'Cj2LXJGKXc6ETC1',
        ];
        
        $testing = false; # Set Payment mode to production
        // Initialize Dragonpay
        $dragonpay = new Dragonpay($merchant_account,  $testing);
        
        // Get token from Dragonpay
        $token = $dragonpay->getToken($parameters);
        
        // If $token instance of Crazymeeks\Foundation\PaymentGateway\Dragonpay\Token, then proceed
        if ( $token instanceof Token ) {
             $dragonpay->away();
        }    
     }
     
     public function postback(Request $request) {     
     	$transaction = null;
     	$admin = null;
     	$ipAddress = new CaptureIpTrait();
     	
     	$method = $request->method();

		if ($request->isMethod('post')) {
   		 	$txnid = $request->input('txnid');
     		$refno = $request->input('refno');
     		$status = $request->input('status');
     		$message = $request->input('message');
     		$digest = $request->input('digest');
     	
     		//$d1 = sha1("$txnid:$refno:$status:$message:ZR4b9WfK716hkWs");
			$d1 = sha1("$txnid:$refno:$status:$message:Cj2LXJGKXc6ETC1");
			 
     		if (isset($digest) && isset($d1) && $digest == $d1) :
     			
       			$order = Order::where('transaction_id', $txnid)->first();
     							
     			$transaction = new Transaction;
     			$transaction->txnid = $txnid;
       			$transaction->refno = $refno;
       			$transaction->amount = $order->amount;
       			$transaction->status = $status;
       			$transaction->order_id = $order->id;
       			$transaction->message = $message;
       			$transaction->digest = $digest;
       			$transaction->ip_addr = $ipAddress->getClientIp();
        		$transaction->save();
     			
     		    if (isset($status) && $status == 'P' && $order->payment_status != 'S') {
					$order->payment_status= $status;
				}

				$order->save();
     		
     			if (isset($status) && $status == "S" && !empty($order)) :					
					// Check if Course or Vod 
					$service = Service::find($order->service_id);
					if (isset($service->course_id)) {
						// If Course 
						$enrolled = LearnerCourse::ifEnrolled($service->course_id, $order->user_id);
						
						if (!$enrolled)	:
							// Enroll the user to course

							$data = array(
								'course_id' => $service->course_id, 
								'user_id' => $order->user_id, 
								'order_id' => $order->id
							);
							$user = User::find($order->user_id);
							
							$learner = LearnerCourse::saveLearnerCourse($data);
							Notification::send($user, new SendPaymentEmail($order));							
							$admin = User::find(10);

							if (count($admin) > 0) 
								Notification::send($admin, new SendPaymentNotifyEmail($order));
						endif;
					} elseif (isset($service->vod_id)) {
						// If VOD
						$vod = Vod::find($service->vod_id);
						$owned = VodPurchase::ifOwned($vod->id, $order->user_id);
	
						if (!$owned) {
							$data = array(
								'vod_id' => $vod->id, 
								'user_id' => $order->user_id, 
								'order_id' => $order->id
							);
	
							$owner = VodPurchase::saveVodPurchase($data);
							$user = User::find($order->user_id);
							Notification::send($user, new SendVodPaymentEmail($order));
	
							$admin = User::find(10);
							if (isset($admin)) {
								Notification::send($admin, new SendVodPaymentNotifyEmail($order));   
							}   
						}	
					} elseif ($service->id == 15) {
						// If Donation
						$donation = Donation::where('order_id', $order->id)->first();
						$donation->paid = 1;
						$donation->save();
	
						if (isset($donation)) {
							// Send Emails
							// $data = array(
							// 	'vod_id' => $vod->id, 
							// 	'user_id' => $order->user_id, 
							// 	'order_id' => $order->id
							// );
	
							// $owner = VodPurchase::saveVodPurchase($data);
							$user = User::find($order->user_id);
                        	Notification::send($user, new SendDonationPaymentEmail($order));
	
							$admin = User::find(10);
							if (isset($admin)) {
								Notification::send($admin, new SendDonationPaymentNotifyEmail($order));   
							}   
						}	
					} else {
						return redirect()->back()->with([
							'status' => 'danger', 
							'message' => "Product is not available. Please Contact pelikuloveofficial@gmail.com for support"
							]);
					}
     				
           			echo "result:OK";
           		elseif (isset($status) && $status == "P") :
            	
           		 	echo "result:PENDING";
           		else :
           		 	echo "result:FAILURE";
     			endif; 
     		
     		else:
     			echo "result:FAIL_DIGEST_MISMATCH";
     		endif;
		}	
     	
     	
    
     	
     }
    
    public function status($order_id) {
    	$service = null;
		$transacion = null;
		
    	
    	$order = Order::find(decrypt($order_id));
    	$transaction = Transaction::where('txnid', '=', $order->transaction_id)
    						->where('refno', '=', $order->ref_no)
							->orderBy('created_at', 'desc')->first();
							
		$service = Service::find($order->service_id);
		return view('payments/thank', compact('order', 'service', 'transaction'));     
    } 
     
    public function return(Request $request)
    {
    	$order = null;
    	$admin = null;
    	$ipAddress = new CaptureIpTrait();
     	
		
      	$txnid = $request->input('txnid');
     	$refno = $request->input('refno');
     	$status = $request->input('status');
     	$message = $request->input('message');
     	$digest = $request->input('digest');
     	
     	//$d1 = sha1("$txnid:$refno:$status:$message:ZR4b9WfK716hkWs");
    	$d1 = sha1("$txnid:$refno:$status:$message:Cj2LXJGKXc6ETC1");
    	
     	
     	$order = Order::where('transaction_id', '=', $txnid)->orderBy('created_at', 'desc')->first();
     	$service = Service::find($order->service_id);
     	
        if (isset($digest) && isset($d1) && $digest == $d1) :
		
			$transaction = new Transaction;
     		$transaction->txnid = $txnid;
       		$transaction->refno = $refno;
       		$transaction->status = $status;
       		$transaction->message = $message;
       		$transaction->amount = $order->amount;
       		$transaction->order_id = $order->id;
       		$transaction->digest = $digest;
       		$transaction->ip_addr = $ipAddress->getClientIp();
        	$transaction->save();
     		
     		if (isset($status) && $status == 'P' && $order->payment_status != 'S') {
				$order->payment_status= $status;
				$order->ref_no = $refno;
			}
     		
			$order->save();
     		
     		if ($status == 'S') :			

            	$order->update([
                	'payment_status' => 'S',
                	'ref_no' => $refno,
				]);	
						
				// Check if Course or Vod 
				$service = Service::find($order->service_id);
				if (isset($service->course_id)) {
					// If Course 
					$enrolled = LearnerCourse::ifEnrolled($service->course_id, $order->user_id);
					
					if (!$enrolled)	:
						// Enroll the user to course

						$data = array(
							'course_id' => $service->course_id, 
							'user_id' => $order->user_id, 
							'order_id' => $order->id
						);
						$user = User::find($order->user_id);
						
						$learner = LearnerCourse::saveLearnerCourse($data);
						Notification::send($user, new SendPaymentEmail($order));							
						$admin = User::find(10);

						if (count($admin) > 0) 
							Notification::send($admin, new SendPaymentNotifyEmail($order));
					endif;
				} elseif (isset($service->vod_id)) {
					// If VOD
					$vod = Vod::find($service->vod_id);
					$owned = VodPurchase::ifOwned($vod->id, $order->user_id);

					if (!$owned) {
						$data = array(
							'vod_id' => $vod->id, 
							'user_id' => $order->user_id, 
							'order_id' => $order->id
						);

						$owner = VodPurchase::saveVodPurchase($data);
						$user = User::find($order->user_id);
						Notification::send($user, new SendVodPaymentEmail($order));

						$admin = User::find(10);
						if (isset($admin)) {
							Notification::send($admin, new SendVodPaymentNotifyEmail($order));   
						}   
					}	
				} elseif ($service->id == 15) {
					// If Donation
					$donation = Donation::where('order_id', $order->id)->first();
					$donation->paid = 1;
					$donation->save();

					if (isset($donation)) {
						// Send Emails
						// $data = array(
						// 	'vod_id' => $vod->id, 
						// 	'user_id' => $order->user_id, 
						// 	'order_id' => $order->id
						// );

						// $owner = VodPurchase::saveVodPurchase($data);
						$user = User::find($order->user_id);
						Notification::send($user, new SendDonationPaymentEmail($order));

						$admin = User::find(10);
						if (isset($admin)) {
							Notification::send($admin, new SendDonationPaymentNotifyEmail($order));   
						}   
					}	
				} else {    
					return redirect()->back()->with([
						'status' => 'danger', 
						'message' => "Product is not available. Please Contact pelikuloveofficial@gmail.com for support"
						]);
				}
     			
     		elseif ($status == 'P') :
            	$order->update([
                	'payment_status' => 'P',
                	'ref_no' => $refno,
            	]);
     			\Session::flash('message', 'Please check your email for payment instructions.');
     			\Session::flash('status', 'info'); 
     		endif;	
     		
     	else :
			\Session::flash('error', 'Invalid Digest: ' . $digest);    
			$order->update(['payment_status' => 'F' ]);  
		
			$service = Service::find($order->service_id);
			return view('payments/thank', compact('order', 'service', 'transaction')); 
		endif;
		 
		$service = Service::find($order->service_id);
		return view('payments/thank', compact('order', 'service', 'transaction')); 
    }
}
