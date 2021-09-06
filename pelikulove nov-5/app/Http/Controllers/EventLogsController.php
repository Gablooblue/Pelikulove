<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use View;
use App\Models\EventLog;
use App\Models\RegisterLog;
use App\Models\User;
use jeremykenedy\LaravelRoles\Models\Role;
use Illuminate\Http\Request;

class EventLogsController extends Controller
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
        $eventlogs = RegisterLog::join('users', 'register_logs.user_id', '=', 'users.id')
        ->select('users.*')
        ->get(); 
        
        foreach ($eventlogs as $eventlog) {
            $newEventlog = EventLog::where('user_id', $eventlog->id)
            ->first();
            if (isset($newEventlog)) {
                $eventlog->referer = $newEventlog->referer;
                $eventlog->comment = $newEventlog->comment;
                $eventlog->log_id = $newEventlog->id;
            } else {
                $eventlog->referer = null;
                $eventlog->comment = null;
                $eventlog->log_id = null;
            }
        }

        // dd($services);

        return View('eventlogs.index', compact('eventlogs'));
        // return $services;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {       
        $eventlog1 = EventLog::find($id);
        
        $eventlog = EventLog::join('users', 'event_logs.user_id', '=', 'users.id')
        ->select('users.*', 'event_logs.id as log_id', 'event_logs.referer', 'event_logs.comment', 'event_logs.event')
        ->where('users.id', $eventlog1->user_id)
        ->first(); 

        return View('eventlogs.show', compact('eventlog'));
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
