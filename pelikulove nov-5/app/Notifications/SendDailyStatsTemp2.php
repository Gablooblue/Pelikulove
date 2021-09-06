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

class SendDailyStatsTemp2 extends Notification implements ShouldQueue
{
    use Queueable;

	protected $users;
	protected $enrolled;
	protected $orders;
	protected $date;

    /**
     * Create a new notification instance.
     */
    public function __construct($users, $enrolled, $orders, $date)
    {
        $this->users = $users;
        $this->enrolled = $enrolled;
        $this->orders = $orders;
        $this->date = $date;
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
        $date = $this->date->format('M j, Y');
    
    	$message = new MailMessage();
        $message->subject(trans('emails.registerNotifySubject', ['day' => $date]))
            ->greeting(trans('emails.registerNotifyGreeting', ['day' => $date]))
            ->line(trans('emails.registerNotifyMessage1', ['rcount' => $this->users->count()]))
            ->line(trans('emails.registerNotifyMessage2', ['ecount' => $this->enrolled->count()]))
            ->line(trans('emails.registerNotifyMessage3', ['pcount' =>  $this->orders->count()]))
            ->action(trans('emails.registerNotifyButton'), route('orders.index'));
       
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
