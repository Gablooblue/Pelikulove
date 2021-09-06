<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendGiftCodeEmail extends Notification implements ShouldQueue
{
    use Queueable;

    protected $giftCode1, $giftCode2, $email;

    /**
     * Create a new notification instance.
     */
    public function __construct($giftCode1, $giftCode2, $email)
    {
        $this->giftCode1 = $giftCode1;
        $this->giftCode2 = $giftCode2;
        $this->email = $email;
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
        $message->subject('Pelikulove Buy 1 Gift 1 Gift Codes')
            ->greeting('Hi ' . $username . ',' )
            ->line('Thank you for purchasing our Buy 1 Gift 1 promo!')            
            ->line('To access the online course:')
            ->line('1. Create your Pelikulove account 
            <u><strong><a href=https://learn.pelikulove.com/redeem-a-code>here</a></strong></u>. 
            Log in to the site.')
            ->line('2. Click <strong>"Redeem Gift Code"</strong> from the navigation bar at the top of the site.')
            ->line("3. To redeem the promo, type in your code: <strong>" . $this->giftCode1 . "</strong> and click 'Redeem Code'. Congrats! You're now enrolled!")
            ->line('4. You will be redirected to the <strong>"Course Page"</strong>. 
            You should see a green <strong>"Currently Enrolled"</strong> status and the duration of your access. 
            Scroll down to see the list of lessons and start learning!')
            ->line('To gift the online course to your friend/loved one/writing buddy, 
            kindly share the instructions above and give this code to him/her: <strong>' . $this->giftCode2 . '</strong>')
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
