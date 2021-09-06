@extends('layouts.app')
		
@section('template_title')
    PELIKULOVE | {{$course->title}} Stats
@endsection

@section('template_fastload_css')
@endsection

@section('content')
	
   <div class="container">  
   		<div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">

                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{$course->title}} Stats	
                            </span>
						
                            
                        </div>
                	</div>
                    
       				<div class="card-body">
                
                		<div class="row mb-3">
                    		<div class="col-md-12 col-lg-12 py-3">
                    		<h4>Total Learners:  <span class="badge badge-info badge-pill"> {{$learners->sum('count')}}</span></h4>
   							
                    	</div>
                    	
                    	@role('admin|pelikulove') 
                    	<div class="col-md-6 col-sm-6 col-lg-6">
                    					

                    					<ul class="list-group">
  										@foreach ($learners as $learner)
  										<li class="list-group-item d-flex justify-content-between align-items-center">
   										 <a class="text-danger" href="{{URL::to('accounting/' . $learner->year . '/' . $learner->month )}}">{{ date("F", mktime(0, 0, 0, $learner->month, 1))}} {{$learner->year}}</a>
   										 <span class="badge badge-success badge-pill"> {{$learner->count}}</span>
  										</li>
  										@endforeach
  										
  										
  										
										</ul>
                    		
                    	</div>
                    	<div class="col-md-6 col-sm-6 col-lg-6">
                    			
                    					<ul class="list-group">
  										@foreach ($services as $service)
  										<li class="list-group-item d-flex justify-content-between align-items-center">
   										 {{$service->name}}
   										 <span class="badge badge-primary badge-pill"> {{$orders->where('service_id', $service->id)->count()}}</span>
  										</li>
  										@endforeach
										</ul>
                    		
                    	</div>
                    	@endrole
                    	@role('admin|pelikulove|mentor') 
                    	<div class="col-md-12 col-lg-12 py-3">
                    			
                    	<ul class="list-group">
                    			<li class="list-group-item d-flex justify-content-between align-items-center ">
                    			<h4>Lessons </h4>
                    			<span class=""><strong> # of Learners who Completed </strong></span>
								</li>
								@if (isset($lessons))
									@foreach ($lessons as $key => $lesson) 
										<li class="list-group-item d-flex justify-content-between align-items-center">
											<a href="{{url('/lesson/'.$key.'/topic/'.$lesson['first'].'/show')}}">{{ $lesson['title']}} </a>
											<span class="badge badge-info badge-pill"> {{ $stats[$key] }} </span>	
										</li>										
									@endforeach
								@else
									<li class="list-group-item d-flex justify-content-between align-items-center">
										No lessons yet
									</li>		
								@endif
                         </ul>
                    	</div>	
                    	@endrole
                	</div>    		
                	
                
                    
                    <!--card-body-->
            
               		
            	
          
				</div>
			</div><!--card-->     
        </div>	<!-- row -->	 
    </div><!-- container -->

@endsection

@section('footer_scripts')
@endsection
