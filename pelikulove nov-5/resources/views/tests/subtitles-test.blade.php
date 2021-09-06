@extends('layouts.app')

@section('template_title')
    {{ $vod->title }}
@endsection

@section('videocss')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel='stylesheet' href='https://unpkg.com/plyr@3/dist/plyr.css'>
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
{{-- <div id="fb-root"></div> --}}

    <div class="bg-dark">
        <div class="container bg-dark col-10 video-container">
            <div class="row d-flex flex-row justify-content-center">
                @guest
                    @if (!isset($vod->video))
                        {{-- <a href="{!! url('/blackbox/redirector/' . $vod->id) !!}"> --}}
                        <a data-toggle="modal" data-target="#loginAndSignup">
                    @endif
                @endguest
                    <video id="video-frame" poster="{{ asset('images/vods/' . $vod->thumbnail) }}" controls playsinline>
                    </video>
                @guest
                    @if (!isset($vod->video))
                        </a>
                    @endif
                @endguest
            </div>
        </div>
    </div>

                
    <div class="container"> 
        <div class="row d-flex flex-row">		
            <div class="col-md-12 mt-3">
                    
                <div class="row">	
                    <div class="col-lg-12 col-md-12">   
                        @php
                            $purchase = \App\Models\VodPurchase::getPurchase($vod->id, Auth::id())
                        @endphp
                        @if (isset($purchase))
                            <div class="card bg-white shadow mb-1">   
                                <div class="card-body rounded bg-white shadow">
                                    <div class="row justify-content-between mx-4">           
                                        @php 
                                            $service = \App\Models\Service::find($purchase->order->service_id); 
                                            $days = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($purchase->created_at)->addDays($service['duration']));
                                            $hours = \Carbon\Carbon::now()->diffInHours(\Carbon\Carbon::parse($purchase->created_at)->addDays($service['duration'])->subDays($days));
                                            $minutes = \Carbon\Carbon::now()->diffInMinutes(\Carbon\Carbon::parse($purchase->created_at)->addDays($service['duration'])->subDays($days)->subHours($hours));
                                        @endphp
                                        <h5 class="mb-0">
                                            Time Left: 
                                            <strong>
                                                {{ \Carbon\Carbon::now()->diffForHumans(\Carbon\Carbon::parse($purchase->created_at)->addDays($service['duration']), ['syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE]) }}
                                            </strong>
                                        </h5>
                                        <h5 class="mb-0">
                                            Since: 
                                            <strong>
                                                {{ \Carbon\Carbon::parse($purchase->created_at)->isoFormat('lll') }}
                                            </strong>
                                        </h5>
                                        <h5 class="mb-0">
                                            Until: 
                                            <strong>
                                                {{ \Carbon\Carbon::parse($purchase->created_at)->addDays($service['duration'])->isoFormat('lll') }}
                                            </strong>
                                        </h5>
                                    </div> 
                                </div>
                            </div>  
                        @endif
                        <div class="card bg-white shadow">                  
                            <div class="card-body">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="{{ url('/blackbox') }}" class="text-danger">
                                                <i class="fa fa-home"></i>  Catalog
                                            </a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="{{ url('/blackbox/' . $vodCategory->id) }}" class="text-danger" >
                                                {{ $vodCategory->name }}
                                            </a>
                                        </li>
                                        <li class="ml-auto">
                                            <a href="{{ url('/blackbox') }}" class="text-danger" >
                                                <i class="fa fa-reply"></i>  Back
                                            </a>
                                        </li>
                                    </ol>
                                </nav>

                                <div class="row justify-content-between mx-2">                    
                                    <h4>
                                        {{-- Currently watching --}}
                                        <strong>
                                            {{ $vod->title }}
                                        </strong>
                                    </h4>
                                    <h5>
                                        <span class="small">
                                            <strong>
                                            Uploaded on: {{ \Carbon\Carbon::parse($vod->published_at)->isoFormat('ll') }}
                                            </strong>
                                        </span class="small">
                                    </h5>
                                </div>

                                @if (isset($vod->description))     
                                    <div class="card-body rounded bg-white shadow mb-5">
                                        <div class="row ml-1 justify-content-between">   
                                            <div class="">
                                                <h5>
                                                    {{-- <u> --}}
                                                        About {{ $vod->short_title }} 
                                                    {{-- </u> --}}
                                                    @if (isset($vod->maturity_rating))     
                                                        <span style="text-align: right;" class="badge badge-secondary ml-2">
                                                            {{ $vod->maturity_rating }}
                                                        </span>
                                                    @endif
                                                </h5>   
                                            </div>
                                        </div>
                                        <p id="course_title" class=""> 
                                            {!! $vod->description !!}
                                        </p>
                                        @if (isset($vodCrewTypes[0]))
                                            <hr>
                                            @foreach ($vodCrewTypes as $vodCrewType)
                                                <strong>
                                                    {{ $vodCrewType[0]->crew_type_name }}:
                                                </strong>
                                                @foreach ($vodCrewType as $crew)
                                                    <br>
                                                    @if (isset($crew->url))
                                                        <a href="{{ $crew->url }}">
                                                            {{ $crew->name }}
                                                        </a>                                            
                                                    @endif
                                                    @if (!$loop->last)                                                    
                                                        {{ $crew->name }}<strong>,</strong> 
                                                    @else
                                                        {{ $crew->name }}
                                                    @endif
                                                @endforeach  
                                                @if (!$loop->last)
                                                    <br>         
                                                    <br>    
                                                @endif                              
                                            @endforeach
                                        @endif  
                                        <hr>
                                        @if ($vodCategory->id == 14)
                                            LIKE our <a href="https://www.facebook.com/PelikuLOVE/">FB page</a> to stay updated on our #LakambiniSeries and other features! Share this post and help build Filipino creative communities together to strengthen our Filipino voice in the online global world!
                                        @else
                                            LIKE our <a href="https://www.facebook.com/PelikuLOVE/">FB page</a> for updates on our program schedule. Spread the word!
                                        @endif
                                    </div> 
                                @else 
                                    @if (isset($vodCrewTypes[0]))
                                        <div class="card-body rounded bg-white shadow mb-5">
                                            @foreach ($vodCrewTypes as $vodCrewType)
                                                <strong>
                                                    {{ $vodCrewType[0]->crew_type_name }}:
                                                </strong>
                                                @foreach ($vodCrewType as $crew)
                                                    <br>
                                                    @if (isset($crew->url))
                                                        <a href="{{ $crew->url }}">
                                                            {{ $crew->name }}
                                                        </a>                                            
                                                    @endif
                                                    @if (!$loop->last)                                                    
                                                        {{ $crew->name }}<strong>,</strong> 
                                                    @else
                                                        {{ $crew->name }}
                                                    @endif
                                                @endforeach  
                                                <br>         
                                                <br>                                  
                                            @endforeach
                                            <hr>
                                            LIKE our <a href="https://www.facebook.com/PelikuLOVE/">FB page</a> for updates on our program schedule. Spread the word!
                                        </div>
                                    @endif  
                                    <hr class="mb-5">
                                @endif                                 
                            </div>   
                        </div>
                    </div>
                </div><!--row-->
            </div><!--col-->
        </div>	<!-- row -->	 
    </div><!-- container -->
    
  @include('modals.modal-signup')
@endsection

@section('videojs2')
    <script src="{{ asset('/js/moment.js') }}"></script>
	<script src='https://cdn.polyfill.io/v2/polyfill.min.js?features=es6,Array.prototype.includes,CustomEvent,Object.entries,Object.values,URL'></script>
	<script src='https://unpkg.com/plyr@3'></script>

    <script id="plyr_script" type="text/javascript">
        // Change the second argument to your options:
        // https://github.com/sampotts/plyr/#options
        const player = new Plyr('video', { 
          captions: { 
            active: true, // show/hide subs on first play
            language: 'en' // default subs
          },
          autoplay: true,
          controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'volume', 'settings', 'pip', 'airplay', 'fullscreen'],
        //   settings: ['captions', 'speed'], 
          keyboard: { 
            focused: true, 
            global: true 
          },
        });
        
        // Expose player so it can be used from the console
        window.player = player;
        
        player.source = {
          type: 'video',
          title: 'yey',
        
          // define video file here
          sources: [
            { 
              //src: 'http://localhost:5000/video/1',
              @php 
                $implodeVideo = explode('.', $vod->video);  
                $implodeExtension = str_split($implodeVideo[sizeOf($implodeVideo)-1]);        
              @endphp
              src: '{{$vod->video}}',
              // src: '@foreach($implodeVideo as $videoPiece) @if (!$loop->last) "$videoPiece" + "." + @else @foreach ($implodeExtension as $extPiece) "$extPiece" @if(!$loop->last) + @endif @endforeach @endif @endforeach',
              type: 'video/mp4',
              size: 576
            }
          ],
          
          // define thumbnail here
          poster: "{{ asset('images/vods/' . $vod->thumbnail) }}",
        
          // define subs here
          tracks: [
            {
                kind: 'captions',
                label: 'English',
                srclang: 'en',
                // src: "{{$vod->transcript}}"  
                src: 'https://learn.pelikulove.com/repo/subtitles/Daddy%27s%20Girl%202020%20test.vtt'
            }
          ], 
          
          @if (isset($vod->preview_thumbnails))  
          previewThumbnails: { 
            enabled: true,    
            src: "{{$vod->preview_thumbnails}}"    
          }
          @endif
        };
        
        $(document).ready(function(){
          var videoSrc = $(".plyr__video-wrapper > video > source")
          var trackSrc = $(".plyr__video-wrapper > video > track")
        
          videoSrc[0].src = '';
          // trackSrc[0].src = '';
          videoSrc[0].remove();
          // trackSrc[0].remove();
        
          var thisScript = $("#plyr_script");
          thisScript.remove();
        });
        </script>
        
        <script>
          window.player = player;
        
        function timeFormatToHMMSS(time) {
          return moment.utc(time * 1000).format('H:mm:ss');
        }
        
        function getPlayerTimeData() {
        
          var rawTime = player.currentTime; // in secs
        
          var timeElapsed = timeFormatToHMMSS(rawTime);
          var timeLeft = timeFormatToHMMSS(player.duration - rawTime);
        
          return { 
            timeElapsed: timeElapsed,
            timeLeft: timeLeft
          };
        }
        
        function isMobile() {
          let isMobile = window.matchMedia("only screen and (max-width: 767px)").matches;
        
          return isMobile;
        }
        
        player.on('ended', evt => {
            //
        });
        
        // On Fullscreen
        player.on('enterfullscreen', evt => {
          if (isMobile()) {
            screen.orientation.lock("landscape");
          }
        })
        
        // On Exit Fullscreen
        player.on('exitfullscreen', evt => {
          if (isMobile()) {
            screen.orientation.unlock();
          }
        })
        
        $(document).ready(function(){
          $(".plyr__volume" ).prop("hidden", 0);
          $(".plyr__control" ).prop("hidden", 0);
        
          @if (Auth::check())
            player.play();
          @endif
        });
        
        $( ".plyr" ).click(function(){
          $( ".plyr__volume" ).prop("hidden", 0);
          $( ".plyr__control" ).prop("hidden", 0);
        });
        </script>
@endsection	

@section('footer_scripts')    

    @include('scripts.signup-modal')

    <script>
        $(document).ready(function(){
            reSizeSlideshow(); 

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
            
        $('.vod-body').on('shown.bs.popover', function (e) {
            // console.log(e.target);
            var popperDiv = e.target;
            // console.log(popperDiv.getAttribute("value"));
            var valueSplit = popperDiv.getAttribute("value").split(" ");

            var duration = valueSplit[0];
            var year_released = valueSplit[1];

            var popperID = popperDiv.getAttribute("aria-describedby");
            var popperTooltip = document.getElementById(popperID);

            
            // console.log(popperDiv);
            // console.log(popperTooltip);
        })

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
                $('.video-container').removeClass("col-10");
                $('.video-container').addClass("col-12"); 
                $('.video-container').css("max-width", "100%");      
            } else { 
                // Contract Slideshow
                $('.video-container').removeClass("col-12");    
                $('.video-container').addClass("col-10"); 
                $('.video-container').css("max-width", "79.8%");             
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

        @if (!Auth::check())
            $("#loginAndSignup").modal()
        @endif
        
    </script>

@endsection
