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

class SendWeeklyUserStats extends Notification implements ShouldQueue
{
    use Queueable;

	protected $users;
	protected $enrolled;
	protected $orders;

    /**
     * Create a new notification instance.
     */
    public function __construct($users, $enrolled, $orders)
    {
        $this->users = $users;
        $this->enrolled = $enrolled;
         $this->orders = $orders;
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
    
    	$start = \Carbon\Carbon::now()->subWeek();
    	$end = \Carbon\Carbon::now()->subDay(1);
    	 
    	$message = new MailMessage();
        $message->subject(trans('emails.registerWeeklyNotifySubject',['start' => \Carbon\Carbon::parse($start)->format('M j') , 'end' =>  \Carbon\Carbon::parse($end)->format('M j, Y')]))
            ->greeting(trans('emails.registerWeeklyNotifyGreeting'))
            ->line(trans('emails.registerWeeklyNotifyMessage'))
            ->line(trans('emails.registerWeeklyNotifyMessage1', ['rcount1' => $this->users->count()]))
            ->line(trans('emails.registerWeeklyNotifyMessage2', ['ecount1' => $this->enrolled->count()]))
            ->line(trans('emails.registerWeeklyNotifyMessage3', ['pcount1' => $this->orders->count()]))
            ->line(trans('emails.registerWeeklyNotifyMessage4', ['start' => \Carbon\Carbon::parse($start)->format('M j') , 'end' =>  \Carbon\Carbon::parse($end)->format('M j, Y')]))
            ->line(trans('emails.registerWeeklyNotifyMessage5', ['rcount2' => $this->users->where('created_at',  '>=', \Carbon\Carbon::parse($start)->format('Y-m-d'))->count()]))
            ->line(trans('emails.registerWeeklyNotifyMessage6', ['ecount2' => $this->enrolled->where('created_at',  '>=', \Carbon\Carbon::parse($start)->format('Y-m-d'))->count()]))
            ->line(trans('emails.registerWeeklyNotifyMessage7', ['pcount2' => $this->orders->where('created_at', '>=', \Carbon\Carbon::parse($start)->format('Y-m-d'))->count()]))
            ->action(trans('emails.registerWeeklyNotifyButton'), route('orders.index'));
       
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
