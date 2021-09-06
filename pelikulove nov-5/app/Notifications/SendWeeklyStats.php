<?php

namespace App\Notifications;

use Auth;

use Carbon\Carbon;

use App\Models\User;
use App\Models\LearnerCourse;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendWeeklyStats extends Notification implements ShouldQueue
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
    	$start = \Carbon\Carbon::now()->subWeek();
        $end = \Carbon\Carbon::now()->subDay(1);

        $users = $this->userData['users'];
        $enrolled = $this->userData['enrolled'];
        $orders = $this->userData['orders'];

        $allVodStats = $this->vodData['allVodStats'];
        $weeklyVodStats = $this->vodData['weeklyVodStats'];
        $lifetimeStats = $this->vodData['lifetimeStats'];
        $weeklyStats = $this->vodData['weeklyStats'];
        $vodPurchasesCount = $this->vodData['vodPurchases']->count();
        $weeklyVodPurchasesCount = $this->vodData['vodPurchases']->where('created_at',  '>=', \Carbon\Carbon::parse($start)->format('Y-m-d'))->count();
        
        $allCompletedCourseStats = $this->courseData['allCompletedStats'];

        $top5Videos = collect();

        foreach ($allVodStats->sortByDesc('totalViews')->slice(0, 5) as $vodStat) {
            $video = collect();
            $video->title = $vodStat->title;
            $video->totalViews = $vodStat->totalViews;
            
            $top5Videos->push($video);
        }

        $weeklyTop5Videos = collect();

        foreach ($weeklyVodStats->sortByDesc('totalViews')->slice(0, 5) as $vodStat) {
            $video = collect();
            $video->title = $vodStat->title;
            $video->totalViews = $vodStat->totalViews;
            
            $weeklyTop5Videos->push($video);
        }

        $count = 1;
        $courseAlltimeHTML = null;
        $courseWeeklyHTML = null;
        foreach ($allCompletedCourseStats as $completedCourseStats) {
            $enroleesAmt = LearnerCourse::select('user_id')->where('course_id', '=', $completedCourseStats->id)->distinct()->get()->count();

            $courseAlltimeHTML .= $count . '. ' . $completedCourseStats->title . ': ' . $completedCourseStats->allCompletions . '/' . $enroleesAmt . '<br>';
            
            $courseWeeklyHTML .= $count . '. ' . $completedCourseStats->title . ': ' . $completedCourseStats->weeklyCompletions . '<br>';

            $count++;
        }
        
        $style = "font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;border-radius:3px;color:#fff;display:inline-block;text-decoration:none;background-color:#e42424;border-top:10px solid #e42424;border-right:18px solid #e42424;border-bottom:10px solid #e42424;border-left:18px solid #e42424";

    	$message = new MailMessage();
        $message->subject(trans('[Pelikulove] Stats for ' . \Carbon\Carbon::parse($start)->format('M j') . ' to ' . \Carbon\Carbon::parse($end)->format('M j, Y')))
            ->greeting(trans('Here are the Stats:'))

            ->line('<strong>Lifetime User Stats</strong>')
            ->line('Total number of Registered users: ' . $users->count())
            ->line('Total number of Enrolled users (including non-paying): ' . $enrolled->count())
            ->line('Total number of Paid users: ' . $orders->count())
            ->line('<br>') 
            ->line('<strong>User Stats from ' . \Carbon\Carbon::parse($start)->format('M j') . ' to ' . \Carbon\Carbon::parse($end)->format('M j, Y') . '</strong>')
            ->line('Total number of new Registered users: ' . $users->where('created_at',  '>=', \Carbon\Carbon::parse($start)->format('Y-m-d'))->count())
            ->line('Total number of new Enrolled users (including non-paying): ' . $enrolled->where('created_at',  '>=', \Carbon\Carbon::parse($start)->format('Y-m-d'))->count())
            ->line('Total number of new Paid users: ' . $orders->where('created_at',  '>=', \Carbon\Carbon::parse($start)->format('Y-m-d'))->count())
            ->line('<a href="' . route('orders.index') . '" style="' . $style . '">Login to Orders</a>')
            ->line('<br>') 

            ->line('<strong>Alltime Blackbox Stats</strong>')
            // ->line('Most Viewed Video: ' . $allVodStats->sortByDesc('totalViews')->first()->title)
            ->line('Top Viewed Videos:')
            ->line('1. ' .$top5Videos->first()->title . ' - ' .$top5Videos->first()->totalViews . ' views')
            ->line('2. ' .$top5Videos[1]->title . ' - ' .$top5Videos[1]->totalViews . ' views')
            ->line('3. ' .$top5Videos[2]->title . ' - ' .$top5Videos[2]->totalViews . ' views')
            ->line('4. ' .$top5Videos[3]->title . ' - ' .$top5Videos[3]->totalViews . ' views')
            ->line('5. ' .$top5Videos[4]->title . ' - ' .$top5Videos[4]->totalViews . ' views')
            ->line('Total Video views: ' . $lifetimeStats->totalViews)
            ->line('Total Registered views: ' . $lifetimeStats->registeredViews)
            ->line('Total Unique Reg. views: ' . $lifetimeStats->uniqueRegUsers)
            // ->line('Total Video finishes: ' . $lifetimeStats->finishes)
            ->line('Total Video Purchases: ' . $vodPurchasesCount)
            ->line('<br>')            
            ->line('<strong>Blackbox Stats from ' . \Carbon\Carbon::parse($start)->format('M j') . ' to ' . \Carbon\Carbon::parse($end)->format('M j, Y') . '</strong>')
            // ->line('Most Viewed Video: ' . $weeklyVodStats->sortByDesc('totalViews')->first()->title)
            ->line('Top Viewed Videos:')
            ->line('1. ' . $weeklyTop5Videos->first()->title . ' - ' . $weeklyTop5Videos->first()->totalViews . ' views')
            ->line('2. ' . $weeklyTop5Videos[1]->title . ' - ' . $weeklyTop5Videos[1]->totalViews . ' views')
            ->line('3. ' . $weeklyTop5Videos[2]->title . ' - ' . $weeklyTop5Videos[2]->totalViews . ' views')
            ->line('4. ' . $weeklyTop5Videos[3]->title . ' - ' . $weeklyTop5Videos[3]->totalViews . ' views')
            ->line('5. ' . $weeklyTop5Videos[4]->title . ' - ' . $weeklyTop5Videos[4]->totalViews . ' views')
            ->line('Total Video views: ' . $weeklyStats->totalViews)
            ->line('Total Registered views: ' . $weeklyStats->registeredViews)
            ->line('Total Unique Reg. views: ' . $weeklyStats->uniqueRegUsers)
            // ->line('Total Video finishes: ' . $weeklyStats->finishes)
            ->line('Total Video Purchases: ' . $weeklyVodPurchasesCount)
            ->line('<a href="' . route('analytics.vod') . '" style="' . $style . '">Login to Analytics</a>')
            ->line('<br>')   

            ->line('<strong>Alltime Course Completions over Enrollees Amount: </strong>')   
            ->line($courseAlltimeHTML)   
            ->line('<strong>Course Completions from ' . \Carbon\Carbon::parse($start)->format('M j') . ' to ' . \Carbon\Carbon::parse($end)->format('M j, Y') . '</strong>')
            ->line($courseWeeklyHTML)
            ->line('<br>');
                        
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
