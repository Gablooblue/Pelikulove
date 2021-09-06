<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a
                href="{{ url(config('forum.routing.prefix')) }}"><i class="fa fa-home"></i> {{ trans('forum::general.index') }}</a></li>

        @if (isset($category) && $category)
        
        @include ('forum::partials.breadcrumb-categories', ['category' => $category]) 
        <!--<li class="breadcrumb-item"><a href="{{ Forum::route('category.show', $category) }}">{{ $category->title }}</a></li>-->
        @endif


        @if (isset($thread) && $thread)
        <li class="breadcrumb-item"><a href="{{ Forum::route('thread.show', $thread) }}">{{ $thread->title }}</a></li>
        @endif

        @if (isset($breadcrumb_other) && $breadcrumb_other)
        <li class="breadcrumb-item active">{!! $breadcrumb_other !!}</li>
        @endif

    </ol>
</nav>