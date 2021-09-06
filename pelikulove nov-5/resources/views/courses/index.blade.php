@extends('layouts.app')
		
@section('template_title')
    PELIKULOVE | Courses
@endsection

@section('template_fastload_css')
@endsection

@section('content')
	
   <div class="container">  
        <div class="row d-flex flex-row">
        	<div class="card shadow bg-white rounded">
				<div class="card-header @role('admin', true) bg-secondary text-white text-md-left @endrole">
					Courses Available	
				</div>
				
				@if (count($courses) > 0)
    			<div class="card-body">	
    				@foreach ($courses as $course)
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
						@if (!\App\Models\LearnerCourse::ifEnrolled($course->id, Auth::user()->id))
						<a class="btn btn-sm btn-info btn-courses mb-2" href="{{url('/course/'.$course->id.'/enroll')}}" role="button">Enroll Now</a>
						@else 
               				<button type="button" class="btn btn-primary btn-courses mb-2">Enrolled</button>
                		@endif
               			<a class="btn btn-sm btn-outline-info btn-courses mb-2" href="{{url('/course/'.$course->id.'/show')}}" role="button">View Course</a>
						<a class="btn btn-sm btn-outline-info btn-courses" href="#" role="button">Invite Friends</a>
										   	   	
                            		
                    </div>
                </div> <!--row-->
            </div><!--card-body-->
		</div><!--card-->
       			@endforeach 
  				@endif
 				 
				
				 </div><!--card-body-->
				
			</div><!--card-->     
        </div>	<!-- row -->	 
    </div><!-- container -->

@endsection

@section('footer_scripts')
@endsection
