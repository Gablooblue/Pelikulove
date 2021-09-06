@extends('layouts.app')

@section('template_title')
	Redemption Page
@endsection

@section('head')
@endsection

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2">
				@if(Session::has('alreadyEnrolled'))
					<div class="alert alert-danger alert-dismissable">
						{!!Session::get('alreadyEnrolled')!!}
					</div>
				@endif
				@if(Session::has('codeUsed'))
					<div class="alert alert-danger alert-dismissable">
						{!!Session::get('codeUsed')!!}
					</div>
				@endif
				@if(Session::has('codeTypeInvalid'))
					<div class="alert alert-danger alert-dismissable">
						{!!Session::get('codeTypeInvalid')!!}
					</div>
				@endif
				@if(Session::has('successfulRedemption'))
					<div class="alert alert-success alert-dismissable">
						{!!Session::get('successfulRedemption')!!}
					</div>
				@endif
				@if(Session::has('emailCannotBeYourOwn'))
					<div class="alert alert-danger alert-dismissable">
						{!!Session::get('emailCannotBeYourOwn')!!}
					</div>
				@endif
				<div class="card">
					<div class="card-header">

                        <div style="display: flex; justify-content: space-between; align-items: center;">
							Gift to a friend!
                        </div>
					</div>
					<div class="card-body">
						{!! Form::open(array('route' => 'redemption.inviteStore', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation', 'id' => 'redemtpionForm')) !!}
							<div class="form-group row">
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
								</div>
							</div>
							
							<div class="form-group row">
								{!! Form::label('code', 'Code', array('class' => 'col-md-3 control-label')); !!}
                                <div class="col-md-9">
                                    <div class="input-group">
										{!! Form::text('code', 'SAMPLE-CODE-1', array('id' => 'code', 'class' => 'form-control', 'placeholder' => 'Gift code', 'id' => 'code', 'required')) !!}
                                        <div class="input-group-append">
                                            <label class="input-group-text" for="code">
                                                <i class="fa fa-fw {{ trans('forms.create_user_icon_password') }}" aria-hidden="true"></i>
                                            </label>
                                        </div>
                                    </div>
								</div>
							</div>
								
							<div class="row justify-content-end">
								<div class="col-md-1">
								</div>
                                {{-- <div class="col-md-9">
                                    <div class="input-group">
										{!! Form::button('Invite', array('class' => 'btn btn-block btn-danger margin-bottom-1 mt-1 mb-1 btn-submit','type' => 'submit', 'id' => 'redemptionInvite')) !!} 
									</div>
									<div class="input-group">
										{!! Form::button('Skip', array('class' => 'btn btn-block btn-warning margin-bottom-1 mt-1 mb-1 btn-skip','id' => 'redemptionInviteSkip')) !!}
									</div>
								</div> --}}
								<div class="col-md-7 mr-5">
									{!! Form::button('Invite', array('class' => 'btn btn-block btn-danger margin-bottom-1 ml-5 mt-1 mb-1 btn-submit','type' => 'submit', 'id' => 'redemptionInvite')) !!} 
								</div>
								<div class="col-md-2">
									{{-- {!! Form::button('Skip', array('class' => 'btn btn-block btn-warning margin-bottom-1 mt-1 mb-1 mr-3 btn-skip','id' => 'redemptionInviteSkip')) !!}  --}}
									<a href="{{ url('/course/1/show') . '#courseProfile'}}" class="btn btn-block btn-warning margin-bottom-1 mt-1 mb-1 mr-3 btn-skip" id = 'redemptionInviteSkip'>Skip</a>
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

<script type="text/javascript">
	$("#redemtpionForm").on('submit', function(e){
		e.preventDefault();

        document.getElementById('redemptionInvite').disabled=true;
		document.getElementById('redemtpionForm').submit();
	});
	$('#redemptionInviteSkip').onClick(function(event) {
		
  	});
</script>
   
@endsection