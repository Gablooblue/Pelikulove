
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

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

   <div class="container-fluid bg-dark">  
        <div class="row d-flex flex-row">
        	@if (isset($topic->video))
        	 <div class="col-md-2 my-auto">@if($prev)<a  href="{{url('/lesson/'.$prev->lesson->id.'/topic/'.$prev->id.'/show')}}" class="video-button p-3 ml-3 text-light bg-danger float-right"  data-toggle="tooltip" data-placement="bottom" title="{{$prev->title}}" style="font-size: 1.1rem">&laquo; PREV </a> @endif</div>
        
        	<div class="col-md-8">
        		<video id="video-frame" controls playsinline poster="https://learn.pelikulove.com/images/obb.png">
				</video>
			</div>
			<div class="col-md-2 my-auto">@if($next)<a href="{{url('/lesson/'.$next->lesson->id.'/topic/'.$next->id.'/show')}}" data-toggle="tooltip" data-placement="bottom" title="{{$next->title}}"  class="video-button p-3 text-light  bg-danger" style="font-size: 1.1rem">NEXT &raquo;</a>@endif</div>
		
			@endif
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
								@if(isset($lesson->file))<h6 class="pl-3"><a href="{{$lesson->file}}"><i class="fa fa-download"></i> With Downloadable Handout</a></h6>@endif
								@if(isset($lesson->file2))<h6 class="pl-3"><a href="{{$lesson->file2}}"><i class="fa fa-download"></i> With Downloadable Script</a></h6>@endif
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
					
    	 						<h5 class="font-weight-bold">{{$topic->title}}</h5>
    	 						
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
                            	<input type="submit" class="btn btn-sm btn-success" id="ajaxSubmit" value="Submit" />
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

@endsection

@section('commentajax2')
<script>
	
	
	$(document).ready(function(){
		
		$('#commentForm').submit(function(e){
  			e.preventDefault();
  			$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        	});
       		var formdata = $(this).serialize(); 
        	
        
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
                }
            });
        }
        
        
  	});


	
</script>
@endsection
   
   <script>$(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip(
        {container:'body', trigger: 'hover', placement:"bottom"}
        );   
    });</script>

@section('videojs2')

<script src='https://cdn.polyfill.io/v2/polyfill.min.js?features=es6,Array.prototype.includes,CustomEvent,Object.entries,Object.values,URL'></script>
<script src='https://unpkg.com/plyr@3'></script>

@include('scripts.show-video')
<script src="{{ asset('/js/moment.js') }}"></script>
@endsection	
@section('footer_scripts')
@endsection
