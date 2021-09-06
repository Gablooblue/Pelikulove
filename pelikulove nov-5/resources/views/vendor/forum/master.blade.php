<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @if (isset($thread))
        {{ $thread->title }} -
        @endif
        @if (isset($category))
        {{ $category->title }} -
        @endif
        {{ trans('forum::general.home_title') }}
        | {{ config('app.name', Lang::get('titles.app')) }}

    </title>

    <meta name="title" content="Pelikulove - learn.pelikulove.com" />
    <meta name="description" content="Pelikulove - learn.pelikulove.com" />
    <meta name="author" content="Pelikulove - learn.pelikulove.com" />
    <meta name="keywords" content="Pelikulove - learn.pelikulove.com" />

    <meta property="og:title" content="Pelikulove - learn.pelikulove.com" />
    <meta property="og:description" content="Pelikulove - learn.pelikulove.com" />
    <meta property="og:image" content="https://learn.pelikulove.com/images/pelikulove_logo_nav_2.png" />
    <meta property="og:site_name" content="Pelikulove - learn.pelikulove.com" />
    <meta property="og:type" content="Pelikulove - learn.pelikulove.com" />
    <meta property="og:url" content="learn.learn.pelikulove.com" />
    <meta property="fb:app_id" content="" />

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
	{{-- Styles --}}
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" >
		
	
    <style type="text/css">
    @yield('template_fastload_css') @if (Auth::User() && (Auth::User()->profile) && 
    (Auth::User()->profile->avatar_status==0)) .user-avatar-nav {
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

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
        <style type="text/css" media="screen">
        .posts-table {
            border: 0;
        }
        .posts-table tr td, .posts-table tr th {
        	padding-left: 0
        }
        .posts-table tr td:last-child {
            padding-right: 15px;
        }
        .posts-table.table-responsive,
        .posts-table.table-responsive table {
            margin-bottom: 0;
        }
        a {
        	color: #e42424;
        }
        a:hover {
        	color: #dc3545;
        	
        }
    </style>
	
    <!-- jQuery -->
    <script src="//code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>

    @yield('head')

</head>

<body>
    <div id="app">

        @include('partials.nav')

        <main>

            <div class="container">
                <div class="row">
                    <div class="col-12">
                        @include ('forum::partials.breadcrumbs')
                        @include ('forum::partials.alerts')
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow bg-white rounded">

                            <div class="card-body">

                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    </div>
	<footer class="page-footer font-small white py-3">

	<div class="container">
		<div class="row">
			<!-- Copyright -->
  			<div class="col-md-7 col-lg-8">
  				2019 © <a class='text-danger' href="https://pelikulove.com"> Pelikulove - Pelikulove.com</a>
  			</div>
  			<!-- Copyright -->
  
  			<div class="col-md-5 col-lg-4 ml-lg-0 text-right">
			  <a href="https://pelikulove.com/honor-code/" class="text-danger pr-3"> Honor Code</a>
    			<a href="https://pelikulove.com/privacy-policy/" class="text-danger pr-3"> Privacy Policy</a>
    			<a href="https://pelikulove.com/terms-and-conditions/" class="text-danger"> Terms & Conditions</a>
  			</div>
  		</div>	
  	</div>	

</footer>
<!-- Footer -->  
    @yield('navbar_scripts')
    <script>
    var toggle = $('input[type=checkbox][data-toggle-all]');
    var checkboxes = $('table tbody input[type=checkbox]');
    var actions = $('[data-actions]');
    var forms = $('[data-actions-form]');
    var confirmString = "{{ trans('forum::general.generic_confirm') }}";

    function setToggleStates() {
        checkboxes.prop('checked', toggle.is(':checked')).change();
    }

    function setSelectionStates() {
        checkboxes.each(function() {
            var tr = $(this).parents('tr');

            $(this).is(':checked') ? tr.addClass('active') : tr.removeClass('active');

            checkboxes.filter(':checked').length ? $('[data-bulk-actions]').removeClass('hidden') : $(
                '[data-bulk-actions]').addClass('hidden');
        });
    }

    function setActionStates() {
        forms.each(function() {
            var form = $(this);
            var method = form.find('input[name=_method]');
            var selected = form.find('select[name=action] option:selected');
            var depends = form.find('[data-depends]');

            selected.each(function() {
                if ($(this).attr('data-method')) {
                    method.val($(this).data('method'));
                } else {
                    method.val('patch');
                }
            });

            depends.each(function() {
                (selected.val() == $(this).data('depends')) ? $(this).removeClass('hidden'): $(this)
                    .addClass('hidden');
            });
        });
    }

    setToggleStates();
    setSelectionStates();
    setActionStates();

    toggle.click(setToggleStates);
    checkboxes.change(setSelectionStates);
    actions.change(setActionStates);

    forms.submit(function() {
        var action = $(this).find('[data-actions]').find(':selected');

        if (action.is('[data-confirm]')) {
            return confirm(confirmString);
        }

        return true;
    });

    $('form[data-confirm]').submit(function() {
        return confirm(confirmString);
    });
    </script>

    
        

        {{-- Scripts --}}
    <script src="{{ mix('/js/app.js') }}"></script>
    
    @yield('footer_scripts')	


</body>

</html>