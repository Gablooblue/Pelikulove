<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{ 
    /**
     * @var string
     */
    protected $table = 'payment_methods';

    /**
     * @var array
     */
    

    /**
     * @var array
     */
    protected $fillable = ['name', 'description', 'logo'];
    
 
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

	
}
