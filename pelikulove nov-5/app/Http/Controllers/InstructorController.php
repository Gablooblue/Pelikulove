<?php

namespace App\Http\Controllers;


use Validator;

use Auth;

use App\Models\User;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\LearnerCourse;
use Illuminate\Http\Request;


class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     

    public function index()
    {
    
    	$pagintaionEnabled = config('usersmanagement.enablePagination');
        if ($pagintaionEnabled) {
            $instructors = Instructor::paginate(config('usersmanagement.paginateListSize'));
        } else {
            $instructors = Instructor::instructorBy('created_at', 'desc')->get();;
        }
        
       
        
        return view('instructors.index', ['instructors' => $instructors]); 
		
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$courses = Course::all();
    	
          if (Auth::User()->hasPermission('create.instructors'))  :
        		 
    			return view('instructors.create', ['courses' => $courses]); 
			
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
        	return back()->with('success', 'Mentor successfully created.');
         else:
         	return back()->with('error', 'Error in creating mentor.');
         endif; 
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\instructor  $instructor
     * @return \Illuminate\Http\Response
     */
    public function show($id)
	{
        $instructor = Instructor::find($id);
       
        
        if (isset($instructor)) :
            $course = Course::find($instructor->course_id);
            // dd($course);           
            if ($course->id == 3) {
                // if (LearnerCourse::ifEnrolled(3, Auth::user()->id)) {     
                    return view('mentors.show-rickylee', compact('instructor', 'course'));    
                // } else {
                //     return redirect()->back()->with(['message' => "Instructor Profile is private", 'status' => 'danger']);
                // }          
            }
        	return view('mentors.show', compact('instructor', 'course')); 
			
        else:
        	return redirect()->back()->with(['message' => "Instructor not found", 'status' => 'danger']);
        endif;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\instructor  $instructor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $instructor = Instructor::find($id);
        
        
        if (count($instructor) < 1 ) :
        	
			 return redirect()->back()->with(['message' => "Invalid Instructor ID", 'status' => 'danger'
       		]);
       else :
        	if (Auth::User()->hasPermission('edit.instructors'))  :
        	
    			return view('instructors.edit', ['instructor' => $instructor, 'users' => $users, 'payments' => $payments, 'services' => $services]); 
			
			else :
				 return back()->with([
                 'message' => "Sorry, you have't have access to that page.",
                 'status' => 'warning' ]);
			endif;
		endif;	
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\instructor  $instructor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
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
        
        $instructor = Instructor::find($request->input('id'));
        
        if ($instructor) :
        	$data['name'] = $request->input('name');
    		$data['description']  = $request->input('description');
        	$data['credentials']  = $request->input('credentials');
        	$data['course_id']  = $request->input('course_id');
     		$saved = Instructor::updateInstructor($data);
			
			
        	if ($saved) :
        		
        		
        		return back()->with('success', 'Mentor successfully updated');
        	else:
        		return back()->with('error', 'Error in updating mentor.');
        	endif;	 
         else:
         	return back()->with('error', 'Invalid Instructor ID');
         endif;   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\instructor  $instructor
     * @return \Illuminate\Http\Response
     */
    public function destroy(instructor $instructor)
    {
        //
    }
}
