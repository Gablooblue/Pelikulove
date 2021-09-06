@extends('layouts.app')

@section('template_title')
Saluhan for {{$lesson->title}}
@endsection

@section('template_fastload_css')
@endsection

@section('content')




<div class="container">
    <div class="row d-flex flex-row">
    	<div class="col-lg-12 col-md-12">
        	<div class="card shadow bg-white rounded">
            	<div class="card-header @role('admin', true) bg-secondary text-white text-md-left @endrole">
              	 Saluhan for  {{$lesson->title}}
           		</div>
           		<div class="card-body">
               		<div class="card mb-3 bg-white rounded">

                    	<div class="card-body">
                    		 <div class="row">
						    	<div class="col-lg-12 col-md-12">
						    		<nav aria-label="breadcrumb">
  									<ol class="breadcrumb">
    								<li class="breadcrumb-item"><a href="{{url('/home')}}" class="text-danger"><i class="fa fa-home"></i> Home</a></li>
    								<li class="breadcrumb-item"><a href="{{url('/submissions/'.$lesson->course->id)}}" class="text-danger" >{{$lesson->course->title}}</a></li>
   									<li class="breadcrumb-item active" aria-current="page" class="">{{$lesson->title}}</li>
  									</ol>
									</nav>
						
									<h4>{{$lesson->title}} <span class="float-right"><a href="{{route('submissions.create', ['lesson_id' => $lesson->id])}}" class="btn btn-sm btn-danger"><i class="fa fa-upload"></i> Upload</a>
								</span></h4>
                            		<p>{{$lesson->description}}</p>
                            		
                            		<hr>
                            		<h5 class="">Uploads:</h5>
                            	</div>	
                         	</div>
                        	<div class="row">  

								@if (count($submissions ) > 0)
								@foreach ($submissions as $s)  
									<div class="submission col-md-3 col-lg-3 col-sm-6">   	
										<div class="media mt-1 pb-3">
											<a class="text-dark" href="{{url('/profile/'.$s->user->name)}}">
												@php													 
													$gravatar = Gravatar::get($s->user->email);
													if ($s->user->profile->avatar_status == 1) 
														$picture = $s->user->profile->avatar;
													else if (isset($gravatar))
														$picture = Gravatar::get($s->user->email);
													else 
														$picture = asset('images/default_avatar.png');
												@endphp
												<img src="{{ $picture }}" alt="{{ $s->user->name }}" class="user2-avatar-nav mt-1">
											</a>

											<div class="media-body mt-0 pt-0">
												<div class="font-weight-bold my-0 py-0"> 
													<a class="text-dark" href="{{url('/profile/'.$s->user->name)}}">
														{{ $s->user->name }}
													</a> 
													<span class="pl-2 small font-italic"> 
														{{\Carbon\Carbon::createFromTimeStamp(strtotime($s->created_at))->diffForHumans()}}
													</span>
												</div>
												@if (count($s->user->roles) > 0) 
													@foreach ($s->user->roles as $user_role)
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
														<div class="small mt-n1 py-0">{{ $user_role->name }}</div> 																
													@endforeach 
												@endif
											
												<div>
													<a href="{{route('submission.show',['id'=> $s->id])}}" class="text-danger" title="{{$s->title}}">
														@if ($s->file != ""  && strpos($s->file, ".pdf") !== false)
															<i class="fa fa-file-pdf-o"></i> 
														@elseif  ($s->file != ""  && (strpos($s->file, ".doc") !== false || strpos($s->file, ".docx") !== false) )
															<i class="fa fa-file"></i> 
														@elseif  ($s->file != ""  && strpos($s->file, ".pdf") !== true)
															<i class="fa fa-file-image-o"></i>
														@endif

														<span class="ml-1">{{ str_limit($s->title, 20, '...') }}</span> 
														<br>														

														@php
															$canDownload = false;
															$lesson = \App\Models\Lesson::find($s->lesson_id);
															if (Auth::user()->hasRole(['admin', 'pelikulove'])) {
																$canDownload = true;
															} else if (Auth::user()->hasRole('rl-reader')) {
																if ($lesson->course_id == 3) {
																	$canDownload = true;
																}
															} else if (Auth::user()->hasRole('mentor')) {
																$instructor = \App\Models\Instructor::where('user_id', Auth::user()->id)
																->first();
																if (isset($instructor)) {					
																	$instructorCourse = \App\Models\InstructorCourse::where('course_id', $lesson->course_id)
																	->where('instructor_id', $instructor->id)
																	->first();
																	if (isset($instructorCourse)) {		
																		$canDownload = true;
																	}
																}
															} 
														@endphp
														
														@if ($canDownload)											
															<a href="{{ route('submission.download', $s->uuid) }}">
																<button class="btn btn-sm btn-danger m-1 ml-2"
																role="button"> 	
																	<strong>
																		Download
																		<i class="fa fa-download fa-fw" aria-hidden="true"></i>
																	</strong>
																</button>
															</a>
														@endif
													</a>
												</div>
												@php $c = \App\Models\Comment::getAllComments($s->id, "submission"); @endphp
												@if (count($c) > 0) <div class="float-right text-danger"><i class="fa fa-comments"></i> {{count($c)}}</div>@endif
												</a>
											</div> <!-- media-body -->
										</div>  <!-- media -->
									</div>	
								@endforeach	 
								@else 
									<div class="card-body text-center">
										<h5>
											No submissions yet
										</h5>
									</div>
								@endif   
							</div> <!-- row -->

                    	</div>
                    	<!--card-body-->
                	</div>
               		<!--card-->
                
           	 	</div>
				<!--card-body-->
			</div> <!--card-->
   		</div> <!-- col -->
    </div> <!-- row -->
    
    <!-- Modals -->
    <div id="showModal" class="modal fade">
		<div class="modal-dialog modal-lg">
    		<div class="modal-content">
            	<div class="modal-header">
            	    <h4 class="modal-title"></h4>
                	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
           
            	</div>
            	<div class="modal-body">
                	<p>Loading...</p>
            	</div>
            	<div class="modal-footer">
                	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                
           	 	</div>
   			 </div>
    	</div>
	</div>
</div><!-- container -->

@endsection

@section('footer_scripts')
@include('scripts.show-file')
@endsection