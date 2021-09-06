<nav class="navbar navbar-expand-md navbar-dark navbar-laravel sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/home') }}">
            <img src="{{ asset('images/pelikulove_logo_nav_2.png') }}" style="width: 100px"
                alt=" {!! config('app.name', trans('titles.app')) !!}" class="logo">

        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            <span class="sr-only">{!! trans('titles.toggleNav') !!}</span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            {{-- Left Side Of Navbar --}}
            <ul class="navbar-nav mr-auto">
                @role('admin')
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {!! trans('titles.adminDropdownNav') !!}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                        <a class="dropdown-item {{ Request::is('users', 'users/' . Auth::user()->id, 'users/' . Auth::user()->id . '/edit') ? 'active' : null }}"
                            href="{{ url('/users') }}">
                            {!! trans('titles.adminUserList') !!}
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item {{ Request::is('users/create') ? 'active' : null }}"
                            href="{{ url('/users/create') }}">
                            {!! trans('titles.adminNewUser') !!}
                        </a>
                        <div class="dropdown-divider"></div>
                            <a class="dropdown-item {{ Request::is('roles') ? 'active' : null }}" href="{{ url('/roles') }}">
                                Roles &amp; Permissions
                            </a>
                        <div class="dropdown-divider"></div>    
                         <a class="dropdown-item {{ Request::is('orders') ? 'active' : null }}" href="{{ url('/orders') }}">
                                Show All Orders
                            </a>
                        <div class="dropdown-divider"></div>
                            <a class="dropdown-item {{ Request::is('enrolles') ? 'active' : null }}" href="{{ url('/enrollees') }}">
                                Show All Enrollees
                            </a>   
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item {{ Request::is('themes','themes/create') ? 'active' : null }}"
                            href="{{ url('/themes') }}">
                            {!! trans('titles.adminThemesList') !!}
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item {{ Request::is('logs') ? 'active' : null }}" href="{{ url('/logs') }}">
                            {!! trans('titles.adminLogs') !!}
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item {{ Request::is('activity') ? 'active' : null }}"
                            href="{{ url('/activity') }}">
                            {!! trans('titles.adminActivity') !!}
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item {{ Request::is('phpinfo') ? 'active' : null }}"
                            href="{{ url('/phpinfo') }}">
                            {!! trans('titles.adminPHP') !!}
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item {{ Request::is('routes') ? 'active' : null }}"
                            href="{{ url('/routes') }}">
                            {!! trans('titles.adminRoutes') !!}
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item {{ Request::is('active-users') ? 'active' : null }}"
                            href="{{ url('/active-users') }}">
                            {!! trans('titles.activeUsers') !!}
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item {{ Request::is('blocker') ? 'active' : null }}"
                            href="{{ route('laravelblocker::blocker.index') }}">
                            {!! trans('titles.laravelBlocker') !!}
                        </a>
                    </div>
                </li>
                @endrole
				@role('pelikulove')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {!! trans('titles.adminDropdownNav') !!}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                            <a class="dropdown-item {{ Request::is('users', 'users/' . Auth::user()->id, 'users/' . Auth::user()->id . '/edit') ? 'active' : null }}" href="{{ url('/users') }}">
                                {!! trans('titles.adminUserList') !!}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item {{ Request::is('users/create') ? 'active' : null }}" href="{{ url('/users/create') }}">
                                {!! trans('titles.adminNewUser') !!}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item {{ Request::is('orders') ? 'active' : null }}" href="{{ url('/orders') }}">
                                Show All Orders
                            </a>
                           <div class="dropdown-divider"></div>
                            <a class="dropdown-item {{ Request::is('enrolles') ? 'active' : null }}" href="{{ url('/enrollees') }}">
                                Show All Enrollees
                            </a>
                        </div>
                    </li>
                @endrole
            <li class="nav-item disable">
                <a class="navbar-brand disable" href="#"><small>Rody Vera's </small> Playwriting</a>
            </li>

                <li class="nav-item">
                    <a class="nav-link" href="https://learn.pelikulove.com/mentor/1/show">Mentor</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        Lessons
                    </a>
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

               
                
                <li class="nav-item">
                    <a class="nav-link" href="http://learn.pelikulove.com/forum/">Tambayan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://learn.pelikulove.com/submissions/1">Saluhan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://pelikulove.com/faq/">FAQ</a>
                </li>


            </ul>
            {{-- Right Side Of Navbar --}}
            <ul class="navbar-nav ml-auto">
                {{-- Authentication Links --}}
                @guest
                <li><a class="nav-link" href="{{ route('login') }}">Log In</a></li>
                <li><a class="nav-link" href="{{ route('register') }}">Sign Up</a></li>
                @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        @if ((Auth::User()->profile) && Auth::user()->profile->avatar_status == 1)
                        <img src="{{ Auth::user()->profile->avatar }}" alt="{{ Auth::user()->name }}"
                            class="user-avatar-nav">
                        @else
                        <div class="user-avatar-nav"></div>

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
                @endguest
            </ul>
        </div>
    </div>
</nav>