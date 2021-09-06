{{-- $category is passed as NULL to the master layout view to prevent it from showing in the breadcrumbs --}}
@extends ('forum::master', ['category' => null])

@section ('content') 
    @can ('createCategories')
        @include ('forum::category.partials.form-create')
    @endcan

    <h5 class="font-weight-bold pt-3 pb-1">Home</h5>

    <!--{{ trans('forum::general.index') }}-->

	<div class="table-responsive posts-table">
            <table class="table  data-table">
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
    @foreach ($categories as $category)
    
       
           
                <tr class="category">
                    @include ('forum::category.partials.list', ['titleClass' => 'lead'])
                </tr>
                
          
       
    @endforeach
      </tbody>
    </table>
     </div>   
@stop