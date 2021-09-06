@extends('layouts.app')
		
@section('template_title')
   Courses Admin
@endsection

@section('template_fastload_css')
@endsection

@section('content')
   <div class="container">  
        <div class="row d-flex flex-row">
        	<div class="card shadow bg-white rounded">
				<div class="card-header">
					Courses Available	

                    <div class="btn-group pull-right btn-group-xs">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                            <span class="sr-only">
                                Show Courses Admin Menu
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{url('/courses-admin/create')}}">
                                <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                                Create New Course
                            </a>
                        </div>
                    </div>
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
                                                <h4> 
                                                    <a class="text-dark" href="{{url('/course/'.$course->id.'/show')}}">
                                                        {{$course->title}}
                                                    </a>
                                                </h4>
                                                <p id="course_title" class=""> 
                                                    {{$course->description}}
                                                </p>
                                                <p id="course_title" class=""> 
                                                    {{$course->information}}
                                                </p>
                                            </div>                                	
                                        </div>
                                        <div class="col-lg-2 col-md-12 text-align-center">
                                            <a class="btn btn-sm btn-info btn-courses mb-2" href="{{url('/courses-admin/'.$course->id)}}" role="button">
                                                View Course
                                            </a>
                                            {{-- <a class="btn btn-sm btn-info btn-courses mb-2" href="{{url('/course/'.$course->id.'/enroll')}}" role="button">
                                                Edit Course
                                            </a>
                                            <a class="btn btn-sm btn-info btn-courses mb-2" href="{{url('/course/'.$course->id.'/enroll')}}" role="button">
                                                Edit Instructor
                                            </a>
                                            <a class="btn btn-sm btn-info btn-courses mb-2" href="{{url('/course/'.$course->id.'/enroll')}}" role="button">
                                                Edit Lessons
                                            </a> --}}
                                            @if (\App\Models\LearnerCourse::ifCourseIDIsNotUsed($course->id))
                                                <a class="btn btn-sm btn-info btn-courses mb-2" href="#" role="button">
                                                    Delete Course
                                                </a>
                                            {{-- @else 
                                                <button type="button" class="btn btn-primary btn-courses mb-2">
                                                    Enrolled
                                                </button>
                                            @endif
                                                <a class="btn btn-sm btn-outline-info btn-courses mb-2" href="{{url('/course/'.$course->id.'/show')}}" role="button">
                                                    View Course
                                                </a>
                                                <a class="btn btn-sm btn-outline-info btn-courses" href="#" role="button">
                                                    Invite Friends
                                                </a> --}}
                                            @endif
                                        </div>
                                    </div> <!--row-->
                                </div><!--card-body-->
                            </div><!--card-->
       			        @endforeach 
                    </div><!--card-body-->
  				@endif	 
			</div><!--card-->     
        </div>	<!-- row -->	 
    </div><!-- container -->
@endsection

@section('footer_scripts')

@endsection
