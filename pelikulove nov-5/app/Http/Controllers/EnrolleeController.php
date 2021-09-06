<?php

namespace App\Http\Controllers;

use Notifications;
use App\Notifications\SendPaymentEmail;

use Validator;

use Auth;

use App\Models\Service;
use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LearnerCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class EnrolleeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     

    public function index()
    {
    
    	$paginationEnabled = config('usersmanagement.enablePagination');
        if ($paginationEnabled) {
            $enrollees = LearnerCourse::orderBy('created_at', 'desc')->paginate(1000);
        } else {
        	
        	$enrollees = LearnerCourse::orderBy('created_at', 'desc')->get();
           	
        }

        $completed = Lesson::getLessonCompleted();
     
        if (Auth::User()->hasPermission('view.enrollees') && (Auth::User()->hasRole('admin') || Auth::User()->hasRole('pelikulove')  ) ) { // you can pass an id or slug
    		
    		return view('enrollees.index', compact('enrollees', 'completed')); 
		}
		else 
		{
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
    public function create()
    {
        
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($course_id)
	{
		$course = Course::find($course_id);

		
		if (isset($course) > 0) :
        	$paginationEnabled = config('usersmanagement.enablePagination');
        	// if ($paginationEnabled) :
           	// 	$learners = LearnerCourse::paginate(config('usersmanagement.paginateListSize'));
        	// else :
        	
                $learners = LearnerCourse::where('course_id', $course_id)
                ->where('status', 1)
                ->orderBy('created_at', 'desc')
                ->get();
         	// endif;
        
     		
     		$completed = Lesson::getLessonCompleted($course->id);
     		
        	if (Auth::User()->hasPermission('view.enrollees')) :
    			return view('enrollees.show', ['enrollees' => $learners, 'course' => $course, 'completed' => $completed]); 
			
			else :
				return back()->with([
                 'message' => "Sorry, you have't have access to that page.",
                 'status' => 'warning']);
			endif;
		else:
			return back()->with([
                 'message' => "Sorry, course doesn't exist.",
                 'status' => 'warning']);
		endif;
			
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    	
    	
       //
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
