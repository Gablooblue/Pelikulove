@extends('layouts.app')

@section('template_title')
    Blackbox {!! $vodCategory->name !!}
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

<div class="container-fluid">
    <div class="row d-flex flex-row main-row">
        <div class="col-md-12 col-lg-12">
            <div class="card shadow bg-white rounded">
                <div class="card-body">
                    <!-- category 1  -->
                    <div class="section mt-5">                
                        <div class="card-body bg-white shadow mb-5">
                            <!-- Title of POV category -->
                            <div class="" style="text-align:center;">
                                <div class="badge badge-info d-block">
                                    <strong>
                                        <h2 class="m-1 text-wrap" style="font-weight:bold;">
                                                {!! $vodCategory->name !!}
                                        </h2>   
                                    </strong> 
                                </div>
                            </div>
                            <hr>
                            <p id="desc_title" class=""> 
                                {!! $vodCategory->description !!}     
                            </p>
                            @if ($vodCategory->id == 15)
                                <div class="row justify-content-between mx-2">        
                                    <a class="btn-lg btn-success mb-2 text-center"
                                        href="{{url('/course/1/enroll')}}" role="button"> 
                                        <i class="fa fa-sign-in"></i> Enroll Now
                                    </a>   

                                    <div class="text-center">
                                        <a class="btn btn-secondary text-center" 
                                            href="{{ url('/blackbox') }}" role="button">
                                            <i class="fa fa-reply"></i> Back to Catalog
                                        </a> 
                                    </div>  
                                </div>
                            @else
                                <div class="row justify-content-end">                              
                                    <a class="mr-4 btn btn-secondary" href="{{ url('/blackbox') }}">
                                        <i class="fa fa-reply"></i> Back to Catalog
                                    </a>    
                                </div>
                            @endif
                        </div>

                        <!-- start of category contents  -->
                        <div class="row mx-1">
                            @foreach($vods as $vod)
                                <div class="col-md-4 px-4 mb-4 vod-body" data-toggle="popover" title="{{ $vod->short_title }}" 
                                    data-content="{{ \Illuminate\Support\Str::limit($vod->description_2, 250, $end='...') }}">
                                        <div class="position-relative">
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
                                                <strong >
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
                        <!-- end of category contents  -->
                            
                    </div>
                    <!-- end of category 1  -->

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_scripts')

    <script>
        $('#myCarousel2').carousel({
            interval: 1000
        }).on('slide.bs.carousel', function() {
            document.getElementById('player').pause();
        });

        $(document).ready(function(){    
            reSizeSlideshow();
            
            $('[data-toggle="popover"]').popover({
                placement: 'top',
                trigger: 'hover',
                animation: true,
            });
            
            $('.vod-body').on('inserted.bs.popover', function (e) {         
                reSizePoppers();
            })
        }); 

        $(window).resize(function(){
            reSizeSlideshow();
        }); 

        function isMobile() {
            let isMobile = window.matchMedia("only screen and (max-width: 767px)").matches;

            return isMobile;
        } 

        function reSizeSlideshow() {
            if (isMobile()) {         
                // Expand Slideshow     
                $('.desktop-mode').css("display", "none");  
                $('.mobile-mode').css("display", "block");  
                
                $('.main-row').removeClass("mx-5");              
            } else { 
                // Contract Slideshow
                $('.mobile-mode').css("display", "none");    
                $('.desktop-mode').css("display", "block"); 
                 
                $('.main-row').addClass("mx-5");            
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
