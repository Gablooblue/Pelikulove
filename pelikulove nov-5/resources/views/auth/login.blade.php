@extends('layouts.app')

@section('content')
<div class="container p-3">
    <div class="row justify-content-center">
        <div class="col-md-6 col-sm-10 col-xs-12">
        	@if(Session::has('warning-message'))
	
		<div class="alert alert-warning alert-dismissible fade show status-box">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
		<strong>{!! Session::get('warning-message') !!}</strong>
		</div>
  								
		@endif
            <div class="card">
                <div class="card-header">{{ __('Log in to your Pelikulove account') }}</div>

                <div class="card-body">
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
                                    Don't have an account? <a href="{{ url('/register') }}">Sign up</a>
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
