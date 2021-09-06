<?php

namespace App\Http\Controllers;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;

use Auth;
use Notifications;
use Validator;
use View;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\VodStats;
use App\Models\Vod;
use App\Models\VodCategory;
use App\Models\VodPurchase;
use App\Models\Topic;
use App\Models\Order;
use App\Models\Comment;
use App\Models\Course;
use App\Models\Submission;
use App\Models\Lesson;
use App\Models\LearnerCourse;
use App\Models\LoggerActivity;
use App\Models\AnalyticsLog;
use App\Models\VodCrew;
use App\Models\Service;
use App\Models\VodCrewType;
use App\Models\Activation;
use App\Models\Profile;
use App\Models\Survey;
use App\Models\SurveyAnswer;
use App\Models\SurveyQuestion;

use App\Notifications\SendSaluhanSubmissionCommentNotif;
use App\Notifications\SendTaumbayanPostNotif;
use App\Notifications\SendTopicCommentNotif;
use App\Notifications\SendVodCommentNotif;
use App\Notifications\SendDailyStatsTemp2;
use App\Notifications\SendDailyStatsTemp;
use App\Notifications\SendDailyStats;

use App\Notifications\SendPaymentEmail;
use App\Notifications\SendEarlyAccessEmail;
use App\Notifications\SendCompliEmail;
use App\Notifications\SendPaymentInstructionEmail;
use App\Notifications\SendPaymentNotifyEmail;
use App\Notifications\SendVodPaymentEmail;
use App\Notifications\SendVodPaymentInstructionEmail;
use App\Notifications\SendVodPaymentNotifyEmail;
use App\Notifications\SendDonationPaymentEmail;
use App\Notifications\SendDonationPaymentInstructionEmail;
use App\Notifications\SendDonationPaymentNotifyEmail;

use App\Traits\ActivationTrait;
use App\Traits\CaptureIpTrait;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

use Creativeorange\Gravatar\Facades\Gravatar;
use jeremykenedy\LaravelRoles\Models\Role;
use Emgag\Video\ThumbnailSprite\ThumbnailSprite;
use Carbon\Carbon;
use Carbon\CarbonPeriod;



class TestsController extends Controller
{
	use ActivityLogger;
    use ActivationTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    public function test01 (Request $request) {    

        
        // $order = Order::find(1125);
        // $service = Service::find($order->service_id);
        // $vod = Vod::find($service->vod_id);
        // $owned = VodPurchase::ifOwned($vod->id, $order->user_id);
             
        //  if (!$owned)	 :		
        //      // Add Purchase to VodPurchases
        //      $data = array(
        //          'vod_id' => $vod->id, 
        //          'user_id' => $order->user_id, 
        //          'order_id' => $order->id
        //      );

        //      $owner = VodPurchase::saveVodPurchase($data);
        //      $user = User::find($order->user_id);
        //      Notification::send($user, new SendVodPaymentEmail($order));

        //      $admin = User::find(10);
        //      if (isset($admin)) {
        //          Notification::send($admin, new SendVodPaymentNotifyEmail($order));   
        //      }   
        // endif;
        
        // $lesson = Lesson::find(2);

        // dd($lesson->topics()->first());
        
        // // $log = Log::info('RL-Register', [Auth::user()]);
        // // dd($log);
        // // $log->logType = "RickyLee";
        // // $log->save();

        // // return view('auth.activation-rickylee-2');
        // // dd('asd');
        // $user = User::find(12);
        // // dd($user);
        // Auth::login($user);
	}

    public function test02 () {	  
        
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

        LoggerActivity::where('route','LIKE','%lesson%topic%show%')->chunk(1000, function ($allUrlCourseView) use (&$courseDailyStats, &$allCourses, &$allLessons, &$allTopics, &$chunkCount) { 
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

        $courses = Course::all();
        $courseAll = collect();

        foreach ($courses as $course) {            
            $completions = Lesson::getLessonCompletedStats($course->id);
            $courseStats = new VodStats;
            $courseStats->title = $course->title;
            $courseStats->completions = $completions;
            $courseAll->push($courseStats);
        }  

        $courseDailyAnalytics = AnalyticsLog::create([
            'type'          => "Course-All",
            'content'       => $courseAll,
        ]);

        dd('123');

    }

    public function test03 () {	

        $rawAllCourseStats = AnalyticsLog::select('content')->where('type', 'Course-Daily')->get();  

        $allCourseStats = collect();
        foreach ($rawAllCourseStats as $rawCourseStat) {
            $content = json_decode($rawCourseStat->content , true);
            $allCourseStats->push($content);
        }

        // $newAllVodStats = collect();   
        $newAllCourseStats = collect();   
        foreach ($allCourseStats[0]['courses'] as $course) {     
            $courseStats = new VodStats;  
            $courseStats->title = $course['title'];
            $courseStats->short_title = $course['short_title'];
            $courseStats->id = $course['id'];
            $courseStats->totalViews = 0;
            $courseStats->uniqueViewsCount = 0;
            $courseStats->uniqueRegViewsCount = 0;
            $courseStats->registeredViews = 0;
            $courseStats->guestViews = 0;

            $newAllCourseStats->push($courseStats);    
        }    

        dd($newAllCourseStats);
        
        foreach ($allCourseStats as $dailyCourseStat) {            
            // Convert Daily Stats to Vod Stats
            foreach ($dailyCourseStat['courses'] as $course) {     
                $courseStats = $newAllCourseStats->firstWhere('id', $course['id']);
                $courseStats->totalViews += $course['totalViews'];
                $courseStats->uniqueViewsCount += $course['uniqueViewsCount'];
                $courseStats->uniqueRegViewsCount += $course['uniqueRegViewsCount'];
                $courseStats->registeredViews += $course['registeredViews'];
                $courseStats->guestViews += $course['guestViews'];  
            }   
            
            // $newAllCourseStats->push($newVodStats);
        }



        // $survey = Survey::find(1);
        // $s_questions = SurveyQuestion::where('survey_id', 1)->get();

        // // dd($survey, $s_questions);

        // return View('surveys.test-survey', compact('survey', 's_questions'));



        // $user = User::find(1632);
        // dd($user, $user->profile, $user->profile->avatar);

        // $this->activationFunction(1632);

        // foreach (Auth::user()->enrolledcourses as $c) {     
        //     dd(Auth::user(), $c, $c->course);     
        // }
        
        // $allNon1MStudents = LearnerCourse::join('orders', 'learnercourses.order_id', '=', 'orders.id')
        // // ->select('learnercourses.*', 'orders.id', 'orders.service_id')
        // ->where('orders.service_id', '!=', 5)
        // ->get();

        // $all1MStudents = LearnerCourse::join('orders', 'learnercourses.order_id', '=', 'orders.id')
        // // ->select('learnercourses.*', 'orders.id', 'orders.service_id')
        // ->where('orders.service_id', '=', 5)
        // ->get();
        // // dd($all1MStudents);
        // // dd($allNon1MStudents->first(), $all1MStudents->first());

        // $reEnrolled1Mstudents = collect();

        // foreach ($allNon1MStudents as $student) {
        //     $duplicate = $all1MStudents->where('user_id', $student->user_id)
        //     ->first();

        //     if (isset($duplicate)) {
        //         // dd($duplicate);
        //         if (Carbon::parse($duplicate->created_at)->lt(Carbon::parse($student->created_at))) {
        //             $reEnrolled1Mstudents->push($student);
        //             // dd("listed", $duplicate, $student);
        //         } else {
        //             // dd("unlisted", , $duplicate, $student);
        //             // dd(Carbon::parse($duplicate->created_at)->lt(Carbon::parse($student->created_at)), Carbon::parse($enrollment->created_at), Carbon::parse($student->created_at));
        //         }
        //     }
        // }

        // dd($reEnrolled1Mstudents);
    }

    public function subtitlesTest () {	
        $vod_id = 20;
        $vod = Vod::find($vod_id);
        $vodCategory = VodCategory::find($vod->category_id);
        
        if (isset($vodCategory)) {        
            $categoryVods = Vod::where('category_id', $vodCategory->id)
            ->where('id', '!=', $vod->id)
            ->where('video', '!=', null)
            ->where('private', '0')
            ->orderBy('vorder', 'asc')
            ->get();
            
            if (isset($categoryVods)) {
                foreach ($categoryVods as $otherVod) {
                    $directors = VodCrew::select('short_name')
                    ->where('vod_id', $otherVod->id)
                    ->where('crew_type_id', 3)
                    ->get();
        
                    if (isset($directors)) {
                        $otherVod->directors = $directors;
                    }
                }
            }
        } else {
            $categoryVods = null;
        }
        
        // get all Crew Type Names
		$vodCrewTypeNames = VodCrewType::join('vod_crew', 'vod_crew_types.id', '=', 'vod_crew.crew_type_id')
        ->select('vod_crew_types.*')
        ->where('vod_crew.vod_id', $vod_id)
        ->distinct()
        ->orderBy('vod_crew_types.torder', 'asc')
		->get();

		$vodCrewTypes = collect();        
        if (isset($vodCrewTypeNames)) {
            // Get All crews by crew type id
            $index = 0;
            foreach ($vodCrewTypeNames as $vodCrewTypeName) {
                $vodCrew = null;
                $vodCrew = VodCrew::join('vod_crew_types', 'vod_crew.crew_type_id', '=', 'vod_crew_types.id')
                ->select('vod_crew.*', 'vod_crew_types.name as crew_type_name')
                ->where('vod_crew.vod_id', $vod_id)
                ->where('vod_crew.crew_type_id', $vodCrewTypeName->id)
                ->orderBy('vod_crew.corder', 'asc')
                ->get();
    
                if (isset($vodCrew)) {
                    $vodCrewTypes->push($vodCrew);
                }
    
                $index++;
            }
        }
        return View('tests.subtitles-test', compact('vod', 'vodCategory', 'categoryVods', 'vodCrewTypes')); 
    }

    public function test01_4_7_2020() { 	
		dd(url('profile/xe/edit/notif'));

		return response()->json(['newDate'=>$newDate, 'avatar'=>$avatar]);

        return View('tests.test01', compact('vods'));
    }

    public function test01_4_2_2020()
    {         
        $comment =  Comment::find(443);			

			// --NOTIF START--
			// Get comments on this topic
			$allComments = Comment::where('topic_id', $comment->topic_id)
			->get();

			// Get distinct user IDs
			$userIDs = [];
			foreach ($allComments as $aComment) {
				// If User is not me & If user is not in array already
				if ($aComment->user_id != Auth::User()->id && !in_array($aComment->user_id, $userIDs)) {
					array_push($userIDs, $aComment->user_id);
				}
			}

			// Get Users form user IDs
			$receivers = collect();	
			foreach ($userIDs as $userID) {   
				$receivers->push(User::find($userID));
			}
			
			$url = url(str_replace(url('/'), '', url()->previous()));
			$sender = Auth::User();

			// Check if Comment Type: Submission, Topic
			if ($comment->type === 'submission') {
				$submission = Submission::find($comment->topic_id);
				$type = "SaluhanSubmissionComment";
		
				$notifData = collect([
					'sender' => $sender,
					'url' => $url,
					'comment' => $comment,
					'submission' => $submission,
					'type' => $type,
				]);
	
				Notification::send($receivers, new SendSaluhanSubmissionCommentNotif($notifData));
			} else if ($comment->type === 'topic') {
				$topic = Topic::find($comment->topic_id);
				$type = "TopicComment";
		
				$notifData = collect([
					'sender' => $sender,
					'url' => $url,
					'comment' => $comment,
					'topic' => $topic,
					'type' => $type,
				]);
	
				Notification::send($receivers, new SendTopicCommentNotif($notifData));
			}
			// --NOTIF END--

			dd($receivers);

			return response()->json([
					'id' => $comment->id, 
					'topic_id' => $comment->topic_id, 
					'type' => $comment->type, 
					'parent_id' => $comment->parent_id
			]);   

        return View('tests.test01', compact('vods'));
    }

    public function markAsReadAll()
    {          
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();

        // return redirect()->back();
    }     

    public function getAllStats() {
        // Blackbox Stats Start
            $allVodViews = LoggerActivity::where('description', 'LIKE', '%blackbox%watch%')
            ->where('userType', '!=', 'Crawler')
            ->orderBy('created_at', 'desc')
            ->get();
        
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
    
            $startDate = Carbon::parse($allVodViews->last()->created_at);
            $endDate = Carbon::now()->addDay();
            $timePeriod = CarbonPeriod::create($startDate, $endDate);
            
            $dailyStats = collect();  
            $allVods = Vod::select('title', 'id')->get();
    
            // Iterate over the period
            foreach ($timePeriod as $date) {            
                $dayStats = new VodStats;
                $dayStats->date = $date->toDateString();
                $dayStats->totalViews = 0;
                $dayStats->uniqueViews = collect();
                $dayStats->uniqueViewsCount = 0;
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
                    $newVod->registeredViews = 0;
                    $newVod->guestViews = 0;   
                    
                    $dayStats->vods->push($newVod);
                } 
    
                $dailyStats->push($dayStats);  
            }
            // dd($timePeriod, $dailyStats);
            
            foreach ($allVodViews as $vodView) {  
                $dayStats = $dailyStats->firstWhere('date', Carbon::parse($vodView->created_at)->toDateString());
                
                if (!isset($dayStats)) {
                    dd($vodView);
                }

                $vod = $dayStats->vods->firstWhere('title', $vodView->vodTitle);
    
                if ($vodView->userType == "Registered") {
                    $dayStats->totalViews++;   
                    $dayStats->registeredViews++;   
                    $vod->totalViews++;   
                    $vod->registeredViews++;   
                } else if ($vodView->userType == 'Guest') {
                    $dayStats->totalViews++;   
                    $dayStats->guestViews++;   
                    $vod->totalViews++;   
                    $vod->guestViews++;   
                }      
    
                if (isset($dayStats->uniqueViews->first()->ipAddress)) {
                    // Adding unique users by IP
                    $exist = $dayStats->uniqueViews->firstWhere('ipAddress', $vodView->ipAddress);
                    if (!isset($exist)) {
                        $dayStats->uniqueViews->push($vodView); 
                        $vod->uniqueViews->push($vodView);  
                    }
    
                } else {
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
    
        AnalyticsLog::truncate();
        
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
        dd($dailyStats);

        foreach($dailyStats as $dailyStat) {
            $dailyStat->uniqueViews = NULL;
            foreach($dailyStat->vods as $vod) {
                $vod->uniqueViews = NULL;
            }
            $vodDailyAnalytics = AnalyticsLog::create([
                'type'          => "VOD-Daily",
                'content'       => $dailyStat,
                'date'          => $dailyStat->date,
            ]);
    
            $vodDailyAnalytics->save();  
        }
    }

    public function sendOldDailyEmails () {   
        $startDate = Carbon::parse('2019-08-19');
        // $startDate = Carbon::parse('2020-04-30');
        $endDate = Carbon::parse('2019-08-24');
        // $endDate = Carbon::parse('2020-05-08');
        $timePeriod = CarbonPeriod::create($startDate, $endDate);        

        foreach ($timePeriod as $date) {
            // User Stats Start        
                $users = null;
                $enrolled = null;

                
                $users = User::whereDate('created_at', $date->format('Y-m-d'))
                          ->get();
                      
                $enrolled = LearnerCourse::whereDate('created_at', $date->format('Y-m-d'))
                          ->get();
                          
                $orders = Order::whereDate('created_at', $date->format('Y-m-d'))
                            ->where('amount', '>', 0)
                            ->where('payment_status', 'S')
                            ->where('payment_id', '!=', 6)
                            ->get();                               
            // User Stats End  
                
                // dd(User::find(412));
                              
                // $admins = [1, 10, 12, 16, 87, 412];
                // $admins = [412];
                // $admins = [12];
                foreach ($admins as $a) :
                    $admin = User::find($a);
                    // if (count($admin) > 0) Notification::send($admin, new SendDailyStats($userData, $vodData, $courseData));
                    Notification::send($admin, new SendDailyStatsTemp2($users, $enrolled, $orders, $date));
                endforeach;	  	

                // break;   
        }

        dd("done");
    }     

    public function sendDailyEmails () {   
        // $startDate = Carbon::parse('2020-04-07');
        $startDate = Carbon::parse('2020-04-30');
        // $endDate = Carbon::parse('2020-04-30');
        $endDate = Carbon::parse('2020-05-07');
        $timePeriod = CarbonPeriod::create($startDate, $endDate);        

        foreach ($timePeriod as $date) {
            // User Stats Start        
                $users = null;
                $enrolled = null;

                
                $users = User::whereDate('created_at', $date->format('Y-m-d'))
                          ->get();
                      
                $enrolled = LearnerCourse::whereDate('created_at', $date->format('Y-m-d'))
                          ->get();
                          
                $orders = Order::whereDate('created_at', $date->format('Y-m-d'))
                            ->where('amount', '>', 0)
                            ->where('payment_status', 'S')
                            ->where('payment_id', '!=', 6)
                            ->get();                               
            // User Stats End  
                
            // Vod Stats Start   
                $vodPurchases = VodPurchase::whereDate('created_at', $date->format('Y-m-d'))
                ->get();
        
                $rawVodStat = AnalyticsLog::select('content')
                ->where('type', 'VOD-Daily')
                ->whereDate('date', $date->format('Y-m-d'))
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
                $courses = Course::all();  
        
                $allCompletedStats = collect();

                $course_id = 1;
        
                foreach ($courses as $course) {
                    
                    $elessons = null;
                    $activities = LoggerActivity::whereDate('created_at', '<', $date->format('Y-m-d'))
                    ->where('route','LIKE','%lesson%show%')->select('route','userId')->distinct()->get();
                    
                    $arr = array();
                    
                    foreach ($activities as $activity) :
                        
                        $route = str_replace('https://', '', $activity['route']);
                        
                        $arr = explode('/',$route);
                        
                        if (isset($arr[2])) :
                            $lesson = Lesson::find($arr[2]);
                            if (isset($lesson)) :
                                if (is_null($course_id) || $course_id == $lesson->course_id) 
                                    $elessons[$lesson->course_id][$activity['userId']][$lesson->id] = array('id' => $arr[2], 'title' =>$lesson->title);        			
                            endif;	 
                        endif;
                            
                    endforeach;

                    $allCompletions = $elessons; 
                    
                    $allCount = 0;
                    foreach ($allCompletions[$course->id] as $key => $value ) :
                        if (count($allCompletions[$course->id][$key]) > 13) $allCount++;
                    endforeach;  
                    
                    $elessons = null;
                    $activities = LoggerActivity::whereDate('created_at', '<=', $date->format('Y-m-d'))
                    ->where('route','LIKE','%lesson%show%')->select('route','userId')->distinct()->get();
                    
                    $arr = array();
                    
                    foreach ($activities as $activity) :
                        
                        $route = str_replace('https://', '', $activity['route']);
                        
                        $arr = explode('/',$route);
                        
                        if (isset($arr[2])) :
                            $lesson = Lesson::find($arr[2]);
                            if (isset($lesson)) :
                                if (is_null($course_id) || $course_id == $lesson->course_id) 
                                    $elessons[$lesson->course_id][$activity['userId']][$lesson->id] = array('id' => $arr[2], 'title' =>$lesson->title);        			
                            endif;	 
                        endif;
                            
                    endforeach;

                    $dailyCompletions = $elessons; 
                    
                    
                    $dailyCount = 0;
                    foreach ($dailyCompletions[$course->id] as $key => $value ) :
                        if (count($dailyCompletions[$course->id][$key]) > 13) $dailyCount++;
                    endforeach;   
                                
                    $courseStats = collect();
                    $courseStats->id = $course->id;
                    $courseStats->title = $course->title;
                    $courseStats->weeklyCompletions = ($dailyCount - $allCount);
        
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
                
                // dd(User::find(412));
                              
                // $admins = [1, 10, 12, 16, 87, 412];
                // $admins = [412];
                $admins = [12];
                foreach ($admins as $a) :
                    $admin = User::find($a);
                    // if (count($admin) > 0) Notification::send($admin, new SendDailyStats($userData, $vodData, $courseData));
                    Notification::send($admin, new SendDailyStatsTemp($userData, $vodData, $courseData, $date));
                endforeach;	  	

                // break;   
        }

        dd("done");
    }

    public function activationFunction ($user_id) {       
        $user = User::find($user_id);
        $currentRoute = Route::currentRouteName();
        $ipAddress = new CaptureIpTrait();
        $role = Role::where('slug', '=', 'user')->first();
        $profile = new Profile();

        $rCheck = $this->activeRedirect($user, $currentRoute);
        if ($rCheck) {
            return $rCheck;
        }

        $user->activated = true;
        $user->detachAllRoles();
        $user->attachRole($role);
        $user->signup_confirmation_ip_address = $ipAddress->getClientIp();
        $user->profile()->save($profile);
        $user->save();

        $allActivations = Activation::where('user_id', $user->id)->get();
        foreach ($allActivations as $anActivation) {
            $anActivation->delete();
        }

        Log::info('Registered user successfully activated. '.$currentRoute.'. ', [$user]);

        if ($user->isAdmin()) {
            return redirect()->route(self::$getAdminHomeRoute())
            ->with('status', 'success')
            ->with('message', trans('auth.successActivated'));
        }

        return redirect()->route(self::getUserHomeRoute())
            ->with('status', 'success')
            ->with('message', trans('auth.successActivated'));
    }

    public static function activeRedirect($user, $currentRoute)
    {
        if ($user->activated) {
            Log::info('Activated user attempted to visit '.$currentRoute.'. ', [$user]);

            if ($user->isAdmin()) {
                return redirect()->route(self::getAdminHomeRoute())
                ->with('status', 'info')
                ->with('message', trans('auth.alreadyActivated'));
            }

            return redirect()->route(self::getUserHomeRoute())
                ->with('status', 'info')
                ->with('message', trans('auth.alreadyActivated'));
        }

        return false;
    }

    

    private static $userHomeRoute = 'public.home';
    private static $adminHomeRoute = 'public.home';
    private static $activationView = 'auth.activation';
    private static $activationRoute = 'activation-required';

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
     * Gets the user home route.
     *
     * @return string
     */
    public static function getUserHomeRoute()
    {
        return self::$userHomeRoute;
    }

    /**
     * Gets the admin home route.
     *
     * @return string
     */
    public static function getAdminHomeRoute()
    {
        return self::$adminHomeRoute;
    }

    /**
     * Gets the activation view.
     *
     * @return string
     */
    public static function getActivationView()
    {
        return self::$activationView;
    }

    /**
     * Gets the activation route.
     *
     * @return string
     */
    public static function getActivationRoute()
    {
        return self::$activationRoute;
    }
}