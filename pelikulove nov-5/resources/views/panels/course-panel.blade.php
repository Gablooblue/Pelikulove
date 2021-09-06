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
    	 
    	 <p class="card-text">{{$course->description}}</p>
         <p class="card-text">{{$course->information}}</p>
    		
  
    </div><!--card-body-->
    
	<div class="card-body">	
    	@if (count($instructors) > 0)
    	
    	@foreach ($instructors as $instructor)
    	<div class="row">	
            <div class="col-lg-3 col-md-12">
				<img class="img-fluid" src="{{asset('images/courses/'.$course->thumbnail)}}" alt="Rody Vera" class="instr-image-courses" width="300px">
				
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="text-lg-left text-md-left">
                 <h4 class="card-title">{{$instructor->name}}</h4>
            	 <p>{!! $instructor->description !!}</p>
            	 <p>{!! $instructor->credentials !!}</p> 
                   
                </div>
                                	
			</div>
			<div class="col-lg-3 col-md-12">
                <div class="text-lg-left text-md-left mt-3">
                <a class="btn btn-sm btn-info btn-courses mb-2" href="#" role="button">Enroll Now</a>
				<a class="btn btn-sm btn-outline-info btn-courses" href="#" role="button">Invite Friends</a>
                    
                </div>
                                	
			</div>
		
        </div> <!--row-->
        @endforeach
  		@endif
 	</div><!--card-body-->
 	 
	<div class="card-body">
        @if (count($lessons ) > 0) 
        <hr>
    
	
		@foreach ($lessons as $lesson)
  		<div class="card mb-3 bg-white rounded">
    		<div class="card-header">
    			{{$lesson->title}}
    		</div>
    		<div class="card-body">
    			<div class="row">
    				<div class="col-lg-8 col-md-12">
    					{{ $lesson->description }}
    				</div>
    				<div class="col-lg-4 col-md-12">
    					<a class="btn btn-info btn-courses mb-2" href="#" role="button"> <i class="fa fa-files-o"></i> View Lesson</a>
						<a class="btn btn-outline-info btn-courses" href="#" role="button"> <i class="fa fa-comments"></i> View Discussions</a>
					
    				</div>
    			</div>
    			
    		</div>  <!--card-body-->
    	</div> <!--card-->
    	@endforeach
      			
  		@endif	
				
	</div><!--card-body-->
</div><!--card-->
