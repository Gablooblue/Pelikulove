@php
    $levelAmount = 'level';

    if (Auth::User()->level() >= 2) {
        $levelAmount = 'levels';

    }
@endphp


<div class="card shadow p-3 bg-white rounded">
	<div class="card-header bg-info text-white">
		 Welcome {{ Auth::user()->name }}! {!! HTML::icon_link(URL::to('/profile/'.Auth::user()->name.'/edit'), '', trans('titles.editProfile') . " &raquo;", array('class' => 'small mt-1 float-right text-white')) !!}
				
	</div>
    <div class="card-body">
    	<div class="row">
            <div class="col-lg-1 col-md-2 col-sm-2 mt-2">    
				@php     
					$gravatar = Gravatar::get(Auth::user()->email);		
					if (isset(Auth::user()->profile->avatar) && Auth::user()->profile->avatar_status == 1) {
						$picture = Auth::user()->profile->avatar;
					}
					else if (isset($gravatar))
						$picture = Gravatar::get(Auth::user()->email);
					else 
						$picture = asset('images/default_avatar.png');
				@endphp
				@if (isset($picture))
					<img src="{{ $picture }}" 
					alt="{{ Auth::User()->name }}" class="user-avatar mt-n1 bg-white" 
					style="border: thick solid aliceblue;">
				@else
					<img src="{{ asset('images/default_avatar.png') }}" 
					class="user-avatar mt-n1 bg-white" 
					style="border: thick solid aliceblue;">
				@endif      
             </div>

            <div class="col-lg-11 col-md-11 col-sm-11">
                <div class="ml-3">
					<p class="mb-0 mt-2" id="name" style="font-weight: bold;">
						@if (Auth::user()->first_name) 
							{{ Auth::user()->first_name }}
						@endif 
						@if (Auth::user()->last_name) 
							{{ Auth::user()->last_name }} 
						@endif 
						@foreach (Auth::user()->roles as $user_role)
							@if ($user_role->name == 'Student')
								@php $badgeClass = 'primary' @endphp
							@elseif ($user_role->name == 'Admin' || $user_role->name == 'Moderator' )
								@php $badgeClass = 'info' @endphp
							@elseif ($user_role->name == 'Mentor')
								@php $badgeClass = 'success' @endphp
							@elseif ($user_role->name == 'Unverified')
								@php $badgeClass = 'danger' @endphp
							@else
								@php $badgeClass = 'default' @endphp
							@endif
							<span class="badge badge-{{$badgeClass}}">{{ $user_role->name }}</span> 
						@endforeach</p>
                	<p class="mb-1" id="email">{{ Auth::user()->email }} </p>
					
					@if (isset(Auth::User()->profile->bio))
                		<p class="mb-1" id="bio">{{ Auth::user()->profile->bio }}</p>
					@endif
                	<p class="mb-1" id="user_since">
              			User since {{ \Carbon\Carbon::parse(Auth::user()->created_at)->format('M Y') }}</p>
              		<p class="mb-1">Enrolled at <span class="font-weight-bold">{{count($ecourses)}}</span> Course(s)</p>	
                </div>
             </div>
		</div>
		
		@if (!isset(Auth::user()->lastlogin))
			<div class="alert alert-info">	
				<button type="button" class="close" data-dismiss="alert">×</button>
				<h4 class="">
					<strong>
						Welcome to Pelikulove!
					</strong>
				</h4>
				<p>
					Share your work and get feedback from moderators and fellow students through the Saluhan Workspace, and immerse yourself in film and theater through the different offerings such as the Plays On Video, Short Films, Talks in the Lakambini series, and more - available on the platform.
				</p>
			</div>			
		@endif
		
		{{-- Admin Dashboard --}}
        @if (count($mcourses) > 0 && Auth::user()->hasRole(['admin', 'pelikulove', 'mentor']))
			<hr>
			@if (Auth::user()->hasRole('mentor')) 
				<h5 class="card-title">Courses Currently Mentoring</h5>
			@endif
			@if (Auth::user()->hasRole('pelikulove|admin')) 
				<h5 class="card-title">Courses Available</h5>
			@endif
			
			@foreach ($mcourses as $value)
				<div class="card d-flex flex-row mt-3 mb-3">
					<div class="card-body">
						<div class="row">
							<div class="col-lg-4 col-md-12">
								<img id="rody_id" src="{{asset('images/courses/'.$value['course']['thumbnail'])}}" alt="Instructor" class="instr-image-courses">
							</div>
							

							<div class="col-lg-8 col-md-12">
								<div class="row">
									<div class="col-md-12 text-lg-left text-md-left mb-3">
									<h4> <a class="text-danger" href="{{url('/course/'.$value['course']['id'].'/show')}}">{{$value['course']['title']}}</a> </h4> 
									</div>
									<div class="col-md-4 col-sm-4 col-xs-6">
										<div class="card card-stats">
										
										<div class="card-body ">
											<div class="row">
												<div class="col-3 col-md-3">
													<i class="fas fa-graduation-cap fa-lg text-center text-success"></i>
												</div>
												<div class="col-9 col-md-9">
													<div class="numbers">
													<p class="card-category text-success">Learners</p>
													<h3 class="card-title font-weight-bold text-success">{{count($value['students'])}}</h3>
													</div>
												</div>
												
											
											</div>
										</div>	
										<div class="card-footer ">
											
											<div class="stats">
											<a class="mb-2 small float-right text-success"  href="{{url('/enrollees/'.$value['course']['id'])}}">View Learners &raquo;</a>
											</div>
										</div> <!-- footer -->
										</div><!-- card -->
									</div><!-- col -->
										<div class="col-md-4 col-sm-4 col-xs-6">
										<div class="card card-stats">
										
										<div class="card-body ">
											<div class="row">
												<div class="col-3 col-md-3">
													<i class="fas fa-file-upload fa-lg text-center text-primary"></i>
												</div>
												<div class="col-9 col-md-9">
													<div class="numbers">
													<p class="card-category text-primary">Submissions</p>
													<h3 class="card-title font-weight-bold text-primary">{{$value['submissions']}}</h3>
													</div>
												</div>
												
											
											</div>
										</div>	
										<div class="card-footer ">
											
											<div class="stats">
											<a class="mb-2 small float-right text-primary" href="{{url('/submissions/'.$value['course']['id'])}}">View Submissions &raquo;</a>
											</div>
										</div> <!-- footer -->
										</div><!-- card -->
									</div><!-- col -->
										<div class="col-md-4 col-sm-4 col-xs-6">
										<div class="card card-stats">
										
										<div class="card-body ">
											<div class="row">
												<div class="col-3 col-md-3">
													<i class="fas fa-clipboard-check fa-lg text-center text-info"></i>
												</div>
												<div class="col-9 col-md-9">
													<div class="numbers">
													<p class="card-category text-success">Completed</p>
													<h3 class="card-title font-weight-bold text-info">{{$value['completed']}}</h3>
													</div>
												</div>
											</div>
										</div>	
										<div class="card-footer ">
											
											<div class="stats">
											<a class="mb-2 small float-right text-info"  href="{{url('/course/'.$value['course']['id'].'/stats')}}">View Stats &raquo;</a>
											</div>
										</div> <!-- footer -->
										</div><!-- card -->
									</div><!-- col -->
								</div><!-- row -->
							</div>   


						</div><!--row-->
					</div> <!--card-body-->
				</div><!--card-->
			@endforeach
        @endif
        
        {{-- Course List --}}
        @if (count($ecourses) > 0)        
			<hr>      
			<h5 class="card-title">My Courses</h5>
			@foreach ($ecourses as $ecourse)										
				<div class="card d-flex flex-row mt-3 mb-3">
					<div class="card-body">
						<div class="row">
							<div class="col-lg-4 col-md-12">
								<img class="w-100 mb-3" id="rody_id" src="{{asset('images/courses/'.$ecourse->course->thumbnail)}}" alt="" class="instr-image-courses">
							</div>
							<div class="col-lg-8 col-md-12">
								<div class="text-lg-left text-md-left"> 
									<h4> 
										<strong>
											<a class="text-danger" href="#">
												{{$ecourse->course->title}}
											</a> 
										</strong>
									</h4> 						

									<p id="course_title" class="">
									Since 1982, Dr. Ricky Lee has been conducting free scriptwriting workshops for beginning writers, producing hundreds of graduates who now work for TV and film<br>
									<br>
									This workshop will be conducted in a period of 8 weeks via Zoom. The Zoom link can be accessed through the Course Page. You may view the recordings of the weekly workshops through the Session Pages, where you can also find the lesson materials, submit your projects and join the discussion.<br>
									<br>
									The free workshop will run from August 12, 2020 until October 07, 2020.
									</p>

									<div class="row justify-content-center">
										
										<a href="{{ url('/course/3/show') }}" class="mb-2 mx-3 col-xl-5 col-lg-5 col-md-12 col-sm-12 col-xs-12">	
											<button class="btn btn-danger btn-dark text-light btn-courses" role="button"> 											
												<h5 class="m-1">
													<strong>
														Go to Course Page &raquo;
													</strong>	
												</h5>
											</button>
										</a>
										
										<a href="{{ url('/mentor/5/show') }}" class="mb-2 mx-3 col-xl-5 col-lg-5 col-md-12 col-sm-12 col-xs-12">
											<button class="btn btn-danger btn-dark text-light btn-courses" role="button"> 											
												<h5 class="m-1">
													<strong>
														About Dr. Ricky Lee &raquo;
													</strong>
												</h5>
											</button>
										</a>

									</div>
								</div>
							</div>
						</div><!--row-->
					</div> <!--card-body-->
				</div><!--card-->		
			@endforeach 
			
			<div class="card border-0">	
				{{-- <div class="container">						 --}}
					<div class="row mb-3 mt-2">
						<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12 mb-3">
							<div class="card row justify-content-center mx-1">
								<div class="row justify-content-center py-4">
									<h5 class="col-12 text-center">
										<strong>
											How to Use
										</strong>
									</h5>	
									
									<a href="{{ route('course.guidelines') }}" target="_blank" class="">	
										<button class="btn btn-danger mt-2 mb-2"
										role="button"> 	
											<strong>
												Read Guidelines
											</strong>
										</button>
									</a>
								</div>
							</div>
						</div>

						<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12 mb-3">
							<div class="card row justify-content-center mx-1">
								<div class="row justify-content-center py-4">
									<h5 class="col-12 text-center">
										<strong>
											Saluhan Workspace
										</strong>
									</h5>	
									
									<a href="{{ url('/submissions/3') }}" class="">	
										<button class="btn btn-danger mt-2 mb-2" 
										role="button"> 	
											<strong>
												Submit Project
											</strong>
										</button>
									</a>
								</div>
							</div>
						</div>

						<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12 mb-3">
							<div class="card row justify-content-center mx-1">
								<div class="row justify-content-center py-4">
									<h5 class="col-12 text-center">
										<strong>
											Tambayan Forums
										</strong>
									</h5>	
										
									<a href="{{ url('/forum/22-ricky-lee-workshop') }}" class="">								
										<button class="btn btn-danger mt-2 mb-2"
										role="button"> 	
											<strong>
												Join Discussion
											</strong>
										</button>
									</a>
								</div>
							</div>
						</div>

						<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-xs-12 mb-3">
							<div class="card row justify-content-center mx-1">
								<div class="row justify-content-center py-4">
									<h5 class="col-12 text-center">
										<strong>
											Help Us Improve
										</strong>
									</h5>	
										
									<a href="https://docs.google.com/forms/d/1dEcGawxurezwl2mel8oHDUsmLtRVDnYyNT_QxULoBsk/edit?fbclid=IwAR1-jvByRnkD2mSwqdEQUD10eEZFghQ5blhI9QbXtdP0zVQLzkCn2qUBEhY" 
									class="" target="_blank">
										<button class="btn btn-danger mt-2 mb-2" 
										role="button"> 	
											<strong>
												Give Feedback
											</strong>
										</button>
									</a>
								</div>
							</div>
						</div>
						
					</div>
				{{-- </div>		 --}}
			</div>

			<div class="">				
				<img id="" src="{{asset('images/courses/rk-quote-1.jpg')}}" 
				alt="Ricky-Lee-Quote" class="w-100">				
			</div>

			<div id="resources-and-materials">
				<hr>
				<h5 class="card-title">Resources and Materials</h5>
			</div>

			
			
			<div class="card border-0">	
				{{-- <div class="container">						 --}}
					<div class="row mb-3 mt-2">
						<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 mb-3">
							<div class="card row justify-content-center mx-1">
								<div class="row justify-content-center py-4">
									<h5 class="col-12 text-center">
										<strong>
											Session 1
										</strong>
										<br>
										<span class="small">
											August 12, 2020
										</span>
									</h5>	
									
									<a href="{{ url('lesson/20/topic/49/show') }}" class="">	
										<button class="btn btn-danger mt-2 mb-2"
										role="button"> 	
											<strong>
												View Materials
											</strong>
										</button>
									</a>
								</div>
							</div>
						</div>

						<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 mb-3">
							<div class="card row justify-content-center mx-1">
								<div class="row justify-content-center py-4">
									<h5 class="col-12 text-center">
										<strong>
											Session 2
										</strong>
										<br>
										<span class="small">
											August 26, 2020
										</span>
									</h5>	
									
									<a href="{{ url('lesson/21/topic/56/show') }}" class="">	
										<button class="btn btn-danger mt-2 mb-2"
										role="button"> 	
											<strong>
												View Materials
											</strong>
										</button>
									</a>
								</div>
							</div>
						</div>

						<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 mb-3">
							<div class="card row justify-content-center mx-1">
								<div class="row justify-content-center py-4">
									<h5 class="col-12 text-center">
										<strong>
											Session 3
										</strong>
										<br>
										<span class="small">
											September 09, 2020
										</span>
									</h5>	
										
									<a href="{{ url('lesson/26/topic/62/show') }}" class="">								
										<button class="btn btn-danger mt-2 mb-2"
										role="button"> 	
											<strong>
												View Materials
											</strong>
										</button>
									</a>
								</div>
							</div>
						</div>
						
					</div>
				{{-- </div>		 --}}
			</div>		

		@endif
		
		{{-- Vod Dashboard --}}
		@if (isset($vodCategories))		
		<hr>
		<h5 class="card-title">Blackbox</h5>  
		<!-- category 1  -->
		<div class="card-body shadow bg-white rounded">
			<div class="section">
				@foreach ($categoryVods as $categoryVod)  	
				<!-- POV category Title Start -->
					<div class="row mb-2 d-flex justify-content-between mr-3 ml-3">
						<div class="row">
							<h4 class="mr-3" style="font-weight:bold;">
								{!! $categoryVod->first()->name !!}
							</h4>
						</div>
						<div class="mt-1 pb-1">
							<a class="row" href="{{ url('/blackbox') }}">
								<h5>     
									View more 
								</h5>
								<i class="fa fa-angle-double-right fa-lg ml-1 mt-1"></i>
							</a>
						</div>
					</div>
					<!-- POV category Title End  -->                                  
					<div class="section mt-3 mx-2">
						<!-- Category Vods Row  -->
						<div class="row">
							@for ($index = 0; $index < 3; $index++)
								@if (isset($categoryVod[$index])) 
									<div class="col-md-4 pd-2 mb-4 vod-body" data-toggle="popover" title="{{ $categoryVod[$index]->short_title }}" 
										value="{{ $categoryVod[$index]->duration }} {{ $categoryVod[$index]->year_released }}"
										data-content="{{ \Illuminate\Support\Str::limit($categoryVod[$index]->description_2, 250, $end='...') }}">
										<div class="position-relative"> 
											@php 
												if (Auth::check()) {
													$owned = \App\Models\VodPurchase::ifOwned($categoryVod[$index]->id, Auth::user()->id);
												}
												else {
													$owned = false;
												}
											@endphp
											<a href="{{url('blackbox/' . $categoryVod[$index]->id . '/watch')}}" 
												class="stretched-link" style="text-decoration:none;">
												<img class=" d-block w-100 mb-3" src="{{ asset('images/vods/'.$categoryVod[$index]->thumbnail) }}"
													style="border-radius:10px;" alt="{{ $categoryVod[$index]->short_title }}">
											</a>
											
											<div class="row justify-content-center mt-n4 position-relative">
												@if ($categoryVod[$index]->paid == 1)
													@if ($owned)
														<a href="#" class="mx-2 py-1 font-weight-bold btn btn-block rounded btn-info btn-vod" 
														style="font-size: 1.2em; background-color: cornflowerblue; border-color: cornflowerblue">
															Pay per view
														</a>      
													@else  
														<a href="#" class="mx-2 py-1 font-weight-bold btn btn-block rounded btn-info btn-vod" 
														style="font-size: 1.2em; background-color: cornflowerblue; border-color: cornflowerblue">
															Pay per view
														</a>      
													@endif    
												@else   
													<a href="#" class="mx-2 py-1 font-weight-bold btn btn-block rounded btn-info btn-vod" 
													style="font-size: 1.2em;">
														Watch Now    
													</a>                                                                
												@endif
											</div>

											<div class="mt-2">
												<h5 class="" style="text-align: center;">
													<strong >
														{{ $categoryVod[$index]->short_title }}
													</strong> 
													@if (isset($categoryVod[$index]->directors) && $categoryVod[$index]->category_id == 3)
														<br>
														<span class="small">
															@foreach ($categoryVod[$index]->directors as $director)
																@if ($loop->first)
																	Directed by: {{ $director->short_name }}
																@elseif ($loop->last)
																	<br>
																	and {{ $director->short_name }}
																@else
																	,
																	<br>
																	{{ $director->short_name }}
																@endif                                                                                        
															@endforeach
														</span>    
													@endif                                                            
												</h5>
											</div>
										</div>
									</div> 
								@endif 
							@endfor 
						</div>           
					</div>
					<!-- end of category contents  -->
					
					<hr class="mb-5 bg-info " style="border: 1px solid #17a2b8;">
				@endforeach 
			</div>
		</div>
	@endif	 

    </div><!--card-body-->
</div><!--card-->
<!-- Modals -->
<div class="modal fade" id="enrollModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
		
	</div>
	</div>
</div>

@section('videojs2')
    <script src="{{ asset('/js/moment.js') }}"></script>
	<script src='https://cdn.polyfill.io/v2/polyfill.min.js?features=es6,Array.prototype.includes,CustomEvent,Object.entries,Object.values,URL'></script>
	<script src='https://unpkg.com/plyr@3'></script>

	<script id="plyr_script" type="text/javascript">
		// Change the second argument to your options:
		// https://github.com/sampotts/plyr/#options

		const players = Array.from(document.querySelectorAll('.plyr-rk'));
	
		players.map(player => new Plyr(player, { 
		  captions: { 
			active: true, // show/hide subs on first play
			language: 'en' // default subs
		  },
		  autoplay: false,
		  controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'volume', 'settings', 'pip', 'airplay', 'fullscreen'],
		  settings: ['captions', 'speed'], 
		  keyboard: { 
			focused: true, 
			global: false 
		  },
		}));

		// var player;

		// document.addEventListener('ready', event => {
		// 	const playerstmp = event.detail.plyr;
		// 	window.players = playerstmp;
		// 	console.log(window.players);
		// });	
		
		$(document).ready(function(){
			var videoSrc = $(".plyr__video-wrapper > video > source");
			var trackSrc = $(".plyr__video-wrapper > video > track");

			var i;
			for (i = 0; i < videoSrc.length; i++) {
				// console.log(videoSrc[i]);
				videoSrc[i].src = '';
				videoSrc[i].remove();
			}

			// console.log($(players));
			
			// videoSrc[0].src = '';
			// trackSrc[0].src = '';
			// videoSrc[0].remove();
			// trackSrc[0].remove();
			
			// var thisScript = $("#plyr_script");
			// thisScript.remove();
			// console.log("wuwu");
			// console.log(window.players);
			// console.log("wuwu");
			// console.log(document.detail.plyr);
		});
		

		// // On Fullscreen
		// players[0].plyr.on('enterfullscreen', evt => {
		// 	if (isMobile()) {
		// 		screen.orientation.lock("landscape");
		// 	}
		// })

		// // On Exit Fullscreen
		// players[0].plyr.on('exitfullscreen', evt => {
		// 	if (isMobile()) {
		// 		screen.orientation.unlock();
		// 	}
		// })

		// // On Fullscreen
		// players[1].plyr.on('enterfullscreen', evt => {
		// 	if (isMobile()) {
		// 		screen.orientation.lock("landscape");
		// 	}
		// })

		// // On Exit Fullscreen
		// players[1].plyr.on('exitfullscreen', evt => {
		// 	if (isMobile()) {
		// 		screen.orientation.unlock();
		// 	}
		// })

		// // On Fullscreen
		// players[2].plyr.on('enterfullscreen', evt => {
		// 	if (isMobile()) {
		// 		screen.orientation.lock("landscape");
		// 	}
		// })

		// // On Exit Fullscreen
		// players[2].plyr.on('exitfullscreen', evt => {
		// 	if (isMobile()) {
		// 		screen.orientation.unlock();
		// 	}
		// })

		// // On Fullscreen
		// players[3].plyr.on('enterfullscreen', evt => {
		// 	if (isMobile()) {
		// 		screen.orientation.lock("landscape");
		// 	}
		// })

		// // On Exit Fullscreen
		// players[3].plyr.on('exitfullscreen', evt => {
		// 	if (isMobile()) {
		// 		screen.orientation.unlock();
		// 	}
		// })

		// // On Fullscreen
		// players[4].plyr.on('enterfullscreen', evt => {
		// 	if (isMobile()) {
		// 		screen.orientation.lock("landscape");
		// 	}
		// })

		// // On Exit Fullscreen
		// players[4].plyr.on('exitfullscreen', evt => {
		// 	if (isMobile()) {
		// 		screen.orientation.unlock();
		// 	}
		// })

		// // On Fullscreen
		// players[5].plyr.on('enterfullscreen', evt => {
		// 	if (isMobile()) {
		// 		screen.orientation.lock("landscape");
		// 	}
		// })

		// // On Exit Fullscreen
		// players[5].plyr.on('exitfullscreen', evt => {
		// 	if (isMobile()) {
		// 		screen.orientation.unlock();
		// 	}
		// })

		// // On Fullscreen
		// players[6].plyr.on('enterfullscreen', evt => {
		// 	if (isMobile()) {
		// 		screen.orientation.lock("landscape");
		// 	}
		// })

		// // On Exit Fullscreen
		// players[6].plyr.on('exitfullscreen', evt => {
		// 	if (isMobile()) {
		// 		screen.orientation.unlock();
		// 	}
		// })
		
		$(document).ready(function(){
		  $(".plyr__volume" ).prop("hidden", 0);
		  $(".plyr__control" ).prop("hidden", 0);		
		});
		
		$( ".plyr" ).click(function(){
		  $( ".plyr__volume" ).prop("hidden", 0);
		  $( ".plyr__control" ).prop("hidden", 0);
		});
	</script>
@endsection	

@section('footer_scripts')    
	<script>
		$(document).ready(function(){
			$('[data-toggle="popover"]').popover({
				placement: 'top',
				trigger: 'hover',
				animation: true,
				template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-badges row justify-content-center"></div><div class="popover-body"></div></div>'
			});  
            
            $('.vod-body').on('inserted.bs.popover', function (e) {         
                reSizePoppers();
            }) 
		}); 
    
		function isMobile() {
			let isMobile = window.matchMedia("only screen and (max-width: 767px)").matches;
			// let isMobile = window.matchMedia(`(max-device-${window.matchMedia('(orientation: portrait)').matches?'width':'height'}: ${670}px)`).matches

			return isMobile;
		} 

        function reSizePoppers() {
            if (isMobile()) {      
                // Expand Slideshow     
                $('.popover').css("width", "50%");   
                $('.popover').css("max-width", "50%"); 
                $('.popover').css("min-width", "0px");      
            } else { 
                // Contract Slideshow
                $('.popover').css("width", "21%");   
                $('.popover').css("min-width", "300px"); 
                $('.popover').css("max-width", "21%");             
            }
        }
	</script>
@endsection