@extends('layouts.app')

@section('template_title')
Mentor - {{ $instructor->name }}
@endsection

@section('template_fastload_css')
@endsection

@section('content')




<div class="" style="background-color: #000000; ">
    <div class="desktop-mode">
        <img class="w-100" src="{{ asset('images/courses/Ricky Lee 1 no watermark.jpg')}}" alt="">
    </div>

    <div class="desktop-mode" style="margin-top: -7rem !important; margin-bottom: 3.5rem !important;">
        <div class="row d-flex flex-row m-0 p-0 justify-content-center">
            <a href="{{ url('/trip2quiapo-registration') }}" class="m-0 p-0">	
                <button class="btn btn-sm btn-danger w-100 p-2 px-3" href="#" role="button"
                    style="border-radius: 15px; border: 1px solid">                        
                    <span style="font-size: 24px">
                        <strong>
                            Join the Workshop &raquo;
                        </strong>
                    </span>
                </button>
            </a>
        </div>
    </div>

    <div class="desktop-mode">
        <img class="w-100" src="{{ asset('images/courses/ricky-lee-intro-1.jpg')}}" alt="">
    </div>
    <div class="desktop-mode">
        <img class="w-100" src="{{ asset('images/courses/rk-quote-1.jpg')}}" alt="">
    </div>
    <div class="desktop-mode">
        <img class="w-100" src="{{ asset('images/courses/ricky-lee-books.jpg')}}" alt="">
    </div>
    <div class="desktop-mode" style="margin-top: -7.5rem !important; margin-bottom: 5rem !important;">
        <div class="row m-0 p-0">
            <div class="col-7 row justify-content-center">
                <a href="https://web.facebook.com/TripToQuiapo/photos/a.588995077825423/3171569212901317/?type=3&theater" 
                target="_blank" class="m-0 p-0">	
                    <button class="btn btn-sm btn-danger p-2 px-3" href="#" role="button"
                        style="border-radius: 15px; border: 1px solid">                        
                        <span style="font-size: 24px">
                            <strong>
                                Get His Books &raquo;
                            </strong>
                        </span>
                    </button>
                </a>
            </div>
            <div class="col-5 m-0 p-0">

            </div>
        </div>
    </div>

    <div class="mobile-mode" style="display: none;">
        <img class="w-100" src="{{ asset('images/courses/ricky-lee-mobile-sits-chair.jpg')}}" alt="">
    </div>

    <div class="mobile-mode" style="margin-top: -5rem !important; margin-bottom: 1rem !important;">
        <div class="row d-flex flex-row m-0 p-0 justify-content-center">
            <a href="{{ url('/trip2quiapo-registration') }}" class="m-0">	
                <button class="btn btn-sm btn-danger w-100 p-2 px-3" href="#" role="button"
                    style="border-radius: 15px; border: 1px solid">                        
                    <span style="font-size: 20px">
                        <strong>
                            Join the Workshop &raquo;
                        </strong>
                    </span>
                </button>
            </a>
        </div>
    </div>

    <div class="mobile-mode" style="display: none;">
        <img class="w-100" src="{{ asset('images/courses/ricky-lee-mobile-intro.jpg')}}" alt="">
    </div>
    <div class="mobile-mode" style="display: none;">
        <img class="w-100" src="{{ asset('images/courses/ricky-lee-mobile-quote.jpg')}}" alt="">
    </div>
    <div class="mobile-mode" style="display: none;">
        <img class="w-100" src="{{ asset('images/courses/ricky-lee-mobile-books-1.jpg')}}" alt="">
    </div>
    <div class="mobile-mode" style="display: none;">
        <img class="w-100" src="{{ asset('images/courses/ricky-lee-mobile-books-2.jpg')}}" alt="">
    </div>
    <div class="mobile-mode" style="display: none;">
        <img class="w-100" src="{{ asset('images/courses/ricky-lee-mobile-books-3.jpg')}}" alt="">
    </div>
    <div class="mobile-mode" style="display: none; background-color: #FFFFFF; margin-top: -0.5rem !important;">
        <div class="row d-flex flex-row justify-content-center">
            <a href="https://web.facebook.com/TripToQuiapo/photos/a.588995077825423/3171569212901317/?type=3&theater" 
            target="_blank" class="mb-4">	
                <button class="btn btn-sm btn-danger" href="#" role="button"
                    style="border-radius: 15px;">                        
                    <span style="font-size: 16px">
                        <strong>
                            Get His Books &raquo;
                        </strong>
                    </span>
                </button>
            </a>
        </div>
    </div>

    <div class="container-fluid mt-3">
        <div class="row d-flex flex-row mx-3">
            <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-xs-12">
                <div class="container">
                    <img class="w-100" src="{{ asset('images/courses/viber_image_2020-03-20_18-08-19.jpg')}}" alt="">
                </div>
                <h5 class="text-white text-center">
                    Since 1982, Dr. Ricky has been conducting free scriptwriting workshops for beginning writers, producing hundreds of graduates who now work for TV and film.
                </h5>
                <br>
                <div class="row d-flex flex-row justify-content-center">
                    <a href="{{ url('/trip2quiapo-registration') }}" class="mb-2 ml-2">	
                        <button class="btn btn-sm btn-danger px-2 py-1" href="#" role="button"
                            style="border-radius: 15px;">                        
                            <span style="font-size: 16px">
                                Join the Workshop &raquo;
                            </span>
                        </button>
                    </a>
                </div>
            </div>
            <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-xs-12">  
                <div class="container">
                    <div class="m-3">              
                        <video id="player" controls playsinline controlsList="nodownload"
                        style="width: 100%; height: 100%;" autoplay>
                            <source src="{{ $course->sneakpeak_video }}"
                            type="video/mp4"/>
                        </video>   
                    </div>    
                </div>     
            </div>
        </div> <!-- row -->
    </div>

    <div class="desktop-mode">
        <img class="w-100" src="{{ asset('images/courses/ricky-lee-grad.jpg')}}" alt="">
    </div>
    <div class="mobile-mode" style="display: none;">
        <img class="w-100" src="{{ asset('images/courses/ricky-lee-mobile-grad.jpg')}}" alt="">
    </div>

    <div class="container-fluid bg-light">
        <div class="row">
            <div class="col-xl-5 col-lg-12 col-md-12 col-sm-12 col-xs-12 pt-4 pr-0">
                <h1 class="text-center">
                    <strong>
                        <i>
                            Awards & Achievements
                        </i>
                    </strong>
                </h1>
                <img class="w-100 mt-2" src="{{ asset('images/courses/ricky-lee-sits-chair.jpg')}}" alt="">        
                <span class="m-2 mt-3">
                    Photo Credits: Grasya Orbon & Arjanmar Rebeta
                </span>
            </div>

            <div class="col-xl-7 col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3"
            style=""> 
                <div class="text-light p-3" 
                style="border: 1px solid #bbbbbb; background-color: #000000; 
                overflow: auto; max-height: 100vh"> 
                    <h5 style="line-height: 30px; ">                     
                        LIFE ACHIEVEMENT AWARDS FOR FILM AND LITERATURE<br>
                        <br>
                        ONE OF 100 CENTENNIAL AWARDEES, CULTURAL CENTER OF THE PHILIPPINES, 1998.<br>
                        CINEMANILA INTERNATIONAL LIFE ACHIEVEMENT AWARD. 2000. <br>
                        NATATANGING GAWAD URIAN LIFE ACHIEVEMENT AWARD 2003. <br>
                        ULIRANG ARTISTA SA LIKOD NG KAMERA, PMPC. 2014. <br>
                        UP GAWAD PLARIDEL FOR FILM. 2015. <br>
                        GAWAD CCP SA SINING (PARA SA LITERATURE). 2015. <br>
                        Gawad Direk. 2015.<br>
                        Iconic Award. Perpetual Help. 2015. <br>
                        International Film Festival Manhattan. 2016. <br>
                        FDCP Film Ambassador. 2017. <br>
                        Ani ng Dangal. 2017.<br>
                        WOW (Walk on Water). 2018. <br>
                        Dangal ni Balagtas. 2018. <br>
                        CinemaLente. 2018. <br>
                        Apolinario Mabini Media Awards PUP. 2018. <br>
                        <br>
                        Has written screenplays of films shown (either in or out of
                            competition) at the Cannes Film Festival, Berlin Film 
                            Festival, Toronto, Cairo, Fukouka, Tokyo, San Sebastian, 
                            Hawaii, Singapore, New York and other countries.<br>
                            <br>
                        Adviser/Founder: Trip to Quiapo Foundation Inc. 2018-Present<br>
                        President: Screenwriters Guild of the Philippines. 2001.<br>
                        Adviser/Founder: Phil. Writers Studio “PWS”, Inc. 1999.<br>
                        <br>
                        Palanca Memorial Awards for Literature, Short Story, First Prize,
                            H'wag, H'wag Mong Kukuwentuhan ang Batang si Wei-fung. 1969. <br>
                        Palanca Memorial Awards for Literature, Short Story, First Prize,
                            Servando Magdamag. 1970. <br>
                        Pilipino Free Press, First and Third Prize, annual literary
                            awards. H'wag, H'wag Mong Kukuwentuhan ang Batang si 
                            Wei-fung; and Pagtatapos. 1969.<br>
                        National Book Award, Manila Critics Circle. 1982. Brutal/Salome.<br>
                        Gawad Balagtas for 1983. Surian ng Wikang Pambansa for 
                            Outstanding Contribution to Literature and Cinema.<br>
                        Gawad ng Quezon City, 1995. Outstanding Citizen of Quezon
                            City in the field of film and literature.<br>
                        Gawad Balagtas Year 2000. Umpil (Writers Organization). <br>
                        Jose Rizal Awards, 2002, in the field of Arts and Culture. <br>
                        Natatanging Gawad ng Sining at Kultura, Ateneo de Manila, 2005. <br>
                        National Book Award. Si Amapola sa 65 na Kabanata. 2012. <br>
                        <br>
                        FILM AWARDS:<br>
                        <br>
                        BEST STORY.<br>
                        <br>
                        HIMALA. Metro Manila Film Festival Awards. 1982.<br>
                        ANDREA, PAANO BA ANG MAGING ISANG INA? Metro Manila Film
                            Festival. 1990.<br>
                        ANDREA, PAANO BA ANG MAGING ISANG INA? Famas. 1990.<br>
                        ANG TOTOONG BUHAY NI PACITA M. Metro Manila Film Festival. 1991.<br>
                        DAHIL MAHAL KITA (THE DOLZURA CORTEZ STORY). Manila Film <br>
                        Festival. 1993.<br>
                        MULING UMAWIT ANG PUSO. Metro Manila Film Festival Awards. 1995.<br>
                        RIZAL (co-writer). Metro Manila Film Festival, 1998.<br>
                        MURU-AMI. Metro Manila Film Festival Awards. 1999.<br>
                        MURU-AMI (co-writer). PASADO Awards. 2000.<br>
                        NASAAN KA MAN (co-writer). FAMAS AWARDS. 2006. <br>
                        HUSTISYA. PASADO. 2015. <br>
                        THE TRIAL. (co-writer). FAMAS AWARDS. 2015. <br>
                        <br>
                        BEST SCREENPLAY.<br>
                        <br>
                        JAGUAR (with Jose F. Lacaba). Urian Awards. 1980.<br>
                        SALOME. Urian Awards. 1981.<br>
                        HIMALA. Catholic Mass Media Awards. 1982.<br>
                        MORAL. Metro Manila Film Festival Awards. 1982.<br>
                        PRIVATE SHOW. Star Awards. 1986.<br>
                        PAANO KUNG WALA KA NA. Star Awards. 1987.<br>
                        OLONGAPO, THE GREAT AMERICAN DREAM. Metro Manila Film Festival. 
                            1987.<br>
                        SANDAKOT NA BALA (with Jose Carreon). Star Awards. 1988.<br>
                        SANDAKOT NA BALA (with Jose Carreon). Catholic Mass Media Awards.
                            1988.<br>
                        KALINANGAN AWARDEE. DIWA NG LAHI CULTURAL AWARD FOR CINEMA, 
                            418TH ANNIVERSARY OF THE CITY OF MANILA. 1989.<br>
                        MACHO DANCER. Star Awards. 1989.<br>
                        ANG BUKAS AY AKIN (adaptation). Star Awards. 1989.<br>
                        GUMAPANG KA SA LUSAK. Urian. 1990.<br>
                        ANDREA, PAANO BA ANG MAGING ISANG INA? Metro Manila Film
                            Festival. 1990.<br>
                        ANDREA, PAANO BA ANG MAGING ISANG INA? Star Awards. 1990.<br>
                        ANDREA, PAANO BA ANG MAGING ISANG INA? Famas. 1990.<br>
                        ANDREA, PAANO BA ANG MAGING ISANG INA? Film Academy of the 
                            Philippines. 1990.<br>
                        ANDREA, PAANO BA ANG MAGING ISANG INA? Young Critics Circle. 
                            1990.<br>
                        HAHAMAKIN LAHAT. Young Critics Circle. 1990.<br>
                        ANG TOTOONG BUHAY NI PACITA M. Metro Manila Film Festival. 1991.<br>
                        ANG TOTOONG BUHAY NI PACITA M. Kritika. 1991.<br>
                        HUWAG MONG SALINGIN ANG SUGAT. Kritika. 1991.<br>
                        ANG LALAKI SA SALAMIN EPISODE IN TAKBO, TALON, TILI. METRO MANILA 
                            FILM FESTIVAL. 1992. <br>
                        DAHIL MAHAL KITA (THE DOLZURA CORTEZ STORY). Manila Film 
                            Festival. 1993.<br>
                        PANGAKO NG KAHAPON. Star Awards. 1994.<br>
                        MULING UMAWIT ANG PUSO. Metro Manila Film Festival Awards. 1995. <br>
                        MAY NAGMAMAHAL SA'YO. Star Awards. 1997.<br>
                        RIZAL (co-writer). Best Screenplay, Metro Manila Film Festival, 
                            1998.<br>
                        RIZAL (co-writer). Best Adaptation. Star Awards. 1999.<br>
                        RIZAL (co-writer). Best Screenplay. FAMAS. 1999. <br>
                        MURU-AMI (co-writer). Best Screenplay. Metro Manila Film Festival
                            Awards. 1999.<br>
                        MURU-AMI (co-writer). Best Screenplay. PASADO Awards. 2000.<br>
                        BULAKLAK NG MAYNILA. Best Adapted Screenplay. Star Awards. 2000.<br>
                        BULAKLAK NG MAYNILA. Best Screenplay. Philippine Academy of the
                            Philippines. 2000.<br>
                        MURU-AMI. Guillermo de Vega Box Office Writer. 2000. <br>
                        ANAK. Best Screenplay. Film Academy of the Philippines. 2001.<br>
                        BAGONG BUWAN. Best Screenplay. Pasado Film Awards. 2002.<br>
                        DUBAI. Best Screenplay. Maria Clara Awards. 2006. <br>
                        NASAAN KA MAN (co-writer). Best Screenplay. FAMAS AWARDS. 2006.<br>
                        HIMALA. PASADO AWARDS. Pinakapasadong Manunulat sa lahat ng Panahon.<br>
                        HIMALA. Star Awards for Best Screenplay of all time. 2009. <br>
                        LAURIANA. Gawad Tanglaw. 2014. <br>
                        LAURIANA. PASADO Awards. 2014.<br>
                        THE TRIAL. (co-writer). FAMAS AWARDS. 2015. <br>
                        RINGGO THE DOG SHOOTER. Best Screenplay. Film Development Council of the Philippines. 2016. <br>
                        <br>
                        TV AWARDS.<br>
                        <br>
                        BEST STORY: MELINDA. Bahaghari Awards for Telecine, GMA 7,<br>
                        1996.<br>
                        BEST TELEPLAY. MELINDA. Bahaghari Awards for Telecine, GMA 7.<br>
                        1996. <br>                            

                    </h5>
                </div>
            </div>            
        </div>
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