<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
   
   	 
    /**
     * @var string
     */
    protected $table = 'promo_codes';

    /**
     * @var array
     */

    /**
     * @var array
     */
    protected $fillable = ['code', 'course_id', 'service_id', 'amount', 'start_date', 'end_date'];
    
    public static function getCoursePromos($course_id) {
    	$promos = null;
    	$promos = PromoCode::where('course_id', '=', $course_id)
    			->get();
    	return $promos;		
    }
    
    public static function getServicePromos($course_id, $service_id) {
    	$promos = null;
    	$promos = PromoCode::where('course_id', '=', $course_id)
    						->where('service_id', '=', $service_id)
    						->get();
    	return $promos;		
    }
   	
   	public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

	
}
