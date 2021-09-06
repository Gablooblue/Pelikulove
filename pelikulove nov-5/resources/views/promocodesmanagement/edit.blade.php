@extends('layouts.app')

@section('template_title')
    Edit Code Page
@endsection

@section('head')
@endsection

@section('content')
<div class="container">
        <div class="row">
		<div class="col-lg-10 offset-lg-1">
                <div class="card">
                    <div class="card-header">
                        @if(!empty($success))
                            <div class="alert alert-success alert-dismissible">
                                <h1>{{Session::get('success')}}</h1>
                            </div>
                        @endif

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            Editing Promocode: {{ $code->code }}
                            <div class="pull-right">
                                <a href="{{ route('promo-codes') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="Back to Promocodes">
                                    <i class="fa fa-fw fa-reply" aria-hidden="true"></i>
                                    <span class="hidden-sm hidden-xs">Back to </span>
                                    <span class="hidden-xs">Promocodes</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">	
                        {{-- Time Promo Code Div Start --}}
                        <div class="time-promo-code-div">
                            {!! Form::open(array('route' => ['promocodes.updatePromoCode', $code->id], 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}
    
                                {!! csrf_field() !!}
    
                                <div class="form-group has-feedback row {{ $errors->has('code') ? ' has-error ' : '' }}">
                                    {!! Form::label('code', 'Promo Code', array('class' => 'col-md-3 control-label')); !!}
                                    <div class="col-md-9">
                                        <div class="input-group">
                                        {!! Form::text('code', $code->code, array('id' => 'code', 'class' => 'form-control', 'placeholder' => 'Unique Promo Code', 'readonly')) !!}
                                            <div class="input-group-append">
                                                <label class="input-group-text" for="code">
                                                    <i class="{{ trans('forms.create_user_icon_role') }}" aria-hidden="true"></i>
                                                </label>
                                            </div>
                                        </div>
                                        @if ($errors->has('code'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('code') }}</strong>
                                            </span>
                                        @endif 
                                    </div>
                                </div>
                                	
                                <div class="form-group has-feedback row">
                                    {!! Form::label('course_id', 'Course', array('class' => 'col-md-3 control-label')); !!}
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <select class="custom-select form-control" name="course_id" id="course_id" readonly>
                                                    <option value="{{ $code->course_id }}">{{ $code->course_title }}</option>  
                                            </select>
                                            <div class="input-group-append">
                                                <label class="input-group-text" for="course_id">
                                                    <i class="{{ trans('forms.create_user_icon_role') }}" aria-hidden="true"></i>
                                                </label>
                                            </div>
                                        </div>
                                        @if ($errors->has('course_id'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('course_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                	
                                <div class="form-group has-feedback row">
                                    {!! Form::label('service_id', 'Service', array('class' => 'col-md-3 control-label')); !!}
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <select class="custom-select form-control" name="service_id" id="service_id" readonly>  
                                                <option value="{{ $code->service_id }}">{{ $code->service_name }}</option>  
                                            </select>
                                            <div class="input-group-append">
                                                <label class="input-group-text" for="service_id">
                                                    <i class="{{ trans('forms.create_user_icon_role') }}" aria-hidden="true"></i>
                                                </label>
                                            </div>
                                        </div>
                                        @if ($errors->has('service_id'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('service_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                                        
                                <div class="form-group has-feedback row {{ $errors->has('amount') ? ' has-error ' : '' }}">
                                    {!! Form::label('amount', 'Amount:', array('class' => 'col-md-3 control-label')); !!}
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            {!! Form::input('number', 'amount', $code->amount, array('id' => 'amount', 'class' => 'form-control', 'placeholder' => '999.00', 'min' => '0.00', 'max' => '99999999.99', 'step' => '.01', 'required', 'readonly')) !!}
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
                        
                                <div class="form-group has-feedback row {{ $errors->has('start_date') ? ' has-error ' : '' }}">
                                    {!! Form::label('start_date', 'Start Date:', array('class' => 'col-md-3 control-label')); !!}
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            {!! Form::input('date', 'start_date', $code->start_date, array('id' => 'start_date', 'class' => 'form-control', 'required', 'readonly')) !!}
                                            <div class="input-group-append">
                                                <label class="input-group-text" for="start_date">
                                                </label>
                                            </div>
                                        </div>
                                        @if ($errors->has('start_date'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('start_date') }}</strong>
                                            </span>
                                        @endif 
                                    </div>
                                </div>
                        
                                <div class="form-group has-feedback row {{ $errors->has('end_date') ? ' has-error ' : '' }}">
                                    {!! Form::label('end_date', 'End Date:', array('class' => 'col-md-3 control-label')); !!}
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            {!! Form::input('date', 'end_date', $code->end_date, array('id' => 'end_date', 'class' => 'form-control', 'required')) !!}
                                            <div class="input-group-append">
                                                <label class="input-group-text" for="end_date">
                                                </label>
                                            </div>
                                        </div>
                                        @if ($errors->has('end_date'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('end_date') }}</strong>
                                            </span>
                                        @endif 
                                    </div>
                                </div>
                                
                                <!-- Submit button -->
                                <div class="row justify-content-end">                                
                                    {!! Form::button('Submit', array('class' => 'btn btn-success btn-submit margin-bottom-1 mt-1 mb-1 mr-3','type' => 'submit' )) !!}  
                                </div>
                            {!! Form::close() !!}
                        </div>
                        {{-- Time Promo Code Div End --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')
   
@endsection