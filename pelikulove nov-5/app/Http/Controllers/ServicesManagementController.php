<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use View;
use App\Models\Service;
use App\Models\Course;
use jeremykenedy\LaravelRoles\Models\Role;
use Illuminate\Http\Request;

class ServicesManagementController extends Controller
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
        $services = Service::join('courses', 'services.course_id', '=', 'courses.id')
        ->select('services.*', 'courses.title')
        ->get();                 
        $roles = Role::all();

        // dd($services);

        return View('servicesmanagement.index', compact('services', 'roles'));
        // return $services;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Course::all();

        return View('servicesmanagement.create', compact('courses'));
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
                'courseID'                      => 'required',
                'serviceName'                   => 'required|max:255',
                'description'                   => 'required',
                'amount'                        => "required|numeric|between:0.00,999999.99",
                'duration'                      => "required|max:5",
            ],
            [
                'courseID.required'             => "Choose a course for the service.",
                'serviceName.required'          => "Service name is required.",
                'description.required'          => "Description of the service is required.",
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
            
        return redirect('services');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = Service::where('services.id', $id)
        ->join('courses', 'services.course_id', '=', 'courses.id')
        ->select('services.*', 'courses.title')
        ->first(); 

        $user = Auth::user();

        return View('servicesmanagement.show', compact('service', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {        
        $courses = Course::all();

        return View('servicesmanagement.edit', compact('service', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $validator = Validator::make($request->all(),
            [
                'courseID'                      => 'required',
                'serviceName'                   => 'required|max:255',
                'description'                   => 'required',
                'amount'                        => "required|numeric|between:0.00,999999.99",
                'duration'                      => "required|max:5",
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
        
        $service->course_id = $request->input('courseID');
        $service->name = $request->input('serviceName');
        $service->description = $request->input('description');
        $service->amount = $request->input('amount');
        $service->duration = $request->input('duration');  
        // dd($service);
        $service->save();       
        
        \Session::flash(
            'success', 
            'Successfully updated Service!');
        
        $services = Service::join('courses', 'services.course_id', '=', 'courses.id')
        ->select('services.*', 'courses.title')
        ->get();                 
        $roles = Role::all();

        return View('servicesmanagement.index', compact('services', 'roles'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $service->delete();
        
        \Session::flash(
            'success', 
            'Successfully deleted Service!');
        
        $services = Service::join('courses', 'services.course_id', '=', 'courses.id')
        ->select('services.*', 'courses.title')
        ->get();                 
        $roles = Role::all();

        return View('servicesmanagement.index', compact('services', 'roles'));
    }
}
