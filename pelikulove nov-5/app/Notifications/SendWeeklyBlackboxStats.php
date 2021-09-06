<?php

namespace App\Notifications;

use Auth;

use Carbon\Carbon;

use App\Models\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendWeeklyBlackboxStats extends Notification implements ShouldQueue
{
    use Queueable;

	protected $allVodStats, $weeklyVodStats, $vodPurchases, $lifetimeStats, $weeklyStats;

    /**
     * Create a new notification instance.
     */
    public function __construct($allVodStats, $weeklyVodStats, $vodPurchases, $lifetimeStats, $weeklyStats)
    {
        $this->allVodStats = $allVodStats;
        $this->weeklyVodStats = $weeklyVodStats;
        $this->vodPurchases = $vodPurchases;
        $this->lifetimeStats = $lifetimeStats;
        $this->weeklyStats = $weeklyStats;
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

        $allVodStats = $this->allVodStats;
        $weeklyVodStats = $this->weeklyVodStats;
        $lifetimeStats = $this->lifetimeStats;
        $weeklyStats = $this->weeklyStats;

        $vodPurchasesCount = $this->vodPurchases->count();
        $weeklyVodPurchasesCount = $this->vodPurchases->where('created_at',  '>=', \Carbon\Carbon::parse($start)->format('Y-m-d'))->count();

    	$message = new MailMessage();
        $message->subject(trans('[Pelikulove] Blackbox Stats for ' . \Carbon\Carbon::parse($start)->format('M j') . ' to ' . \Carbon\Carbon::parse($end)->format('M j, Y')))
            ->greeting(trans('Here are the Blackbox Stats:'))

            ->line('<strong>Alltime Blackbox Stats:</strong>')
            ->line('Total Video Purchases: ' . $vodPurchasesCount)
            ->line('Most Viewed Video: ' . $allVodStats->sortByDesc('totalViews')->first()->title)
            ->line('Total Video views: ' . $lifetimeStats->totalViews)
            // ->line('Total Registered views: ' . $lifetimeStats->registeredViews)
            // ->line('Total Unique views: ' . $lifetimeStats->uniqueUsers)
            // ->line('Total Unregistered views: ' . $lifetimeStats->guestViews)
            ->line('Total Video finishes: ' . $lifetimeStats->finishes)

            ->line('<br>')
            
            ->line('<strong>Blackbox Stats from ' . \Carbon\Carbon::parse($start)->format('M j') . ' to ' . \Carbon\Carbon::parse($end)->format('M j, Y') . '</strong>')
            ->line('Total Video Purchases: ' . $weeklyVodPurchasesCount)
            ->line('Most Viewed Video: ' . $weeklyVodStats->sortByDesc('totalViews')->first()->title)
            ->line('Total Video views: ' . $weeklyStats->totalViews)
            // ->line('Total Registered views: ' . $weeklyStats->registeredViews)
            // ->line('Total Unique views: ' . $weeklyStats->uniqueUsers)
            // ->line('Total Unregistered views: ' . $weeklyStats->guestViews)
            ->line('Total Video finishes: ' . $weeklyStats->finishes)

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
