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
				@if(Session::has('codeTypeInvalid'))
					<div class="alert alert-danger alert-dismissable">
						{!!Session::get('codeTypeInvalid')!!}
					</div>
				@endif
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
				<div class="card">
					<div class="card-header">

                        <div style="display: flex; justify-content: space-between; align-items: center;">
							Redeem Gift Code
                        </div>
						<hr class="mb-0 pb-0">
					</div>
					<div class="card-body">
						{!! Form::open(array('route' => 'redemption.store', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation', 'id' => 'redemtpionForm')) !!}
							{!! csrf_field() !!} 
							<div class="form-group row">
								<div class="container">
									<div class="row justify-content-center ml-4 mr-4 mb-2">
										<div class="col-xl-10">
											{!! Form::text('code', Null, array('id' => 'code', 'class' => 'form-control', 
											'placeholder' => 'SAMPLE-CODE-1', 'id' => 'code', 'required')) !!}
										</div>		
									</div> 
									<div class="row justify-content-center ml-4 mr-4">
										<div class="col-xl-10">
											{!! Form::button('Redeem Code', array('class' => 'btn btn-block btn-danger float-right btn-submit', 
											'type' => 'submit', 'id' => 'redemptionSubmit')) !!}
										</div>		
									</div> 
									<div class="row justify-content-center mb-2 mt-4">
										<div> 
											Got an extra code?
											<a href = "{{url('/redeem-a-code/invite')}}">Click here to invite a friend!</a>
										</div> 
									</div>
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

    {{-- @include('scripts/code-generator'); --}}
<script type="text/javascript">
	$("#redemtpionForm").on('submit', function(e){
		e.preventDefault();

        document.getElementById('redemptionSubmit').disabled=true;
		document.getElementById('redemtpionForm').submit();
	});
	$('.redemptionSubmit').click(function(event) {

  	});
</script>
   
@endsection