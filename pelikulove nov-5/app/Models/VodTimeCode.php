<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VodTimeCode extends Model
{    
    protected $table = 'vod_time_codes';

    protected $fillable = [
        'code', 
        'vod_id', 
        'starts_at', 
        'ends_at'
    ];
}
