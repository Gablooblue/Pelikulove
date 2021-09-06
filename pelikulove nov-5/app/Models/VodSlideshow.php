<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;


class VodSlideshow extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vod_slideshows';
   
    protected $fillable = [
        'order', 'name', 'thumbnail', 'url', 'video', 'video_thumbnail'
    ];

    public function vodCategory()
    {       
    	return $this->belongsTo('App\Models\VodCategory');
    }
}


