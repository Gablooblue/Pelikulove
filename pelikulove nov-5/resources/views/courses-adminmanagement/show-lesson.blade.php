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
          <div class="row justify-content-between mr-2 ml-2">
            <h3>
              Showing Lesson: {!! $course->title !!}
            </h3>
            <div class="float-right">
              <a href="{{ url('/courses-admin') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="Back to Courses">
                <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                <span class="hidden-sm hidden-xs">
                  Back to 
                </span>
                <span class="hidden-xs">
                  Courses
                </span>
              </a>
              <br>
              <a href="{{ url('/courses-admin/' . $course->id) }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="Back to Course">
                <i class="fa fa-fw fa-reply" aria-hidden="true"></i>
                <span class="hidden-sm hidden-xs">
                  Back to 
                </span>
                <span class="hidden-xs">
                  Course
                </span>
              </a>
            </div>
          </div>
        </div>              
          {{-- Topic's Information Start --}}    
          <div class="card-body">	  
            <div class="card shadow bg-white rounded">
              <div class="card-header">   
                <h4 class="text-center">
                  <strong>
                    Showing Lesson: {!! $lesson->lorder!!}'s Topics
                  </strong> 
                  <div class="btn-group pull-right btn-group-xs mt-n2 mr-2">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                      <span class="sr-only">
                        Show Topic Admin Menu
                      </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item" href="#">
                        <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                        Create New Topic
                      </a>
                    </div>
                    <div class="dropdown-menu dropdown-menu-right">
                      <a class="dropdown-item" href="#">
                        <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                        Rearrange Topics
                      </a>
                    </div>
                  </div>                   
                </h4>
                <hr>
              </div>
              <div class="d-flex flex-row mt-n4">
                @if (isset($topics))
                  <div class="card-body">
                    @foreach ($topics as $topic)
                      <div class="card lesson-card mb-3 bg-white rounded">
                        <div class="card-body">
                          <div class="row justify-content-center">
                            <h4>
                              <strong>
                                Topic {!! $topic->torder !!}
                              </strong>
                            </h4>
                          </div>
                          <hr>
                          <div class="row">
                            <div class="col-lg-12 col-md-12">
                              <h4>
                                {!!$topic->title!!} 
                                <span class="small font-weight-light">                                  
                                  {!!$topic->duration!!}  min
                                </span>
                              </h4>
                              @if (isset($topic->vdesc))
                                <p class="pt-2">
                                  {!!$topic->vdesc!!} 
                                </p>
                              @endif
                            </div>
                          </div> 
                          
                          <div class="row m-1">
                            <div oncontextmenu="return false;">
                              <video id="player" controls playsinline style="max-width: 100%;"
                                poster="{{ asset('images/patikim-thumbnail.png')}}">
                                <source src="{{$topic->video}}" />
                              </video>
                            </div>
                          </div>

                          <div class="row ml-1 mr-1 mt-3">
                            <a class="btn btn-block btn-info" href="#}" role="button">
                                Edit Topic
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
          {{-- Topic's Information End --}}

        </div><!--card-->     
    </div>	<!-- row -->	 
  </div><!-- container -->
@endsection

@section('footer_scripts')

@endsection
