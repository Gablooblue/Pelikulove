@extends('layouts.app')

@section('template_title')
	Create Service for {{ $vod->title }}
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
                            Create Service for {{ $vod->title }}
                            <div class="pull-right">
                                <a href="{{ url('blackbox-admin') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="Back to Blackbox Admin">
                                    <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                                    <span class="hidden-sm hidden-xs">Back to </span>
                                    <span class="hidden-xs">Blackbox Admin</span>
                                </a>
                                <br>
                                <a href="{{ url('/blackbox-admin/category/' . $vod->category_id) }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="Back to Category">
                                    <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                                    <span class="hidden-sm hidden-xs">Back to </span>
                                    <span class="hidden-xs">Category</span>
                                </a>
                                <br>
                                <a href="{{ url('blackbox-admin/category/' . $vod->category_id . '/vod/' . $vod->id . '/services') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="Back to Blackbox Admin">
                                    <i class="fa fa-fw fa-reply" aria-hidden="true"></i>
                                    <span class="hidden-sm hidden-xs">Back to </span>
                                    <span class="hidden-xs">Services</span>
                                </a>
                            </div>
                        </div>
                        <hr>
                    </div>


                    {!! Form::text('formType', 'blackbox-admin-new-cat', array('id' => 'formType', 'class' => 'form-control', 'hidden')) !!}
                    
                    {!! Form::open(array('route' => ['vodsmanagement.storeVodService', $vod->category_id, $vod->id], 'method' => 'POST', 'new-vod' => 'form', 'class' => 'needs-validation')) !!}

                    {!! csrf_field() !!}

                    <div class="card-body div-service">

                        <div class="form-group has-feedback row {{ $errors->has('name') ? ' has-error ' : '' }}">
                            {!! Form::label('serviceName', 'Service Name:', array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                {!! Form::text('serviceName', old('serviceName'), array('id' => 'serviceName', 'class' => 'form-control', 'placeholder' => 'Service Name', 'required')) !!}
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

                        <div class="form-group has-feedback row {{ $errors->has('description') ? ' has-error ' : '' }}">
                            {!! Form::label('description', 'Description:', array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                {!! Form::textarea('description', old('description'), array('id' => 'description', 'class' => 'form-control', 'placeholder' => 'About the service', 'required')) !!}
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
                                   
                        <div class="form-group has-feedback row {{ $errors->has('available') ? ' has-error ' : '' }}">
                            {!! Form::label('available', 'Availability:', array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                {{-- <div class=""> --}}
                                    {{-- @php $checkDonate = 'checked'; if($vodCategory->available != 1) $checkDonate = '' @endphp --}}
                                    {!! Form::input('checkbox', 'available', old('available'), array('id' => 'available', 'class' => 'form-control', 'style' => 'width: 20px; height: 100%;', 'checked')) !!} 
                                {{-- </div> --}}
                                @if ($errors->has('available'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('available') }}</strong>
                                    </span>
                                @endif 
                            </div>
                        </div> 
                        
                        <div class="form-group has-feedback row {{ $errors->has('amount') ? ' has-error ' : '' }}">
                            {!! Form::label('amount', 'Amount:', array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                    {!! Form::input('number', 'amount', NULL, array('id' => 'amount', 'class' => 'form-control', 'placeholder' => '1999', 'min' => '0.00', 'max' => '99999999.99', 'step' => '.01', 'required')) !!}
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

                        <div class="form-group has-feedback row {{ $errors->has('duration') ? ' has-error ' : '' }}">
                            {!! Form::label('duration', 'Duration:', array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                    {!! Form::input('number', 'duration', old('duration'), array('id' => 'duration', 'class' => 'form-control', 'placeholder' => '30', 'min' => '1', 'max' => '99999', 'step' => '1', 'required')) !!}
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

    {{-- @include('scripts/code-generator'); --}}
   
@endsection