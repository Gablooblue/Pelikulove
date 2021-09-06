@extends('layouts.app')



@section('template_title')
PELIKULOVE - Enroll {{$course->title}}
@endsection

@section('template_fastload_css')
@endsection

@section('content')
<div class="container p-4">
    <div class="row d-flex flex-row justify-content-center">
    	<div class="col-md-9 col-sm-12">
        <div class="card shadow bg-white rounded ">

            <div class="card-header">
                <h4>Enroll now at {{$course->title}}</h4>
            </div>

            <div class="card-body">
               
                <form method="post" action="{{ route('checkout.process')}}">
                    {{ csrf_field() }}
                    
                    <h5> Rates</h5>

                	<div class="card  rounded mb-3">
                    <div class="card-body">
                    @foreach ($services as $s) 
                        <div class="form-check {{ $errors->has('service_id') ? ' has-danger ' : '' }}">
                            <input class="form-check-input" type="radio" data-amount="{{$s->amount}}" name="service_id" value="{{$s->id}}" @if (old('service_id') == $s->id) checked @endif>
                            <label class="form-check-label"><p class="ml-2">&#8369;{{$s->amount}}- {{$s->name}}</p>
                            <p class="ml-2" style="overflow-wrap: break-word;"> {{$s->description}}</p>
                            </label>
                        </div>
                         @if ($s->codes())
                        @foreach ($s->codes as $c) @if ($c->service_id == $s->id) 
                        <div  id="promo_{{$s->id}}">
                       
                        <div class="form-group row">
                        	<label for="promo-code" class="col-sm-2 col-form-label ml-4 font-weight-bold">Promo Code</label>
                        	<div class="col-sm-9 col-md-6">
                            	<input type="text" class="form-control" id="code" name="code" placeholder="Promo code for {{$s->name}}" value="{{old('code')}}">
                            	
                        	</div>
                        	
                        	<button type="button" class="btn btn-sm btn-danger float-right btn-pay" id="ajaxSubmit">Enter Code</button>
                        	
                        	 <div class="form-control-feedback font-weight-bold ml-4" id="pmsg"></div>
                        </div>
                       
                      
                        </div>
                        @endif
                        @endforeach
                        @endif
                   
					@endforeach
                        
                    </div>
               		 </div>
                   <h5>Payment Options</h5>

                    <div class="card mb-3 rounded">
                        <div class="card-body">
                        	
                        	@foreach ($payments as $p) @if ($p->online == 1)
                            <div class="form-check mb-2 {{ $errors->has('payment') ? ' has-danger ' : '' }}">
                                <input class="form-check-input" type="radio" name="payment" value="{{$p->id}}" @if (old('payment') == $p->id) checked @endif>
                                <label class="form-check-label"> <img src="{{ asset('images/'.$p->logo) }}"
                                        style="width: 100px;" alt="{{$p->name}} logo" class="img-responsive ml-3"></label>

                            </div>
                            @endif
                            @endforeach
                       </div>
                    </div>
                    <div class="card mb-3 rounded">
                    	<div class="card-body">
                    	
                    		<div class="form-group row">
                    			<label for="amount" class="col-sm-3 col-form-label font-weight-bolder"><h4>Amount to Pay: </h4></label>
    							<div class="col-sm-4">
									<input type="text" id="amount" name="amount" class="form-control form-control-lg font-weight-bolder  pl-2" value="{{old('amount')}}" readonly>
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

$("[id^=promo]").addClass('d-none');

$('#ajaxSubmit').click(function(e){
  			
  		
         var service_id = $('input[name=service_id]:checked').val();
         var code = $('#code').val();
         var amt = null;
       
         $.get("/ajax/check/"+ code +"/"+service_id, function(data){
              
                $('#pmsg').empty();
               
               
                if (data.amount == undefined) {
                	$('#pmsg').removeClass( "text-success" );
                	$('#pmsg').append(data.error).addClass( "text-danger" );
                	
                }
                else {
                	$('#amount').empty();
                 	$('#amount').val(data.amount);
                 	$('#pmsg').removeClass( "text-danger" );
                	$('#pmsg').append("Promo Code Applied. Amount is now &#8369;" + data.amount + "." ).addClass( "text-success" );
                }
        	});
        })
	
	$('input[type=radio][name=service_id]').change(function(e) {
		$('#pmsg').empty();
		$('#code').val("");
		var s = e.target.value;
		
    	var amt = $('input[name=service_id]:checked').data("amount");
    	
    	$('#amount').val(amt);
    	$("#promo_"+s).addClass('d-block');
    	
    });
});
</script>
@endsection

@section('footer_scripts')
@endsection
