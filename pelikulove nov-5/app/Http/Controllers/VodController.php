<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Course;
use App\Models\Vod;
use App\Models\User;
use App\Models\VodCategory;
use App\Models\VodPurchase;
use App\Models\VodSlideshow;
use App\Models\VodTimeCode;
use App\Models\Order;
use App\Models\VodCrew;
use App\Models\VodCrewType;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class VodController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function index() {      
        $vodCategories = array();
        $vodPurchases = VodPurchase::all();  
        $vodSlideshows = VodSlideshow::orderBy('order')
        ->get();
        $course = Course::find(1);

        // Get all distinct vod categories that has a vod
        $vodCategoryNames = Vod::join('vod_categories', 'vods.category_id', '=', 'vod_categories.id')
        ->select('vod_categories.name', 'vod_categories.id')
        ->where('vods.private', '0')
        ->where('vods.hidden', '0')
        ->where('vod_categories.hidden', '0')
        ->distinct()
        ->orderBy('vod_categories.corder', 'asc')
        ->get();

        // Put all vods to each Category
        for ($i=0; $i<sizeof($vodCategoryNames); $i++){
            $vodCategories[$i] = Vod::join('vod_categories', 'vods.category_id', '=', 'vod_categories.id')
            ->select('vods.*', 'vod_categories.name', 'vod_categories.corder')
            ->where('vods.category_id', $vodCategoryNames[$i]->id)
            ->where('vods.video', '!=', null)
            ->where('vods.hidden', '!=', '1')
            ->where('private', '0')
            ->orderBy('vods.vorder', 'asc')
            ->get();

            foreach ($vodCategories[$i] as $otherVod) {
                $directors = VodCrew::select('short_name')
                ->where('vod_id', $otherVod->id)
                ->where('crew_type_id', 3)
                ->get();
    
                if (isset($directors)) {
                    $otherVod->directors = $directors;
                }
            }
        }
        
        return view('/vods/index', compact('vodCategories', 'vodPurchases', 'vodSlideshows', 'course'));
    } 
 
 	/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		
    }

    public function show(Request $request, $vod_id)
    {           
        $vod = Vod::find($vod_id);
        
        // If Vod Doesn't Exist
        if (!isset($vod)) :			
            return back()->with('danger', 'Vod does not exist.');		
        endif;
        
        $code = $request->session()->get('code');

        // If Session Code Exists
        if (isset($code)) {
            $vodTimeCode = VodTimeCode::find($code->id);
        }

        // If Vod is private, redirect to showPrivate
        if ($vod->private == 1) {            
            return redirect()->route('vod.showPrivate', $vod_id);
        } else if ($vod->paid == 1) {

            // If Session Code Doesn't Exist
            if (isset($code)) {
                if (isset($vodTimeCode)) {
                    return redirect()->route('vod.showPrivate', $vod_id);	
                }
            }
        }

        $vodCategory = VodCategory::find($vod->category_id);

        if (Auth::check()) {
            // Notif Read Check		            
	        $notifications = auth()->user()->unreadNotifications;	
            foreach ($notifications as $notification) {
                if (isset($notification->data['vod_id'])) {
                    if ($notification->data['vod_id'] == $vod_id) {					
                        $notification->markAsRead();
                    }
                }
            } 

            $owned = VodPurchase::ifOwned($vod->id, Auth::user()->id);
            
            // If Vod is Paid
            if (!$owned && $vod->paid == 1) :
                return redirect()->route('vod.purchase', ['vod_id' => $vod->id]);	
                // $vod->video = null;
                // $vod->transcript = null;
            endif;

            // Check if user is activated for more than x hrs 
            $user = Auth::user();
            $maxLimit = Carbon::parse($user->created_at);
            $maxLimit->addHours(4); 

            if ($user->activated != 1 && Carbon::now()->gt($maxLimit)) {        
                return redirect()->route('activation-required')
                    ->with([
                        'message' => 'Unactivated viewing limit reached. Please Activate your account to continue. ',
                        'status'  => 'danger',
                    ]);
            }
            
        } else {
            $vod->video = null;
            $vod->transcript = null;
        }
        
        if (isset($vodCategory)) {        
            $categoryVods = Vod::where('category_id', $vodCategory->id)
            ->where('id', '!=', $vod->id)
            ->where('video', '!=', null)
            ->where('private', '0')
            ->where('hidden', '0')
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
        $oneVod = $vod;
        
        $nextVod = Vod::find($vod->next_video_id);
        if (!isset($nextVod) && isset($categoryVods)) {   
            $vodOrderId = $vod->vorder;   
            $vodCategoryId = $vod->category_id;   
            $isNextVod = false; 
            $catVods = Vod::where('category_id', $vodCategory->id)
            ->where('video', '!=', null)
            ->where('private', '0')
            ->where('hidden', '0')
            ->orderBy('vorder', 'asc')
            ->get();
            
            foreach ($categoryVods as $aVod) {
                if ($isNextVod) {
                    $nextVod = $aVod;
                }
                if ($aVod->id == $vod->id) {
                    $isNextVod = true;
                }
            }

            if (!isset($nextVod)) {                                
                $nextVod = $categoryVods->first();
            }
        }

        if (!Auth::check()) {
            $vod->video = null;
            $vod->transcript = null;

            if ($vod->paid == 1) {                
                return redirect()->route('vod.purchase', ['vod_id' => $vod->id]);
            }
        }
        
        return view('vods/show', compact('vod', 'vodCategory', 'categoryVods', 'oneVod', 'vodCrewTypes', 'nextVod')); 
    }
    
    public function showPrivate(Request $request, $vod_id)
    {    
        $vod = Vod::find($vod_id);
        
        // If Vod Doesn't Exist
        if (!isset($vod)) :			
            return back()->with('danger', 'Vod does not exist.');		
        endif;

        $vodCategory = VodCategory::find($vod->category_id);
        
        // If Vod Category Doesn't Exist
        if (!isset($vodCategory)) :			
            return back()->with('danger', 'Vod Category does not exist.');		
        endif;

        if ($vod->paid == 1)  {
            $code = $request->session()->get('code');

            // If Session Code Doesn't Exist
            if (!isset($code)) {
                return redirect()->route('vod.purchase', ['vod_id' => $vod->id]);	
            }

            $vodTimeCode = VodTimeCode::find($code->id);
            
            // If Code Doesn't Exist
            if (!isset($vodTimeCode)) {
                return redirect()->route('vod.purchase', ['vod_id' => $vod->id]);	
            }
        }
        
        // If Vod is Private
        if ($vod->private == 1 || $vod->paid == 1) :
            $code = $request->session()->get('code');

            // If Session Code Doesn't Exist
            if (!isset($code)) {
                return redirect()->route('vod.index')
                ->with(['message' => 'The Video you are trying to access is private.', 
                'status' => 'danger']);
            }

            $vodTimeCode = VodTimeCode::find($code->id);

            // If Code Doesn't Exist
            if (!isset($vodTimeCode)) {
                return redirect()->route('vod.index')
                ->with(['message' => 'The Video you are trying to access is private.', 
                'status' => 'danger']);	
            }
            
            $startsAt = Carbon::parse($vodTimeCode->starts_at);
            $endsAt = Carbon::parse($vodTimeCode->ends_at);

            $codeVod = Vod::find($vodTimeCode->vod_id);

            if (!isset($codeVod)) {
                return redirect()->route('vod.index')
                ->with(['message' => 'The video of your code no longer exists. Contact pelikuloveofficial@gmail.com for support', 'status' => 'danger']);                
            }

            if ($startsAt->lt(now()) && $endsAt->gt(now())) {
                if ($codeVod->id != $vod->id) {
                    if ($vod->paid == 1 && $vod->private != 1) {
                        return redirect('/redeem-a-code')
                        ->with(['message' => 'Your free access code is for a different Paid Video.<br><a href="' . route('vod.showPrivate', ['vod_id' => $vod->id]) . '">Click here to watch your free access code Video!</a><br>
                        If you want to watch this other Video, <a href="' . route('vod.purchase', ['vod_id' => $vod->id]) . '">Click here to purchase it.</a>', 'status' => 'warning']);
                    } else {
                        return redirect('/redeem-a-code')
                        ->with(['message' => 'Your free access code is for a different private Video.<br><a href="' . route('vod.showPrivate', ['vod_id' => $vod->id]) . '">Click here to watch your free access code Video!</a>', 'status' => 'warning']);
                    }
                }
            } else {
                if ($startsAt->gt(now())) {
                    if ($vod->paid == 1 && $vod->private != 1) {
                        return redirect('/redeem-a-code')
                        ->with(['message' => 'Your free access code is not yet usable. Please wait till "' . $startsAt->toDayDateTimeString() . '" for your free viewing session.<br>
                        If you want to access the video sooner, <a href="' . route('vod.purchase', ['vod_id' => $vod->id]) . '">Click here to purchase the video.</a>', 
                        'status' => 'warning']);
                    } else {
                        return redirect('/redeem-a-code')
                        ->with(['message' => 'Your free access code is not yet usable. Please wait till "' . $startsAt->toDayDateTimeString() . '" for your free viewing session.', 
                        'status' => 'warning']);
                    }
                } else if ($endsAt->lt(now())) {
                    $request->session()->forget('code');
                    if ($vod->paid == 1 && $vod->private != 1) {
                        return redirect('/redeem-a-code')
                        ->with(['message' => 'Your free access code to this video is no longer valid. It expired on "' . $endsAt->toDayDateTimeString() . '".<br>
                        <a href="' . route('vod.purchase', ['vod_id' => $vod->id]) . '">Click here to purchase the video.</a>', 
                        'status' => 'danger']);
                    } else {
                        return redirect('/redeem-a-code')
                        ->with(['message' => 'Your free access code to this video is no longer valid. It expired on "' . $endsAt->toDayDateTimeString() . '".', 
                        'status' => 'danger']);
                    }
                } else {
                    return redirect('/redeem-a-code')
                    ->with(['message' => 'Error! Please Contact pelikuloveofficial@gmail.com for support.', 
                    'status' => 'danger']);
                }
            }
        else :
            return redirect()->route('vod.show', $vod_id);
        endif;
        
        $categoryVods = Vod::where('category_id', $vodCategory->id)
        ->where('id', '!=', $vod->id)
        ->where('video', '!=', null)
        ->where('private', '0')
        ->where('hidden', '0')
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

        $oneVod = $vod;
        
        return view('vods/show', compact('vod', 'vodCategory', 'categoryVods', 'oneVod')); 
    }

    public function redirector($vod_id) {
        return redirect('/blackbox/' . $vod_id . '/watch');
    }

    public function redirectorHome() {
        return redirect('/blackbox');
    }

    public function redirectorCategory ($category_id) {
        return redirect('/blackbox/' . $category_id);
    }

    public function redirectorPrivate ($vod_id) {
        return redirect('/blackbox/' . $vod_id . '/watch/private');
    }

    public function showCategory($vodCategory_id) 
    {  
        $vodCategory = VodCategory::find($vodCategory_id);

        $vodPurchases = VodPurchase::all();  

        if (isset($vodCategory)):
            $vods = Vod::where('category_id', $vodCategory->id)
            ->where('video', '!=', null)
            ->where('private', '0')
            ->where('hidden', '0')
            ->orderBy('vorder', 'asc')
            ->get();
            
            foreach ($vods as $otherVod) {
                $directors = VodCrew::select('short_name')
                ->where('vod_id', $otherVod->id)
                ->where('crew_type_id', 3)
                ->get();
    
                if (isset($directors)) {
                    $otherVod->directors = $directors;
                }
            }
            
            return view('/vods/category', compact('vods', 'vodCategory', 'vodPurchases'));
        else:
            return back()->with('danger', 'Category does not exist.');
        endif;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }	
}
