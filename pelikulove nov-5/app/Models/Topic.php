<?php

namespace App\Models;

use App\Models\Lesson;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    
    public $timestamps = true;
    public $incrementing = true;
    protected $table = 'topics';
   
    protected $fillable = [
        'course_id' ,  'title', 'lesson_id', 'filename', 'duration','torder', 'video', 'vdesc', 'video2', 'vdesc2', 'video3', 'vdesc3',
        'transcript', 'created_by', 'updated_by'
    ];
    

	
	public static function getfirstTopic($lesson_id) {
    	$topic = null;
    	
    	$topic = Topic::where('lesson_id', $lesson_id)
    				->orderBy('torder', 'asc')->first();
    	return $topic;
    }
    public static function getTopics($lesson_id) {
    	$topics = null;
    	
    	$topics = Topic::where('lesson_id', $lesson_id)
    				->orderBy('torder', 'asc')->get();
    	return $topics;
    }
    
    public static function getNext($topic_id) {
    	 $current = Topic::find($topic_id);
    	 $nlesson = null;
    	 $next = null;
   		 $torder = Topic::where('torder', '>', $current->torder)
   		 					->where('course_id' , $current->course_id)
   		 					->where('lesson_id' , $current->lesson_id)
   		 				   ->min('torder');
   		 if ($torder) : 				   
   		 	$next = Topic::where('torder', $torder)	
   						->where('course_id' , $current->course_id)
   						->where('lesson_id' , $current->lesson_id)
   						->first();	
   		 else :
   			 $lesson = Lesson::find($current->lesson_id);
   			 $nlesson = Lesson::where('lorder', '>', $lesson->lorder)
   		 				   ->where('course_id' , $lesson->course_id)
   		 				   ->orderBy('lorder', 'asc')
   		 				   ->first();
   		 				   
   		 	if ($nlesson) :			   
   		 	 	$next = Topic::where('course_id' , $lesson->course_id)
   						->where('lesson_id' , $nlesson->id)
   						->orderBy('torder', 'asc')
   						->first();			   
   			 endif;
   			 			
   		 endif;	
   		 
   		 									   
   		 return $next;
    }
    
    
    
    public static function getPrev($topic_id) {
    	$current = Topic::find($topic_id);
    	$prev = null;
    	$plesson = null;
    	
   		$torder = Topic::where('torder', '<', $current->torder)
   						->where('course_id' , $current->course_id)
   						->where('lesson_id' , $current->lesson_id)
   		 				->max('torder');
   		if ($torder) : 				   
   			$prev = Topic::where('torder', $torder)	
   						->where('course_id' , $current->course_id)
   						->where('lesson_id' , $current->lesson_id)
   						->first();
   		else :
   			 $lesson = Lesson::find($current->lesson_id);
   			 $plesson = Lesson::where('lorder', '<', $lesson->lorder)
   		 					->where('course_id' , $lesson->course_id)
   		 				    ->orderBy('lorder', 'desc')
   		 				   ->first();
   		 	 if ($plesson)	:		   
   		 	   $prev = Topic::where('course_id' , $lesson->course_id)
   						->where('lesson_id' , $plesson->id)
   						->orderBy('torder', 'asc')
   						->first();
   			endif;							
   		endif;							   
   		return $prev;
    }
    
    public static function searchTopic($key) {
    	$activities = Topic::select('topics.id', 'topics.title', 'topics.page')
    			->where('topics.title', 'like', $key)
    			->orWhere('topics.title', 'like', '%' . $key . '%')
    			->orWhere('lessons.title', 'like', '%' . $key . '%')
    			->orWhere('topics.title', 'like', '%' . $key . '%')
    			->join('lessons', 'lessons.id', '=', 'topics.lesson_id')
    			->join('topics', 'topics.id', '=', 'topics.topic_id')
    						->orderBy('created_at', 'asc')->get();
    						
    	return $activities;					
    }
    
    public static function getAllTopics($course_id) {
    	$activities = Topic::where('course_id', $course_id)->orderBy('created_at', 'asc')->get();
    	return $activities;
    	
    }
    
    public static function getAllTopicLessons($course_id, $lesson_id) {
    	$activities = Topic::where('course_id', $course_id)
    							->where('lesson_id', $lesson_id)
    							->orderBy('created_at', 'asc')->get();
    	return $activities;
    	
    }
    
    public static function saveTopic($data) {
    	$activity  = new Topic;
        $activity->course_id = $data['course_id'];
        $activity->created_by = $data['created_by'];
        $activity->lesson_id = $data['lesson_id'];
        $activity->topic_id = $data['topic_id'];
        $activity->title = $data['title'];
        $activity->page = $data['page'];

        
        if ($data['video']) $activity->video = $data['video'];
        if ($data['video2']) $activity->video2 = $data['video2'];
        if ($data['video3']) $activity->video3 = $data['video3'];
   
   		if ($data['vdesc']) $activity->vdesc = $data['vdesc'];
        if ($data['vdesc2']) $activity->vdesc2 = $data['vdesc2'];
        if ($data['vdesc3']) $activity->vdesc3 = $data['vdesc3'];
   
   
        $activity->transcript = $data['transcript'];
       
        $activity->filename = $data['file'];
       
        $activity->save();
        return $activity->id;
    } 
    
    public static function updateTopic($data) {
    
    	$activity = Topic::find($data['id']);	
    	
        $activity->course_id = $data['course_id'];
        $activity->lesson_id = $data['lesson_id'];
        $activity->topic_id = $data['topic_id'];
        $activity->title = $data['title'];
        $activity->updated_by = $data['updated_by'];
        $activity->page = $data['page'];
        $activity->filename = $data['file'];
        $activity->video = $data['video'];
        $activity->vdesc = $data['vdesc'];
        $activity->video2 = $data['video2'];
        $activity->vdesc2 = $data['vdesc2'];
        $activity->video3 = $data['video3'];
        $activity->vdesc3 = $data['vdesc3re'];
        $activity->transcript = $data['transcript'];
       
   
       
        $activity->save();
        return $activity;
    } 
    
    
    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }
    
    public function lesson()
    {
        return $this->belongsTo('App\Models\Lesson');
    }
     public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }

}
