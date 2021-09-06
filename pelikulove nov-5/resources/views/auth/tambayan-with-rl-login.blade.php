@extends('layouts.app')

@section('template_title')
{{-- {{ $course->title }} --}}
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
@endsection

@section('content')




<div class="" style="">
    {{-- <div class="container"> --}}

        <div class="">            
            <img class="w-100" src="{{ asset('images/vods/tambayan-wtih-rl-stock-3.jpg') }}" alt="">
        </div>

        <div class="container mt-3">
            <div class="row d-flex flex-row justify-content-center">

                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 align-self-center px-4 card shadow rounded">
                    <form method="POST" action="{{ route('login') }}" class="loginform">
                        @csrf

                        <div class="mt-3 form-group row justify-content-center">
                        	<div class="col-12">
                            <label for="email" class="col-form-label">{{ __('E-Mail') }}</label>

                         
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                        </div>

                        <div class="mt-3 form-group row justify-content-center">
                        	 <div class="col-12">
                            <label for="password" class="col-form-label">{{ __('Password') }}</label>

                           
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
				
                        <div class="mt-3 form-group row justify-content-center">
                            <div class="col-12">
                                <div class="checkbox float-left">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember me') }}
                                    </label>
                                </div>
                               
                            </div>
                        </div>
											
                        <div class="form-group row justify-content-center mt-3 mb-0 mx-3">
                            <div class="col-12 row justify-content-center ">
                                <button type="submit" id="signUp" class="btn btn-lg btn-warning m-3 trash-hand">
                                    <h1 class="mb-0">
                                        {{ __('Login') }}
                                    </h1>                                 
                                </button>
                            </div>
                        </div>
											
                        <div class="form-group row justify-content-center mb-4 mt-0 mx-3">
                            <div class="col-12 row justify-content-center ">
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            </div>
                        </div>
                        
						<div class="row">
                              <div class="col-12">
                            	<div style="width: 100%; height: 20px; border-bottom: 1px solid #bbbbbb; text-align: center; margin-bottom: 25px;">
  								<span style="font-size: 1em;  position: relative; top: .5em; background-color: white; padding: 0 10px;" >
   								or
  								</span>
								</div>
                                
                                @include('partials.socials-icons')
                                
                                <p class="text-center mb-4">
                                    Don't have an account? <a href="{{ route('registration.newcreaterickylee') }}">Sign up</a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>

            </div> <!-- row -->
        </div>

        

    {{-- </div> --}}<!-- container -->
</div>

@endsection


@section('footer_scripts')
    @include('scripts.tooltips')

    @if(config('settings.reCaptchStatus'))
    <script src='https://www.google.com/recaptcha/api.js'></script>
    @endif

    <script>
        $(document).ready(function() {
            // Passwords
            $("#form-show-password a").on('click', function(event) {
                event.preventDefault();
                if ($('#form-show-password input').attr("type") == "text") {
                    $('#form-show-password input').attr('type', 'password');
                    $('#form-show-password i').addClass("fa-eye-slash");
                    $('#form-show-password i').removeClass("fa-eye");
                } else if ($('#form-show-password input').attr("type") == "password") {
                    $('#form-show-password input').attr('type', 'text');
                    $('#form-show-password i').removeClass("fa-eye-slash");
                    $('#form-show-password i').addClass("fa-eye");
                }
            });        
        })
    </script>
@endsection