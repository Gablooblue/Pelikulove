<?php

namespace App\Console\Commands;

use App\Models\LoggerActivity;
use App\Models\AnalyticsLog;
use App\Models\VodPurchase;
use App\Models\VodStats;
use App\Models\Vod;
use App\Models\User;
use App\Models\Order;
use App\Models\Lesson;
use App\Models\Course;
use App\Models\LearnerCourse;

use Carbon\Carbon;

use Notifications;
use App\Notifications\SendWeeklyStats;
use Illuminate\Support\Facades\Notification;

use Illuminate\Console\Command;

class MailWeeklyStats extends Command
{
    
    protected $signature = 'weeklystats:mail';
    
    protected $description = 'Send weekly stats of registered and enrolled users, and vod analytics';
    
    public function __construct()
    {
        parent::__construct();
       
    }
    
    public function handle()
    {     
        $log = Carbon::now()->toDateTimeString() . " - ";

    // User Stats Start    
    	$users = null;
    	$enrolled = null;
    	
    
        $users = User::whereRaw('Date(created_at) < CURDATE()')
                    ->get();
                  
        $enrolled = LearnerCourse::whereRaw('Date(created_at) < CURDATE()')
                    ->where('course_id', '!=', 2)
        		  	->get();
        		  
        $orders = Order::whereRaw('Date(updated_at) < CURDATE()')
        			->where('amount', '>', 0)
        			->where('payment_status', 'S')
        			->where('payment_id', '!=', 6)
        		    ->get();
    // User Stats End

    // Vod Stats Start      
        $vodPurchases = VodPurchase::get();

        // Lifetime Blackbox Stats Start   
        //         
        $rawAllVodStats = AnalyticsLog::select('content')
        ->where('type', 'VOD-Daily')
        ->where('date', '<=', Carbon::parse(Carbon::now()->subDay(1))->format('Y-m-d'))
        ->get();

        $allVodStats = collect();
        foreach ($rawAllVodStats as $rawVodStat) {
            $content = json_decode($rawVodStat->content , true);
            $allVodStats->push($content);
        }   

        $newWeeklyVodStats = collect();   
        foreach ($allVodStats[0]['vods'] as $vodTitle) {     
            $vodStats = new VodStats;  
            $vodStats->title = $vodTitle['title'];
            $vodStats->id = $vodTitle['id'];
            $vodStats->totalViews = 0;
            $vodStats->uniqueUsers = 0;
            $vodStats->uniqueRegUsers = 0;
            $vodStats->registeredViews = 0;
            $vodStats->guestViews = 0;

            $newWeeklyVodStats->push($vodStats);    
        }    

        $lifetimeStats = collect();      
		$lifetimeStats->totalViews = 0;
		$lifetimeStats->uniqueUsers = 0;
		$lifetimeStats->uniqueRegUsers = 0;
		$lifetimeStats->registeredViews = 0;
        $lifetimeStats->guestViews = 0;
        
        foreach ($allVodStats as $dailyVodStat) {
            $lifetimeStats->totalViews += $dailyVodStat['totalViews'];
            $lifetimeStats->uniqueUsers += $dailyVodStat['uniqueViewsCount'];
            $lifetimeStats->uniqueRegUsers += $dailyVodStat['uniqueRegViewsCount'];
            $lifetimeStats->registeredViews += $dailyVodStat['registeredViews'];
            $lifetimeStats->guestViews += $dailyVodStat['guestViews'];
            // Convert Daily Stats to Vod Stats
            foreach ($dailyVodStat['vods'] as $vodTitle) {     
                $vodStats = $newWeeklyVodStats->firstWhere('id', $vodTitle['id']);
                $vodStats->totalViews += $vodTitle['totalViews'];
                $vodStats->uniqueUsers += $vodTitle['uniqueViewsCount'];
                $vodStats->uniqueRegUsers += $vodTitle['uniqueRegViewsCount'];
                $vodStats->registeredViews += $vodTitle['registeredViews'];
                $vodStats->guestViews += $vodTitle['guestViews'];
            }  
        }
        $allVodStats = $newWeeklyVodStats; 
        //
        // Lifetime Blackbox Stats End

        // Weekly Blackbox Stats Start     
        //
    	$start = Carbon::now()->subWeek();
        $end = Carbon::now()->subDay(1);
        
        $rawWeeklyVodStats = AnalyticsLog::select('content')
        ->where('type', 'VOD-Daily')
        ->where('date', '>=', Carbon::parse($start)->format('Y-m-d'))
        ->where('date', '<=', Carbon::parse($end)->format('Y-m-d'))
        ->get();

        $weeklyVodStats = collect();
        foreach ($rawWeeklyVodStats as $rawVodStat) {
            $content = json_decode($rawVodStat->content , true);
            $weeklyVodStats->push($content);
        }   

        $newWeeklyVodStats = collect();   
        foreach ($weeklyVodStats[0]['vods'] as $vodTitle) {     
            $vodStats = new VodStats;  
            $vodStats->title = $vodTitle['title'];
            $vodStats->id = $vodTitle['id'];
            $vodStats->totalViews = 0;
            $vodStats->uniqueUsers = 0;
            $vodStats->uniqueRegUsers = 0;
            $vodStats->registeredViews = 0;
            $vodStats->guestViews = 0;

            $newWeeklyVodStats->push($vodStats);    
        }    

        $weeklyStats = collect();      
		$weeklyStats->totalViews = 0;
		$weeklyStats->uniqueUsers = 0;
		$weeklyStats->uniqueRegUsers = 0;
		$weeklyStats->registeredViews = 0;
        $weeklyStats->guestViews = 0;
        
        foreach ($weeklyVodStats as $dailyVodStat) {
            $weeklyStats->totalViews += $dailyVodStat['totalViews'];
            $weeklyStats->uniqueUsers += $dailyVodStat['uniqueViewsCount'];
            $weeklyStats->uniqueRegUsers += $dailyVodStat['uniqueRegViewsCount'];
            $weeklyStats->registeredViews += $dailyVodStat['registeredViews'];
            $weeklyStats->guestViews += $dailyVodStat['guestViews'];
            // Convert Daily Stats to Vod Stats
            foreach ($dailyVodStat['vods'] as $vodTitle) {     
                $vodStats = $newWeeklyVodStats->firstWhere('id', $vodTitle['id']);
                $vodStats->totalViews += $vodTitle['totalViews'];
                $vodStats->uniqueUsers += $vodTitle['uniqueViewsCount'];
                $vodStats->uniqueRegUsers += $vodTitle['uniqueRegViewsCount'];
                $vodStats->registeredViews += $vodTitle['registeredViews'];
                $vodStats->guestViews += $vodTitle['guestViews'];
            }  
        }
        $weeklyVodStats = $newWeeklyVodStats; 
        //
        // Weekly Blackbox Stats End
    // Vod Stats End

    // Course Stats Start
        $courses = Course::where('id', '!=', 2)
        ->get();

        $allCompletedStats = collect();

        foreach ($courses as $course) {
            $allCompletions = Lesson::getLessonCompleted($course->id, 'AllExceptToday'); 
            
            $allCount = 0;
            if (isset($allCompletions)) {
                foreach ($allCompletions[$course->id] as $key => $value ) :
                    if (count($allCompletions[$course->id][$key]) > 13) $allCount++;
                endforeach;   
            }
            
            $weeklyCompletions = Lesson::getLessonCompleted($course->id, 'AllExcept1week'); 
            
            $weeklyCount = 0;
            if (isset($weeklyCompletions)) {
                foreach ($weeklyCompletions[$course->id] as $key => $value ) :
                    if (count($weeklyCompletions[$course->id][$key]) > 13) $weeklyCount++;
                endforeach;  
            }
                        
            $courseStats = collect();
            $courseStats->id = $course->id;
            $courseStats->title = $course->title;
            $courseStats->allCompletions = $allCount;
            $courseStats->weeklyCompletions = ($allCount - $weeklyCount);

            $allCompletedStats->push($courseStats);    
        } 
    // Course Stats End

        $userData = [
            'users' => $users, 
            'enrolled' => $enrolled, 
            'orders' => $orders
        ];

        $vodData = [
            'allVodStats' => $allVodStats, 
            'weeklyVodStats' => $weeklyVodStats, 
            'vodPurchases' => $vodPurchases,
            'lifetimeStats' => $lifetimeStats, 
            'weeklyStats' => $weeklyStats, 
        ];

        $courseData = [
            'allCompletedStats' => $allCompletedStats, 
        ];
        
        $admins = [1, 10, 12, 16, 87, 412, 1416];
        // $admins = [412];
        foreach ($admins as $a) :
        	$admin = User::find($a);
            if (isset($admin)) 
                Notification::send($admin, new SendWeeklyStats($userData, $vodData, $courseData));

        endforeach;	  	        

        $log .= Carbon::now()->toDateTimeString() . ": Sent weekly stats \n";   
        echo $log;  
    }    
}
