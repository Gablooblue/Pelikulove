@extends('layouts.app')
		
@section('template_title')
   Showing Course: {!! $course->title !!}
@endsection

@section('template_fastload_css')
@endsection

@section('content')
  <div class="container">  
    <div class="row d-flex flex-row">
      <div class="card shadow bg-white rounded">
        <div class="card-header bg-secondary text-white text-md-left">
          <div class="row d-flex justify-content-between ml-2 mr-2">      
            <h3>
              Showing Course: {!! $course->title !!}
            </h3>
            <a href="{{ url('/courses-admin') }}" class="btn btn-light" 
            data-toggle="tooltip" data-placement="left" title="Courses">
              <i class="fa fa-fw fa-reply" aria-hidden="true"></i>
              <span class="hidden-sm hidden-xs">
                Back to 
              </span>
              <span class="hidden-xs">
                Courses
              </span>
            </a>
          </div>
        </div>

        {{-- Carousel Start --}}
        <div class="card-body">	
          <div class="card shadow bg-white rounded">
            <div class="card-header">   
              <h4 class="text-center">
                <strong>
                  Carousel Slides
                </strong>                    
              </h4>
              <hr>
            </div>
            <div class="d-flex flex-row mt-n4">
              <div class="card-body">
                <div class="row m-1">
                  <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                      <div class="carousel-item active" oncontextmenu="return false;">
                          <video id="player" controls playsinline style="max-width: 100%;"
                              poster="{{ asset('images/patikim-thumbnail.png')}}">
                              <source src="{{$course->video}}" />
                          </video>
                          {{-- <video id="player" controls autoplay playsinline
                            poster="{{ asset('images/patikim-thumbnail.png')}}">
                            <source src="{{$course->video}}" />
                          </video> --}}
                      </div>
                      <div class="carousel-item">
                          <img class="d-block" style="max-width: 100%;" src="{{ asset('images/slider-photo-1.jpg') }}" alt="Second slide">
                      </div>

                      <div class="carousel-item">
                          <img class="d-block" style="max-width: 100%;" src="{{ asset('images/slider-photo-2.jpg') }}" alt="Third slide">
                      </div>

                      <div class="carousel-item">
                          <img class="d-block" style="max-width: 100%;" src="{{ asset('images/slider-photo-4.png') }}" alt="Fourth slide">
                      </div>

                      <div class="carousel-item">
                          <img class="d-block" style="max-width: 100%;" src="{{ asset('images/slider-photo-5.jpg') }}" alt="Fifth slide">
                      </div>
                    </div>
                    <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                  </div>
                </div>     
                <div class="row m-1">
                  <a class="btn btn-block btn-info" href="#" role="button">
                      Edit Carousel
                  </a>
                </div>
              </div>
            </div>
          </div><!--card-->
        </div><!--card-body-->    
        {{-- Carousel End --}}      

        {{-- Course Description Start --}}     
        <div class="card-body">	
          <div class="card shadow bg-white rounded">
            <div class="card-header">   
              <h4 class="text-center">
                <strong>
                  Course Description
                </strong>                    
              </h4>
              <hr>
            </div>
            <div class="d-flex flex-row mt-n4">
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
                    <a class="btn btn-sm btn-info btn-courses mb-2" href="#" role="button">
                        Edit Course
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
                    @endif
                  </div>
                </div>
              </div> <!--row-->
            </div><!--card-body-->
          </div><!--card-->
        </div><!--card-body-->
        {{-- Course Description End --}}
            
        {{-- Instructors Description Start --}}    
        <div class="card-body">	   
          <div class="card shadow bg-white rounded">  
            <div class="card-header">   
              <h4 class="text-center">
                <strong>
                  Instructor(s) Description
                </strong>                    
              </h4>
              <hr>
            </div>
            <div class="d-flex flex-row mt-n4">     
              @php $cnt=0; @endphp
              @if (count($instructors) > 0)
                <div class="card-body">
                  @foreach ($instructors as $i)
                    <div class="row mb-4">
                      <div class="col-lg-3 col-md-12">
                        <img class="img-fluid" src="{{asset('images/courses/'.$course->thumbnail)}}" alt="Rody Vera"
                            class="instr-image-courses" width="300px">
                      </div>
                      <div class="col-lg-6 col-md-12">
                        <div class="text-lg-left text-md-left">
                            <h4 class="card-title">{{$i->instructor->name}}</h4>
                            <p>{!! $i->instructor->description !!}</p>
                            <p>{!! $i->instructor->credentials !!}</p>
                            <a class="text-danger" href="{{url('/mentor/'.$i->instructor->id.'/show')}}">Read more about
                                {{$i->instructor->name}} here</a>
                        </div>
                      </div>
                      <div class="col-lg-3 col-md-12">
                        <a class="btn btn-sm btn-info btn-courses mb-2" href="#" role="button">
                            Edit Instructor
                        </a>
                        <a class="btn btn-sm btn-info btn-courses mb-2" href="#" role="button">
                            Change Instructor
                        </a>
                      </div>
                    </div> <!--row-->
                    <hr>
                    @php $cnt++; @endphp
                  @endforeach
                </div> <!--card-body-->
              @endif
            </div>
          </div><!--card-->
        </div><!--card-body-->
        {{-- Instructors Description End --}}

        {{-- Sneak Peek Start --}}
        <div class="card-body">	
          <div class="card shadow bg-white rounded">
            <div class="card-header">   
              <h4 class="text-center">
                <strong>
                  Sneak Peak Contents
                </strong>                    
              </h4>
              <hr>
            </div>
            <div class="d-flex flex-row mt-n4">
              <div class="card-body">
                <div class="row m-1">
                    <h3>
                      Sneak Peek: Rody Vera On Choosing A Topic (excerpt from Lesson 2)
                    </h3>
                    <p>
                      Get a glimpse of the Rody Vera Online Playwriting Course! Watch Now!
                    </p>
                </div>    
                <div class="row m-1">
                  <div oncontextmenu="return false;">
                    <video id="player" controls playsinline style="max-width: 100%;"
                      poster="{{ asset('images/patikim-thumbnail.png')}}">
                      <source src="{{$course->video}}" />
                    </video>
                  </div>
                </div>     
                <div class="row m-1">
                  <a class="btn btn-block btn-info" href="#" role="button">
                      Edit Sneak Peek
                  </a>
                  @if (\App\Models\LearnerCourse::ifCourseIDIsNotUsed($course->id))
                    <a class="btn btn-block btn-info" href="#" role="button">
                      Delete Course
                    </a>
                  @endif
                </div>
              </div>
            </div>
          </div><!--card-->
        </div><!--card-body-->    
        {{-- Sneak Peek End --}}  
              
        {{-- Lessons' Information Start --}}    
        <div class="card-body">	   
          <div class="card shadow bg-white rounded">  
            <div class="card-header">   
              <h4 class="text-center">
                <strong>
                  Lessons' Information
                </strong>     
                <div class="btn-group pull-right btn-group-xs mt-n2 mr-2">
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                    <span class="sr-only">
                      Show Lessons Admin Menu
                    </span>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#">
                      <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                      Create New Lesson
                    </a>
                  </div>
                  <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#">
                      <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                      Rearrange Lessons
                    </a>
                  </div>
                </div>                                     
              </h4>
              <hr>
            </div>
            <div class="d-flex flex-row mt-n4">    
              @if (count($lessons ) > 0)
                <div class="card-body">
                  @foreach ($lessons as $key => $lesson)
                    <div class="card lesson-card mb-3 bg-white rounded">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-lg-12 col-md-12">
                            <h3>
                              {{$lesson['title']}} 
                              <span class="small font-weight-light">
                                {{$lesson['duration']}} min
                              </span>
                            </h3>
                            <p class="pt-2">
                              {{ $lesson['description'] }} 
                            </p>
                            @if ($lesson['count'] && Auth::check())
                              {{-- @if ($lesson['premium'] == 0 || count($enrolled) > 0 )
                                <a title="View Lessons" class="mb-2 text-danger stretched-link"
                                    href="{{url('/lesson/'.$key.'/topic/'.$lesson['first'].'/show')}}"> 
                                    <i class="fa fa-files-o"></i> View {{$lesson['count']}} Topic(s) &raquo;
                                </a>
                              @else --}}
                                {{$lesson['count']}} Topic(s) &raquo;
                              {{-- @endif --}}
                            @endif
                          </div>
                        </div>     
                        <div class="row ml-1 mr-1 mt-3">
                          <a class="btn btn-block btn-info" 
                          href="{{url('/courses-admin/' . $course->id . '/lesson/' . $key)}}" role="button">
                              View Lesson
                          </a>
                        </div>
                      </div> <!--card-body-->
                    </div> <!--card-->
                  @endforeach
                </div> <!--card-body-->
              @endif
            </div>
          </div><!--card-->
        </div><!--card-body-->
        {{-- Lessons' Information End --}}
      </div><!--card-->     
    </div>	<!-- row -->	 
  </div><!-- container -->
@endsection

@section('footer_scripts')

@endsection
