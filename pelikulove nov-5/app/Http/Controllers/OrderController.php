<?php

namespace App\Http\Controllers;

use Notifications;
use App\Notifications\SendPaymentEmail;
use App\Notifications\SendEarlyAccessEmail;
use App\Notifications\SendCompliEmail;
use App\Notifications\SendPaymentInstructionEmail;
use App\Notifications\SendPaymentNotifyEmail;
use App\Notifications\SendVodPaymentEmail;
use App\Notifications\SendVodPaymentInstructionEmail;
use App\Notifications\SendVodPaymentNotifyEmail;
use App\Notifications\SendDonationPaymentEmail;
use App\Notifications\SendDonationPaymentInstructionEmail;
use App\Notifications\SendDonationPaymentNotifyEmail;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;

use Validator;

use Auth;


use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Service;
use App\Models\User;
use App\Models\RoleUser;
use App\Models\LearnerCourse;
use App\Models\VodPurchase;
use App\Models\Vod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     

    public function index()
    {    
    	$services = Service::all();
    	$pagintaionEnabled = config('usersmanagement.enablePagination');
    	// $pagintaionEnabled = false;
        if ($pagintaionEnabled) {
            $orders = Order::where('service_id', '!=', NULL)
            ->orderBy('created_at', 'desc')
            ->paginate(config('usersmanagement.paginateListSize'));
        } else {
            $orders = Order::where('service_id', '!=', NULL)
            ->orderBy('created_at', 'desc')
            ->get();
        }     
        
        if (Auth::User()->hasPermission('view.orders')) { // you can pass an id or slug
    		return view('orders.index', compact('orders', 'services')); 
		} else {
			 return back()->with([
                 'message' => "Sorry, you have't have access to that page.",
                 'status' => 'warning'
                
            ]);
		}        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($user_id = null)
    {
        
        $payments = PaymentMethod::orderBy('name')->get();
        $users = User::orderBy('email')->get();
        $services = Service::where('course_id', "!=", NULL)->get();
    
        
        if (Auth::User()->hasPermission('create.orders')) :
        		 
    			return view('orders.create', compact('users', 'payments', 'services',  'user_id')); 
			
		else :
				 return back()->with([
                 'message' => "Sorry, you have't have access to that page.",
                 'status' => 'warning' ]);
		endif;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'     => 'required',
            'ref_no' => 'required',
            'payment_status' => 'required',
            'amount' => 'required|numeric',
            'payment_id' => 'required',
            'service_id' => 'required',              
        ]);
            
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $service = Service::find($request->input('service_id'));
        $userRole = RoleUser::where('user_id', Auth::user()->id)
        ->first();

        if ($userRole->role_id != 1) {
            if ($userRole->role_id != 5) {
                if (isset($service)) {
                    if ($service->available != 1) {
                        return back()->with('error', "The service you have chosen is no longer available. Please try again.");
                    }
                } else {
                    return back()->with('error', "The service you have chosen no longer exists. Please try again.");
                }
            }
        }
        
        $transaction_id = $request->input('user_id').time().mt_rand(10000000,99999999);
        
        //$transaction_id = '16656740';
        
        $exist = Order::where('transaction_id', $transaction_id)->first();
        while (isset($exist)) {
        	$transaction_id = Auth::User()->id.time().mt_rand(10000000,99999999);
        	$exist = Order::where('transaction_id', $transaction_id)->first();
        }
        
        
        $user = User::find($request->input('user_id'));
        
        $order = new Order;
        $order->user_id = $request->input('user_id');
        $order->transaction_id = $transaction_id;
        $order->ref_no = $request->input('ref_no');
        $order->payment_status = $request->input('payment_status');
        $order->amount = floatval($request->input('amount'));
        $order->payment_id = $request->input('payment_id');
        $order->service_id = $request->input('service_id');
        $order->code = $request->input('code');
        if ($user->hasRole('admin|mentor|pelikulove')) : 
        	 $order->billable = 0 ;
        else: $order->billable = 1; 
        endif;
			
        if ($order->id) :
        	if ($order->payment_status == 'S') :
                $service = Service::find($order->service_id);
                
				if (isset($service->course_id)) {
                    if ($user->hasRole('pelikulove') || $user->hasRole('admin')) {
                        $enrolled = LearnerCourse::ifEnrolled($service->course_id, $order->user_id, true);
                    } else {
                        $enrolled = LearnerCourse::ifEnrolled($service->course_id, $order->user_id);
                    }
                         
                     if (!$enrolled)	 :		
                         // Enroll the user to course
                         $user = User::find($order->user_id);
                         $data = array('course_id' => $service->course_id, 'user_id' => $order->user_id, 'order_id' => $order->id);
                           $learner = LearnerCourse::saveLearnerCourse($data);
                           if ( $order->payment_id == 5) :
                               Notification::send($user, new SendEarlyAccessEmail($order));
                           elseif ( $order->payment_id == 6) :
                               Notification::send($user, new SendCompliEmail($order));
                           else :
                               Notification::send($user, new SendPaymentEmail($order));
                           endif;	
                    endif;
				} elseif (isset($service->vod_id)) {
                    $vod = Vod::find($service->vod_id);
                    $owned = VodPurchase::ifOwned($vod->id, $order->user_id);
                         
                     if (!$owned)	 :		
                         // Add Purchase to VodPurchases
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
                    endif;

                } else {                    
					return redirect()->back()->with([
						'status' => 'danger', 
						'message' => "Product is not available. Please Contact pelikuloveofficial@gmail.com for support"
                    ]);
                }
                
		        $order->save();	
            ;
        	endif;
        	
        	return back()->with('success', trans('orders.createSuccess'));
         else:
         	return back()->with('error', trans('orders.createFail'));
         endif; 
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(order $order)
	{
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::find($id);
        $payments = PaymentMethod::orderBy('name')->get();
        $users = User::orderBy('email')->get();
        $services = Service::all();
        
        if (isset($order)) :    
        	if (Auth::User()->hasPermission('edit.orders'))  :
        	
    			return view('orders.edit', ['order' => $order, 'users' => $users, 'payments' => $payments, 'services' => $services]); 
			
			else :
				 return back()->with([
                 'message' => "Sorry, you have't have access to that page.",
                 'status' => 'warning' ]);
			endif;
       else :
            return redirect()->back()->with(['message' => "Invalid Order ID", 'status' => 'danger']);
		endif;	
    }

	public function transact($id)
    {
        $order = Order::find($id);
        
        if (isset($order)) :
        	if (Auth::User()->hasPermission('view.transactions'))  :
        	
    			return view('orders.transactions', ['order' => $order, 'transactions' => $order->transactions]); 
			
			else :
				 return back()->with([
                 'message' => "Sorry, you have't have access to that page.",
                 'status' => 'warning' ]);
			endif;
        else :        	
            return redirect()->back()->with(['message' => "Invalid Order ID", 'status' => 'danger']);  
		endif;	
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
    	
    	
        $validator = Validator::make($request->all(), [
                'user_id'     => 'required',
                'transaction_id'    => 'required',
                'ref_no' => 'required',
                'payment_status' => 'required',
                'amount' => 'required|numeric',
                'payment_id' => 'required',
                'service_id' => 'required',
           
            ]);
            
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $order = Order::find($request->input('id'));
        $stat = $order->payment_status; 
      
        
        if ($order) :
        	$order->user_id = $request->input('user_id');
        	$order->transaction_id = $request->input('transaction_id');
        	$order->ref_no = $request->input('ref_no');
        	$order->payment_status = $request->input('payment_status');
        	$order->amount = $request->input('amount');
        	$order->payment_id = $request->input('payment_id');
        	$order->service_id = $request->input('service_id');
        	$order->code = $request->input('code');
        	
            $saved =  $order->save();
            
        	if ($saved) :
        		if ($stat != $order->payment_status && $order->payment_status == 'S'):
        			$service = Service::find($order->service_id);
                    
                    if (isset($service->course_id)) {
                        if ($user->hasRole('pelikulove') || $user->hasRole('admin')) {
                            $enrolled = LearnerCourse::ifEnrolled($service->course_id, $order->user_id, true);
                        } else {
                            $enrolled = LearnerCourse::ifEnrolled($service->course_id, $order->user_id);
                        }
                             
                         if (!$enrolled)	 :		
                             // Enroll the user to course
                                $user = User::find($order->user_id);
                                $data = array('course_id' => $service->course_id, 'user_id' => $order->user_id, 'order_id' => $order->id);
                               $learner = LearnerCourse::saveLearnerCourse($data);
                               if ( $order->payment_id == 5) :
                                   Notification::send($user, new SendEarlyAccessEmail($order));
                               elseif ( $order->payment_id == 6) :
                                   Notification::send($user, new SendCompliEmail($order));
                               else :
                                   Notification::send($user, new SendPaymentEmail($order));
                               endif;	
                        endif;
                    } elseif (isset($service->vod_id)) {
						$vod = Vod::find($service->vod_id);
                        $owned = VodPurchase::ifOwned($vod->id, $order->user_id);
                             
                         if (!$owned)	 :		
                             // Add Purchase to VodPurchases
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
                        endif;
    
                    } else {                    
                        return redirect()->back()->with([
                            'status' => 'danger', 
                            'message' => "Product is not available. Please Contact pelikuloveofficial@gmail.com for support"
                        ]);
                    }
        		endif;
        		
        		return back()->with('success', trans('orders.updateSuccess'));
        	else:
        		return back()->with('error', trans('orders.updateFail'));
        	endif;	 
         else:
         	return back()->with('error', 'Invalid Order ID');
         endif;   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(order $order)
    {
        //
    }
}
