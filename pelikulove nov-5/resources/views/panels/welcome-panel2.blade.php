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
            	
                <img src="@if (Auth::User()->profile->avatar_status == 1) {{ Auth::User()->profile->avatar }} @else {{ Gravatar::get(Auth::User()->email) }} @endif" alt="{{ Auth::User()->name }}" class="user-avatar mt-n1">
                
             </div>

            <div class="col-lg-11 col-md-11 col-sm-11">
                <div class="ml-3">
                	<p class="mb-0 mt-2" id="name" style="font-weight: bold;">@if (Auth::user()->first_name) {{ Auth::user()->first_name }} @endif @if (Auth::user()->last_name) {{ Auth::user()->last_name }} @endif @foreach (Auth::user()->roles as $user_role)
                                                   @if ($user_role->name == 'Student')
                                                        @php $badgeClass = 'primary' @endphp
                                                    @elseif ($user_role->name == 'Admin' || $user_role->name == 'Manager' )
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
                	
                	<p class="mb-1" id="bio">{{ Auth::user()->profile->bio }}</p>
                	<p class="mb-1" id="user_since">
              			User since {{ \Carbon\Carbon::parse(Auth::user()->created_at)->format('M Y') }}</p>
              		<p class="mb-1">Enrolled at <span class="font-weight-bold">{{count($ecourses)}}</span> Course(s)</p>	
                 	
                </div>
             </div>
             
        </div>
        
        
        @if (count($mcourses) > 0 && Auth::user()->hasRole(['admin', 'manager', 'mentor']))
        <hr>
        @if (Auth::user()->hasRole('mentor')) <h5 class="card-title">Courses Currently Mentoring</h5>@endif
        @if (Auth::user()->hasRole('manager|admin')) <h5 class="card-title">Courses Available</h5>@endif
        
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
                     						 <p class="card-category text-success">Students</p>
                     						 <h3 class="card-title font-weight-bold text-success">{{count($value['students'])}}</h3>
                    						</div>
                  						</div>
                  						
                					
               	 					</div>
               	 				</div>	
               	 				<div class="card-footer ">
               					 	
               					 	<div class="stats">
                  					 <a class="mb-2 small float-right text-success"  href="{{url('/enrollees/'.$value['course']['id'])}}">View Students &raquo;</a>
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
                  					 <a class="mb-2 small float-right text-info"  href="{{url('/stats/'.$value['course']['id'])}}">View Stats &raquo;</a>
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
        
        
        @if (count($ecourses) > 0)
        
		<hr>
      
       	<h5 class="card-title">Courses Currently Enrolled</h5>
       	@foreach ($ecourses as $ecourse)
      
		<div class="card d-flex flex-row mt-3 mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4 col-md-12">
						<img id="rody_id" src="{{asset('images/courses/'.$ecourse->course->thumbnail)}}" alt="Rody Vera" class="instr-image-courses">
                    </div>
                    <div class="col-lg-6 col-md-12">
                   		<div class="text-lg-left text-md-left">
                          <p id="course_title" class=""> {{$ecourse->course->description}}</p>     
                         @php $enrolled = \App\Models\LearnerCourse::getEnrollment($ecourse->course->id, Auth::user()->id); $service = \App\Models\Service::find($enrolled->order->service_id) ;@endphp
                         @if (count($enrolled) > 0)
                         <p class="mb-0">Enrolled since <span class="font-weight-bold">{{ \Carbon\Carbon::parse($enrolled->created_at)->format('M j, Y') }}</span></p>  
                         <p>Valid until <span class="font-weight-bold">{{ \Carbon\Carbon::parse($enrolled->created_at)->addDays($service['duration'])->format('M j, Y') }}</span></p>     
                         @endif 
                    	</div>
					</div>
					<div class="col-lg-2 col-md-12 text-align-center">
                        <div class="text-lg-center">
                            <p class="mb-0"> Lessons Completed</p>
                            <p id="course_progress" class=" mt-0 landingH2" style="color: red;"> {{count($completed[$ecourse->course->id][Auth::user()->id])}}/{{count(\App\Models\Lesson::getLessons($ecourse->course->id))}}</p>
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
		
		
		@if (count($allcourses) > 0 && !Auth::User()->HasRole('manager'|'admin'))
		<hr>
		
       	@foreach ($allcourses as $course)@php $cnt = 0; @endphp
       	
        @if (!\App\Models\LearnerCourse::ifEnrolled($course->id, Auth::user()->id)) 
        @if ($cnt == 0) <h5 class="card-title">Courses Available</h5>  @php $cnt++; @endphp @endif
		      				
		<div class="card d-flex flex-row shadow bg-white rounded">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4 col-md-12">
					<img class="img-fluid" src="{{asset('images/courses/'.$course->thumbnail)}}" alt="Rody Vera" class="instr-image-courses" width="225px">
					<div class="mt-3">
										
                	</div>
                </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="text-lg-left text-md-left">
                                        <h4> <a class="text-dark" href="{{url('/course/'.$course->id.'/show')}}">{{$course->title}}</a></h4>
                                        <p id="course_title" class=""> {{$course->description}}</p>
                                        <p id="course_title" class=""> {{$course->information}}</p>
                        </div>
                                	
					</div>
					<div class="col-lg-2 col-md-12 text-align-center">
						@if (\App\Models\Order::ifPending($course->id, Auth::user()->id)) <button type="button" class="btn btn-sm btn-warning btn-courses mb-2"> With Pending Enrollment</button>
               			@else <a class="btn  btn-sm btn-info btn-courses mb-2" href="{{url('/course/'.$course->id.'/enroll')}}" role="button"> <i class="fas fa-sign-in-alt"></i> Enroll Now</a>
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