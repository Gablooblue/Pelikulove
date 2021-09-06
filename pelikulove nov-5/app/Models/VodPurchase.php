<?php

namespace App\Models;

use App\Models\Service;
use App\Models\Order;
use Carbon\Carbon;


use Illuminate\Database\Eloquent\Model;


class VodPurchase extends Model
{
    protected $table = "vod_purchases";
   
    protected $fillable = [
       'user_id', 'vod_id', 'order_id', 'batch_id', 'teacher_id'
    ];
 	
 	public static function ifOwned($vod_id, $user_id) {
 		$vodPurchase = null;
 		$vodPurchase = VodPurchase::where('vod_id', $vod_id)
                                    ->where('user_id', $user_id)
                                    ->where('status', 1)
                                    ->first();
                                
		if (isset($vodPurchase)) :		
			$order = Order::find($vodPurchase->order_id);
			$service = Service::find($order->service_id);
            $duration = $service->duration;
            $durationSplit = explode(".",$duration);
            $durationDays = $durationSplit[0];

            if (isset($durationSplit[1])) {
                $durationHrs = $durationSplit[1];
            } else {
                $durationHrs = 0;
            }
            
            if (Carbon::now()->gt($vodPurchase->created_at->addDays($durationDays)->addHours($durationHrs))) {
                $vodPurchase->status = 0;
                $vodPurchase->save();
                return false;	
            } else {
                return true;	
            }
		else: 
			return false;
 		endif; 						
 	}
 	
 	public static function getPurchase($vod_id, $user_id) {
 		$vod = null;
 		$vod = VodPurchase::where('vod_id', '=', $vod_id)
                            ->where('user_id', '=', $user_id)
                            ->where('status', 1)
                            ->first();
                                
        if (isset($vod)) :		
            $order = Order::find($vod->order_id);
            $service = Service::find($order->service_id);
            $duration = $service->duration;
            $durationSplit = explode(".",$duration);
            $durationDays = $durationSplit[0];

            if (isset($durationSplit[1])) {
                $durationHrs = $durationSplit[1];
            } else {
                $durationHrs = 0;
            }
            
            if (Carbon::now()->gt($vod->created_at->addDays($durationDays)->addHours($durationHrs))) {
                $vod->status = 0;
                $vod->save();
                return NULL;	
            } else {
                return $vod; 	
            }
        else: 
            return NULL;
        endif; 						
 	} 
	
    public static function ifVodIDIsUsed($vod_id)
    {
        $result = VodPurchase::where('vod_id', '=', $vod_id)
        ->first();

        return !empty($result);
    }
    
 	public static function saveVodPurchase($data) {
    	$vod = new VodPurchase;
        $vod->user_id = $data['user_id'];
        $vod->vod_id = $data['vod_id'];
        $vod->order_id = $data['order_id'];
 		//$vod->teacher_id = $data['teacher_id'];
       
        $vod->save();
        return $vod->id;
    } 
    
  	public function user()
    {
        return $this->belongsTo('\App\Models\User');
    }
    
    public function vod()
    {
        return $this->belongsTo('\App\Models\Vod');
    }
    public function order()
    {
        return $this->belongsTo('\App\Models\Order');
    }
}
