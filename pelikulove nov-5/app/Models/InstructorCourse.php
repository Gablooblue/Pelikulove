<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class InstructorCourse extends Model
{
    //
    
    public $timestamps = true;
    public $incrementing = true;
    protected $table = "instructorcourses";
   
    protected $fillable = [
       'course_id', 'instructor_id'
    ];
    

 	
 
 
    
 	public static function saveInstructorCourse($data) {
    	$instructorcourse  = new InstructorCourse;
        $instructorcourse->instructor_id = $data['instructor_id'];
        $instructorcourse->course_id = $data['course_id'];
      
        $instructorcourse->save();
        return $instructorcourse->id;
    } 
    
    public static function updateInstructorCourse($data) {
    
    	
   		$instructorcourse->instructor_id = $data['instructor_id'];
        $instructorcourse->course_id = $data['course_id'];
 	
       
        $instructorcourse->save();
        return $instructorcourse->id;
   
    } 
    
  	public function course()
    {
        return $this->belongsTo('\App\Models\Course');
    }
    
    public function instructor()
    {
        return $this->belongsTo('\App\Models\Instructor');
    }
    
}
