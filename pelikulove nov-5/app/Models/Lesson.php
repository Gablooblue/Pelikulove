<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


use jeremykenedy\LaravelLogger\App\Models\Activity;

class Lesson extends Model
{
    //
    
    public $timestamps = false;
    public $incrementing = true;
   
    protected $fillable = [
        'title' , 'description', 'course_id', 'duration', 'file', 'lorder', 'premium'
    ]; 
    
    public static function getLessons($course_id) {
		
    	$lessons = Lesson::where('course_id', $course_id)
    				->orderBy('lorder', 'asc')
    				->get();
    		
    	return $lessons;			
    }
    
    
    public static function getLessonTopics($course_id) {
		$lessontopics = array();
    	$lessons = Lesson::where('course_id', $course_id)
    				->orderBy('lorder', 'asc')
    				->get();
    				
    	foreach ($lessons as $lesson):
    		$topics = $lesson->$topics();
    		if (isset($topics)) :
    			foreach ($topics as $topic):
    				
    				$lessontopics[$lesson->id][$topic->id]= array('title' => $topic->title,  'video' => $topic->video, 'subtitle' => $topic->video2,'id' => $a->id, 'lorder' => $topic->lorder, 'duration' => $topic->duration);
    			
    				
    			endforeach;	
    		else:
    			$lessontopics[$lesson->id]= array();
    		endif;	
    	endforeach;
    				
       return $lessontopics;       
    }
    


    public static function getLessonCompletedbyUser($user_id, $course_id = null) {    	
    	$elessons = null;
    	   
      	$activities = Activity::where('userId', '=', $user_id)->where('route','LIKE','%lesson%show%')->select('route')->distinct()->get();
         
		$arr = array();
		
    	
    	foreach ($activities as $activity) :
        	
        	$route = str_replace('https://', '', $activity['route']);
        	
        	$arr = explode('/',$route);
			// dd($route);     
        	
        	if (isset($arr[2])) :
        		$lesson = Lesson::find($arr[2]);
        		if (isset($lesson)) :
					if (is_null($course_id) || $course_id == $lesson->course_id) 
						$elessons[$lesson->course_id][$user_id][$lesson->lorder] = array('id' => $arr[2], 'title' =>$lesson->title);
        		endif;	 
        	endif;
        		
        endforeach;  
		// dd("123");      
     
        return $elessons;
    }
    
    public static function getLessonCompletedStats($course_id) { 
    	$count = 0;
		$completed = Lesson::getLessonCompleted($course_id);
		if (isset($completed[$course_id])) {
			foreach ($completed[$course_id] as $key => $value ) :
				//$stats[$key] = count($completed[$course_id][$key]);
				if (count($completed[$course_id][$key]) > 13) $count++;
			endforeach;
		}
    	//arsort($stats);
    	//print_r($stats);
    	
    	return $count;
    }
    
    public static function getLessonStats($course_id) { 
    	$elessons = null;
    	   
      	$activities = Activity::where('route','LIKE','%lesson%show%')->select('route','userId')->distinct()->get();
         
    	$arr = array();
    	$stats = array();
    	
    	$lessons = Lesson::getLessons($course_id);
    	foreach ($lessons as $lesson) :
    		$stats[$lesson->id] = 0;
    	endforeach;
    	
    	foreach ($activities as $activity) :
        	
			$route = str_replace('https://', '', $activity['route']);			
		
			// dd($route);     
        	
        	$arr = explode('/',$route);
        	
        	if (isset($arr[2])) :
        		$lesson = Lesson::find($arr[2]);
        		if (isset($lesson) > 0) :
        			if (is_null($course_id) || $course_id == $lesson->course_id) :
        				
        				if (!isset($elessons[$lesson->id][$activity['userId']])) :
        					$elessons[$lesson->id][$activity['userId']]= array('id' => $arr[2]);
        					$stats[$lesson->id] = $stats[$lesson->id] + 1;
        				endif; 
        			endif;	
        		endif;	 
        	endif;
        		
		endforeach;
		
		// dd("123");     
        
        
      return $stats;
    }
    
    
    public static function getLessonCompleted($course_id = null, $date = null) {
    	
		$elessons = null;
    	$start = \Carbon\Carbon::now()->subWeek();
        $end = \Carbon\Carbon::now()->subDay(1);
		
		switch ($date) {
			case 'AllExceptToday': 
				$activities = Activity::whereRaw('Date(created_at) < CURDATE()')
				->where('route','LIKE','%lesson%show%')->select('route','userId')->distinct()->get();
			break;
			case 'AllExcept1week': 
				$activities = Activity::where('created_at',  '<=', \Carbon\Carbon::parse($start)->format('Y-m-d'))
				->where('route','LIKE','%lesson%show%')->select('route','userId')->distinct()->get();
			break;
			case 'AllExcept1day': 
				$activities = Activity::where('created_at',  '<=', \Carbon\Carbon::parse($end)->format('Y-m-d'))
				->where('route','LIKE','%lesson%show%')->select('route','userId')->distinct()->get();
			break;
			case null: 
				$activities = Activity::where('route','LIKE','%lesson%show%')->select('route','userId')->distinct()->get();
			break;
			default:
				$activities = Activity::where('route','LIKE','%lesson%show%')->select('route','userId')->distinct()->get();
		}
         
    	$arr = array();
    	
    	foreach ($activities as $activity) :
        	
        	$route = str_replace('https://', '', $activity['route']);
        	
        	$arr = explode('/',$route);
        	
        	if (isset($arr[2])) :
				// dd($route);     
        		$lesson = Lesson::find($arr[2]);
        		if (isset($lesson)) :
					if (is_null($course_id) || $course_id == $lesson->course_id) :
						$elessons[$lesson->course_id][$activity['userId']][$lesson->id] = array('id' => $arr[2], 'title' =>$lesson->title);        			
					else :
						// dd("course is not null or diff course id", $activity);
					endif;	
				else :
					// dd("lesson not set", $activity);
				endif;	
        	endif;
        		
		endforeach;
		
		// dd("123");     
        
     
        return $elessons;
    }
	
    
    
	public static function saveLesson($data) {
    	$lesson  = new Lesson;
    
        $lesson->course_id = $data['course_id'];
        $lesson->title = $data['title'];
        $lesson->duration = $data['duration'];
        $lesson->lorder = $data['lorder'];
        $lesson->premium = $data['premium'];
       	$lesson->file = $data['file'];
       
        $lesson->save();
        return $lesson->id;
        
    } 
    
    public static function updateLesson($data) {
    
    	$lesson = Lesson::find($data['id']);	
    	
      	$lesson->title = $data['title'];
        $lesson->duration = $data['duration'];
        $lesson->lesson = $data['lorder'];
        $lesson->premium = $data['premium'];
        $lesson->file = $data['file'];
      
        return $lesson->save();
        
    } 
    
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }
    
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

}
