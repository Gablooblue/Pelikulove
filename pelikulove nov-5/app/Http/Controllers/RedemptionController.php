<?php

namespace App\Http\Controllers;

use Notifications;
use App\Notifications\SendRedemptionEmail;
use App\Notifications\SendCodeInviteEmail;

use Auth;
use Validator;
use Carbon\Carbon;
use App\Models\Course;
use App\Models\GiftCode;
use App\Models\VodTimeCode;
use App\Models\VodTimeCodeTracking;
use App\Models\LearnerCourse;
use App\Models\Vod;
use App\Models\VodPurchase;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Service;
use App\Models\User;
use App\Traits\CaptureIpTrait;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;

class RedemptionController extends Controller
{
    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    public function __construct()
    {
        // $this->middleware('auth');
    }
   
    public function create()
    {
        // $giftCodes = GiftCode::all();
        
        // $payments = PaymentMethod::orderBy('name')->get();
        // $users = User::orderBy('email')->get();
        // $services = Service::all();
    
        return view('redemption/index');
        		 
    	// return view('redemption/index', ['users' => $users, 'payments' => $payments, 'services' => $services,  'user_id' => $user_id]); 
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'code'                 => 'required',
            ],
            [
                'code.required'        => "Gift code is Required",
                'code.exists'          => "The Gift Code does not exist. Please contact pelikuloveofficial@gmail.com for support."
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $code = $request->input('code');
        $giftCode = GiftCode::where('code', $code)
        ->first();
        $vodTimeCode = VodTimeCode::where('code', $code)
        ->first();
        
        // If Code is a Gift Code
        if (isset($giftCode)) {
            if (!Auth::check()) {
                return redirect('/login');
            }
            if ($giftCode->validity == 1) {
                $giftCode->user_id = Auth::user()->id;
                $giftCode->validity = 0;
    
                //return redirect()->route('redemption.store', compact('code'));
                $user = Auth::user();        
    
                $codeExplode = explode('-', $code);
                $codePrefix = $codeExplode[0];
    
                if ($codePrefix != 'B1' && $codePrefix != 'B2' && $codePrefix != 'VOD') {
                    \Session::flash(
                        'codeTypeInvalid', 
                        'Invalid <strong>Code Type: ' . $codePrefix . '</strong><br>
                        Please contact pelikuloveofficial@gmail.com for support.');
                    return redirect('/redeem-a-code'); 
                }
                    
                $order = Order::where('code', $code)
                ->first();
    
                if ($codePrefix == "VOD") {
                    $user = Auth::user();       
                    $transaction_id = $user->user_id.time().mt_rand(10000000,99999999);
            
                    $exist = Order::where('transaction_id', $transaction_id)->first();
                    while (isset($exist)) {
                        $transaction_id = Auth::User()->id.time().mt_rand(10000000,99999999);
                        $exist = Order::where('transaction_id', $transaction_id)->first();
                    } 
                    
                    $mytime = Carbon::now();
                    $mytime = str_replace(' ', '-', $mytime->toDateTimeString());             
                            
                    $order = new Order;
                    $order->user_id = Auth::user()->id;
                    $order->transaction_id = $transaction_id;      
                    $order->payment_status = 'S';
                    $order->payment_id = 3;           
                    $order->vod_id = $giftCode->vod_id;
                    $order->code = $giftCode->code;
                    $order->billable = 1;      
                    $order->ref_no ='Timelimited-VOD-' . $mytime; 
                    $order->amount = 0;
                    
                    $vod = Vod::find($order->vod_id);
                    $this->vod = $vod;
                    $enrolled = VodPurchase::ifOwned($order->vod_id, $order->user_id);
                    $this->order = $order;    
    
                    if (!$enrolled)	 :	
                        $order->save();
                        $giftCode->save();
    
                        // Enroll the user to course
                        $user = User::find($order->user_id);
                        $data = array(
                            'vod_id' => $vod->id, 
                            'user_id' => Auth::User()->id, 
                            'order_id' => $order->id
                        );
    
                        $owner = VodPurchase::saveVodPurchase($data);
                        
                        $course = Vod::find($service->course_id);
                        $user = User::find($this->order->user_id);
                        $code = $this->order->code;
                        $txnID = $this->order->transaction_id;
                        $payment = PaymentMethod::find($this->order->payment_id);     
    
                        $request->session()->put('course_id', $service->course_id);
                        $request->session()->put('courseTitle', $course->title);
                        
                        Notification::route('mail', $user->email)
                        ->notify(new SendRedemptionEmail($service, $course, $user, $code, $txnID, $payment));	
                        
                        $data = array(
                            "service" => $service, 
                            "order" => $order, 
                            "course" => $course);
    
                        \Session::flash(
                            'successfulRedemption', 
                            'User is now enrolled to <strong>Course: ' . $course->title . '</strong>!');
                        return redirect('/redeem-a-code/invite');
                        
                        // return redirect()->route('course.show', $service->course_id);
                    else :               
                        $course = Course::find($service->course_id);
                        \Session::flash(
                            'alreadyEnrolled', 
                            'User is already enrolled to <strong>Course: ' . $course->title . '</strong><br>
                            Please gift the code to another user.');
                        return redirect('/redeem-a-code');       
                    endif;	 
                    
                    // return redirect('/redeem-a-code');
                } else if ($codePrefix == "B1" || $codePrefix == "B2") {
                    if (isset($order)) {
                        $order->user_id = Auth::user()->id;
                    } else {
                        $user = Auth::user();       
                        $transaction_id = $user->user_id.time().mt_rand(10000000,99999999);
                
                        $exist = Order::where('transaction_id', $transaction_id)->first();
                        while (isset($exist)) {
                            $transaction_id = Auth::User()->id.time().mt_rand(10000000,99999999);
                            $exist = Order::where('transaction_id', $transaction_id)->first();
                        } 
                        
                        $mytime = Carbon::now();
                        $mytime = str_replace(' ', '-', $mytime->toDateTimeString());             
                                
                        $order = new Order;
                        $order->user_id = Auth::user()->id;
                        $order->transaction_id = $transaction_id;      
                        $order->payment_status = 'S';
                        $order->payment_id = 7;           
                        $order->service_id = 2;
                        $order->code = $giftCode->code;
                        $order->billable = 1;      
        
                        if ($codePrefix == 'B1') {
                            $order->ref_no ='Ticket2Me-B1-' . $mytime;  
                            $order->amount = floatval(1999);
                        } elseif ($codePrefix == 'B2') {
                            $order->ref_no ='Ticket2Me-B2-' . $mytime;  
                            $order->amount = floatval(0);
                        }
                    }
                    
                    $service = Service::find($order->service_id);
                    $this->service = $service;
                    $enrolled = LearnerCourse::ifEnrolled($service->course_id, $order->user_id);
                    $this->order = $order;
                        
                    if (true) :            
                        if (!$enrolled)	 :	
                            $order->save();
                            $giftCode->save();
        
                            // Enroll the user to course
                            $user = User::find($order->user_id);
                            $data = array('course_id' => $service->course_id, 'user_id' => $order->user_id, 'order_id' => $order->id);
                            $learner = LearnerCourse::saveLearnerCourse($data);
                            
                            $service = Service::find($this->order->service_id);
                            $course = Course::find($service->course_id);
                            $user = User::find($this->order->user_id);
                            $code = $this->order->code;
                            $txnID = $this->order->transaction_id;
                            $payment = PaymentMethod::find($this->order->payment_id); 
                            // dd($this->order);    
        
                            $request->session()->put('course_id', $service->course_id);
                            $request->session()->put('courseTitle', $course->title);
                            
                            Notification::send(Auth::User(), new SendRedemptionEmail($service, $course, $user, $code, $txnID, $payment));	
                            
                            $data = array(
                                "service" => $service, 
                                "order" => $order, 
                                "course" => $course);
        
                            \Session::flash(
                                'successfulRedemption', 
                                'User is now enrolled to <strong>Course: ' . $course->title . '</strong>!');
                            return redirect('/redeem-a-code/invite');
                            
                            // return redirect()->route('course.show', $service->course_id);
                        else :               
                            $course = Course::find($service->course_id);
                            \Session::flash(
                                'alreadyEnrolled', 
                                'User is already enrolled to <strong>Course: ' . $course->title . '</strong><br>
                                Please gift the code to another user.');
                            return redirect('/redeem-a-code');       
                        endif;	 
                        
                        // return redirect('/redeem-a-code');
                    else:
                    endif;
                }
            }
            else {
                \Session::flash(
                    'codeUsed', 
                    'The <strong>Code: ' . $code . '</strong> has already been <strong>used</strong>.<br>
                    Please contact pelikuloveofficial@gmail.com for support.');
    
                return redirect('/redeem-a-code');
            }
        } else if (isset($vodTimeCode)) {
            // dd($vodTimeCode);
            $startsAt = Carbon::parse($vodTimeCode->starts_at);
            $endsAt = Carbon::parse($vodTimeCode->ends_at);

            if ($startsAt->lt(now()) && $endsAt->gt(now())) {
                $vod = Vod::find($vodTimeCode->vod_id);

                if (!isset($vod)) {
                    return redirect('/redeem-a-code')
                    ->with(['message' => 'The video of your code no longer exists. Contact pelikuloveofficial@gmail.com for support', 'status' => 'danger']);
                }
        
                $request->session()->put('code', $vodTimeCode);

                $ip_address = new CaptureIpTrait();
                
                $vtctExists = VodTimeCodeTracking::where('ip_address', $ip_address->getClientIp())->first();
                if (!isset($vtctExists)) {
                    $vodTimeCodeTracking = new VodTimeCodeTracking;
                    $vodTimeCodeTracking->code = $vodTimeCode->code;
                    $vodTimeCodeTracking->ip_address = $ip_address->getClientIp();
                    $vodTimeCodeTracking->uses = 1;
                    $vodTimeCodeTracking->save();
                } else {
                    $vodTimeCodeTracking = $vtctExists;
                    $vodTimeCodeTracking->uses = ($vodTimeCodeTracking->uses)+1;
                    $vodTimeCodeTracking->save();
                }
                
                return redirect()->route('vod.showPrivate', $vodTimeCode->vod_id);
            } else {
                if ($startsAt->gt(now())) {
                    return redirect('/redeem-a-code')
                    ->with(['message' => 'Your code is not yet usable. Please wait till "' . $startsAt->toDayDateTimeString() . '".', 
                    'status' => 'warning']);
                } else if ($endsAt->lt(now())) {
                    return redirect('/redeem-a-code')
                    ->with(['message' => 'Your code is no longer usable. It expired on "' . $endsAt->toDayDateTimeString() . '".', 
                    'status' => 'danger']);
                } else {
                    return redirect('/redeem-a-code')
                    ->with(['message' => 'Error! Please Contact pelikuloveofficial@gmail.com for support.', 
                    'status' => 'danger']);
                }
            }
        } else {
            return redirect('/redeem-a-code')
            ->with(['message' => 'Code: ' . $code . 'does not exist!', 'status' => 'danger']);
        } 
    }
    
    public function invite()
    {                
        return view('redemption/invite');
    }
    
    public function inviteStore(Request $request)
    {                
        $validator = Validator::make($request->all(),
            [
                'email'                => 'required|email|max:255',
                'code'                 => 'required|exists:gift_codes,code',
            ],
            [
                'email.required'       => trans('auth.emailRequired'),
                'email.email'          => trans('auth.emailInvalid'),
                'code.required'        => "Gift code is Required",
                'code.exists'          => "The gift code does not exist. Please contact pelikuloveofficial@gmail.com for support."
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $code = $request->input('code'); 
        $email = $request->input('email');  
        $giftCode = GiftCode::where('code', $code)->first();

        $user = User::where('email', $email)->first();
        $sender = Auth::user();
        
        if ($email == $sender->email){
            \Session::flash(
                'emailCannotBeYourOwn', 
                "Your own email cannot be used here.");
            return redirect('/redeem-a-code/invite'); 
        }

        $codeExplode = explode('-', $code);
        $codePrefix = $codeExplode[0];

        if ($codePrefix != 'B1' && $codePrefix != 'B2' && $codePrefix != 'VOD'){
            \Session::flash(
                'codeTypeInvalid', 
                'Invalid <strong>Code Type: ' . $code . '</strong><br>
                Please contact pelikuloveofficial@gmail.com for support.');
            return redirect('/redeem-a-code/invite'); 
        }

        // $service = $data->service;
        // $order = $data->order;
        // $course = $data->course;

        if($request->session()->has('course_id')){
            $course_id = $request->session()->get('course_id');
        }
        else{
            // $course_id = 1;
        }

        if($request->session()->has('courseTitle')){
            $courseTitle = $request->session()->get('courseTitle');
        }
        else{
            // $courseTitle = "Rody Vera Online Playwriting Course";
        }

        if ($giftCode->validity == 1) {
            //if email has an account
            if ($user->first()->isNotEmpty() || $user != null){
                $enrolled = LearnerCourse::ifEnrolled($course_id, $user->id);
                if (!$enrolled) {
    
                    Notification::route('mail', $email)
                    ->notify(new SendCodeInviteEmail($sender, $email, $courseTitle, $code));
                    return redirect()->route('course.show', $course_id);
                }
                else {           
                    $course = Course::find($course_id);
                    \Session::flash(
                        'alreadyEnrolled', 
                        'The invited user is already enrolled to <strong>Course: ' . $course->title . '</strong><br>
                        Please gift the code to another user.');
                    return redirect('/redeem-a-code/invite'); 
                }
            }
            //if email has no account
            else {       
                Notification::route('mail', $email)
                ->notify(new SendCodeInviteEmail($sender, $email, $courseTitle, $code));
                return redirect()->route('course.show', $course_id);
            }
        }
        else {
            \Session::flash(
                'codeUsed', 
                'The <strong>Code: ' . $code . '</strong> has already been used.<br>
                Please contact pelikuloveofficial@gmail.com for support.');
            
            return redirect('/redeem-a-code/invite');     
        }

        $request->session()->forget('course_id');
        $request->session()->forget('courseTitle');
    }
    
    public function inviteSkip()
    {   
        return redirect()->route('course.show');
    }
}