@extends('layouts.app')

@section('template_title')
Upload Saluhan for {{$lesson->course->title}} - {{$lesson->title}} 
@endsection

@section('template_linked_css')
    <style type="text/css">
        .btn-save,
    </style>
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                          Saluhan for  {{$lesson->title}} 
                            <div class="pull-right">
                                <a href="{{ route('submissions.show', ['id' => $lesson->course_id]) }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="top" title="Back to Saluhan">
                                    <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                                    Back to Saluhan 
                                </a>
                                
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        {!! Form::open(array('route' => ['submission.store'], 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation', 'files' => true)) !!}
							{!! csrf_field() !!}
                            {{ Form::hidden('lesson_id', $lesson->id) }}
							<div class="form-group has-feedback row {{ $errors->has('title') ? ' has-error ' : '' }}">
                                {!! Form::label('title', 'Title', array('class' => 'col-md-3 control-label')) !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                		{!! Form::text('title', old('title'), array('class'=>'form-control')) !!}
                                    </div>
                                    @if($errors->has('title'))
                                        <span class="help-block small text-danger">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
							 
							<div class="form-group has-feedback row {{ $errors->has('description') ? ' has-error ' : '' }}">
                              
					       {!! Form::label('description', 'Description' , array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                    	  {!! Form::textarea('description', old('description') , [ 'rows' => 5, 'class' => 'form-control']) !!}
                                    </div>
                                    @if($errors->has('description'))
                                        <span class="help-block small text-danger">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                           <div class="form-group has-feedback row {{ $errors->has('file') ? ' has-error ' : '' }}">
                                {!! Form::label('file', 'Upload File', array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                 	 {!! Form::file('file', old('file'),  array('class'=>'form-control')) !!}
                                 	 <p>Max File Size: 5Mb. jpg, gif, png, doc and pdf files are allowed.</p>
                                 	 </div>
                                     @if($errors->has('file'))
                                        <span class="help-block small text-danger">
                                            <strong>{{ $errors->first('file') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            
                           
                            <div class="row">
                                
                                <div class="col-12 col-sm-6">
                                 {!! Form::button('Upload', array('class' => 'btn btn-success margin-bottom-1 mb-1 float-right','type' => 'submit' )) !!}
                     			</div>
                            </div>
                        {!! Form::close() !!}
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer_scripts')
  
@endsection
