<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;


class Vod extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vods';
   
    protected $fillable = [
        'title', 'short_title','start_date', 'end_date', 'thumbnail', 'excerpt', 'description', 'information' , 'welcome_message', 
        'syllabus', 'allow_mentor', 'video', 'video_desc', 'created_by', 'updated_by', 'time', 'token', 'school_id', 'private', 
        'license', 'paid', 'category_id', 'vorder', 'maturity_rating', 'year_released', 'category_id', 'duration' 
    ];

    public static function getAllVodsByCategory($id) {
		$vods = array();
		
		$vods = Vod::where('category_id', $id)
               ->orderBy('vorder', 'asc')
               ->get();

        return empty($vods) ? null : $vods;
    }

    public function vodCategory()
    {       
    	return $this->belongsTo('App\Models\VodCategory');
    }
    
    public function services()
    {
        return $this->hasMany(Service::class);
    }
    
    public function vodpurchases()
    {
        return $this->hasMany(VodPurchase::class);
    }
}


