<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;

use App\Models\LoggerActivity;
use App\Models\Vod;
use App\Models\VodStats;
use App\Models\User;
use App\Models\AnalyticsLog;
use App\Models\LearnerCourse;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Topic;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class GenerateAnalytics extends Command
{
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'analytics:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new analytics logs';

    /**
     * Create a new command instance.
     *
     * DeleteExpiredActivations constructor.
     *
     * @param ActivationRepository $activationRepository
     */
    public function __construct()
    {
        parent::__construct();
       
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // $start = microtime(true);
		$this->getAllStats();  
        // $time_elapsed_secs = microtime(true) - $start;
        // echo $time_elapsed_secs;
    }

    public function getAllStats() {
        $log = Carbon::now()->toDateTimeString() . " - ";

    // Blackbox Stats Start
        $allVodViews = LoggerActivity::where('description', 'LIKE', '%blackbox%watch%')
        ->where('userType', '!=', 'Crawler')
        ->orderBy('created_at', 'desc')
        ->get();

        // Remove Non-existing Videos
        $allVodViews = $allVodViews->filter(function ($vodView) {
            $descExplode = explode("/", $vodView->description);
            $vod_id = $descExplode[1];
            $vod = Vod::find($vod_id);
            
            if (isset($vod)) {
                $vodView->vodTitle = $vod->title;
            }

            $user = User::find($vodView->userId);
            
            if (isset($user)) {                
                $vodView->username = $user->name;
            }
            
            return isset($vodView->vodTitle);
        }); 

        // Get Time Period of analytics
        $startDate = Carbon::parse($allVodViews->last()->created_at);
        $endDate = Carbon::now()->addDay();
        $timePeriod = CarbonPeriod::create($startDate, $endDate);
        
        $vodDailyStats = collect();  
        $allVods = Vod::select('title', 'id')->get();

        // Iterate over the period and initialise the collection
        foreach ($timePeriod as $date) {            
            $dayStats = new VodStats;
            $dayStats->date = $date->toDateString();
            $dayStats->totalViews = 0;
            $dayStats->uniqueViews = collect();
            $dayStats->uniqueViewsCount = 0;
            $dayStats->uniqueRegViews = collect();
            $dayStats->uniqueRegViewsCount = 0;
            $dayStats->registeredViews = 0;
            $dayStats->guestViews = 0; 
            $dayStats->vods = collect();  

            foreach ($allVods as $oneVod) {
                $newVod = new Vod;
                $newVod->id = $oneVod->id;
                $newVod->title = $oneVod->title;
                $newVod->date = $date->toDateString();
                $newVod->totalViews = 0;
                $newVod->uniqueViews = collect();
                $newVod->uniqueViewsCount = 0;
                $newVod->uniqueRegViews = collect();
                $newVod->uniqueRegViewsCount = 0;
                $newVod->registeredViews = 0;
                $newVod->guestViews = 0;   
                
                $dayStats->vods->push($newVod);
            } 

            $vodDailyStats->push($dayStats);  
        }
        
        // Iterate over all the views and add the stats by Day
        foreach ($allVodViews as $vodView) {  
            $dayStats = $vodDailyStats->firstWhere('date', Carbon::parse($vodView->created_at)->toDateString());
            
            $vod = $dayStats->vods->firstWhere('title', $vodView->vodTitle);

            if ($vodView->userType == "Registered") {
                $dayStats->totalViews++;   
                $dayStats->registeredViews++;   
                $vod->totalViews++;   
                $vod->registeredViews++;  

                // Unique User ID Count
                // Check if the day already has a uniqueView
                if (isset($dayStats->uniqueRegViews->first()->userId)) {
                    // Check if the view's IP Address is already recorded for that day
                    $exist = $dayStats->uniqueRegViews->firstWhere('userId', $vodView->userId);
                    if (!isset($exist)) {
                        $dayStats->uniqueRegViews->push($vodView); 
                    }
                    $existVod = $vod->uniqueRegViews->firstWhere('userId', $vodView->userId);
                    if (!isset($existVod)) {
                        $vod->uniqueRegViews->push($vodView);  
                    }
                } else {
                    // Add the first view into the day
                    $dayStats->uniqueRegViews->push($vodView);  
                    $vod->uniqueRegViews->push($vodView);  
                }

                $dayStats->uniqueRegViewsCount = $dayStats->uniqueRegViews->count();
                $vod->uniqueRegViewsCount = $vod->uniqueRegViews->count();
                
            } else if ($vodView->userType == 'Guest') {
                $dayStats->totalViews++;   
                $dayStats->guestViews++;   
                $vod->totalViews++;   
                $vod->guestViews++;   
            }      

            // Unique IP Address Count
            // Check if the day already has a uniqueView
            if (isset($dayStats->uniqueViews->first()->ipAddress)) {
                // Check if the view's IP Address is already recorded for that day
                $exist = $dayStats->uniqueViews->firstWhere('ipAddress', $vodView->ipAddress);
                if (!isset($exist)) {
                    $dayStats->uniqueViews->push($vodView); 
                }
                $existVod = $vod->uniqueViews->firstWhere('ipAddress', $vodView->ipAddress);
                if (!isset($existVod)) {
                    $vod->uniqueViews->push($vodView);  
                }
            } else {
                // Add the first view into the day
                $dayStats->uniqueViews->push($vodView);  
                $vod->uniqueViews->push($vodView);  
            }

            $dayStats->uniqueViewsCount = $dayStats->uniqueViews->count();
            $vod->uniqueViewsCount = $vod->uniqueViews->count();
        }
    // Blackbox Stats End

    // User Stats Start
        $allRegVodViews = LoggerActivity::join('users', 'laravel_logger_activity.userId', '=', 'users.id')
        ->join('role_user', 'users.id', '=', 'role_user.user_id')
        ->select('users.id', 'users.name', 'users.first_name', 'users.last_name', 'users.email', 'laravel_logger_activity.description', 'laravel_logger_activity.created_at')
        ->where('laravel_logger_activity.description', 'LIKE', '%blackbox%watch%')
        ->where('laravel_logger_activity.userType', '=', 'Registered')
        ->where('role_user.role_id', '!=', '5') // Exclude Admin Roles
        ->where('role_user.role_id', '!=', '1') // Exclude Moderator Roles
        ->where('users.id', '!=', '680') // Temporarily Exclude Admin Fb Acc
        ->orderBy('laravel_logger_activity.created_at', 'asc')
        ->get(); 
        
        $allRegVodViews = $allRegVodViews->filter(function ($vodView) {
            $descExplode = explode("/", $vodView->description);
            $vod_id = $descExplode[1];
            $vod = Vod::find($vod_id);
            
            if (!isset($vod)) {     
                $vodView->description = null;          
                return null;
            } else {  
                $vodView->description = null;   
                return true;
            }            
        });  

        $allActiveUsers = collect();

        $loop = 0;
        foreach ($allRegVodViews as $regVodView) {
            if (!$allActiveUsers->contains('id', $regVodView->id)) {
                $allActiveUsers->push($regVodView);
            }  
            $loop++;          
        }

        foreach ($allActiveUsers as $activeUser) {
            foreach ($allRegVodViews as $regVodView) {                   
                if ($regVodView->id == $activeUser->id) {
                    if (isset($activeUser->views)) {
                        $activeUser->views++;    
                    } else {
                        $activeUser->views = 1;
                    }
                } 
            }
        }
    // User Stats End

    // Registrant and Enrollees Stats Start
        $enrollees = LearnerCourse::join('orders', 'orders.id', '=', 'learnercourses.order_id')
        ->select('learnercourses.*', 'orders.id', 'orders.amount')
        ->where('learnercourses.created_at', '>=', '2019-06-18')
        ->orderBy('learnercourses.created_at', 'desc')
        ->get();
        $users = User::where('created_at', '>=', '2019-06-18')
        ->orderBy('created_at', 'desc')
        ->get();

        $startDate = Carbon::parse('2019-06-18')->toDateString();
        $endDate = Carbon::now()->addDay();
        $timePeriod = CarbonPeriod::create($startDate, $endDate);

        $regAndEnrolDailyStats = collect();  

        // Iterate over the period and initialise the collection
        foreach ($timePeriod as $date) {            
            $regAndEnrolDayStats = new VodStats;
            $regAndEnrolDayStats->date = $date->toDateString();
            $regAndEnrolDayStats->totalEnrollees = 0;
            $regAndEnrolDayStats->paidEnrollees = 0;
            $regAndEnrolDayStats->freeEnrollees = 0;
            $regAndEnrolDayStats->totalRegistrants = 0; 
            $regAndEnrolDayStats->websiteRegistrants = 0; 
            $regAndEnrolDayStats->adminRegistrants = 0; 
            
            $regAndEnrolDailyStats->push($regAndEnrolDayStats);  
        }

        $paidEnrolleesCount = 0;  

        foreach ($enrollees as $enrollee) {   
            // dd( Carbon::parse($enrollee->created_at)->toDateString()); 
            $regAndEnrolDayStats = $regAndEnrolDailyStats->firstWhere('date', Carbon::parse($enrollee->created_at)->toDateString());

            $regAndEnrolDayStats->totalEnrollees++;
            if ($enrollee->amount > 0) {
                $paidEnrolleesCount++;
                $regAndEnrolDayStats->paidEnrollees++;
            } else {
                $regAndEnrolDayStats->freeEnrollees++;
            }
        }

        foreach ($users as $user) {     
            $regAndEnrolDayStats = $regAndEnrolDailyStats->firstWhere('date', Carbon::parse($user->created_at)->toDateString());

            $regAndEnrolDayStats->totalRegistrants++;
            if (isset($user->admin_ip_address)) {
                $regAndEnrolDayStats->adminRegistrants++;
            } else {
                $regAndEnrolDayStats->websiteRegistrants++;
            }
        }   

        $regAndEnrolDailyStats;
    // Registrant and Enrollees Stats End

    // Course Stats Start            
        $firstCourseView = LoggerActivity::where('route','LIKE','%lesson%topic%show%')
        ->orderBy('created_at', 'asc')
        ->first();

        $startDate = Carbon::parse($firstCourseView->created_at);
        $endDate = Carbon::now()->addDay();
        $timePeriod = CarbonPeriod::create($startDate, $endDate); 

        $courseDailyStats = collect();

        $allCourses = collect();
        $allCoursesBase = Course::select('id', 'title', 'short_title')
        ->get();        

        foreach ($allCoursesBase as $oneCourse) {
            $newCourse = new Lesson;
            $newCourse->id = $oneCourse->id;
            $newCourse->title = $oneCourse->title;
            $newCourse->short_title = $oneCourse->short_title;
            $newCourse->totalViews = 0;
            $newCourse->uniqueViews = collect();
            $newCourse->uniqueViewsCount = 0;
            $newCourse->uniqueRegViews = collect();
            $newCourse->uniqueRegViewsCount = 0;
            $newCourse->registeredViews = 0;
            $newCourse->guestViews = 0;   
            
            $allCourses->push($newCourse);
        } 

        $allLessons = collect();
        $allLessonsBase = Lesson::all();

        foreach ($allLessonsBase as $oneLesson) {
            $newLesson = new Lesson;
            $newLesson->id = $oneLesson->id;
            $newLesson->title = $oneLesson->title;
            $newLesson->course_id = $oneLesson->course_id;
            $newLesson->lorder = $oneLesson->lorder;
            $newLesson->totalViews = 0;
            $newLesson->uniqueViews = collect();
            $newLesson->uniqueViewsCount = 0;
            $newLesson->uniqueRegViews = collect();
            $newLesson->uniqueRegViewsCount = 0;
            $newLesson->registeredViews = 0;
            $newLesson->guestViews = 0;   
            
            $allLessons->push($newLesson);
        } 

        $allTopics = collect();
        $allTopicsBase = Topic::all();

        foreach ($allTopicsBase as $oneTopic) {
            $newTopic = new Topic;
            $newTopic->id = $oneTopic->id;
            $newTopic->title = $oneTopic->title;
            $newTopic->course_id = $oneTopic->course_id;
            $newTopic->lesson_id = $oneTopic->lesson_id;
            $newTopic->torder = $oneTopic->torder;
            $newTopic->totalViews = 0;
            $newTopic->uniqueViews = collect();
            $newTopic->uniqueViewsCount = 0;
            $newTopic->uniqueRegViews = collect();
            $newTopic->uniqueRegViewsCount = 0;
            $newTopic->registeredViews = 0;
            $newTopic->guestViews = 0;   
            
            $allTopics->push($newTopic);
        } 

        // Iterate over the period and initialise the collection
        foreach ($timePeriod as $date) {            
            $courseDayStats = new VodStats;
            $courseDayStats->date = $date->toDateString();
            $courseDayStats->totalViews = 0;
            $courseDayStats->uniqueViews = collect();
            $courseDayStats->uniqueViewsCount = 0;
            $courseDayStats->uniqueRegViews = collect();
            $courseDayStats->uniqueRegViewsCount = 0;
            $courseDayStats->registeredViews = 0;
            $courseDayStats->guestViews = 0; 
            $courseDayStats->courses = collect(); 

            foreach ($allCourses as $oneCourse) {
                $newCourse = new Course;
                $newCourse->id = $oneCourse->id;
                $newCourse->title = $oneCourse->title;
                $newCourse->short_title = $oneCourse->short_title;
                $newCourse->date = $date->toDateString();
                $newCourse->totalViews = 0;
                $newCourse->uniqueViews = collect();
                $newCourse->uniqueViewsCount = 0;
                $newCourse->uniqueRegViews = collect();
                $newCourse->uniqueRegViewsCount = 0;
                $newCourse->registeredViews = 0;
                $newCourse->guestViews = 0;   
                // $newCourse->lessons = collect(); 

                // $courseLessons = Lesson::where('course_id', $newCourse->id)
                // ->get();

                // foreach ($courseLessons as $oneLesson) {
                //     $newLesson = new Lesson;
                //     // $newLesson->id = $oneLesson->id;
                //     // $newLesson->title = $oneLesson->title;
                //     // $newLesson->course_id = $oneLesson->course_id;
                //     // $newLesson->lorder = $oneLesson->lorder;
                //     // $newLesson->date = $date->toDateString();
                //     // $newLesson->totalViews = 0;
                //     // $newLesson->uniqueViews = collect();
                //     // $newLesson->uniqueViewsCount = 0;
                //     // $newLesson->uniqueRegViews = collect();
                //     // $newLesson->uniqueRegViewsCount = 0;
                //     // $newLesson->registeredViews = 0;
                //     // $newLesson->guestViews = 0;   
                //     $newLesson->topics = collect(); 

                //     $lessonTopics = Topic::where('lesson_id', $newLesson->id)
                //     ->get();

                //     foreach ($lessonTopics as $oneTopic) {
                //         $newTopic = new Topic;
                //         // $newTopic->id = $oneTopic->id;
                //         // $newTopic->title = $oneTopic->title;
                //         // $newTopic->course_id = $oneTopic->course_id;
                //         // $newTopic->lesson_id = $oneTopic->lesson_id;
                //         // $newTopic->torder = $oneTopic->torder;
                //         // $newTopic->date = $date->toDateString();
                //         // $newTopic->totalViews = 0;
                //         // $newTopic->uniqueViews = collect();
                //         // $newTopic->uniqueViewsCount = 0;
                //         // $newTopic->uniqueRegViews = collect();
                //         // $newTopic->uniqueRegViewsCount = 0;
                //         // $newTopic->registeredViews = 0;
                //         // $newTopic->guestViews = 0;   
                        
                //         $newLesson->topics->push($newTopic);
                //     } 
                    
                //     $newCourse->lessons->push($newLesson);
                // } 
                
                $courseDayStats->courses->push($newCourse);
            } 
            
            $courseDailyStats->push($courseDayStats);  
        }

        // dd($courseDailyStats, $allCourses, $allLessons, $allTopics);

        $chunkCount = 0;

        LoggerActivity::where('route','LIKE','%lesson%topic%show%')->chunk(1000, function ($allUrlCourseView) 
        use (&$courseDailyStats, &$allCourses, &$allLessons, &$allTopics, &$chunkCount) { 
            // dd($allUrlCourseView);
            $chunkCount++;

            // if ($chunkCount < 2) {
                foreach ($allUrlCourseView as $urlCourseView) {
                    $dayStats = $courseDailyStats->firstWhere('date', Carbon::parse($urlCourseView->created_at)->toDateString());

                    $lessonViewArr = explode('/', $urlCourseView->route);    
                    $lesson_id = $lessonViewArr[4];
                    $lesson = Lesson::find($lesson_id);

                    // Check if lesson exists
                    if (isset($lesson)) {
                        $courseViewed = $dayStats->courses->firstWhere('id', $lesson->course_id);
                        $courseViewedFromAll = $allCourses->firstWhere('id', $lesson->course_id);

                        // Check if Course exists
                        if (isset($courseViewed)) {          
                            // $lessonViewed = $courseViewed->lessons->firstWhere('id', $lesson_id);
                            $lessonViewedFromAll = $allLessons->firstWhere('id', $lesson_id);

                            // Check if Lesson exists
                            if (isset($lessonViewedFromAll)) {                                    
                                $topic_id = $lessonViewArr[6];
                                // $topicViewed = $lessonViewed->topics->firstWhere('id', $topic_id);
                                $topicViewedFromAll = $allTopics->firstWhere('id', $topic_id);

                                // Check if Topic exists
                                if (isset($topicViewedFromAll)) {
                                    if ($urlCourseView->userType == "Registered") {
                        
                                        // Unique User ID Count
                                        // Check if the day already has a uniqueView
                                        if (isset($dayStats->uniqueRegViews->first()->userId)) {
                                            // Check if the view's IP Address is already recorded for that day
                                            $exist = $dayStats->uniqueRegViews->firstWhere('userId', $urlCourseView->userId);
                                            if (!isset($exist)) {
                                                $dayStats->uniqueRegViews->push($urlCourseView); 
                                            }

                                            $existCourse = $courseViewed->uniqueRegViews->firstWhere('userId', $urlCourseView->userId);
                                            if (!isset($existCourse)) {
                                                $courseViewed->uniqueRegViews->push($urlCourseView);  
                                            }

                                            // $existLesson = $lessonViewed->uniqueRegViews->firstWhere('userId', $urlCourseView->userId);
                                            // if (!isset($existLesson)) {
                                            //     $lessonViewed->uniqueRegViews->push($urlCourseView);  
                                            // }

                                            // $existTopic = $topicViewed->uniqueRegViews->firstWhere('userId', $urlCourseView->userId);
                                            // if (!isset($existTopic)) {
                                            //     $topicViewed->uniqueRegViews->push($urlCourseView);  
                                            // }
                                        } else {
                                            // Add the first view into the day
                                            $dayStats->uniqueRegViews->push($urlCourseView);  
                                            $courseViewed->uniqueRegViews->push($urlCourseView); 
                                            // $lessonViewed->uniqueRegViews->push($urlCourseView); 
                                            // $topicViewed->uniqueRegViews->push($urlCourseView);  
                                        }
                        
                                        $dayStats->uniqueRegViewsCount = $dayStats->uniqueRegViews->count();
                                        $courseViewed->uniqueRegViewsCount = $courseViewed->uniqueRegViews->count();
                                        // $lessonViewed->uniqueRegViewsCount = $lessonViewed->uniqueRegViews->count();
                                        // $topicViewed->uniqueRegViewsCount = $topicViewed->uniqueRegViews->count();
                                        
                                        $dayStats->registeredViews++;

                                        $courseViewed->registeredViews++;
                                        $courseViewedFromAll->registeredViews++;
                                        
                                        // $lessonViewed->registeredViews++;
                                        $lessonViewedFromAll->registeredViews++;
                                        
                                        // $topicViewed->registeredViews++;
                                        $topicViewedFromAll->registeredViews++;   

                                    } else if ($urlCourseView->userType == 'Guest') {                                       
                                        $dayStats->guestViews++;

                                        $courseViewed->guestViews++;
                                        $courseViewedFromAll->guestViews++;
                                        
                                        // $lessonViewed->guestViews++;
                                        $lessonViewedFromAll->guestViews++;
                                        
                                        // $topicViewed->guestViews++;
                                        $topicViewedFromAll->guestViews++;  
                                    }      
                        
                                    // Unique IP Address Count
                                    // Check if the day already has a uniqueView
                                    if (isset($dayStats->uniqueViews->first()->ipAddress)) {
                                        // Check if the view's IP Address is already recorded for that day
                                        $exist = $dayStats->uniqueViews->firstWhere('ipAddress', $urlCourseView->ipAddress);
                                        if (!isset($exist)) {
                                            $dayStats->uniqueViews->push($urlCourseView); 
                                        }

                                        $existCourse = $courseViewed->uniqueViews->firstWhere('ipAddress', $urlCourseView->ipAddress);
                                        if (!isset($existCourse)) {
                                            $courseViewed->uniqueViews->push($urlCourseView);  
                                        }

                                        // $existLesson = $lessonViewed->uniqueViews->firstWhere('ipAddress', $urlCourseView->ipAddress);
                                        // if (!isset($existLesson)) {
                                        //     $lessonViewed->uniqueViews->push($urlCourseView);  
                                        // }

                                        // $existTopic = $topicViewed->uniqueViews->firstWhere('ipAddress', $urlCourseView->ipAddress);
                                        // if (!isset($existTopic)) {
                                        //     $topicViewed->uniqueViews->push($urlCourseView);  
                                        // }
                                    } else {
                                        // Add the first view into the day
                                        $dayStats->uniqueViews->push($urlCourseView);  
                                        $courseViewed->uniqueViews->push($urlCourseView);  
                                        // $lessonViewed->uniqueViews->push($urlCourseView);  
                                        // $topicViewed->uniqueViews->push($urlCourseView);  
                                    }
                        
                                    $dayStats->uniqueViewsCount = $dayStats->uniqueViews->count();
                                    $courseViewed->uniqueViewsCount = $courseViewed->uniqueViews->count();
                                    // $lessonViewed->uniqueViewsCount = $lessonViewed->uniqueViews->count();
                                    // $topicViewed->uniqueViewsCount = $topicViewed->uniqueViews->count();

                                    $dayStats->totalViews++;

                                    $courseViewed->totalViews++;
                                    $courseViewedFromAll->totalViews++;
                                    
                                    // $lessonViewed->totalViews++;
                                    $lessonViewedFromAll->totalViews++;
                                    
                                    // $topicViewed->totalViews++;
                                    $topicViewedFromAll->totalViews++;
                                }
                            }
                        }
                    }
                }
            // }
        });

        // Course Completion Stats
        $courses = Course::all();
        $courseCompletions = collect();

        foreach ($courses as $course) {            
            $completions = Lesson::getLessonCompletedStats($course->id);
            $courseStats = new VodStats;
            $courseStats->id = $course->id;
            $courseStats->title = $course->title;
            $courseStats->completions = $completions;
            $courseCompletions->push($courseStats);
        }  
    // Course Stats End

    // DB Start
        AnalyticsLog::truncate();
        
        // Vod User Stats
        $parts = $allActiveUsers->count() / 500;

        for ($index = 0; $index < $parts; $index++) {
            $partializedUsers = $allActiveUsers->slice(($index*500),500);
            $userAllAnalytics = AnalyticsLog::create([
                'type'          => "User-All",
                'content'       => $partializedUsers,
            ]);

            $userAllAnalytics->save();   
        }
        // dd(AnalyticsLog::where('type', 'User-All')->get());


        // Vod Stats
        foreach($vodDailyStats as $dailyStat) {
            $dailyStat->uniqueViews = NULL;
            $dailyStat->uniqueRegViews = NULL;
            foreach($dailyStat->vods as $vod) {
                $vod->uniqueViews = NULL;
                $vod->uniqueRegViews = NULL;
            }
            $vodDailyAnalytics = AnalyticsLog::create([
                'type'          => "VOD-Daily",
                'content'       => $dailyStat,
                'date'          => $dailyStat->date,
            ]);
    
            $vodDailyAnalytics->save();  
        }            

        // Registrant and Enrollees Stats
        foreach($regAndEnrolDailyStats as $regAndEnrolDailyStat) {     
            $regAndEnrolDailyAnalytics = AnalyticsLog::create([
                'type'          => "Daily-RegistrantsAndEnrollees",
                'content'       => $regAndEnrolDailyStat,
                'date'          => $regAndEnrolDailyStat->date,
            ]);
    
            $regAndEnrolDailyAnalytics->save();  
        }

        // Course Stats

        
        $courseAll = new VodStats;
        $courseAll->allCourses = $allCourses;
        $courseAll->allLessons = $allLessons;
        $courseAll->allTopics = $allTopics;
        $courseAll->courseCompletions = $courseCompletions;

        $courseDailyAnalytics = AnalyticsLog::create([
            'type'          => "Course-All",
            'content'       => $courseAll,
        ]);

        foreach($courseDailyStats as $dailyStat) {
            $dailyStat->uniqueViews = NULL;
            $dailyStat->uniqueRegViews = NULL;
            foreach($dailyStat->courses as $course) {
                $course->uniqueViews = NULL;
                $course->uniqueRegViews = NULL;
            }
            $courseDailyAnalytics = AnalyticsLog::create([
                'type'          => "Course-Daily",
                'content'       => $dailyStat,
                'date'          => $dailyStat->date,
            ]);

            $courseDailyAnalytics->save();  
        }  

    // DB End 
        $log .= Carbon::now()->toDateTimeString() . ": Analytics Generated \n"; 
        echo $log;     
    }
}
