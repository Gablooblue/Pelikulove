<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Notifications\SendTaumbayanPostNotif;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DatabaseNotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
        
    public function markAsReadAll()
    {          
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();
    }

    public function index()
    {        
        return View('dbnotifs/index');
    }

    public function getNotifications () {
        $user = Auth::user();
        return $user->notifications;
    }

    public function getNotifDetails (Request $request) { 
        if ($request->isMethod('POST')){    
            //get newDate        
            $date = $request->input('date');
            $newDate = Carbon::createFromTimeStamp(strtotime($date))->diffForHumans();
                     
            //get avatar
            $user = User::find($request->input('user_id'));    
            if ($user->profile->avatar_status == 1) {
                $avatar = asset($user->profile->avatar);
            }
            else {
                $avatar = asset('images/default_avatar.png');
            }

            return response()->json(['newDate'=>$newDate, 'avatar'=>$avatar]);
        }   
    }
}