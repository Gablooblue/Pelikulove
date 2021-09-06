<?php

namespace App\Notifications;

use Auth;
use App\Models\Vod;
use App\Models\Order;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendVodPaymentInstructionEmail extends Notification implements ShouldQueue
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
    	// $vod = Vod::find($this->order->service->vod_id);

    	$message = new MailMessage();
        $message->subject(trans('emails.instructionSubject'))
            ->greeting(trans('emails.instructionGreeting', ['username' => Auth::User()->name]))
            ->line(trans('Your donation is pending.'))
            ->line(trans('emails.instructionMessage2', ['amount' =>  $this->order['amount']]))
            ->line(trans('emails.instructionMessage3'))
            ->line(trans('emails.instructionMessage4'))
            ->line(trans('emails.instructionThanks'));

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
