@extends('layouts.app')

@section('template_title')
	Add New Blackbox Category
@endsection

@section('head')
@endsection

@section('content')
<div class="container">
        <div class="row">
		<div class="col-lg-10 offset-lg-1">
                <div class="card">
                    <div class="card-header">
                        <div class="div-title" style="display: flex; justify-content: space-between; align-items: center;">
                            Add New Blackbox Category
                            <div class="pull-right">
                                <a href="{{ url('blackbox-admin') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="Back to Payment Methods">
                                    <i class="fa fa-fw fa-reply" aria-hidden="true"></i>
                                    <span class="hidden-sm hidden-xs">Back to </span>
                                    <span class="hidden-xs">Blackbox Admin</span>
                                </a>
                            </div>
                        </div>

                        <hr>
                    </div>

                    {!! Form::text('formType', 'blackbox-admin-new-cat', array('id' => 'formType', 'class' => 'form-control', 'hidden')) !!}
                    
                    {!! Form::open(array('route' => 'vodsmanagement.storeCategory', 'method' => 'POST', 'new-cat' => 'form', 'class' => 'needs-validation')) !!}

                    {!! csrf_field() !!}

                    <div class="card-body div-payment-methods">		
                        <div class="form-group has-feedback row {{ $errors->has('name') ? ' has-error ' : '' }}">
                            {!! Form::label('name', 'Category Name:', array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                {!! Form::text('name', NULL, array('id' => 'name', 'class' => 'form-control', 'placeholder' => 'Category Name', 'required')) !!}
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="name">
                                            {{-- <i class="fa fa-fw {{ trans('forms.create_user_icon_password') }}" aria-hidden="true"></i> --}}
                                        </label>
                                    </div>
                                </div>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif 
                            </div>
                        </div>

                        <div class="form-group has-feedback row {{ $errors->has('description') ? ' has-error ' : '' }}">
                            {!! Form::label('description', 'Description:', array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                {!! Form::textarea('description', NULL, array('id' => 'description', 'class' => 'form-control', 'placeholder' => 'About the Category')) !!}
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="description">
                                            <i class="fa fa-fw fa-pencil" aria-hidden="true"></i>
                                        </label>
                                    </div>
                                </div>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif 
                            </div>
                        </div>   

                        <div class="form-group has-feedback row {{ $errors->has('hidden') ? ' has-error ' : '' }}">
                            {!! Form::label('hidden', 'Unlisted:', array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                {{-- <div class=""> --}}
                                    {!! Form::input('checkbox', 'hidden', NULL, array('id' => 'hidden', 'class' => 'form-control', 'style' => 'width: 20px; height: 100%;')) !!} 
                                {{-- </div> --}}
                                @if ($errors->has('hidden'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('hidden') }}</strong>
                                    </span>
                                @endif 
                            </div>
                        </div>                     

                        <div class="form-group has-feedback row {{ $errors->has('categoryOrder') ? ' has-error ' : '' }}">
                            {!! Form::label('categoryOrder', 'Category Order:', array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                    <select class="custom-select form-control" name="categoryOrder" id="categoryOrder">
                                        @if ($vodCategories)
                                            @foreach($vodCategories as $vodCategory)
                                                <option value="{{ $vodCategory->corder }}">{{ $vodCategory->corder }}</option>
                                            @endforeach
                                            <option value="{{ $vodCategory->corder+1 }}" selected="selected">{{ $vodCategory->corder+1 }}</option>
                                        @endif
                                    </select>
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="categoryOrder">
                                        </label>
                                    </div>
                                </div>
                                @if ($errors->has('categoryOrder'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('categoryOrder') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Submit button -->
                        <div class="row justify-content-end">                                
                            {!! Form::button('Submit', array('class' => 'btn btn-success btn-submit margin-bottom-1 mt-1 mb-1 mr-3', 'type' => 'submit')) !!}  
                        </div>
                    </div>
                    
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')
   
@endsection