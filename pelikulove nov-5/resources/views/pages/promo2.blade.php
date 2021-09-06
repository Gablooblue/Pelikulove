 @extends('layouts.app')

 @section('template_title')
 Rody Vera's Playwriting Course
 @endsection

 @section('template_fastload_css')
 @endsection

 @section('content')

 <div class="container-fluid" style="align-items: flex-start">


     <!--Top slider video-->
     <div class="row d-flex flex-row">
         <div class="col-md-12 col-lg-12">
             <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                 <div class="carousel-inner">
                 <div class="carousel-item active">
    					<div class="embed-responsive embed-responsive-16by9">
      					<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/Itixr3yGUew"></iframe>
						  </div>
						  
						  
					</div>

					<div class="carousel-item ">
    					<div class="embed-responsive embed-responsive-16by9">
      					<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/EsEcYfNMVEc"></iframe>
						  </div>
						  
						  
					</div>
					<div class="carousel-item ">
    					<div class="embed-responsive embed-responsive-16by9">
      					<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/XD1dKiagh1k"></iframe>
						  </div>
						  
						  
					</div>
					<div class="carousel-item">
						<img class="d-block w-100" src="{{ asset('images/slider-photo-1.jpg') }}" alt="Second slide">
					</div>
						
					<div class="carousel-item">
						<img class="d-block w-100" src="{{ asset('images/slider-photo-2.jpg') }}" alt="Third slide">
					</div>

						<div class="carousel-item">
						<img class="d-block w-100" src="{{ asset('images/slider-photo-3.jpg') }}" alt="Third slide">
					</div>

                 </div>
                 <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                     <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                     <span class="sr-only">Previous</span>
                 </a>
                 <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                     <span class="carousel-control-next-icon" aria-hidden="true"></span>
                     <span class="sr-only">Next</span>
                 </a>
             </div>
         </div>
     </div>


     <div class="row bg-info justify-content-center" style="z-index:">
         <div class="col-md-8">
             <div class="card bg-info border-0">
                 <div class="card-header bg-info pt-5">
                     <h2 class="text-white text-center font-weight-bold">Sign up to Rody Vera's Playwriting Course!</h2>
                 </div>
                 <div class="card-body">
                     <form method="POST" action="{{ route('register') }}">
                         @csrf
                         <div class="form-group row">
                             <div class="col-md-6 offset-md-3">
                                 <label for="name"
                                     class="col-form-label text-md-right text-white  font-weight-bold">{{ __('Username') }}</label>
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
                             <div class="col-md-6 offset-md-3">
                                 <label for="email"
                                     class="col-form-label text-white font-weight-bold">{{ __('E-Mail') }}</label>
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
                             <div class="col-md-6 offset-md-3">
                                 <label for="password"
                                     class="col-form-label text-white font-weight-bold">{{ __('Password') }}</label>
                                 <input id="password" type="password"
                                     class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                     name="password" required>
                                 @if ($errors->has('password'))
                                 <span class="invalid-feedback">
                                     <strong>{{ $errors->first('password') }}</strong>
                                 </span>
                                 @endif
                             </div>
                         </div>

                         <div class="form-group row mb-4">
                             <div class="col-md-6 offset-md-3">
                                 <label for="password-confirm"
                                     class="col-form-label text-white font-weight-bold">{{ __('Confirm Password') }}</label>
                                 <input id="password-confirm" type="password" class="form-control"
                                     name="password_confirmation" required>
                             </div>
                         </div>
                         @if(config('settings.reCaptchStatus'))
                     <div class="justify-content-center mb-3 form-group row">
                         <div class="col-md-8 offset-md-2">
                             <div class="g-recaptcha" data-sitekey="{{ config('settings.reCaptchSite') }}"></div>
                         </div>
                     </div>
                     @endif
                         <div class="form-group row mb-3">
                             <div class="col-md-6 offset-md-3 text-center ">
                                 <button type="submit"
                                     class="p-2 px-6 btn btn-lg btn-light btn-outline-info font-weight-bold">
                                     {{ __('Register') }}
                                 </button>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col-md-8 offset-md-2">
                                 <div
                                     style="width: 100%; height: 20px; border-bottom: 1px solid white; text-align: center; margin-bottom: 25px;">
                                     <span class="text-white"
                                         style="font-size: 1em; position: relative; top: .5em; background-color: #17a2b8; padding: 0 10px;">
                                         or
                                     </span>
                                 </div>
                                 @include('partials.socials-icons')
                             </div>
                         </div>
                     </form>
                 </div>
             </div>
         </div>
     </div>


 </div>
 <div class="container-fluid" style="align-items: flex-start" style="align-items: flex-start">
     <div class="container-fluid my-5">
         <div class="row justify-content-center">
             <div class="col-lg-6 d-flex justify-content-center m-lg-0 mx-5 mb-5">
                 <h2 class="font-weight-bold" style="text-align: center;"> About Rody </h2>
             </div>
         </div>

         <div class="container">
             <div class="card">
                 <div class="card-body">
                     <div class="row mt-5 justify-content-center">

                         <div class="col-lg-3 m-lg-0 mb-0">
                             <img class="img-fluid instr-image-courses mb-3"
                                 src="https://learn.pelikulove.com/images/courses/rody_id_sm.jpg" alt="Rody Vera"
                                 style="width:300px">
                         </div>
                         <div class="col-lg-6 d-flex m-lg-0 mb-0">
                             <div class="text-lg-left text-md-left">

                                 <h4> Rody Vera </h4>
                                 <p>Playwright | Theater Director | Dramaturg |
                                     Screenwriter | Actor | Singer

                                 </p>

                                 <ul class="list-group list-group-flush">
                                     <li class="list-group-item">Dangal ni Balagtas, Awardee</li>
                                     <li class="list-group-item">Carlos Palanca Awards for Literature, Hall of Fame</li>
                                     <li class="list-group-item">Ateneo’s Gawad Tanglaw ng Lahi, Awardee</li>
                                     <li class="list-group-item">Virgin Labfest, Co-Founder
                                     <li class="list-group-item">The Writer’s Bloc, Inc., Executive Director</li>
                                     <li class="list-group-item">Philippine Educational Theater Association (PETA),
                                         former
                                         Artistic
                                         Director</li>
                                 </ul>

                             </div>
                         </div>


                     </div>

                 </div>
             </div>
         </div>
     </div>
     <div class="row mt-5 justify-content-center">
         <div class="col-lg-6 d-flex justify-content-center m-lg-0 mx-5 mb-0">
             <h2 class="font-weight-bold" style="text-align:center;"> Why enroll in Pelikulove? </h2>
         </div>
     </div>

     <div class="row mt-5 justify-content-center">
         <div class="col-lg-2  justify-content-center m-lg-0 mb-0">
             <div style="text-align: center">
                 <i class="fa fa-film fa-5x mb-3"></i>
                 <p class="mb-0" style="font-weight: 700;"> In-depth lessons </p>
                 <p class="mt-0"> with videographed class discussions </p>
             </div>
         </div>
         <div class="col-lg-2 justify-content-center m-lg-0 mb-0">
             <div style="text-align: center">
                 <i class="fa fa-comments  fa-5x mb-3"></i>
                 <p style="font-weight: 700;"> Tambayan forum </p>
             </div>
         </div>
         <div class="col-lg-2  justify-content-center m-lg-0 mb-0">
             <div style="text-align: center">
                 <i class=" fa fa-file-text-o fa-5x mb-3"></i>
                 <p style="font-weight: 700;"> Downloadable handouts </p>
             </div>
         </div>
         <div class="col-lg-2 justify-content-center m-lg-0  mb-0">
             <div style="text-align: center">


                 <i class="fa fa-users fa-5x mb-3"></i>
                 <p style="font-weight: 700;"> Saluhan workspace</p>
             </div>
         </div>
     </div>
     <div class="col-lg-12  mt-5 d-flex justify-content-center">
         <p style="font-weight: 700;"> Bonus Features </p>
     </div>
     <div class="row d-flex justify-content-center">
         <div class="col-lg ">
         </div>
         <div class="col-lg-4 m-lg-0 mx-5">
             <!-- insert image here -->
             <img src="{{ asset('images/Plays_on_Video.jpg') }}" class="img-fluid">
             <!--align right-->
             <p class="mt-2 mb-0" style="font-weight: 700;"> <span> <i class="pr-2 fa fa-play-circle"></i>
                 </span>
                 Plays-on-Video </p>
             <p> Plays-on-video are stage plays captured cinematically (titles: Indigo Child, Dalawang Gabi, Daddy’s Girl)</p>
         </div>
         <div class="col-lg-4 m-lg-0 mx-5">
             <!-- insert image here -->
             <img src="{{ asset('images/Backstage_Pass.jpg') }}" class="img-fluid">
             <!--align right-->
             <p class="mt-2 mb-0" style="font-weight: 700;"> <span> <i class="pr-2 fa fa-star"></i>
                 </span>
                 Backstage pass </p>
             <p> Get access to a forum with theater directors, playwrights, and actors</p>
         </div>
         <div class="col-lg">
         </div>
     </div>

     <!--Ready to learn div-->
     <div class="row py-4 my-5 justify-content-center">
         <div class="col-md-12">
             <h2 class="text-info font-weight-bold text-center mb-3 "> Ready to learn about Playwriting?</h2>
         </div>
         <div class="col-md-6 text-center  justify-content-center">
             <button type="button" class="btn btn-lg btn-info sign-up-btn"
                 style=" box-shadow: 0px 1px 15px rgba(0, 104, 145, 0.3);">Sign Up</button>
         </div>

     </div>

     <!--Topics and excerpt-->
     <div class="row mt-6 justify-content-center">
         <div class="col-lg-6 d-flex justify-content-center m-lg-0 mx-5 mb-0">
             <h2 class="font-weight-bold"> Lessons </h2>
         </div>
     </div>
     <div class="row mt-3 justify-content-center">
         <div class="col-4 ">
             <div class="card mb-1 bg-white rounded">
                 <div class="card-body">
                 Lesson 1. Playwriting: Going beyond the “Insult”
                 </div>
             </div>
             <div class="card mb-1 bg-white rounded">
                 <div class="card-body">
                 Lesson 2. What to Write About: From Within or Without?
                 </div>
             </div>
             <div class="card  mb-1 bg-white rounded">
                 <div class="card-body">
                 Lesson 3. Types of Character: They Are Not Human!
                 </div>
             </div>
             <div class="card  mb-1 bg-white rounded">
                 <div class="card-body">
                 Lesson 4. Crafting the Character: Depth vs. Action
                 </div>
             </div>
             <div class="card mb-1 bg-white rounded">
                 <div class="card-body">
                 Lesson 5. Genre: What fits?
                 </div>
             </div>
             <div class="card  mb-1 bg-white rounded">
                 <div class="card-body">
                 Lesson 6. Conflict: Status Negotiation and Other
Approaches
                 </div>
             </div>
             <div class="card mb-1 bg-white rounded">
                 <div class="card-body">
                 Lesson 7. Premise: It Isn’t the Be-All and the End-All
                 </div>
             </div>
         </div>
         <div class="col-4 justify-content-center">
           
             <div class="card  mb-1 bg-white rounded">
                 <div class="card-body">
                 Lesson 8. Structure: How You Tell The Story
                 </div>
             </div>
             <div class="card mb-1 bg-white rounded">
                 <div class="card-body">
                     Lesson 9: "Coming Out"
                 </div>
             </div>
             <div class="card mb-1 bg-white rounded">
                 <div class="card-body">
                 Lesson 10. The Magic of Dialogue
                 </div>
             </div>
             <div class="card  mb-1 bg-white rounded">
                 <div class="card-body">
                 Lesson 11.Writing the First Draft: How to Look like a
Pro
                 </div>
             </div>
             <div class="card mb-1 bg-white rounded">
                 <div class="card-body">
                 Lesson 12. “San Nicolas”: From Workshop to Award-
Winning Play
                 </div>
             </div>

             <div class="card mb-1 bg-white rounded">
                 <div class="card-body">
                 Lesson 13. Revising Your Play Into Production
                 </div>
             </div>
             <div class="card mb-1 bg-white rounded">
                 <div class="card-body">
                 Bonus Feature: Backstage Pass
                 </div>
             </div>
         </div>

     </div>

 </div>


 <div class="row mt-5 justify-content-center">
     <div class="col-lg-6 d-flex justify-content-center m-lg-0 mx-5 mb-0">
         <h2 class="font-weight-bold"> Reviews </h2>
     </div>
 </div>
 <div class="row justify-content-center">
     <div class="col-lg-6 d-flex justify-content-center m-lg-0 mx-5 mb-0">
         <p style="text-align:center;"> What our participants say about the program </p>
     </div>
 </div>

 <div class="row my-lg-5 my-sm-2 mb-5">
     <div class="col-lg-3">
     </div>
     <div class="card col-lg-6 d-flex justify-content-center m-lg-0 m-5">
         <div class="card-body">

             <div class="row">
                 <div class="col-lg-1 mt-1">
                     <img src="{{ asset('images/testimonial-miggy.png') }}" class="rounded-circle img-fluid">

                 </div>
                 <div class="col-lg-11 col-sm">
                     <p class="card-title  mb-0"> Migy Obina</p>
                     <p class="card-subtitle  text-muted mt-0 mb-2"> Banker </p>
                     <p class="card-text ">“I felt like I’m having a Master's degree on playwriting! I
                         went to workshops on screenwriting and I'm fascinated that it's different from
                         playwriting - although
                         we still follow character, we still follow conflict, we still follow resolution. And
                         the way Rody presented the theories, the ideas, it’s simplified na parang, ‘A,
                         hindi ko pala kailangan ito’. Simple ang pagkakapresenta.”</p>
                 </div>
             </div>
         </div>
     </div>
     <div class="col-lg-3">
     </div>
 </div>
 <!--Form-->
 <div class="row bg-danger sticky-item justify-content-center" style="width: 102%;">
    


         <button type="submit" class="btn btn-lg btn-light btn-outline-danger font-weight-bold">
             Enroll now
         </button>

   
 </div>
 <div class="row bg-danger justify-content-center" style="z-index: 3;">
     <div class="col-md-8">
         <div class="card bg-danger border-0">
             <div class="card-header bg-danger pt-5">
                 <h5 class="text-white text-center font-weight-bold">Get started with Pelikulove online classes
                     about
                     the arts!</h5>
             </div>
             <div class="card-body">
                 <form method="POST" action="{{ route('register') }}">
                     @csrf
                     <div class="form-group row">
                         <div class="col-md-6 offset-md-3">
                             <label for="name"
                                 class="col-form-label text-md-right text-white  font-weight-bold">{{ __('Username') }}</label>
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
                         <div class="col-md-6 offset-md-3">
                             <label for="email"
                                 class="col-form-label text-white font-weight-bold">{{ __('E-Mail') }}</label>
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
                         <div class="col-md-6 offset-md-3">
                             <label for="password"
                                 class="col-form-label text-white font-weight-bold">{{ __('Password') }}</label>
                             <input id="password" type="password"
                                 class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                                 required>
                             @if ($errors->has('password'))
                             <span class="invalid-feedback">
                                 <strong>{{ $errors->first('password') }}</strong>
                             </span>
                             @endif
                         </div>
                     </div>

                     <div class="form-group row mb-4">
                         <div class="col-md-6 offset-md-3">
                             <label for="password-confirm"
                                 class="col-form-label text-white font-weight-bold">{{ __('Confirm Password') }}</label>
                             <input id="password-confirm" type="password" class="form-control"
                                 name="password_confirmation" required>
                         </div>
                     </div>
                     @if(config('settings.reCaptchStatus'))
                     <div class="justify-content-center form-group row">
                         <div class="col-md-8 offset-md-2">
                             <div class="g-recaptcha" data-sitekey="{{ config('settings.reCaptchSite') }}"></div>
                         </div>
                     </div>
                     @endif
                     <div class="form-group row mb-3">
                         <div class="col-md-6 offset-md-3 text-center ">
                             <button type="submit" class="btn btn-lg btn-light btn-outline-danger font-weight-bold">
                                 {{ __('Register') }}
                             </button>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-md-8 offset-md-2">
                             <div
                                 style="width: 100%; height: 20px; border-bottom: 1px solid white; text-align: center; margin-bottom: 25px;">
                                 <span class="text-white"
                                     style="font-size: 1em;  position: relative; top: .5em; background-color: #dc3545; padding: 0 10px;">
                                     or
                                 </span>
                             </div>
                             @include('partials.socials-icons')
                         </div>
                     </div>
                 </form>
             </div>
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