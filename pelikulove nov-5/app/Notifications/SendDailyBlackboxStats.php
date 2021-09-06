<?php

namespace App\Notifications;

use Auth;
use App\Models\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendDailyBlackboxStats extends Notification implements ShouldQueue
{
    use Queueable;

	protected $allVodStats, $dailyStats, $vodPurchases;

    /**
     * Create a new notification instance.
     */
    public function __construct($allVodStats, $dailyStats, $vodPurchases)
    {
        $this->allVodStats = $allVodStats;
        $this->dailyStats = $dailyStats;
        $this->vodPurchases = $vodPurchases;
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
        $allVodStats = $this->allVodStats;
        $dailyStats = $this->dailyStats;
        $vodPurchases = $this->vodPurchases;

    	$message = new MailMessage();
        $message->subject(trans('[Pelikulove] Blackbox Stats for '. date('M j, Y',strtotime(' - 1 days')) ))
            ->greeting(trans('Here are the Blackbox Stats for '. date('M j, Y',strtotime(' - 1 days')) ))
            ->line('Total Video Purchases: ' . $vodPurchases->count())
            ->line('Most Viewed Video: ' . $allVodStats->sortByDesc('totalViews')->first()->title)
            ->line('Total Video views: ' . $dailyStats->totalViews)
            // ->line('Total Registered views: ' . $dailyStats->registeredViews)
            // ->line('Total Unique views: ' . $dailyStats->uniqueUsers)
            // ->line('Total Unregistered views: ' . $dailyStats->guestViews)
            ->line('Total Video finishes: ' . $dailyStats->finishes)
            ->action('Login to Analytics', route('analytics.vod'));
       
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
