@php

    $levelAmount = 'level';

    if (Auth::User()->level() >= 2) {
        $levelAmount = 'levels';

    }

@endphp


<div class="card shadow p-3 bg-white rounded">
	<div class="card-header @role('admin', true) bg-info text-white @endrole">
		 Welcome {{ Auth::user()->name }}!
	</div>
    <div class="card-body">
    	<div class="row">
            <div class="col-lg-1 col-md-2 col-sm-2 mt-2">
            	
                <img src="@if (Auth::User()->profile->avatar_status == 1) {{ Auth::User()->profile->avatar }} @else {{ Gravatar::get(Auth::User()->email) }} @endif" alt="{{ Auth::User()->name }}" class="user-avatar">

             </div>

            <div class="col-lg-11 col-md-10 col-sm-10">
                <div class="ml-3">
                	<p class="mb-0 mt-2" id="name" style="font-weight: bold;">@if (Auth::user()->first_name) {{ Auth::user()->first_name }} @endif @if (Auth::user()->last_name) {{ Auth::user()->last_name }} @endif</p>
                	<p class="mb-1" id="email">{{ Auth::user()->email }} </p>
                	<p class="mb-1" id="bio">{{ Auth::user()->profile->bio }}</p>
                	<p id="user_since">User since {{ \Carbon\Carbon::parse(Auth::user()->created_at)->format('M Y') }}</p>
              		@php $activity = Auth::user()->activities->where('View home','description')->max('created_at')->first();@endphp @if (count($activity) > 0)<p id="user_since">Last Logged in {{\Carbon\Carbon::createFromTimeStamp(strtotime($activity->created_at))->diffForHumans()}}</p>@endif
                 	{!! HTML::icon_link(URL::to('/profile/'.Auth::user()->name.'/edit'), '', trans('titles.editProfile'), array('class' => 'btn btn-info')) !!}

                </div>
             </div>
        </div>
        
        @if (count($ecourses) > 0)
        
		<hr>
      
       	<h5 class="card-title">Courses Currently Enrolled</h5>
       	@foreach ($ecourses as $ecourse)
      
		<div class="card d-flex flex-row m-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4 col-md-12">
						<img id="rody_id" src="{{asset('images/courses/'.$ecourse->thumbnail)}}" alt="Rody Vera" class="instr-image-courses">
                    </div>
                    <div class="col-lg-4 col-md-12">
                   		<div class="text-lg-left text-md-left">
                        <h5> <a class="text-dark" href="{{url('/course/'.$ecourse->id.'/show')}}">{{$ecourse->title}}</a></h5>
                         <p id="course_title" class=""> {{$ecourse->description}}</p>     
                         @php $enrolled = \App\Models\LearnerCourse::getEnrollment($ecourse->id, Auth::user()->id); $service = \App\Models\Service::find($enrolled->order->service_id) ;@endphp
                         @if (count($enrolled) > 0)
                         <p class="mb-0">Enrolled since <span class="font-weight-bold">{{ \Carbon\Carbon::parse($enrolled->created_at)->format('M j, Y') }}</span></p>  
                         <p>Valid until <span class="font-weight-bold">{{ \Carbon\Carbon::parse($enrolled->created_at)->addDays($service['duration'])->format('M j, Y') }}</span></p>     
                         @endif 
                    	</div>
					</div>
					<div class="col-lg-4 col-md-12 text-align-center">
                        <div class="text-lg-center">
                            <p class="mb-0"> Lessons Completed</p>
                            <p id="course_progress" class=" mt-0 landingH2" style="color: red;"> 01/{{count(\App\Models\Lesson::getLessons($ecourse->id))}}</p>
                        </div>
                    	<div>
						
						<a class="btn btn-sm btn-info btn-courses mb-2" href="{{url('/course/'.$ecourse->id.'/show')}}" role="button">Resume Learning</a>
						
                    	</div>
                	</div>	
            	</div><!--row-->
       		 </div> <!--card-body-->
        </div><!--card-->
			
		@endforeach 
		
		@endif
		
		@if (count($allcourses) > 0)
		<hr>
		
       	@foreach ($allcourses as $course)@php $cnt = 0; @endphp
       	
        @if (!\App\Models\LearnerCourse::ifEnrolled($course->id, Auth::user()->id)) 
        @if ($cnt == 0) <h5 class="card-title">Courses Available</h5>  @php $cnt++; @endphp @endif
		      				
		<div class="card d-flex flex-row shadow bg-white rounded">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-md-12">
					<img class="img-fluid" src="{{asset('images/courses/'.$course->thumbnail)}}" alt="Rody Vera" class="instr-image-courses" width="225px">
					<div class="mt-3">
										
                	</div>
                </div>
                    <div class="col-lg-7 col-md-12">
                        <div class="text-lg-left text-md-left">
                                        <h4> <a class="text-dark" href="{{url('/course/'.$course->id.'/show')}}">{{$course->title}}</a></h4>
                                        <p id="course_title" class=""> {{$course->description}}</p>
                                        <p id="course_title" class=""> {{$course->information}}</p>
                        </div>
                                	
					</div>
					<div class="col-lg-2 col-md-12 text-align-center">
						@if (\App\Models\Order::ifPending($course->id, Auth::user()->id)) <button type="button" class="btn btn-sm btn-warning btn-courses mb-2"> With Pending Enrollment</button>
               			@else <a class="btn  btn-sm btn-info btn-courses mb-2" href="{{url('/course/'.$course->id.'/enroll')}}" role="button"> <i class="fa fa-sign-in"></i> Enroll Now</a>
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
	  
    </div><!--card-body-->
</div><!--card-->
<!-- Modals -->
    <div class="modal fade" id="enrollModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          
        </div>
      </div>
    </div>