<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonationCause extends Model
{    
    protected $table = 'donations_causes';

    protected $fillable = [
        'title', 
        'corder', 
        'type',
        'description',
    ];
}
