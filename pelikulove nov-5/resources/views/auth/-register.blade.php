@extends('layouts.app')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6 col-sm-10 col-xs-12">
            <div class="card">
                <div class="card-header">{{ __('Hey there! Kindly sign up first before enrolling') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf



                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <label for="name" class="col-form-label text-md-right">{{ __('Username') }}</label>


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

                        <div class="form-group row">
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
                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <div class="g-recaptcha" data-sitekey="{{ config('settings.reCaptchSite') }}"></div>
                            </div>
                        </div>
                        @endif
                        <div class="form-group row my-4">
                            <div class="col-md-8 offset-md-2">
                                By Signing Up, you agree to our <a
                                    href="http://pelikulove.com/terms-and-conditions/">Terms and Conditions</a> and
                                <a href="http://pelikulove.com/privacy-policy/">Privacy Policy</a>.
                            </div>

                            </label>
                        </div>
                        <div class="form-group row mb-4">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-lg btn-primary mb-4">
                                    {{ __('Sign Up') }}
                                </button>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div
                                    style="width: 100%; height: 20px; border-bottom: 1px solid #bbbbbb; text-align: center; margin-bottom: 25px;">
                                    <span
                                        style="font-size: 1em;  position: relative; top: .5em; background-color: white; padding: 0 10px;">
                                        or
                                    </span>
                                </div>

                                @include('partials.socials-icons')

                                <p class="text-center mb-4">
                                    Already have an account? <a href="{{ url('/login') }}">Log in</a>
                                </p>
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
@if(config('settings.reCaptchStatus'))
<script src='https://www.google.com/recaptcha/api.js'></script>
@endif
@endsection
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

<script>
$(document).ready(function() {
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
});
</script>