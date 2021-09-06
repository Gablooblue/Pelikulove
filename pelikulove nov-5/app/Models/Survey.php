<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{    
    protected $table = 'surveys';

    protected $fillable = [
        'title', 
        'intro', 
        'outro',
        'type',
        'topic_id',
        'lesson_id', 
        'course_id', 
        'vod_id',
    ];
}
