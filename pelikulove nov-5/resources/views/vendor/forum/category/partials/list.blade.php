<tr>
    <td {{ $category->threadsEnabled ? '' : 'colspan=5' }}>
        <h5 class="{{ isset($titleClass) ? $titleClass : '' }}"><a href="{{ Forum::route('category.show', $category) }}">{{ $category->title }}</a></h5>
        <h5><span class="text-muted small">{{ $category->description }}</span></h5>
        
    </td>
    @if ($category->threadsEnabled)
        <td>{{ $category->thread_count }}</td>
        <td>{{ $category->post_count }}</td>
        <td>
            @if ($category->newestThread)@php $user = \App\Models\User::where('name', '=', $category->newestThread->authorName)->first(); @endphp
               <div class="row">
            	<div class="float-left pl-2">
            		 @if (Auth::User())<a class="text-dark" href="{{url('/profile/'.$user->name)}}">@endif<img src="@if ($user->profile->avatar_status == 1) {{ $user->profile->avatar }} @else {{ Gravatar::get($user->email) }} @endif" alt="{{ $user->name }}" class="user2-avatar-nav mr-1">@if (Auth::User())</a>@endif

            	</div>
            	<div class="float-right">
                <div class=""><a href="{{ Forum::route('thread.show', $category->newestThread) }}">
                    {{ $category->newestThread->title }} </a></div>
                
            	@if (Auth::User())<a class="text-dark" href="{{url('/profile/'.$category->newestThread->authorName)}}">@endif<span class="text-nowrap small font-weight-bold">By {{ $category->newestThread->authorName }}</span>@if (Auth::User())</a> @endif<br>
            	<span class="small font-italic text-secondary">{{\Carbon\Carbon::createFromTimeStamp(strtotime($category->newestThread->created_at))->diffForHumans()}}	</span>
        		</div>
        	</div>	
            @endif
        </td>
        <td>
            @if ($category->latestActiveThread)@php $user = \App\Models\User::where('name', '=', $category->latestActiveThread->lastPost->authorName)->first(); @endphp
                
            <div class="row">
            	<div class="float-left pl-2">
            	@if (Auth::User())<a class="text-dark" href="{{url('/profile/'.$user->name)}}">@endif<img src="@if ($user->profile->avatar_status == 1) {{ $user->profile->avatar }} @else {{ Gravatar::get($user->email) }} @endif" alt="{{ $user->name }}" class="user2-avatar-nav mr-1">@if (Auth::User())</a>@endif

            	</div>
            	<div class="float-right">
                <div class=""><a href="{{ Forum::route('thread.show', $category->latestActiveThread->lastPost) }}">
                    {{ $category->latestActiveThread->title }}
                      </a></div>
                
            	@if (Auth::User())<a class="text-dark" href="{{url('/profile/'.$category->latestActiveThread->lastPost->authorName)}}">@endif<span class="text-nowrap small font-weight-bold">By {{ $category->latestActiveThread->lastPost->authorName }}</span>@if (Auth::User())</a> @endif<br>
            	<span class="small font-italic text-secondary">{{\Carbon\Carbon::createFromTimeStamp(strtotime($category->latestActiveThread->lastPost->updated_at))->diffForHumans()}}	</span>
        		</div>
        	</div>	
              
            @endif
        </td>
    @endif
</tr>
