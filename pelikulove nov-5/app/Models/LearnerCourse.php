<?php

namespace App\Models;

use Auth;

use App\Models\InstructorCourse;
use App\Models\Instructor;
use App\Models\Service;
use App\Models\Course;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class LearnerCourse extends Model
{
    //
    
    public $timestamps = true;
    public $incrementing = true;
    protected $table = "learnercourses";
   
    protected $fillable = [
       'user_id', 'course_id', 'order_id', 'batch_id', 'teacher_id'
    ];
    
 
 	public static function getAllEnrolled($course_id) {
 		$learners = null;
 		$learners = LearnerCourse::where('course_id', '=', $course_id)->get();
 		return $learners;
 		
 						
 	}
 	
 	public static function getAllUserCourses($user_id) {
 		$courses = null;
 		$courses = LearnerCourse::where('user_id', '=', $user_id)
 								->join('courses', 'courses.id', '=', 'learnercourses.course_id')
 								->select('courses.id', 'courses.title', 'courses.thumbnail')
 								->orderBy('courses.title', 'asc')
 								->distinct()
 								->get();
 		return $courses;
 		
 						
 	}
 	
 	public static function ifEnrolled($course_id, $user_id, $bypassAdminEnrollment = false) {
		$user = User::find($user_id);

		if (($user->hasRole('pelikulove') || $user->hasRole('admin')) && $bypassAdminEnrollment == false) {
			return true;	
		} else if (Auth::user()->hasRole('mentor')) {
			$instructor = Instructor::where('user_id', $user_id)->first();

			if (isset($instructor)) {
				if ($instructor->course_id == $course_id) {
					return true;	
				}
			}
		}

		$learner = null;
		$learner = LearnerCourse::where('course_id', '=', $course_id)
								  ->where('user_id', '=', $user_id)
								  ->where('status', 1)
								  ->orderBy('created_at', 'desc')
								  ->first();
		// dd($learner);	

		if (isset($learner)) :			
			$order = Order::find($learner->order_id);
			$service = Service::find($order->service_id);
			$duration = $service->duration;
			if (Carbon::now()->gt($learner->created_at->addDays($duration))) {
				$learner->status = 0;
				$learner->save();
				return null; 
			} else {
				return true;	
			}
		else:  
			return null;	
 		endif;
 						
 	}
 	
 	public static function getEnrollment($course_id, $user_id) {		 
		// dd($course_id, $user_id);
		if (Auth::user()->hasRole('pelikulove') || Auth::user()->hasRole('admin')) {
			$newLearner = new LearnerCourse;
			$newLearner->user_id = Auth::User()->id;  
			$newLearner->order_id = LearnerCourse::where('course_id', $course_id)->first()->order_id;  
			$newLearner->course_id = $course_id;  
			$newLearner->status = 1;  
			return $newLearner;	
		} else if (Auth::user()->hasRole('mentor')) {
			$instructor = Instructor::where('user_id', $user_id)->first();

			if (isset($instructor)) {
				if ($instructor->course_id == $course_id) {
					$newLearner = new LearnerCourse;
					$newLearner->user_id = Auth::User()->id;  
					$newLearner->order_id = LearnerCourse::where('course_id', $course_id)->first()->order_id;  
					$newLearner->course_id = $course_id;  
					$newLearner->status = 1;  
					return $newLearner;	
				}
			}
		}

 		$learner = null;
 		$learner = LearnerCourse::where('course_id', '=', $course_id)
								  ->where('user_id', '=', $user_id)
								  ->where('status', 1)
								  ->orderBy('created_at', 'desc')
								  ->first();

		// dd($learner);	
		if (isset($learner)) :			
			$order = Order::find($learner->order_id);
			$service = Service::find($order->service_id);
			$duration = $service->duration;
			if (Carbon::now()->gt($learner->created_at->addDays($duration))) {				
				$learner->status = 0;
				$learner->save();
				return null; 
			} else {
				return $learner;	
			}
		else:  
			return null;	
		endif;				
	}
	
	// Check if User is included in 2019 Enrollment Extension
	public static function ifUserisExtendable2019 ($learner) {
		// $orderIdList = collect([349,350,351,352,353,358,359,357,354,356,355,363,367,360,361,362,366,365,364,368,344,
		// 345,346,347,348,370,369,371,423,424,425,499,436,449,450,451,452,453,454,500,472,473,477,479,480,483,
		// 485,492,496,497,511,515,498,504,503,502,501,505,506,507,508,532,536,519,520,525,517,528,530,512,514,
		// 521,522,523,533,539,540,560,561,562,564,513,524,534,537,565,566,567,568,569,575,578,580,581,585,584,
		// 585,587,588,590,591,593,594,600,601,605,606,607,610,611,612,614,617,621,624,625,626,627,629,630,638,
		// 639,640,641,646,647,648,650,653,654,657,658,660,661,665,666,669,671,673,675,676,677,678,682,683,684,
		// 688,690,693,694,695,696,697,698,700,702,706,710,712,713,714,715,718,719,722,723,455,724,458,459,460,
		// 461,462,463]);
		
		$orderIdList = collect([0]);

		foreach ($orderIdList as $orderId) {
			if ($orderId == $learner->order_id) {
				return true;
			}
		}
		
		return null;
	}
 
    
 	public static function saveLearnerCourse($data) {
    	$learnercourse  = new LearnerCourse;
        $learnercourse->user_id = $data['user_id'];
        $learnercourse->course_id = $data['course_id'];
        $learnercourse->order_id = $data['order_id'];
 		//$learnercourse->teacher_id = $data['teacher_id'];
       
        $learnercourse->save();
        return $learnercourse->id;
    } 
    
    public static function updateLearnerCourse($data) {
    
    	$learnercourse = Learner::find($data['id']);	
    	$learnercourse->user_id = $data['user_id'];
        $learnercourse->course_id = $data['course_id'];
        $learnercourse->order_id = $data['order_id'];
 		//$learnercourse->teacher_id = $data['teacher_id'];
       
        $learnercourse->save();
        return $learnercourse->id;
   
    }
	
	public static function ifCourseIDIsNotUsed($course_id)
    {
        $result = LearnerCourse::where('course_id', '=', $course_id)
        ->first();

		return empty($result);
    } 
    
  	public function user()
    {
        return $this->belongsTo('\App\Models\User');
    }
    
    public function course()
    {
        return $this->belongsTo('\App\Models\Course');
	}
	
    public function order()
    {
        return $this->belongsTo('\App\Models\Order');
    }
}
