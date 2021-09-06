@extends('layouts.app')

@section('template_title')
    Dashboard
@endsection

@section('template_fastload_css')    
    
    .vod-body:hover {
        filter: brightness(70%);
        text-decoration: underline;  
    }

    .popover {
        background-color: #444;
        border-style: solid;
        line-height: 1.4;
        width: 21%;
        max-width: 21%;
    }

    .arrow {
        
    }
    
    .bs-popover-top > .arrow::after {
        border-color: #444 transparent transparent transparent !important;
    }

    .bs-popover-bottom > .arrow::after {
        border-color: transparent transparent #444 transparent !important;
    }
    
    .bs-popover-bottom .popover-header::before {
        border-bottom: 1px solid #444
    }

    .popover-header {
        font-size: 1.8em;
        line-height: 1.1;
        background-color: #333;
        color: azure;
        text-align: center;
        font-weight: bold;
    }

    .popover-body {
        margin: 2px;
        background-color: #444;
        color: aliceblue;
        font-size: 1.2em;
    }

@endsection

@section('content')

    <div class="container">  
        <div class="row d-flex flex-row">
        	<div class="col-md-12">
                <div class="card shadow p-3 bg-white rounded">
                    <div class="card-header bg-info text-white">
                         Welcome Guest!                                
                    </div>
                    <div class="card-body">                              
                        {{-- Non-Admin Dashboard --}}
                        @if (count($allcourses) > 0)
                            <hr>	
                            <h5 class="card-title">Courses Available</h5>  		
                            @foreach ($allcourses as $course)								
                                <div class="card d-flex flex-row shadow bg-white rounded mt-3 mb-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-12">
                                                <img id="rody_id" src="{{asset('images/courses/'.$course->thumbnail)}}" alt="Rody Vera" class="instr-image-courses">
                                            </div>
                                            <div class="col-lg-6 col-md-12">
                                                <div class="text-lg-left text-md-left">
                                                    <h4> <a class="text-dark" href="{{url('/course/'.$course->id.'/show')}}">{{$course->title}}</a></h4>
                                                    <p id="course_title" class=""> {{$course->description}}</p>
                                                    <p id="course_title" class=""> {{$course->information}}</p>
                                                </div>												
                                            </div>
                                            <div class="col-lg-2 col-md-12 text-align-center">
                                                <a class="btn  btn-sm btn-info btn-courses mb-2" href="{{url('/course/'.$course->id.'/enroll')}}" role="button"> <i class="fas fa-sign-in-alt"></i> Enroll Now</a>
                                                <a class="btn btn-sm btn-info btn-courses mb-2" href="{{url('/course/'.$course->id.'/show')}}" role="button">View Course</a>									
                                                <!-- <a class="btn btn-sm btn-outline-info btn-courses" href="#" role="button">Invite Friends</a>-->	
                                            </div>
                                        </div> <!--row-->
                                    </div><!--card-body-->
                                </div><!--card-->
                            @endforeach
                        @endif	 
                        
                        {{-- Vod Dashboard --}}
                        @if (isset($vodCategories))	
                            <hr>
                            <h5 class="card-title">Blackbox</h5>  
                            <!-- category 1  -->
                            <div class="card-body shadow bg-white rounded">
                                @foreach ($categoryVods as $categoryVod)  	
                                    <div class="section">
                                        <!-- POV category Title Start -->
                                        <div class="row mb-2 d-flex justify-content-between mr-3 ml-3">
                                            <div class="row">
                                                <h4 class="mr-3" style="font-weight:bold;">
                                                    {!! $categoryVod->first()->name !!}
                                                </h4>
                                            </div>
                                            <div class="mt-1 pb-1">
                                                <a class="row" href="{{ url('/blackbox') }}">
                                                    <h5>     
                                                        View more 
                                                    </h5>
                                                    <i class="fa fa-angle-double-right fa-lg ml-1 mt-1"></i>
                                                </a>
                                            </div>
                                        </div>                          
                                        <div class="section mt-3 mx-2">
                                            <!-- Category Vods Row  -->
                                            <div class="row">
                                                @for ($index = 0; $index < 6; $index++)
                                                    @if (isset($categoryVod[$index])) 
                                                        <div class="col-md-4 pd-2 mb-4 vod-body" data-toggle="popover" title="{{ $categoryVod[$index]->short_title }}" 
                                                            value="{{ $categoryVod[$index]->duration }} {{ $categoryVod[$index]->year_released }}"
                                                            data-content="{{ \Illuminate\Support\Str::limit($categoryVod[$index]->description_2, 250, $end='...') }}">
                                                            <div class="position-relative">
                                                                <a href="{{url('/blackbox/' . $categoryVod[$index]->id . '/watch')}}" 
                                                                    class="stretched-link" style="text-decoration:none;">
                                                                    <img class=" d-block w-100 mb-3" src="{{ asset('images/vods/'.$categoryVod[$index]->thumbnail) }}"
                                                                        style="border-radius:10px;" alt="{{ $categoryVod[$index]->short_title }}">
                                                                </a>
                                                                
                                                                <div class="row justify-content-center mt-n4 position-relative">
                                                                    @if ($categoryVod[$index]->paid == 1)
                                                                        <a href="#" class="mx-2 py-1 font-weight-bold btn btn-block rounded btn-info btn-vod" 
                                                                        style="font-size: 1.2em; background-color: cornflowerblue; border-color: cornflowerblue">
                                                                            Pay per view
                                                                        </a>     
                                                                    @else   
                                                                        <a href="#" class="mx-2 py-1 font-weight-bold btn btn-block rounded btn-info btn-vod" 
                                                                        style="font-size: 1.2em;">
                                                                            Watch Now    
                                                                        </a>                                                                
                                                                    @endif
                                                                </div>

                                                                <div class="mt-2">
                                                                    <h5 class="" style="text-align: center;">
                                                                        <strong >
                                                                            {{ $categoryVod[$index]->short_title }}
                                                                        </strong>  
                                                                        @if (isset($categoryVod[$index]->directors) && $categoryVod[$index]->category_id == 3)
                                                                            <br>
                                                                            <span class="small">
                                                                                @foreach ($categoryVod[$index]->directors as $director)
                                                                                    @if ($loop->first)
                                                                                        Directed by: {{ $director->short_name }}
                                                                                    @elseif ($loop->last)
                                                                                        <br>
                                                                                        and {{ $director->short_name }}
                                                                                    @else
                                                                                        ,
                                                                                        <br>
                                                                                        {{ $director->short_name }}
                                                                                    @endif                                                                                        
                                                                                @endforeach
                                                                            </span>    
                                                                        @endif                                                           
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                    @endif 
                                                @endfor 
                                            </div>           
                                            <!-- end of category contents  -->
                                        </div>
                                        
                                        <hr class="mb-5 bg-info " style="border: 1px solid #17a2b8;">                                          
                                    </div>
                                @endforeach 
                            </div>
                        @endif	 
                
                    </div><!--card-body-->
                </div><!--card-->
                <!-- Modals -->
                <div class="modal fade" id="enrollModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        
                    </div>
                    </div>
                </div>
            </div>
        </div>	      
    </div>

@endsection

@section('footer_scripts')    
	<script>
		$(document).ready(function(){
			$('[data-toggle="popover"]').popover({
				placement: 'top',
				trigger: 'hover',
				animation: true,
				template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-badges row justify-content-center"></div><div class="popover-body"></div></div>'
			});  
            
            $('.vod-body').on('inserted.bs.popover', function (e) {         
                reSizePoppers();
            }) 
		}); 
    
        function isMobile() {
            let isMobile = window.matchMedia("only screen and (max-width: 767px)").matches;
            // let isMobile = window.matchMedia(`(max-device-${window.matchMedia('(orientation: portrait)').matches?'width':'height'}: ${670}px)`).matches

            return isMobile;
        } 

        function reSizePoppers() {
            if (isMobile()) {      
                // Expand Slideshow     
                $('.popover').css("width", "50%");   
                $('.popover').css("max-width", "50%"); 
                $('.popover').css("min-width", "0px");      
            } else { 
                // Contract Slideshow
                $('.popover').css("width", "21%");   
                $('.popover').css("min-width", "300px"); 
                $('.popover').css("max-width", "21%");             
            }
        }
	</script>
@endsection
