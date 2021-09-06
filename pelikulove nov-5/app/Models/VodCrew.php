<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VodCrew extends Model
{    
    protected $table = 'vod_crew';

    protected $fillable = [
        'vod_id', 
        'crew_type_id', 
        'corder',
        'name',
        'description',
        'url',
    ];
}
