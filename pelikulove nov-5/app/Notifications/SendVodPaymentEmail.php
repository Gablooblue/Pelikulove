<?php

namespace App\Notifications;

use Auth;
use App\Models\Order;
use App\Models\Vod;
use App\Models\User;
use App\Models\PaymentMethod;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendVodPaymentEmail extends Notification implements ShouldQueue
{
    use Queueable;

	protected $order;

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
    	$user = User::find($this->order->user_id);
    	// $vod = Vod::find($this->order->service->vod_id);
    	$vod = $this->order->service->vod;
    	$payment = PaymentMethod::find($this->order->payment_id);
    	$message = new MailMessage();
        $message->subject(trans('emails.paymentSubject'))
            ->greeting(trans('emails.paymentGreeting', ['username' => $user->name]))
            ->line(trans('emails.paymentMessage1', ['course' => $vod->title]))
            ->line(trans('emails.paymentMessage2', ['amount' =>  $this->order['amount'], 'payment' => $payment->name, 'txnid' => $this->order['transaction_id'] ]))
            ->line(trans('emails.paymentMessage3'))
            ->action(trans('emails.paymentButton'), route('login'))
            ->line(trans('emails.paymentThanks'));

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
