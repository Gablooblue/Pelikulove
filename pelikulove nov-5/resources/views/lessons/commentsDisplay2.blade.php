@foreach($comments as $comment)
    <div class="display-comment" id="comment_{{$comment->id}}" @if($comment->parent_id != null) style="margin-left:40px;" @endif>
        <div class="comment @if($comment->parent_id == null) border-bottom border-light @endif">
        		
        	<a class="text-dark" href="{{url('/profile/'.$comment->user->name)}}">
        	<img src="@if ($comment->user->profile->avatar_status == 1) {{ $comment->user->profile->avatar }} @else {{ Gravatar::get($comment->user->email) }} @endif" alt="{{ $comment->user->name }}" class="user2-avatar-nav mt-1"></a>

            <a class="text-dark" href="{{url('/profile/'.$comment->user->name)}}"><strong>{{ $comment->user->name }}</strong></a> <span class="small text-secondary">{{\Carbon\Carbon::createFromTimeStamp(strtotime($comment->created_at))->diffForHumans()}}	</span>
        		@if ($level+1 < 2)<a class="reply text-danger btn btn-sm btn-light" data-id="{{$comment->id}}" role="button"><i class="fa fa-reply"></i> Reply</a>@endif

        	<p>{{ $comment->body }} </p>
        		
        	@if ($level+1 < 2)
        	<div class="d-none" id="rcommentModal{{$comment->id}}">
        		<form method="POST" action="" class="rcommentForm" id="rcommentForm_{{ $comment->id }}"> 
        		 @csrf
                  	<div class="form-group">
                		<input type="text" name="body"  placeholder="Type your comment here" class="form-control" />
                		<input type="hidden" name="topic_id"  value="{{ $topic->id }}" />
                		<input type="hidden" name="parent_id" value="{{ $comment->id }}" />
                        <input type="hidden" name="type" value="topic" />
                        <input type="hidden" name="level" value="{{$level}}" />
            		</div>
            		<div class="form-group">
                		<input type="submit" class="btn btn-sm btn-success" data-id="{{$comment->id}}" id="ajaxsubmit2_{{$comment->id}}" value="Reply" />
                	</div>
        		</form>
        	</div>
        		
        		
        	@include('lessons.commentsDisplay2', ['comments' => $comment->replies->sortBy('created_at'), 'level' => $level+1])
        	@endif	
       			
        </div>
    </div>
@endforeach


