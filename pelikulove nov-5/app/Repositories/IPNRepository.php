<?php
namespace App\Repositories;

use Notifications;
use App\Notifications\SendPaymentEmail;
use App\Notifications\SendVodPaymentEmail;
use Illuminate\Support\Facades\Notification;

use Auth;
use App\Models\Order;
use App\Models\LearnerCourse;
use App\Models\VodPurchase;
use App\Models\Service;
use App\Models\Vod;
use App\Models\PayPalIPN;
use Illuminate\Http\Request;

/**
 * Class IPNRepository
 * @package App\Repositories
 */
class IPNRepository 
{
    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param $event
     * @param $verified
     * @param $order_id
     */
    public function handle($event, $verified, $order_id)
    {
        $object = $event->getMessage();
        
        

        if (is_numeric($order_id)) {
            $order = Order::find($order_id);
        }

        if (empty($order)) {
            $order = Order::findByTransactionId(
                $object->get('txn_id')
            )->first();
        }

        $paypal = PayPalIPN::create([
            'verified' => $verified,
            'transaction_id' => $object->get('txn_id'),
            'order_id' => $order ? $order->id : null,
            'payment_status' => $object->get('payment_status'),
            'request_method' => $this->request->method(),
            'request_url' => $this->request->url(),
            'request_headers' => json_encode($this->request->header()),
            'payload' => json_encode($this->request->all()),
        ]);

        if ($paypal->isVerified() && $paypal->isCompleted() &&  $object->get('txn_id') == $order->transaction_id) {
            if ($order && $order->unpaid()) {
                $order->update([
                	
                    'payment_status' => 'S',
                ]);                
                
                // Check if Course or VOD
                $service = Service::find($order->service_id);
                if (isset($service->course_id)) { 
                    // If Course 
                    $enrolled = LearnerCourse::ifEnrolled($service->course_id, $order->user_id);
                        
                    if (!$enrolled)	 :	                
                        $data = array(
                            'course_id' => $service->course_id, 
                            'user_id' => $order->user_id, 
                            'order_id' => $order->id
                        );
                        
                        $learner = LearnerCourse::saveLearnerCourse($data);
                        Notification::send(Auth::User(), new SendPaymentEmail($order));
                    endif;	
                } elseif (isset($service->vod_id)) {
                    // If Vod 
                    $vod = Vod::find($service->vod_id);
                    $owned = VodPurchase::ifOwned($vod->id, Auth::User()->id);

                    if (!$owned) {
                        $data = array(
                            'vod_id' => $vod->id, 
                            'user_id' => Auth::User()->id, 
                            'order_id' => $order->id
                        );

                        $owner = VodPurchase::saveVodPurchase($data);
                        Notification::send(Auth::User(), new SendVodPaymentEmail($order));     
                    }
                } 
            }
        }
    }
}