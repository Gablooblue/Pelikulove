@extends('layouts.app')

@section('template_title')
Saluhan for {{$course->title}}
@endsection

@section('template_fastload_css')
@endsection

@section('content')




<div class="container">
    <div class="row d-flex flex-row">
    	<div class="col-md-12 col-lg-12">
        	<div class="card shadow bg-white rounded">
            	<div class="card-header @role('admin', true) bg-secondary text-white text-md-left @endrole">
               	Saluhan for  {{$course->title}}
				   <div class="pull-right">
					   <a href="{{ route('submissions.catalog') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="top" title="Back to Saluhan Catalog">
						   <i class="fa fa-fw fa-reply" aria-hidden="true"></i>
						   Back to Saluhan Catalog
					   </a>
					   
				   </div>
            	</div>
				@if (count($lessons ) > 0)
					<div class="card-body">
				
						@foreach ($lessons as $key => $lesson)
						<div class="card mb-3 bg-white rounded">

							<div class="card-body">
								<div class="row">
									<div class="col-lg-12 col-md-12">
										<h4><a href="{{url('/submissions/show/'.$key)}}" class="text-dark" >{{ $lesson['title']}}</a> <a href="{{route('submissions.create', ['lesson_id' => $key])}}" class="btn btn-sm btn-danger float-right"><i class="fa fa-upload"></i> Upload</a></h4>
									</div>    
								</div> 
								@if (count($submissions[$key]) > 0) 
								<span class="mt-3 pt-1 mb-2">Recent Uploads</span>
								<div class="row">      
								
									@foreach ($submissions[$key] as $s)
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
												<div class="font-weight-bold my-0 py-0"> <a class="text-dark" href="{{url('/profile/'.$s->user->name)}}">{{ $s->user->name }}</a> <span class="pl-2 small font-italic"> {{\Carbon\Carbon::createFromTimeStamp(strtotime($s->created_at))->diffForHumans()}}</span></div>
												@if (count($s->user->roles) > 0) @foreach ($s->user->roles as $user_role)
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
													
												@endforeach @endif
												<div class=""><a href="{{route('submission.show',['id'=> $s->id])}}" class="text-danger" title="{{$s->title}}">
												@if ($s->file != ""  && strpos($s->file, ".pdf") !== false)
												<i class="fa fa-file-pdf-o"></i> 
												@elseif  ($s->file != ""  && ( strpos($s->file, ".doc") !== false || strpos($s->file, ".docx") !== false) )
												<i class="fa fa-file"></i> 
												@else
												<i class="fa fa-file-image-o"></i>	@endif
												<span class="ml-1">{{ str_limit($s->title, 20, '...') }}</span>
												<br>	
												@php
												$canDownload = false;
													if (Auth::user()->hasRole(['admin', 'pelikulove'])) {
														$canDownload = true;
													} else if (Auth::user()->hasRole('rl-reader')) {
														$lesson = \App\Models\Lesson::find($s->lesson_id);
														if ($lesson->course_id == 3) {
															$canDownload = true;
														}
													} else if (Auth::user()->hasRole('mentor')) {
														$instructor = App\Models\Instructor::where('user_id', Auth::user()->id)
														->first();
														if (isset($instructor)) {					
															$instructorCourse = App\Models\InstructorCourse::where('course_id', $course->id)
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
												</a></div>
												@php $c = \App\Models\Comment::getAllComments($s->id, "submission"); @endphp
												@if (count($c) > 0) <div class="float-right text-danger"><i class="fa fa-comments"></i> {{count($c)}}</div>@endif
											</div>
										</div>
									</div>	
									@endforeach	
									<div class="col-md-12 col-lg-12">
										
										<div class="media mt-1 mb-2">
										
										<a href="{{url('/submissions/show/'.$key)}}" class="btn btn-sm btn-outline-danger ml-2" ><i class="fa fa-files-o"></i> View More</a> </div>
									</div>
							</div> 
							@endif
						
						</div>
						<!--card-body-->
					</div>
					<!--card-->

					@endforeach
            </div>
			@else
			<div class="card-body">
				<div class="container text-center">
					<h3>
						No lessons yet
					</h3>
				</div>
			</div>
            <!--card-body-->
            @endif


        	</div>
        	<!--card-->
        </div>	
    </div> <!-- row -->
</div><!-- container -->

@endsection

@section('footer_scripts')
@endsection