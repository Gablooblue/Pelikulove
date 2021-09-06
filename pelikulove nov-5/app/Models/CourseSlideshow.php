<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;


class CourseSlideshow extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'course_slideshows';
   
    protected $fillable = [
        'order', 'name', 'thumbnail', 'url', 'video', 'video_thumbnail'
    ];
}


