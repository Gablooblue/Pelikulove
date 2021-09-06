<form action="{{ Forum::route('category.store') }}" method="POST">
    {!! csrf_field() !!}
	<input type="hidden" name="category_id" value="0">
    <div class="panel panel-default">
        <div class="panel-heading">
           
            <a class="btn btn-primary" data-toggle="collapse" href="#create-category" role="button" aria-expanded="false" aria-controls="create-category">
            <i class="fa fa-plus"></i> {{ trans('forum::categories.create') }}
            </a>
  			 
        </div>
        <div class="collapse" id="create-category">
            <div class="panel-body bg-light px-4 py-3">
                <div class="form-group">
                    <label for="title">{{ trans('forum::general.title') }}</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="description">{{ trans('forum::general.description') }}</label>
                    <input type="text" name="description" value="{{ old('description') }}" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="weight">{{ trans('forum::general.weight') }}</label>
                    <input type="number" id="weight" name="weight" value="{{ !empty(old('weight')) ? old('weight') : 0 }}" class="form-control">
                </div>
                <div class="form-group">
                    <label>
                        <input type="hidden" name="enable_threads" value="0">
                        <input type="checkbox" name="enable_threads" value="1" checked>
                        {{ trans('forum::categories.enable_threads') }}
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        <input type="hidden" name="private" value="0">
                        <input type="checkbox" name="private" value="1">
                        {{ trans('forum::categories.make_private') }}
                    </label>
                </div>
            </div>
            <div class="panel-footer bg-light px-4 clearfix">
                <button type="submit" class="btn btn-outline-primary pull-right">{{ trans('forum::general.create') }}</button>
            </div>
        </div>
    </div>
</form>
