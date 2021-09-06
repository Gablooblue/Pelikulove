<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Notifications;
use Validator;
use View;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Service;
use App\Models\Order;
use App\Models\LearnerCourse;
use App\Models\RegisterLog;
use App\Models\TestLog;
use App\Models\EventLog;
use App\Notifications\SendNewRegistrantEmail;
use App\Notifications\SendCompliEmail;
use App\Traits\ActivationTrait;
use App\Traits\CaptchaTrait;
use App\Traits\CaptureIpTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Auth\RegistersUsers;
use jeremykenedy\LaravelRoles\Models\Role;

class SpecialRegistrationController extends Controller
{
    use ActivationTrait;
    use CaptchaTrait;
    use RegistersUsers;

    public function __construct()
    {
        // $this->middleware('auth');
    }
        
    public function createRickyLee ()
    { 
        if (Auth::check()) {
            if (LearnerCourse::ifEnrolled(3, Auth::user()->id)) {  
                return redirect()->route('course.show', 3)->with(['message' => "User is already registered in this course.", 'status' => 'warning']);
            } else {
                return View('auth.rickylee-register');
            }
        } else {
            return View('auth.rickylee-register');
        }
    }
        
    public function storeRickyLee (Request $request)
    {        
        $data['captcha'] = $this->captchaCheck();

        if (!config('settings.reCaptchStatus')) {            
            $data['captcha'] = true;
        }

        $validatorCaptcha = Validator::make($data,
            [
                'captcha'               => 'required|min:1',
            ],
            [
                'captcha.min'           => trans('auth.CaptchaWrong'),
            ]
        );

        if ($validatorCaptcha->fails()) {
            return back()->withErrors($validatorCaptcha)->withInput();
        }
        
        $validator = Validator::make($request->all(),
            [
                'name'                  => 'required|max:255|unique:users',
                // 'first_name'            => 'required|max:255',
                // 'last_name'             => 'required|max:255',
                'email'                 => 'required|email|max:255|unique:users',
                'password'              => 'required|min:6|max:30',
            /* 'password_confirmation' => 'required|same:password',*/
                'g-recaptcha-response'  => '',
                // 'captcha'               => 'required|min:1',
            ],
            [
                'name.unique'                   => trans('auth.userNameTaken'),
                'name.required'                 => trans('auth.userNameRequired'),
                // 'first_name.required'           => trans('auth.fNameRequired'),
                // 'last_name.required'            => trans('auth.lNameRequired'),
                'email.required'                => trans('auth.emailRequired'),
                'email.email'                   => trans('auth.emailInvalid'),
                'password.required'             => trans('auth.passwordRequired'),
                'password.min'                  => trans('auth.PasswordMin'),
                'password.max'                  => trans('auth.PasswordMax'),
                'g-recaptcha-response.required' => trans('auth.captchaRequire'),
                // 'captcha.min'                   => trans('auth.CaptchaWrong'),
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $ipAddress = new CaptureIpTrait();
        $role = Role::where('slug', '=', 'unverified')->first();

        $user = User::create([
                'name'              => $request->input('name'),
                // 'first_name'        => $request->input('first_name'),
                // 'last_name'         => $request->input('last_name'),
                'email'             => $request->input('email'),
                'password'          => Hash::make($request->input('password')),
                'token'             => str_random(64),
                'signup_ip_address' => $ipAddress->getClientIp(),
                'activated'         => !config('settings.activation'),
            ]);

        // dd($user);

        $user->attachRole($role);
        $this->initiateEmailActivation($user);

        $testLog = TestLog::create([
            'user_id'              => $user->id,
            'description_1'        => 'ricky lee registration',
            'description_2'        => $request->input('email'),
        ]);
        
        $testLog->save();        
        
        Auth::guard()->login($user);
        
        $transaction_id = $request->input('user_id').time().mt_rand(10000000,99999999);
        
        //$transaction_id = '16656740';
        
        $exist = Order::where('transaction_id', $transaction_id)->first();
        while (isset($exist)) {
        	$transaction_id = Auth::User()->id.time().mt_rand(10000000,99999999);
        	$exist = Order::where('transaction_id', $transaction_id)->first();
        }        
        
        $order = new Order;
        $order->user_id = $user->id;
        $order->transaction_id = $transaction_id;
        $order->ref_no = 'RickyLeeWorkshop';
        $order->payment_status = $request->input('payment_status');
        $order->amount = floatval(0);
        $order->payment_id = 6;
        $order->service_id = 12;
        $order->payment_status = 'S';
        $order->billable = 1;

		$order->save();
			
        if ($order->id) :
        	if ($order->payment_status == 'S') :
        		$service = Service::find($order->service_id);
        		$enrolled = LearnerCourse::ifEnrolled($service->course_id, $order->user_id);
     				
     			if (!$enrolled)	 :
     				// Enroll the user to course
     				$user = User::find($order->user_id);
     				$data = array('course_id' => $service->course_id, 'user_id' => $order->user_id, 'order_id' => $order->id);
               		$learner = LearnerCourse::saveLearnerCourse($data);
                    Notification::send($user, new SendCompliEmail($order));
            	endif;	
            ;
            endif;
        else:
         	return back()->with('error', 'Unexpected problem encountered. Please Try again or contact pelikuloveofficial@gmail.com');
        endif; 
        Notification::route('mail', 'pelikuloveofficial@gmail.com')
        ->notify(new SendNewRegistrantEmail($user));
        
        return redirect()->route('activate');
    }
    
        
    public function newCreateRickyLee ()
    { 
        if (Auth::check()) {
            return redirect()->route('public.home')->with(['message' => "User already has an account.", 'status' => 'warning']);
        } else {
            return View('auth.new-rickylee-register');
        }
    }
        
    public function newStoreRickyLee (Request $request)
    {        
        $data['captcha'] = $this->captchaCheck();

        if (!config('settings.reCaptchStatus')) {            
            $data['captcha'] = true;
        }

        $validatorCaptcha = Validator::make($data,
            [
                'captcha'               => 'required|min:1',
            ],
            [
                'captcha.min'           => trans('auth.CaptchaWrong'),
            ]
        );

        if ($validatorCaptcha->fails()) {
            return back()->withErrors($validatorCaptcha)->withInput();
        }
        
        $validator = Validator::make($request->all(),
            [
                'name'                  => 'required|max:255|unique:users',
                'email'                 => 'required|email|max:255|unique:users',
                'password'              => 'required|min:6|max:30',
            /* 'password_confirmation' => 'required|same:password',*/
                'g-recaptcha-response'  => '',
                // 'captcha'               => 'required|min:1',
            ],
            [
                'name.unique'                   => trans('auth.userNameTaken'),
                'name.required'                 => trans('auth.userNameRequired'),
                'email.required'                => trans('auth.emailRequired'),
                'email.email'                   => trans('auth.emailInvalid'),
                'password.required'             => trans('auth.passwordRequired'),
                'password.min'                  => trans('auth.PasswordMin'),
                'password.max'                  => trans('auth.PasswordMax'),
                'g-recaptcha-response.required' => trans('auth.captchaRequire'),
                // 'captcha.min'                   => trans('auth.CaptchaWrong'),
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $ipAddress = new CaptureIpTrait();
        $role = Role::where('slug', '=', 'unverified')->first();

        $user = User::create([
                'name'              => $request->input('name'),
                // 'first_name'        => $request->input('first_name'),
                // 'last_name'         => $request->input('last_name'),
                'email'             => $request->input('email'),
                'password'          => Hash::make($request->input('password')),
                'token'             => str_random(64),
                'signup_ip_address' => $ipAddress->getClientIp(),
                'activated'         => !config('settings.activation'),
            ]);

        // dd($user);

        $user->attachRole($role);
        $this->initiateEmailActivation($user);

        Notification::route('mail', 'pelikuloveofficial@gmail.com')
        ->notify(new SendNewRegistrantEmail($user));
        
        Auth::guard()->login($user);
        
        $rlRegisterLog = new RegisterLog;
        $rlRegisterLog->user_id = $user->id;
        $rlRegisterLog->event = "RickyLeeLandingPage";
        $rlRegisterLog->save();
        
        return redirect()->route('activate.rickylee');
    }
        
    public function storeRickyLeeProfile (Request $request)
    {              
        // dd($request);  

        $validator = Validator::make($request->all(),
            [
                'first_name'                => 'required|max:255',
                'last_name'                 => 'required|max:255',
                'mobile_number'             => 'required|max:12',
                'gender'                    => 'required|max:100',
                'birthday'                  => 'required|date',
                'profession'                => 'required|max:255',
                'interests'                 => 'required|max:255',
                'referer'                   => 'required|max:255',
                'comments'                  => 'required',
            ],
            [
                'first_name.required'           => trans('auth.fNameRequired'),
                'last_name.required'            => trans('auth.lNameRequired'),
                'mobile_number.required'        => "Mobile Number is required.",
                'gender.required'               => "Gender is required.",
                'birthday.required'             => "Birthday is required.",
                'profession.required'           => "Profession is required.",
                'interests.required'            => "Interests is required.",
                'referer.required'              => "Referer is required.",
                'comments.required'             => "Comments is required.",
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();

        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->mobile_number = $request->input('mobile_number');
        $user->gender = $request->input('gender');
        $user->birthday = $request->input('birthday');
        $user->profession = $request->input('profession');
        $user->interests = $request->input('interests');
        $user->save();
        
        $eventLog = new EventLog;
        $eventLog->user_id = $user->id;
        $eventLog->event = "Ricky Lee Landing Page";
        $eventLog->referer = $request->input('referer');
        $eventLog->comment = $request->input('comments');
        $eventLog->save();

        // dd($request);  
                
        // return redirect()->url('forum/23-ricky-lee-talks-webinars');
        return redirect('blackbox/18');
    }
}