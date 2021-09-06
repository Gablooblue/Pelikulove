@extends('layouts.app')

@section('template_title')
    {{ Auth::User()->name }}'s' Homepage
@endsection

@section('template_fastload_css')
@endsection

@section('content')

   <div class="container">  
        <div class="row d-flex flex-row">
        	<div class="col-md-12">
                 @include('panels.welcome-panel2')
            </div>
        </div>		 
                    
    </div>

@endsection

@section('footer_scripts')
 
@endsection
