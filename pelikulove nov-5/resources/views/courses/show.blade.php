@extends('layouts.app')

@section('template_title')
{{ $course->title }}
@endsection

@section('template_fastload_css')
@endsection

@section('content')

<div class="container-fluid bg-dark">
    <div class="container bg-dark" style="max-width: 81.1%;">
        <div class="row d-flex flex-row">
            <div class="col-md-12 col-lg-12 px-0">
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @for ($index = 0; $index < sizeOf($courseSlideshow); $index++)       
                            @if (isset($courseSlideshow[$index]->thumbnail))                                     
                                <div class="carousel-item @if ($index == 0) active @endif">
                                    @if (isset($courseSlideshow[$index]->url))
                                        <a href="{{ $courseSlideshow[$index]->url }}" target="_blank" rel="noopener noreferrer">
                                    @endif
                                    
                                    <img class="d-block" style="max-width: 100%;" 
                                    src="{{ asset('images/slideshows/' . $courseSlideshow[$index]->thumbnail) }}" alt="Slide {{ $index+1 }}">

                                    @if (isset($courseSlideshow[$index]->url))
                                        </a>
                                    @endif
                                </div>
                            @elseif (isset($courseSlideshow[$index]->video))
                                <div class="carousel-item @if ($index == 0) active @endif" oncontextmenu="return false;">
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <video id="player" controls playsinline
                                            poster="{{ asset($courseSlideshow[$index]->video_thumbnail)}}">
                                            <source src="{{$courseSlideshow[$index]->video}}" />
                                        </video>
                                    </div>
                                </div>                                    
                            @endif
                        @endfor

                        {{-- <div class="carousel-item active">
                            <a href="https://forms.gle/BKjCtqxUfpc2djTF6" target="_blank" rel="noopener noreferrer">
                                <img class="d-block w-100" src="{{ asset('images/slideshows/Blackbox_Call_for_Filipino_Art_Mentors_2.jpg') }}" alt="Third slide">
                            </a>
                        </div>

                        <div class="carousel-item ">
                            <img class="d-block w-100" src="{{ asset('images/slideshows/POV.jpg') }}" alt="Third slide">
                        </div>

                        <div class="carousel-item" oncontextmenu="return false;">
                            <div class="embed-responsive embed-responsive-16by9">
                                <video id="player" controls playsinline
                                    poster="{{ asset($courseSlideshow->video_thumbnail})}}">
                                    <source src="{{$courseSlideshow->video}}" />
                                </video>
                            </div>
                        </div> --}}
                    </div>
                    <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev"
                    style="top: 50%; transform: translateY(-50%); height: 50vh; max-height: 50%;">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next"
                    style="top: 50%; transform: translateY(-50%); height: 50vh; max-height: 50%;">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>


                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row d-flex flex-row">
        <div class="card shadow bg-white rounded">
            <div class="card-header" id="courseProfile">
                {{$course->title}}
            </div>
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
                            @if ($i->instructor->id == 1)
                            <a class="text-danger" href="{{url('/mentor/'.$i->instructor->id.'/show')}}">
                                Read more about {{$i->instructor->name}} here
                            </a>
                            @endif

                        </div>

                    </div>
                    <div class="col-lg-3 col-md-12">@if ($cnt == 0)
                        <div class="text-lg-left text-md-left mt-3">
                            @php $enrolled = null; $pending = false; @endphp
                            @if (Auth::check())
                                @php 
                                    $enrolled = \App\Models\LearnerCourse::getEnrollment($course->id, Auth::user()->id);
                                @endphp
                                @if (isset($enrolled)) @php $service =
                                \App\Models\Service::find($enrolled->order->service_id); @endphp<button type="button"
                                    class="btn btn-success btn-courses mb-2">Currently Enrolled</button>
                                <p class="mb-0 text-center">Since <span
                                        class="font-weight-bold">{{ \Carbon\Carbon::parse($enrolled->created_at)->format('M j, Y') }}</span>
                                </p>
                                <p class="text-center">Until <span
                                        class="font-weight-bold">{{ \Carbon\Carbon::parse($enrolled->created_at)->addDays($service['duration'])->format('M j, Y') }}</span>
                                </p>

                                @elseif (\App\Models\Order::ifPending($course->id, Auth::user()->id)) <button type="button"
                                    class="btn btn-warning btn-courses mb-2"> With Pending Enrollment</button>
                                @else
                                <a class="btn  btn-info btn-courses mb-2" href="{{url('/course/'.$course->id.'/enroll')}}"
                                    role="button"> <i class="fa fa-sign-in"></i> Enroll Now</a>

                                @endif

                            @else
                            <a class="btn  btn-info btn-courses mb-2" href="{{url('/register')}}" role="button"> <i class="fas fa-sign-in-alt"></i> Enroll Now</a>

                            @endif


                            <!--<a class="btn  btn-outline-info btn-courses" href="#" role="button"><i class="fa fa-envelope"></i> Invite Friends</a>-->

                        </div>
						@endif 
						@php $cnt++; @endphp
                    </div>

                </div>
                <!--row-->
                @endforeach
                <hr>
            </div>
            <!--card-body-->
            @endif

            <div class="row mx-4">
            @if (isset($course->sneakpeak_title))
                <div>
                    <h3>
                        {{ $course->sneakpeak_title }}
                    </h3>
                    <p>
                        {{ $course->sneakpeak_content }}
                    </p>     
                </div>
            @endif
            <div class="embed-responsive embed-responsive-16by9" oncontextmenu="return false;">
                <video id="player" controls playsinline
                    poster="{{ asset('images/patikim-thumbnail.png')}}">
                        <source src="{{ $course->sneakpeak_video }}"
                        type="video/mp4" />
                </video>
                </div>   
            </div>

            @if (count($lessons ) > 0)
            <div class="card-body">
                <hr>
                @foreach ($lessons as $key => $lesson)
                <div class="card lesson-card mb-3 bg-white rounded">

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <h3>{{ $lesson['title']}} <span class="small font-weight-light">{{$lesson['duration']}}
                                        min</span>@if (isset(Auth::user()->id) && isset($completed[$course->id][Auth::user()->id][$key]))<span class="small float-right text-success"><i class="fas fa-check-circle"></i></span>@endif</h3>
                                <p class="pt-2">{{ $lesson['description'] }} </p>
                                @if ($lesson['count'] && Auth::check())
                                @if ($lesson['premium'] == 0 || isset($enrolled))
                                <a title="View Lessons" class="mb-2 text-danger stretched-link"
                                    href="{{url('/lesson/'.$key.'/topic/'.$lesson['first'].'/show')}}"> <i
                                        class="fa fa-files-o"></i> View {{$lesson['count']}} Topic(s) &raquo;</a>
                                @else
                                {{$lesson['count']}} Topic(s) &raquo;
                                @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    <!--card-body-->
                </div>
                <!--card-->
                @endforeach
            </div>
            <!--card-body-->
            @endif


        </div>
        <!--card-->
    </div> <!-- row -->
</div><!-- container -->

@endsection

@section('footer_scripts')

    <script>
        $('#myCarousel').carousel({
            interval: 3000
        }).on('slide.bs.carousel', function() {
            document.getElementById('player').pause();
        });
    </script>

@endsection