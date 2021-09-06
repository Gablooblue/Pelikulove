<?php

namespace App\Http\Controllers;

use Notifications;
use App\Notifications\SendPaymentEmail;
use App\Notifications\SendPaymentNotifyEmail;
use App\Notifications\SendVodPaymentEmail;
use App\Notifications\SendVodPaymentNotifyEmail;
use App\Notifications\SendDonationPaymentEmail;
use App\Notifications\SendDonationPaymentNotifyEmail;
use Illuminate\Support\Facades\Notification;

use Auth;
use App\Models\Order;
use App\PayPal;
use App\Models\Donation;
use App\Models\Service;
use App\Models\User;
use App\Models\LearnerCourse;
use App\Models\VodPurchase;
use App\Models\Vod;
use App\Models\Transaction;
use App\Models\PayPalIPN;
use Illuminate\Http\Request;
use App\Repositories\IPNRepository;
use PayPal\IPN\Listener\Http\ArrayListener;


use PayPal\IPN\Event\IPNInvalid;
use PayPal\IPN\Event\IPNVerificationFailure;
use PayPal\IPN\Event\IPNVerified;
 


use App\Traits\CaptureIpTrait;

/**
 * Class PayPalController
 * @package App\Http\Controllers
 */
class PayPalController extends Controller
{
    
    
   public function __construct(IPNRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $order_id
     * @param Request $request
     */
    public function checkout($order_id)
    {
        $order = Order::findOrFail(decrypt($order_id));
        
        $paypal = new PayPal;

        $response = $paypal->purchase([
            'amount' => $paypal->formatAmount($order->amount),
            'transactionId' => $order->transaction_id,
            'currency' => 'PHP',
            'cancelUrl' => $paypal->getCancelUrl($order),
            'returnUrl' => $paypal->getReturnUrl($order),
            'notifyUrl' => $paypal->getNotifyUrl($order),
        ]);

        if ($response->isRedirect()) {
            $response->redirect();
        }

        return redirect()->back()->with([
                'message' => $response->getMessage(),                
        ]);
    }

    /**
     * @param $order_id
     * @param Request $request
     * @return mixed
     */
    public function completed($order_id, Request $request)
    {
        $admin = null;
    
		$ipAddress = new CaptureIpTrait();
        $order = Order::findOrFail($order_id);
        $status = "";

        $paypal = new PayPal;

        $response = $paypal->complete([
            'amount' => $paypal->formatAmount($order->amount),
            'transactionId' => $order->transaction_id,
            'currency' => 'PHP',
            'cancelUrl' => $paypal->getCancelUrl($order),
            'returnUrl' => $paypal->getReturnUrl($order),
            'notifyUrl' => $paypal->getNotifyUrl($order),
        ]);
        
        $paypalResponse = $response->getData();
		 
     	$transaction = new Transaction;
     	$transaction->txnid = $order->transaction_id;
     	if (isset($paypalResponse['PAYMENTINFO_0_AMT'])) $transaction->amount = $paypalResponse['PAYMENTINFO_0_AMT'];
     	if (isset($paypalResponse['PAYMENTINFO_0_CURRENCYCODE'])) $transaction->currency = $paypalResponse['PAYMENTINFO_0_CURRENCYCODE'];
     	if (isset($paypalResponse['PAYMENTINFO_0_RECEIPTID'])) $transaction->receiptid = $paypalResponse['PAYMENTINFO_0_RECEIPTID'];
     	if (isset($paypalResponse['PAYMENTINFO_0_PAYMENTSTATUS'])) $status = $paypalResponse['PAYMENTINFO_0_PAYMENTSTATUS'];
     	$transaction->status = $status;
     	$transaction->order_id = $order->id;
       	$transaction->refno = $response->getTransactionReference();
        $transaction->message = $response->getMessage();
       	$transaction->ip_addr = $ipAddress->getClientIp();
       	$transaction->save();

        if ($response->isSuccessful()) {
        	if ($status == "Completed") :     
            	$order->update([
                	'ref_no' => $response->getTransactionReference(),
                	'payment_status' => 'S',
                ]);	
                          
                // Check if Course or VOD
                $service = Service::find($order->service_id);
                if (isset($service->course_id)) {   
                    // If Course 
                    $enrolled = LearnerCourse::ifEnrolled($service->course_id, Auth::User()->id);
                         
                    if (!$enrolled)	 :		
                        // Enroll the user to course                    
                        $data = array(
                            'course_id' => $service->course_id, 
                            'user_id' => Auth::User()->id, 
                            'order_id' => $order->id
                        );

                        $learner = LearnerCourse::saveLearnerCourse($data);
                        Notification::send(Auth::User(), new SendPaymentEmail($order));
                        $admin = User::find(10);
                        
                        if (isset($admin)) {
                            Notification::send($admin, new SendPaymentNotifyEmail($order));     
                        }
                    endif;
                } elseif (isset($service->vod_id)) {
                    // If VOD
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

                        $admin = User::find(10);
                        if (isset($admin)) {
                            Notification::send($admin, new SendVodPaymentNotifyEmail($order));   
                        }   
                    }
                } elseif ($service->id == 15) {   
                    // If Donation
                    $donation = Donation::where('order_id', $order->id)->first();
                    $donation->paid = 1;
                    $donation->save();

                    if (isset($donation)) {
                        // Send Emails
                        // $data = array(
                        //     'vod_id' => $vod->id, 
                        //     'user_id' => Auth::User()->id, 
                        //     'order_id' => $order->id
                        // );

                        // $owner = VodPurchase::saveVodPurchase($data);
                        Notification::send(Auth::User(), new SendDonationPaymentEmail($order));

                        // $admin = Auth::User();
                        $admin = User::find(10);
                        if (isset($admin)) {
                            Notification::send($admin, new SendDonationPaymentNotifyEmail($order));   
                        }   
                    }
                } else {        
                    return redirect()->back()->with([
                         'message' => "Course or Vod does not exist", 'status', 'danger'
                    ]);
                }
            else:
            	$order->update([
                	'ref_no' => $response->getTransactionReference(),
                	'payment_status' => 'P',
            	]);
              endif;	            
              
            $service = Service::find($order->service_id); 
            return view('payments/thank', compact('order', 'service', 'transaction')); 
        }

		elseif($response->isRedirect())
        {
            $response->getRedirectUrl();
        }
        else {
        	$order->update(['payment_status' => 'F' ]);
        }
        
	    return redirect()->back()->with([
        	 'message' => $response->getMessage(), 'status', 'danger'
        ]);

    }
    
    
   

    /**
     * @param $order_id
     */
    public function cancelled($order_id)
    {
        $order = Order::findOrFail($order_id);

        $service = Service::find($order->service_id);
        // Check if Vod or Course 
        if (isset($service->course_id)) {
            // If Course             

            return redirect()->route('order.paypal', ['course_id' => $service->course_id, 'order_id' => encrypt($order->id)])->with([
                'message' => 'You have cancelled your recent PayPal payment !', 'status' => 'info'
            ]);
        } else {
            // If Vod           
            $vod = Vod::find($service->vod_id);

            return redirect()->route('vod-order.paypal', ['vod_id' => $vod->id, 'order_id' => encrypt($order->id)])->with([
                'message' => 'You have cancelled your recent PayPal payment !', 'status' => 'info'
            ]);
        }
    }

        /**
     * @param $order_id
     * @param $env
     * @param Request $request
     */
    public function webhook($order_id, $env, Request $request)
    {
    
    	$listener = new ArrayListener;

       /* if ($env == 'sandbox') {
            $listener->useSandbox();
        }*/

        $listener->setData($request->all());

        $listener = $listener->run();

        $listener->onInvalid(function (IPNInvalid $event) use ($order_id) {
            $this->repository->handle($event, PayPalIPN::IPN_INVALID, $order_id);
        });

        $listener->onVerified(function (IPNVerified $event) use ($order_id) {
            $this->repository->handle($event, PayPalIPN::IPN_VERIFIED, $order_id);
        });

        $listener->onVerificationFailure(function (IPNVerificationFailure $event) use ($order_id) {
            $this->repository->handle($event, PayPalIPN::IPN_FAILURE, $order_id);
        });

        $listener->listen();
    }
    
}