@extends('layouts.app')

@section('template_title')
	{{ trans('titles.activation') }}
@endsection

@section('template_fastload_css')

    @font-face {
        font-family: TrashHand;
        src: url('{{ asset('fonts/TrashHand.ttf') }}');
    }

    @font-face {
        font-family: TravelingTypewriter;
        src: url('{{ asset('fonts/TravelingTypewriter.ttf') }}');
    }

    .trash-hand {
        font-weight: 600;
        font-family: TrashHand;
    }

    .traveling-typewriter {
        font-weight: 600;
        font-family: TravelingTypewriter;
	}
	
	label {
        font-weight: 700;
	}
@endsection

@section('content')
	<div class="container">
		<div class="row">
			<div class="card col-12 border-0">
				<div class="card-header trash-hand pb-1" style="font-size: 48px; line-height: normal;">
					<b>
						YOU'RE IN!
					</b>
				</div>
				<div class="card-body py-2">
					<h5>
						Thanks for signing-up! You will recieve an email confirmation shortly. 
						Please click the link to confirm your email address.
					</h5>

					<p class="pt-2">
						<a href='/activation' class="btn btn-warning">{{ trans('auth.clickHereResend') }}</a>
					</p>
				</div>
			</div>
			
			<div class="card col-12 border-0">
				<div class="card-header trash-hand pt-3"  style="font-size: 40px; line-height: normal;">
					<b>
						TELL US MORE ABOUT YOURSELF
					</b>
				</div>
				<div class="card-body">
					<form method="POST" action="{{ route('registration.storerickyleeprofile') }}">
						@csrf
						
						<div class="row justify-content-center">
							
							{{-- FIRST NAME --}}
							<div class="mt-3 form-group row justify-content-center col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12">
								<div class="col-12">
									<label for="first_name" class="col-form-label">First Name</label>
									<input id="first_name" type="first_name"
										class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name"
										value="{{ old('first_name') }}" required autofocus>
	
									@if ($errors->has('first_name'))
									<span class="invalid-feedback">
										<strong>{{ $errors->first('first_name') }}</strong>
									</span>
									@endif
								</div>
							</div>
							
							<div class="col-xl-1 col-lg-1 col-md-1 hidden-sm hidden-xs">
							</div>
	
							{{-- LAST NAME --}}
							<div class="mt-3 form-group row justify-content-center col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12">
								<div class="col-12">
									<label for="last_name" class="col-form-label">Last Name</label>
									<input id="last_name" type="last_name"
										class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name"
										value="{{ old('last_name') }}" required>
	
									@if ($errors->has('last_name'))
									<span class="invalid-feedback">
										<strong>{{ $errors->first('last_name') }}</strong>
									</span>
									@endif
								</div>
							</div>
							
	
							{{-- MOBILE --}}
							<div class="mt-3 form-group row justify-content-center col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12">
								<div class="col-12">
									<label for="mobile_number" class="col-form-label">Mobile Number</label>
	
									<input type="number" class="form-control {{ $errors->has('mobile_number') ? ' is-invalid' : '' }}" 
										id="mobile_number" name="mobile_number" placeholder="" 
										value="{{old('mobile_number')}}" 
										min="0" max="" step="1" required>
										
									@if ($errors->has('mobile_number'))
									<span class="invalid-feedback">
										<strong>{{ $errors->first('mobile_number') }}</strong>
									</span>
									@endif
								</div>
							</div>
							
							<div class="col-xl-1 col-lg-1 col-md-1 hidden-sm hidden-xs">
							</div>
							
							{{-- GENDER --}}
							<div class="mt-3 form-group row justify-content-center col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12">
								<div class="col-12">
									<label for="gender" class="col-form-label">Gender</label>																
									<input list="gender-list" class="form-control{{ $errors->has('gender') ? ' is-invalid' : '' }}"
									name="gender" id="gender" value="{{ old('gender') }}" required/>
									<datalist id="gender-list">
										<option label="Male" value="Male">
										<option label="Female" value="Female">
									</datalist>
	
									@if ($errors->has('gender'))
									<span class="invalid-feedback">
										<strong>{{ $errors->first('gender') }}</strong>
									</span>
									@endif
								</div>
							</div>
							
							{{-- BIRTHDAY --}}
							<div class="mt-3 form-group row justify-content-center col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12">
								<div class="col-12">
									<label for="birthday" class="col-form-label text-md-right">Birthday</label>
									{{-- <span class="text-danger" style="font-size: 1.5rem">*</span> --}}
									<input id="birthday" type="date"
										class="form-control{{ $errors->has('birthday') ? ' is-invalid' : '' }}" name="birthday"
										value="{{ old('birthday') }}" required autofocus>
	
									@if ($errors->has('birthday'))
									<span class="invalid-feedback">
										<strong>{{ $errors->first('birthday') }}</strong>
									</span>
									@endif
								</div>
							</div>
							
							<div class="col-xl-1 col-lg-1 col-md-1 hidden-sm hidden-xs">
							</div>						
							
							{{-- PROFESSION --}}
							<div class="mt-3 form-group row justify-content-center col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12">
								<div class="col-12">
									<label for="profession" class="col-form-label text-md-right">Profession</label>
									{{-- <span class="text-danger" style="font-size: 1.5rem">*</span> --}}
									<input id="profession" type="text"
										class="form-control{{ $errors->has('profession') ? ' is-invalid' : '' }}" name="profession"
										value="{{ old('profession') }}" required autofocus>
	
									@if ($errors->has('profession'))
									<span class="invalid-feedback">
										<strong>{{ $errors->first('profession') }}</strong>
									</span>
									@endif
								</div>
							</div>
	
							{{-- INTERESTS --}}
							<div class="mt-3 form-group row justify-content-center col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12">
								<div class="col-12">
									<label for="interests" class="col-form-label">Interests</label>
									<input id="interests" type="interests"
										class="form-control{{ $errors->has('interests') ? ' is-invalid' : '' }}" name="interests"
										value="{{ old('interests') }}" required>
	
									@if ($errors->has('interests'))
									<span class="invalid-feedback">
										<strong>{{ $errors->first('interests') }}</strong>
									</span>
									@endif
								</div>
							</div>	
							
							<div class="col-xl-1 col-lg-1 col-md-1 hidden-sm hidden-xs">
							</div>
	
							{{-- REFERER --}}
							<div class="mt-3 form-group row justify-content-center col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12">
								<div class="col-12">
									<label for="referer" class="col-form-label">How did you hear about this event?</label>																
									<input list="referer-list" class="form-control{{ $errors->has('referer') ? ' is-invalid' : '' }}"
									name="referer" id="referer" value="{{ old('referer') }}" required/>
									<datalist id="referer-list">
										<option label="Facebook" value="Facebook">
										<option label="Email" value="Email">
										<option label="Friend" value="Friend">
										<option label="Media Site" value="Media Site">
									</datalist>
	
									@if ($errors->has('referer'))
									<span class="invalid-feedback">
										<strong>{{ $errors->first('referer') }}</strong>
									</span>
									@endif
								</div>
							</div>
							
							{{-- COMMENTS --}}
							<div class="mt-3 form-group row justify-content-center col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12">
								<div class="col-12">
									<label for="comments" class="col-form-label">Comments / Suggestions</label>
									<input id="comments" type="comments"
										class="form-control{{ $errors->has('comments') ? ' is-invalid' : '' }}" name="comments"
										value="{{ old('comments') }}" required>
	
									@if ($errors->has('comments'))
									<span class="invalid-feedback">
										<strong>{{ $errors->first('comments') }}</strong>
									</span>
									@endif
								</div>
							</div>
							
							{{-- SUBMIT --}}
							<div class="col-12 form-group row m-3 d-flex justify-content-center">
								{{-- <div class=""> --}}
									<button type="submit" id="signUp" class="btn btn-lg btn-warning m-3 trash-hand"
									data-toggle="tooltip" data-placement="left" title="Read Terms and Conditions First"
									style="border: 1px solid black">
										<h1 class="mb-0 px-2">
											SUBMIT
										</h1>                                 
									</button>
								{{-- </div> --}}
							</div>

						</div>

                    </form>
                        
				</div>
			</div>

			
			{{-- <div class="col-md-10 offset-md-1">
				<div class="card card-default">
					<div class="card-header">{{ trans('titles.activation') }}</div>
					<div class="card-body">
						<p>{{ trans('auth.regThanks') }}</p>
						<p>{{ trans('auth.anEmailWasSent',['email' => $email, 'date' => $date ] ) }}</p>
						<p>{{ trans('auth.clickInEmail') }}</p>
						<p><a href='/activation' class="btn btn-primary">{{ trans('auth.clickHereResend') }}</a></p>
					</div>
				</div>
			</div> --}}
		</div>
	</div>
@endsection




@section('footer_scripts')
    <script>
        $(document).ready(function() {
			// Passwords
			var genderValue;
			$('#gender').on('click', function() {
				if ($(this).val() != '') {
					genderValue = $(this).val();
				}
				$(this).val('');
			});

			$('#gender').on('mouseleave', function() {
				if ($(this).val() == '') {
					$(this).val(genderValue);
				}
			});  

			var refererValue;
			$('#referer').on('click', function() {
				if ($(this).val() != '') {
					refererValue = $(this).val();
				}
				$(this).val('');
			});

			$('#referer').on('mouseleave', function() {
				if ($(this).val() == '') {
					$(this).val(refererValue);
				}
			});      

			$('#mobile_number').change(function(e){  		       
                var amount = $('#mobile_number').val();
                var amountSplit = amount.split(".");
                var amountWhole = amountSplit[0];
                var amountDecimal = amountSplit[1];

				amountDecimal = 0;

                // if (parseInt(amountWhole) > 9) {
                //     amountWhole = 140;
                // } 
				
				if (parseInt(amountWhole) < 0) {
                    amountWhole = 0;
                }
                amount = amountWhole;   
                
                $('#mobile_number').val(amount);
            })
        })
    </script>
@endsection