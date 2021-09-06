{{-- $thread is passed as NULL to the master layout view to prevent it from showing in the breadcrumbs --}}
@extends ('forum::master', ['thread' => null])

@section ('content')
    <div id="category">
        @can ('createCategories')
            @include ('forum::category.partials.form-create')
        @endcan

        <h4 class="pt-3">{{ $category->title }}</h4>
		@if ($category->description)
        <h4><span class="small">{{ $category->description }}</span></h4>
            @endif
        <hr>

        @can ('manageCategories')
            <form action="{{ Forum::route('category.update', $category) }}" method="POST" data-actions-form>
                {!! csrf_field() !!}
                {!! method_field('patch') !!}

                @include ('forum::category.partials.actions')
            </form>
        @endcan

        @if (!$category->children->isEmpty())
        <div class="table-responsive posts-table">
            <table class="table data-table table-category pt-4">
                <thead>
                    <tr>
                        <th>{{ trans_choice('forum::categories.category', 1) }}</th>
                        <th>{{ trans_choice('forum::threads.thread', 2) }}</th>
                        <th>{{ trans_choice('forum::posts.post', 2) }}</th>
                        <th>{{ trans('forum::threads.newest') }}</th>
                        <th>{{ trans('forum::posts.last') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($category->children as $subcategory)
                        @include ('forum::category.partials.list', ['category' => $subcategory])
                    @endforeach
                </tbody>
            </table>
        </div>    
        @endif

        <div class="row px-3">
            <div class="col-xs-4 pb-2">
                @if ($category->threadsEnabled)
                    @can ('createThreads', $category)
                        <a href="{{ Forum::route('thread.create', $category) }}" class="btn btn-primary">{{ trans('forum::threads.new_thread') }}</a>
                    @endcan
                @endif
            </div>
            <div class="col-xs-8 text-right">
                {!! $threads->render() !!}
            </div>
        </div>

        @can ('manageThreads', $category)
            <form action="{{ Forum::route('bulk.thread.update') }}" method="POST" data-actions-form class="mb-2 mt-2">
                {!! csrf_field() !!}
                {!! method_field('delete') !!}
        @endcan

        @if ($category->threadsEnabled)
         <div class="table-responsive posts-table">
            <table class="table data-table table-thread">
                <thead>
                    <tr>
                        <th>{{ trans('forum::general.subject') }}</th>
                        <th class="text-right">{{ trans('forum::general.replies') }}</th>
                        <th class="text-right">{{ trans('forum::posts.last') }}</th>
                        @can ('manageThreads', $category)
                            <th class="text-right"><input type="checkbox" data-toggle-all></th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @if (!$threads->isEmpty())
                        @foreach ($threads as $thread)
                            <tr class="{{ $thread->trashed() ? "deleted" : "" }}">
                                <td class="" style="border-color: lightgrey; border-top-width: medium;">
                                    
                                    <h5><a href="{{ Forum::route('thread.show', $thread) }}">{{ $thread->title }}</a></h5>
                                    @php $user = \App\Models\User::where('name', '=', $thread->authorName)->first(); @endphp
                                        <span class=""></span>
                                      	<span class="">By {{ $thread->authorName }} </span>
                                      	<span class="text-muted">({{ $thread->posted }})</span>
                                    
                                        @if ($thread->locked)
                                            <span class="badge badge-warning">{{ trans('forum::threads.locked') }}</span>
                                        @endif
                                        @if ($thread->pinned)
                                            <span class="badge badge-info">{{ trans('forum::threads.pinned') }}</span>
                                        @endif
                                        @if ($thread->userReadStatus && !$thread->trashed())
                                            <span class="badge badge-primary">{{ trans($thread->userReadStatus) }}</span>
                                        @endif
                                        @if ($thread->trashed())
                                            <span class="badge badge-danger">{{ trans('forum::general.deleted') }}</span>
                                        @endif
                                    
                                  
                                </td>
                                @if ($thread->trashed())
                                    <td colspan="2" style="border-color: lightgrey; border-top-width: medium;">&nbsp;</td>
                                @else
                                    <td class="text-right" style="border-color: lightgrey; border-top-width: medium;">
                                        {{ $thread->reply_count }}
                                    </td>
                                    <td class="text-right" style="border-color: lightgrey; border-top-width: medium;">
                                        {{ $thread->lastPost->authorName }}
                                        <p class="text-muted">({{ $thread->lastPost->posted }})</p>
                                        <a href="{{ Forum::route('thread.show', $thread->lastPost) }} text-nowrap" class="btn btn-primary btn-sm">{{ trans('forum::posts.view') }} &raquo;</a>
                                    </td>
                                @endif
                                @can ('manageThreads', $category)
                                    <td class="text-right" style="border-color: lightgrey; border-top-width: medium;">
                                        <input type="checkbox" name="items[]" value="{{ $thread->id }}">
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>
                                {{ trans('forum::threads.none_found') }}
                            </td>
                            <td class="text-right" colspan="3">
                                @can ('createThreads', $category)
                                    <a href="{{ Forum::route('thread.create', $category) }}">{{ trans('forum::threads.post_the_first') }}</a>
                                @endcan
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>    
        @endif

        @can ('manageThreads', $category)
                @include ('forum::category.partials.thread-actions')
            </form>
        @endcan

        <div class="row px-3">
            <div class="col-xs-4">
                @if ($category->threadsEnabled)
                    @can ('createThreads', $category)
                        <a href="{{ Forum::route('thread.create', $category) }}" class="btn btn-primary">{{ trans('forum::threads.new_thread') }}</a>
                    @endcan
                @endif
            </div>
            <div class="col-xs-8 text-right">
                {!! $threads->render() !!}
            </div>
        </div>

        @if ($category->threadsEnabled)
            @can ('markNewThreadsAsRead')
                <hr>
                <div class="text-center">
                    <form action="{{ Forum::route('mark-new') }}" method="POST" data-confirm>
                        {!! csrf_field() !!}
                        {!! method_field('patch') !!}
                        <input type="hidden" name="category_id" value="{{ $category->id }}">
                        <button class="btn btn-default btn-small">{{ trans('forum::categories.mark_read') }}</button>
                    </form>
                </div>
            @endcan
        @endif
    </div>
@stop
