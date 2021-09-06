@extends('layouts.app')

@section('template_title')
    Blackbox Catalog
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
        border-bottom: 0;
    }
    
    .popover-body {
        margin: 2px;
        background-color: #444;
        color: aliceblue;
        font-size: 1.2em;
    }

@endsection

@section('content')

<div class="bg-dark">
    <div class="container bg-dark col-10 slideshow-container">
        <div class="row d-flex flex-row">
            <div class="col-md-12 col-lg-12 px-0">
                <div id="vodSlideshow" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @for ($index = 0; $index < sizeOf($vodSlideshows); $index++)       
                            @if (isset($vodSlideshows[$index]->thumbnail))                                     
                                <div class="carousel-item @if ($index == 0) active @endif">
                                    @if (isset($vodSlideshows[$index]->url))
                                        <a href="{{ $vodSlideshows[$index]->url }}" target="_blank" rel="noopener noreferrer">
                                    @endif
                                    
                                    <img class="d-block" style="max-width: 100%;" 
                                    src="{{ asset('images/slideshows/' . $vodSlideshows[$index]->thumbnail) }}" alt="Slide {{ $index+1 }}">

                                    @if (isset($vodSlideshows[$index]->url))
                                        </a>
                                    @endif
                                </div>
                            @elseif (isset($vodSlideshows[$index]->video))
                                <div class="carousel-item @if ($index == 0) active @endif" oncontextmenu="return false;">
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <video id="player" controls playsinline
                                            poster="{{ asset($vodSlideshows[$index]->video_thumbnail)}}">
                                            <source src="{{$vodSlideshows[$index]->video}}" />
                                        </video>
                                    </div>
                                </div>                                    
                            @endif
                        @endfor
                        
                        <a class="carousel-control-prev" href="#vodSlideshow" role="button" data-slide="prev"
                        style="top: 50%; transform: translateY(-50%); height: 50vh; max-height: 50%;">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#vodSlideshow" role="button" data-slide="next"
                        style="top: 50%; transform: translateY(-50%); height: 50vh; max-height: 50%;">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row d-flex flex-row">
        <div class="vod-cat">
            <div class="card shadow bg-white rounded" >
                <div class="card-body" style="background-color: #;">
                    @foreach($vodCategories as $vodCategory)
                        <div class="section mt-5">

                            {{-- Get Total Number Of Slides --}}
                            {{-- Each Slide has 6 Items/Videos --}}
                            @php 
                                if ($vodCategory[0]->name == "Video On Demand") {
                                    $vodCatSlides = ceil((sizeof($vodCategory)+1) / 6); 
                                } else {
                                    $vodCatSlides = ceil(sizeof($vodCategory) / 6); 
                                }
                            @endphp

                            {{-- If there are more than 1 Slides, Add Carousel --}}
                            @if ($vodCatSlides > 1)
                                <div id="category-slide-carousel-{{ $vodCategory[0]->id }}" class="carousel slide carousel-multi-item" data-ride="carousel">
                            @endif                             

                            <!-- Category Title Start -->
                            <div class="row mb-3 d-flex justify-content-between mr-3 ml-3">
                                <div class="row">
                                    <h4 class="mr-3" style="font-weight:bold;">
                                        {!! $vodCategory[0]->name !!}
                                    </h4>

                                    {{-- If there are more than 1 Slides, Add Carousel Controlls --}}
                                    <!--Controls-->
                                    @if ($vodCatSlides > 1)
                                        <div class="desktop-mode">                                            
                                            <a class="btn-floating mr-2" href="#category-slide-carousel-{{ $vodCategory[0]->id }}" data-slide="prev">
                                                <i class="fa fa-2x fw fa-chevron-circle-left" style="color: rgb(200, 100, 100);"></i>
                                            </a>
                                            <a class="btn-floating" href="#category-slide-carousel-{{ $vodCategory[0]->id }}" data-slide="next">
                                                <i class="fa fa-2x fw fa-chevron-circle-right" style="color: rgb(200, 100, 100);"></i>
                                            </a>  
                                        </div>
                                    @endif 
                                    <!--Controls End-->  
                                </div>
                                
                                {{-- If there are more than 1 Slides, Add View More Button Leading to Category Catalog --}}
                                @if ($vodCatSlides > 1)
                                    <div class="pt-1 pb-1">
                                            <a class="row" href="{{ url('/blackbox/' . $vodCategory[0]->category_id) }}"> 
                                                <h5>     
                                                    View more 
                                                </h5>
                                                <i class="fa fa-angle-double-right fa-lg ml-1 mt-1"></i>
                                            </a>
                                    </div>
                                @endif
                            </div>
                            <!-- Category Title End -->  

                            <!-- Vod Slides Start -->
                            {{-- If Category has more than 1 Slides --}}
                            @if ($vodCatSlides > 1)
                                <div class="desktop-mode">             
                                    <div class="carousel-inner" role="listbox">
                                        @php $vodIndex = 0; @endphp
                                        
                                        {{-- Carousel Slides --}}
                                        @for($slideCount = 0; $slideCount < $vodCatSlides; $slideCount++)  
                                            <div class="carousel-item @if ($slideCount==0) active @endif">
                                                <div class="row mx-1">     
    
                                                    {{-- Vods in Slides --}} 
                                                    @for ($slideVodCount = 0; $slideVodCount<6; $slideVodCount++)
                                                        @if (isset($vodCategory[$vodIndex]))
                                                            <div class="col-md-4 pd-2 mb-3 vod-body" data-toggle="popover" title="{{ $vodCategory[$vodIndex]->short_title }}" 
                                                                data-content="{{ \Illuminate\Support\Str::limit($vodCategory[$vodIndex]->description_2, 250, $end='...') }}">
                                                                <div class="position-relative mx-1 mb-3">
                                                                    @php 
                                                                        if (Auth::check()) {
                                                                            $owned = \App\Models\VodPurchase::ifOwned($vodCategory[$vodIndex]->id, Auth::user()->id);
                                                                        }
                                                                        else {
                                                                            $owned = false;
                                                                        }
                                                                    @endphp
                                                                    <a href="{{url('blackbox/' . $vodCategory[$vodIndex]->id . '/watch')}}" 
                                                                        class="stretched-link" style="text-decoration:none;">
                                                                        <img class=" d-block w-100 mb-3" src="{{ asset('images/vods/'.$vodCategory[$vodIndex]->thumbnail) }}"
                                                                            style="border-radius:10px;" alt="{{ $vodCategory[$vodIndex]->short_title }}">
                                                                    </a>
                                                                    
                                                                    <div class="row justify-content-center mt-n4 position-relative">
                                                                        @if ($vodCategory[$vodIndex]->paid == 1)
                                                                            @if ($owned)                                                                                
                                                                                <a href="#" class="mx-2 py-1 font-weight-bold btn btn-block rounded btn-info btn-vod" 
                                                                                style="font-size: 1.2em; background-color: cornflowerblue; border-color: cornflowerblue">
                                                                                    Pay per view
                                                                                </a>  
                                                                            @else                                                                                  
                                                                                <a href="#" class="mx-2 py-1 font-weight-bold btn btn-block rounded btn-info btn-vod" 
                                                                                style="font-size: 1.2em; background-color: cornflowerblue; border-color: cornflowerblue">
                                                                                    Pay per view
                                                                                </a>  
                                                                            @endif    
                                                                        @else   
                                                                            <a href="#" class="mx-2 py-1 font-weight-bold btn btn-block rounded btn-info btn-vod" 
                                                                            style="font-size: 1.2em;">
                                                                                Watch Now    
                                                                            </a>                                                                
                                                                        @endif
                                                                    </div>

                                                                    <div class="mt-2">
                                                                        <h5 class="" style="text-align: center;">
                                                                            <strong>
                                                                                {{ $vodCategory[$vodIndex]->short_title }}
                                                                            </strong>
                                                                            @if (isset($vodCategory[$vodIndex]->directors) && $vodCategory[$vodIndex]->category_id == 3)
                                                                                <br>
                                                                                <span class="small">
                                                                                    @foreach ($vodCategory[$vodIndex]->directors as $director)
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
                                                        
                                                        @php $vodIndex++; @endphp
                                                    @endfor
                                                    {{-- /.Vods in Slides --}}   
                                                </div>
                                            </div>
                                        @endfor      
                                        {{-- /.Carousel Slides --}}                               
                                    </div>
                                </div>
                                
                                {{-- Display for mobile --}}
                                <div class="row mobile-mode mx-1">
                                    @for ($mobileIndex = 0; $mobileIndex < 3; $mobileIndex++)
                                        <div class="col-md-4 pd-2 mb-3 vod-body" data-toggle="popover" title="{{ $vodCategory[$mobileIndex]->short_title }}" 
                                            data-content="{{ \Illuminate\Support\Str::limit($vodCategory[$mobileIndex]->description_2, 250, $end='...') }}">
                                            <div class="position-relative mx-1 mb-3">
                                                @php 
                                                    if (Auth::check()) {
                                                        $owned = \App\Models\VodPurchase::ifOwned($vodCategory[$mobileIndex]->id, Auth::user()->id);
                                                    }
                                                    else {
                                                        $owned = false;
                                                    }
                                                @endphp
                                                <a href="{{url('blackbox/' . $vodCategory[$mobileIndex]->id . '/watch')}}" 
                                                    class="stretched-link" style="text-decoration:none;">
                                                    <img class=" d-block w-100 mb-3" src="{{ asset('images/vods/'.$vodCategory[$mobileIndex]->thumbnail) }}"
                                                        style="border-radius:10px;" alt="{{ $vodCategory[$mobileIndex]->short_title }}">
                                                </a>
                                                
                                                <div class="row justify-content-center mt-n4 position-relative">
                                                    @if ($vodCategory[$mobileIndex]->paid == 1)
                                                        @if ($owned)
                                                            <a href="#" class="mx-2 py-1 font-weight-bold btn btn-block rounded btn-info btn-vod" 
                                                            style="font-size: 1.2em; background-color: cornflowerblue; border-color: cornflowerblue">
                                                                Pay per view
                                                            </a>  
                                                        @else  
                                                            <a href="#" class="mx-2 py-1 font-weight-bold btn btn-block rounded btn-info btn-vod" 
                                                            style="font-size: 1.2em; background-color: cornflowerblue; border-color: cornflowerblue">
                                                                Pay per view   
                                                            </a>  
                                                        @endif    
                                                    @else   
                                                        <a href="#" class="mx-2 py-1 font-weight-bold btn btn-block rounded btn-info btn-vod" 
                                                        style="font-size: 1.2em;">
                                                            Watch Now    
                                                        </a>                                                                
                                                    @endif
                                                </div>

                                                <div class="mt-2">
                                                    <h5 class="" style="text-align: center;">
                                                        <strong>
                                                            {{ $vodCategory[$mobileIndex]->short_title }}
                                                        </strong>
                                                        @if (isset($vodCategory[$mobileIndex]->directors) && $vodCategory[$mobileIndex]->category_id == 3)
                                                            <br>
                                                            <span class="small">
                                                                @foreach ($vodCategory[$mobileIndex]->directors as $director)
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
                                    @endfor 
                                    <div class="container mb-4">
                                        <hr class="mx-3">
                                        <div class="row justify-content-center">
                                            <a class="row" href="{{ url('/blackbox/' . $vodCategory[0]->category_id) }}"> 
                                                <h5>     
                                                    <strong>
                                                        View more 
                                                    </strong>
                                                </h5>
                                                <i class="fa fa-angle-double-right fa-lg ml-1 mt-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>   
                            @else 
                                {{-- Display 3 or less Vods --}}
                                <div class="row mx-1">
                                    {{-- Adding a Course as a Vod --}}
                                    {{-- Recommend transfering to its own categeory --}}
                                    @if ($vodCategory[0]->name == "Video On Demand")
                                    <div class="col-md-4 pd-2 mb-3 vod-body" data-toggle="popover" title="{{ $course->short_title }}" 
                                    data-content="{{ \Illuminate\Support\Str::limit("$course->description_2", 250, $end='...') }}">
                                        <div class="position-relative mx-1 mb-3">
                                            <a href="{{ url('/course/' . $course->id . '/show')}}" 
                                                class="stretched-link" style="text-decoration:none;">
                                                <img class=" d-block w-100 mb-3" src="{{ asset('images/courses/' . $course->thumbnail_vod) }}"
                                                    style="border-radius:10px;" alt="{{ $course->short_title }}">
                                            </a>
                                            @php 
                                                if (Auth::check())
                                                    $enrolled = \App\Models\LearnerCourse::getEnrollment(1, Auth::user()->id); 
                                                else 
                                                    $enrolled = false;
                                            @endphp
                                            <div class="row justify-content-center mt-n4 position-relative">
                                                @if ($enrolled)  
                                                    <a href="#" class="mx-2 py-1 font-weight-bold btn btn-block rounded btn-info btn-vod" 
                                                    style="font-size: 1.2em; background-color: cornflowerblue; border-color: cornflowerblue">
                                                        Resume Learning
                                                    </a> 
                                                @else    
                                                    <a href="#" class="mx-2 py-1 font-weight-bold btn btn-block rounded btn-info btn-vod" 
                                                    style="font-size: 1.2em; background-color: cornflowerblue; border-color: cornflowerblue">
                                                        Enroll Now
                                                    </a> 
                                                @endif    
                                            </div>

                                            <div class="mt-2">
                                                <h5 class="" style="text-align: center;">
                                                    <strong >
                                                        {{ $course->short_title }}
                                                    </strong>                                                            
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @foreach($vodCategory as $vod)
                                        <div class="col-md-4 pd-2 mb-3 vod-body" data-toggle="popover" title="{{ $vod->short_title }}" 
                                        data-content="{{ \Illuminate\Support\Str::limit($vod->description_2, 250, $end='...') }}">
                                            <div class="position-relative mx-1 mb-3">
                                                @php 
                                                    if (Auth::check()) {
                                                        $owned = \App\Models\VodPurchase::ifOwned($vod->id, Auth::user()->id);
                                                    }
                                                    else {
                                                        $owned = false;
                                                    }
                                                @endphp
                                                <a href="{{url('blackbox/' . $vod->id . '/watch')}}" 
                                                    class="stretched-link" style="text-decoration:none;">
                                                    <img class=" d-block w-100 mb-3" src="{{ asset('images/vods/'.$vod->thumbnail) }}"
                                                        style="border-radius:10px;" alt="{{ $vod->short_title }}">
                                                </a>
                                                
                                                <div class="row justify-content-center mt-n4 position-relative">
                                                    @if ($vod->paid == 1)
                                                        @if ($owned)  
                                                            <a href="#" class="mx-2 py-1 font-weight-bold btn btn-block rounded btn-info btn-vod" 
                                                            style="font-size: 1.2em; background-color: cornflowerblue; border-color: cornflowerblue">
                                                                Pay per view
                                                            </a> 
                                                        @else    
                                                            <a href="#" class="mx-2 py-1 font-weight-bold btn btn-block rounded btn-info btn-vod" 
                                                            style="font-size: 1.2em; background-color: cornflowerblue; border-color: cornflowerblue">
                                                                Pay per view  
                                                            </a> 
                                                        @endif    
                                                    @else   
                                                        <a href="#" class="mx-2 py-1 font-weight-bold btn btn-block rounded btn-info btn-vod" 
                                                        style="font-size: 1.2em;">
                                                            Watch Now    
                                                        </a>                                                                
                                                    @endif
                                                </div>

                                                <div class="mt-2">
                                                    <h5 class="" style="text-align: center;">
                                                        <strong>
                                                            {{ $vod->short_title }}
                                                        </strong>
                                                        @if (isset($vod->directors) && $vod->category_id == 3)
                                                            <br>
                                                            <span class="small">
                                                                @foreach ($vod->directors as $director)
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
                                    @endforeach    
                                </div>                                  
                            @endif  
                            <!-- Vod Slides End -->        

                            @if ($vodCatSlides > 1)
                                </div>
                            @endif             
                        </div>
                        <hr class="mb-n1 bg-info " style="border: 1px solid #17a2b8;">
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <div class="row justify-content-center mb-0">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mx-1 row justify-content-center">
        <a class="mr-2 mb-2" href="https://www.facebook.com/TripToQuiapo/posts/3171576436233928" target="_blank">
            <button class="btn btn-lg btn-danger p-2 px-3 mb-2">
                Get His Books
            </button>
        </a> 
    </div>

    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mx-1 row justify-content-center">
        <a class="mr-2 mb-2" href="#" target="_blank">
            <button class="btn btn-lg btn-danger p-2 px-3 mb-2">
                Enter The Workshop
            </button>
        </a>         
    </div>
</div> --}}

@endsection

@section('footer_scripts')

    <script>
        $(document).ready(function(){    
            reSizeSlideshow();
            $('#vodSlideshow').carousel({
                interval: 5000
            });

            $('.category-slide-carousel').carousel('pause');
            
            $('[data-toggle="popover"]').popover({
                placement: 'top',
                trigger: 'hover',
                animation: true,
                template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-badges row justify-content-center"></div><div class="popover-body"></div></div>',
            });

            // var x = document.getElementsByTagName("BODY")[0];
            // x.style.backgroundColor = "#";
            
            $('.vod-body').on('inserted.bs.popover', function (e) {   
                reSizePoppers();
            })
        }); 

        $(window).resize(function(){
            reSizeSlideshow();
        }); 
    
        function isMobile() {
            let isMobile = window.matchMedia("only screen and (max-width: 767px)").matches;
            // let isMobile = window.matchMedia(`(max-device-${window.matchMedia('(orientation: portrait)').matches?'width':'height'}: ${670}px)`).matches

            return isMobile;
        } 

        function reSizeSlideshow() {
            if (isMobile()) {         
                // Expand Slideshow     
                $('.slideshow-container').removeClass("col-10");
                $('.slideshow-container').addClass("col-12"); 
                $('.slideshow-container').css("max-width", "100%");    

                $('.desktop-mode').css("display", "none");  
                $('.mobile-mode').css("display", "block");    
            } else { 
                // Contract Slideshow
                $('.slideshow-container').removeClass("col-12");    
                $('.slideshow-container').addClass("col-10"); 
                $('.slideshow-container').css("max-width", "81.1%");     

                $('.mobile-mode').css("display", "none");    
                $('.desktop-mode').css("display", "block");          
            }
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
