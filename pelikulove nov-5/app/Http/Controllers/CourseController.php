<?php

namespace App\Http\Controllers;


use Auth;
use App\Models\Course;
use App\Models\LearnerCourse;
use App\Models\Lesson;
use App\Models\Order;
use App\Models\Service;
use App\Models\Topic;
use App\Models\Instructor;
use App\Models\InstructorCourse;
use App\Models\CourseSlideshow;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class CourseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
	
    public function catalog()
    {
		$courses = Course::where('id', '!=', 2)
		->get();

		// dd($courses);

		return view('courses.catalog', compact('courses'));    	
    }
    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function index() {
    	$courses = Course::all();
    	return view('courses.index', ['courses' => $courses]); 
    	
  
    } 
 
 	/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    
    	if (Auth::User()->hasPermission('create.courses'))  :
        		 
    			return view('course.create'); 
			
		else :
				 return back()->with([
                 'message' => "Sorry, you have't have access to that page.",
                 'status' => 'warning' ]);
		endif;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'name'     => 'required',
                'description' => 'required',
                'credentials' => 'required',
                'course_id' => 'required',
            ]);
            
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $data['name'] = $request->input('name');
    	$data['description']  = $request->input('description');
        $data['credentials']  = $request->input('credentials');
        $data['course_id']  = $request->input('course_id');
     	$instructor = Instructor::saveInstructor($data);
			
			
        if ($instructor->id) :
        	$data['instructor_id']  = $instructor->id;
        	$instructor1 = InstructorCourse::saveInstructorCourse($data);
        	
        	return back()->with('success', 'Mentor successfully created.');
         else:
         	return back()->with('error', 'Error in creating mentor.');
         endif; 
    
    }
    
    public function show2($course_id)
    {

    	$first = 1;
    	$course = Course::find($course_id);
     	$instructors = array();
     	$lessons = array();
  		$f = array();
       
    	if (isset($course) > 0 ) :
       		$ls = Lesson::getLessons($course_id);
       		
       		foreach ($ls as $lesson) :
       			$f = Topic::getFirstTopic($lesson->id);
       			if (isset($f) > 0) :
       				$first = $f->id;
       			else:
       				$first = 1;	
       			endif;
       			$lessons[$lesson->id] = array('title' => $lesson->title, 'description' => $lesson->description, 'duration' => $lesson->duration, 'first' => $first, 'file' => $lesson->file , 
       			'premium' => $lesson->premium, 'count' => $lesson->topics()->count());
       		
       		endforeach;
           	$instructors = Instructor::where('course_id', $course_id)->where('id', 1)->get();
       		
       else:
       		
       		return back()->with('danger', 'Course does not exist.');		
       endif;
       
      
       return view('courses.show', compact('course', 'instructors', 'lessons')); 
    
    }
    
    // correct one
     public function show($course_id)
    {		    
		$courseSlideshow = CourseSlideshow::where('course_id', $course_id)
		->orderBy('order')
		->get();
    	$first = 1;
    	$course = Course::find($course_id);
     	$instructors = array();
     	$lessons = array();
  		$f = array();
		$completed = array();
       
		if (isset($course)) :
			if ($course->private == 1) {	
				if (!Auth::check()) {
					// return back()->with('danger', 'Course is private.');
					return redirect()->back()
					->with(['message' => 'The Course you are trying to access is private.', 
					'status' => 'danger']);	
				}	
				$enrolled = LearnerCourse::ifEnrolled($course_id, Auth::user()->id);
				if (!$enrolled) {
					// return back()->with('danger', 'Course is private.');
					return redirect()->back()
					->with(['message' => 'The Course you are trying to access is private.', 
					'status' => 'danger']);	
				}
			}

       		$ls = Lesson::getLessons($course_id);
       		
       		if (Auth::check()) $completed = Lesson::getLessonCompletedbyUser(Auth::user()->id, $course_id);
       		
       		foreach ($ls as $lesson) :
       			$f = Topic::getFirstTopic($lesson->id);
       			if (isset($f)) :
       				$first = $f->id;
       			else:
       				$first = 1;	
       			endif;
       			$lessons[$lesson->id] = array('title' => $lesson->title, 'description' => $lesson->description, 'duration' => $lesson->duration, 'first' => $first, 'file' => $lesson->file , 
       			'premium' => $lesson->premium, 'count' => $lesson->topics()->count());
       		
       		endforeach;
           	$instructors = InstructorCourse::where('course_id', $course_id)->get();
       		
       else:
       			
       		return redirect()->back()
			   ->with(['message' => 'Course is private.', 
			   'status' => 'danger']);	
       endif;
	   
	//    dd($instructors);
      
		
		switch ($course_id) {
			case 3:
				// return view('courses.show-ricky-lee', compact('course', 'instructors', 'lessons', 'completed', 'courseSlideshow')); 
				return view('courses.show-rickylee', compact('course', 'instructors')); 
				break;
			
			default:
				return view('courses.show', compact('course', 'instructors', 'lessons', 'completed', 'courseSlideshow')); 
				break;
		}  
    
	}
	
    public function stats($course_id)
    {
    	$course = Course::find($course_id);
    	$stats = Lesson::getLessonStats($course_id);
    	$ls = Lesson::getLessons($course_id);
    	$completed = Lesson::getLessonCompleted($course_id);
    	$cstats = array();
    	
    	
    	
		foreach ($ls as $lesson) :
			if (isset($lesson)) {
				$f = Topic::getFirstTopic($lesson->id);
				$cstats[$lesson->id] = 0;
				if (isset($f) > 0) :
					$first = $f->id;
				else:
					$first = 1;	
				endif;
				$lessons[$lesson->id] = array('title' => $lesson->title, 'duration' => $lesson->duration, 'first' => $first);
			}
       			
       	endforeach;
		   
		// dd($completed);

		// if (isset($completed)) {
		// 	foreach ($completed[$course_id] as $key => $value ) :
		// 		$c = count($completed[$course_id][$key]);
		// 		dd($c, $cstats);		
		// 		$cstats[$c] += 1 ;				
		// 	endforeach;
		// }
    	
    	$services = Service::where('course_id', '=', $course_id)->get();
    	$learners = LearnerCourse::selectRaw('COUNT(id) as count,  YEAR(created_at) year, MONTH(created_at) month')->groupby('year','month')->where('course_id', '=', $course_id)->where('status', 1)->orderBy('month')->get();

    	$orders = Order::join('services', 'services.id', '=', 'orders.service_id')->where('orders.payment_status', '=', 'S')->where('services.course_id', '=', $course_id)->get();
    	
    	
    	return view('courses.stats', compact('course', 'stats' , 'lessons', 'learners', 'orders', 'services')); 
   
    }
	
    public function rkGuidelines()
    {    	
		$course = Course::find(3);
		
    	return view('courses.rk-guidelines', compact('course'));    
    }
	
    public function rkGroupings()
    {    	
		$course = Course::find(3);
		
    	return view('courses.rk-groupings', compact('course'));    
    }
	
}
