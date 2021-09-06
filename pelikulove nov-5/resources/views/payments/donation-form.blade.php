@extends('layouts.app')



@section('template_title')
Donate And Help Make Pinoy Arts Sustainable!
@endsection

@section('template_fastload_css')
@endsection

@section('content')
<div class="container p-4">
    <div class="row d-flex flex-row justify-content-center">
    	<div class="col-md-9 col-sm-12">
            <div class="card shadow bg-white rounded ">
                <div class="card-header">
                    <h4>Donate And Help Make Pinoy Arts Sustainable!</h4>
                    <p class="small mx-2">
                        PELIKULOVE, an online multi-channel arts platform, is made of a small team of hardworking 
                        creatives and tech which aims to harness the power of arts, culture, and technology to help 
                        build a better society where artists and cultural groups with complementing goals exchange 
                        knowledge, share resources, take risks and find industry solutions together - all to strengthen 
                        the Filipino voice globally. <br>
                        <br>
                        Your contribution will not only help sustain the displaced artists who worked on a particular 
                        project but also help us create more meaningful content for you and the rest of the world. <br>
                    </p>
                </div>
                <div class="card-body mt-n3">               
                    <form method="post" action="{{ route('donations.store')}}">
                        {{ csrf_field() }}
                        {{-- <input type="hidden" name="vod_id" value="{{$vod->id}}"> --}}
                        {{-- <input type="hidden" name="service_id" value="0"> --}}
                        @if (isset($order))
                            <input type="hidden" name="order_id" value="{{encrypt($order->id)}}">
                        @endif

                        <h5> 
                            Amount
                        </h5>    
                        <div class="card rounded mb-3 px-3">
                            <div class="row mt-3">

                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 mb-3">
                                    <div class="card row justify-content-center mx-1 border-0">
                                        <button type="button" id="300btn" value="300" class="btn btn-lg btn-outline-dark">
                                            <div class="row justify-content-center py-4">
                                                <h5 class="col-12 text-center mb-0">
                                                    <strong>
                                                        ₱300
                                                    </strong>
                                                    <br>
                                                    <span class="small">
                                                        PHP
                                                    </span>
                                                </h5>	
                                            </div>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 mb-3">
                                    <div class="card row justify-content-center mx-1 border-0">
                                        <button type="button" id="500btn" value="500" class="btn btn-lg btn-outline-dark">
                                            <div class="row justify-content-center py-4">
                                                <h5 class="col-12 text-center mb-0">
                                                    <strong>
                                                        ₱500
                                                    </strong>
                                                    <br>
                                                    <span class="small">
                                                        PHP
                                                    </span>
                                                </h5>	
                                            </div>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 mb-3">
                                    <div class="card row justify-content-center mx-1 border-0">
                                        <button type="button" id="1000btn" value="1000" class="btn btn-lg btn-outline-dark">
                                            <div class="row justify-content-center py-4">
                                                <h5 class="col-12 text-center mb-0">
                                                    <strong>
                                                        ₱1000
                                                    </strong>
                                                    <br>
                                                    <span class="small">
                                                        PHP
                                                    </span>
                                                </h5>	
                                            </div>
                                        </button>
                                    </div>
                                </div>

                            </div>

                            <div class="row mb-3">
                                <div class="col-12">
                                    {{-- <div class="card row justify-content-center mx-1"> --}}
                                        <div class="row justify-content-center pt-1">
                                            <h5 class="col-12">
                                                <div class="input-group">
                                                    <div class="input-group-append">
                                                        <label class="input-group-text" for="customAmount">
                                                            <strong>
                                                                ₱
                                                            </strong>
                                                        </label>
                                                    </div>
                                                    {{-- <strong>
                                                        Any Amount
                                                    </strong>
                                                    <br> --}}
                                                    <input type="number" class="form-control" id="customAmount" 
                                                    name="customAmount" placeholder="Any amount" 
                                                    value="@if (old('customAmount')) {{old('customAmount')}} 
                                                    @elseif (isset($order->customAmount)) {{$order->customAmount}} @endif" 
                                                    min="0" max="999999" step="1">
                                                </div>
                                            </h5>	
                                        </div>
                                    {{-- </div> --}}
                                </div>
                            </div>
                        </div>

                        <h5>
                            Donation Cause
                        </h5>
                        <div class="card mb-3 rounded">
                            <div class="card-body">
                                <div class="input-group">
                                    <select class="custom-select form-control" name="cause_id" id="cause_id">                                        
                                        <option value="0">
                                            None
                                        </option>
                                        @foreach($donationCauses as $cause)
                                            <option value="{{ $cause->id }}">                                                
                                                {{ $loop->iteration }}. {{ $cause->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="cause_id">
                                            <i class="fa fa-folder-open fa-fw" aria-hidden="true"></i>
                                        </label>
                                    </div>
                                </div>
                                @if ($errors->has('cause_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cause_id') }}</strong>
                                    </span>
                                @endif                    
                            </div>
                        </div>

                        <h5>
                            Add a note
                        </h5>
                        <div class="card mb-3 rounded">
                            <div class="card-body">
                                <div class="input-group">
                                {!! Form::textarea('note', NULL, array('id' => 'note', 'class' => 'form-control', 'placeholder' => 'My note...')) !!}
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="note">
                                            <i class="fa fa-pencil-square-o fa-fw" aria-hidden="true"></i>
                                        </label>
                                    </div>
                                </div>
                                @if ($errors->has('note'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('note') }}</strong>
                                    </span>
                                @endif               
                            </div>
                        </div>

                        <h5>
                            Payment Options
                        </h5>
                        <div class="card mb-3 rounded">
                            <div class="card-body">
                                @foreach ($payments as $pMethod) 
                                    @if ($pMethod->online == 1)
                                        <div class="form-check mb-2 {{ $errors->has('payment') ? ' is-invalid ' : '' }}">
                                            <input class="form-check-input" type="radio" name="payment" value="{{$pMethod->id}}" @if (old('payment') == $pMethod->id || (isset($order->payment_id) && $order->payment_id == $pMethod->id)) checked @endif>
                                            <label class="form-check-label"> 
                                                <span class="pl-3 font-weight-bold">{{$pMethod->description}}</span> 
                                                <br> 
                                                <img src="{{ asset('images/'.$pMethod->logo) }}"
                                                    alt="{{$pMethod->name}} logo" class="img-responsive ml-3">
                                            </label>
                                            @if ($errors->has('payment'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('payment') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                @endforeach                                
                            </div>
                        </div>

                        <div class="card mb-3 rounded">
                            <div class="card-body">        
                                <div class="form-group row">
                                    <label for="amount" class="col-sm-3 col-form-label font-weight-bolder">
                                        <h4>
                                            Amount to Pay: 
                                        </h4>
                                    </label>
                                    <div class="col-sm-4">
                                    <input type="text" id="amount" name="amount" class="form-control form-control-lg font-weight-bolder  pl-2" placeholder="₱0" readonly>
                                    </div>
                                </div>                                    
                            </div>
                        </div>
                        <button id="payBtn" class="btn btn-lg btn-danger float-right btn-pay" disabled>
                            Pay Now
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@section('amountajax')
    <script>
        $(document).ready(function() {            
                
            $('#amount').val($('#customAmount').val());

            if ($('#amount').val() > 0) {
                document.getElementById('payBtn').disabled=false;
            }

            // var c = $('#code').val(); 
            // $("[id^=promo]").addClass('d-none');
            // if (c != "") $("[id^=promo]").addClass('d-block');

            $('#customAmount').change(function(e){  		
                // var service_id = $('input[name=service_id]:checked').val();           
                var donation = $('#customAmount').val();
                var donationSplit = donation.split(".");
                var donationWhole = donationSplit[0];
                var donationDecimal = donationSplit[1];

                // if (donationDecimal == undefined) {
                    donationDecimal = 0;
                // }      

                if (parseInt(donationWhole) > 999999) {
                    donationWhole = 999999;
                } else if (parseInt(donationWhole) < 0) {
                    donationWhole = 0;
                }
                // donation = parseFloat(donationWhole + "." + donationDecimal);
                donation = donationWhole;   

                console.log(donation);   

                switch (donation) {
                    case '300':
                        $('#300btn').focus();    
                        console.log('300btn');                      
                        break;
                    case '500':
                        $('#500btn').focus(); 
                        console.log('500btn');  
                        break;
                    case '1000':
                        $('#1000btn').focus(); 
                        console.log('1000btn');  
                        break;

                    default:
                        break;
                }
                
                $('#customAmount').val(donation);

                // var serviceAmt = parseFloat($('input[name=service_id]:checked').data("amount"));
                // var amt;    
                // if (isNaN(donation)) {
                //     donation = 0;
                // }
                // if (isNaN(serviceAmt)) {
                //     serviceAmt = 0;
                // }
                
                // amt = serviceAmt + donation;
                amt = donation;
                if (isNaN(amt)) {
                    amt = 0;
                }

                if (amt > 0) {                    
                    document.getElementById('payBtn').disabled=false;
                } else {
                    document.getElementById('payBtn').disabled=true;
                }
                
                $('#amount').val(amt);
            })

            $("#300btn").on('click', function(e){
                $('#customAmount').val(300);
                $('#amount').val(300);
                document.getElementById('payBtn').disabled=false;
            });

            $("#500btn").on('click', function(e){
                $('#customAmount').val(500);
                $('#amount').val(500);
                document.getElementById('payBtn').disabled=false;
            });

            $("#1000btn").on('click', function(e){
                $('#customAmount').val(1000);
                $('#amount').val(1000);
                document.getElementById('payBtn').disabled=false;
            });
        });
    </script>
@endsection

@section('footer_scripts')
@endsection
