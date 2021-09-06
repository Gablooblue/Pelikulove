<?php 

namespace App\Http\Controllers;

use Notifications;
use App\Notifications\SendPaymentEmail;
use App\Notifications\SendPaymentInstructionEmail;
use App\Notifications\SendPaymentNotifyEmail;
use App\Notifications\SendVodPaymentInstructionEmail;
use App\Notifications\SendDonationPaymentInstructionEmail;


use Auth;
use App\Traits\CaptureIpTrait;
use App\Models\User;
use App\Models\Course;
use App\Models\Service;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Models\LearnerCourse;
use App\Models\PromoCode;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Notification;



class PaymentController extends Controller
{

	public function __construct()
    {
        //$this->middleware('auth');
    }
    
	
	public function form($course_id, $order_id = null)
    {

		$order = null;
		$course = Course::find($course_id);
        $services = Service::where('course_id', '=', $course_id)
					->where('available', '=', 1)
					->orderBy('sorder', 'asc')
					->get();
    	$payments = PaymentMethod::all();
			
		if ($course->private == 1) {	
			return redirect('/home')->with('danger', 'Course is private.');
		}
    	
		if ($order_id) $order = Order::find(decrypt($order_id));
      
        $enrolled = LearnerCourse::ifEnrolled($course->id, Auth::User()->id);
     	if ($enrolled) :
     		\Session::flash('message', 'Already enrolled in this course.'); 
     		\Session::flash('status', 'info'); 
     		return redirect()->route('course.show', $course->id);
     	endif;
     		
     	if (Order::ifPending($course->id, Auth::user()->id)) :
     		\Session::flash('message', 'Already enrolled but with pending payment.'); 
     		\Session::flash('status', 'info'); 
     		return redirect()->route('course.show', $course->id);
     	endif;
     		
        return view('payments/form', compact('services', 'payments', 'course', 'order'));
    }
    
    public function form2($course_id, $order_id = null)
    {

		$order = null;
		$course = Course::find($course_id);
        $services = Service::where('course_id', '=', $course_id)
        			->where('available', '=', 1)->get();
    	$payments = PaymentMethod::all();
    	
    	if ($order_id) $order = Order::find(decrypt($order_id));
    	

      
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
     		
        return view('payments/form2', compact('services', 'payments', 'course', 'order'));
    }
    
    public function test() 
    {
    	$user = User::find(1);
    	$order = Order::find(447);
    	Notification::send($user, new SendPaymentNotifyEmail($order));
    	echo "hello";
    	
    }
  
    public function process(Request $request)
    {    	
    	$request->validate([
            'service_id'=>'required',
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
		$service = Service::findOrFail($request->input('service_id'));	  

		if ($service->available != 1) {
			return redirect()->route('course.enroll', $service->course_id)->with([
                'message' => "The package you have chosen: <strong>'" . $service->name . "'</strong> is not available!", 'status' => 'danger'
            ]);
		}
		
		$code = $request->input('code');
		$dateNow =  date('Y-m-d');
		$promoCode = PromoCode::where('code', '=', $code)->where('service_id', '=', $service->id)
						->where('start_date', '<=', $dateNow)
						->where('end_date', '>=', $dateNow)
						->first();
		
		// Check code if valid
		if (isset($promoCode)) {
			// If Code valid 
       		$order->amount = $promoCode->amount;
		} else {
			// If Code Invalid
       		$order->amount = $service->amount;
		}
    
    	$order->service_id    = $request->input('service_id');
       	$order->payment_id =  $request->input('payment');
       	$order->code =  $request->input('code');
       	// $order->amount =  $request->input('amount');
		$order->billable = 1;
        
		 

     	$service = Service::findOrFail($order->service_id);

        // the above order is just for example.
        $enrolled = LearnerCourse::ifEnrolled($service->course->id, Auth::User()->id);
     	if ($enrolled) :
     		\Session::flash('message', 'Already enrolled in this course.'); 
     		\Session::flash('status', 'info'); 
     		return redirect()->route('course.show', $service->course_id);
     	endif;
     		
     	// if enrollment is pending 
     	if (isset($order)) :
     		if ($payment == 1):
     			
     			$order->save();
     			return redirect()->route('checkout.payment.dragonpay', ['transaction_id' => encrypt($transaction_id)]);
     		elseif ($payment == 4):
     			
     			$order->save();
     			
     			return redirect()->route('checkout.payment.paypal', ['order_id' => encrypt($order->id)]);
     		
     		else:
     			$order->payment_status= 'P';
     			
				$order->save();
				
                if (isset($service->course_id)) {   
					Notification::send(Auth::User(), new SendPaymentInstructionEmail($order));
                } elseif (isset($service->vod_id)) {
					Notification::send(Auth::User(), new SendVodPaymentInstructionEmail($order));
                } elseif ($service->id == 15) {  
					Notification::send(Auth::User(), new SendDonationPaymentInstructionEmail($order));
				}
				
     			\Session::flash('message', 'Your enrollment is pending. Please follow the email instructions sent.'); 
				\Session::flash('status', 'info'); 
     			return redirect()->route('course.show', $service->course_id);
     		
     		endif;
     	else :
     			\Session::flash('error', 'Order not found.'); 
     		return redirect()->route('course.show', $service->course_id);
     	endif;  	
	}
	
	public function ajaxCheckCode ($code){
		$now =  date('Y-m-d');
        $find = \App\Models\PromoCode::where('code', '=', $code)
        				->where('start_date', '<=', $now)
        				->where('end_date', '>=', $now)
                        ->first();
                        
        if (isset($find)) 
            return response()->json($find);
        else 
            return response()->json([
   				 'error' => $code . " is an invalid code.",
    	    ]);
    }
}
