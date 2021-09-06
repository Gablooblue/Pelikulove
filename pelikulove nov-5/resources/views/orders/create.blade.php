@extends('layouts.app')

@section('template_title')
    {!! trans('orders.create-new-order') !!}
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
                            {!! trans('orders.create-new-order') !!}
                            <div class="pull-right">
                                <a href="{{ route('orders.index') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="top" title="{{ trans('orders.tooltips.back-orders') }}">
                                    <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                                    {!! trans('orders.buttons.back-to-orders') !!}
                                </a>
                                
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        {!! Form::open(array('route' => ['order.store'], 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}

                            {!! csrf_field() !!}
							
							 <div class="form-group has-feedback row {{ $errors->has('user_id') ? ' has-error ' : '' }}">
                                {!! Form::label('user_id', 'User', array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                    	<select class="form-control" name="user_id" >
                                    	<option value="">[ Select User ] </option>
    									@foreach ($users as $u)
      									<option value="{{$u->id}}" @if (old('user_id') == $u->id || $user_id == $u->id) ? selected @endif>{{$u->email}} ({{$u->name}}) </option>
   										@endforeach
 										</select>
                                      
                                    </div>
                                    @if($errors->has('user_id'))
                                        <span class="help-block small text-danger">
                                            <strong>{{ $errors->first('user_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
							
                            <div class="form-group has-feedback row {{ $errors->has('ref_no') ? ' has-error ' : '' }}">
                                {!! Form::label('ref_no', 'Ref No' , array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                    	 <input type="text" name="ref_no" value="{{ old('ref_no') }}" class="form-control">
                                      
                                    </div>
                                    @if($errors->has('ref_no'))
                                        <span class="help-block small text-danger">
                                            <strong>{{ $errors->first('ref_no') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                           <div class="form-group has-feedback row {{ $errors->has('payment_id') ? ' has-error ' : '' }}">
                                {!! Form::label('payment_id', 'Payment', array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                    <select class="form-control" name="payment_id">
                                    	<option value="">[ Select Payment ] </option>
    									@foreach ($payments as $p)
      									<option value="{{$p->id}}" {{ (old('payment_id') == $p->id) ? 'selected' : '' }}>{{$p->name}}  </option>
   										 @endforeach
 										</select>
                                         
                                     </div>
                                     @if($errors->has('payment_id'))
                                        <span class="help-block small text-danger">
                                            <strong>{{ $errors->first('payment_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

							<div class="form-group has-feedback row {{ $errors->has('service_id') ? ' has-error ' : '' }}">
                                {!! Form::label('service_id', 'Service', array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                    <select class="form-control" name="service_id">
                                    	<option value="">[ Select Service ] </option>
    									@foreach ($services as $s)
      									<option value="{{$s->id}}" {{(old('service_id') == $s->id) ? 'selected' : ''}}>{{$s->name}}  </option>
   										 @endforeach
 										</select>
                                        
                                     </div>
                                     @if($errors->has('service_id'))
                                        <span class="help-block small text-danger">
                                            <strong>{{ $errors->first('service_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group has-feedback row {{ $errors->has('amount') ? ' has-error ' : '' }}">
                                {!! Form::label('amount', 'Amount' , array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                     <input type="number" name="amount" value="{{ old('amount') ? number_format(old('amount'),2) : ''}}" class="form-control">
                                       
                                    </div>
                                    @if($errors->has('amount'))
                                        <span class="help-block small text-danger">
                                            <strong>{{ $errors->first('amount') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group has-feedback row {{ $errors->has('payment_status') ? ' has-error ' : '' }}">
                                {!! Form::label('payment_status', 'Status', array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <select class="form-control" name="payment_status">
    										<option value="">[ Select Status ] </option>
      									<option value="S" {{ (old('payment_status') == "S")  ? 'selected' : ''}}>Success  </option>
      									<option value="P" {{ (old('payment_status') == "P") ? 'selected' : ''}}>Pending  </option>
      									<option value="F" {{ (old('payment_status') == "F") ? 'selected' : ''}}>Failure  </option>
   										<option value="W" {{ (old('payment_status') == "W") ? 'selected' : ''}}>Waiting  </option>
 										</select>
                                    </div>
                                    @if ($errors->has('payment_status'))
                                        <span class="help-block small text-danger">
                                            <strong>{{ $errors->first('payment_status') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group has-feedback row {{ $errors->has('code') ? ' has-error ' : '' }}">
                                {!! Form::label('code', 'Code' , array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                     <input type="text" name="code" value="{{  old('code') }}" class="form-control">
                                       
                                    </div>
                                    @if($errors->has('code'))
                                        <span class="help-block small text-danger">
                                            <strong>{{ $errors->first('code') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                
                                <div class="col-12 col-sm-6">
                                 {!! Form::button(trans('forms.create_order_button_text'), array('class' => 'btn btn-success margin-bottom-1 mb-1 float-right','type' => 'submit' )) !!}
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
