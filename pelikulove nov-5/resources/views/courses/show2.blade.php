@extends('layouts.app')

@section('template_title')
{{ $course->title }}
@endsection

@section('template_fastload_css')
@endsection

@section('content')

<div class="container-fluid bg-dark">
    <div class="row d-flex flex-row">
        <div class="col-md-12 col-lg-12 px-0">
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">

                    <div class="carousel-item active" oncontextmenu="return false;">

                        <div class="embed-responsive embed-responsive-16by9">
                            <video id="player" controls autoplay playsinline
                                poster="{{ asset('images/patikim-thumbnail.png')}}">
                                <source src="{{$course->video}}" />
                            </video></div>
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="{{ asset('images/slider-photo-1.jpg') }}" alt="Second slide">
                    </div>

                    <div class="carousel-item">
                        <img class="d-block w-100" src="{{ asset('images/slider-photo-2.jpg') }}" alt="Third slide">
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
    </div>
</div>



<div class="container">
    <div class="row d-flex flex-row">
        <div class="card shadow bg-white rounded">
            <div class="card-header">
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
                            <a class="text-danger" href="https://learn.pelikulove.com/mentor/{{$i->instructor->id}}/show">Read more about
                                {{$i->instructor->name}} here</a>

                        </div>

                    </div>
                    <div class="col-lg-3 col-md-12">@if ($cnt == 0)
                        <div class="text-lg-left text-md-left mt-3">
                            @php $enrolled = null; $pending = false; @endphp
                            @if (Auth::check())
                            @php $enrolled = \App\Models\LearnerCourse::getEnrollment($course->id, Auth::user()->id);
                            @endphp
                            @if (count($enrolled) > 0) @php $service =
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
      <div>
      <h3>Sneak Peek: Rody Vera On Choosing A Topic (excerpt from Lesson 2)</h3>
    <p>Get a glimpse of the Rody Vera Online Playwriting Course! Watch Now!
</p>
     
      </div>
      <div class="embed-responsive embed-responsive-16by9" oncontextmenu="return false;">
                            <video id="player" controls playsinline
                                poster="{{ asset('images/patikim-thumbnail.png')}}">
                                <source src="https://cdn.orangefix.xyz/repo/rcvopc-patikim-video.mp4"
                                    type="video/mp4" />
                            </video></div>
   
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
                                @if ($lesson['premium'] == 0 || count($enrolled) > 0 )
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