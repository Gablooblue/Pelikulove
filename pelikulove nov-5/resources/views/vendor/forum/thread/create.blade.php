@extends ('forum::master', ['breadcrumb_other' => trans('forum::threads.new_thread')])

@section ('content')
<div id="create-thread">
    <h4>{{ trans('forum::threads.new_thread') }} ({{ $category->title }})</h4>

    <form method="POST" action="{{ Forum::route('thread.store', $category) }}">
        {!! csrf_field() !!}
        {!! method_field('post') !!}

        <div class="form-group">
            <label for="title">{{ trans('forum::general.title') }}</label>
            <input type="text" name="title" value="{{ old('title') }}" class="form-control">
        </div>

        <div class="form-group">
            <textarea name="content" class="form-control">{{ old('content') }}</textarea>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-info pull-right">{{ trans('forum::general.create') }}</button>
            <a href="{{ URL::previous() }}"
                class="btn btn-link text-info pull-right">{{ trans('forum::general.cancel') }}</a>
        </div>


    </form>
</div>
@stop