@extends('layouts.app')

@section('template_title')
Saluhan for {{$submission->lesson->title}} - {{$submission->title}} by {{$submission->user->name}}
@endsection

@section('template_fastload_css')
@endsection

@section('content')




<div class="container">
    <div class="row d-flex flex-row">
    	<div class="col-lg-12 col-md-12">
        	<div class="card shadow bg-white rounded">
            <div class="card-header @role('admin', true) bg-secondary text-white text-md-left @endrole">
               Saluhan for {{$submission->lesson->title}}  - {{$submission->title}} by {{$submission->user->name}}
            </div>
			@if (isset($submission))
            <div class="card-body">
               
               
                <div class="card mb-3 bg-white rounded">

                    <div class="card-body">
                    	 <div class="row">
						    <div class="col-lg-12 col-md-12">
						    	<nav aria-label="breadcrumb">
  								<ol class="breadcrumb">
    							<li class="breadcrumb-item"><a href="{{url('/home')}}" class="text-danger"><i class="fa fa-home"></i> Home</a></li>
    							<li class="breadcrumb-item"><a href="{{url('/submissions/'.$submission->lesson->course->id)}}" class="text-danger" >{{$submission->lesson->course->title}}</a></li>
    							<li class="breadcrumb-item"><a href="{{url('/submissions/show/'.$submission->lesson->id)}}" class="text-danger" >{{$submission->lesson->title}}</a></li>
   								
   								<li class="breadcrumb-item active" aria-current="page" class="">{{$submission->title}}</li>
  								</ol>
								</nav>
						
								
								<div class="media mt-1 mb-4">
									
									<a class="text-dark" href="{{url('/profile/'.$submission->user->name)}}">
										@php													 
											$gravatar = Gravatar::get($submission->user->email);
											if ($submission->user->profile->avatar_status == 1) 
												$picture = $submission->user->profile->avatar;
											else if (isset($gravatar))
												$picture = Gravatar::get($submission->user->email);
											else 
												$picture = asset('images/default_avatar.png');
										@endphp
										<img src="{{ $picture }}" alt="{{ $submission->user->name }}" class="user2-avatar-nav mt-1">
									</a>

  								 	<div class="media-body mt-0 pt-0">
     							 		<div class="font-weight-bold my-0 py-0"> <a class="text-dark" href="{{url('/profile/'.$submission->user->name)}}">{{ $submission->user->name }}</a> <span class="pl-2 small font-italic"> {{\Carbon\Carbon::createFromTimeStamp(strtotime($submission->created_at))->diffForHumans()}}</span></div>
     							  			@if (count($submission->user->roles) > 0) @foreach ($submission->user->roles as $user_role)
     							  				@if ($user_role->name == 'Student')
                                                        @php $badgeClass = 'primary' @endphp
                                                    @elseif ($user_role->name == 'Admin' || $user_role->name == 'Pelikulove' )
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
                                                   	
     							 	
                            			<p>{{$submission->description}}</p>
                            			<a href="#" data-toggle="modal" data-title="{{$submission->title}} by {{$submission->user->name}}" data-load-url="{{route('submission.view', ['uuid' => $submission->uuid])}}" data-target="#showModal" class="text-danger mb-2" title="{{$submission->title}}">
											@if ($submission->file != ""  && strpos($submission->file, ".pdf") !== false)
												<i class="fa fa-file-pdf-o"></i> 
											@elseif  ($submission->file != ""  && (strpos($submission->file, ".doc") !== false || 
													strpos($submission->file, ".docx") !== false) )
												<i class="fa fa-file"></i> 
											@else 
												<i class="fa fa-file-image-o"></i>
											@endif

											{{$submission->title}}										

											@php
												$canDownload = false;
												$lesson = \App\Models\Lesson::find($submission->lesson_id);
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
												<a href="{{ route('submission.download', $submission->uuid) }}">
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
										&nbsp; 
										@if ($submission->user_id ==  Auth::user()->id) 
											<a href="{{route('submission.edit',['id' => $submission->id])}}" class="btn btn-sm btn-outline-warning">
												<i class="fa fa-pencil"></i> Edit
											</a> 
										@endif
     							 		@if($submission->updated_at->gt($submission->created_at))
											 <div class="small mb-2">
												 Note: The owner uploaded the most recent file last {{ \Carbon\Carbon::parse($submission->updated_at)->format('j M Y h:i A')  }}.
											</div>
										@endif
										
     							 		<h5 class="mt-3"><i class="fa fa-comments"></i> Join Discussions</h5>
    	 						
                    					<hr>
                    			
                    			
    	 							<div id="displayComments">
                   					@include('submissions.commentsDisplay', ['comments' => \App\Models\Comment::getAllComments($submission->id, "submission"), 'topic_id' => $submission->lesson_id])
                   					</div>
   							
   								
                    				<form method="post" id="commentForm"> 
										@csrf
										<div class="form-group">
											<textarea class="form-control" name="body" placeholder="Type your comment here"></textarea>
											<input type="hidden" name="topic_id" value="{{ $submission->id }}" />
											<input type="hidden" name="parent_id" value="" />
											<input type="hidden" name="type" value="submission" />
										</div>
										<div class="form-group">																				
											<button type="submit" class="btn btn-sm btn-success" id="ajaxSubmit" disabled>
												<i id="reply-spinner" class="fa fa-spinner fa-spin" style="display: none;"></i>
												Submit
											</button>
										</div>
                    				</form>
                    				<div class="alert alert-danger alert-dismissable fade show" style="display:none;" role="alert">
   									<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  
    								<ul>
        							@foreach ($errors->all() as $error)
            						<li>{{ $error }}</li>
       								 @endforeach
    								</ul>
									</div>
    								</div> <!-- media-body -->
 								</div>  <!-- media -->
 								
							

                            </div>

						</div> <!-- row -->

                    </div>
                    <!--card-body-->
                </div>
                <!--card-->
                
            </div>
            <!--card-body-->
            @endif
	

        </div>
        <!--card-->
    </div> <!-- row -->
    
    <!-- Modals -->

	<div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="stitle" aria-hidden="true">
  		<div class="modal-dialog modal-lg" role="document">
    		<div class="modal-content">
      			<div class="modal-header">
      
            		<h4 class="modal-title" id="stitle"></h4>
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

@section('commentajax2')
<script>

	$(document).ready(function(){
		document.getElementById('ajaxSubmit').disabled=false;
		
		$("#ajaxSubmit").on('click', function(e){
  			e.preventDefault();
			$("#reply-spinner").css("display", "inline-block");
			document.getElementById('ajaxSubmit').disabled=true;
			
			console.log("clickity click click!");
			
  			$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        	});
       		var formdata = $('#commentForm').serialize(); 
        	
        
        	$.ajax({
                  url: "{{url("/comment/store2") }}",
                  method: 'post',
                  data: formdata,
                  success: function(data){
                  	  showComments(data.topic_id, data.type);
                      $('#commentForm')[0].reset();
                       
            	},
            	error: function (request, status, error) {
					json = $.parseJSON(request.responseText);
					$.each(json.errors, function(key, value){
						$('.alert-danger').show();
						$('.alert-danger ul').append('<li>'+value+'</li>');
					});
				}
            });
        });
        
        function showComments(id, type){
            $.ajax({
                url: "{{url("/comment/showAll") }}",
                data: {id:id, type: type},
                success: function(data){                
                	$('#displayComments').html(data); 
					$("#reply-spinner").css("display", "none");
					document.getElementById('ajaxSubmit').disabled=false;
                }
            });
        }  
  	});
	
</script>
@endsection

@section('footer_scripts')
	@include('scripts.show-file')
@endsection