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
			<h5 class="card-title">Courses Currently Enrolled</h5>
			@foreach ($ecourses as $ecourse)						
				<div class="card d-flex flex-row mt-3 mb-3">
					<div class="card-body">
						<div class="row">
							<div class="col-lg-4 col-md-12">
								<img id="rody_id" src="{{asset('images/courses/'.$ecourse->course->thumbnail)}}" alt="" class="instr-image-courses">
							</div>
							<div class="col-lg-6 col-md-12">
								<div class="text-lg-left text-md-left"> 
								<h4> <a class="text-danger" href="{{url('/course/'.$ecourse->course->id.'/show')}}">{{$ecourse->course->title}}</a> </h4> 
									
								<p id="course_title" class=""> {{$ecourse->course->description}}</p>

								@php $enrolled = \App\Models\LearnerCourse::getEnrollment($ecourse->course->id, Auth::user()->id);@endphp
								@if (isset($enrolled))
								@php $service = \App\Models\Service::find($enrolled->order->service_id); @endphp
								<p class="mb-0">Enrolled since <span class="font-weight-bold">{{ \Carbon\Carbon::parse($enrolled->created_at)->format('M j, Y') }}</span></p>  
								<p>Valid until <span class="font-weight-bold">{{ \Carbon\Carbon::parse($enrolled->created_at)->addDays($service['duration'])->format('M j, Y') }}</span></p>     
								@endif 
								</div>
							</div>
							<div class="col-lg-2 col-md-12 text-align-center">
								<div class="text-lg-center">
									<p class="mb-0"> Lessons Completed</p>
									@php
										$lessonsCompleted = isset($completed[$ecourse->course->id][Auth::user()->id]);
										if (!$lessonsCompleted) $lessonsCompleted = 0;
									@endphp
									<p id="course_progress" class=" mt-0 landingH2" style="color: red;"> {{ $lessonsCompleted }}/{{count(\App\Models\Lesson::getLessons($ecourse->course->id))}}</p>
									<a class="btn btn-sm btn-danger btn-courses mb-2" href="{{url('/course/'.$ecourse->course->id.'/show')}}" role="button"> Resume Learning &raquo;</a>
								</div>
								<div>
										
								</div>
							</div>	
						</div><!--row-->
					</div> <!--card-body-->
				</div><!--card-->		
			@endforeach 
		@endif
		
		{{-- Non-Admin Dashboard --}}
		@if (count($allcourses) > 0 && !Auth::User()->HasRole('pelikulove'|'admin'))
			<hr>	
			<h5 class="card-title">Courses Available</h5>  		
			@foreach ($allcourses as $course)
				@if (!\App\Models\LearnerCourse::ifEnrolled($course->id, Auth::user()->id)) 							
					<div class="card d-flex flex-row shadow bg-white rounded">
						<div class="card-body">
							<div class="row">
								<div class="col-lg-4 col-md-12">
									<img id="rody_id" src="{{asset('images/courses/'.$course->thumbnail)}}" alt="Rody Vera" class="instr-image-courses">
								</div>
								<div class="col-lg-6 col-md-12">
									<div class="text-lg-left text-md-left">
										<h4> <a class="text-dark" href="{{url('/course/'.$course->id.'/show')}}">{{$course->title}}</a></h4>
										<p id="course_title" class=""> {{$course->description}}</p>
										<p id="course_title" class=""> {{$course->information}}</p>
									</div>												
								</div>
								<div class="col-lg-2 col-md-12 text-align-center">
									@if (\App\Models\Order::ifPending($course->id, Auth::user()->id)) 
										<button type="button" class="btn btn-sm btn-warning btn-courses mb-2"> With Pending Enrollment</button>
									@else 
										<a class="btn  btn-sm btn-info btn-courses mb-2" href="{{url('/course/'.$course->id.'/enroll')}}" role="button"> <i class="fas fa-sign-in-alt"></i> Enroll Now</a>
									@endif	
									<a class="btn btn-sm btn-info btn-courses mb-2" href="{{url('/course/'.$course->id.'/show')}}" role="button">View Course</a>									
									<!-- <a class="btn btn-sm btn-outline-info btn-courses" href="#" role="button">Invite Friends</a>-->	
								</div>
							</div> <!--row-->
						</div><!--card-body-->
					</div><!--card-->
				@endif		
			@endforeach
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
							@for ($index = 0; $index < 6; $index++)
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