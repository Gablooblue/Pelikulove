@php

    $levelAmount = 'level';

    if (Auth::User()->level() >= 2) {
        $levelAmount = 'levels';

    }

@endphp


<div class="card shadow bg-white rounded">
	<div class="card-header @role('admin', true) bg-secondary text-white text-md-left @endrole">
						{{$course->title}}
	</div>
    <div class="card-body">
    	<div class="row">
            <div class="col-lg-4 col-md-12">
									<img class="img-fluid" src="{{asset('images/courses/'.$course->thumbnail)}}" alt="Rody Vera" class="instr-image-courses" width="200px">
									<div class="mt-3">
										<a class="btn btn-sm btn-info btn-courses mb-2" href="#" role="button">Enroll Now</a>
										<a class="btn btn-sm btn-outline-info btn-courses" href="#" role="button">Invite Friends</a>
										
                            		</div>
                            	</div>
                            	<div class="col-lg-8 col-md-12">
                               		<div class="text-lg-left text-md-left">
            
                                        <p id="course_title" class=""> {{$course->description}}</p>
                                	</div>
                                	
								</div>
								<div class="col-lg-3 col-md-12 text-align-center">
                                	
                            		
                </div>
        </div> <!--row-->
        
        @if (count($lessons ) > 0) <?php $cnt = 1;?>
        <hr>
        <h4>Lessons</h4>
		<div id="accordion">
		@foreach ($topiclessons as $key=> $lesson)
  			<div class="card">
    			<div class="card-header outline-info" id="heading{{$cnt}}">
      				<h4 class="mb-0">
       				 <button class="btn btn-link text-dark" data-toggle="collapse" data-target="#collapse{{$cnt}}" aria-expanded="{{ $cnt == 1 ? 'true' : 'false' }}" aria-controls="collapse{{$cnt}}">
         			 <h5>{{$lessons[$key]['title']}}</h5>
       				 </button>
     				 </h4>
    			</div>
				<div id="collapse{{$cnt}}" class="collapse" aria-labelledby="heading{{$cnt}}" data-parent="#accordion">
      				<div class="card-body">
      			 	<p>{{$lessons[$key]['description']}}</p>
      			 	<ul class="list-group">
      			 	@foreach ($lesson as $l => $topic)
      			 	<li class="list-group-item d-flex justify-content-between">
      			 	<div class="col-12 mb-2">{{$topic['title']}}
    				<span class="badge badge-primary badge-pill">{{$topic['page']}}</span></div>
    				@if ($topic['video'] && $topic['id'] == 1)
    				<div class="video" style="max-width: 500px;">
    					<video controls playsinline poster="https://storage.googleapis.com/pelikulove/lesson1-p1-thumb.png">
						<source src="{{$topic['video']}}" type="video/mp4" size="540">
				
						<!-- Caption files -->
						<track kind="captions" label="English" srclang="en" src="{{$topic['subtitle']}}adefault>
				<track kind="captions" label="Français" srclang="fr" src="https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer-HD.fr.vtt">
				<!-- Fallback for browsers that don't support the <video> element -->
				<a href="https://storage.cloud.google.com/pelikulove/Lesson%201%20%20(Part%201%20-%20WTH)%20360p.mp4?authuser=1&folder&organizationId&supportedpurview=project&_ga=2.36216418.-339285357.1549342169&_gac=1.24165448.1559211472.Cj0KCQjw_r3nBRDxARIsAJljleHPi5WAxkVULj9j_3lBbcrIwL_Q6GHHG-pOS0MUXd3Wrcddeeu7-PQaAjxUEALw_wcB" download>Download</a>
			</video></div>
					@endif
    				</li>
  
      			 		
      			 	@endforeach
      			 	</ul>
      			 	
      			 	
	 			 	</div>
  	  			</div>
 		 	</div> <?php $cnt++;?>
 		 @endforeach 	
  		</div>
  		@endif	
  	</div>	
</div>

				
				
				
		
            
        

    </div><!--card-body-->
</div><!--card-->
