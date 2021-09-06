@extends('layouts.app')

@section('template_fastload_css')
    #signUp:disabled {opacity: 0.4}
@endsection

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6 col-sm-10 col-xs-12">
            <div class="card">
                {{-- <div class="card-header text-center">{{ __('SIGN UP for FREE access') }}</div> --}}

                <div class="card-header text-center">
                    Welcome!
                    <br>
                    <span class="small">                        
                        Ricky Lee Scriptwriting Workshop
                    </span>
                    <div class="mt-2">
                        <img class="w-100" src="{{ asset('images/courses/ricky-lee-sits-2.jpg') }}" alt="">
                    </div>
                </div>
                
                <hr>

                <div class="card-body">
                    <form method="POST" action="{{ route('registration.storerickylee') }}">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <label for="name" class="col-form-label text-md-right">{{ __('Username') }}</label>
                                {{-- <span class="text-danger" style="font-size: 1.5rem">*</span> --}}
                                <input id="name" type="text"
                                    class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                                    value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <label for="email" class="col-form-label">{{ __('E-Mail') }}</label>
                                <input id="email" type="email"
                                    class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                    value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row" id="form-show-password">
                            <div class="col-md-8 offset-md-2">
                                <label for="password" class="col-form-label">{{ __('Password') }}</label>
                                <div class="input-group" id="form-show-password">
                                    <input id="password" type="password"
                                        class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                        name="password" required>
                                    <div class="input-group-append">
                                        <div class="input-group-text"><a href=""><i class="fa fa-eye-slash"></i></a>
                                        </div>
                                    </div>
                                </div>
                                @if ($errors->has('password'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        @if(config('settings.reCaptchStatus'))
                            <br>
                            <div class="form-group row d-flex justify-content-center">
                                <div class="col-md-8 text-center">
                                    <div class="g-recaptcha" data-sitekey="{{ config('settings.reCaptchSite') }}"></div>
                                </div>
                            </div>
                        @endif

                        <div class="form-group row m-3">
                            <div class="col-md-8 offset-md-2">
                                By Signing Up, you agree to our 
                                <a href="http://pelikulove.com/terms-and-conditions/">Terms and Conditions</a> and 
                                <a href="http://pelikulove.com/privacy-policy/">Privacy Policy</a>        
                            </div>
                            </label>
                        </div>
                        
                        <div class="form-group row m-3 d-flex justify-content-center">
                            <div class="col-md-6 text-center">
                                <button type="submit" id="signUp" class="btn btn-lg btn-primary m-3" disabled
                                data-toggle="tooltip" data-placement="left" title="Read Terms and Conditions First">
                                    {{ __('Sign Up') }}
                                </button>
                            </div>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_scripts')
    @include('scripts.tooltips')

    @if(config('settings.reCaptchStatus'))
    <script src='https://www.google.com/recaptcha/api.js'></script>
    @endif

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>

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

            // Sign Up btn Enable on Scroll Down
            document.getElementsByName("container_terms")[0].addEventListener("scroll", checkScrollHeight, false);

            var tosDiv = document.getElementsByName("container_terms")[0];
            var signUpBtn = document.getElementById("signUp");

            function checkScrollHeight() {                

                if(tosDiv.scrollTop >= (tosDiv.scrollHeight - tosDiv.offsetHeight)) {
                    signUpBtn.disabled = false;
                    // Remove tooltip on sign up enable
                    signUpBtn.title = '';
                }
            }          
        })
    </script>
@endsection