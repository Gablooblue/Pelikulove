<?php

namespace App\Notifications;

use Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendDailyStats extends Notification implements ShouldQueue
{
    use Queueable;

	protected $userData, $vodData, $courseData;

    /**
     * Create a new notification instance.
     */
    public function __construct($userData, $vodData, $courseData)
    {
        $this->userData = $userData;
        $this->vodData = $vodData;
        $this->courseData = $courseData;
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
        $users = $this->userData['users'];
        $enrolled = $this->userData['enrolled'];
        $orders = $this->userData['orders'];

        $allVodStats = $this->vodData['allVodStats'];
        $dailyStats = $this->vodData['dailyStats'];
        $vodPurchases = $this->vodData['vodPurchases'];

        $allCompletedCourseStats = $this->courseData['allCompletedStats'];
        
        $top5Videos = collect();

        foreach ($allVodStats->sortByDesc('totalViews')->slice(0, 5) as $vodStat) {
            $video = collect();
            $video->title = $vodStat->title;
            $video->totalViews = $vodStat->totalViews;
            
            $top5Videos->push($video);
        }

        $count = 1;
        $courseDailyHTML = null;
        foreach ($allCompletedCourseStats as $completedCourseStats) {
            
            $courseDailyHTML .= $count . '. ' . $completedCourseStats->title . ': ' . $completedCourseStats->weeklyCompletions . ' <br>';

            $count++;
        }

        $style = "font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;border-radius:3px;color:#fff;display:inline-block;text-decoration:none;background-color:#e42424;border-top:10px solid #e42424;border-right:18px solid #e42424;border-bottom:10px solid #e42424;border-left:18px solid #e42424";

    	$message = new MailMessage();
        $message->subject(trans('[Pelikulove] Stats for '. date('M j, Y',strtotime(' - 1 days')) ))
            ->greeting(trans('Here are the Stats for '. date('M j, Y',strtotime(' - 1 days')) ))
            ->line('<strong>User Stats</strong>')
            ->line('Total number of new Registered users: ' . $users->count())
            ->line('Total number of new Enrolled users (including non-paying): ' . $enrolled->count())
            ->line('Total number of new Paid users: ' . $orders->count())
            ->line('<a href="' . route('orders.index') . '" style="' . $style . '">Login to Orders</a>')
            ->line('<br>')
            ->line('<strong>Blackbox Stats</strong>')
            // ->line('Most Viewed Video: ' . $allVodStats->sortByDesc('totalViews')->first()->title)
            ->line('Top Viewed Videos:')
            ->line('1. ' . $top5Videos->first()->title . ' - ' . $top5Videos->first()->totalViews . ' views')
            ->line('2. ' . $top5Videos[1]->title . ' - ' . $top5Videos[1]->totalViews . ' views')
            ->line('3. ' . $top5Videos[2]->title . ' - ' . $top5Videos[2]->totalViews . ' views')
            ->line('4. ' . $top5Videos[3]->title . ' - ' . $top5Videos[3]->totalViews . ' views')
            ->line('5. ' . $top5Videos[4]->title . ' - ' . $top5Videos[4]->totalViews . ' views')
            ->line('Total Video views: ' . $dailyStats->totalViews)
            ->line('Total Registered views: ' . $dailyStats->registeredViews)
            ->line('Total Unique Reg. views: ' . $dailyStats->uniqueRegUsers)
            // ->line('Total Unique views: ' . $dailyStats->uniqueUsers)
            // ->line('Total Unregistered views: ' . $dailyStats->guestViews)
            // ->line('Total Video finishes: ' . $dailyStats->finishes)
            ->line('Total Video Purchases: ' . $vodPurchases->count())
            ->line('<a href="' . route('analytics.vod') . '" style="' . $style . '">Login to Analytics</a>')
            ->line('<br>')
            
            ->line('Course Completions:')
            ->line($courseDailyHTML)
            ->line('<br>');
            // ->action('Login to Analytics', route('analytics.vod'));
       
        return $message;

        /*
        'registerNotifySubject'  => '[Pelikulove] User Stats for :day',
        'registerNotifyGreeting' => 'Here are the User Stats for :day:',
        'registerNotifyMessage1'  => 'Total number of Registered users: :rcount',
        'registerNotifyMessage2'  => 'Total number of Enrolled users (including non-paying): :ecount',
        'registerNotifyMessage3'  => 'Total number of Paid users: :pcount',
        'registerNotifyButton'   => 'Login to Orders',
        */
       
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
