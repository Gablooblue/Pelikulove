<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;


class Course extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'courses';

    public $timestamps = true;
    public $incrementing = true;
   
    protected $fillable = [
        'title', 'short_title','start_date', 'end_date', 'thumbnail', 'excerpt', 'description', 'information' , 'welcome_message', 
        'syllabus', 'allow_mentor', 'video', 'video_desc', 'created_by', 'updated_by', 'time', 'token', 'school_id', 'private', 'license'
    ];
    
    
    public static function getAllCoursebyUID($user_id) {
		$courses = array();
		
		$courses= Course::where('created_by', $user_id)
               ->orderBy('title', 'asc')
               ->get();
        return empty($courses) ? null : $courses;
	}
	
    
	public static function saveCourse($data) {
    	$course  = new Course;
        $course->title = $data['title'];
        $course->short_title = $data['short_title'];
    	$course->excerpt = $data['excerpt'];
        $course->description =  $data['description'];
        $course->information = $data['information'];
        $course->thumbnail = $data['thumbnail'];
        $course->welcome_message =  $data['welcome_message'];
        $course->syllabus =  $data['syllabus'] ;
        $course->private =  $data['private'] ;
        $course->license =  $data['license'] ;
        $token = uniqid();
        
        $exist = Course::where('token', $token)->first();
        while (count($exist) > 0) {
      		$token = uniqid();
          	$exist = Course::where('token', $token)->first();
      	}
      	$course->token = $token;
      	
        $course->video = $data['video'];
        $course->created_by = $data['created_by'];
        $course->allow_facilitator = 1;
       
        $course->save();
        return $course->id;
    } 
    
    public static function updateCourse($data) {
    
    	$course = Course::find($data['id']);	
    	
        $course->title = $data['title'];
        $course->short_title = $data['short_title'];
        $course->excerpt = $data['excerpt'];
        $course->description =  $data['description'];
        $course->information = $data['information'];
        $course->welcome_message =  $data['welcome_message'];
        $course->syllabus =  $data['syllabus'] ;
        $course->thumbnail = $data['thumbnail'];
      	$course->updated_by = $data['updated_by'];
        $course->video = $data['video'];
        $course->private =  $data['private'] ;
        $course->license =  $data['license'] ;
   
       
        $course->save();
        return $course->id;
    } 
    
  

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
    
    public function services()
    {
        return $this->hasMany(Service::class);
    }
    
    public function instructors()
    {
        return $this->hasMany(Instructor::class);
    }
    
    public function learnercourses()
    {
        return $this->hasMany(LearnerCourse::class);
    }
}


