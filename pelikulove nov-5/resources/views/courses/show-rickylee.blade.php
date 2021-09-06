@extends('layouts.app')

@section('template_title')
{{ $course->title }}
@endsection

@section('template_fastload_css')
@endsection

@section('content')




<div class="" style="background-color: #000000; ">
    {{-- <div class="container"> --}}
        <br>

        <div class="container">
            <div class="row d-flex flex-row">
                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-xs-12">
                    <div class="container">
                        <img class="w-100" src="{{ asset('images/courses/viber_image_2020-03-20_18-08-19.jpg')}}" alt="">
                    </div>
                    <h5 class="text-white text-center">
                        Since 1982, Dr. Ricky has been conducting free scriptwriting workshops for beginning writers, producing hundreds of graduates who now work for TV and film.
                    </h5>
                    <br>
                    <div class="row d-flex flex-row justify-content-center">											
                        <a href="{{ url('mentor/5/show') }}" class="mb-2 ml-2">	
                            <button class="btn btn-sm btn-danger w-100 px-2 py-1" href="#" role="button"
                                style="border-radius: 15px;" >                         
                                <span style="font-size: 16px">
                                    About Ricky Lee &raquo;
                                </span>
                            </button>
                        </a>

                        {{-- <a class="btn btn-sm btn-danger mb-2 ml-2 col-5" href="#" role="button"
                            style="border-radius: 15px;" disabled>                         
                            <span style="font-size: 16px">
                                About Ricky Lee &raquo;
                            </span>
                        </a>  --}}
                    </div>
                </div>
                <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-xs-12">  
                    <div class="container">
                        <div class="m-3">              
                            <video id="player" controls playsinline controlsList="nodownload"
                            {{-- poster="{{ asset('images/patikim-thumbnail.png')}}" --}}
                            style="width: 100%; height: 100%;">
                                <source src="{{ $course->sneakpeak_video }}"
                                type="video/mp4"/>
                            </video>   
                        </div>    
                    </div>     
                </div>
            </div> <!-- row -->
        </div>

        <br>

        <div class="container-fluid">
            <div class="row d-flex flex-row">
                <div class="col-xl-5 col-lg-12 col-md-12 col-sm-12 col-xs-12 mx-0 px-0">                
                    {{-- <div class="container mx-0 px-0"> --}}
                        <img class="w-100" src="{{ asset('images/courses/ricky-lee-sits-4.png')}}" alt="">
                    {{-- </div> --}}
                </div>
                <div class="row justify-content-center col-xl-7 col-lg-12 col-md-12 col-sm-12 col-xs-12 mx-0 px-0">
                    <div class="col-12 mx-0 px-0 text-dark text-center h-100 align-self-center row" style="background-color: #DBDBDB;">
                        <div class="px-5 pt-4 align-self-center">
                            <h3>
                                <strong>
                                    Welcome! Ricky Lee Scriptwriting Workshop
                                    <br>
                                    <span class="small text-left">
                                        {{-- August 12, 2020 - September 2, 2020 --}}
                                        August 12, 2020 - October 07, 2020
                                    </span>
                                </strong>
                            </h3>

                            <br>
    
                            <div class="container text-white p-3" style="background-color: #000000;">
                                <h4>
                                    To enter the Zoom webinar, click the button below. Please be sure to read the Rules & Guidelines before the workshop. 
                                    <br>
                                    <br>
                                    All workshop sessions will be recorded and made available in this page. Scroll down to review the session recordings. You may submit your project or activity and join the discussion at the bottom of each session page.
                                </h4>
                            </div>

                            <br>
                            
                            <div class="row justify-content-center">
                                <div class="">
                                    
                                    <a href="https://us02web.zoom.us/j/2020031948?pwd=Z01mWHF6MVljTm5oK2JFUS8xT3Axdz09" 
                                    class="mb-2 ml-2 block" style="text-decoration: none;" target="_blank">	
                                        <button class="btn btn-sm btn-danger btn-block" role="button"
                                        style="border: 1px solid black" disabled>                         
                                            <strong style="font-size: 20px">
                                                ENTER THE WORKSHOP
                                            </strong>
                                        </button>
                                    </a>
                                    <i>*The workshop will be available starting September 09, 2020 (Wednesday).</i>
            
                                    <br>
                                    <br>
            
                                    <a href="{{ route('course.guidelines') }}" class="block" 
                                    style="text-decoration: none;" target="_blank" >	
                                        <button class="btn btn-sm btn-light btn-block mb-2" role="button"
                                        style="border: 1px solid">                         
                                            <strong style="font-size: 16px">
                                                Workshop Guidelines
                                            </strong>
                                        </button> 
                                    </a>
            
                                    <a href="{{ url('lesson/26/topic/62/show') }}" class="block" 
                                    style="text-decoration: none;">	
                                        <button class="btn btn-sm btn-light btn-block mb-2" role="button"
                                        style="border: 1px solid">                         
                                            <strong style="font-size: 16px">
                                                Resources and Materials
                                            </strong>
                                        </button>
                                    </a>
            
                                    <a href="{{ route('course.groupings') }}" class="block" 
                                    style="text-decoration: none;" target="_blank" >	
                                        <button class="btn btn-sm btn-light btn-block mb-3" role="button"
                                        style="border: 1px solid">                         
                                            <strong style="font-size: 16px">
                                                Groupings
                                            </strong>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div> <!-- row -->
        </div>

        <div class="container-fluid">
            <div class="row justify-content-center">

                <div class="col-xl-3 col-lg-6 col-md-12 col-sm-12 col-xs-12 row justify-content-center py-5 mx-0" style="background-color: #000000;">
                    <div class="col-3">
                        <img class="w-100" src="{{ asset('images/courses/bulb.svg') }}" alt="">
                        <br>
                        <br>
                    </div>
                    <div class="col-12">
                        <h5 class="text-center text-light">
                            <strong>
                                Session 1
                            </strong>
                            <br>
                            <br>
                            <span class="small">
                                August 12, 2020
                                <br>
                                <br>
                                <a id="aug-12-view" value="aug-12-view" class="mb-2 row justify-content-center listCollapsible" href="#" data-toggle="collapse" 
                                data-target="#aug-12-content" aria-expanded="false" aria-controls="totalViewsList">
                                    <span class="text-light" href="#">
                                        View &raquo;
                                    </span>
                                </a>
                                <div id="aug-12-content" class="collapse">
                                    <div class="row justify-content-center mx-1 mt-1">
                                        <div class="col-xl-5 col-lg-12 col-md-12 col-sm-12 col-xs-12">            
                                            <a href="{{ url('lesson/24/topic/60/show') }}" class="block" 
                                            style="text-decoration: none;">	
                                                <button class="btn btn-light btn-block mt-2" role="button"
                                                style="border: 1px solid">
                                                    <strong style="">
                                                        Morning Session
                                                    </strong>
                                                </button>
                                            </a>
                                        </div>
                                        <div class="col-xl-5 col-lg-12 col-md-12 col-sm-12 col-xs-12">        
                                            <a href="{{ url('lesson/25/topic/61/show') }}" class="block" 
                                            style="text-decoration: none;">	
                                                <button class="btn btn-light btn-block mt-2" role="button"
                                                style="border: 1px solid">
                                                    <strong style="">
                                                        Afternoon Session
                                                    </strong>
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </span>
                        </h5>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-12 col-sm-12 col-xs-12 row justify-content-center py-5 mx-0" style="background-color: #605E5E;">
                    <div class="col-6">
                        <img class="w-100" src="{{ asset('images/courses/pencil.svg') }}" alt="">
                        <br>
                        <br>
                    </div>
                    <div class="col-12">
                        <h5 class="text-center text-light">
                            <strong>
                                Session 2
                            </strong>
                            <br>
                            <br>
                            <span class="small">
                                August 26, 2020
                                <br>
                                <br>
                                <a id="aug-26-view" value="aug-26-view" class="mb-2 row justify-content-center listCollapsible" href="#" data-toggle="collapse" 
                                data-target="#aug-26-content" aria-expanded="false" aria-controls="totalViewsList">
                                    <span class="text-light" href="#">
                                        View &raquo;
                                    </span>
                                </a>
                                <div id="aug-26-content" class="collapse">
                                    <div class="row justify-content-center mx-1 mt-1">
                                        <div class="col-xl-5 col-lg-12 col-md-12 col-sm-12 col-xs-12">            
                                            <a href="{{ url('lesson/28/topic/64/show') }}" class="block" 
                                            style="text-decoration: none;">	
                                                <button class="btn btn-light btn-block mt-2" role="button"
                                                style="border: 1px solid">
                                                    <strong style="">
                                                        Morning Session
                                                    </strong>
                                                </button>
                                            </a>
                                        </div>
                                        <div class="col-xl-5 col-lg-12 col-md-12 col-sm-12 col-xs-12">        
                                            <a href="{{ url('lesson/27/topic/63/show') }}" class="block" 
                                            style="text-decoration: none;">	
                                                <button class="btn btn-light btn-block mt-2" role="button"
                                                style="border: 1px solid">
                                                    <strong style="">
                                                        Afternoon Session
                                                    </strong>
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </span>
                        </h5>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-12 col-sm-12 col-xs-12 row justify-content-center py-5 mx-0" style="background-color: #EDEDED;">
                    <div class="col-6">
                        <img class="w-100" src="{{ asset('images/courses/chat-bubble-1.svg') }}" alt="">
                        <br>
                        <br>
                    </div>
                    <div class="col-12">
                        <h5 class="text-center text-dark">
                            <strong>
                                Session 3
                            </strong>
                            <br>
                            <br>
                            <span class="small text-dark">                                
                                September 09, 2020
                                <br>
                                <br>
                                <a id="sep-09-view" value="sep-09-view" class="mb-2 row justify-content-center listCollapsible" href="#" data-toggle="collapse" 
                                data-target="#sep-09-content" aria-expanded="false" aria-controls="totalViewsList">
                                    <span class="text-dark" href="#">
                                        View &raquo;
                                    </span>
                                </a>
                                <div id="sep-09-content" class="collapse">
                                    <div class="row justify-content-center mx-1 mt-1">
                                        <div class="col-xl-5 col-lg-12 col-md-12 col-sm-12 col-xs-12">            
                                            <a href="{{ url('lesson/29/topic/65/show') }}" class="block" 
                                            style="text-decoration: none;">	
                                                <button class="btn btn-dark btn-block mt-2" role="button"
                                                style="border: 1px solid">
                                                    <strong style="">
                                                        Morning Session
                                                    </strong>
                                                </button>
                                            </a>
                                        </div>
                                        <div class="col-xl-5 col-lg-12 col-md-12 col-sm-12 col-xs-12">        
                                            <a href="{{ url('lesson/30/topic/66/show') }}" class="block" 
                                            style="text-decoration: none;">	
                                                <button class="btn btn-dark btn-block mt-2" role="button"
                                                style="border: 1px solid">
                                                    <strong style="">
                                                        Afternoon Session
                                                    </strong>
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </span>
                        </h5>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-12 col-sm-12 col-xs-12 row justify-content-center py-5 mx-0" style="background-color: #fff;">
                    <div class="col-6">
                        <img class="w-100" src="{{ asset('images/courses/film.svg') }}" alt="">
                        <br>
                        <br>
                    </div>
                    <div class="col-12">
                        <h5 class="text-center text-dark">
                            <strong>
                                Session 4
                            </strong>
                            <br>
                            <br>
                            <span class="small text-dark">                                
                                October 07, 2020
                                <br>
                                <br>
                                <a id="oct-07-view" value="oct-07-view" class="mb-2 row justify-content-center listCollapsible" href="#" data-toggle="collapse" 
                                data-target="#oct-07-content" aria-expanded="false" aria-controls="totalViewsList">
                                    <span class="text-dark" href="#">
                                        View &raquo;
                                    </span>
                                </a>
                                <div id="oct-07-content" class="collapse">
                                    <div class="row justify-content-center mx-1 mt-1">
                                        <div class="col-xl-5 col-lg-12 col-md-12 col-sm-12 col-xs-12">            
                                            <a href="{{ url('lesson/31/topic/67/show') }}" class="block" 
                                            style="text-decoration: none;">	
                                                <button class="btn btn-dark btn-block mt-2" role="button"
                                                style="border: 1px solid">
                                                    <strong style="">
                                                        Morning Session
                                                    </strong>
                                                </button>
                                            </a>
                                        </div>
                                        <div class="col-xl-5 col-lg-12 col-md-12 col-sm-12 col-xs-12">        
                                            <a href="{{ url('lesson/32/topic/68/show') }}" class="block"
                                            style="text-decoration: none;">	
                                                <button class="btn btn-dark btn-block mt-2" role="button"
                                                style="border: 1px solid">
                                                    <strong style="">
                                                        Afternoon Session
                                                    </strong>
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </span>
                        </h5>
                    </div>
                </div>
                {{-- <div class="col-xl-3 col-lg-6 col-md-12 col-sm-12 col-xs-12 row justify-content-center py-5 mx-0" style="background-color: #E21C21;">
                    <div class="col-6">
                        <img class="w-100" src="{{ asset('images/courses/film.svg') }}" alt="">
                        <br>
                        <br>
                    </div>
                    <div class="col-12">
                        <h5 class="text-center text-light">
                            <strong>
                                Session 4
                            </strong>
                            <br>
                            <br>
                            <span class="small">
                                September 2, 2020
                                <br>
                                <br>
                                <span class="text-light" href="#">
                                    Coming soon &raquo;
                                </span>
                            </span>
                        </h5>
                    </div>
                </div> --}}
            </div> <!-- row -->
        </div>

        

    {{-- </div> --}}<!-- container -->
</div>

@endsection

@section('footer_scripts')
@endsection