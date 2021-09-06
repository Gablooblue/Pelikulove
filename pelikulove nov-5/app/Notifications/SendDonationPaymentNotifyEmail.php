<?php

namespace App\Notifications;

use Auth;
use App\Models\Donation;
use App\Models\DonationCause;
use App\Models\Order;
use App\Models\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendDonationPaymentNotifyEmail extends Notification implements ShouldQueue
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
    	$user = User::find($this->order->user_id);
    	// $vod = Vod::find($this->order->service->vod_id);
        $donation = Donation::where('order_id', $this->order->id)->first();
        
        if (isset($donation->cause_id)) {
            $d_cause = DonationCause::find($donation->cause_id);
            $line2 = $d_cause->title;
        } else {
            $line2 = "None" ;
        }
        
        if (isset($donation->notes)) {
            $line3 = $donation->notes;
        } else {
            $line3 = "None" ;
        }

    	$message = new MailMessage();
        $message->subject('[Pelikulove] New Donator ' . $user->name . '.')
            ->greeting('Dear Pelikulove Admin,')
            ->line('Received payment from ' . $user->email . ' in the amount of ' . $this->order['amount'] . 
            ' with Transaction ID ' . $this->order['transaction_id'] . '.')
            ->line('Cause: ' . $line2)
            ->line('Notes: ' . $line3)
            ->line('Payment: ' . $this->order->payment->name . ' (' . $this->order->ref_no . ')')
            ->line('Thank you.');

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
