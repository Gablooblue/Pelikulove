@extends('layouts.app')

@section('template_title')
     Rody Vera's Playwriting Course
@endsection

@section('template_fastload_css')
@endsection

@section('content')

	<div class="container-fluid">


        <!--Top slider-->
        <div class="row d-flex flex-row">
        <div class="col-md-12 col-lg-12">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item"
                                src="https://www.youtube.com/embed/zirN4XnZGa0"></iframe>
                        </div>


                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="{{ asset('images/slider-photo-1.jpg') }}" alt="Second slide">

                    </div>

                    <div class="carousel-item">
                        <img class="d-block w-100" src="{{ asset('images/slider-photo-2.jpg') }}" alt="Third slide">

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
		<div class="row bg-info justify-content-center">
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
                            	<label for="name" class="col-form-label text-md-right text-white  font-weight-bold">{{ __('Username') }}</label>
								<input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
								 @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group row">
                        	<div class="col-md-6 offset-md-3">
                            	<label for="email" class="col-form-label text-white font-weight-bold">{{ __('E-Mail') }}</label>
							 	<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
							 	 @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                           </div>
                    	</div>

                        <div class="form-group row">
                        	<div class="col-md-6 offset-md-3">
                            	<label for="password" class="col-form-label text-white font-weight-bold">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
								 @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                        	<div class="col-md-6 offset-md-3">
                            	<label for="password-confirm" class="col-form-label text-white font-weight-bold">{{ __('Confirm Password') }}</label>
								<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                        	</div>
                        </div>
                        <div class="form-group row mb-3">
                            <div class="col-md-6 offset-md-3 text-center ">
                                <button type="submit" class="p-2 px-6 btn btn-lg btn-light btn-outline-info font-weight-bold">
                                    {{ __('Register') }}
                                </button>
                            </div>    
						</div>
                       	<div class="row">
                        	<div class="col-md-8 offset-md-2">
                            	<div style="width: 100%; height: 20px; border-bottom: 1px solid white; text-align: center; margin-bottom: 25px;">
  									<span class="text-white" style="font-size: 1em; position: relative; top: .5em; background-color: #17a2b8; padding: 0 10px;" >
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
   

        <!--TESTIMONALS last priority-->
        <div class="row p-5 mx-3">
            <section class="text-center my-5 p-1">

                <div class="testimonalTextContainer">
                    <h2 class="mb-5 text-info font-weight-bold">Testimonials</h2>
                </div>
                <div class="row">
                    <!--Grid column-->
                    <div class="col-lg-4 col-md-6 mb-md-0 mb-4">
                        <!--Card-->
                        <div class="card testimonial-card">
                            <!--Background color-->
                            <div class="card-up blue-gradient">
                            </div>
                           
                            <div class="card-body">
                             <!--Avatar-->
                             <div class="avatar mx-auto mb-3 white">
                             <img src="{{ asset('images/testimonial-carlo.png') }}" class="rounded-circle img-fluid" style="width: 150px">
                            </div>
                                <!--Name-->
                                <p class="card-title landingH2 mb-0"> Carlo Tarobal</p>
                                <p class="card-subtitle landingP text-muted mt-0 mb-2"> 31, Asst. Director (for film)
                                </p>
                                <p class="card-text landingP text-left">“Hindi pa ako nakakapag-workshop ever sa
                                    pagsusulat so ako,
                                    sa mga previous works ko, sobrang sabog ng ideas. It takes me a long time to
                                    organize
                                    yung mga dapat ilagay mga kung anu-anong anek. So ngayon, masaya kasi ang dami kong
                                    na-pick up
                                    from my co-workshoppers and of course, kay sir Rody. Ang dami kong natutunan.
                                    Parang f*ck, ang galing!”.</p>
                            </div>
                        </div>
                        <!--Card-->
                    </div>
                    <!--Grid column-->
                    <!--Grid column-->
                    <div class="col-lg-4 col-md-12 mb-lg-0 mb-4">
                        <!--Card-->
                        <div class="card testimonial-card">
                            <!--Background color-->
                            <div class="card-up info-color"></div>
                           
                            <div class="card-body">
                             <!--Avatar-->
                             <div class="avatar mb-3 mx-auto white">
                             <img src="{{ asset('images/testimonial-miggy.png') }}" class="rounded-circle img-fluid" style="width: 150px">
                            </div>
                                <!--Name-->
                                <p class="card-title landingH2 mb-0"> Migy Obina</p>
                                <p class="card-subtitle landingP text-muted mt-0 mb-2"> 45, Banker </p>
                                <p class="card-text landingP text-left">“I felt like I’m having a Master's degree on
                                    playwriting! I
                                    went to workshops on
                                    screenwriting and I'm fascinated that it's different from playwriting - although
                                    we still follow character, we still follow conflict, we still follow resolution. And
                                    the way Rody presented the theories, the ideas, it’s simplified na parang, ‘A,
                                    hindi ko pala kailangan ito’. Simple ang pagkakapresenta.”</p>
                            </div>
                        </div>
                        <!--Card-->
                    </div>
                    <!--Grid column-->



                    <!--Grid column-->
                    <div class="col-lg-4 col-md-6">
                        <!--Card-->
                        <div class="card testimonial-card">
                            <!--Background color-->
                            <div class="card-up indigo"></div>
                           
                            <div class="card-body">
                             <!--Avatar-->
                             <div class="avatar mb-3 mx-auto white">
                             <img src="{{ asset('images/testimonial-jmee.png') }}" class="rounded-circle img-fluid" style="width: 150px">
                            </div>
                                <!--Name-->
                                <p class="card-title landingH2 mb-0"> J-Mee Katanyag</p>
                                <p class="card-subtitle landingP text-muted mt-0 mb-2">  31, TV Series Scriptwriter/Actor
                                </p>
                                <p class="card-text landingP text-left">"Minsan kasi kailangan mong i-exercise ‘yung
                                    senses mo as a writer, as an
                                    artist...Maganda ‘yung course kasi mas nagiging clear na nagbago ka nga din
                                    siguro as a writer kumpara noong bata ka kasi iba 'yung mga sensibilities mo.
                                    Ma-ri-realize mo na ‘A, may nagbago na.’ or puwedeng, ‘A, gano’n pa rin pala
                                    ako.’ So ‘yung workshop nagiging pamantayan kung kamusta ka na bilang
                                    isang estudyante ng arts or ng pagsusulat."</p>
                            </div>
                        </div>
                        <!--Card-->
                    </div>
                    <!--Grid column-->

                </div>
                <!-- Grid row -->

            </section>
            <!-- Section: Testimonials v.1 -->
        </div>

        <!--Ready to learn div-->
        <div class="row py-4 my-5">
        	 <div class="col-md-12">
                <h2 class="text-info font-weight-bold text-center"> Ready to learn about Playwriting?</h2>
             </div>
             <div class="col-md-6 offset-md-3 text-center ">   
                <button type="button" class="btn btn-lg btn-info sign-up-btn"
                    style=" box-shadow: 0px 1px 15px rgba(0, 104, 145, 0.3);">Sign Up</button>
            </div>
           
        </div>

        <!--Topics and excerpt-->
        <div class="row my-4 px-4">
			 <div class="col-md-12">
                <h2 class="text-info mb-5 font-weight-bold text-center"> Welcome to the Rody Vera Playwriting Course </h2>
            </div>
           
            <div class="col-lg-6 order-lg-1 order-2 column-topics">
                    <p class="topics-text">Topics <br> </p>

                    <ul class="list-text">
                        <!--
                        https://drive.google.com/drive/folders/1olmhwVceQI6VfucJ9_K4U7pAqm7ODYPW
                    -->
                        <li>Playwriting</li>
                        <li>What To Write About</li>
                        <li>Types of Character</li>
                        <li>Crafting the Character</li>
                        <li>Genre</li>
                        <li>Conflict</li>
                        <li>Premise</li>
                        <li>Structure/Plot</li>
                        <li>"Coming Out"</li>
                        <li>notes on Dialogue</li>
                        <li>Writing the First Draft</li>
                        <li>Script Reading and
                            Discussion of Miggy Obina’s “San
                            Nicolas”</li>
                        <li>Revising Your Play Unto
                            Production</li>
                    </ul>
                </div>

                <div class="col-lg-6 order-lg-2 order-1 mx-lg-0 mx-1 col-video justify-content-center">
                    <div class="column-right">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item"
                                src="https://www.youtube.com/embed/zirN4XnZGa0"></iframe>
                        </div>

                    </div>

              

            </div>
        </div>

        <!--Form-->

        <div class="row bg-danger justify-content-center">
        	<div class="col-md-8">
				<div class="card bg-danger border-0">
					<div class="card-header bg-danger pt-5">
						<h2 class="text-white text-center font-weight-bold">Get started with Pelikulove online classes about the arts</h2>
					</div>
					<div class="card-body">
						<form method="POST" action="{{ route('register') }}">
                        @csrf
						<div class="form-group row">
                        	<div class="col-md-6 offset-md-3">
                            	<label for="name" class="col-form-label text-md-right text-white  font-weight-bold">{{ __('Username') }}</label>
								<input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
								 @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group row">
                        	<div class="col-md-6 offset-md-3">
                            	<label for="email" class="col-form-label text-white font-weight-bold">{{ __('E-Mail') }}</label>
							 	<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
							 	 @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                           </div>
                    	</div>

                        <div class="form-group row">
                        	<div class="col-md-6 offset-md-3">
                            	<label for="password" class="col-form-label text-white font-weight-bold">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
								 @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                        	<div class="col-md-6 offset-md-3">
                            	<label for="password-confirm" class="col-form-label text-white font-weight-bold">{{ __('Confirm Password') }}</label>
								<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                        	</div>
                        </div>
                        <div class="form-group row mb-3">
                            <div class="col-md-6 offset-md-3 text-center ">
                                <button type="submit" class="btn btn-lg btn-light btn-outline-danger font-weight-bold">
                                    {{ __('Register') }}
                                </button>
                            </div>    
						</div>
                       	<div class="row">
                        	<div class="col-md-8 offset-md-2">
                            	<div style="width: 100%; height: 20px; border-bottom: 1px solid white; text-align: center; margin-bottom: 25px;">
  									<span class="text-white" style="font-size: 1em;  position: relative; top: .5em; background-color: #dc3545; padding: 0 10px;" >
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
@endsection

@section('footer_scripts')
@endsection
    
    