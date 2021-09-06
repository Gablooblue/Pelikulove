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
{{-- <div id="fb-root"></div> --}}

    <div class="bg-dark">
        <div class="container bg-dark col-10 video-container">
            <div class="row d-flex flex-row justify-content-center">
                <div style="display: none">
                    <div>
                        <span class="small">Up Next</span>                    
                        <br>
                        @if (isset($nextVod))
                            <a href="{{url('blackbox/' . $nextVod->id . '/watch')}}">
                                {{ $nextVod->title }}
                            </a>
                        @endif
                        <strong>CANCEL</strong>   

                    </div>
    
                    <div class="container-fluid" style="background-color: black; opacity: 0.2;">
                    </div>
                </div>

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
                                        <li class="ml-auto mt-auto hidden-sm hidden-xs">
                                            <a href="{{ url('/blackbox') }}" class="text-danger" >
                                                <i class="fa fa-reply"></i>  Back
                                            </a>
                                        </li>
                                        <li class="hidden-md hidden-lg hidden-xl mt-3">
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

                                @if (isset($vod->description) || isset($vodCrewTypes[0]) || $vodCategory->id == 18 || $vodCategory->id == 14 || $vod->donate_btn == 1)     
                                    <div class="card-body rounded bg-white shadow mb-5">
                                        <div class="row mx-1 justify-content-between">   
                                            <div class="mt-1">
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
                                        @if ($vodCategory->id == 18)
                                            <hr>
                                            <div class="row justify-content-center mb-0">
                                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mx-1 row justify-content-center">
                                                    <a class="mr-2 mb-2" href="https://www.facebook.com/TripToQuiapo/posts/3171576436233928" target="_blank">
                                                        <button class="btn btn-lg btn-danger p-2 px-3 mb-2">
                                                            Get His Books
                                                        </button>
                                                    </a> 
                                                </div>
                                            
                                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mx-1 row justify-content-center">
                                                    <a class="mr-2 mb-2" href="https://us02web.zoom.us/j/89108837572?pwd=U2Q4REFQT0szTEMwYzRuQzlJTVR2UT09" target="_blank">
                                                        <button class="btn btn-lg btn-danger p-2 px-3 mb-2">
                                                            Enter The Workshop
                                                        </button>
                                                    </a>         
                                                </div>
                                            </div>
                                            <hr class="mt-0">
                                            <div class="container-fluid slideshow-container">
                                                <div class="row d-flex flex-row justify-content-center">
                                                    <div class="col-md-10 col-lg-8 col-xl-7 px-0">
                                                        <div id="vodSlideshow" class="carousel slide" data-ride="carousel">
                                                            <div class="carousel-inner">   
                                                
                                                                <div class="carousel-item active">
                                                                    <img class="d-block m-0" style="max-width: 100%;" 
                                                                    src="{{asset('images/rickylee_books_bahaynimarta-2.png')}}" alt="rickylee_books_bahaynimarta.png">
                                                                </div>             
                                                                <div class="carousel-item">
                                                                    <img class="d-block" style="max-width: 100%;" 
                                                                    src="{{asset('images/rickylee_books_kungalam-2.png')}}" alt="rickylee_books_kungalam.png">
                                                                </div>     
                                                                <div class="carousel-item">
                                                                    <img class="d-block" style="max-width: 100%;" 
                                                                    src="{{asset('images/rickylee_books_parakayb-2.png')}}" alt="rickylee_books_parakayb.png">
                                                                </div>     
                                                                <div class="carousel-item">
                                                                    <img class="d-block" style="max-width: 100%;" 
                                                                    src="{{asset('images/rickylee_books_sapusonghimala-2.png')}}" alt="rickylee_books_sapusonghimala.png">
                                                                </div>     
                                                                <div class="carousel-item">
                                                                    <img class="d-block" style="max-width: 100%;" 
                                                                    src="{{asset('images/rickylee_books_siamapola-2.png')}}" alt="rickylee_books_siamapola.png">
                                                                </div>     
                                                                <div class="carousel-item">
                                                                    <img class="d-block" style="max-width: 100%;" 
                                                                    src="{{asset('images/rickylee_books_sitatang-2.png')}}" alt="rickylee_books_sitatang.png">
                                                                </div>     
                                                                <div class="carousel-item">
                                                                    <img class="d-block" style="max-width: 100%;" 
                                                                    src="{{asset('images/rickylee_books_triptoquiapo-2.png')}}" alt="rickylee_books_triptoquiapo.png">
                                                                </div>     
                                                                <div class="carousel-item">
                                                                    <img class="d-block" style="max-width: 100%;" 
                                                                    src="{{asset('images/rickylee_books_workbook-2.png')}}" alt="rickylee_books_workbook.png">
                                                                </div>

                                                                
                                                                <a class="carousel-control-prev" href="#vodSlideshow" role="button" data-slide="prev"
                                                                style="top: 50%; transform: translateY(-50%); height: 50vh; max-height: 50%;">
                                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                                    <span class="sr-only">Previous</span>
                                                                </a>
                                                                <a class="carousel-control-next" href="#vodSlideshow" role="button" data-slide="next"
                                                                style="top: 50%; transform: translateY(-50%); height: 50vh; max-height: 50%; filter: brightness(1.75);">
                                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                                    <span class="sr-only">Next</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                            
                                        <hr>
                                        @if ($vodCategory->id == 14)
                                            LIKE our <a href="https://www.facebook.com/PelikuLOVE/">FB page</a> to stay updated on our #LakambiniSeries and other features! Share this post and help build Filipino creative communities together to strengthen our Filipino voice in the online global world!
                                        @else
                                            LIKE our <a href="https://www.facebook.com/PelikuLOVE/">FB page</a> for updates on our program schedule. Spread the word!
                                        @endif
                                        @if ($vod->donate_btn == 1)
                                            <hr>
                                            <div class="row">
                                                <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-xs-12">  
                                                    <h5>
                                                        <strong>                     
                                                            Say Yes to a World with Arts..
                                                        </strong>
                                                    </h5>                   
                                                        Life’s already tough. Now imagine if you don’t have a song, a movie, a TV series, or a book to help you.
                                                         What will the world look and feel like? Mas mahirap at malungkot siguro.  <br>
                                                        <br>
                                                        Donation = Yes and thank you to artists and the arts! <br>
                                                        <br>
                                                        Our team has been pouring our hearts, time, effort, and resources into making and sustaining Pelikulove,
                                                         even before the pandemic. Pelikulove was built on the backs of our team, friends, families, OJTs,
                                                         volunteers, and several good people, and you guys. You have all helped us make it this far. And we hope
                                                         we’ll continue to be in this together.<br>
                                                        <br>
                                                        Pelikulove offerings are mainly free of charge and we hope to keep it that way for some of our programs.
                                                         But we also hope to do more and offer more that will help sustain Pelikulove and its artists. <br>
                                                        <br>
                                                        If you find joy and believe in what we are trying to do and achieve, please consider donating to this
                                                         project or to the platform. Your support will really help confirm we’ve chosen the right path...and
                                                         aren’t just crazy to stay on it.<br>
                                                        <br>
                                                        Maraming salamat kapatid! <br>
                                                        <br>
                                                        *PELIKULOVE is a small team of hardworking creatives & tech. We aim to harness
                                                         the power of arts, culture, and technology to help build a better society 
                                                         where artists and cultural groups can be sustained, collaborate, and build 
                                                         communities together to strengthen the Filipino voice.<br>
                                                    </p>

                                                    {{-- /*

                                                        Life’s already tough. Now imagine if you don’t have a song, a movie, a TV series, or a book to help you. What will the world look and feel like? Mas mahirap at malungkot siguro. 

                                                        Donation = Yes and thank you to artists and the arts! 

                                                        Our team has been pouring our hearts, time, effort, and resources into making and sustaining Pelikulove, even before the pandemic. Pelikulove was built on the backs of our team, friends, families, OJTs, volunteers, and several good people, and you guys. You have all helped us make it this far. And we hope we’ll continue to be in this together. 

                                                        Pelikulove offerings are mainly free of charge and we hope to keep it that way for some of our programs. But we also hope to do more and offer more that will help sustain Pelikulove and its artists. 

                                                        If you find joy and believe in what we are trying to do and achieve, please consider donating to this project or to the platform. Your support will really help confirm we’ve chosen the right path...and aren’t just crazy to stay on it.

                                                        Maraming salamat kapatid! 

                                                    */ --}}
                                                </div>
                                                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-xs-12 align-self-center text-center my-1 mb-3">  
                                                    <a href="https://pelikulove.com/covid-memoirs/#pray-for-wuhan" target="_blank">
                                                        <img class="w-100" src="{{ asset('images/donation_img-3.png') }}" alt="">
                                                    </a>
                                                    {{-- <br>
                                                    <a href="https://pelikulove.com/covid-memoirs/#pray-for-wuhan" target="_blank">
                                                        #PRAYFORWUHAN (COVID-19 ARTWORK SERIES) <br>
                                                    </a>
                                                    By: Josef Lee --}}
                                                </div>
                                            </div>
                                            
                                            <div class="mx-2">
                                                <a class="mr-2 mb-2" href="{{ route('donations.create') }}" target="_blank">
                                                    <button class="btn btn-lg btn-success p-2 px-3 mb-2">
                                                        Support Pelikulove 
                                                        <i class="fa fa-arrow-right fa-fw" aria-hidden="true"></i>
                                                    </button>
                                                </a> 
                                                <br>
                                                <div class="row">
                                                    <div class="col-5">
                                                        <img class="mb-2 w-25" src="{{ asset('images/logo_dragonpay.png') }}" alt="">
                                                        <img class="mb-1 w-25" src="{{ asset('images/logo_paypal.png') }}" alt=""> 
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div> 
                                @endif 

                                {{-- Category Vods start here --}}
                                @if (isset($categoryVods[0]))
                                    {{-- <div class="row lesson"> --}}
                                    <!-- category 1  -->
                                    <div class="section">
                                        <!-- POV category Title Start -->
                                        <div class="row mb-2 d-flex justify-content-between mr-3 ml-3">
                                            <div class="row">
                                                <h4 class="mr-3" style="font-weight:bold;">
                                                    Other {!! $vodCategory->name !!}
                                                </h4>
                                            </div>
                                            @if (isset($categoryVods[3]))
                                                <div class="mt-1 pb-1">
                                                    <a class="row" href="{{ url('/blackbox/' . $vodCategory->id) }}">
                                                        <h5>     
                                                            View more 
                                                        </h5>
                                                        <i class="fa fa-angle-double-right fa-lg ml-1 mt-1"></i>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                        <!-- POV category Title End  -->                                  
                                        <div class="section mt-3 mx-2">
                                        <!-- Category Vods Row  -->
                                            <div class="row">
                                                @for ($index = 0; $index < 6; $index++)
                                                    @if (isset($categoryVods[$index])) 
                                                        <div class="col-md-4 pd-2 mb-4 vod-body" data-toggle="popover" title="{{ $categoryVods[$index]->short_title }}" 
                                                            value="{{ $categoryVods[$index]->duration }} {{ $categoryVods[$index]->year_released }}"
                                                            data-content="{{ \Illuminate\Support\Str::limit($categoryVods[$index]->description_2, 250, $end='...') }}">
                                                            <div class="position-relative"> 
                                                                @php 
                                                                    if (Auth::check()) {
                                                                        $owned = \App\Models\VodPurchase::ifOwned($categoryVods[$index]->id, Auth::user()->id);
                                                                    }
                                                                    else {
                                                                        $owned = false;
                                                                    }
                                                                @endphp
                                                                <a href="{{url('blackbox/' . $categoryVods[$index]->id . '/watch')}}" 
                                                                    class="stretched-link" style="text-decoration:none;">
                                                                    <img class=" d-block w-100 mb-3" src="{{ asset('images/vods/'.$categoryVods[$index]->thumbnail) }}"
                                                                        style="border-radius:10px;" alt="{{ $categoryVods[$index]->short_title }}">
                                                                </a>
                                                                
                                                                <div class="row justify-content-center mt-n4 position-relative">
                                                                    @if ($categoryVods[$index]->paid == 1)
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
                                                                            {!! $categoryVods[$index]->short_title !!}
                                                                        </strong>    
                                                                        @if (isset($categoryVods[$index]->directors) && $categoryVods[$index]->category_id == 3)
                                                                            <br>
                                                                            <span class="small">
                                                                                @foreach ($categoryVods[$index]->directors as $director)
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
                                        </div>
                                        <!-- end of category contents  -->
                                    </div>
                                    <hr>
                                @endif
                                <!-- end of category 1  -->
                                {{-- </div> --}}

                                {{-- Comments Start here --}}
                                <div class="container">
                                    <div>
                                        <h5 class="mt-2">
                                            <i class="fa fa-comments"></i> Discussions
                                        </h5>
                                        <p class="small">
                                            Help us keep the community relevant and fun for everyone by following the 
                                            <span>
                                                <a href="https://pelikulove.com/community-guidelines/" target="_blank">
                                                    Community Guidelines
                                                </a>
                                            </span>
                                        </p>
                                        
                                        <hr>
                                    </div>
                                    <div id="displayComments">
                                        {{-- @include('lessons.commentsDisplay', [
                                            'comments' => \App\Models\Comment::getAllVodComments($vod->id), 
                                            'topic_id' => $vod->id
                                        ]) --}}
                                        
                                        @php
                                            $comments = \App\Models\Comment::getAllVodComments($vod->id); 
                                            $topic_id = $vod->id;
                                        @endphp
        
                                        @foreach($comments as $comment)
                                            <div class="display-comment" @if($comment->parent_id != null) style="margin-left:40px;" @endif>
                                                <div class="media mt-1 mb-2">
                                                    <a class="text-dark" href="{{url('/profile/'.$comment->user->name)}}">
                                                        <img src="  @if ($comment->user->profile->avatar_status == 1) 
                                                                        {{ $comment->user->profile->avatar }} 
                                                                    @else 
                                                                        {{ Gravatar::get($comment->user->email) }} 
                                                                    @endif" 
                                                            alt="{{ $comment->user->name }}" class="user2-avatar-nav mt-1">
                                                    </a>
                                                    
                                                    <div class="media-body mt-0 pt-0">
                                                        <div class="font-weight-bold my-0 py-0"> 
                                                            <a class="text-dark" href="{{url('/profile/'.$comment->user->name)}}">
                                                                <strong>
                                                                    {{ $comment->user->name }}
                                                                </strong>
                                                            </a> 
                                                            <span class="small text-secondary">
                                                                {{\Carbon\Carbon::createFromTimeStamp(strtotime($comment->created_at))->diffForHumans()}}	
                                                            </span>
                                                        </div>
                                                        @if (count($comment->user->roles) > 0) 
                                                            @foreach ($comment->user->roles as $user_role)
                                                                @if ($user_role->name == 'Student')
                                                                    @php $badgeClass = 'primary' @endphp
                                                                @elseif ($user_role->name == 'Admin' || $user_role->name == 'Pelikulove' )
                                                                    @php $badgeClass = 'info' @endphp
                                                                @elseif ($user_role->name == 'Mentor')
                                                                    @php $badgeClass = 'success' @endphp
                                                                @elseif ($user_role->name == 'Unverified')
                                                                    @php $badgeClass = 'danger' @endphp
                                                                @else
                                                                    @php $badgeClass = 'default' @endphp
                                                                @endif
                                                                <div class="small mt-n1 py-0">{{ $user_role->name }}</div> 		
                                                            @endforeach
                                                        @endif
                                                        <p>{{ $comment->body }} </p>
                                                    </div>
                                                </div>	    
                                            </div>
                                        @endforeach
        
                                    </div>
                                    
                                    @if (Auth::check())                        
                                        <form method="post" id="commentForm"> 
                                            @csrf
                                            <div class="form-group">
                                                <textarea class="form-control" name="body" placeholder="Type your comment here"></textarea>
                                                <input type="hidden" name="topic_id" value="{{ $vod->id }}" />
                                                <input type="hidden" name="parent_id" value="" />
                                                <input type="hidden" name="type" value="vod" />
                                            </div>
                                            <div class="form-group">									
                                                <button type="submit" class="btn btn-sm btn-success" id="ajaxSubmit" disabled>
                                                    <i id="reply-spinner" class="fa fa-spinner fa-spin" style="display: none;"></i>
                                                    Submit
                                                </button>
                                            </div>
                                        </form>
                                    @endif
                                    
                                    <div class="alert alert-danger alert-dismissable fade show" style="display:none;" role="alert">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                
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

	@include('scripts.show-video-vod')
@endsection	

@section('commentajax2')
    @if (Auth::check())
        <script>	
            $(document).ready(function(){
                document.getElementById('ajaxSubmit').disabled=false;
                
                $("#ajaxSubmit").on('click', function(e){
                    e.preventDefault();
                    $("#reply-spinner").css("display", "inline-block");
                    document.getElementById('ajaxSubmit').disabled=true;
                    
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var formdata = $('#commentForm').serialize(); 
                    
                
                    $.ajax({
                        url: "{{url("/comment/store2") }}",
                        method: 'post',
                        data: formdata,
                        success: function(data){
                            showComments(data.topic_id, data.type);
                            $('#commentForm')[0].reset();
                        },
                        error: function (request, status, error) {
                            json = $.parseJSON(request.responseText);
                            $.each(json.errors, function(key, value){
                                $('.alert-danger').show();
                                $('.alert-danger ul').append('<li>'+value+'</li>');
                            });
                        }
                    });
                });
                
                function showComments(id, type){
                    $.ajax({
                        url: "{{url("/comment/showAll") }}",
                        data: {id:id, type: type},
                        success: function(data){                
                            $('#displayComments').html(data); 
                            $("#reply-spinner").css("display", "none");
                            document.getElementById('ajaxSubmit').disabled=false;
                        }
                    });
                }  
            });	
        </script>
    @endif
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
