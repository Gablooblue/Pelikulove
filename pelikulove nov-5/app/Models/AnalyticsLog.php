<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalyticsLog extends Model
{    
    protected $table = 'analytics_logs';

    protected $fillable = [
        'type', 
        'content', 
        'date', 
    ];
}
