{{-- @php Header("Cache-Control: max-age=3600, must-revalidate"); @endphp --}}
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- CSRF Token --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">
        

        <title>@if (trim($__env->yieldContent('template_title')))@yield('template_title') | @endif {{ config('app.name', Lang::get('titles.app')) }}</title>
        <meta name="title" content="Pelikulove - learn.pelikulove.com" />
		<meta name="description" content="Pelikulove - learn.pelikulove.com" />
		<meta name="author" content="Pelikulove - learn.pelikulove.com" />
		<meta name="keywords" content="Pelikulove - learn.pelikulove.com" />
		<meta property="og:site_name" content="Pelikulove - learn.pelikulove.com" />
        <meta property="fb:app_id" content="989418608095673"/>
        {{-- <meta property="fb:admins" content="3278836645479486"/> Xavier FB ID --}}
        
        @if (isset($oneVod))
		    <meta property="og:url" content="{!! url()->current() !!}" />
            <meta property="og:title" content="{!! $vod->short_title !!}" />
            <meta property="og:description" content="{!! $vod->description_2 !!}" />
            <meta property="og:image" content="{!! asset('images/vods/' . $vod->thumbnail) !!}"/>
            <meta property="og:type" content="video.movie"/>
        @else 
		    <meta property="og:url" content="https://learn.pelikulove.com" />
            <meta property="og:title" content="Pelikulove - learn.pelikulove.com" />
            <meta property="og:description" content="Pelikulove - learn.pelikulove.com" />
		    <meta property="og:image" content="https://learn.pelikulove.com/images/obb.png" />
            <meta property="og:type" content="website"/>
        @endif
 
		<meta itemprop="name" content="Pelikulove - learn.pelikulove.com">
		<meta itemprop="description" content="Pelikulove - learn.pelikulove.com">

        <link rel="shortcut icon" href="{{ asset('images/pelikulove_favicon_32x32.png') }}">

        {{-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries --}}
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        {{-- Fonts --}}
        @yield('template_linked_fonts')

        {{-- Styles --}}
       	<link href="{{ mix('/css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" >
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
		@yield('videocss')
		@yield('videojs')
		@yield('commentajax1')

        @yield('template_linked_css')

        <style type="text/css">
            @yield('template_fastload_css')

            @if (Auth::User() && (Auth::User()->profile) && (Auth::User()->profile->avatar_status == 0))
                .user-avatar-nav {
                    background: url({{ Gravatar::get(Auth::user()->email) }}) 50% 50% no-repeat;
                    background-size: auto 100%;
                }
            @endif

        </style>

        {{-- Scripts --}}
        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
        </script>

        @if (Auth::User() && (Auth::User()->profile) && $theme->link != null && $theme->link != 'null')
            <link rel="stylesheet" type="text/css" href="{{ $theme->link }}">
        @endif

        @yield('head')
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-142254727-1"></script>
		<script>
 		 window.dataLayer = window.dataLayer || [];
  			function gtag(){dataLayer.push(arguments);}
 			 gtag('js', new Date());

  			gtag('config', 'UA-142254727-1');
		</script>

<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
 fbq('init', '1000314113338938'); 
fbq('track', 'PageView');
</script>
<noscript>
 <img height="1" width="1" 
src="https://www.facebook.com/tr?id=1000314113338938&ev=PageView
&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->
    </head>
    <body>
        <div id="app">
			
			@include('partials.nav')
			
            

            <main>

                <div class="container">
                	<div class="row">
                        <div class="col-12">
                            @include('partials.form-status')
                        </div>
                    </div>
               </div>   
                @yield('content')  
                
          </main>

        </div>
        @include('partials.footer')
        

        {{-- Scripts --}}
        <script src="{{ mix('/js/app.js') }}"></script>
		
		@yield('commentajax2')
		@yield('videojs2')
		@yield('amountajax')
		
        @yield('footer_scripts')
        @yield('navbar_scripts')

    </body>
</html>
