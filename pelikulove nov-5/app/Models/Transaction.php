<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
  
  	/**
     * @var string
     */
    protected $table = 'transactions';

	public $timestamps = true;

    /**
     * @var array
     */
    protected $fillable = ['txnid', 'refno', 'amount', 'currency', 'receiptid', 'message', 'order_id', 'status', 'digest', 'ip_addr'];  
    

	
    
    public function order() 
    {
    	return $this->belongsTo(Order::class);
    }
      
}
