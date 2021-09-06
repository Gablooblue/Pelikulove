<?php

namespace App\Models;

use App\Models\Course;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    
    public $timestamps = true;
    public $incrementing = true;
   
    protected $fillable = [
        'name', 'description', 'credentials', 'avatar', 'course_id', 'user_id',
    ];
    
    
  
    public static function getCourses($instructor_id) {
    	$courses = Instructor::where('course_id', $course_id)->first();
    }
    
    
    public static function saveInstructor($data) {
        $instructor  = new Instructor;
        $instructor->name = $data['name'];
        $instructor->description = $data['description'];
        $instructor->credentials = $data['credentials'];
        $instructor->course_id= $data['course_id'];
        $instructor->user_id= $data['user_id'];
        $instructor->avatar = $data['avatar'];
        $instructor->save();
        return $instructor->id;
     } 
    
    public static function updateInstructor($data) {
    
        $instructor = Instructor::find($data['instructor_id']); 
        
        $instructor->name = $data['name'];
        $instructor->description = $data['description'];
        $instructor->credentials = $data['credentials'];
        $instructor->course_id= $data['course_id'];
        $instructor->user_id= $data['user_id'];
        $instructor->avatar = $data['avatar'];
       
        $instructor->save();
        return $instructor->id;
    } 

	public function instructorcourse()
    {
        return $this->belongsTo('\App\Models\InstructorCourse');
    }
}
