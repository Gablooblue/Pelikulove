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
            {{-- <img class="w-100" src="{{ asset('images/courses/ricky-lee-register-top-2.jpg') }}" alt=""> --}}
        </div>

        <div class="container mt-3">
            <div class="row d-flex flex-row justify-content-center">
                
                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12 hidden-xl hidden-lg hidden-md mt-3">  
                    <div class="container">
                        <div class="m-3">              
                            <video id="player" controls playsinline controlsList="nodownload"
                            {{-- poster="{{ asset('images/patikim-thumbnail.png')}}" --}}
                            style="width: 100%; height: 100%;">
                                <source src="https://storage.googleapis.com/learn.pelikulove.com/Courses/Ricky%20Lee/Ricky-Lee-Commencement-Speech.mp4"
                                type="video/mp4"/>
                            </video>   
                        </div>    
                        <div class="m-3 text-center">
                            <p class="traveling-typewriter">
                                Dr Ricardo "Ricky" Lee is the most-awarded scriptwriter in the Philippines. <br>
                                <br>
                                He has written more than 180 produced film scripts, earning him more than 70 trophies 
                                from award-giving bodies, including life achievement awards from Cinemanila International Film Festival, 
                                the Gawad Urian, the UP Gawad Plaridel, the Gawad CCP, and others. <br>
                            </p>
                        </div>
                    </div>                      
                </div>


                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 align-self-center px-4">
                    <form method="POST" action="{{ route('registration.newstorerickylee') }}">
                        @csrf
                        <div class="mt-3 form-group row justify-content-center">
                            <div class="col-12">
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

                        <div class="mt-3 form-group row justify-content-center">
                            <div class="col-12">
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

                        <div class="mt-3 form-group row justify-content-center" id="form-show-password">
                            <div class="col-12">
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
                            <div class="mt-2 form-group row d-flex justify-content-center">
                                <div class="g-recaptcha" data-sitekey="{{ config('settings.reCaptchSite') }}">
                                </div>
                            </div>
                        @endif

                        <div class="mt-3 form-group row m-3 justify-content-center">
                            <div class="col-12">
                                By Signing Up, you agree to our 
                                <a href="http://pelikulove.com/terms-and-conditions/">Terms and Conditions</a> and 
                                <a href="http://pelikulove.com/privacy-policy/">Privacy Policy</a>        
                            </div>
                            </label>
                        </div>
                        
                        <div class="form-group row m-3 d-flex justify-content-center">
                            <div class="col-12 text-center">
                                <button type="submit" id="signUp" class="btn btn-lg btn-warning m-3 trash-hand">
                                    <h1 class="mb-0">
                                        {{ __('Sign Up Now') }}
                                    </h1>                                 
                                </button>
                            </div>
                        </div>
                        
                        <div class="form-group row m-3 d-flex justify-content-center">
                              <div class="col-12">
                            	<div style="width: 100%; height: 20px; border-bottom: 1px solid #bbbbbb; text-align: center; margin-bottom: 25px;">
  								<span style="font-size: 1em;  position: relative; top: .5em; background-color: white; padding: 0 10px;" >
   								or
  								</span>
                                </div>
                                <br>
                                
                                <p class="text-center mb-4">
                                    Already have an account? <a href="{{ route('login.tambayanwithrl') }}">Log in</a>
                                </p>
                            </div>
                        </div>

                    </form>
                </div>


                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12 hidden-sm hidden-xs mt-3">  
                    <div class="container">
                        <div class="m-3">              
                            <video id="player" controls playsinline controlsList="nodownload"
                            {{-- poster="{{ asset('images/patikim-thumbnail.png')}}" --}}
                            style="width: 100%; height: 100%;">
                            {{-- ftp://pelikulove@dev.pelikulove.com/pelikulove/public/fonts/TravelingTypewriter.gif --}}
                                <source src="https://storage.googleapis.com/learn.pelikulove.com/Courses/Ricky%20Lee/Ricky-Lee-Commencement-Speech.mp4"
                                type="video/mp4"/>
                            </video>   
                        </div>    
                        <div class="m-3 text-center">
                            <h5 class="traveling-typewriter">
                                Dr Ricardo "Ricky" Lee is the most-awarded scriptwriter in the Philippines. <br>
                                <br>
                                He has written more than 180 produced film scripts, earning him more than 70 trophies 
                                from award-giving bodies, including life achievement awards from Cinemanila International Film Festival, 
                                the Gawad Urian, the UP Gawad Plaridel, the Gawad CCP, and others. <br>
                            </h5>
                        </div>
                    </div>                      
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