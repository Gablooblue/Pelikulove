<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Course;
use App\Models\LearnerCourse;
use App\Models\Lesson;
use App\Models\Topic;


use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class LessonController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
 
    
    public function show($lesson_id, $topic_id)
    {
     
     $course = null;
  	 $prev = $next = null;
  	
     $topics = array();
     
     //$lesson = Lesson::find($lesson_id);
  	 $topic = Topic::find($topic_id);
  	 
  	            		   
  	 if (isset($topic)) :
  	 	$lesson = Lesson::find($topic->lesson_id);
  		$course = Course::find($topic->course_id);
  		
  	 	if (!empty($course)) :
       	
       		if (!LearnerCourse::ifEnrolled($course->id, Auth::user()->id) && $lesson->premium == 1) :
				  \Session::flash('message', "Sorry, you don't have access to this course. Please enroll 
				  <a href=".route('course.enroll', $course->id).">NOW</a>.");
  				\Session::flash('status', "warning");
  				return redirect()->route('course.show', $lesson->course_id);
  			endif;
  		
       		$topics = Topic::getTopics($lesson_id);
       		$next = Topic::getNext($topic_id);
       		$prev = Topic::getPrev($topic_id);
       		
       		$ls = Lesson::getLessons($topic->course_id);
       		
       		foreach ($ls as $l) :
       			$f = Topic::getFirstTopic($l->id);
       			if (isset($f)) :
       				$first = $f->id;
       			else:
       				$first = 1;	
       			endif;
       			$lessons[$l->id] = array('title' => $l->title, 'first' => $first );
       		
			endforeach;    
       		
       	else:	
       		\Session::flash('error', 'Course does not exist.');
			return redirect()->route('public.home');
      	endif;
       		
    else:
       		\Session::flash('error', 'Topic does not exist.');
			return redirect()->route('public.home');
      		
	endif;	
			
	$notifications = auth()->user()->unreadNotifications;
			
	foreach ($notifications as $notification) {
		if (isset($notification->data['topic_id'])) {
			if ($notification->data['topic_id'] == $topic_id) {					
				$notification->markAsRead();
			}
		}
	} 
    
    return view('lessons.show', ['course' => $course, 'topic' => $topic, 'topics' => $topics, 'lesson' => $lesson, 'lessons' => $lessons, 'prev' => $prev, 'next' => $next]); 
    
    }
    
    public function show2($lesson_id, $topic_id)
    {
     
     $course = null;
  	 $prev = $next = null;
  	
     $topics = array();
     
     //$lesson = Lesson::find($lesson_id);
  	 $topic = Topic::find($topic_id);
  	 
  	            		   
  	 if (count($topic) > 0 ) :
  	 	$lesson = Lesson::find($topic->lesson_id);
  		$course = Course::find($topic->course_id);
  		
  	 	if (!empty($course)) :
       	
       		if (!LearnerCourse::ifEnrolled($course->id, Auth::user()->id)) :
  				\Session::flash('message', "Sorry, you don't have access to this course. Please enroll <a href=".route('course.enroll', $course->service->id).">NOW</a>.");
  				\Session::flash('status', "warning");
  				return redirect()->route('course.show', $lesson->course_id);
  			endif;
  		
       		$topics = Topic::getTopics($lesson_id);
       		$next = Topic::getNext($topic_id);
       		$prev = Topic::getPrev($topic_id);
       		
       		$ls = Lesson::getLessons($topic->course_id);
       		
       		foreach ($ls as $l) :
       			$f = Topic::getFirstTopic($l->id);
       			if (count($f) > 0) :
       				$first = $f->id;
       			else:
       				$first = 1;	
       			endif;
       			$lessons[$l->id] = array('title' => $l->title, 'first' => $first );
       		
       		endforeach;     
       		
       	else:	
       		\Session::flash('error', 'Course does not exist.');
			return redirect()->route('public.home');
      	endif;
       		
    else:
       		\Session::flash('error', 'Topic does not exist.');
			return redirect()->route('public.home');
      		
	endif;	
			
	$notifications = auth()->user()->unreadNotifications;
			
	foreach ($notifications as $notification) {
		if (isset($notification->data['topic'])) {
			if ($notification->data['topic']->id == $topic_id) {					
				$notification->markAsRead();
			}
		}
	} 
    
    return view('lessons.show2', ['course' => $course, 'topic' => $topic, 'topics' => $topics, 'lesson' => $lesson, 'lessons' => $lessons, 'prev' => $prev, 'next' => $next]); 
    
    }
	
}
