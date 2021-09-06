<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestLog extends Model
{    
    protected $table = 'test_log';

    protected $fillable = [
        'user_id', 
        'description_1', 
        'description_2', 
    ];
}
