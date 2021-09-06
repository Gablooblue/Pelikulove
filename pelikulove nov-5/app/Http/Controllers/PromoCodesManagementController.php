<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\GiftCode;
use App\Models\PromoCode;
use App\Models\Course;
use App\Models\Service;
use App\Models\Order;
use App\Models\Vod;
use App\Models\VodTimeCode;
use App\Notifications\SendGiftCodeEmail;
use App\Notifications\SendVodTimeCodeEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Notifications;
use Validator;
use View;
use Auth;

class PromoCodesManagementController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $giftcodes = GiftCode::join('courses', 'gift_codes.course_id', '=', 'courses.id')
        ->join('services', 'gift_codes.service_id', '=', 'services.id')
        ->select('gift_codes.*', 'courses.title as course_title', 'services.name as service_name')
        ->get();    
        
        $promocodes = PromoCode::join('courses', 'promo_codes.course_id', '=', 'courses.id')
        ->join('services', 'promo_codes.service_id', '=', 'services.id')
        ->select('promo_codes.*', 'courses.title as course_title', 'services.name as service_name')
        ->get();               

        $codes = collect();    

        foreach ($promocodes as $promocode) {
            $codes->push($promocode);
        }

        foreach ($giftcodes as $giftcode) {
            $codes->push($giftcode);
        }           

        // $codes = $giftcodes->merge($promocodes)
        // ->sortByDesc('created_at')
        // ->values()
        // ->all();

        // dd($codes);        
                    
        return view('promocodesmanagement/index', compact('codes'));
    }
   
    public function create()
    {
        $giftCodes = GiftCode::all();
        $courses = Course::all();
        $services = Service::all();
        $vods = Vod::where('private', 1)
        ->get();
        $vtc = VodTimeCode::where('ends_at', '>', Carbon::now())
        ->orderBy('id', 'asc')
        ->get();

        return view('promocodesmanagement/create', compact('giftCodes', 'courses', 'services', 'vods', 'vtc'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function storeGift(Request $request)
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

        // Reserve the codes in Order Table
        // Done to include the payment in the summary on time

        $user = Auth::user();       
        $transaction_id = $user->user_id.time().mt_rand(10000000,99999999);

        $exist = Order::where('transaction_id', $transaction_id)->first();
        while (isset($exist)) {
            $transaction_id = Auth::User()->id.time().mt_rand(10000000,99999999);
            $exist = Order::where('transaction_id', $transaction_id)->first();
        }    

        $mytime = Carbon::now();
        $mytime = str_replace(' ', '-', $mytime->toDateTimeString());
                        
        $order1 = new Order;
        $order1->user_id = 0;
        $order1->transaction_id = $transaction_id;                       
        $order1->ref_no ='Ticket2Me-B1-' . $mytime;
        $order1->payment_status = 'S';
        $order1->payment_id = 7;           
        $order1->service_id = 2;
        $order1->code = $giftCode1->code;
        $order1->billable = 1;        
        $order1->amount = floatval(1999);
                        
        $order2 = new Order;
        $order2->user_id = 0;
        $order2->transaction_id = $transaction_id;                       
        $order2->ref_no ='Ticket2Me-B2-' . $mytime;
        $order2->payment_status = 'S';
        $order2->payment_id = 7;           
        $order2->service_id = 2;
        $order2->code = $giftCode2->code;
        $order2->billable = 1;        
        $order2->amount = floatval(0);

        $order1->save();
        $order2->save();
        
        //Send Email        
        Notification::route('mail', $email)
        ->notify(new SendGiftCodeEmail($giftCode1->code, $giftCode2->code, $email));	
        
        \Session::flash(
            'success', 
            'Email succesfully sent to ' . $email . ' with the following codes: <br>
            Code 1: ' . $giftCode1->code . '<br>
            Code 2: ' . $giftCode2->code);

        return redirect('/promo-codes/create');
        // return redirect('/promocodesmanagement');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function storeTimePromo(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'code'                          => 'required|unique:promo_codes,code',
                'course_id'                     => 'required',
                'service_id'                    => "required",
                'amount'                        => "required",
                'start_date'                    => "required",
                'end_date'                      => "required",
            ],
            [
                'code'                          => 'Code Name is required.',
                'course_id'                     => 'Course is required.',
                'service_id'                    => "Service is required.",
                'amount'                        => "Amount is required.",
                'start_date'                    => "Start date is required.",
                'end_date'                      => "End date is required.",
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $promoCode = PromoCode::create([
            'code'                          => $request->input('code'),
            'course_id'                     => $request->input('course_id'),
            'service_id'                    => $request->input('service_id'),
            'amount'                        => $request->input('amount'),
            'start_date'                    => $request->input('start_date'),
            'end_date'                      => $request->input('end_date'),
        ]);

        $promoCode->save();
        
        \Session::flash(
            'success', 
            'Promo Code: ' . $promoCode->code . ' has been successfully created. Usable from ' 
            . $promoCode->start_date . ' to ' . $promoCode->end_date . '.');

        return redirect('/promo-codes/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function showGiftCode($id)
    {
        $code = GiftCode::findorfail($id);
        if (!isset($code)) {
            return redirect('/promocodesmanagement/create')
            ->with('danger', 'Giftcode does not exist.');
        }
        $course = Course::find($code->course_id);
        $service = Service::find($code->service_id);
        $user = User::find($code->user_id);

        return view('promocodesmanagement/show-giftcode', compact('code', 'service', 'course', 'user'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function showPromoCode($id)
    {
        $code = PromoCode::findorfail($id); 
        if (!isset($code)) {
            return redirect('/promocodesmanagement/create')
            ->with('danger', 'Promocode does not exist.');
        }
        $course = Course::find($code->course_id);
        $service = Service::find($code->service_id);

        return view('promocodesmanagement/show-promocode', compact('code', 'service', 'course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function editPromoCode($promocode_id)
    {        
        $code = PromoCode::join('courses', 'promo_codes.course_id', '=', 'courses.id')
        ->join('services', 'promo_codes.service_id', '=', 'services.id')
        ->select('promo_codes.*', 'courses.title as course_title', 'services.name as service_name')
        ->where('promo_codes.id', $promocode_id)
        ->first(); 

        if (!isset($code))
        return redirect('/promocodesmanagement')
        ->with('danger', 'Promocode does not exist.');

        // dd($code);

        return View('promocodesmanagement/edit', compact('code'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function updatePromoCode(Request $request, $promocodeID)
    {
        $validator = Validator::make($request->all(),
            [
                'code'                          => 'required',
                'course_id'                     => 'required',
                'service_id'                    => "required",
                'amount'                        => "required",
                'start_date'                    => "required",
                'end_date'                      => "required",
            ],
            [
                'code'                          => 'Code Name is required.',
                'course_id'                     => 'Course is required.',
                'service_id'                    => "Service is required.",
                'amount'                        => "Amount is required.",
                'start_date'                    => "Start date is required.",
                'end_date'                      => "End date is required.",
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $promocode = PromoCode::find($promocodeID);
        $oldDate = $promocode->end_date;

        if (!isset($promocode))
        return redirect('/promocodesmanagement')
        ->with('danger', 'Promocode does not exist.');
                
        $promocode->end_date = $request->input('end_date');

        $promocode->save();
        
        \Session::flash(
            'success', 
            'Successfully extended Promocode: ' . $promocode->code . ' from '
             . $oldDate . ' to ' . $promocode->end_date . '.');

        return redirect('/promo-codes/' . $promocode->id . '/editPromoCode');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function storeTimeVod(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'code'                          => 'required|unique:vod_time_codes,code',
                'vod_id'                        => 'required',
                'start_date'                    => "required",
                'end_date'                      => "required",
            ],
            [
                'code.required'                 => "Vod Time Code is required.",
                'code.unique'                   => "Vod Time Code '" . $request->input('code') . "' already exists",
                'vod_id.required'               => "Vod is required.",
                'start_date.required'           => "Start Date is required.",
                'end_date.required'             => "End Date is required.",
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $vodTimeCode = VodTimeCode::create([
            'code'                          => $request->input('code'),
            'vod_id'                        => $request->input('vod_id'),
            'starts_at'                    => $request->input('start_date'),
            'ends_at'                      => $request->input('end_date'),
        ]);

        $vodTimeCode->save();                       
        
        \Session::flash(
            'success', 
            'Vod Time Code: ' . $vodTimeCode->code . ' has been successfully created. Usable from ' 
            . Carbon::parse($vodTimeCode->starts_at)->toDayDateTimeString() . 
            ' to ' . Carbon::parse($vodTimeCode->ends_at)->toDayDateTimeString() . '.');

        return redirect('/promo-codes/create');
    }

    public function sendTimeVod (Request $request) {     
        $validator = Validator::make($request->all(),
            [
                'vtc_id'                          => 'required',
                'emails'                        => "required",
            ],
            [
                'vtc_id.required'                 => "Vod Time Code is required.",
                'emails.required'               => "Email(s) is required.",
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $emails = $request->input('emails');
        $emailsWithoutSpaces = preg_replace('/\s/', '', $emails);
        $emailsSplit = explode(",",$emailsWithoutSpaces);

        $vodTimeCode = VodTimeCode::find($request->input('vtc_id'));

        foreach($emailsSplit as $email) {
            Notification::route('mail', $email)
            ->notify(new SendVodTimeCodeEmail($vodTimeCode, $email));
        }     
        
        \Session::flash(
            'success', 
            'Vod Time Code: ' . $vodTimeCode->code . ' has been successfully sent to ' . sizeof($emailsSplit) . ' email(s).');

        return redirect('/promo-codes/create');   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit ()
    {        
        // dd("asd");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update (Request $request, PaymentMethod $paymentMethod)
    {
        //
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy($code_id)
    {
        $code = GiftCode::find($code_id);
        $code->delete();

        return redirect()->route('promo-codes')->with(['message' => "Successfuly removed Code: " . $code->code, 'status' => 'success']);
    }

    
}