@extends('layouts.app')

@section('template_title')
	Create Course Page
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
                            Create New Course
                            <div class="pull-right">
                                <a href="{{ route('courses-admin') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="Back to Services">
                                    <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                                    <span class="hidden-sm hidden-xs">Back to </span>
                                    <span class="hidden-xs">Courses</span>
                                </a>
                            </div>
                        </div>
                        <hr>
                    </div>

                    {!! Form::text('formType', 'service', array('id' => 'formType', 'class' => 'form-control', 'hidden')) !!}
                    
                    {!! Form::open(array('route' => 'courses-admin.store', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}

                    {!! csrf_field() !!}

                    <div class="card-body div-service">	
                        
                        <h3>
                            Carousel Slides
                        </h3>
                        <div class="card-body">
                            <div class="form-group has-feedback row {{ $errors->has('carouselSlide') ? ' has-error ' : '' }}">
                                {!! Form::label('carouselSlide', 'Carousel Slide:', array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                    {!! Form::text('carouselSlide', NULL, array('id' => 'carouselSlide', 'class' => 'form-control', 'placeholder' => 'Course Name', 'required')) !!}
                                        <div class="input-group-append">
                                            <label class="input-group-text" for="carouselSlide">
                                                {{-- <i class="fa fa-fw {{ trans('forms.create_user_icon_password') }}" aria-hidden="true"></i> --}}
                                            </label>
                                        </div>
                                    </div>
                                    @if ($errors->has('carouselSlide'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('carouselSlide') }}</strong>
                                        </span>
                                    @endif 
                                </div>
                            </div>
                        </div>


                        <hr>  

                        <h3>
                            Course Description
                        </h3>					
                        <div class="card-body">
                            <div class="form-group has-feedback row">
                                {!! Form::label('isntructorID', 'Instructor:', array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="custom-select form-control" name="isntructorID" id="isntructorID"> 
                                            @if ($instructors)
                                                @foreach($instructors as $instructor)
                                                    <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <div class="input-group-append">
                                            <label class="input-group-text" for="isntructorID">
                                                <i class="fa fa-fw fa-book" aria-hidden="true"></i>
                                            </label>
                                        </div>
                                    </div>
                                    @if ($errors->has('isntructorID'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('isntructorID') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
    
                            <div class="form-group has-feedback row {{ $errors->has('courseName') ? ' has-error ' : '' }}">
                                {!! Form::label('courseName', 'Course Name:', array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                    {!! Form::text('courseName', NULL, array('id' => 'courseName', 'class' => 'form-control', 'placeholder' => 'Course Name', 'required')) !!}
                                        <div class="input-group-append">
                                            <label class="input-group-text" for="courseName">
                                                {{-- <i class="fa fa-fw {{ trans('forms.create_user_icon_password') }}" aria-hidden="true"></i> --}}
                                            </label>
                                        </div>
                                    </div>
                                    @if ($errors->has('courseName'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('courseName') }}</strong>
                                        </span>
                                    @endif 
                                </div>
                            </div>
    
                            <div class="form-group has-feedback row {{ $errors->has('description') ? ' has-error ' : '' }}">
                                {!! Form::label('description', 'Description:', array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                    {!! Form::textarea('description', NULL, array('id' => 'description', 'class' => 'form-control', 'placeholder' => 'About the service', 'required')) !!}
                                        <div class="input-group-append">
                                            <label class="input-group-text" for="description">
                                                {{-- <i class="fa fa-fw {{ trans('forms.create_user_icon_password') }}" aria-hidden="true"></i> --}}
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
    
                            <div class="form-group has-feedback row {{ $errors->has('information') ? ' has-error ' : '' }}">
                                {!! Form::label('information', 'Information:', array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                    {!! Form::textarea('information', NULL, array('id' => 'information', 'class' => 'form-control', 'placeholder' => 'About the service', 'required')) !!}
                                        <div class="input-group-append">
                                            <label class="input-group-text" for="information">
                                                {{-- <i class="fa fa-fw {{ trans('forms.create_user_icon_password') }}" aria-hidden="true"></i> --}}
                                            </label>
                                        </div>
                                    </div>
                                    @if ($errors->has('information'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('information') }}</strong>
                                        </span>
                                    @endif 
                                </div>
                            </div>
    
                            <div class="form-group has-feedback row {{ $errors->has('thumbnail') ? ' has-error ' : '' }}">
                                {!! Form::label('thumbnail', 'Thumbnail:', array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                    {!! Form::textarea('thumbnail', NULL, array('id' => 'thumbnail', 'class' => 'form-control', 'placeholder' => 'About the service', 'required')) !!}
                                        <div class="input-group-append">
                                            <label class="input-group-text" for="thumbnail">
                                                {{-- <i class="fa fa-fw {{ trans('forms.create_user_icon_password') }}" aria-hidden="true"></i> --}}
                                            </label>
                                        </div>
                                    </div>
                                    @if ($errors->has('thumbnail'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('thumbnail') }}</strong>
                                        </span>
                                    @endif 
                                </div>
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