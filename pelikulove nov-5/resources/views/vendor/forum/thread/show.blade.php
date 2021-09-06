@extends ('forum::master')


@section ('content')
    <div id="thread">
        <h4 class="font-weight-bold">
            @if ($thread->trashed())
                <span class="label label-danger">{{ trans('forum::general.deleted') }}</span>
            @endif
            @if ($thread->locked)
                <span class="label label-warning">{{ trans('forum::threads.locked') }}</span>
            @endif
            @if ($thread->pinned)
                <span class="label label-info">{{ trans('forum::threads.pinned') }}</span>
            @endif
            {{ $thread->title }}
        </h4>

        {{-- <hr> --}}

        @can ('manageThreads', $category)
            <form action="{{ Forum::route('thread.update', $thread) }}" method="POST" data-actions-form>
                {!! csrf_field() !!}
                {!! method_field('patch') !!}

                @include ('forum::thread.partials.actions')
            </form>
        @endcan

        @can ('deletePosts', $thread)
            <form action="{{ Forum::route('bulk.post.update') }}" method="POST" data-actions-form>
                {!! csrf_field() !!}
                {!! method_field('delete') !!}
        @endcan

        {{-- <div class="row">
            <div class="ml-3 my-3 col-xs-4">
                @can ('reply', $thread)
                    <div class="btn-group my-2" role="group">
                        <a href="{{ Forum::route('post.create', $thread) }}" class="btn btn-info">{{ trans('forum::general.new_reply') }}</a>
                        <a href="#quick-reply" class="btn btn-outline-info">{{ trans('forum::general.quick_reply') }}</a>
                    </div>
                @endcan
            </div>
            <div class="col-xs-8 text-right">
                {!! $posts->render() !!}
            </div>
        </div> --}}

		<div class="table-responsive posts-table">
        <table class="table data-table {{ $thread->trashed() ? 'deleted' : '' }}">
            <thead>
                <tr>
                    <th class="pr-2">
                        {{ trans('forum::general.author') }}
                    </th>
                    <th>
                        {{ trans_choice('forum::posts.post', 1) }}
                        @can ('deletePosts', $thread)
                            <span class="pull-right">
                                <input type="checkbox" data-toggle-all>
                            </span>
                        @endcan
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    @include ('forum::post.partials.list', compact('post'))
                @endforeach
            </tbody>
        </table>
        </div>

        @can ('deletePosts', $thread)
                @include ('forum::thread.partials.post-actions')
            </form>
        @endcan

        {!! $posts->render() !!}

        @can ('reply', $thread)
            <h3>{{ trans('forum::general.quick_reply') }}</h3>
            <div id="quick-reply">
                <form id="reply_form" method="POST" action="{{ Forum::route('post.store', $thread) }}">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <textarea name="content" class="form-control" style="resize: vertical; height: 200px;">{{ old('content') }}</textarea>
                    </div>

                    <div class="text-right">                        
                        <button id="reply" type="submit" class="btn btn-info pull-right" disabled>
                            <i id="reply-spinner" class="fa fa-spinner fa-spin" style="display: none;"></i>
                            {{ trans('forum::general.reply') }}
                        </button>
                    </div>
                </form>
            </div>
        @endcan
    </div>
@stop

@section ('footer')
    <script>
        $('tr input[type=checkbox]').change(function () {
            var postRow = $(this).closest('tr').prev('tr');
            $(this).is(':checked') ? postRow.addClass('active') : postRow.removeClass('active');
        });
    </script>
@stop


@section('footer_scripts')

    <script type="text/javascript">        
        $(document).ready(function(){
            document.getElementById('reply').disabled=false;
            
            $("#reply").on('click', function(e){
                e.preventDefault();

                $("#reply-spinner").css("display", "inline-block");
                document.getElementById('reply').disabled=true;
                document.getElementById('reply_form').submit();
            });
        });
    </script>

@endsection
