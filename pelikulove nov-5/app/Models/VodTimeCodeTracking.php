<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VodTimeCodeTracking extends Model
{    
    protected $table = 'vod_time_codes_tracking';

    protected $fillable = [
        'code', 
        'ip_address', 
        'uses', 
    ];
}
