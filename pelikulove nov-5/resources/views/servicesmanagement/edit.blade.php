@extends('layouts.app')

@section('template_title')
    Editing Service: {!! $service->name !!}
@endsection

@section('template_linked_css')
    <style type="text/css">
        .btn-save,
        .pw-change-container {
            display: none;
        }
    </style>
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            Editing Service: 
                            <br>
                            {!! $service->name !!}
                            <div class="pull-right">
                                <a href="{{ route('services') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="top" title="Back to Services">
                                    <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                                    <span class="hidden-sm hidden-xs">
                                        Back to 
                                    </span><span class="hidden-xs">
                                        Services
                                    </span>
                                </a>
                                <br>
                                <a href="{{ url('/services/' . $service->id) }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="Back to Service">
                                    <i class="fa fa-fw fa-reply" aria-hidden="true"></i>
                                        Back to 
                                    <span class="hidden-xs">
                                        Service
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="card-body">
                        {!! Form::open(array('route' => ['services.update', $service->id], 'method' => 'PUT', 'role' => 'form', 'class' => 'needs-validation')) !!}

                        {!! csrf_field() !!}

                        {{-- Course Name --}}
                        <div class="form-group has-feedback row {{ $errors->has('courseID') ? ' has-error ' : '' }}">
                            {!! Form::label('courseID', "Course: ", array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                    <select class="custom-select form-control" name="courseID" id="courseID">
                                        @if ($courses)
                                            @foreach($courses as $course)
                                                <option value="{{ $course->id }}" {{ $service->course_id == $course->id ? 'selected="selected"' : '' }}>{{ $course->title }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="courseID">
                                            <i class="fa fa-fw fa-book" aria-hidden="true"></i>
                                        </label>
                                    </div>
                                </div>
                                @if ($errors->has('courseID'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('courseID') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>    
                        
                        {{-- Service Name --}}
                        <div class="form-group has-feedback row {{ $errors->has('name') ? ' has-error ' : '' }}">
                            {!! Form::label('serviceName', 'Service Name:', array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                {!! Form::text('serviceName', $service->name, array('id' => 'serviceName', 'class' => 'form-control', 'placeholder' => 'Service Name', 'required')) !!}
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="serviceName">
                                            {{-- <i class="fa fa-fw {{ trans('forms.create_user_icon_password') }}" aria-hidden="true"></i> --}}
                                        </label>
                                    </div>
                                </div>
                                @if ($errors->has('serviceName'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('serviceName') }}</strong>
                                    </span>
                                @endif 
                            </div>
                        </div>
                            
                        {{-- Description --}}
                        <div class="form-group has-feedback row {{ $errors->has('description') ? ' has-error ' : '' }}">
                            {!! Form::label('description', 'Description:', array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                {!! Form::textarea('description', $service->description, array('id' => 'description', 'class' => 'form-control', 'placeholder' => 'About the service', 'required')) !!}
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
                        
                        
                        {{-- Amount --}}
                        <div class="form-group has-feedback row {{ $errors->has('amount') ? ' has-error ' : '' }}">
                            {!! Form::label('amount', 'Amount:', array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                    {!! Form::input('number', 'amount', $service->amount, array('id' => 'amount', 'class' => 'form-control', 'placeholder' => '1999', 'min' => '0.00', 'max' => '999999.99', 'step' => '.01', 'required')) !!}
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="amount">
                                            {{-- <i class="fa fa-fw {{ trans('forms.create_user_icon_password') }}" aria-hidden="true"></i> --}}
                                        </label>
                                    </div>
                                </div>
                                @if ($errors->has('amount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                @endif 
                            </div>
                        </div>                        
                        
                        {{-- Duration --}}
                        <div class="form-group has-feedback row {{ $errors->has('duration') ? ' has-error ' : '' }}">
                            {!! Form::label('duration', 'Duration in Days:', array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                {!! Form::text('duration', $service->duration, array('id' => 'duration', 'class' => 'form-control', 'placeholder' => '365', 'pattern' => '\d*', 'maxlength' => '5',  'required')) !!}
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="duration">
                                            {{-- <i class="fa fa-fw {{ trans('forms.create_user_icon_password') }}" aria-hidden="true"></i> --}}
                                        </label>
                                    </div>
                                </div>
                                @if ($errors->has('duration'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('duration') }}</strong>
                                    </span>
                                @endif 
                            </div>
                        </div>
                        

                        <div class="row">
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-9">
                                {!! Form::button(trans('forms.save-changes'), array('class' => 'btn btn-success btn-block margin-bottom-1 mt-3 mb-2 btn-save', 'data-toggle' => 'modal', 'data-target' => '#confirmSave', 'data-title' => trans('modals.edit_user__modal_text_confirm_title'), 'data-message' => trans('modals.edit_user__modal_text_confirm_message'))) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('modals.modal-save')
    @include('modals.modal-delete')

@endsection

@section('footer_scripts')
    @include('scripts.delete-modal-script')
    @include('scripts.save-modal-script')
    @include('scripts.check-changed')
    <script>        
        $('#description').change(function(event) {
            if(!$('#description').val()){
                $(".btn-save").hide();
            }
            else {
                $(".btn-save").show();
            }
        });
    </script>
@endsection
