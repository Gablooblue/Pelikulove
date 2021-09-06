<?php

namespace App\Notifications;

use Auth;
use App\Models\Service;
use App\Models\Order;
use App\Models\User;
use App\Models\Invoice;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendMonthlyBilling extends Notification implements ShouldQueue
{
    use Queueable;

	protected $users;
	protected $enrolled;
	protected $invoice;

    /**
     * Create a new notification instance.
     */
    public function __construct($users, $enrolled, $invoice)
    {
        $this->users = $users;
        $this->enrolled = $enrolled;
         $this->invoice = $invoice;
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
    
    	$invoices = Invoice::where('paid', 0)->orderBy('created_at', 'desc')->get();
    	$start = \Carbon\Carbon::now()->subMonth()->startOfMonth();
    	$end =  \Carbon\Carbon::now()->subMonth()->endOfMonth();
    	
    	$month = \Carbon\Carbon::now()->subMonth();
  
    		
    	$message = new MailMessage();
    	$line = array();
    	foreach ($invoices as $i) : 
    		$now = \Carbon\Carbon::now();
    		$date = \Carbon\Carbon::parse($i->created_at);
    		if ($date->diffInDays($now) > 12) :
    			$line[] = $i->period . ": " . number_format($i->net_servicefee, 2);
    		endif;
    	endforeach;
    	
    	$message->from('finance@orangefix.net', 'Orangefix Billing')
    		->replyTo('finance@orangefix.net', 'Orangefix Billing')
        	->subject(trans('emails.billingMonthlyNotifySubject',['month' => \Carbon\Carbon::parse($month)->format('M Y') ]))
            ->greeting(trans('emails.billingMonthlyNotifyGreeting'))
            ->line(trans('emails.billingMonthlyNotifyMessage1', ['rcount' => $this->users->count()]) .'<br/>' . 
            	trans('emails.billingMonthlyNotifyMessage2', ['ecount' => $this->enrolled->count()]) . '<br/>' .
            	trans('emails.billingMonthlyNotifyMessage3', ['pcount' => $this->invoice->orders]))
			->line('<strong>' . trans('emails.billingMonthlyNotifyMessage4') . '</strong>')
            ->line(trans('emails.billingMonthlyNotifyMessage5', ['total' => number_format($this->invoice->sales,2)]) . '<br/>'.
             trans('emails.billingMonthlyNotifyMessage6', ['netamount' => number_format($this->invoice->net_amount,2)]). 
             '<br/>' .trans('emails.billingMonthlyNotifyMessage7', ['servicefee' => number_format($this->invoice->net_servicefee,2)]));
        
    	if (count($line)> 0) :
    		$message->line('<strong>Unpaid Monthly Invoice(s):<strong>');
    		$message->line(implode('<br/>',$line));
    	endif;
    	$message->line('<strong>'.trans('emails.billingMonthlyNotifyMessage8') .'</strong>');
    	$message->line(trans('emails.billingMonthlyNotifyMessage9') . '<br/>' .trans('emails.billingMonthlyNotifyMessage10') . '<br/>' . trans('emails.billingMonthlyNotifyMessage11'));
    	$message->line(trans('emails.billingMonthlyNotifyThanks'));
    	$message->action(trans('emails.billingMonthlyNotifyButton'), route('accounting.index'));
        $message->salutation("\r\n");
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
