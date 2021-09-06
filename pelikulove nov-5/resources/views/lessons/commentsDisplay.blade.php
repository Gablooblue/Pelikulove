@foreach($comments as $comment)
    <div class="display-comment" @if($comment->parent_id != null) style="margin-left:40px;" @endif>
        <div class="media mt-1 mb-2">
        		<a class="text-dark" href="{{url('/profile/'.$comment->user->name)}}">
        		<img src="@if ($comment->user->profile->avatar_status == 1) {{ $comment->user->profile->avatar }} @else {{ Gravatar::get($comment->user->email) }} @endif" alt="{{ $comment->user->name }}" class="user2-avatar-nav mt-1"></a>
				
				<div class="media-body mt-0 pt-0">
            	<div class="font-weight-bold my-0 py-0"> <a class="text-dark" href="{{url('/profile/'.$comment->user->name)}}"><strong>{{ $comment->user->name }}</strong></a> <span class="small text-secondary">{{\Carbon\Carbon::createFromTimeStamp(strtotime($comment->created_at))->diffForHumans()}}	</span></div>
        		@if (count($comment->user->roles) > 0) @foreach ($comment->user->roles as $user_role)
     					@if ($user_role->name == 'Student')
                                                        @php $badgeClass = 'primary' @endphp
                                                    @elseif ($user_role->name == 'Admin' || $user_role->name == 'Pelikulove' )
                                                        @php $badgeClass = 'info' @endphp
                                                    @elseif ($user_role->name == 'Mentor')
                                                    	@php $badgeClass = 'success' @endphp
                                                    @elseif ($user_role->name == 'Unverified')
                                                        @php $badgeClass = 'danger' @endphp
                                                    @else
                                                        @php $badgeClass = 'default' @endphp
                                                    @endif
                                                    <div class="small mt-n1 py-0">{{ $user_role->name }}</div> 		
                        @endforeach
                    @endif
        		<p>{{ $comment->body }} </p>
        		</div>
        </div>	    
    </div>
@endforeach
