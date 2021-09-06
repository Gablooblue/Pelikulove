<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LearnerTeacher extends Model
{
    //
    
    public $timestamps = true;
    public $incrementing = true;
    protected $table = "learnerteachers";
   
    protected $fillable = [
       'learner_id', 'course_id', 'teacher_id', 'batch_id'
    ];
    
    


    
    public static function getLearnerCoursesbyUID($user_id ) {
    	$courses = array();
    	
    	
    	$courses = LearnerTeacher::where('learner_id','=', $user_id)
    				->join('courses', 'courses.id', '=', 'learnerteachers.course_id')
    				->select('courses.*',  'learnerteachers.*')
    				->get();
    				
    	return $courses;			
    }
     
 
    
 public static function saveLearnerTeacher($data) {
    	$learnerteacher  = new LearnerTeacher;
        $learnerteacher->learner_id = $data['learner_id'];
        $learnerteacher->course_id = $data['course_id'];
 		$learnerteacher->teacher_id = $data['teacher_id'];
       
        $learnerteacher->save();
        return $learnerteacher->id;
    } 
    
    public static function updateLearnerTeacher($data) {
    
    	$learnerteacher = Learner::find($data['id']);	
    	
        $learnerteacher->learner_id = $data['learner_id'];
        $learnerteacher->course_id = $data['course_id'];
 		$learnerteacher->teacher_id = $data['teacher_id'];
       
        $learnerteacher->save();
        return $learnerteacher->id;
   
    } 

}
