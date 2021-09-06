<?php

namespace App\Notifications;

use Auth;
use App\Models\Service;
use App\Models\Order;
use App\Models\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendPaymentNotifyEmail extends Notification implements ShouldQueue
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
    	$service = Service::find( $this->order->service_id);
    	$user = User::find($this->order->user_id);
    	$message = new MailMessage();
        $message->subject(trans('emails.paymentNotifySubject', ['username' => $user->name]))
            ->greeting(trans('emails.paymentNotifyGreeting'))
            ->line(trans('emails.paymentNotifyMessage1', ['email' => $user->email, 'txnid' => $this->order['transaction_id'],  'amount' =>  $this->order['amount']]))
            ->line(trans('emails.paymentNotifyMessage2', ['course' => $service->course->title, 'service' => $service->name]))
            ->line(trans('emails.paymentNotifyMessage3', ['promo' =>  $this->order->code]))
            ->line(trans('emails.paymentNotifyMessage4',['payment' =>  $this->order->payment->name, 'refno' => $this->order->ref_no]))
            ->line(trans('emails.paymentNotifyThanks'));

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
