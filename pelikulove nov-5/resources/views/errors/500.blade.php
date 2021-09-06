@extends('layouts.app')

@section('template_title')
    500 | Page Error
@endsection

@section('template_fastload_css')    

@endsection

@section('content')
    <div class="container">  
        <div class="row d-flex flex-row">
        	<div class="col-md-12">
                <div class="card shadow p-3 bg-white rounded">
                    <div class="card col-11 container shadow p-3 bg-white rounded">
                        <div class="card-header bg-white rounded row justify-content-center">
                            Oops! We are sorry this happened. 
                            <br>
                            We have alerted our Dev Ops of this error and we will get this fixed as soon as possible. 
                            <br>
                            Thank you for your patience.
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
