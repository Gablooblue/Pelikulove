@extends('layouts.app')

@section('template_title')
    503 | Be right back!
@endsection

@section('template_fastload_css')    

@endsection

@section('content')
    <div class="container">  
        <div class="row d-flex flex-row">
        	<div class="col-md-12">
                <div class="card shadow p-3 bg-white rounded">
                    <div class="card col-11 container shadow p-3 bg-white rounded">
                        {{-- <div class="card-header bg-white rounded row justify-content-center text-center">
                            Pelikulove is currently upgrading its services for a better experience. <br>
                            <br>
                            The website will be temporarily unavailable from 1AM to 4AM UST+8. <br>
                            <br>
                            Thank you for your patience.
                        </div> --}}
                        <div class="card-header bg-white rounded row justify-content-center">
                            Oops! Looks like the website is too busy right now.
                            <br>
                            Wait for a while then try again.
                        </div>
                        <div class="card-body rounded row justify-content-center">
                            <a type="button" class="btn btn-primary" href="{{ url('home') }}">Go back to Homepage!</a>
                        </div>
                    </div><!--card-->
                </div><!--card-->
            </div>
        </div>	      
    </div>

@endsection

@section('footer_scripts')   

@endsection
