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

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class CoursesAdminManagementController extends Controller
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
    	$courses = Course::all();
    	return view('courses-adminmanagement.index', compact('courses')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return View('payment-methodsmanagement.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $validator = Validator::make($request->all(),
        //     [
        //         'name'                          => 'required',
        //         'description'                   => 'required',
        //     ],
        //     [
        //         'name.required'                 => "Payment Method name is required.",
        //         'description.required'          => "Description of the payment method is required.",
        //     ]
        // );

        // if ($validator->fails()) {
        //     return back()->withErrors($validator)->withInput();
        // }

        // $service = PaymentMethod::create([
        //     'name'              => $request->input('name'),
        //     'description'       => $request->input('description'),
        // ]);

        // $service->save();        	
        
        // \Session::flash(
        //     'success', 
        //     'Service ' . $request->input('name') . ' has been successfully created.');
            
        // return redirect('payment-methods');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show($course_id)
    {
        $course = Course::findorfail($course_id);
        $instructors = InstructorCourse::where('course_id', $course_id)
        ->get();        
     	$lessons = array();
       
        if (isset($course)) :
            $ls = Lesson::getLessons($course_id);
            
            foreach ($ls as $lesson) :
                // Get First Topic ID even if first topic id is 2
                $f = Topic::getFirstTopic($lesson->id);
                if (isset($f)) :
                    $first = $f->id;
                else:
                    $first = 1;	
                endif;

                $lessons[$lesson->id] = array(
                    'title' => $lesson->title, 
                    'description' => $lesson->description, 
                    'duration' => $lesson->duration, 
                    'first' => $first, 
                    'file' => $lesson->file , 
                    'premium' => $lesson->premium, 
                    'count' => $lesson->topics()->count()
                );            
            endforeach;            
        else:       			
            return back()->with('danger', 'Course does not exist.');		
        endif;

        return view('courses-adminmanagement.show', compact('course', 'instructors', 'lessons')); 
        
    	// $courses = Course::all();
    	// return view('courses-adminmanagement.index', compact('courses')); 
    }

    public function showLesson($course_id, $lesson_id)
    {              
        $course = Course::findorfail($course_id);
        $lesson = Lesson::findorfail($lesson_id);

        $topics = Topic::where('course_id', $course->id)
        ->where('lesson_id', $lesson_id)
        ->orderBy('torder', 'asc')
        ->get();   

        // dd($course, $lesson, $topics);        
                  
        if (!isset($course)) : 
            return back()->with('danger', 'Course does not exist.');
        endif; 
        
        if (!isset($lesson)) : 
            return back()->with('danger', 'Lesson does not exist.');   
        endif;
                            
        if (!isset($topics)) : 
            return back()->with('danger', 'Topic does not exist.');            
        endif;

        return view('courses-adminmanagement.show-lesson', compact('topics', 'lesson', 'course')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentMethod $paymentMethod)
    {        
        // return View('payment-methodsmanagement.edit', compact('paymentMethod'));
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
        // $validator = Validator::make($request->all(),
        //     [
        //         'name'                          => 'required',
        //         'description'                   => 'required',
        //     ],
        //     [
        //         'name.required'                 => "Payment Method name is required.",
        //         'description.required'          => "Description of the payment method is required.",
        //     ]
        // );

        // if ($validator->fails()) {
        //     return back()->withErrors($validator)->withInput();
        // }            
        
        // $paymentMethod->name = $request->input('name');
        // $paymentMethod->description = $request->input('description');

        // $paymentMethod->save();

        // return back()->with('success', 'Successfully updated Payment Method!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        // $paymentMethod->delete();
        // return back()->with('success', 'Successfully deleted Service!');
    }
}
