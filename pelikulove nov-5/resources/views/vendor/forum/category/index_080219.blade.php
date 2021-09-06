{{-- $category is passed as NULL to the master layout view to prevent it from showing in the breadcrumbs --}}
@extends ('forum::master', ['category' => null])

@section ('content')
    @can ('createCategories')
        @include ('forum::category.partials.form-create')
    @endcan

    <h4 class="pt-3">{{ trans('forum::general.index') }}</h4>
	<table class="table table-index table-responsive">
    @foreach ($categories as $category)
       
            <thead class="bg-info text-white">
                <tr>
                    <th class="col-md-4">{{ trans_choice('forum::categories.category', 1) }}</th>
                    <th class="col-md-1">{{ trans_choice('forum::threads.thread', 2) }}</th>
                    <th class="col-md-1">{{ trans_choice('forum::posts.post', 2) }}</th>
                    <th class="col-md-3">{{ trans('forum::threads.newest') }}</th>
                    <th class="col-md-3">{{ trans('forum::posts.last') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr class="category">
                    @include ('forum::category.partials.list', ['titleClass' => 'lead'])
                </tr>
                @if (!$category->children->isEmpty())
                     <tr class="">
                        <th colspan="5">{{ trans('forum::categories.subcategories') }}</th>
                    </tr>
                    @foreach ($category->children as $subcategory)
                        @include ('forum::category.partials.list', ['category' => $subcategory])
                    @endforeach
                @endif
            </tbody>
        
    @endforeach
    </table>
@stop
