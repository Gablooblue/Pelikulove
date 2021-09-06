@extends('layouts.app')

@section('template_title')
    {{ Auth::User()->name }}'s' Homepage
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

   <div class="container">  
        <div class="row d-flex flex-row">
        	<div class="col-md-12">
                @if (\App\Models\LearnerCourse::ifEnrolled(3, Auth::user()->id) && 
                !Auth::user()->hasRole('pelikulove') &&
                !Auth::user()->hasRole('admin') )
                    @include('panels.welcome-panel-ricky-lee')
                @else
                    @include('panels.welcome-panel')
                @endif
            </div>
        </div>		 
                    
    </div>

@endsection

@section('footer_scripts')
    <script>
        
    </script>
 
@endsection
