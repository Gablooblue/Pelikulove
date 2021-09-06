@extends('layouts.app')
		
@section('template_title')
    {{ $course->title }}
@endsection

@section('videocss')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
	<link rel='stylesheet' href='https://unpkg.com/plyr@3/dist/plyr.css'>
@endsection

@section('template_fastload_css')
@endsection

@section('content')

   <div class="container-fluid bg-dark row justify-content-center">  
		<div class="bg-dark" style="max-width: 80.1%;">
			<div class="row d-flex flex-row pt-3">
				@if (isset($topic->video))
				<div class="col-md-1 my-auto hidden-xs">
					@if($prev)
						<div class="row d-flex justify-content-center">
							<a  href="{{url('/lesson/'.$prev->lesson->id.'/topic/'.$prev->id.'/show')}}" 
								data-toggle="tooltip" data-placement="bottom" title="{{$prev->title}}"  
								class="video-button p-2 text-light rounded bg-danger" style="font-size: 1.1rem">
								&laquo; PREV
							</a> 
						</div>
					@endif
				</div>
			
				<div class="col-md-10 col-xs-12">
					<video id="video-frame" controls playsinline 
					poster="https://learn.pelikulove.com/images/obb.png">
					</video>
				</div>

				<div class="col-md-1 my-auto hidden-xs">
					@if($next)
						<div class="row d-flex justify-content-center">
							<a href="{{url('/lesson/'.$next->lesson->id.'/topic/'.$next->id.'/show')}}" 
								data-toggle="tooltip" data-placement="bottom" title="{{$next->title}}"  
								class="video-button p-2 text-light rounded bg-danger" style="font-size: 1.1rem">
								NEXT &raquo;
							</a>
						</div>
					@endif
				</div>
			
				@endif
			</div>	
			<div class="row d-flex flex-row p-2">				
				<div class="col-6 my-auto mx-auto hidden-sm hidden-md hidden-lg hidden-xl">
					@if($prev)
						<div class="d-flex justify-content-end">
							<a  href="{{url('/lesson/'.$prev->lesson->id.'/topic/'.$prev->id.'/show')}}" 
								data-toggle="tooltip" data-placement="bottom" title="{{$prev->title}}" 
								class="video-button px-2 py-1 text-light rounded bg-danger" style="font-size: 1.1rem">
								&laquo; PREV 
							</a> 
						</div>
					@endif
				</div>				
				<div class="col-6 my-auto mx-auto hidden-sm hidden-md hidden-lg hidden-xl">
					@if($next)
						<div class="d-flex justify-content-start">
							<a href="{{url('/lesson/'.$next->lesson->id.'/topic/'.$next->id.'/show')}}" 
								data-toggle="tooltip" data-placement="bottom" title="{{$next->title}}"  
								class="video-button px-2 py-1 text-light rounded bg-danger" style="font-size: 1.1rem">
								NEXT &raquo;
							</a>
						</div>
					@endif
				</div>
			</div>	
		</div>	
	</div>
			
	<div class="container"> 
		 <div class="row d-flex flex-row">		
			<div class="col-md-12 mt-3">
					
				<div class="row">
						
					<div class="col-lg-3 col-md-12">
						<div class="bg-white shadow">
							<div class="">	
								<h6 class="text-danger font-weight-bold p-3">Lesson Outline</h6>
								<h5 class="font-weight-bold pl-3">
								{{$lesson->title}}
								<span class="small">{{$lesson->duration}} min</span>
								</h5>
								@if(isset($lesson->file))<h6 class="pl-3"><a href="{{$lesson->file}}" target="_blank"><i class="fa fa-download"></i> With Downloadable Handout</a></h6>@endif
								@if(isset($lesson->file2))<h6 class="pl-3"><a href="{{$lesson->file2}}" target="_blank"><i class="fa fa-download"></i> With Downloadable Script</a></h6>@endif
								<ul class="list-group lessons">
								@foreach ($topics as $t)
								<li class="list-group-item text-dark @if($t->id == $topic->id) active @endif">
								<a href="{{url('/lesson/'.$lesson->id.'/topic/'.$t->id.'/show')}}" class="text-dark"><div class="float-left" style="width: 80%">{{$t->title}} </div>
								<div class="small float-right text-right" style="width: 20%">{{$t->duration}} min</div></a>
								</li>
								@endforeach
								</ul>
							</div>
						</div>
					</div>		
					<div class="col-lg-9 col-md-12">
						<div class="card bg-white shadow">
							
							<div class="card-body">	
								<nav aria-label="breadcrumb">
  								<ol class="breadcrumb">
    							<li class="breadcrumb-item"><a href="{{url('/home')}}" class="text-danger"><i class="fa fa-home"></i> Home</a></li>
    							<li class="breadcrumb-item"><a href="{{url('/course/'.$course->id.'/show')}}" class="text-danger" >{{$course->title}}</a></li>
   								<li class="breadcrumb-item active" aria-current="page" class="">{{$lesson->title}}</li>
  								</ol>
								</nav>								
								
								@if ($lesson->submission == 1)
									<div class="row justify-content-between mx-2">
										<h5 class="font-weight-bold">{{$topic->title}}</h5>
										<a href="{{ url('submissions/create/' . $lesson->id) }}" class="m-0 p-0">	
											<button class="btn btn-sm btn-danger mb-2" href="#" role="button"
												style="">                        
												<span style="">
													Submit Activity &raquo;
												</span>
											</button>
										</a>
									</div>
								@endif			
								
								@if (isset($lesson->description) && $lesson->course_id == 3)
									<div class="row justify-content-between mx-2">
										<p>
											{{ $lesson->description }}
										</p>
									</div>
								@endif		
								
								@if ($topic->copyright_disclaimer == 1)
									<div>
										<p class="small">											
											No copyright infringement intended. Solely for educational purposes.
										</p>
									</div>
								@endif

								 
    	 						<div class="row lesson">
    	 							<div class="p-3 col-lg-6 col-md-12 border-right border-bottom border-top border-gray">@if ($prev)<span class="small float-left"> <a href="{{url('/lesson/'.$prev->lesson->id.'/topic/'.$prev->id.'/show')}}" class="text-dark">PREVIOUS</a> <br> <a href="{{url('/lesson/'.$prev->lesson->id.'/topic/'.$prev->id.'/show')}}" class="text-dark"> {{$prev->title}}</a></span>@endif </div>
    	 							<div class="p-3 col-lg-6 col-md-12 border-bottom border-top border-gray">@if ($next)<span class="small float-right text-right"><a  class="text-dark" href="{{url('/lesson/'.$next->lesson->id.'/topic/'.$next->id.'/show')}}">NEXT </a><br> <a href="{{url('/lesson/'.$next->lesson->id.'/topic/'.$next->id.'/show')}}" class="text-dark">{{$next->title}}</a></span>@endif</div>
    	 						</div>
    	 						<h5 class="mt-2"><i class="fa fa-comments"></i> Discussions</h5>
								 <p class="small">Help us keep the community relevant and fun
for everyone by following the <span><a href="https://pelikulove.com/community-guidelines/" target="_blank">Community Guidelines</a></span></p>
    	 						
                    			<hr>
                    			
                    			
    	 						<div id="displayComments">
                   				@include('lessons.commentsDisplay', ['comments' => \App\Models\Comment::getAllTopicComments($topic->id), 'topic_id' => $topic->id])
                   				</div>
   							
   								
                    			<form method="post" id="commentForm"> 
									@csrf
									<div class="form-group">
										<textarea class="form-control" name="body" placeholder="Type your comment here"></textarea>
										<input type="hidden" name="topic_id" value="{{ $topic->id }}" />
										<input type="hidden" name="parent_id" value="" />
										<input type="hidden" name="type" value="topic" />
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
							</div>
							
							
						</div>
							
					</div>
						
    	 		
				</div><!--row-->
    		
			</div><!--col-->
        	     
        </div>	<!-- row -->	 
	</div><!-- container -->
	
	
    {{-- @include('modals.modal-survey-link') --}}

@endsection

@section('commentajax2')
<script>
	
	$(document).ready(function(){
		document.getElementById('ajaxSubmit').disabled=false;
		
		$("#ajaxSubmit").on('click', function(e){
  			e.preventDefault();
			$("#reply-spinner").css("display", "inline-block");
			document.getElementById('ajaxSubmit').disabled=true;
			
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

@section('videojs2')
	<script src='https://cdn.polyfill.io/v2/polyfill.min.js?features=es6,Array.prototype.includes,CustomEvent,Object.entries,Object.values,URL'></script>
	<script src='https://unpkg.com/plyr@3'></script>

	@include('scripts.show-video')

	<script src="{{ asset('/js/moment.js') }}"></script>

@endsection	

@section('footer_scripts')
   
	<script>
		$(document).ready(function(){
			$('[data-toggle="tooltip"]').tooltip({
				container:'body', 
				trigger: 'hover', 
				placement:"bottom"
			});   
		});
	</script>

@endsection
