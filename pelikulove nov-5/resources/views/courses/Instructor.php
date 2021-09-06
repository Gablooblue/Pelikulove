<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    
    public $timestamps = true;
    public $incrementing = true;
   
    protected $fillable = [
        'name', 'description', 'credentials', 'avatar', 
    ];
    
    
    public static function findInstructorbyCid($course_id) {
        
        $instructor = Instructor::where('course_id', $course_id)->first();
        
        return $instructor;       
    }
    
    
    public static function saveInstructor($data) {
        $instructor  = new Instructor;
        $instructor->name = $data['name'];
        $instructor->description = $data['description'];
        $instructor->credentials = $data['credentials'];
        $instructor->course_id= $data['course_id'];
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
        $instructor->avatar = $data['avatar'];
       
        $instructor->save();
        return $instructor->id;
    } 

}
