<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    
   	 
    /**
     * @var string
     */
    protected $table = 'orders';

    /**
     * @var array
     */
    protected $dates = ['deleted_at', 'created_at'];

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'ref_no', 'transaction_id', 'amount', 'service_id', 'payment_status', 'payment_id', 'donation'];
    
    
    public static function ifPending($course_id, $user_id) {
    
		$orders = Order::join('services', 'services.id','=', 'orders.service_id')
						->where('payment_status', '=', 'P')
						->where('user_id', '=', $user_id)
						->where('services.course_id', '=', $course_id)
						->orderBy('orders.created_at', 'desc')
						->first();
						
		return empty($orders) ? false : true;
	}
    
    
    public static function ifVodPending($vod_id, $user_id) {
    
		$orders = Order::join('vods', 'vods.id','=', 'orders.vod_id')
						->where('payment_status', '=', 'P')
						->where('vods.id', '=', $vod_id)
						->where('user_id', '=', $user_id)
						->orderBy('orders.created_at', 'desc')
						->first();
												
		return empty($orders) ? false : true;
	}
	
	public static function ifServiceIDIsUsed($service_id)
    {
        $result = Order::where('service_id', '=', $service_id)
        ->first();

		return empty($result);
    }
	
	public static function ifPaymentMethodIDIsUsed($paymentMethod_id)
    {
        $result = Order::where('payment_id', '=', $paymentMethod_id)
        ->first();

		return empty($result);
    }
	
	public static function ifPromoCodeIsUsed($code)
    {
        $result = Order::where('code', '=', $code)
        ->first();

		return empty($result);
    }
	
	public function findByTransactionId($query, $transaction_id)
    {
        return $query->where('transaction_id', $transaction_id);
    }

    /**
     * Payment completed.
     *
     * @return boolean
     */
    public function paid()
    {
        return in_array($this->payment_status, ['S']);
    }

    /**
     * Payment is still pending.
     *
     * @return boolean
     */
    public function unpaid()
    {
        return in_array($this->payment_status, ['P','F']);
    }
    
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    
    public function payment()
    	
    {
    	
        return $this->belongsTo(PaymentMethod::class);
    }

	public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    
	public function transactions()
    {
        return $this->hasMany(Transaction::class );
    }
}
