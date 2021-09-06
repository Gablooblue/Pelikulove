<nav class="navbar navbar-expand-md navbar-dark navbar-laravel sticky-top">
    <div class="container">
        {{-- <a class="navbar-brand" href="http://pelikulove.com"> --}}
            <img src="{{ asset('images/pelikulove_logo_nav_2.png') }}" style="width: 120px; margin-top: -18px;"
                alt=" {!! config('app.name', trans('titles.app')) !!}" 
                class="logo pt-3 hidden-md hidden-lg hidden-xl">
            <img src="{{ asset('images/pelikulove_logo_nav_2.png') }}" style="width: 120px; margin-top: -18px;"
                alt=" {!! config('app.name', trans('titles.app')) !!}" 
                class="logo pt-3 hidden-xs hidden-sm ml-n3">
        {{-- </a> --}}
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" 
            id="navbarbtn">
            <span class="navbar-toggler-icon"></span>
            <span class="sr-only">{!! trans('titles.toggleNav') !!}</span>
        </button>
        <div class="collapse navbar-collapse ml-3" id="navbarSupportedContent">
            {{-- Left Side Of Navbar --}}
            <ul class="navbar-nav mr-auto pt-1">     
                @if (Auth::check())    
                    @if (Auth::User()->hasRole('admin'))
                    <li class="nav-item nav-mobile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="overflow:auto;">
                            {!! trans('titles.adminDropdownNav') !!}
                        </a>
                        <ul class="dropdown-menu multi-level" aria-labelledby="navbarDropdown" style="height: auto;
                            max-height: 50vh;
                            overflow-x: hidden;">
                            <li>
                                <a class="dropdown-item" href="{{ url('home') }}">
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item {{ Request::is('users', 'users/' . Auth::user()->id, 'users/' . Auth::user()->id . '/edit') ? 'active' : null }}"
                                    href="{{ url('/users') }}">
                                    {!! trans('titles.adminUserList') !!}
                                </a>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item {{ Request::is('users/create') ? 'active' : null }}"
                                    href="{{ url('/users/create') }}">
                                    {!! trans('titles.adminNewUser') !!}
                                </a>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item {{ Request::is('roles') ? 'active' : null }}"
                                    href="{{ url('/roles') }}">
                                    Roles &amp; Permissions
                                </a>
                            </li>
                            <li class="dropdown-submenu">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ url('/vod-admin') }}">
                                    Vod Administration
                                </a>
                            </li>
                            <li class="dropdown-submenu">                            
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item {{ Request::is('admin-catalog') ? 'active' : null }}"
                                    href="{{ url('/admin-catalog') }}">
                                    Show Admin
                                </a>
                            </li>
                            <li class="dropdown-submenu">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item {{ Request::is('analytics-catalog') ? 'active' : null }}"
                                    href="{{ url('/analytics-catalog') }}">
                                    Show Analytics
                                </a>
                            </li>
                            {{-- <li class="dropdown-submenu">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ url('/courses-admin') }}">
                                    Courses Administration
                                </a>
                            </li>
                            <li class="dropdown-submenu">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ url('/services') }}">
                                    Services Administration
                                </a>
                            </li>
                            <li class="dropdown-submenu">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ url('/payment-methods') }}">
                                    Payment Methods Administration
                                </a>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ url('/promo-codes') }}">
                                    Promo Codes Administration
                                </a>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item"
                                    href="{{ route('analytics.vod') }}">
                                    Show Blackbox Analytics
                                </a>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item"
                                    href="{{ route('analytics.courses') }}">
                                    Show Course Analytics
                                </a>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('eventlogs.index') }}">
                                    Show Event Logs
                                </a>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item {{ Request::is('orders') ? 'active' : null }}"
                                    href="{{ url('/orders') }}">
                                    Show All Orders
                                </a>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item {{ Request::is('enrollees') ? 'active' : null }}"
                                    href="{{ url('/enrollees') }}">
                                    Show All Enrollees
                                </a>
                            </li>
                            <li>                                    
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item"
                                    href="{{ url('/vod-purchases') }}">
                                    Show All VOD Purchases
                                </a>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item"
                                    href="{{ route('donations.list') }}">
                                    Show All Donations
                                </a>
                            </li> --}}
                            <li>
                                <div class="dropdown-divider"></div>                        
                                <a class="dropdown-item {{ Request::is('themes','themes/create') ? 'active' : null }}"
                                    href="{{ url('/themes') }}">
                                    {!! trans('titles.adminThemesList') !!}
                                </a>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item {{ Request::is('logs') ? 'active' : null }}" href="{{ url('/logs') }}">
                                    {!! trans('titles.adminLogs') !!}
                                </a>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item {{ Request::is('activity') ? 'active' : null }}"
                                    href="{{ url('/activity') }}">
                                    {!! trans('titles.adminActivity') !!}
                                </a>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item {{ Request::is('phpinfo') ? 'active' : null }}"
                                    href="{{ url('/phpinfo') }}">
                                    {!! trans('titles.adminPHP') !!}
                                </a>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item {{ Request::is('routes') ? 'active' : null }}"
                                    href="{{ url('/routes') }}">
                                    {!! trans('titles.adminRoutes') !!}
                                </a>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item {{ Request::is('active-users') ? 'active' : null }}"
                                    href="{{ url('/active-users') }}">
                                    {!! trans('titles.activeUsers') !!}
                                </a>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item {{ Request::is('blocker') ? 'active' : null }}"
                                    href="{{ route('laravelblocker::blocker.index') }}">
                                    {!! trans('titles.laravelBlocker') !!}
                                </a>
                            </li>
                        </ul>
                    </li>
                    @elseif (Auth::User()->hasRole('pelikulove'))
                    <li class="nav-item nav-mobile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {!! trans('titles.adminDropdownNav') !!}
                        </a>
                        <div class="dropdown-menu multi-level" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ url('home') }}">
                                Dashboard
                            </a>
                            {{-- <div class="dropdown-divider"></div>
                            <a class="dropdown-item {{ Request::is('users', 'users/' . Auth::user()->id, 'users/' . Auth::user()->id . '/edit') ? 'active' : null }}"
                                href="{{ url('/users') }}">
                                {!! trans('titles.adminUserList') !!}
                            </a> --}}
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item {{ Request::is('users/create') ? 'active' : null }}"
                                href="{{ url('/users/create') }}">
                                {!! trans('titles.adminNewUser') !!}
                            </a>
                            {{-- <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ url('/services') }}">
                                Services Administration
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ url('/payment-methods') }}">
                                Payment Methods Administration
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ url('/promo-codes') }}">
                                Promo Codes Administration
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('analytics.vod') }}">
                                Show Blackbox Analytics
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('analytics.courses') }}">
                                Show Course Analytics
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('eventlogs.index') }}">
                                Show Event Logs
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item {{ Request::is('orders') ? 'active' : null }}"
                                href="{{ url('/orders') }}">
                                Show All Orders
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item {{ Request::is('enrolles') ? 'active' : null }}"
                                href="{{ url('/enrollees') }}">
                                Show All Enrollees
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item"
                                href="{{ url('/vod-purchases') }}">
                                Show All VOD Purchases
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item"
                                href="{{ route('donations.list') }}">
                                Show All Donations
                            </a> --}}
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item {{ Request::is('admin-catalog') ? 'active' : null }}"
                                href="{{ url('/admin-catalog') }}">
                                Show Admin
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item {{ Request::is('analytics-catalog') ? 'active' : null }}"
                                href="{{ url('/analytics-catalog') }}">
                                Show Analytics
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item {{ Request::is('accounting') ? 'active' : null }}"
                                href="{{ url('/accounting') }}">
                                Show All Invoices
                            </a>
                        </div>
                    </li>
                    {{-- @endrole
                    @role('mentor')
                    <li class="nav-item nav-mobile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {!! trans('titles.adminDropdownNav') !!}
                        </a>
                        <div class="dropdown-menu multi-level" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ url('home') }}">
                                Dashboard
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('analytics.courses') }}">
                                Show Course Analytics
                            </a>
                        </div>
                    </li> --}}
                    @else
                    <li class="nav-item nav-mobile">
                        <a class="nav-link" href="{{ url('/home') }}">
                            Dashboard
                        </a>
                    </li>
                    @endif
                @else 
                    <li class="nav-item nav-mobile">
                        <a class="nav-link" href="{{ url('/home') }}">
                            Dashboard
                        </a>
                    </li>
                @endif
               
				{{-- @if (isset($course) && isset($lesson) && Auth::check()) 
					<li class="nav-item nav-mobile dropdown">
					@if ($course->id == 1)
					 
               	 	  <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><small>Rody Vera's </small> Playwriting</a>
            		 
            		@else
            		  <li class="nav-item nav-mobile disable">
               	 	  <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{$course->short_title}}</a>
            		
					@endif
					 <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    	@foreach ($lessons as $key => $l)
                    	@if (\App\Models\LearnerCourse::ifEnrolled($course->id, Auth::user()->id))
                        <a class="dropdown-item" href="{{url('/lesson/'.$key.'/topic/'.$l['first'].'/show')}}">{{$l['title']}}</a>
                        @else
                        <span class="dropdown-item">{{$l['title']}}</span>
                        @endif
                        @endforeach
                    </div>
					</li>   
				@endif --}}

                <li class="nav-item nav-mobile">
                    <a class="nav-link" href="{{url('/courses')}}" role="button"
                        aria-haspopup="true" aria-expanded="false">
                        Courses
                    </a>
                    {{-- <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @php 
                            $courses = \App\Models\Course::where('id', '!=', 2)->where('private', 0)->get(); 
                        @endphp
                        @if (Auth::check())
                            @foreach (Auth::user()->enrolledcourses as $ec)  
                                @if ($ec->course->private == 1)
                                    <a class="dropdown-item" href="{{url('/course/'.$ec->course->id.'/show')}}">{{$ec->course->short_title}}</a>
                                @endif
                            @endforeach
                        @endif
                        @foreach ($courses as $c)
                            <a class="dropdown-item" href="{{url('/course/'.$c->id.'/show')}}">{{$c->short_title}}</a>
                        @endforeach
                    </div> --}}
                </li>   

                <li class="nav-item nav-mobile dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        Community
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="https://pelikulove.com/community-guidelines/" target="_blank">Must Read!</a>
                        <a class="dropdown-item" href="{{ url('/forum') }}">Tambayan Forum</a>
                        <a class="dropdown-item" href="{{ url('/submissions') }}">Saluhan Workspace</a>
                        
                        {{-- @if (auth()->check())    
                            @php
                                $enrolled = \App\Models\LearnerCourse::getEnrollment(2, Auth::user()->id);
                            @endphp
                            @if (isset($enrolled))
                                <a class="dropdown-item" href="{{ url('/submissions/2') }}">Demo Saluhan Workspace</a>
                            @endif
                        @endif --}}
                        {{-- <a class="dropdown-item" href="https://pelikulove.com/writers-bloc/">Writer's Bloc Online - Soon!</a>
                        <a class="dropdown-item" href="https://pelikulove.com/webinar/">Webinar - Soon!</a> --}}
                        <a class="dropdown-item" href="https://pelikulove.com/" target="_blank">Blog</a>
                        <a class="dropdown-item" href="https://pelikulove.com/opportunities/" target="_blank">Opportunities</a>

                    </div>
                </li>
                
                <li class="nav-item nav-mobile">
                    <a class="nav-link" href="{{ url('/blackbox')}}">
                        Blackbox
                    </a>
                </li>
                {{-- <li class="nav-item nav-mobile">
                    <a class="nav-link" href="https://pelikulove.com/faq/">
                        FAQ
                    </a>
                </li>
                <li class="nav-item nav-mobile">
                    <a class="nav-link" href="https://pelikulove.com/patronage/" role="button">
                        Pricing
                    </a>
                </li> --}}
                {{-- <li class="nav-item nav-mobile">
                    <a class="nav-link" href="#">
                        Help
                    </a>
                </li> --}}
                <li class="nav-item nav-mobile dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false" >
                        Help
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="https://pelikulove.com/faq/" target="_blank">FAQ</a>
                        <a class="dropdown-item" href="https://pelikulove.com/patronage/" target="_blank">Pricing</a>
                        
                        <a class="dropdown-item" href="{{ url('/redeem-a-code') }}">Redeem Gift Codes</a>

                    </div>
                </li>
                {{-- <li class="nav-mobile nav-item">
                    <a class="nav-link" href="{{ url('/redeem-a-code') }}">Redeem Gift Codes</a>

                </li> --}}
            </ul>

            {{-- Right Side Of Navbar --}}
            <ul class="navbar-nav ml-auto">
                @php $firstNotif = null; @endphp
                {{-- Authentication Links --}}
                @auth        
                {{-- User Notifications Start --}}
                <li class="nav-item dropdown nav-user nav-mobile">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle navbar-notify container-fluid" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <div class="row mr-0 ml-0">
                            <i class="fa fa-bell fa-fw"></i>                                      
                            <div class="mt-n3 notif-count" style="display: @if (auth()->user()->unreadNotifications->count()) inline-block @else none @endif;">
                                <span class="badge badge-dark ml-n2" style="border-radius: 50px;">
                                    <span id="notif-counter" class="text-white">
                                        @php $notif_count = auth()->user()->unreadNotifications->count() @endphp 
                                        {{ $notif_count }}
                                    </span>
                                </span>  
                            </div> 
                            <span class="mobile-mode" style="display: none;">
                                Notifications
                            </span>
                        </div>        
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow p-0 m-0 rounded" aria-labelledby="navbarDropdown">
                        <div class="dropdown-header p-1">
                            <div class="row justify-content-between pl-4 pr-4" style="font-size: 1rem;">                                            
                                Notifications
                                <div class="" style="text-align: right;">                     
                                    <a href="#" id="readAllNotifsBtn">                                   
                                        Mark all as read
                                    </a>
                                </div>
                            </div>
                        </div>
                        <hr class="m-0 p-0" style="border: 1px solid #17a2b8; background-color: #17a2b8;">
                        <div class="notif-inbox-div-list notif-dropdown" style="height: auto; max-height: 40vh; overflow-x: hidden; width: auto; min-width: 35vw; max-width: 100vw;">
                            @php $notifyCounter = 1;  $notifications = auth()->user()->notifications; 
                            $firstNotif = auth()->user()->notifications->first() @endphp
                            <div class="notif-item-list">
                                @if (auth()->user()->notifications->count() > 0)
                                    @foreach ($notifications as $notification)     
                                        {{-- First 5 Notifs --}}
                                        @if ($notifyCounter <= 5)                          
                                            <a class="notif_item-{{ $notifyCounter }}" href="{{ $notification->data['url'] }}" 
                                            style="border-color: lightgrey; justify-content: normal;">
                                                <div class="dropdown-item d-flex align-items-center border-top notif-item pt-2 pb-2"
                                                style="background-color: @if ($notification->unread()) aliceblue; @else white; @endif">
                                                    <div class="d-flex align-items-center p-0">   
                                                        @php 
                                                            $user = \App\Models\User::find($notification->data['sender_id']); 
                                                            $gravatar = Gravatar::get($user->email);
                                                            if ($user->profile->avatar_status == 1) 
                                                                $picture = $user->profile->avatar;
                                                            else if (isset($gravatar))
                                                                $picture = Gravatar::get($user->email);
                                                            else 
                                                                $picture = asset('images/default_avatar.png');
                                                        @endphp
                                                        @if (isset($user))
                                                            <img src="{{ $picture }}" 
                                                            alt="{{ $user->name }}" 
                                                            class="user2-avatar-nav m-0 p-0" 
                                                            style="width: 35px; height: 35px; ">
                                                        @else 
                                                            <img src="{!! asset('images/default_avatar.png') !!}"
                                                            class="user2-avatar-nav m-0 p-0" 
                                                            style="width: 35px; height: 35px; ">                                                                
                                                        @endif
                                                    </div>     
                                                    <div class="dropdown-item pl-4 p-0" style="white-space: normal;">
                                                        <div class="small font-italic"> 
                                                            {{\Carbon\Carbon::createFromTimeStamp(strtotime($notification->created_at))->diffForHumans()}}
                                                        </div>
                                                        <span class="font-weight-bold">
                                                            {!! $notification->data['data'] !!}
                                                        </span>
                                                    </div>
                                                    @php $notifyCounter++; @endphp
                                                </div>
                                            </a>
                                        @else
                                        {{-- Notifs num. 6+ are display none --}}
                                            <a class="notif_item-{{ $notifyCounter }}" href="{{ $notification->data['url'] }}" 
                                            style="border-color: lightgrey; justify-content: normal; display: none;">
                                                <div class="dropdown-item d-flex align-items-center border-top notif-item pt-2 pb-2" 
                                                style="background-color: @if ($notification->unread()) aliceblue; @else white; @endif">
                                                    <div class="d-flex align-items-center p-0">
                                                        @php 
                                                            $user = \App\Models\User::find($notification->data['sender_id']); 
                                                            $gravatar = Gravatar::get($user->email);
                                                            if ($user->profile->avatar_status == 1) 
                                                                $picture = $user->profile->avatar;
                                                            else if (isset($gravatar))
                                                                $picture = Gravatar::get($user->email);
                                                            else 
                                                                $picture = asset('images/default_avatar.png');
                                                        @endphp
                                                        @if (isset($user))
                                                            <img src="{{ $picture }}" 
                                                            alt="{{ $user->name }}" 
                                                            class="user2-avatar-nav m-0 p-0" 
                                                            style="width: 35px; height: 35px; ">
                                                        @else 
                                                            <img src="{!! asset('images/default_avatar.png') !!}"
                                                            class="user2-avatar-nav m-0 p-0" 
                                                            style="width: 35px; height: 35px; ">                                                                
                                                        @endif
                                                    </div>   
                                                    <div class="dropdown-item pl-4 p-0" style="white-space: normal;">
                                                        <div class="small font-italic"> 
                                                            {{\Carbon\Carbon::createFromTimeStamp(strtotime($notification->created_at))->diffForHumans()}}
                                                        </div>
                                                        <span class="font-weight-bold">
                                                            {!! $notification->data['data'] !!}
                                                        </span>
                                                    </div>
                                                    @php $notifyCounter++; @endphp
                                                </div>
                                            </a>
                                        @endif 
                                    @endforeach
                                @else 
                                    <a id="no_messages" style="border-color: lightgrey; justify-content: normal;">
                                        <div class="dropdown-item d-flex align-items-center border-top notif-item pt-2 pb-2"
                                        style="background-color: white;">    
                                            <div class="dropdown-item p-0 font-weight-bold text-center" style="white-space: normal;">
                                                No messages yet
                                            </div>
                                        </div>
                                    </a>
                                @endif
                            </div>
                        </div>      
                        <hr class="m-0 p-0" style="border: 1px solid #17a2b8; background-color: #17a2b8;">
                        <div class="dropdown-footer mb-1" style="overflow: hidden; margin-left: 0rem;">
                            <h6 class="pt-1 " style="text-align: center;">                     
                                <a href="{{ route('notifications.index') }}">                                   
                                    Show all Notifications
                                </a>
                            </h6>
                        </div>
                    </div>
                </li>
                {{-- User Notifications End --}}
                
                {{-- User Logout and Profile Start --}}
                <li class="nav-item dropdown nav-user mb-1">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        @php     
                            $gravatar = Gravatar::get(Auth::user()->email);                            
                            $picture = asset('images/default_avatar.png');	
                            if (isset(Auth::user()->profile->avatar) && Auth::user()->profile->avatar_status == 1) {
                                $picture = Auth::user()->profile->avatar;
                            }
                            else if (isset($gravatar))
                                $picture = Gravatar::get(Auth::user()->email);
                            else 
                                $picture = asset('images/default_avatar.png');
                        @endphp
                        @if (isset($picture))
                            <img src="{{ $picture }}" 
                            alt="{{ Auth::user()->name }}" class="user-avatar-nav bg-white"  
                            style="width: 40px; height: 40px; border: medium solid aliceblue;">
                        @else
                            <img src="{{ asset('images/default_avatar.png') }}" 
                            class="user-avatar-nav bg-white"  
                            style="width: 40px; height: 40px; border: medium solid aliceblue;">
                        @endif
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown"> 
                        <a class="dropdown-item {{ Request::is('profile/'.Auth::user()->name, 'profile/'.Auth::user()->name . '/edit') ? 'active' : null }}"
                            href="{{ url('/profile/'.Auth::user()->name) }}">
                            {!! trans('titles.profile') !!}
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
                {{-- User Logout and Profile End --}}
                @else      
                    <li class="nav-mobile nav-user"><a class="nav-link ml-1" href="{{ route('login') }}">Log In</a></li>
                    <li class="nav-user"><a class="nav-link ml-1" href="{{ route('register') }}">Sign Up</a></li>  
                @endauth
            </ul>
        </div>
    </div>
</nav>

@section('navbar_scripts')
    <script>
        $(document).ready(function(){
            reStyleNavbar();

            $("ul.dropdown-menu [data-toggle='dropdown']").on("click", function(event) {
                event.preventDefault();
                event.stopPropagation();

                $(this).siblings().toggleClass("show");

                if (!$(this).next().hasClass('show')) {
                    $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
                }

                $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
                    $('.dropdown-submenu .show').removeClass("show");
                });
            });

            $(window).resize(function(){
                reStyleNavbar();
            });            
    
            function isMobile() {
                let isMobile = window.matchMedia("only screen and (max-width: 767px)").matches;

                return isMobile;
            }

            function reStyleNavbar() {
                if (isMobile()) {
                    $('.nav-mobile').addClass("border-bottom mt-n1");
                    $('.nav-mobile').removeClass("bg-transparent");
                    $('.nav-user').addClass("mt-n2"); 

                    $('.topmost-navitem').addClass("border-top");           
                    $('.notif-inbox-div-list').css('max-height', '30vh');
                    $('.mobile-mode').css('display', 'block');
                    
                } else {
                    $('.nav-mobile').removeClass("border-bottom mt-n1");
                    $('.nav-mobile').addClass("bg-transparent");
                    $('.nav-user').removeClass("mt-n2");

                    $('.topmost-navitem').removeClass("border-top");           
                    $('.notif-inbox-div-list').css('max-height', '40vh');   
                    $('.mobile-mode').css('display', 'none');
                }
            }

            $('#readAllNotifsBtn').click(function(e){    
                // console.log("{!! route('notifications.readall') !!}");                
                $('.notif-item').css('background-color', 'white');
                $('.notif-count').css('display', 'none');

                $.get("{!! route('notifications.readall') !!}", function () {});
            });

            var totalShownNotifs = 5;
            var check = true;

            $('.notif-dropdown').on('scroll', function() {
                var scrollProgress = $(this).scrollTop() + $(this).innerHeight();
                var maxScroll = $(this)[0].scrollHeight;
                if (scrollProgress >= (maxScroll - 20)) {    
                    if (check) {
                        check = !check;
                        var notifCounter = totalShownNotifs;
                        for (var i=1; i<6; i++) {
                            $('.notif_item-' + (notifCounter+i)).css('display', 'inline');
                            totalShownNotifs++;
                        }
                        check = !check;
                    }
                }          
            })     
            
            var uni = self.setInterval(function () {
                updateNotifInbox();                
            }, 600000); // 1000 = 1 second
            
            var notifItems = '';
            var oldFirstNotif = '';

            @if (auth()->check())    
                var oldFirstNotif = @json($firstNotif);
                var notifCount = {!! $notif_count !!};
            @endif 

            function updateNotifInbox () { 
                var newNotifs = '';
                var notifItems = $('.notif-item-list').html();
                // console.log("updateNotifInbox is called");
                @if (auth()->check())    

                    $.get("{!! route('notifications.getNotifications') !!}", function (data) {   
                        if (data.length > 0) {
                            if (oldFirstNotif == null) {
                                oldFirstNotif = (data[0].id + "filler");
                            }
                            
                            if (oldFirstNotif.id != data[0].id) {
                                // console.log("1. There is new Notif Start!");
                                
                                for (index=0; index < data.length; index++) {
                                    if (oldFirstNotif.id == data[index].id) {
                                        // console.log("4-2. Stopping Adding of Notifs!");
                                        break;
                                    } 
                                    notifCount++;         
                                    
                                    // console.log("2. Adding New Notif!");                 
                                    newNotifs += 
                                                "<a href='" + data[index].data.url + "' " + 
                                                "style='border-color: lightgrey; justify-content: normal;'> " + 
                                                    "<div class='dropdown-item d-flex align-items-center border-top notif-item pt-2 pb-2' " + 
                                                    "style='background-color: aliceblue;'> " + 
                                                        "<div class='d-flex align-items-center p-0'> " +
                                                            "<img id='" + data[index].id + "-avatar' src='" + "{{ asset('images/default_avatar.png') }}" + "' " + 
                                                            "class='user2-avatar-nav m-0 p-0' style='width: 35px; height: 35px;'> " + 
                                                        "</div> " +
                                                        "<div class='dropdown-item pl-4 p-0' style='white-space: normal;'>  " +
                                                            "<div id='" + data[index].id + "-newDate' class='small font-italic'>  " +
                                                                "A moment ago" +
                                                            "</div> " +
                                                            "<span class='font-weight-bold'> " +
                                                                data[index].data.data +
                                                            "</span> " + 
                                                        "</div> " +
                                                    "</div> " + 
                                                "</a>"; 
                                    
                                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                                    var date = data[index].created_at;
                                    var newDate = '';
                                    var user_id = data[index].data.sender_id;
                                    var avatar = '';
                                    var notifItem = data[index];
                                    
                                    $.ajax({
                                        url:"{!! route('getNotifDetails') !!}", 
                                        type: "POST", 
                                        dataType: 'JSON',
                                        data: {_token: CSRF_TOKEN, date: date, user_id: user_id},
                                        success:function(data){       
                                            newDate = data.newDate;  
                                            avatar = data.avatar;     

                                            $('#' + notifItem.id + "-newDate").html(newDate);
                                            $('#' + notifItem.id + "-avatar").src = "http://127.0.0.1:8000/" + avatar;                        
                                        },
                                        error:function(data) { 
                                            // console.log("Error on ajax");
                                            // console.log(data.error);
                                        }
                                    });
                                }

                                $('.notif-item-list').html(newNotifs + notifItems);
                                notifItems = $('.notif-item-list').html();
                                oldFirstNotif = data[0];

                                $('.notif-count').css('display', 'inline-block');  
                                $('#notif-counter').html(notifCount);
                                $('#no_messages').css('display', 'none');      
                            }   
                        }
                    });  
                @endif  
            }
        });
    </script>
@endsection