<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterLog extends Model
{    
    protected $table = 'register_logs';

    protected $fillable = [
        'user_id', 
        'event', 
        'referer', 
    ];
}
