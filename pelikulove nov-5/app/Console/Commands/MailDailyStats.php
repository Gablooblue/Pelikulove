<?php

namespace App\Console\Commands;

use App\Models\LoggerActivity;
use App\Models\VodPurchase;
use App\Models\VodStats;
use App\Models\Vod;
use App\Models\User;
use App\Models\Lesson;
use App\Models\Course;
use App\Models\AnalyticsLog;

use App\Models\Order;
use App\Models\LearnerCourse;

use Notifications;
use Carbon\Carbon;
use App\Notifications\SendDailyStats;
use Illuminate\Support\Facades\Notification;

use Illuminate\Console\Command;

class MailDailyStats extends Command
{
    
    protected $signature = 'dailystats:mail';
    
    protected $description = 'Send daily stats of registered and enrolled users, and vod analytics';
    
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
    	
        $users = User::whereRaw('DATE(created_at) = DATE_ADD(CURDATE(), INTERVAL -1 DAY)')
                  ->get();
                  
        $enrolled = LearnerCourse::whereRaw('DATE(created_at) = DATE_ADD(CURDATE(), INTERVAL -1 DAY)')
                  ->where('course_id', '!=', 2)
        		  ->get();
        		  
        $orders = Order::whereRaw('Date(updated_at) = DATE_ADD(CURDATE(), INTERVAL -1 DAY)')
        			->where('amount', '>', 0)
        			->where('payment_status', 'S')
        			->where('payment_id', '!=', 6)
                    ->get();                            
    // User Stats End  
        
    // Vod Stats Start   
        $vodPurchases = VodPurchase::whereRaw('DATE(created_at) = DATE_ADD(CURDATE(), INTERVAL -1 DAY)')
        ->get();

        $rawVodStat = AnalyticsLog::select('content')
        ->where('type', 'VOD-Daily')
        ->where('date', Carbon::now()->subDay()->format('Y-m-d'))
        ->first();

        $allVodStats = collect();
        $allVodStats = json_decode($rawVodStat->content , true);
        
        $newAllVodStat = collect();
        
        foreach ($allVodStats['vods'] as $vodTitle) {     
            $vodStats = collect();
            $vodStats->id = $vodTitle['id'];
            $vodStats->title = $vodTitle['title'];
            $vodStats->totalViews = $vodTitle['totalViews'];
            $vodStats->uniqueViewsCount = $vodTitle['uniqueViewsCount'];
            $vodStats->uniqueRegViewsCount = $vodTitle['uniqueRegViewsCount'];
            $vodStats->registeredViews = $vodTitle['registeredViews'];
            $vodStats->guestViews = $vodTitle['guestViews'];
            $newAllVodStat->push($vodStats);   
        }

        $dailyStats = collect();     
		$dailyStats->totalViews = $allVodStats['totalViews'];
		$dailyStats->uniqueUsers = $allVodStats['uniqueViewsCount'];
		$dailyStats->uniqueRegUsers = $allVodStats['uniqueRegViewsCount'];
		$dailyStats->registeredViews = $allVodStats['registeredViews'];
		$dailyStats->guestViews = $allVodStats['guestViews'];  
        
        $allVodStats = $newAllVodStat;                       
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

            $dailyCompletions = Lesson::getLessonCompleted($course->id, 'AllExcept1day'); 

            $dailyCount = 0;
            if (isset($dailyCompletions)) {
                foreach ($dailyCompletions[$course->id] as $key => $value ) :
                    if (count($dailyCompletions[$course->id][$key]) > 13) $dailyCount++;
                endforeach;   
            }
                        
            $courseStats = collect();
            $courseStats->id = $course->id;
            $courseStats->title = $course->title;
            $courseStats->weeklyCompletions = ($allCount - $dailyCount);

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
            'dailyStats' => $dailyStats, 
            'vodPurchases' => $vodPurchases
        ];

        $courseData = [
            'allCompletedStats' => $allCompletedStats, 
        ];
        			  
        $admins = [1, 10, 12, 16, 87, 412, 1416];
        // $admins = [412];
        foreach ($admins as $a) :
        	$admin = User::find($a);
            if (isset($admin)) 
                Notification::send($admin, new SendDailyStats($userData, $vodData, $courseData));

        endforeach;	  

        $log .= Carbon::now()->toDateTimeString() . ": Sent daily stats \n"; ;  
        echo $log;
    }    
}
