@extends ('forum::master', ['breadcrumb_other' => trans('forum::posts.view')])

@section ('content')
    <div id="post">
        <h4 class="font-weight-bold">{{ trans('forum::posts.view') }} ({{ $thread->title }})</h4>

        <a href="{{ Forum::route('thread.show', $thread) }}" class="btn text-info">&laquo; {{ trans('forum::threads.view') }}</a>

		<div class="table-responsive posts-table">
            <table class="table  data-table">
            <thead>
                <tr class="">
                    <th>
                        {{ trans('forum::general.author') }}
                    </th>
                    <th>
                        {{ trans_choice('forum::posts.post', 1) }}
                    </th>
                </tr>
            </thead>
            <tbody>
                @include ('forum::post.partials.list', compact('post'))
            </tbody>
        </table>
        </div>
    </div>
@stop
