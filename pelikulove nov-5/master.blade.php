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
		<meta property="fb:app_id" content=""/>
 
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
    			<div class="row d-flex flex-row">
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

            checkboxes.filter(':checked').length ? $('[data-bulk-actions]').removeClass('hidden') : $('[data-bulk-actions]').addClass('hidden');
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
                (selected.val() == $(this).data('depends')) ? $(this).removeClass('hidden') : $(this).addClass('hidden');
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

    @yield('footer')
</body>
</html>
