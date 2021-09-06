<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiftCode extends Model
{
    
    protected $table = 'gift_codes';

    protected $fillable = [
        'course_id', 
        'service_id', 
        'user_id', 
        'email',
        'code', 
        'validity', 
    ];

    // protected $hidden = [
    //     'code', 
    //     'validity', 
    // ];
   	
   	public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
