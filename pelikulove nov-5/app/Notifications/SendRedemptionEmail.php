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

	protected $service, $course, $user, $code, $txnID, $payment;
	// protected $email;

    /**
     * Create a new notification instance.
     */
    public function __construct($service, $course, $user, $code, $txnID, $payment)
    {
        $this->service = $service;
        $this->course = $course;
        $this->user = $user;
        $this->code = $code;
        $this->txnID = $txnID;
        $this->payment = $payment;
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
        
    	$message = new MailMessage();
        $message->subject("You redeemed a Code for the " . $course->title)
            ->greeting('Hi ' . $user->name . ',')
            ->line('Congratulations! You are now enrolled in the <strong>' . $course->title . '</strong>.')
            ->line('This is to confirm that you have redeemed the Buy 1 Gift 1 Promo Code: <strong>' . $code .'</strong>.')
            ->line('Your Transaction ID: <strong>' . $txnID . '</strong>.')
            ->line('<u><strong><a href=https://dev.pelikulove.com/course/' . $service->course_id . 
            '/show>Start learning now!</a></strong></u>');
        
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
