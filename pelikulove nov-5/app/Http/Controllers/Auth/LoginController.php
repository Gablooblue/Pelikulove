<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectAfterLogout = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Logout, Clear Session, and Return.
     *
     * @return void
     */
    public function logout()
    {
        $user = Auth::user();
        Log::info('User Logged Out. ', [$user]);
        Auth::logout();
        Session::flush();

        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }

    public function authenticated(Request $request) {   
        // dd('LoginController@authenticated');     
        $redirectURL = $request->session()->get('redirectURL');
        $request->session()->forget('redirectURL');        

        Auth::user()->lastlogin = \Carbon\Carbon::now();
        Auth::user()->save();	

        if (isset($redirectURL)) {
            return redirect($redirectURL);
        }
    }

    public function tambayanWithRLLogin()
    {
        return view('auth.tambayan-with-rl-login'); 
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {        
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        $previousUrl = url()->previous();

        if (Str::contains($previousUrl, 'tambayan-with-ricky-lee')) {
            return $this->authenticated($request, $this->guard()->user())
                ?: redirect('blackbox/18');
        } else {
            return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
        }
    }
}
