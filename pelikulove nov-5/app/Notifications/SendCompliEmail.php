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

class SendCompliEmail extends Notification implements ShouldQueue
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
    	$payment = PaymentMethod::find($this->order->payment_id);
    	$message = new MailMessage();
        $message->subject(trans('emails.compliSubject'))
            ->greeting(trans('emails.compliGreeting', ['username' => $user->name]))
            ->line(trans('emails.compliMessage1', ['course' => $course->title]))
            ->line(trans('emails.compliMessage2'))
            ->line(trans('emails.compliMessage3'))
            ->action(trans('emails.compliButton'), route('login'))
            ->line(trans('emails.compliThanks', ['txnid' => $this->order['transaction_id']]));

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
