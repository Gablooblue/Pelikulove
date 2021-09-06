@extends('layouts.app')

@section('template_title')
{{ $course->title }} - Guidelines
@endsection

@section('template_fastload_css')
@endsection

@section('content')

<div class="" style="background-color: #000000; ">
    <div class="desktop-mode">
        <img class="w-100" src="{{ asset('images/courses/RL-Guidelines.jpg')}}" alt="">
    </div>
    <div class="mobile-mode" style="display: none;">
        <img class="w-100" src="{{ asset('images/courses/mobile-RL-Guidelines.jpg')}}" alt="">
    </div>
    
</div>

@endsection

@section('footer_scripts')

<script>
    $(document).ready(function(){    
        reSizeAll();
    }); 

    $(window).resize(function(){
        reSizeAll();
    }); 

    function isMobile() {
        let isMobile = window.matchMedia("only screen and (max-width: 767px)").matches;
        // let isMobile = window.matchMedia(`(max-device-${window.matchMedia('(orientation: portrait)').matches?'width':'height'}: ${670}px)`).matches

        return isMobile;
    } 

    function reSizeAll() {
        if (isMobile()) {         
            // Expand     
            $('.desktop-mode').css("display", "none");  
            $('.mobile-mode').css("display", "block");    
        } else { 
            // Contract  
            $('.mobile-mode').css("display", "none");    
            $('.desktop-mode').css("display", "block");          
        }
    }
</script>
@endsection