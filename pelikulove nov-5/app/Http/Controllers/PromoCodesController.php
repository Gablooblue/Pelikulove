<?php

namespace App\Http\Controllers;

/*
use App\Http\Requests\DeleteUserAccount;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Http\Requests\UpdateUserProfile;
use App\Models\Profile;
use App\Models\Theme;
use App\Models\User;
use App\Notifications\SendGoodbyeEmail;
use App\Traits\CaptureIpTrait;
use File;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Image;
use jeremykenedy\Uuid\Uuid;
use Validator;
use View;
*/

use App\Models\GiftCode;
use App\Notifications\SendGiftCodeEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Notifications;
use Validator;
use View;

class PromoCodesController extends Controller
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
   
    public function create()
    {
        $giftCodes = GiftCode::all();

        return view('promocodes/index', compact('giftCodes'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'code_type'                 => 'required',
                'email'                     => 'required|email|max:255',
                'code1'                     => "required|unique:gift_codes,code",
                'code2'                     => "required|unique:gift_codes,code",
                // 'code1'                     => "required",
                // 'code2'                     => "required",
            ],
            [
                'code_type.required'        => "Code Type is Required",
                'email.required'            => trans('auth.emailRequired'),
                'email.email'               => trans('auth.emailInvalid'),
                'code1.required'            => "Generate a Code first.",
                'code2.required'            => "Generate a Code first.",
                'code1.unique'              => "Code 1 is not unique. Please generate another code.",
                'code2.unique'              => "Code 2 is not unique. Please generate another code.",
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $giftCode1 = GiftCode::create([
            'course_id'         => 1,
            'service_id'        => 1,
            'code'              => $request->input('code1'),
            'validity'          => 1,
            'email'              => $request->input('email'),
        ]);
        
        $giftCode2 = GiftCode::create([
            'course_id'         => 1,
            'service_id'        => 1,
            'code'              => $request->input('code2'),
            'validity'          => 1,
            'email'              => $request->input('email'),
        ]);

        $giftCode2->save();
        
        $email = $request->input('email');
        
        //Send Email        
        Notification::route('mail', $email)
        ->notify(new SendGiftCodeEmail($giftCode1->code, $giftCode2->code, $email));	
        
        \Session::flash(
            'success', 
            'Email succesfully sent to ' . $email . ' with the following codes: <br>
            Code 1: ' . $giftCode1->code . '<br>
            Code 2: ' . $giftCode2->code);

        return redirect('/promo-codes/create');
    }
    
    public function codeGen(Request $request)
    {
        $newcode1;
        $newcode2;

        if ($request->isMethod('POST')){            
            $codeType = $request->input('codeType');
    
            switch ($codeType){
                case 'discount':
    
                break;
                case 'buy1gift1':	
                    do {	
                        $code1 = Str::random(25);                                       
                        $code2 = Str::random(25);
                        
                        $newcode1 = "B1-" . $code1;	
                        $newcode2 = "B2-" . $code2;
    
                    } while ($this->isDuplicate($code1) == true || $this->isDuplicate($code2) == true);
            
                    return response()->json(['code1'=>$newcode1,'code2'=>$newcode2]);
                break;
                default:
            }
        }

        // do {	
        //     $code1 = Str::random(25);                                       
        //     $code2 = Str::random(25);
            
        //     $newcode1 = "B1-" . $code1;	
        //     $newcode2 = "B2-" . $code2;

        // } while ($this->isDuplicate($code1) == true || $this->isDuplicate($code2) == true);
        
        // return response()->json(['code1'=>$newcode1,'code2'=>$newcode2]);
    }

    // Returns true if Code is Duplicate
	private function isDuplicate ($code) {
        $giftCodes = GiftCode::all();
        $isDuplicate = false;
                            
        foreach ($giftCodes as $giftCode) {
            $uniqueCode = explode('-', $giftCode->code);
            if ($uniqueCode[1] == $code){
                $isDuplicate = true;
            }
        }		

		return $isDuplicate;
	}

    
}