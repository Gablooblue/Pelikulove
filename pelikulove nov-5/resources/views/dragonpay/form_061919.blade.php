@extends('layouts.app')



@section('template_title')
PELIKULOVE - Enroll {{$service->course->title}}
@endsection

@section('template_fastload_css')
@endsection

@section('content')
<div class=" col-md-6 container p-4">
    <div class="row d-flex flex-row justify-content-center">
        <div class=" card shadow bg-white rounded">

            <div class="card-header">
                <h4>Enroll now at {{$service->course->title}}</h4>
            </div>

            <div class="card-body">
                <div class="col-md-12  col-sm-8 col-xs-12 pb-3">
                </div>
                <h5> Rates</h5>

                <div class="card rounded col-md-12">
                    <div class="card-body justify-content-center">
                        <div>
                            <input type="radio" id="course-rate-regular" name="course-rate" value="1">
                            <label for="course-rate-regular">
                                <p class="ml-2"><span>&#8369;</span>3000 - Regular Rate of Basic Course</p>

                            </label>
                            <p class="ml-4" style="overflow-wrap: break-word;"> Gives you 1-year access to 9
                                hours’ worth of
                                video lessons, downloadable handouts, tambayan forum, saluhan workspace and
                                Plays-on-Video</p>


                        </div>

                        <div>
                            <input type="radio" id="course-rate-package-a" name="course-rate" value="2">
                            <label for="course-rate-package-a">

                                <p class="ml-2"><span>&#8369;</span>2899 - Promo Launch Rate Package A
                                </p>


                            </label>
                            <p class="ml-4" style="overflow-wrap: break-word;"> Gives you 1-year access to 9
                                hours’ worth of
                                video lessons, downloadable handouts, tambayan forum, saluhan workspace and
                                Plays-on-Video</p>
                        </div>

                        <div class="mt-0">
                            <input type="radio" id="course-rate-package-b" name="course-rate" value="3">
                            <label for="course-rate-package-b">

                                <p class="ml-2"><span>&#8369;</span>4999 - Promo Launch Rate Package B</p>


                            </label>

                            <p class="ml-4" style="overflow-wrap: break-word;"> Gives you 2-year access to all
                                inclusions of the basic course plus you get 2-year free membership in The Writer's Bloc
                                Online and you'll be the included in the priority lane for script feedback </p>
                        </div>
                    </div>
                </div>



                <h5 class="mt-2">Order Overview</h5>
                <hr>
                <p><span class="font-weight-bold">Item : </span> {{$service->name}}</p>
                <p><span class="font-weight-bold">Desc :</span> {{$service->course->title}} </p>
                <p><span class="font-weight-bold">Amount :</span> ₱{{ $service->amount }}</p>
                <form method="POST"
                    action="{{ route('checkout.process', ['transaction_id' => encrypt($transaction_id)]) }}">
                    {{ csrf_field() }}
                    <h5>Payment Options</h5>

                    <div class="card bg-white mb-3 rounded">
                        <div class="card-body">
                            <div class="form-group row ml-1 mb-2">
                                <input type="radio" id="choice1" name="payment" value="1">
                                <label for="choice1"> <img src="{{ asset('images/logo_dragonpay.png') }}"
                                        style="width: 130px;" alt="Dragon Pay logo" class="img-responsive ml-3"></label>

                            </div>
                            <div class="form-group row ml-1">
                                <input type="radio" id="choice2" name="payment" value="2">
                                <label class="ml-3" for="choice2"> <img src="{{ asset('images/logo_bdo.png') }}"
                                        style="width: 75px;" alt="BDO logo" class="img-responsive mr-1"> Bank
                                    Deposit</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="promo-code" class="col-sm-3 col-form-label">Promo Code</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="promo-code" placeholder="Insert promo code">
                        </div>
                    </div>
                    <button class="btn btn-lg btn-danger float-right btn-pay">
                        Pay
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection

@section('footer_scripts')
@endsection