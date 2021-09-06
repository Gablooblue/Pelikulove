<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VodCrewType extends Model
{    
    protected $table = 'vod_crew_types';

    protected $fillable = [
        'torder', 
        'name', 
        'description',
    ];
}
