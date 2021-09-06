@extends('layouts.app')

@section('template_title')
	Create Code Page
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
                            Create New Code
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
                        <div class="form-group has-feedback row">
                            {!! Form::label('code_type', 'Code Type', array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                    <select class="custom-select form-control" name="code_type" id="code_type">
                                        <option value="buy1gift1">Buy 1 Gift 1</option>
                                        <option value="timepromocode">Course Promocode</option>
                                        <option value="timevodcode" selected>Vod Time Codes (VTC)</option>
                                    </select>
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="code_type">
                                            <i class="{{ trans('forms.create_user_icon_role') }}" aria-hidden="true"></i>
                                        </label>
                                    </div>
                                </div>
                                @if ($errors->has('code_type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('code_type') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Gift Code Div Start --}}
                        <div class="gift-code-div">
                            {!! Form::open(array('route' => 'promocodes.storeGift', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}
    
                                {!! csrf_field() !!}
    
                                <div class="form-group has-feedback row {{ $errors->has('email') ? ' has-error ' : '' }}">
                                    {!! Form::label('email', trans('forms.create_user_label_email'), array('class' => 'col-md-3 control-label')); !!}
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            {!! Form::text('email', NULL, array('id' => 'email', 'class' => 'form-control', 'placeholder' => trans('forms.create_user_ph_email'), 'required')) !!}
                                            <div class="input-group-append">
                                                <label for="email" class="input-group-text">
                                                    <i class="fa fa-fw {{ trans('forms.create_user_icon_email') }}" aria-hidden="true"></i>
                                                </label>
                                            </div>
                                        </div>
                                         @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
    
                                <div class="form-group has-feedback row {{ $errors->has('code1') ? ' has-error ' : '' }}">
                                    {!! Form::label('code1', 'Code 1', array('class' => 'col-md-3 control-label')); !!}
                                    <div class="col-md-9">
                                        <div class="input-group">
                                        {!! Form::text('code1', NULL, array('id' => 'code1', 'class' => 'form-control', 'placeholder' => 'Unique Code 1', 'readonly')) !!}
                                            <div class="input-group-append">
                                                <label class="input-group-text" for="code1">
                                                    <i class="fa fa-fw {{ trans('forms.create_user_icon_password') }}" aria-hidden="true"></i>
                                                </label>
                                            </div>
                                        </div>
                                        @if ($errors->has('code1'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('code1') }}</strong>
                                            </span>
                                        @endif 
                                    </div>
                                </div>                                
    
                                <div class="form-group has-feedback row {{ $errors->has('code2') ? ' has-error ' : '' }}">
                                    {!! Form::label('code2', 'Code 2', array('class' => 'col-md-3 control-label')); !!}
                                    <div class="col-md-9">
                                        <div class="input-group">
                                        {!! Form::text('code2', NULL, array('id' => 'code2', 'class' => 'form-control', 'placeholder' => 'Unique Code 2', 'readonly')) !!}
                                            <div class="input-group-append">
                                                <label class="input-group-text" for="code2">
                                                    <i class="fa fa-fw {{ trans('forms.create_user_icon_password') }}" aria-hidden="true"></i>
                                                </label>
                                            </div>
                                        </div>
                                        @if ($errors->has('code2'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('code2') }}</strong>
                                            </span>
                                        @endif 
                                    </div>
                                </div>
                                 
                                <!-- Code Generator Button with JS -->
                                <div class="row justify-content-end">
                                    {!! Form::button('Generate Code', array('class' => 'btn btn-primary btn-gen-code margin-bottom-1 mt-1 mb-1 mr-3', 'id' => 'btn-gen-code')) !!}                                                           
                                </div>
                                
                                <!-- Submit button -->
                                <div class="row justify-content-end">                                
                                    {!! Form::button('Send Email', array('class' => 'btn btn-success btn-submit margin-bottom-1 mt-1 mb-1 mr-3','type' => 'submit' )) !!}  
                                </div>
                            {!! Form::close() !!}
                        </div>
                        {{-- Gift Code Div End --}}                        

                        {{-- ########################################################################################################################################## --}}
                        {{-- ########################################################################################################################################## --}}
                        {{-- ########################################################################################################################################## --}}

                        {{-- Time Promo Code Div Start --}}
                        <div class="time-promo-code-div">
                            {!! Form::open(array('route' => 'promocodes.storeTimePromo', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}
    
                                {!! csrf_field() !!}
    
                                <div class="form-group has-feedback row {{ $errors->has('code') ? ' has-error ' : '' }}">
                                    {!! Form::label('code', 'Promo Code', array('class' => 'col-md-3 control-label')); !!}
                                    <div class="col-md-9">
                                        <div class="input-group">
                                        {!! Form::text('code', NULL, array('id' => 'code', 'class' => 'form-control', 'placeholder' => 'Unique Promo Code')) !!}
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
                                            <select class="custom-select form-control" name="course_id" id="course_id">
                                                @foreach ($courses as $course)
                                                    <option value="{{ $course->id }}">{{ $course->title }}</option>   
                                                @endforeach                                             
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
                                            <select class="custom-select form-control" name="service_id" id="service_id">                                      
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
                                            {!! Form::input('number', 'amount', NULL, array('id' => 'amount', 'class' => 'form-control', 'placeholder' => '999.00', 'min' => '0.00', 'max' => '99999999.99', 'step' => '.01', 'required')) !!}
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
                                            {!! Form::input('date', 'start_date', NULL, array('id' => 'start_date', 'class' => 'form-control', 'required')) !!}
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
                                            {!! Form::input('date', 'end_date', NULL, array('id' => 'end_date', 'class' => 'form-control', 'required')) !!}
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

                        {{-- ########################################################################################################################################## --}}
                        {{-- ########################################################################################################################################## --}}
                        {{-- ########################################################################################################################################## --}}

                        {{-- Time Limited Vod Code Div Start --}}
                        {{-- Create VTC Start --}}
                        <div class="time-vod-div">
                            {!! Form::open(array('route' => 'promocodes.storeTimeVod', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}
    
                                {!! csrf_field() !!} 
    
                                <div class="form-group has-feedback row {{ $errors->has('code') ? ' has-error ' : '' }}">
                                    {!! Form::label('code', 'Vod Time Code', array('class' => 'col-md-3 control-label')); !!}
                                    <div class="col-md-9">
                                        <div class="input-group">
                                        {!! Form::text('code', NULL, array('id' => 'code', 'class' => 'form-control', 'placeholder' => 'Unique Code')) !!}
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
                                    {!! Form::label('vod_id', 'Vod', array('class' => 'col-md-3 control-label')); !!}
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <select class="custom-select form-control" name="vod_id" id="vod_id">
                                                @foreach ($vods as $vod)
                                                    <option value="{{ $vod->id }}">{{ $vod->title }}</option>   
                                                @endforeach                                     
                                            </select>
                                            <div class="input-group-append">
                                                <label class="input-group-text" for="vod_id">
                                                    <i class="{{ trans('forms.create_user_icon_role') }}" aria-hidden="true"></i>
                                                </label>
                                            </div>
                                        </div>
                                        @if ($errors->has('vod_id'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('vod_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                        
                                <div class="form-group has-feedback row {{ $errors->has('start_date') ? ' has-error ' : '' }}">
                                    {!! Form::label('start_date', 'Start Date:', array('class' => 'col-md-3 control-label')); !!}
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            {!! Form::input('datetime-local', 'start_date', NULL, array('id' => 'start_date', 'class' => 'form-control', 'required')) !!}
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
                                            {!! Form::input('datetime-local', 'end_date', NULL, array('id' => 'end_date', 'class' => 'form-control', 'required')) !!}
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
                        {{-- Create VTC End --}}

                        {{-- Send VTC Start --}}
                        <div class="time-vod-div">
                            <hr>
                            <div class="card-header p-0 mb-3">    
                                <div class="">
                                    Send VTC to Emails
                                </div>
                            </div>
                        </div>

                        <div class="time-vod-div">
                            {!! Form::open(array('route' => 'promocodes.sendTimeVod', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}
    
                                {!! csrf_field() !!}                                   
                                <div class="form-group has-feedback row">
                                    {!! Form::label('vtc_id', 'Vod Time Code', array('class' => 'col-md-3 control-label')); !!}
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <select class="custom-select form-control" name="vtc_id" id="vtc_id">
                                                @foreach ($vtc as $vtc)
                                                    <option value="{{ $vtc->id }}">{{ $vtc->code }}</option>   
                                                @endforeach                                     
                                            </select>
                                            <div class="input-group-append">
                                                <label class="input-group-text" for="vtc_id">
                                                    <i class="{{ trans('forms.create_user_icon_role') }}" aria-hidden="true"></i>
                                                </label>
                                            </div>
                                        </div>
                                        @if ($errors->has('vtc_id'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('vtc_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group has-feedback row {{ $errors->has('emails') ? ' has-error ' : '' }}">
                                    {!! Form::label('emails', 'Emails:', array('class' => 'col-md-3 control-label')); !!}
                                    <div class="col-md-9">
                                        <div class="input-group">
                                        {!! Form::textarea('emails', NULL, array('id' => 'emails', 'class' => 'form-control', 'placeholder' => 'email@email.com, 2ndemail@2nd.net, valid@email.this', 'required')) !!}
                                            <div class="input-group-append">
                                                <label class="input-group-text" for="emails">
                                                    {{-- <i class="fa fa-fw {{ trans('forms.create_user_icon_password') }}" aria-hidden="true"></i> --}}
                                                </label>
                                            </div>
                                        </div>
                                        @if ($errors->has('emails'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('emails') }}</strong>
                                            </span>
                                        @endif 
                                    </div>
                                </div>
                                 
                                <!-- Check Email Btn with JS -->
                                <div class="row justify-content-end">      
                                    <div class="col-9" style='width: 90%;'>                                                    
                                        {!! Form::button('Check Emails', array('class' => 'btn btn-primary btn-block btn-check-email mb-1 mr-3', 'id' => 'btn-check-email')) !!}
                                    </div>                                   
                                </div>

                                <div class="form-group has-feedback row {{ $errors->has('email-log') ? ' has-error ' : '' }}">
                                    {!! Form::label('email-log', 'Email Logs:', array('class' => 'col-md-3 control-label')); !!}
                                    <div class="col-md-9">
                                        <div class="input-group">
                                        {!! Form::textarea('email-log', NULL, array('id' => 'email-log', 'class' => 'form-control', 'placeholder' => 'Additional Info will be displayed here.', 'required')) !!}
                                            <div class="input-group-append">
                                                <label class="input-group-text" for="email-log">
                                                    {{-- <i class="fa fa-fw {{ trans('forms.create_user_icon_password') }}" aria-hidden="true"></i> --}}
                                                </label>
                                            </div>
                                        </div>
                                        @if ($errors->has('email-log'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email-log') }}</strong>
                                            </span>
                                        @endif 
                                    </div>
                                </div>
                                
                                <!-- Submit button -->
                                <div class="row justify-content-end">                                
                                    {!! Form::button('Send Email', array('id' => 'btn-vtc-submit', 'class' => 'btn btn-success btn-submit margin-bottom-1 mt-1 mb-1 mr-3', 'type' => 'submit' )) !!}  
                                </div>
                            {!! Form::close() !!}
                        </div>
                        {{-- Send VTC End --}}
                        {{-- Time Limited Vod Code Div End --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_scripts')

    {{-- @include('scripts/code-generator'); --}}

<script>
    
    $(document).ready(function() {
        $('#btn-gen-code').click(function(e){        
        //GET METHOD
            // $.get('/promo-codes/code-gen', function (data) {
            //     document.getElementById('code1').value = data.code1;
            //     document.getElementById('code2').value = data.code2;
            // });

        //POST METHOD
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var codeType = document.getElementById('code_type').value;
            $.ajax({
                url:"/promo-codes/code-gen", 
                type: "POST", 
                dataType: 'JSON',
                data: {_token: CSRF_TOKEN, codeType: codeType},
                success:function(data){
                    document.getElementById('code1').value = data.code1;
                    document.getElementById('code2').value = data.code2;
                },
                error:function(data) { 
                    console.log("Error on ajax");
                    console.log(data.error);
                    console.log(data);
                }
            });
        });

        
        $('#btn-check-email').click(function(e){  
            var emailDiv = document.getElementById('emails');
            var values = emailDiv.value;
            var noSpaceValues = values.replace(/\s/g,'');
            var valuesSplit = noSpaceValues.split(",");
            
            var invalidEmailsIndex = [];
            var newValue = "";
            var totalDupes = 0;
            
            var valuesSoFar = Object.create(null);
            // console.log(valuesSoFar);
            for (var i = 0; i < valuesSplit.length; ++i) {
                var valueTmp = valuesSplit[i];
                if (valueTmp in valuesSoFar) {
                    totalDupes++;
                }
                valuesSoFar[valueTmp] = true;
            }

            var log = valuesSplit.length + " total email(s).\nWith " + totalDupes + " duplicate entries\n\n";

            var errors = "";
            var duplicates = "";
            var valuesSoFar2 = [];
            var index;
            for (index=0; index < valuesSplit.length; index++) {
                email = valuesSplit[index];
                // console.log("uwu");
                
                var valueTmp = valuesSplit[index];
                if (valuesSoFar2.includes(valueTmp)) {
                    duplicates += "Duplicate in row " + (index+1) + ": '" + email + "'\n";
                }
                valuesSoFar2.push(valueTmp);

                if (email.includes("@")) {                    
                    emailSplit = email.split("@");
                    if (emailSplit.length <= 2) {                        
                        if (emailSplit[1].includes(".")) {     
                            if (emailSplit[1].length >= 3) {
                                var emailSplit2 = emailSplit[1].split(".");
                                if (emailSplit2[0].length < 1 || emailSplit2[emailSplit2.length-1].length < 1 ) {
                                    invalidEmailsIndex.push(index.toString());
                                    errors += "Email too short in row  " + (index+1) + ": '" + email + "'\n";
                                }
                            } else {
                                invalidEmailsIndex.push(index.toString());
                                errors += "Email too short in row " + (index+1) + ": '" + email + "'\n";
                            }              
                        } else {
                            invalidEmailsIndex.push(index.toString());
                            errors += "Missing '.' in row " + (index+1) + ": '" + email + "'\n";
                        }
                    }
                    else {
                        invalidEmailsIndex.push(index.toString());
                        errors += "Email too short in row " + (index+1) + ": '" + email + "'\n";
                    }
                } else {
                    invalidEmailsIndex.push(index.toString());
                    errors += "Missing '@' in row " + (index+1) + ": '" + email + "'\n";
                }

                if (index+1 < valuesSplit.length) {
                    newValue += email +",\n";
                } else {
                    newValue += email;
                }
            }

            if (errors != null && errors != "") {
                // console.log(errors);                
                document.getElementById('btn-vtc-submit').disabled = true;   
            } else {
                document.getElementById('btn-vtc-submit').disabled = false;   
                errors = "";             
            }

            document.getElementById('emails').value = newValue;

            log += errors + duplicates;
            document.getElementById('email-log').value = log;           
            
            var serviceIDElementList = document.getElementById('service_id').getElementsByTagName("option");
            // var text = document.createTextNode(log);
            // emailLogDiv.appendChild(text);
            // console.log(emailLogDiv);

        });

        selectCodeType("timevodcode");
        
        var courseID = $('#course_id').val();
        adjustOptions(courseID);

        $('#course_id').change(function(e) {
            adjustOptions(e.target.value);
        });
    });

    $('#code_type').change(function(e) {
        targetName = e.target.value;
        selectCodeType(targetName);
    });

    function selectCodeType (targetName) {
        if (targetName == "buy1gift1") {         
            $('.time-promo-code-div').css("display", "none");
            $('.time-vod-div').css("display", "none");
            $('.gift-code-div').css("display", "block");
        } else if (targetName == "timepromocode") {            
            $('.gift-code-div').css("display", "none");
            $('.time-vod-div').css("display", "none");
            $('.time-promo-code-div').css("display", "block");
        } else if (targetName == "timevodcode") {            
            $('.gift-code-div').css("display", "none");
            $('.time-promo-code-div').css("display", "none");
            $('.time-vod-div').css("display", "block");
        }
    }

    function adjustOptions(courseID) {   
        var allServices = {!! $services !!}   

        var serviceIDElement = document.getElementById('service_id');
        var serviceIDElementList = document.getElementById('service_id').getElementsByTagName("option");
        var serviceIDElementListLength = parseInt(serviceIDElementList.length)

        var courseServices = allServices.filter(service => service.course_id == courseID);
        
        var index;
        for (index = 0; index < serviceIDElementListLength; index++) {    
            serviceIDElement.removeChild(serviceIDElement.childNodes[0]);
        }
        
        for (index = 0; index < courseServices.length; index++) {                
            var option = document.createElement("option");                
            option.value = courseServices[index].id;
            var optionValue = document.createTextNode(courseServices[index].name);        
            option.appendChild(optionValue); 
            serviceIDElement.appendChild(option);
        }   
    }
</script>
   
@endsection