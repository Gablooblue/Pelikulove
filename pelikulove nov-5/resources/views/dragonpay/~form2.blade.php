@extends('layouts.app')



@section('template_title')
PELIKULOVE - Enroll {{$service->course->title}}
@endsection

@section('template_fastload_css')
@endsection

@section('content')
<div class="container p-4">
    <div class="row d-flex flex-row justify-content-center">
        <div class="card shadow bg-white rounded">

            <div class="card-header">
                <h4>Enroll now at {{$service->course->title}}</h4>
            </div>
            <div class="card-body">
                <div class="col-md-6 col-sm-8 col-xs-12 pb-3">

                </div>

                <h5 class="text-center">Order Overview</h5>
                <hr>
                <p>Item : {{$service->name}}</p>
                <p>Desc : {{$service->course->title}} </p>
                <p>Amount : ₱{{ $service->amount }}</p>
                <hr>
                <p class="mt-3 font-weight-bold"> Choose a Payment Method </p>
                <form>
                    <div class="card bg-white rounded mb-3">
                        <div class="card-body">
                            <input type="radio" id="paymentChoice1" name="payment" value="DragonPay">
                            <label for="paymentChoice1">  <img src="{{ asset('images/logo_dragonpay.png') }}"
                                        style="width: 100px;" alt="Dragon Paylogo"
                                        class="img-responsive gateway__img ml-3"></label>
                        </div>
                    </div>

                    <div class="card bg-white mb-5 rounded">
                        <div class="card-body">
                            
                                <input type="radio" id="paymentChoice2" name="payment" value="BankDeposit">
                                <label class="ml-3" for="paymentChoice2">Bank Deposit</label>
                           

                        </div>
                    </div>

                </form>


                <form method="POST"
                    action="{{ route('checkout.payment.dragonpay', ['transaction_id' => encrypt($transaction_id)]) }}">
                    {{ csrf_field() }}
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