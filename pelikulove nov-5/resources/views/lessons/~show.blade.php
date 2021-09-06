@extends('layouts.app')
@section('videojs')
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
@endsection
		
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
        	@if ($topic->video)
        	<div class="col-md-8 offset-md-2">
        		<video controls playsinline poster="https://storage.googleapis.com/pelikulove/lesson1-p1-thumb.png">
						<source src="{{$topic->video}}" type="video/mp4" size="540">
			
						
						<!-- Fallback for browsers that don't support the <video> element -->
						<a href="{{$topic->video}}">Download</a>
				</video>
			</div>
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
								<ul class="list-group lessons">
								@foreach ($lessons as $key => $l) 
								<li class="list-group-item @if($key == $topic->lesson_id) active @endif"><a href="{{url('/lesson/'.$key.'/topic/'.$l['first'].'/show')}}" class="text-dark">
								<div class="float-left" style="width: 80%">{{$l['title']}} </div>
								<div class="small float-right" style="width: 20%">{{$l['duration']}} min</div></a>
							
								</li>
								@endforeach
								</ul>
							</div>
						</div>
					</div>		
					<div class="col-lg-9 col-md-12">
						<div class="card bg-white shadow">
							<div class="card-body">	
								<h5>{{$lesson->title}}</h5>
    	 						<h5 class="font-weight-bold">{{$topic->title}}</h5>
    	 						<p>{{$lesson->description}}</p>
    	 						<div class="row lesson">
    	 							<div class="p-3 col-lg-6 col-md-12 border-right border-bottom border-top border-gray">@if ($prev)<span class="small float-left">PREVIOUS<br> {{$prev->lesson->title}} <br> <a href="{{url('/lesson/'.$lesson->id.'/topic/'.$prev->id.'/show')}}" class="text-dark font-weight-bold"> {{$prev->title}}</a></span>@endif </div>
    	 							<div class="p-3 col-lg-6 col-md-12 border-bottom border-top border-gray">@if ($next)<span class="small float-right text-right">NEXT<br> {{$next->lesson->title}} <br> <a href="{{url('/lesson/'.$lesson->id.'/topic/'.$next->id.'/show')}}" class="text-dark font-weight-bold">{{$next->title}}</a></span>@endif</div>
    	 						</div>
    	 					
    	 						
    	 						<h5 class="mt-2"><i class="fa fa-comments"></i> Discussions</h5>
                   				 @include('lessons.commentsDisplay', ['comments' => $topic->comments, 'topic_id' => $topic->id])
   								<hr />
                    			<h6>Join Discussion</h6>
                    			<form method="post" action="{{ route('comment.store') }}">
                       			 @csrf
                        		<div class="form-group">
                            	<textarea class="form-control" name="body" placeholder="Type your comment here"></textarea>
                            	<input type="hidden" name="topic_id" value="{{ $topic->id }}" />
                        		</div>
                        		<div class="form-group">
                            	<input type="submit" class="btn btn-sm btn-success" value="Add" />
                        		</div>
                    			</form>
    	 						
							</div>
							
							
						</div>
							
					</div>
						
    	 		
				</div><!--row-->
    		
			</div><!--col-->
        	     
        </div>	<!-- row -->	 
    </div><!-- container -->

@endsection

@section('videojs2')
<script src='https://cdn.polyfill.io/v2/polyfill.min.js?features=es6,Array.prototype.includes,CustomEvent,Object.entries,Object.values,URL'></script>
<script src='https://unpkg.com/plyr@3'></script>
<script>
// Change the second argument to your options:
// https://github.com/sampotts/plyr/#options
const player = new Plyr('video', { captions: { active: true } });

// Expose player so it can be used from the console
window.player = player;
</script>
@endsection

@section('footer_scripts')
@endsection
