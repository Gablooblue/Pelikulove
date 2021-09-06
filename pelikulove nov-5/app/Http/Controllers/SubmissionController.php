<?php

namespace App\Http\Controllers;


use Auth;
use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Submission;
use App\Models\Topic;
use App\Models\LearnerCourse;
use App\Models\Instructor;
use App\Models\InstructorCourse;
use App\Notifications\SendSaluhanSubmissionNotif;
use jeremykenedy\LaravelRoles\Models\Role;

use Illuminate\Http\Request;
use Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;

use Validator;

class SubmissionController extends Controller
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
	
    public function catalog()
    {
		$courses = Course::where('id', '!=', 2)
		->get();

		// dd($courses);

		return view('submissions.catalog', compact('courses'));    	
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */     
    public function index($course_id) {
		$course = Course::find($course_id);
    	$roles = Role::all();
    	
    	$submissions = null;
    	$lessons = null;
  		
  		if (isset($course)) :
    	
			if (!LearnerCourse::ifEnrolled($course_id, Auth::user()->id)) :
					  \Session::flash('message', "Sorry, you don't have access to this course. Please enroll <a href=".route('course.enroll', $course->id).">NOW</a>.");
					  \Session::flash('status', "warning");
					  return redirect()->route('course.show', $course_id);
			  endif;	
			$ls = Lesson::where('course_id', $course_id)
			  		->where('submission', 1)
					->orderBy('lorder', 'asc')
					->get();
       		
       		foreach ($ls as $lesson) :
       			$f = Topic::getFirstTopic($lesson->id);
       			if (isset($f)) :
       				$first = $f->id;
       			else:
       				$first = 1;	
       			endif;
				   $lessons[$lesson->id] = array('title' => $lesson->title, 'description' => $lesson->description, 'duration' => $lesson->duration, 'first' => $first, 'file' => $lesson->file );
				   
				if (Auth::user()->hasRole(['admin', 'pelikulove', 'rl-reader'])) {
					$submissions[$lesson->id] =	Submission::where('lesson_id', '=', $lesson->id )
					->orderBy('created_at' , 'DESC')
					->take(4)
					->get();
				} else {
					if (Auth::user()->hasRole('mentor')) {
						$instructor = Instructor::where('user_id', Auth::user()->id)
						->first();
						if (isset($instructor)) {
							$instructorCourse = InstructorCourse::where('course_id', $course->id)
							->where('instructor_id', $instructor->id)
							->first();
				
							if (isset($instructorCourse)) {
								$submissions[$lesson->id] =	Submission::where('lesson_id', '=', $lesson->id )
								->orderBy('created_at' , 'DESC')
								->take(4)
								->get();
							} else {
								$privateSubmissions = Submission::where('lesson_id', '=', $lesson->id )
									->where('private', 1)
									->where('user_id', Auth::user()->id)
									->orderBy('created_at' , 'DESC')
									->take(4)
									->get();  
								$allSubmissions = Submission::where('lesson_id', '=', $lesson->id )
									->where('private', 0)
									->orderBy('created_at' , 'DESC')
									->take(4)
									->get();
								$submissions[$lesson->id] =	$privateSubmissions->merge($allSubmissions)->slice(0,4);
							}
						} else {
							$privateSubmissions = Submission::where('lesson_id', '=', $lesson->id )
								->where('private', 1)
								->where('user_id', Auth::user()->id)
								->orderBy('created_at' , 'DESC')
								->take(4)
								->get();  
							$allSubmissions = Submission::where('lesson_id', '=', $lesson->id )
								->where('private', 0)
								->orderBy('created_at' , 'DESC')
								->take(4)
								->get();
							$submissions[$lesson->id] =	$privateSubmissions->merge($allSubmissions)->slice(0,4);
						}
					} else {
						$privateSubmissions = Submission::where('lesson_id', '=', $lesson->id )
							->where('private', 1)
							->where('user_id', Auth::user()->id)
							->orderBy('created_at' , 'DESC')
							->take(4)
							->get();  
						$allSubmissions = Submission::where('lesson_id', '=', $lesson->id )
							->where('private', 0)
							->orderBy('created_at' , 'DESC')
							->take(4)
							->get();
						$submissions[$lesson->id] =	$privateSubmissions->merge($allSubmissions)->slice(0,4);
					}
				}
					
				// dd($submissions[$lesson->id]);	
       		endforeach;
    		return view('submissions.index', compact('course', 'lessons', 'submissions', 'roles'));    	
    	else:
    		return back()->with([
                 'message' => "Course does not exist.",
                 'status' => 'danger' ]);
    	endif;
    } 
 
 	/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($lesson_id)
    {
    	$lesson = Lesson::find($lesson_id);
    	
    	if (!LearnerCourse::ifEnrolled($lesson->course_id, Auth::user()->id)) :
  				\Session::flash('message', "Sorry, you don't have access to this course. Please enroll <a href=".route('course.enroll', $lesson->course->id).">NOW</a>.");
  				\Session::flash('status', "warning");
  				return redirect()->route('course.show', $lesson->course_id);
  		endif;
  		return view('submissions.create', ['lesson' => $lesson]);    
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
                'title'     => 'required|max:100',
                'description' => 'required|max:400',
                'lesson_id' => 'required',
                'file' => 'required|mimes:jpeg,jpg,png,doc,docx,gif,pdf|max:6000',
            ]);
            
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
		}    
       
        $data = $request->all();
        
        $lesson = Lesson::find($data['lesson_id']);
        
        if ($request->hasFile('file') && isset($lesson)) {
        	$filename =  $lesson->course->short_title . "_" . $lesson->id . "_" . time() . "." . $request->file->getClientOriginalExtension();
			
			$data['file'] = $filename;
        	
        	$request->file->storeAs('submissions/' . Auth::user()->id, $data['file']);
           	
    	}
        
		$submission = Submission::saveSubmission($data);
		
		if ($submission) :   
			$submission = Submission::find($submission);

			$instructorCourse = InstructorCourse::where('course_id', $lesson->course_id)
			->first();
			$instructor = Instructor::find($instructorCourse->instructor_id);
	
			$receiver = User::find($instructor->user_id);
			$sender = Auth::User();
			$lessonURL = url('/submissions/show/'.$lesson->id);
			$submissionURL = url('/submission/' . $submission->id . '/show');
			$type = "SaluhanSubmissionPost";
			$fileURL = storage_path('app/submissions/' . $submission->user_id."/".$submission->file);
	
			$notifData = collect([
				'sender' => $sender,
				'lessonURL' => $lessonURL,
				'submissionURL' => $submissionURL,
				'fileURL' => $fileURL,
				'submission' => $submission,
				'type' => $type,
				'lesson' => $lesson,
			]);

			Notification::send($receiver, new SendSaluhanSubmissionNotif($notifData));

			return back()->with('success', 'File upload successfully added.');
		else:
			return back()->with('error', 'Error in uploading file.');
		endif;     
    }
    
    public function show($lesson_id)
    {
    	$submission = null;
		$lesson = Lesson::find($lesson_id);
		$course = Course::find($lesson->course_id);
		if (Auth::user()->hasRole(['admin', 'pelikulove', 'rl-reader'])) {
			$submissions = Submission::where('lesson_id', '=', $lesson->id )
			->orderBy('created_at' , 'DESC')
			->get();
		} else {
			if (Auth::user()->hasRole('mentor')) {
				$instructor = Instructor::where('user_id', Auth::user()->id)
				->first();

				if (isset($instructor)) {
					$instructorCourse = InstructorCourse::where('course_id', $course->id)
					->where('instructor_id', $instructor->id)
					->first();
		
					if (isset($instructorCourse)) {
						$submissions = Submission::where('lesson_id', '=', $lesson->id )
						->orderBy('created_at' , 'DESC')
						->get();
					} else {
						$privateSubmissions = Submission::where('lesson_id', '=', $lesson->id )
							->where('private', 1)
							->where('user_id', Auth::user()->id)
							->orderBy('created_at' , 'DESC')
							->get();  
						$allSubmissions = Submission::where('lesson_id', '=', $lesson->id )
							->where('private', 0)
							->orderBy('created_at' , 'DESC')
							->get();
						$submissions = $privateSubmissions->merge($allSubmissions);
					}
				} else {
					$privateSubmissions = Submission::where('lesson_id', '=', $lesson->id )
						->where('private', 1)
						->where('user_id', Auth::user()->id)
						->orderBy('created_at' , 'DESC')
						->get();  
					$allSubmissions = Submission::where('lesson_id', '=', $lesson->id )
						->where('private', 0)
						->orderBy('created_at' , 'DESC')
						->get();
					$submissions = $privateSubmissions->merge($allSubmissions);
				}
			} else {
				$privateSubmissions = Submission::where('lesson_id', '=', $lesson->id )
					->where('private', 1)
					->where('user_id', Auth::user()->id)
					->orderBy('created_at' , 'DESC')
					->get();  
				$allSubmissions = Submission::where('lesson_id', '=', $lesson->id )
					->where('private', 0)
					->orderBy('created_at' , 'DESC')
					->get();
				$submissions = $privateSubmissions->merge($allSubmissions);
			}
		}
    
    	// if (count($submissions) > 0 ) :	
    		return view('submissions.show', ['submissions' => $submissions, 'lesson' => $lesson]); 
    	
    	// else :
    		
    	// 	return redirect()->route('submissions', $lesson->course_id)->with([
        //          'message' => "No Uploads for Lesson.",
        //          'status' => 'danger' ]);
    	// endif;
    }
    
     public function show2($id)
    {
    	$submission = null;
    	
		$submission = Submission::find($id);

		if (!isset($submission)) {
    		return redirect()->back()->with([
                 'message' => "Submission does not exist.",
                 'status' => 'danger' ]);
		}

		$lesson = Lesson::find($submission->lesson_id);
		$course = Course::find($lesson->course_id);
		
		if ($submission->private == 1) {
			if ($submission->user_id == Auth::user()->id || Auth::user()->hasRole(['admin', 'pelikulove', 'rl-reader'])) {
				
			} else if (Auth::user()->hasRole('mentor')) {
				$instructor = Instructor::where('user_id', Auth::user()->id)
				->first();
				if (isset($instructor)) {
					$instructorCourse = InstructorCourse::where('course_id', $course->id)
					->where('instructor_id', $instructor->id)
					->first();	
	
					if (!isset($instructorCourse)) {
						return redirect()->route('submissions.show', $lesson->id)->with([
							 'message' => "Submission is private.",
							 'status' => 'danger' ]);
					}
				} else {
					return redirect()->route('submissions.show', $lesson->id)->with([
						 'message' => "Submission is private.",
						 'status' => 'danger' ]);
				}
			} else {
				return redirect()->route('submissions.show', $lesson->id)->with([
					 'message' => "Submission is private.",
					 'status' => 'danger' ]);
			}
		}
        
        // Check for Unread Notifs
        $notifications = auth()->user()->unreadNotifications;
        
        foreach ($notifications as $notification) {
            if (isset($notification->data['submission_id'])) {
				if ($notification->data['submission_id'] == $id) {					
					$notification->markAsRead();
				}
            }
		}
		
		return view('submissions.show2', ['submission' => $submission]); 
    }
    
     public function edit($id)
    {
    	$submission = null;
    	$submission = Submission::find($id);
		$lesson = Lesson::find($submission->lesson_id);
    
    	if (isset($submission)) :	
    		if (Auth::user()->id != $submission->user_id) :
    			\Session::flash('message', 'You have no permission to edit this.'); 
    			\Session::flash('status', "error");
    			return redirect()->route('submissions',['course_id' => $submission->course_id]);
    		endif;    		
    		return view('submissions.edit', compact('submission', 'lesson'));     	
    	else :
    		return back()->with([
                 'message' => "Submission does not exist.",
                 'status' => 'danger' ]);
    	endif;
    }
    
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'title'     => 'required|max:100',
                'description' => 'required|max:400',
                'file' => 'nullable|mimes:jpeg,jpg,png,doc,docx,gif,pdf|max:6000',
            ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
		}
		
        $data = $request->all();
        
        $submission = Submission::find($data['id']);
        
        if (isset($submission)) :	
        	$lesson = Lesson::find($submission->lesson_id);
        	
        	if ($request->hasFile('file') && isset($lesson)) :
        		if ($request->file('file')->getSize() > 6000000) :
        			return back()->with([
                	'message' => "File is too large. Please upload another file.",
                 	'status' => 'danger' ]);
				endif;
				
        		$filename =  $lesson->course->short_title . "_" . $lesson->id . "_" . time() . ".".$request->file->getClientOriginalExtension();
			
				$data['file'] = $filename;
        	
        		$request->file->storeAs('submissions/' . Auth::user()->id , $data['file']);
    	
    		else :
            	$data['file'] = $data['ofile'];
        	endif;        
    		
      		$id = Submission::updateSubmission($data);
	    	if ($id) :
        		return back()->with('success', 'File submission successfully updated.');
         	else:
         		return back()->with('danger', 'Error in file submission.');
         	endif; 
         else:
         	
    		return back()->with([
                 'message' => "Submission does not exist.",
                 'status' => 'danger' ]);
         endif;	    
    }
    
	public function view($uuid)
	{
		$size = null;
   	 	$submission = Submission::where('uuid', $uuid)->firstOrFail();

		if (!isset($submission)) {
			return redirect()->back()->with([
				'message' => "Submission does not exist.",
				'status' => 'danger' ]);
		}

    	$pathToFile = storage_path('app/submissions/' . $submission->user_id."/".$submission->file);
    	$url = Storage::url($submission->user_id. "/" .$submission->file);

		$size = getImageSize($pathToFile);
		
       /* $mimeType = mime_content_type($pathToFile);
    	
    	$headers = array(
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="'.$submission->file.'"'
        );
         return Response::make(file_get_contents($pathToFile), 200, $headers);
         
         
        */
        
        //return response()->download(storage_path("app/submissions/".$submission->user_id."/".$submission->file), null, [], null);
		return view('submissions.view', ['submission' => $submission, 'url' => $url, 'path' => $pathToFile]); 
	}

	public function download ($uuid) {
		$submission = Submission::where('uuid', $uuid)->firstOrFail();
		$pathExt = explode(".",$submission->file);
		if (isset($submission)) {
			$lesson = Lesson::find($submission->lesson_id);
			if (Auth::user()->hasRole(['admin', 'pelikulove'])) {
				$pathToFile = storage_path('app/submissions/' . $submission->user_id."/".$submission->file);	
				$pathExt = explode(".",$submission->file);
				$newFileName = $submission->title . "." . $pathExt[sizeof($pathExt)-1];
				return response()->download($pathToFile, $newFileName);
	
			} else if (Auth::user()->hasRole('rl-reader')) {
				if ($lesson->course_id == 3) {
					$pathToFile = storage_path('app/submissions/' . $submission->user_id."/".$submission->file);
					$pathExt = explode(".",$submission->file);
					$newFileName = $submission->title . "." . $pathExt[sizeof($pathExt)-1];
					return response()->download($pathToFile, $newFileName);
	
				} else {         	
					return redirect()->route(['submission.view', $uuid])->with([
						'message' => "User does not have access to this function",
						'status' => 'danger' ]);
				}
			} else if (Auth::user()->hasRole('mentor')) {
				$instructor = Instructor::where('user_id', Auth::user()->id)
				->first();
				if (isset($instructor)) {					
					$instructorCourse = InstructorCourse::where('course_id', $lesson->course_id)
					->where('instructor_id', $instructor->id)
					->first();
					if (isset($instructorCourse)) {		
						$pathToFile = storage_path('app/submissions/' . $submission->user_id."/".$submission->file);	
						$pathExt = explode(".",$submission->file);
						$newFileName = $submission->title . "." . $pathExt[sizeof($pathExt)-1];
						return response()->download($pathToFile, $newFileName);
					} else {
						return redirect()->route(['submission.view', $uuid])->with([
							'message' => "User does not have access to this function",
							'status' => 'danger' ]);
					}
				} else {
					return redirect()->route(['submission.view', $uuid])->with([
						'message' => "User does not have access to this function",
						'status' => 'danger' ]);
				}
			} else {         	
				return redirect()->route(['submission.view', $uuid])->with([
					'message' => "User does not have access to this function",
					'status' => 'danger' ]);
			}
		} else {
    		return redirect()->back()->with([
				'message' => "Submission does not exist.",
				'status' => 'danger' ]);
		}
	}
    
    // public function getSubStoragePath ($id, $file) {
	// 	$path = storage_path('app/'  . 'submissions/' . $id .'/'. $file);
	// 	return response()->file($path);
	// }
}
