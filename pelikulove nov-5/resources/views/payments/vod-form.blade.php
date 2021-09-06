@extends('layouts.app')



@section('template_title')
Watch {{$vod->title}}
@endsection

@section('template_fastload_css')
@endsection

@section('content')
<div class="container p-4">
    <div class="row d-flex flex-row justify-content-center">
    	<div class="col-md-9 col-sm-12">
            <div class="card shadow bg-white rounded ">
                <div class="card-header">
                    @if ($vod->category_id == 18)
                        <h4><strong>{{$vod->title}}</strong></h4>
                    @else
                        <h4>Watch <strong>{{$vod->title}}</strong> now</h4>
                    @endif
                </div>
                <div class="card-body mt-n3">               
                    <form method="post" action="{{ route('vod.process')}}">
                        {{ csrf_field() }}
                        <input type="hidden" name="vod_id" value="{{$vod->id}}">
                        @if (isset($order))
                            <input type="hidden" name="order_id" value="{{encrypt($order->id)}}">
                        @endif
                        <h5> 
                            Rates
                        </h5>    
                        <div class="card rounded mb-3">
                            <div class="card-body">
                                @foreach ($services as $s) 
                                    <div class="form-check ml-1 {{ $errors->has('service_id') ? ' is-invalid ' : '' }}">
                                        <input id="service_id_{{ $s->id }}" class="form-check-input" type="radio" data-amount="{{$s->amount}}" name="service_id" value="{{$s->id}}" @if (old('service_id') == $s->id || (isset($order->service_id) && $order->service_id == $s->id)) checked @endif>
                                        <label class="form-check-label"><p class="ml-2 font-weight-bold">&#8369;{{$s->amount}} - {{$s->name}}</p>
                                        <p class="ml-2" style="overflow-wrap: break-word;"> {{$s->description}}</p>
                                        </label>
                                        @if ($errors->has('service_id'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('service_id') }}</strong>
                                            </span>
                                        @endif
                                            
                                    </div>
                            
                                @endforeach 
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
                                {{-- <div class="form-group">
                                    <div class="row d-flex justify-content-start">  
                                        <h5 class="ml-3">
                                            <strong>                                  
                                                Feel free to donate to support the website!
                                            </strong>
                                        </h5>
                                    </div>
                                    <div class="container mt-2">
                                        <div class="row d-flex justify-content-center">
                                            <input type="number" class="form-control" id="donation" name="donation" 
                                            placeholder="₱0" value="@if (old('donation')) {{old('donation')}} @endif" 
                                            min="0" max="999999" step="1">
                                        </div>
                                    </div>
        
                                    <div class="form-control-feedback font-weight-bold ml-2 mt-3" id="pmsg">                                
                                    </div>
                                </div>   
        
                                <hr> --}}
        
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
                        <button class="btn btn-lg btn-danger float-right btn-pay">
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

$(document).ready(function(){

    // var c = $('#code').val(); 
    // $("[id^=promo]").addClass('d-none');
    // if (c != "") $("[id^=promo]").addClass('d-block');

    $('#donation').change(function(e){  		
        // var service_id = $('input[name=service_id]:checked').val();           
        var donation = $('#donation').val();
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
        
        // if (donationDecimal.length > 2) {
        //     donationDecimal = donationDecimal.slice(0, 2);
        // } else if (parseInt(donationDecimal) > 99) {
        //     donationDecimal = 99;
        // } 

        donation = parseFloat(donationWhole + "." + donationDecimal);
        
        $('#donation').val(donation);

        var serviceAmt = parseFloat($('input[name=service_id]:checked').data("amount"));
        var amt;    
        if (isNaN(donation)) {
            donation = 0;
        }
        if (isNaN(serviceAmt)) {
            serviceAmt = 0;
        }
        
        amt = serviceAmt + donation;
        if (isNaN(amt)) {
            amt = 0;
        }
        
    	$('#amount').val(amt);
    })
	
	$('input[type=radio][name=service_id]').change(function(e) {
		$('#pmsg').empty();
		$('#code').val("");
		$("[id^=promo]").addClass('d-none');
		var s = e.target.value;
		
    	var amt = parseFloat($('input[name=service_id]:checked').data("amount"));
        var donation = parseFloat($('#donation').val());    	

        if (isNaN(amt)) {
            amt = 0;
        }
        if (isNaN(donation)) {
            donation = 0;
        }
        
        trueAmt = amt + donation;

        if (!isNaN(trueAmt)) {
            $('#amount').val(trueAmt);
        } else {            
            $('#amount').val(0);
        }

    	$("#promo_"+s).addClass('d-block');    	
    });
		
    var amt = parseFloat($('input[name=service_id]:checked').data("amount"));
    var donation = parseFloat($('#donation').val());    	

    if (isNaN(amt)) {
        amt = 0;
    }
    if (isNaN(donation)) {
        donation = 0;
    }
    
    trueAmt = amt + donation;

    if (!isNaN(trueAmt)) {
        $('#amount').val(trueAmt);
    } else {            
        $('#amount').val(0);
    }
});
</script>
@endsection

@section('footer_scripts')
@endsection
