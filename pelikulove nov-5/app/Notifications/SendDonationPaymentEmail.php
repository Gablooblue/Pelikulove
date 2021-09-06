<?php

namespace App\Notifications;

use Auth;
use App\Models\Order;
use App\Models\Donation;
use App\Models\DonationCause;
use App\Models\User;
use App\Models\PaymentMethod;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendDonationPaymentEmail extends Notification implements ShouldQueue
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
        
    	$donation = Donation::where('order_id', $this->order->id)->first();

    	$message = new MailMessage();
        $message->subject('Payment Received')
            ->greeting('Dear ' . $user->name . ',')
            ->line('The sun is shining a little brighter for Pinoy arts thanks to you!')
            ->line("Your donation of ₱" . $this->order['amount'] . " will help in building sustainable Filipino arts 
            communities through Pelikulove. We'll continue to do our best in giving you a meaningful experience here in Pelikulove.")
            ->line('Maraming salamat sa iyong suporta!')
            ->line("Nagmamahal,")
            ->line("Pelikulove Team")
            ->action('Return to Pelikulove', route('public.home'))
            ->line('Transaction Method: ' . $this->order->payment->name . '<br>Transaction ID #: ' . $this->order['transaction_id'] . '.')
            ->salutation("\r\n");

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
