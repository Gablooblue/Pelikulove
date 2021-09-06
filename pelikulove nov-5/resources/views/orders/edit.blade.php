@extends('layouts.app')

@section('template_title')
    {!! trans('orders.editing-order', ['name' => $order->name]) !!}
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
                            {!! trans('orders.editing-order') !!}
                            <div class="pull-right">
                            	<a href="{{url('/order/'.$order->id.'/transactions')}}" class="btn btn-outline-primary btn-sm float-left" data-toggle="tooltip" data-placement="top" title="Show Transactions">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                    Show Transactions
                                </a>
                                &nbsp;&nbsp;
                                <a href="{{ route('orders.index') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="top" title="{{ trans('orders.tooltips.back-orders') }}">
                                    <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                                    {!! trans('orders.buttons.back-to-orders') !!}
                                </a>
                                
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        {!! Form::open(array('route' => ['order.update'], 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}

                            {!! csrf_field() !!}
							{{ Form::hidden('id', $order->id) }}
							 <div class="form-group has-feedback row {{ $errors->has('user_id') ? ' has-error ' : '' }}">
                                {!! Form::label('user_id', 'User', array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                    	<select class="form-control" name="user_id" {{ $order->payment_id == 1 ? 'disabled' : '' }} >
                                    	
    									@foreach ($users as $u)
      									<option value="{{$u->id}}" @if ($order->user_id == $u->id) ? selected @endif>{{$u->email}} ({{$u->name}}) </option>
   										@endforeach
 										</select>
                                       @if ($order->payment_id == 1) {{ Form::hidden('user_id', $order->user_id) }} @endif
                                    </div>
                                    @if($errors->has('user_id'))
                                        <span class="help-block small text-danger">
                                            <strong>{{ $errors->first('user_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                           

                            <div class="form-group has-feedback row {{ $errors->has('transaction_id') ? ' has-error ' : '' }}">
                                {!! Form::label('transaction_id', 'Trans ID' , array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                      <input type="text" name="transaction_id" value="{{ $order->transaction_id ? $order->transaction_id : old('transaction_id') }}" class="form-control" {{($order->payment_id == 1) ? 'readonly' : '' }}>
                                            
                                    </div>
                                    @if($errors->has('transaction_id'))
                                        <span class="help-block small text-danger">
                                            <strong>{{ $errors->first('transaction_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group has-feedback row {{ $errors->has('ref_no') ? ' has-error ' : '' }}">
                                {!! Form::label('ref_no', 'Ref No' , array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                    	 <input type="text" name="ref_no" value="{{ $order->ref_no  ? $order->ref_no :  old('ref_no') }}" class="form-control" {{($order->payment_id == 1) ? 'readonly' : '' }}>
                                      
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
                                    <select class="form-control" name="payment_id" {{($order->payment_id == 1) ? 'disabled' : '' }}>
    									@foreach ($payments as $p)
      									<option value="{{$p->id}}" {{ ($order->payment_id == $p->id) ? 'selected' : '' }}>{{$p->name}}  </option>
   										 @endforeach
 										</select>
                                         @if ($order->payment_id == 1) {{ Form::hidden('payment_id', $order->payment_id) }} @endif
                                    
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
                                    <select class="form-control" name="service_id" {{($order->payment_id == 1) ? 'disabled' : '' }}>
    									@foreach ($services as $s)
      									<option value="{{$s->id}}" {{($order->service_id == $s->id) ? 'selected' : ''}}>{{$s->name}}  </option>
   										 @endforeach
 										</select>
                                         @if ($order->payment_id == 1) {{ Form::hidden('service_id', $order->service_id) }} @endif
                                    
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
                                     <input type="number" name="amount" value="{{ $order->amount || $order->amount == 0.00  ?  $order->amount  : old('amount') }}" class="form-control" {{($order->payment_id == 1) ? 'readonly' : '' }}>
                                       
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
    									
      									<option value="S" {{ ($order->payment_status == "S")  ? 'selected' : ''}}>Success  </option>
      									<option value="P" {{ ($order->payment_status == "P") ? 'selected' : ''}}>Pending  </option>
      									<option value="F" {{ ($order->payment_status == "F") ? 'selected' : ''}}>Failure  </option>
   										<option value="W" {{ ($order->payment_status == "W") ? 'selected' : ''}}>Waiting  </option>
   									
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
                                     <input type="text" name="code" value="{{ $order->code  ? $order->code :  old('code') }}" class="form-control" {{($order->payment_id == 1) ? 'readonly' : '' }}>
                                       
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
                                    {!! Form::button(trans('forms.save-changes'), array('class' => 'btn btn-success btn-block margin-bottom-1 mt-3 mb-2 btn-save','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmSave', 'data-title' => trans('modals.modal_text_confirm_title'), 'data-message' => trans('modals.modal_text_confirm_message'))) !!}
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
  @include('scripts.save-modal-script')
  @include('scripts.check-changed')
@endsection
