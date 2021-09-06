<tr id="post-{{ $post->sequence }}" class="{{ $post->trashed() ? 'deleted' : '' }} post-body" style="border-color: coral;">
    <td class="author-info pr-2" style="border-color: darkgray; border-top-width: thick;">
    	<div class="media mt-1 pb-3 pr-2">	
    	@php $user = \App\Models\User::where('name', '=', $post->authorName)->first(); @endphp
        @if (Auth::User())
            <a class="text-dark" href="{{url('/profile/'.$user->name)}}">
        @endif
            <img src="@if ($user->profile->avatar_status == 1) {{ $user->profile->avatar }} 
            @else {{ Gravatar::get($user->email) }} @endif" 
            alt="{{ $user->name }}" class="user2-avatar-nav mr-1">
        @if (Auth::User())</a>@endif
        
        <div class="media-body mt-0 pt-0">
        	<div class="font-weight-bold my-0 py-0 text-nowrap"> <a class="text-dark" href="{{url('/profile/'.$user->name)}}">{{ $user->name }}</a>  </div> 
       
			@if (count($user->roles) > 0) @foreach ($user->roles as $user_role)
     		@if ($user_role->name == 'Student')
            	@php $badgeClass = 'primary' @endphp
           	@elseif ($user_role->name == 'Admin' || $user_role->name == 'Moderator' )
            	@php $badgeClass = 'info' @endphp
            @elseif ($user_role->name == 'Mentor')
            	@php $badgeClass = 'success' @endphp
            @elseif ($user_role->name == 'Unverified')
            	@php $badgeClass = 'danger' @endphp
            @else
            	@php $badgeClass = 'default' @endphp
            @endif
        
        	<span class="small badge badge-{{$badgeClass}}">{{ $user_role->name }}</span> 		
       	 	@endforeach @endif   
       </div>
       </div>
       
    </td>
    <td class="content pt-3" style="border-color: darkgray; border-top-width: thick;">
        @if (!is_null($post->parent))
            <blockquote class="p-2 border" style="background-color: snow; border-color: #F7E0E8">
                <p>
                    <strong>
                        {{ trans('forum::general.response_to', ['item' => $post->parent->authorName]) }}
                        (<a href="{{ Forum::route('post.show', $post->parent) }}">{{ trans('forum::posts.view') }}</a>):
                        {{-- (<a href="{{ Forum::route('thread.show', $post->parent) }}">{{ trans('forum::posts.view') }}</a>): --}}
                    </strong>
                </p>
                <hr>
                {!! str_limit(Forum::render($post->parent->content)) !!}
            </blockquote>
        @endif

        @if ($post->trashed())
            <span class="label label-danger">{{ trans('forum::general.deleted') }}</span>
        @else
            {!! Forum::render($post->content) !!}
        @endif
    </td>
</tr>
<tr class="post-footer">
    <td style="border-top-width: initial;">
        @if (!$post->trashed())
            @can ('edit', $post)
                <a href="{{ Forum::route('post.edit', $post) }}">{{ trans('forum::general.edit') }}</a>
            @endcan
        @endif
    </td>
    <td class="text-muted" style="border-top-width: initial;">
        {{ trans('forum::general.posted') }} {{ $post->posted }}
        @if ($post->hasBeenUpdated())
            | {{ trans('forum::general.last_updated') }} {{ $post->updated }}
        @endif
        <span class="pull-right">
            {{-- <a href="{{ Forum::route('thread.show', $post) }}">#{{ $post->sequence }}</a> -  --}}
            @if (!$post->trashed())
                @can ('reply', $post->thread)
                   <a href="{{ Forum::route('post.create', $post) }}">{{ trans('forum::general.reply') }}</a>
                @endcan
            @endif
            @if (Request::fullUrl() != Forum::route('post.show', $post) && !$post->trashed())
                - <a href="{{ Forum::route('post.show', $post) }}">{{ trans('forum::posts.view') }}</a>
            @endif
            @if (isset($thread))
                @can ('deletePosts', $thread)
                    @if (!$post->isFirst)
                        <input type="checkbox" name="items[]" value="{{ $post->id }}">
                    @endif
                @endcan
            @endif
        </span>
    </td>
</tr>
