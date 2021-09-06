<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;


class VodCategory extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vod_categories';
   
    protected $fillable = [
        'corder', 'name', 'description'
    ];    
    
    public static function getAllVodsbyUID($user_id) {
		$courses = array();
		
		$courses= VodCategory::where('created_by', $user_id)
               ->orderBy('title', 'asc')
               ->get();
        return empty($courses) ? null : $courses;
    }
            
    public function vod()
    {
        return $this->hasMany('App\Models\Vod');
    }
}


