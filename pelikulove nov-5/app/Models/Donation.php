<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{    
    protected $table = 'donations';

    protected $fillable = [
        'user_id', 
        'order_id', 
        'cause_id',
        'status',
        'notes',
    ];
}
