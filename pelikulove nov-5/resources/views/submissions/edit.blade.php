@extends('layouts.app')

@section('template_title')
    Edit Submission
@endsection

@section('template_linked_css')
    {{-- <style type="text/css">
        .btn-save,
       
    </style> --}}
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            Edit Submission
                            <div class="pull-right">
                                <a href="{{ route('submissions.show', ['lesson_id' => $submission->lesson_id]) }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="top" title="Back to Saluhan">
                                    <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                                   Back to Saluhan
                                </a>
                                
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        {!! Form::open(array('route' => ['submission.update'], 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation', 'files' => true)) !!}

                            {!! csrf_field() !!}
					
							<input name="id" type="hidden" value="{{$submission->id}}">
							<input name="ofile" type="hidden" value="{{$submission->file}}">
                            <div class="form-group has-feedback row {{ $errors->has('title') ? ' has-error ' : '' }}">
                                {!! Form::label('title', 'Title', array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                	
                                      	<input type="text" name="title" class="form-control" value="{{$submission->title  ? $submission->title  :  old('title')}}">
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
                                    	 <textarea rows="5" class="form-control" name="description" cols="50" id="description">{{ $submission->description ? $submission->description  :  old('description')}}</textarea>
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
                                 	</div> 
                                 	<div>
                                 	<p>Max File Size: 5Mb. jpg, gif, png, doc and pdf files are allowed.</p>
                                 	<a href="#" data-toggle="modal" data-title="{{$submission->title}} by {{$submission->user->name}}" data-load-url="{{route('submission.view', ['uuid' => $submission->uuid])}}" data-target="#showModal" class="text-danger mb-2">
     							 	@if ($submission->file != ""  && strpos($submission->file, ".pdf") !== false)
     							 		<i class="fa fa-file-pdf-o"></i> 
     							 		@elseif  ($submission->file != ""  &&  ( strpos($submission->file, ".doc") !== false || strpos($submission->file, ".docx") !== false) )
     							 		<i class="fa fa-file"></i> 
     							 		@elseif  ($submission->file != ""  && strpos($submission->file, ".pdf") !== true)
     							 		<i class="fa fa-file-image-o"></i>
     							 		@endif
     							 		{{$submission->title}}
     							 		</a>
     							 	</div>	
                                     @if($errors->has('file'))
                                        <span class="help-block small text-danger">
                                            <strong>{{ $errors->first('file') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            @if ($lesson->course_id == 3)
                                <div class="form-group has-feedback row {{ $errors->has('private') ? ' has-error ' : '' }}">      
                                    {!! Form::label('private', 'Private Submission', array('class' => 'col-md-3 control-label', 
                                    'data-toggle' => 'tooltip', 'title' => 'A private submission is only visible to the readers and the mentor')); !!}
                                    <div class="col-md-9">
                                        <div class="input-group">     
                                            @php $checkprvt = 'checked'; if($submission->private == 0) $checkprvt = '' @endphp                                   
                                            {!! Form::input('checkbox', 'private', NULL, array('id' => 'private', 'style' => 'width: 20px; height: 20px;', '
                                            data-toggle' => 'tooltip', 'title' => 'A private submission is only visible to the readers and the mentor',
                                            $checkprvt)) !!}                                                   
                                        </div>
                                        @if($errors->has('private'))
                                            <span class="help-block small text-danger">
                                                <strong>{{ $errors->first('private') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>                                
                            @endif
						
                            <div class="row">
                                
                                 <div class="col-12 col-sm-6">
                                    {!! Form::button(trans('forms.save-changes'), array('class' => 'btn btn-success btn-block margin-bottom-1 mt-3 mb-2 btn-save','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmSave', 'data-title' => trans('modals.modal_text_confirm_title'), 'data-message' => trans('modals.modal_text_confirm_message'))) !!}
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>

                </div>
            </div>
        </div>
        <!-- Modals -->
    <div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="stitle" aria-hidden="true">
  		<div class="modal-dialog modal-lg" role="document">
    		<div class="modal-content">
      			<div class="modal-header">
      
            		<h4 class="modal-title" id="stitle"></h4>
                	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                
           		 </div>
           		 <div class="modal-body">
              	 	 <p>Loading...</p>
           		 </div>
          		 <div class="modal-footer">
              	 	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                
            	</div>
    		</div>
    	</div>
	</div>
    </div>

    @include('modals.modal-save')
    @include('modals.modal-delete')

@endsection

@section('footer_scripts')
  @include('scripts.save-modal-script')
  @include('scripts.show-file')
  @include('scripts.tooltips')
@endsection
