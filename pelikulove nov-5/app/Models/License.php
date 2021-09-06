<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    //
    
    public $timestamps = false;
    public $incrementing = true;
   
    protected $fillable = [
        'acronym' , 'name', 'link', 'icon', 'description'
    ]; 
    
   
    
    

}
