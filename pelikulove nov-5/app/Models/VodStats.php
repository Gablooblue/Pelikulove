<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VodStats extends Model
{
    protected $fillable = [
        'title',
        'totalViews', 
        'uniqueUsers', 
        'uniqueUsersCount', 
        'registeredViews', 
        'guestViews', 
        'crawlerViews', 
    ];
}
