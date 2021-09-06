<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendCodeInviteEmail extends Notification implements ShouldQueue
{
    use Queueable;

    protected $sender, $email, $courseTitle, $code;

    /**
     * Create a new notification instance.
     */
    public function __construct($sender, $email, $courseTitle, $code)
    {
        $this->sender = $sender;
        $this->email = $email;
        $this->courseTitle = $courseTitle;
        $this->code = $code;
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
        $emailExplode = explode('@', $this->email);
        $username = $emailExplode[0];

        $message = new MailMessage();
        $message->subject($this->sender->first_name . " " . $this->sender->last_name . ' sent you a gift!')
            ->greeting('Hi ' . $username . ',' )
            ->line($this->sender->first_name . ' has gifted you the ' . $this->courseTitle . '!')            
            ->line('To access the online course:')
            ->line('1. Create your Pelikulove account 
            <u><strong><a href=https://learn.pelikulove.com/redeem-a-code>here</a></strong></u>. 
            Log in to the site.')
            ->line('2. Click <strong>"Redeem Gift Code"</strong> from the navigation bar at the top of the site.')
            ->line("3. To redeem the promo, type in your code: <strong>" . $this->code . "</strong> and click 'Redeem Code'. Congrats! You're now enrolled!")
            ->line('4. You will be redirected to the <strong>"Course Page"</strong>. 
            You should see a green <strong>"Currently Enrolled"</strong> status and the duration of your access. 
            Scroll down to see the list of lessons and start learning!')
            ->line('Feel free to message us here if you have any concerns.')
            ->line("We're excited for your creative writing journey together!");

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
