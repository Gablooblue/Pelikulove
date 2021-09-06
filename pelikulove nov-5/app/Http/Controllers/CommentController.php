<?php
   
namespace App\Http\Controllers;
   
use Auth;
use Illuminate\Support\Facades\Notification;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Submission;
use App\Models\Topic;
use App\Models\Lesson;
use App\Models\User;
use App\Models\Vod;
use App\Notifications\SendSaluhanSubmissionCommentNotif;
use App\Notifications\SendTopicCommentNotif;
use App\Notifications\SendVodCommentNotif;
   
class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	if ($request->ajax())  {
			
			$request->validate([
           	 	'body'=>'required',
           	 	'topic_id' => 'required',
           	 	'type' => 'required'
            ]);
        
        	
        	$input = $request->all();
        	$input['user_id'] = auth()->user()->id;
    
       		$comment =  Comment::create($input);

			return response()->json([
   				 'id' => $comment->id, 'topic_id' => $comment->topic_id, 'type' => $comment->type, 'parent_id' => $comment->parent_id
    		]);
    	
    	}
    	else{
          return response()->json(['status' => 'error']);
        }
    }
    
    public function store2(Request $request)
	{
		if ($request->ajax())  {			
			$request->validate([
           	 	'body'=>'required',
           	 	'topic_id' => 'required',
           	 	'type' => 'required'
			]);        
        	
			$input = $request->all();
			$input['user_id'] = auth()->user()->id;

			$comment = Comment::create($input);
			$comment->save();

			// --NOTIF START--

			// Get comments on this topic
			if ($comment->type === 'vod') {
				$allComments = Comment::where('type', '=', 'vod')
				->where('topic_id', $comment->topic_id)
				->whereNull('parent_id')
				->get();
			} else if ($comment->type === 'submission') {
				$allComments = Comment::where('type', '=', 'submission')
				->where('topic_id', $comment->topic_id)
				->whereNull('parent_id')
				->get();
			} else if ($comment->type === 'topic') {
				$allComments = Comment::where('type', '=', 'topic')
				->where('topic_id', $comment->topic_id)
				->get();
			}

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
				$author_id = Submission::find($comment->topic_id)->user_id;	
				if ($author_id != Auth::User()->id && !in_array($author_id, $userIDs)) {
					$receivers->push(User::find($author_id));
				}

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
			} else if ($comment->type === 'vod') {
				$video = Vod::find($comment->topic_id);
				$type = "VodComment";
		
				$notifData = collect([
					'sender' => $sender,
					'url' => $url,
					'comment' => $comment,
					'video' => $video,
					'type' => $type,
				]);
	
				Notification::send($receivers, new SendVodCommentNotif($notifData));
			}
			// --NOTIF END--

			return response()->json([
					'id' => $comment->id, 
					'topic_id' => $comment->topic_id, 
					'type' => $comment->type, 
					'parent_id' => $comment->parent_id,
			]);    	
    	}
    	else {
          return response()->json(['status' => 'error']);
        }
	}
	
	
	
	public function show(Request $request){
     
     	   $comments = array();
           $comment = Comment::find($request->id);
           $topic = Topic::find($comment->topic_id);
           $comments[] = $comment;
          
 		   return view('lessons.commentsDisplay', compact('comments', 'topic'));
        
    }
    
    public function show2(Request $request){
     
     	   $comments = array();
           $level = 0;
           $comments = Comment::getAllComments($request->id, $request->type);
           if ($request->type == 'topic') :
           		$topic = Topic::find($request->id);
        		return view('lessons.commentsDisplay2', compact('comments', 'level', 'topic'));
           else:
           		$lesson = Lesson::find($request->id);
        		return view('submissions.commentsDisplay2', compact('comments','level', 'lesson'));
           endif;
           
           
        
    }
    
    public function showAll(Request $request){
     
     	   $comments = array();
           $comments = Comment::getAllComments($request->id, $request->type);
           if ($request->type == 'topic') :
           		$topic = Topic::find($request->id);
        		return view('lessons.commentsDisplay', compact('comments', 'topic'));
           else:
           		$lesson = Lesson::find($request->id);
        		return view('submissions.commentsDisplay', compact('comments', 'lesson'));
           endif;
           
    }
    
    
}
