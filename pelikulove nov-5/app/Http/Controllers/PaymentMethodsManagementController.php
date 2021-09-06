<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use View;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodsManagementController extends Controller
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
        $paymentMethods = PaymentMethod::all();             

        return View('payment-methodsmanagement.index', compact('paymentMethods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('payment-methodsmanagement.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name'                          => 'required',
                'description'                   => 'required',
            ],
            [
                'name.required'                 => "Payment Method name is required.",
                'description.required'          => "Description of the payment method is required.",
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $service = PaymentMethod::create([
            'name'              => $request->input('name'),
            'description'       => $request->input('description'),
        ]);

        $service->save();        	
        
        \Session::flash(
            'success', 
            'Service ' . $request->input('name') . ' has been successfully created.');
            
        return redirect('payment-methods');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentMethod $paymentMethod)
    {

        return View('payment-methodsmanagement.show', compact('paymentMethod'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentMethod $paymentMethod)
    {        
        return View('payment-methodsmanagement.edit', compact('paymentMethod'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $validator = Validator::make($request->all(),
            [
                'name'                          => 'required',
                'description'                   => 'required',
            ],
            [
                'name.required'                 => "Payment Method name is required.",
                'description.required'          => "Description of the payment method is required.",
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }            
        
        $paymentMethod->name = $request->input('name');
        $paymentMethod->description = $request->input('description');

        $paymentMethod->save();
        
        \Session::flash(
            'success', 
            'Successfully updated Payment Method!');

            
        $paymentMethods = PaymentMethod::all();     
        return View('payment-methodsmanagement.index', compact('paymentMethods'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();
        
        \Session::flash(
            'success', 
            'Successfully deleted Service!');

            
        $paymentMethods = PaymentMethod::all();     
        return View('payment-methodsmanagement.index', compact('paymentMethods'));
    }

    public function upload(PaymentMethod $paymentMethod)
    {
        // if (Input::hasFile('file')) {
        //     $logo = Input::file('file');
        //     $filename = 'logo.'.$logo->getClientOriginalExtension();
        //     $save_path = storage_path() . '/payment_methods/id/' . $paymentMethod->id . '/uploads/images/logo/';
        //     $path = $save_path.$filename;
        //     $public_path = '/images/profile/'.$paymentMethod->id.'/avatar/'.$filename;

        //     // Make the user a folder and set permissions
        //     File::makeDirectory($save_path, $mode = 0755, true, true);

        //     // Save the file to the server
        //     Image::make($logo)->save($save_path.$filename);

        //     // Save the public image path
        //     $currentUser->profile->avatar = $public_path;
        //     $currentUser->profile->save();

        //     return response()->json(['path' => $path], 200);
        // } else {
        //     return response()->json(false, 200);
        // }
    }
}
