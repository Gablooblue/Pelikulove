@extends('layouts.app')

@section('template_title')
    Editing Payment Method: {!! $paymentMethod->name !!}
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
                            Editing Payment Method: 
                            <br>
                            {!! $paymentMethod->name !!}
                            <div class="pull-right">
                                <a href="{{ route('payment-methods') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="top" title="Back to Payment Methods">
                                    <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                                    <span class="hidden-sm hidden-xs">
                                        Back to 
                                    </span><span class="hidden-xs">
                                        Payment Methods
                                    </span>
                                </a>
                                <br>
                                <a href="{{ url('/payment-methods/' . $paymentMethod->id) }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="Back to Payment Method">
                                    <i class="fa fa-fw fa-reply" aria-hidden="true"></i>
                                        Back to 
                                    <span class="hidden-xs">
                                        Payment Method
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <hr>
                    {{-- <div class="card-body">
                        <div class="dz-preview"></div>
                        {!! Form::open(array('route' => ['payment-methods.upload', $paymentMethod->id], 'method' => 'POST', 'name' => 'avatarDropzone','id' => 'avatarDropzone', 'class' => 'form single-dropzone dropzone single', 'files' => true)) !!}
                            <img id="user_selected_avatar" class="user-avatar" 
                            src="@if ($paymentMethod->logo != NULL) {{ $paymentMethod->logo }} @endif" alt="{{ $paymentMethod->name }}">
                        {!! Form::close() !!}
                    </div> --}}
                    <div class="card-body">
                        {!! Form::open(array('route' => ['payment-methods.update', $paymentMethod->id], 'method' => 'PUT', 'role' => 'form', 'class' => 'needs-validation')) !!}

                        {!! csrf_field() !!}

                        <div class="card-body div-payment-methods">		
                            <div class="form-group has-feedback row {{ $errors->has('name') ? ' has-error ' : '' }}">
                                {!! Form::label('name', 'Payment Method Name:', array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
                                    {!! Form::text('name', $paymentMethod->name, array('id' => 'name', 'class' => 'form-control', 'placeholder' => 'Payment Method Name', 'required')) !!}
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
                                    {!! Form::textarea('description', $paymentMethod->description, array('id' => 'description', 'class' => 'form-control', 'placeholder' => 'About the Payment Method', 'required')) !!}
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
    </div>

    @include('modals.modal-save')
    @include('modals.modal-delete')

@endsection

@section('footer_scripts')
    @include('scripts.delete-modal-script')
    @include('scripts.save-modal-script')
    @include('scripts.check-changed')
    @include('scripts.paymentMethod-logo-dz')
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
