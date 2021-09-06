<?php

namespace App\Http\Controllers;

use App\Models\Vod;
use App\Models\VodCrew;
use App\Models\VodCategory;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Submission;
use App\Models\Topic;
use App\Models\LearnerCourse;
use App\Models\Instructor;
use App\Models\InstructorCourse;
use App\Models\AnalyticsLog;
use Auth;

class UserController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index2()
    {
        $user = Auth::user();
    
        $allcourses = Course::all();
        
        
        $ecourses = null;
        $elessons = array();
        $courses = null;
        
        
        $ecourses = LearnerCourse::getAllUserCourses($user->id);
        

        if ($user->isAdmin()) {
            return view('pages.admin.home', ['courses' => $courses, 'ecourses' => $ecourses, 'allcourses' => $allcourses]);
        }
		
		
        return view('pages.user.home',  ['courses' => $courses, 'ecourses' => $ecourses, 'allcourses' => $allcourses]);
    }
    
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            $ecourses = null;
            $elessons = array();
            $completed = array();
            $submissions = array();
            $mcourses = array();
        
            $allcourses = Course::where('id', '!=', 2)
            ->where('private', 0)
            ->get();
            $enrolledusers = null;
           
            $ecourses = LearnerCourse::where('user_id', '=', $user->id)->where('status', 1)->distinct()->get();
            if (Auth::user()->hasRole('mentor') ||  Auth::user()->hasRole('pelikulove') ||  Auth::user()->hasRole('admin') ):        
                if (Auth::user()->hasRole('mentor')) :
                    $instructor = Instructor::where('user_id', '=', Auth::user()->id)->first();
                    $courses = InstructorCourse::where('instructor_id', '=', $instructor['id'])->pluck('course_id');
                else:
                    $courses = Course::pluck('id'); 
                    
                endif;
                
                foreach ($courses as $c) :
                    $instructor = InstructorCourse::join('instructors', 'instructorcourses.instructor_id', '=', 'instructors.id')
                    ->where('instructorcourses.course_id', '=', $c)
                    ->first();
                    $eusers = LearnerCourse::where('course_id', '=', $c)
                    ->where('user_id', '!=', $instructor->user_id)
                    ->get();
                    $mcourse = Course::find($c);
            
                    
                    $lessons = $mcourse->lessons->pluck('id');
                    $submissions = Submission::whereIn('lesson_id', $lessons)->count();  
                    // $completed = Lesson::getLessonCompletedStats($c);  
                    // $completed = 0;
                    $rawLifetimeCourseStats = AnalyticsLog::select('content')
                    ->where('type', 'Course-All')
                    ->get(); 
                    
                    $rawCourseCompletions = collect();
                    foreach ($rawLifetimeCourseStats as $rawLifetimeStat) {
                        $content = json_decode($rawLifetimeStat->content , true);
                        $rawCourseCompletions->push($content['courseCompletions']);
                    }   

                    foreach ($rawCourseCompletions->first() as $courseCompletion) {
                        if ($c == $courseCompletion['id']) {
                            $completed = $courseCompletion['completions']; 
                        }
                    }

                    if (!isset($completed)) {
                        $completed = 0;
                    }
                    
                    $mcourses[$c] = array('course' => $mcourse, 'students' => $eusers, 'submissions' => $submissions, 'completed' => $completed);
                    
                endforeach;	
                
                $allcourses = Course::whereNotIn('id',$courses)->get();
                if (Auth::user()->hasRole('admin')) {
                    // dd($mcourses);
                }
                //$ecourses = LearnerCourse::where('user_id', '=', $user->id)->whereNotin('course_id',$courses)->distinct()->get();      	
            endif;
                  
            if (count($user->activities) > 0) 
                $completed = Lesson::getLessonCompletedbyUser(Auth::user()->id);
                
            $submissions = Submission::where('user_id', Auth::user()->id)
            ->get();
            
            
                   
            // dd("adsasd");
            // Vod  
            $vodCategories = Vod::join('vod_categories', 'vods.category_id', '=', 'vod_categories.id')
            ->select('vod_categories.name', 'vod_categories.id')
            ->where('vods.private', '0')
            ->where('vods.hidden', '0')
            ->where('vod_categories.hidden', '0')
            ->distinct()
            ->orderBy('vod_categories.corder', 'asc')
            ->get();

            for ($i=0; $i<$vodCategories->count(); $i++){
                $categoryVods[$i] = Vod::join('vod_categories', 'vods.category_id', '=', 'vod_categories.id')
                ->select('vods.*', 'vod_categories.name', 'vod_categories.corder')
                ->where('vods.category_id', $vodCategories[$i]->id)
                ->where('vods.video', '!=', null)
                ->where('vods.hidden', '0')
                ->where('private', '0')
                ->orderBy('vods.vorder', 'asc')
                ->get();

                foreach ($categoryVods[$i] as $otherVod) {
                    $directors = VodCrew::select('short_name')
                    ->where('vod_id', $otherVod->id)
                    ->where('crew_type_id', 3)
                    ->get();
        
                    if (isset($directors)) {
                        $otherVod->directors = $directors;
                    }
                }
            }            

            // foreach (Auth::user()->enrolledcourses as $c) {     
            //     dd(Auth::user(), $c, $c->course);     
            // }
            
            if ($user->isAdmin()) {
                return view('pages.admin.home', compact('ecourses', 'allcourses', 'completed', 'mcourses', 
                'vodCategories', 'categoryVods', 'submissions'));
            } else {
                return view('pages.user.home', compact('ecourses', 'allcourses', 'completed', 'mcourses', 
                'vodCategories', 'categoryVods', 'submissions'));
            }	
        } else {
            $allcourses = Course::where('id', '!=', 2)
            ->where('private', 0)
            ->get();

            // Vod  
            $vodCategories = Vod::join('vod_categories', 'vods.category_id', '=', 'vod_categories.id')
            ->select('vod_categories.name', 'vod_categories.id')
            ->where('vods.private', '0')
            ->where('vods.hidden', '0')
            ->where('vod_categories.hidden', '0')
            ->distinct()
            ->orderBy('vod_categories.corder', 'asc')
            ->get();

            for ($i=0; $i<$vodCategories->count(); $i++){
                $categoryVods[$i] = Vod::join('vod_categories', 'vods.category_id', '=', 'vod_categories.id')
                ->select('vods.*', 'vod_categories.name', 'vod_categories.corder')
                ->where('vods.category_id', $vodCategories[$i]->id)
                ->where('vods.video', '!=', null)
                ->where('vods.hidden', '0')
                ->where('private', '0')
                ->orderBy('vods.vorder', 'asc')
                ->get();

                foreach ($categoryVods[$i] as $otherVod) {
                    $directors = VodCrew::select('short_name')
                    ->where('vod_id', $otherVod->id)
                    ->where('crew_type_id', 3)
                    ->get();
        
                    if (isset($directors)) {
                        $otherVod->directors = $directors;
                    }
                }
            }

            // dd($categoryVods[0][2]);
            
            // $categoryVods = Vod::where('category_id', $vodCategory->id)
            // ->where('video', '!=', null)
            // ->where('private', '0')
            // ->orderBy('vorder', 'asc')
            // ->get(); 


            return view('pages.guesthome', compact('allcourses', 'vodCategories', 'categoryVods'));
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
	
    public function catalogAnalytics()
    {		
		$courses = Course::where('id', '!=', 2)
        ->get();
        
		return view('pages.catalog-analytics', compact('courses'));    	
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
	
    public function catalogAdmin()
    {		        
		return view('pages.catalog-admin');    	
    }
}
