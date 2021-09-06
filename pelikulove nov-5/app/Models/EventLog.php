<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventLog extends Model
{    
    protected $table = 'event_logs';

    protected $fillable = [
        'user_id', 
        'event', 
        'referer', 
        'comment', 
    ];
}
