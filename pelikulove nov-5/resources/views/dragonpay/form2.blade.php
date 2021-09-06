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
               
                <form method="POST" action="{{ route('checkout.process2')}}">
                    {{ csrf_field() }}
                    
                    <h6> Rates</h6>

                	<div class="card  rounded mb-3">
                    <div class="card-body">
                    @foreach ($services as $s) 
                        <div class="form-check">
                            <input class="form-check-input" type="radio" data-amount="{{$s->amount}}" name="service_id" value="{{$s->id}}">
                            <label class="form-check-label"><p class="ml-2">&#8369;</span>{{$s->amount}}- {{$s->name}}</p>
                            <p class="ml-2" style="overflow-wrap: break-word;"> {{$s->description}}</p>
                            </label>
                        </div>
                        
                    
					@endforeach
                        
                    </div>
               		 </div>
               		 
               		 
                    <h6>Payment Options</h6>

                    <div class="card mb-3 rounded">
                        <div class="card-body">
                        	
                        	@foreach ($payments as $p)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="payment" value="{{$p->id}}">
                                <label class="form-check-label"> <img src="{{ asset('images/'.$p->logo) }}"
                                        style="width: 100px;" alt="{{$p->name}} logo" class="img-responsive ml-3"></label>

                            </div>
                            
                            @endforeach
                            
                           
                            
                        </div>
                    </div>

                    
                    
                    <h5>Amount to Pay: </h5> <input type="text" id="amount" name="amount" value="" readonly>
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

	$('.ajaxSubmit').click(function(e){
  			e.preventDefault();
  			$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        	});
         var service_id = $('#service_id').val();
         var code = $('#code').val();
         var amt = null;
         
        
         
    
         

    });   	
	
    
	
	$('input[type=radio][name=service_id]').change(function() {
    	var amt = $('input[name=service_id]:checked').data("amount");
    	
    	$('#amount').val(amt);
    });
});
</script>
@endsection

@section('footer_scripts')
@endsection
