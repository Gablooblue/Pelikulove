<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class SendNewRegistrantEmail extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    
    /**
     * Create a new notification instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
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
        $message = new MailMessage();
        $message->subject('You have a new Registrant!')
            ->line("Pelikulove User " . $this->user->name . "'s Information")
            ->line("First Name: " . $this->user->first_name . "")
            ->line("Last Name: " . $this->user->last_name . "")
            ->line("Email: " . $this->user->email . "")
            ->line("Created on: " . $this->user->created_at . "");

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
