<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Submission extends Model
{

    use SoftDeletes;

    protected $table = 'submissions';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'lesson_id',
        'private',
        'file',
        'title',
        'description',
        'uuid',
    ];

    
    protected $dates = [
        'deleted_at',
    ];

	public $timestamps = true;
    public $incrementing = true;
    
    
    public static function getLessonSubmissions($lesson_id) {
    	$submissions = null;
    	$submissions = Submission::where('lesson_id', '=', $lesson_id)
    									->orderBy('created_at', 'DESC')
    									->get();
    	return $submissions;								
    }
    
    
    public static function getUserSubmissions($user_id) {
    	$submissions = null;
    	$submissions = Submission::where('user_id', '=', $user_id)
    									->orderBy('created_at', 'DESC')
    									->get();
    	return $submissions;								
    }
     
       
    public static function saveSubmission($data) {
        $submission  = new Submission;
        $submission->title = $data['title'];
        $submission->description = $data['description'];
        $submission->lesson_id= $data['lesson_id'];
        $submission->user_id= Auth::User()->id;
        $submission->uuid = Str::orderedUuid();
        $submission->file = $data['file'];
        if (isset($data['private'])) {
            if ($data['private'] == "on") {
                $submission->private = 1;
            } else {
                $submission->private = 0;
            }
        } else {
            $submission->private = 0;
        }
        
        $submission->save();
        return $submission->id;
     } 
    
    public static function updateSubmission($data) {
    	
    
    	
        $submission = Submission::find($data['id']); 
        
     	$submission->title = $data['title'];
        $submission->description = $data['description'];
        $submission->file = $data['file'];
        if (isset($data['private'])) {
            if ($data['private'] == "on") {
                $submission->private = 1;
            } else {
                $submission->private = 0;
            }
        } else {
            $submission->private = 0;
        }
       
      	$submission->save();
   
        return $submission->id;
    } 
    
    public function user()
    {
        return $this->belongsTo('\App\Models\User');
    }
    public function lesson()
    {
        return $this->belongsTo('\App\Models\Lesson');
    }
    
}
