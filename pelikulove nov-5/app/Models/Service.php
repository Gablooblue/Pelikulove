<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
  
  	/**
     * @var string
     */
    protected $table = 'services';


    /**
     * @var array
     */
    protected $fillable = [
         'course_id', 
         'vod_id', 
         'amount', 
         'name', 
         'description', 
         'duration'
     ];  
    
     public function orders()
    {
         return $this->hasMany(Order::class);
    } 
    
     public function codes()
    {
         return $this->hasMany(PromoCode::class);
    }  
    
    public function course() 
    {
    	return $this->belongsTo(Course::class);
    }
    
    public function vod() 
    {
    	return $this->belongsTo(Vod::class);
    }
      
}
