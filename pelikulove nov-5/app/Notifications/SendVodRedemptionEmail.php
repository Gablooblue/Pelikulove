<?php

namespace App\Notifications;

use Auth;
use Carbon\Carbon;
use App\Models\Service;
use App\Models\Order;
use App\Models\Course;
use App\Models\User;
use App\Models\PaymentMethod;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendVodRedemptionEmail extends Notification implements ShouldQueue
{
    use Queueable;

	protected $order;
	// protected $email;

    /**
     * Create a new notification instance.
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $service = $this->service;
        $course = $this->course;
        $user = $this->user;
        $code = $this->code;
        $txnID = $this->txnID;
        $payment = $this->payment;
        
        $curTime = Carbon::now();
        $expTime = $vodPurchase->expiration;
        
    	$message = new MailMessage();
        $message->subject("You redeemed a Code for the " . $vod->title . " VOD.")
            ->greeting('Hi ' . $user->first_name . ' ' . $user->last_name . ',')
            ->line('Congratulations! You now have ' . $vodPurchase->duration . ' hours to watch <strong>' . $vod->title . '</strong>.')
            ->line('You can watch' . $vodPurchase->duration . ' hours to watch <strong>' . $vod->title . '</strong>.')
            ->line('This is to confirm that you have redeemed the VOD Promo Code: <strong>' . $code .'</strong>.')
            ->line('Your Transaction ID: <strong>' . $txnID . '</strong>.')
            ->line('<u><strong><a href=https://dev.pelikulove.com/vod/' . $vod->id . 
            '/watch>Start watching now!</a></strong></u>');
        
        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
