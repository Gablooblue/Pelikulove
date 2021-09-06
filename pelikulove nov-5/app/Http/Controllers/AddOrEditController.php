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

use App\Models\Service;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Notifications;
use Validator;
use View;

class AddOrEditController extends Controller
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
                'courseID'                      => 'required',
                'serviceName'                   => 'required|max:255',
                'description'                   => 'required',
                'amount'                        => "required",
                'duration'                      => "required",
            ],
            [
                'courseID.required'             => "Choose a course for the service.",
                'serviceName.required'          => "Service name is required.",
                'description.required'          => "Description of the service is requried.",
                'amount.required'               => "The price of the service is required.",
                'duration.required'             => "Duration of the service is required.",
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $service = Service::create([
            'course_id'         => $request->input('courseID'),
            'name'              => $request->input('serviceName'),
            'description'       => $request->input('description'),
            'amount'            => $request->input('amount'),
            'duration'          => $request->input('duration'),
        ]);

        $service->save();        	
        
        \Session::flash(
            'success', 
            'Service ' . $request->input('serviceName') . ' has been successfully created.');
            
        return redirect('add-or-edit');
    }
    
    public function show(Request $request)
    {
        return view('add-or-edit/index');
    }
}