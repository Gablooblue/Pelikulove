<div class="modal fade" id="loginAndSignup" role="dialog" aria-labelledby="loginAndSignup" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="login-mode">            
                <div class="modal-header">
                    <h5 class="modal-title">
                        <strong>
                            Log in to your Pelikulove account
                        </strong>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">close</span>
                    </button>
                </div>
    
                <div class="modal-body">
                    <form method="POST" action="{{ route('login') }}" class="loginform">
                        @csrf

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                            <label for="email" class="col-form-label">{{ __('E-Mail') }}</label>

                        
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

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

                        
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                
                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <div class="checkbox float-left">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember me') }}
                                    </label>
                                </div>
                            
                            </div>
                        </div>
                                            
                        <div class="form-group row justify-content-center mb-4">
                            <div class="col-md-8 text-center">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                <br>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div style="width: 100%; height: 20px; border-bottom: 1px solid #bbbbbb; text-align: center; margin-bottom: 25px;">
                                <span style="font-size: 1em;  position: relative; top: .5em; background-color: white; padding: 0 10px;" >
                                or
                                </span>
                                </div>
                                
                                @include('partials.socials-icons')
                                
                                <p class="text-center mb-4">
                                    Don't have an account? <a id="signUpSwitch" href="#">Sign up</a>
                                </p>
                            </div>
                        </div>     
                    </form>
                </div>
            </div>

            <div class="signup-mode" style="display: none;">          
                <div class="modal-header">
                    <h5 class="modal-title">
                        <strong>
                            SIGN UP for FREE access
                        </strong>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">close</span>
                    </button>
                </div>
    
                <div class="modal-body">
                    <form method="POST" action="{{ route('register') }}">
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
                        
                        {{-- <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <label for="first_name" class="col-form-label text-md-right">{{ __('First Name') }}</label>
                                <input id="first_name" type="text"
                                    class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name"
                                    value="{{ old('first_name') }}">

                                @if ($errors->has('first_name'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-md-8 offset-md-2">
                                <label for="last_name" class="col-form-label text-md-right">{{ __('Last Name') }}</label>
                                <input id="last_name" type="text"
                                    class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name"
                                    value="{{ old('last_name') }}">

                                @if ($errors->has('last_name'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div> --}}

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
                                    Already have an account? <a id="logInSwitch" href="#">Log in</a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
