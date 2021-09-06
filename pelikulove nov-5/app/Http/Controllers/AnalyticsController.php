<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use View;

use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;
use jeremykenedy\LaravelRoles\Models\Role;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

use Illuminate\Http\Request;

use App\Models\RegisterLog;
use App\Models\LoggerActivity;
use App\Models\Vod;
use App\Models\VodStats;
use App\Models\User;
use App\Models\AnalyticsLog;
use App\Models\LearnerCourse;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Topic;
use App\Models\Comment;
use App\Models\Submission;


class AnalyticsController extends Controller
{
    use ActivityLogger;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showVods(Request $request)
    {      
        // Get Date        
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if (isset($startDate) && isset($endDate)) {  
            $rawAllVodStats = AnalyticsLog::select('content')
            ->where('type', 'VOD-Daily')
            ->where('date', '>=', Carbon::parse($startDate)->format('Y-m-d'))
            ->where('date', '<=', Carbon::parse($endDate)->format('Y-m-d'))
            ->get();
        } else {    
            $rawAllVodStats = AnalyticsLog::select('content')->where('type', 'VOD-Daily')->get();       
        }        
        
        $rawAllUserStats = AnalyticsLog::select('content')->where('type', 'User-All')->get();
        $allUserStats = collect();
        foreach ($rawAllUserStats as $rawUserStat) {
            $content = json_decode($rawUserStat->content, true);

            foreach ($content as $userStats) {
                // dd($userStats);
                $newUserStats = collect();
                $newUserStats->id = $userStats["id"];
                $newUserStats->name = $userStats["name"];
                $newUserStats->first_name = $userStats["first_name"];
                $newUserStats->last_name = $userStats["last_name"];
                $newUserStats->email = $userStats["email"];
                $newUserStats->description = $userStats["description"];
                $newUserStats->created_at = $userStats["created_at"];
                $newUserStats->views = $userStats["views"];

                $allUserStats->push($newUserStats);
            }
            // dd($allUserStats);
        }

        $allVodStats = collect();
        foreach ($rawAllVodStats as $rawVodStat) {
            $content = json_decode($rawVodStat->content , true);
            $allVodStats->push($content);
        }

        $allVodStatsByDate = new VodStats;   
        $allVodStatsByDate->dates = collect();  
        $allVodStatsByDate->totalViews = collect();  
        $allVodStatsByDate->uniqueViewsCount = collect();
        $allVodStatsByDate->uniqueRegViewsCount = collect();
        $allVodStatsByDate->registeredViews = collect();
        $allVodStatsByDate->guestViews = collect();     

        // $newAllVodStats = collect();   
        $newAllVodStats = collect();   
        foreach ($allVodStats[0]['vods'] as $vodTitle) {     
            $vodStats = new VodStats;  
            $vodStats->title = $vodTitle['title'];
            $vodStats->id = $vodTitle['id'];
            $vodStats->totalViews = 0;
            $vodStats->uniqueViewsCount = 0;
            $vodStats->uniqueRegViewsCount = 0;
            $vodStats->registeredViews = 0;
            $vodStats->guestViews = 0;

            $newAllVodStats->push($vodStats);    
        }    
        
        foreach ($allVodStats as $dailyVodStat) {
            // Convert allVodStats to allDailyStats
            $allVodStatsByDate->dates->push($dailyVodStat['date']);
            $allVodStatsByDate->totalViews->push($dailyVodStat['totalViews']);
            $allVodStatsByDate->uniqueViewsCount->push($dailyVodStat['uniqueViewsCount']);
            $allVodStatsByDate->uniqueRegViewsCount->push($dailyVodStat['uniqueRegViewsCount']);
            $allVodStatsByDate->registeredViews->push($dailyVodStat['registeredViews']);
            $allVodStatsByDate->guestViews->push($dailyVodStat['guestViews']);
            
            // $newVodStats = new VodStats;   
            // $newVodStats->date = $dailyVodStat['date'];  
            // $newVodStats->totalViews = $dailyVodStat['totalViews'];  
            // $newVodStats->uniqueViewsCount = $dailyVodStat['uniqueViewsCount'];
            // $newVodStats->registeredViews = $dailyVodStat['registeredViews'];
            // $newVodStats->guestViews = $dailyVodStat['guestViews']; 
            // $newVodStats->vods = collect(); 
            
            // foreach ($dailyVodStat['vods'] as $vodStats) {   
            //     $newVod = new Vod;
            //     $newVod->id = $vodStats['id'];
            //     $newVod->title = $vodStats['title'];
            //     $newVod->date = $vodStats['date'];
            //     $newVod->totalViews = $vodStats['totalViews'];
            //     $newVod->uniqueViewsCount = $vodStats['uniqueViewsCount'];
            //     $newVod->registeredViews = $vodStats['registeredViews'];
            //     $newVod->guestViews = $vodStats['guestViews'];
            
            //     $newVodStats->vods->push($newVod);         
            //     // Add collection here
            // }
            
            // dd($dailyVodStat['vods']);
            // Convert Daily Stats to Vod Stats
            foreach ($dailyVodStat['vods'] as $vodTitle) {     
                $vodStats = $newAllVodStats->firstWhere('id', $vodTitle['id']);
                $vodStats->totalViews += $vodTitle['totalViews'];
                $vodStats->uniqueViewsCount += $vodTitle['uniqueViewsCount'];
                $vodStats->uniqueRegViewsCount += $vodTitle['uniqueRegViewsCount'];
                $vodStats->registeredViews += $vodTitle['registeredViews'];
                $vodStats->guestViews += $vodTitle['guestViews'];
            }  
            // $newAllVodStats->push($newVodStats);
        }
        // dd($log); 
        
        $allVodStats = $newAllVodStats;
        // dd($allVodStatsByDate->dates);
        
        return View('analytics.vods.index', compact('allVodStats', 'allUserStats', 'allVodStatsByDate', 'startDate', 'endDate'));
    }
    
    public function showAllVodStats(Request $request)
    {   
        // Get Date        
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if (isset($startDate) && isset($endDate)) {  
            $rawAllVodStats = AnalyticsLog::select('content')
            ->where('type', 'VOD-Daily')
            ->where('date', '>=', Carbon::parse($startDate)->format('Y-m-d'))
            ->where('date', '<=', Carbon::parse($endDate)->format('Y-m-d'))
            ->get();
        } else {    
            $rawAllVodStats = AnalyticsLog::select('content')->where('type', 'VOD-Daily')->get();       
        }        

        $allVodStats = collect();
        foreach ($rawAllVodStats as $rawVodStat) {
            $content = json_decode($rawVodStat->content , true);
            $allVodStats->push($content);
        }  

        // $newAllVodStats = collect();   
        $newAllVodStats = collect();   
        foreach ($allVodStats[0]['vods'] as $vodTitle) {     
            $vodStats = new VodStats;  
            $vodStats->title = $vodTitle['title'];
            $vodStats->id = $vodTitle['id'];
            $vodStats->totalViews = 0;
            $vodStats->uniqueViewsCount = 0;
            $vodStats->uniqueRegViewsCount = 0;
            $vodStats->registeredViews = 0;
            $vodStats->guestViews = 0;

            $newAllVodStats->push($vodStats);    
        }    
        
        foreach ($allVodStats as $dailyVodStat) {            
            // Convert Daily Stats to Vod Stats
            foreach ($dailyVodStat['vods'] as $vodTitle) {     
                $vodStats = $newAllVodStats->firstWhere('id', $vodTitle['id']);
                $vodStats->totalViews += $vodTitle['totalViews'];
                $vodStats->uniqueViewsCount += $vodTitle['uniqueViewsCount'];
                $vodStats->uniqueRegViewsCount += $vodTitle['uniqueRegViewsCount'];
                $vodStats->registeredViews += $vodTitle['registeredViews'];
                $vodStats->guestViews += $vodTitle['guestViews'];  
            }   
            
            // $newAllVodStats->push($newVodStats);
        }
        
        $firstDate = $allVodStats[0]['date'];
        $allVodStats = $newAllVodStats;

        return View('analytics.vods.show-all-videos', compact('allVodStats', 'firstDate', 'startDate', 'endDate'));       
    }
    
    public function showAllUserStats()
    {    
        $rawAllUserStats = AnalyticsLog::select('content')->where('type', 'User-All')->get();
        $allUserStats = collect();
        foreach ($rawAllUserStats as $rawUserStat) {
            $content = json_decode($rawUserStat->content, true);

            foreach ($content as $userStats) {
                // dd($userStats);
                $newUserStats = collect();
                $newUserStats->id = $userStats["id"];
                $newUserStats->name = $userStats["name"];
                $newUserStats->first_name = $userStats["first_name"];
                $newUserStats->last_name = $userStats["last_name"];
                $newUserStats->email = $userStats["email"];
                $newUserStats->description = $userStats["description"];
                $newUserStats->created_at = $userStats["created_at"];
                $newUserStats->views = $userStats["views"];

                $allUserStats->push($newUserStats);
            }
            // dd($allUserStats);
        }
        

        return View('analytics.vods.show-all-users', compact('allUserStats'));
    }

    public function showVideo(Request $request, $id) {
        $vod = Vod::find($id);
        
        // Get Date        
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if (isset($startDate) && isset($endDate)) {  
            $rawAllVodStats = AnalyticsLog::select('content')
            ->where('type', 'VOD-Daily')
            ->where('date', '>=', Carbon::parse($startDate)->format('Y-m-d'))
            ->where('date', '<=', Carbon::parse($endDate)->format('Y-m-d'))
            ->get();
        } else {    
            // $startDate = $vod->published_at;
            $rawAllVodStats = AnalyticsLog::select('content')->where('type', 'VOD-Daily')
            // ->where('date', '>=', Carbon::parse($startDate)->format('Y-m-d'))
            ->get();       
        }        

        $allVodStats = collect();
        foreach ($rawAllVodStats as $rawVodStat) {
            $content = json_decode($rawVodStat->content , true);
            $allVodStats->push($content);
        }  

        // $newAllVodStats = collect();   
        
        $vodStats = new VodStats;  
        $vodStats->title = $vod->title;
        $vodStats->id = $vod->id;
        $vodStats->publishedAt = $vod->published_at;
        $vodStats->totalViews = 0;
        $vodStats->uniqueViewsCount = 0;
        $vodStats->uniqueRegViewsCount = 0;
        $vodStats->registeredViews = 0;
        $vodStats->guestViews = 0;

        $allVodStatsByDate = new VodStats;   
        $allVodStatsByDate->dates = collect();  
        $allVodStatsByDate->totalViews = collect();  
        $allVodStatsByDate->uniqueViewsCount = collect();
        $allVodStatsByDate->uniqueRegViewsCount = collect();
        $allVodStatsByDate->registeredViews = collect();
        $allVodStatsByDate->guestViews = collect();  
        
        $firstDay = true;
        foreach ($allVodStats as $dailyVodStat) {       
            foreach ($dailyVodStat['vods'] as $vodTitle) {   
                if ($firstDay) {
                    if ($vodTitle['totalViews'] > 0) {  
                        if ($vodTitle['id'] == $vod->id) {
                            $vodStats->totalViews += $vodTitle['totalViews'];
                            $vodStats->uniqueViewsCount += $vodTitle['uniqueViewsCount'];
                            $vodStats->uniqueRegViewsCount += $vodTitle['uniqueRegViewsCount'];
                            $vodStats->registeredViews += $vodTitle['registeredViews'];
                            $vodStats->guestViews += $vodTitle['guestViews'];  
            
                            // Convert Daily Stats to Vod Stats
                            $allVodStatsByDate->dates->push($dailyVodStat['date']);
                            $allVodStatsByDate->totalViews->push($vodTitle['totalViews']);
                            $allVodStatsByDate->uniqueViewsCount->push($vodTitle['uniqueViewsCount']);
                            $allVodStatsByDate->uniqueRegViewsCount->push($vodTitle['uniqueRegViewsCount']);
                            $allVodStatsByDate->registeredViews->push($vodTitle['registeredViews']);
                            $allVodStatsByDate->guestViews->push($vodTitle['guestViews']);

                            $firstDay = !$firstDay;
                        }
                    } 
                } else {
                    if ($vodTitle['id'] == $vod->id) {
                        $vodStats->totalViews += $vodTitle['totalViews'];
                        $vodStats->uniqueViewsCount += $vodTitle['uniqueViewsCount'];
                        $vodStats->uniqueRegViewsCount += $vodTitle['uniqueRegViewsCount'];
                        $vodStats->registeredViews += $vodTitle['registeredViews'];
                        $vodStats->guestViews += $vodTitle['guestViews'];  
        
                        // Convert Daily Stats to Vod Stats
                        $allVodStatsByDate->dates->push($dailyVodStat['date']);
                        $allVodStatsByDate->totalViews->push($vodTitle['totalViews']);
                        $allVodStatsByDate->uniqueViewsCount->push($vodTitle['uniqueViewsCount']);
                        $allVodStatsByDate->uniqueRegViewsCount->push($vodTitle['uniqueRegViewsCount']);
                        $allVodStatsByDate->registeredViews->push($vodTitle['registeredViews']);
                        $allVodStatsByDate->guestViews->push($vodTitle['guestViews']);
                    }   
                }
            }  
        }
        
        $firstDate = $allVodStats[0]['date'];

        // dd($vodStats);

        // dd($vodStats, $allVodStatsByDate);
        
        return View('analytics.vods.show-video', compact('vodStats', 'allVodStatsByDate', 'firstDate', 'startDate', 'endDate'));
    }

    public function showEnrolleesAndRegistrants(Request $request)
    {    
        // Get Date        
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if (isset($startDate) && isset($endDate)) {  
            $rawAllDailyStats = AnalyticsLog::select('content')
            ->where('type', 'Daily-RegistrantsAndEnrollees')
            ->where('date', '>=', Carbon::parse($startDate)->format('Y-m-d'))
            ->where('date', '<=', Carbon::parse($endDate)->format('Y-m-d'))
            ->get();
        } else {    
            $rawAllDailyStats = AnalyticsLog::select('content')->where('type', 'Daily-RegistrantsAndEnrollees')->get();
        }   
        
        $enrollees = LearnerCourse::join('orders', 'orders.id', '=', 'learnercourses.order_id')
        ->select('learnercourses.*', 'orders.id', 'orders.amount')
        ->where('learnercourses.created_at', '>=', '2019-06-18')
        ->orderBy('learnercourses.created_at', 'desc')
        ->get();
        $paidEnrollees = LearnerCourse::join('orders', 'orders.id', '=', 'learnercourses.order_id')
        ->select('learnercourses.*', 'orders.id', 'orders.amount')
        ->where('learnercourses.created_at', '>=', '2019-06-18')
        ->where('orders.amount', '>', 0)
        ->orderBy('learnercourses.created_at', 'desc')
        ->get();
        $activeEnrollees = LearnerCourse::join('orders', 'orders.id', '=', 'learnercourses.order_id')
        ->select('learnercourses.*', 'orders.id', 'orders.amount')
        ->where('learnercourses.created_at', '>=', '2019-06-18')
        ->where('learnercourses.status', '1')
        ->orderBy('learnercourses.created_at', 'desc')
        ->get();
        $rlUsers = RegisterLog::where('event', 'RickyLeeLandingPage')
        ->orderBy('created_at', 'desc')
        ->get();
        $users = User::where('created_at', '>=', '2019-06-18')
        ->orderBy('created_at', 'desc')
        ->get();     

        $dailyUserStats = collect();
        foreach ($rawAllDailyStats as $rawDailyStat) {
            $content = json_decode($rawDailyStat->content , true);
            $collectContent = collect();
            $collectContent->date = $content['date'];  
            $collectContent->totalEnrollees = $content['totalEnrollees'];  
            $collectContent->paidEnrollees = $content['paidEnrollees'];
            $collectContent->freeEnrollees = $content['freeEnrollees'];
            $collectContent->totalRegistrants = $content['totalRegistrants'];
            $collectContent->websiteRegistrants = $content['websiteRegistrants'];  
            $collectContent->adminRegistrants = $content['adminRegistrants'];  
            $dailyUserStats->push($collectContent);
        }  

        $allUserStatsByDate = new VodStats;   
        $allUserStatsByDate->dates = collect();  
        $allUserStatsByDate->totalEnrollees = collect();  
        $allUserStatsByDate->paidEnrollees = collect();
        $allUserStatsByDate->freeEnrollees = collect();
        $allUserStatsByDate->totalRegistrants = collect();
        $allUserStatsByDate->websiteRegistrants = collect();  
        $allUserStatsByDate->adminRegistrants = collect();  
        $allUserStatsByDate->rlUsers = collect();  

        foreach ($dailyUserStats as $dayStats) {     
            $allUserStatsByDate->dates->push($dayStats->date);
            $allUserStatsByDate->totalEnrollees->push($dayStats->totalEnrollees);
            $allUserStatsByDate->paidEnrollees->push($dayStats->paidEnrollees);
            $allUserStatsByDate->freeEnrollees->push($dayStats->freeEnrollees);
            $allUserStatsByDate->totalRegistrants->push($dayStats->totalRegistrants);
            $allUserStatsByDate->websiteRegistrants->push($dayStats->websiteRegistrants);
            $allUserStatsByDate->adminRegistrants->push($dayStats->adminRegistrants);            
        }
        
        // dd($dailyUserStats->sortByDesc('date')->slice(0, 5));
        // dd($allUserStatsByDate);

        $enrolleesCount = $enrollees->count();
        $usersCount = $users->count();
        $activeEnrolleesCount = $activeEnrollees->count();
        $paidEnrolleesCount = $paidEnrollees->count();

        $totalStats = collect();
        $totalStats->enrolleesCount = $enrolleesCount;
        $totalStats->usersCount = $usersCount;
        $totalStats->activeEnrolleesCount = $activeEnrolleesCount;
        $totalStats->paidEnrolleesCount = $paidEnrolleesCount;

        // dd($dailyUserStats->first()->date);
        
        return View('analytics.show-enrollees-registrants', compact('dailyUserStats', 'allUserStatsByDate', 'totalStats', 'rlUsers'));
    }

    public function showCourses(Request $request) {

        // $rawAllCourseStats = AnalyticsLog::select('content')->where('type', 'Course-Daily')
        // // ->where('date', '>=', Carbon::parse($startDate)->format('Y-m-d'))
        // ->get();        

        // $allCourseStats = collect();
        // foreach ($rawAllCourseStats as $rawCourseStat) {
        //     $content = json_decode($rawCourseStat->content , true);
        //     $allCourseStats->push($content);
        // }  
        // dd($allCourseStats, $allCourseStats->first());
        
        $rawLifetimeCourseStats = AnalyticsLog::select('content')->where('type', 'Course-All')
        // ->where('date', '>=', Carbon::parse($startDate)->format('Y-m-d'))
        ->get();        

        $rawAllLessons = collect();
        foreach ($rawLifetimeCourseStats as $rawLifetimeStat) {
            $content = json_decode($rawLifetimeStat->content , true);
            $rawAllLessons->push($content['allLessons']);
        }  
        // dd($allLifetimeStats, $allLifetimeStats->first());

        $allLessons = collect();
        // dd($rawAllLessons->first());
        
        foreach ($rawAllLessons->first() as $oneLesson) {  
            $newLesson = new VodStats;  
            $newLesson->id = $oneLesson['id'];
            $newLesson->title = $oneLesson['title'];
            $newLesson->course_id = $oneLesson['course_id'];
            $newLesson->lorder = $oneLesson['lorder'];
            $newLesson->totalViews = $oneLesson['totalViews'];
            $newLesson->uniqueViews = $oneLesson['uniqueViews'];
            $newLesson->uniqueViewsCount = $oneLesson['uniqueViewsCount'];
            $newLesson->uniqueRegViews = $oneLesson['uniqueRegViews'];
            $newLesson->uniqueRegViewsCount = $oneLesson['uniqueRegViewsCount'];
            $newLesson->registeredViews = $oneLesson['registeredViews'];
            $newLesson->guestViews = $oneLesson['guestViews'];

            $allLessons->push($newLesson);
        }       

        $rawAllTopics = collect();
        foreach ($rawLifetimeCourseStats as $rawLifetimeStat) {
            $content = json_decode($rawLifetimeStat->content , true);
            $rawAllTopics->push($content['allTopics']);
        }  
        // dd($allLifetimeStats, $allLifetimeStats->first());

        $allTopics = collect();
        // dd($rawAllTopics->first());
        
        foreach ($rawAllTopics->first() as $oneTopic) {  
            $newTopic = new VodStats;  
            $newTopic->id = $oneTopic['id'];
            $newTopic->title = $oneTopic['title'];
            $newTopic->course_id = $oneTopic['course_id'];
            $newTopic->lesson_id = $oneTopic['lesson_id'];
            $newTopic->torder = $oneTopic['torder'];
            $newTopic->totalViews = $oneTopic['totalViews'];
            $newTopic->uniqueViews = $oneTopic['uniqueViews'];
            $newTopic->uniqueViewsCount = $oneTopic['uniqueViewsCount'];
            $newTopic->uniqueRegViews = $oneTopic['uniqueRegViews'];
            $newTopic->uniqueRegViewsCount = $oneTopic['uniqueRegViewsCount'];
            $newTopic->registeredViews = $oneTopic['registeredViews'];
            $newTopic->guestViews = $oneTopic['guestViews'];

            $allTopics->push($newTopic);
        }

        $data = collect();
        $data->allStudents = LearnerCourse::select('learnercourses.id as learnercourse_id', 'learnercourses.user_id', 'learnercourses.order_id', 'learnercourses.course_id', 'learnercourses.status',  'learnercourses.created_at as learnercourse_created_at', 
        'users.id as user_id', 'users.name as username', 'users.first_name', 'users.last_name', 'users.email', 'users.lastlogin', 'users.created_at as user_created_at', 
        'courses.id as course_id', 'courses.title', 'courses.short_title', 
        'orders.id as order_id', 'orders.service_id', 'services.id as service_id', 'services.name as service_name', 'services.duration')
        ->join('users', 'learnercourses.user_id', '=', 'users.id')
        ->join('courses', 'learnercourses.course_id', '=', 'courses.id')
        ->join('orders', 'learnercourses.order_id', '=', 'orders.id')
        ->join('services', 'orders.service_id', '=', 'services.id')
        ->orderBy('learnercourses.created_at', 'desc')
        ->get();
        $data->allPaidStudents = LearnerCourse::join('orders', 'learnercourses.order_id', '=', 'orders.id')
        ->where('orders.amount', '>', 0)
        ->get();
        $data->allEnrolledStudents = LearnerCourse::join('users', 'learnercourses.user_id', '=', 'users.id')
        ->where('status', 1)
        ->get();
        $allUnEnrolledStudents = LearnerCourse::join('users', 'learnercourses.user_id', '=', 'users.id')
        ->where('status', 0)
        ->get();
        $data->allActiveStudents3D = LearnerCourse::join('users', 'learnercourses.user_id', '=', 'users.id')
        ->whereRaw('DATE(users.lastlogin) >= DATE_ADD(CURDATE(), INTERVAL -3 DAY)')
        ->where('status', 1)
        ->get();
        $data->allActiveStudents1W = LearnerCourse::join('users', 'learnercourses.user_id', '=', 'users.id')
        ->whereRaw('DATE(users.lastlogin) >= DATE_ADD(CURDATE(), INTERVAL -1 WEEK)')
        ->where('status', 1)
        ->get();
        $data->allActiveStudents3W = LearnerCourse::join('users', 'learnercourses.user_id', '=', 'users.id')
        ->whereRaw('DATE(users.lastlogin) >= DATE_ADD(CURDATE(), INTERVAL -3 WEEK)')
        ->where('status', 1)
        ->get();

        $data->allSubmissions = Submission::all();
        $data->allComments = Comment::where('type', 'topic')
        ->get(); 

        $data->allLessons = $allLessons;
        $data->allTopics = $allTopics;
        $data->allCourses = Course::all();

        // dd($allLessons->first());

        return View('analytics.courses.index', compact('data'));    

        // dd($allCourses);  
    }   

    public function showCourse(Request $request, $course_id) {

        $data = collect();
        
        $course = Course::find($course_id);
        if (!isset($course)) {
            return redirect()->route('analytics.courses')->with([
				'status' => 'danger', 
				'message' => "Course does not exist."
				]);
        } 

        $data->allCourses = $course;

        $data->allStudents = LearnerCourse::select('learnercourses.id as learnercourse_id', 'learnercourses.user_id', 'learnercourses.order_id', 'learnercourses.course_id', 'learnercourses.status',  'learnercourses.created_at as learnercourse_created_at', 
        'users.id as user_id', 'users.name as username', 'users.first_name', 'users.last_name', 'users.email', 'users.lastlogin', 'users.created_at as user_created_at', 
        'courses.id as course_id', 'courses.title', 'courses.short_title', 
        'orders.id as order_id', 'orders.service_id', 'services.id as service_id', 'services.name as service_name', 'services.duration')
        ->join('users', 'learnercourses.user_id', '=', 'users.id')
        ->join('courses', 'learnercourses.course_id', '=', 'courses.id')
        ->join('orders', 'learnercourses.order_id', '=', 'orders.id')
        ->join('services', 'orders.service_id', '=', 'services.id')
        ->where('learnercourses.course_id', $course_id)
        ->orderBy('learnercourses.created_at', 'desc')
        ->get();

        // dd($allStudents->slice(0, 5));
        $data->allPaidStudents = LearnerCourse::join('orders', 'learnercourses.order_id', '=', 'orders.id')
        ->where('learnercourses.course_id', $course_id)
        ->where('orders.amount', '>', 0)
        ->get();
        $data->allEnrolledStudents = LearnerCourse::join('users', 'learnercourses.user_id', '=', 'users.id')
        ->where('learnercourses.course_id', $course_id)
        ->where('status', 1)
        ->get();
        $data->allUnEnrolledStudents = LearnerCourse::join('users', 'learnercourses.user_id', '=', 'users.id')
        ->where('learnercourses.course_id', $course_id)
        ->where('status', 0)
        ->get();
        $data->allActiveStudents3D = LearnerCourse::join('users', 'learnercourses.user_id', '=', 'users.id')
        ->where('learnercourses.course_id', $course_id)
        ->whereRaw('DATE(users.lastlogin) >= DATE_ADD(CURDATE(), INTERVAL -3 DAY)')
        ->where('status', 1)
        ->get();
        $data->allActiveStudents1W = LearnerCourse::join('users', 'learnercourses.user_id', '=', 'users.id')
        ->where('learnercourses.course_id', $course_id)
        ->whereRaw('DATE(users.lastlogin) >= DATE_ADD(CURDATE(), INTERVAL -1 WEEK)')
        ->where('status', 1)
        ->get();
        $data->allActiveStudents3W = LearnerCourse::join('users', 'learnercourses.user_id', '=', 'users.id')
        ->where('learnercourses.course_id', $course_id)
        ->whereRaw('DATE(users.lastlogin) >= DATE_ADD(CURDATE(), INTERVAL -3 WEEK)')
        ->where('status', 1)
        ->get();

        $allSubmissions = Submission::all();
        
        $data->allSubmissions = $allSubmissions->filter(function ($submission) use (&$course_id) {
            $lesson = Lesson::find($submission->lesson_id);
            
            if ($lesson->course_id == $course_id) {            
                return $submission;
            }
        }); 

        $allComments = Comment::where('type', 'topic')
        ->get();     
        
        $data->allComments = $allComments->filter(function ($comment) use (&$course_id) {
            $topic = Topic::find($comment->topic_id);
            if (isset($topic)) {
                $lesson = Lesson::find($topic->lesson_id);
                if (isset($lesson)) {
                    if ($lesson->course_id == $course_id) {            
                        return $comment;
                    }
                }
            }
        });         
        
        $rawLifetimeCourseStats = AnalyticsLog::select('content')->where('type', 'Course-All')
        // ->where('date', '>=', Carbon::parse($startDate)->format('Y-m-d'))
        ->get();        

        $rawAllLessons = collect();
        foreach ($rawLifetimeCourseStats as $rawLifetimeStat) {
            $content = json_decode($rawLifetimeStat->content , true);
            $rawAllLessons->push($content['allLessons']);
        }  
        // dd($allLifetimeStats, $allLifetimeStats->first());

        $allLessons = collect();
        // dd($rawAllLessons->first());
        
        foreach ($rawAllLessons->first() as $oneLesson) { 
            if ($oneLesson['course_id'] == $course->id) {
                $newLesson = new VodStats;  
                $newLesson->id = $oneLesson['id'];
                $newLesson->title = $oneLesson['title'];
                $newLesson->course_id = $oneLesson['course_id'];
                $newLesson->lorder = $oneLesson['lorder'];
                $newLesson->totalViews = $oneLesson['totalViews'];
                $newLesson->uniqueViews = $oneLesson['uniqueViews'];
                $newLesson->uniqueViewsCount = $oneLesson['uniqueViewsCount'];
                $newLesson->uniqueRegViews = $oneLesson['uniqueRegViews'];
                $newLesson->uniqueRegViewsCount = $oneLesson['uniqueRegViewsCount'];
                $newLesson->registeredViews = $oneLesson['registeredViews'];
                $newLesson->guestViews = $oneLesson['guestViews'];
    
                $allLessons->push($newLesson);
            } 
        }    

        $data->allLessons = $allLessons;

        return View('analytics.courses.show-course', compact('data'));    
    }

    // DEPRECIATED
    public function logVodVideoEnd(Request $request)
    {
        $vod_id;

        if ($request->isMethod('POST')){            
            $vod_id = $request->input('vod_id');    
            
            // Get Latest Log of Vod End
            // $lastLog = LoggerActivity::where('description', "VideoEnd-" . $vod_id)
            // ->orderBy('created_at', 'desc')
            // ->first();

            // If Last log exists
            if (isset($lastLog)) {
                $lastLogTimestamp = Carbon::parse($lastLog->created_at);

                // If Latest log occured within the last 5 minutes, dont log
                if (Carbon::now()->gt($lastLogTimestamp->addMinutes(5))) {
                    ActivityLogger::activity("VideoEnd-" . $vod_id, "vod");            
                    return response()->json(['message'=>"logged"]);
                } else {
                    return response()->json(['message'=>"waiting"]);
                }
            } else {
                ActivityLogger::activity("VideoEnd-" . $vod_id, "vod");            
                return response()->json(['message'=>"logged"]);
            }
        }
    }
}
