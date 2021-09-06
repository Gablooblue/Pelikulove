<?php

namespace App\Notifications;

use Auth;
use App\Models\Vod;
use Carbon\Carbon;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendVodTimeCodeEmail extends Notification implements ShouldQueue
{
    use Queueable;

	protected $vodTimeCode, $email;
	// protected $email;

    /**
     * Create a new notification instance.
     */
    public function __construct($vodTimeCode, $email)
    {
        $this->vodTimeCode = $vodTimeCode;
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
        $vodTimeCode = $this->vodTimeCode;
        $vod = Vod::find($vodTimeCode->vod_id);
        $startDate = Carbon::parse($vodTimeCode->starts_at)->toDayDateTimeString();
        $endDate = Carbon::parse($vodTimeCode->ends_at)->toDayDateTimeString();
        $emailExplode = explode('@', $this->email);
        $username = $emailExplode[0];
        
    	$message = new MailMessage();
        $message->subject("You received a Code for the Vod " . $vod->title . "!")
            ->greeting('Hi ' . $username . ',')
            ->line('Congratulations! You have received a code for the Vod <strong>' . $vod->title . '</strong>.')            
            ->line('The Vod is accessbile from ' . $startDate . ' to ' . $endDate . '.')         
            ->line('To access the Vod:')
            ->line('1. Wait until ' . $startDate . ' before continuing.')
            ->line("2. Access this link <u><strong><a href='https://learn.pelikulove.com/redeem-a-code'>redemption page</a></strong></u> to continue.")
            ->line("3. To redeem the promo, type in your code: <strong>" . $vodTimeCode->code . 
            "</strong> and click 'Redeem Code'. Congrats! You can now watch the video within the duration")
            ->line('4. You will be redirected to the <strong>"Vod Watch Page"</strong> where you can watch video.')
            ->line('Feel free to message us here if you have any concerns.')
            ->line("Enjoy!");
        
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
