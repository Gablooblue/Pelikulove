<?php

namespace App\Notifications;

use Auth;
use App\Models\Service;
use App\Models\Order;
use App\Models\Course;
use App\Models\User;
use App\Models\PaymentMethod;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendRedemptionEmail extends Notification implements ShouldQueue
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
    	$course = Course::find($service->course_id);
        $user = User::find($this->order->user_id);
        $code = $this->order->code;
        $txnID = $this->order->transaction_id;
        $payment = PaymentMethod::find($this->order->payment_id);
        
    	$message = new MailMessage();
        $message->subject('Redeemed a Code for ' . $course->title)
            ->greeting(trans('emails.paymentGreeting', ['username' => $user->name]))
            ->line(trans('emails.paymentMessage1', ['course' => $course->title]))
            ->line('This is to confirm that we have redeemed your code: ' . $code . ' with transaction ID ' . $txnID . '.')
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
