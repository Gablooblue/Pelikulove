@extends('layouts.app')

@section('template_title')
Mentor - Ricky Lee
@endsection

@section('template_fastload_css')
@endsection

@section('content')




<div class="" style="background-color: #000000; ">
    {{-- <div class="container"> --}}
        <br>

        <div class="container">
            <div class="row d-flex flex-row">
                <div class="col-5">
                    <div class="container">
                        <img class="w-100" src="{{ asset('images/courses/viber_image_2020-03-20_18-08-19.jpg')}}" alt="">
                    </div>
                    <h5 class="text-white text-center">
                        Since 1982, Dr. Ricky has been conducting free scriptwriting workshops for beginning writers, producing hundreds of graduates who now work for TV and film.
                    </h5>
                    <br>
                    <div class="row d-flex flex-row justify-content-center">
                            <a class="btn btn-sm btn-danger mb-2 col-5" href="#" role="button"
                                style="border-radius: 15px;">                             
                                <span style="font-size: 16px">
                                    Resume &raquo;
                                </span>
                            </a>
                            <div class="col-1">
        
                            </div>
                            <a class="btn btn-sm btn-danger mb-2 ml-2 col-5" href="#" role="button"
                                style="border-radius: 15px;">                         
                                <span style="font-size: 16px">
                                    Learning &raquo;
                                </span>
                            </a>
                    </div>
                </div>
                <div class="col-7">  
                    <div class="container">
                        <div class="m-3">              
                            <video id="player" controls playsinline
                            poster="{{ asset('images/patikim-thumbnail.png')}}"
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
                <div class="col-5 mr-0 pr-0">                
                    <div class="container mr-0 pr-0">
                        <img class="w-100" src="{{ asset('images/courses/Ricky Lee f008-1.webp')}}" alt="">
                    </div>
                </div>
                <div class="col-7 ml-0 pl-0">
                    <div class="container ml-0 pl-0 text-dark text-center h-100" style="background-color: #DBDBDB;">
                        <div class="px-5 pt-5">
                            <h3>
                                <strong>
                                    Welcome! Ricky Lee Scriptwriting Workshop
                                    <br>
                                    <span class="small text-left">
                                        August 12, 2020 - September 2, 2020
                                    </span>
                                </strong>
                            </h3>

                            <br>
    
                            <div class="container text-white p-3" style="background-color: #000000;">
                                <h4>
                                    To enter the Zoom webinar, click the button below to access the Zoom link. Please be sure to read the Rules & Guidelines before the workshop. 
                                    <br>
                                    <br>
                                    All workshop sessions will be recorded and made available in this page. Scroll down to review the session recordings.You may submit your project or activity and join the discussion at the bottom of each session page.
                                </h4>
                            </div>

                            <br>
                            
                            <div class="row justify-content-center">
                                <div class="px-5 w-50 ">
                                    <a class="btn btn-sm btn-danger btn-block mb-2 ml-2 " href="#" role="button"
                                    style="">                         
                                        <strong style="font-size: 20px">
                                            ENTER THE WORKSHOP
                                        </strong>
                                    </a>
                                    <i>*The workshop will be available starting August 12, 2020 (Wednesday).</i>
            
                                    <br>   
                                    <br>    
            
                                    <a class="btn btn-sm btn-danger btn-block mb-2 ml-2" href="#" role="button"
                                    style="">                         
                                        <span style="font-size: 16px">
                                            Rules & Guidelines
                                        </span>
                                    </a> 
            
                                    <a class="btn btn-sm btn-danger btn-block mb-2 ml-2 " href="#" role="button"
                                    style="">                         
                                        <span style="font-size: 16px">
                                            Resources and Materials
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div> <!-- row -->
        </div>

        <div class="container-fluid">
            <div class="row d-flex flex-row justify-content-center">
                <div class="col-3 row justify-content-center py-5" style="background-color: #000000;">
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
                                <a class="text-light" href="#">
                                    View &raquo;
                                </a>
                            </span>
                        </h5>
                    </div>
                </div>
                <div class="col-3 row justify-content-center py-5" style="background-color: #605E5E;">
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
                                August 19, 2020
                                <br>
                                <br>
                                <a class="text-light" href="#">
                                    View &raquo;
                                </a>
                            </span>
                        </h5>
                    </div>
                </div>
                <div class="col-3 row justify-content-center py-5" style="background-color: #EDEDED;">
                    <div class="col-6">
                        <img class="w-100" src="{{ asset('images/courses/chat-bubble.svg') }}" alt="">
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
                            <span class="small">
                                August 26, 2020
                                <br>
                                <br>
                                <a class="text-dark" href="#">
                                    View &raquo;
                                </a>
                            </span>
                        </h5>
                    </div>
                </div>
                <div class="col-3 row justify-content-center py-5" style="background-color: #E21C21;">
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
                                <a class="text-light" href="#">
                                    View &raquo;
                                </a>
                            </span>
                        </h5>
                    </div>
                </div>
            </div> <!-- row -->
        </div>

        

    {{-- </div> --}}<!-- container -->
</div>

@endsection

@section('footer_scripts')
@endsection