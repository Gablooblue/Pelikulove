@extends('layouts.app')

@section('template_title')
Mentor - {{ $instructor->name }}
@endsection

@section('template_fastload_css')
@endsection

@section('content')




<div class="container">
    <div class="row d-flex flex-row">
        <div class="card shadow bg-white rounded">
            <div class="card-header @role('admin', true) bg-secondary text-white text-center @endrole">


            </div>



            <div class="card-body">
                <img class="d-block w-100 pb-5" src="{{ asset('images/rcv-photo-mentor-profile.jpg') }}"
                    alt="Photo of Rody Vera">
                    <div class="px-3">
                    <h4 class="text-center font-weight-bold pb-3">About Rody</h4>
                    <p>Rodolfo “Rody” Carlos Vera may be receiving lots of screenwriting credits recently but first
                        and
                        foremost, he is a dramaturg, a theater extraordinaire, and an award-winning playwright.

                    </p>

                    <p class="font-weight-bold">
                        <!--italic and bold-->
                        “I was part of a generation that was influenced by foreign playwrights. But from that
                        foundation, gusto ko gumawa ng sarili in my own terms. And that has also spurred my
                        commitment to playwrights’ development.” <sup>1</sup>

                    </p>

                    <p>It is this deep-seated dedication to theater and commitment to playwrights that led to him
                        establishing The Writer’s Bloc in 2004, an independent organization of established and
                        aspiring
                        Filipino playwrights; and his founding (with former Tanghalang Pilipino Artistic Director
                        Herbie
                        Go) and spearheading of the Virgin Labfest (VLF) 15 years ago – an annual playwrights-led
                        festival of untried, untested, unstaged works on theater which has since changed the
                        landscape
                        of playwriting and redefined theatergoing in the country.
                    </p>

                    <p>
                        Rody’s commitment also extends to education. He has been teaching playwriting and
                        theater acting since the ‘80s and has held more than 50 workshops all over the
                        country and even abroad.


                    </p>

                    <p>Numerous recognitions and titles aside, Rody, at his core, is a Filipino creative with a deep
                        and
                        profound sense of social empathy.
                    </p>
                    <p>After enrolling in a summer workshop for teenagers at the Philippine Educational Theater
                        Association (PETA), he began to see theater as a powerful medium of advocacy especially
                        during
                        the Martial Law period. Rody would then go on to write plays for other organizations,
                        events,
                        and theater companies -- with a burning desire to help the general public understand current
                        social issues.
                    </p>

                    <p>
                        Rody was also largely influenced by his mentors:
                        Rene Villanueva, who taught him how to make use of political allegories; Al Santos,
                        who showed him how to develop and modernize traditional forms of theater; and Fritz
                        Bennewitz, who instilled in him Bertolt Brecht’s philosophy for theater-making, how to
                        translate and adapt for the stage as well as play analysis and dramaturgy<sup>2</sup>.

                    </p>

                    <p>A great product of renowned playwrights, Rody himself has become one of the
                        greats. As of writing, he has created a large body of work, having written more than
                        30 original plays and adapted or translated more than 30 foreign works to Filipino.
                    </p>

                    <div class="justify-content-center text-center font-italic">
                        <p>Rody, a multi-talented, award-winning writer.
                        </p>
                        <p>A passionate and committed teacher.
                        </p>
                        <p>A true game-changer.
                        </p>

                        <p>And now, our <span class="font-weight-bold">artist-mentor.</span>
                        </p>

                    </div>
                  
                </div>
<hr>
                <h5 class="text-center font-weight-bold py-5">Awards and Achievements</h5>
                <div class="px-3 row">
                    <div class="col-md">
                        <ul class="list-unstyled">
                            <p class="font-weight-bold">2019</p>
                            <li>“Signal Rock”, Best Script in the Asian Competition Section, Dhaka International
                                Film
                                Festival; Philippine representative to the 76th Golden Globe Awards and 91st Academy
                                Awards;
                                Best Screenplay, Gawad Urian
                            </li>
                            <li>Dangal ni Balagtas, Komisyon sa Wikang Filipino
                            </li>
                        </ul>


                        <ul class="list-unstyled">
                            <p class="font-weight-bold">2017</p>
                            <li>
                                “Die Beautiful”, Movie Screenwriter of the Year, 33rd PMPC Star Awards for Movies

                            </li>
                        </ul>

                        <ul class="list-unstyled">
                            <p class="font-weight-bold">2015</p>
                            <li>Gawad Tanglaw ng Lahi, Ateneo De Manila University
                            </li>
                            <li>Gawad Pambansang Alagad ni Balagtas para sa Dula sa Filipino, Unyon ng mga Manunulat
                                sa
                                Pilipinas
                            </li>
                        </ul>


                        <ul class="list-unstyled">
                            <p class="font-weight-bold">2014</p>
                            <li>“Norte: Hangganan ng Kasaysayan”, Best Screenplay, URIAN Awards, co-written with Lav
                                Diaz
                            </li>
                            <li>"Der Kaufmann", Outstanding Translation or Adaptation, Philstage Gawad Buhay Awards
                            </li>
                            <li>"D' Wonder Twins of Boac", Outstanding Original Libretto, Philstage Gawad Buhay
                                Awards
                            </li>




                        </ul>

                    </div>

                    <div class="col-md">
                        <ul class="list-unstyled">
                            <li>Hall of Fame, Carlos Palanca Memorial Awards for Literature
                                <p>1st Prize, (Screenplay, Filipino) for the film "Lakambini"
                                </p>
                                <p>1st Prize, (Screenplay, Filipino) for the film “Death March”
                                </p>
                                <p>1st Prize, (Full-Length Play, Filipino) for “Paalam, Sr. Soledad”
                                </p>
                                <p>1st Prize, (Full-Length Play, Filipino) for “Ismail at Isabel”, a play for young
                                    people on the Muslim-Christian conflict
                                </p>
                                <p>1st Prize, (Full-length play, Filipino) for “Luna, Isang Romansang Aswang”
                                </p>
                            </li>
                        </ul>
                        <ul class="list-unstyled">

                            <p class="font-weight-bold">2012</p>
                            <li>“Niño”, Best Screenplay, Young Critic’s Circle
                            </li>
                        </ul>


                        <ul class="list-unstyled">
                            <p class="font-weight-bold">2009</p>
                            <li>“Boses”, Best Screenplay, Golden Screen Awards, Gawad Tanglaw ng Lahi, co-writer
                                with
                                Froi Medina
                            </li>
                        </ul>

                        <ul class="list-unstyled">

                            <p class="font-weight-bold">1998</p>
                            <li>“Senyor Paciano”, 2nd Prize, National Centennial Literary Awards (Screenplay,
                                Filipino)
                            </li>
                        </ul>
                    </div>
                </div>

                <hr>
               
                <div class="text-muted">
                        <ul style="list-style-type: none">
                            <li><sup>1</sup>Vera, Rodolfo C. (2019). Two Women as Specters of History. Quezon City,
                                National Capital
                                Region: Ateneo De Manila University Press.</li>
                            <li>
                                <sup>2</sup>Vera, Rodolfo C. (2010). Playwriting in the Time of Exigency. Kritika
                                Kultura, 14, 103-110, <a class="text-decoration-none"
                                    href="www.ateneo.edu/kritikakultura">www.ateneo.edu/kritikakultura</a>.

                            </li>
                        </ul>

                    </div>

            </div>
            <!--card-body-->






        </div>
        <!--card-->
    </div> <!-- row -->
</div><!-- container -->

@endsection

@section('footer_scripts')
@endsection