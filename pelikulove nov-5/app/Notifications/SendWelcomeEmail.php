<?php

namespace App\Notifications;

use App\Models\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendWelcomeEmail extends Notification implements ShouldQueue
{
    use Queueable;

    protected $token;
    public $user;

    /**
     * Create a new notification instance.
     *
     * SendActivationEmail constructor.
     *
     * @param $token
     */
    public function __construct($token, $user)
    {
        $this->token = $token;
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
     *a
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $message = new MailMessage();
        $message->subject(trans('emails.welcomeSubject'))
            ->greeting(trans('emails.welcomeGreeting' ,['username' => $this->user->name]))
            ->line(trans('emails.welcomeMessage1'))
            ->line(trans('emails.welcomeMessage2'))
            ->line(trans('emails.welcomeMessage3', ['count' => config('auth.passwords.users.expire')/(24*60)]))
            ->action(trans('emails.welcomeButton'), route('password.reset', ['token' => $this->token, 'email' => $this->user->email]))
            ->line(trans('emails.welcomeThanks'));

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
