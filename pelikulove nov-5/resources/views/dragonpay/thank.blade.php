@extends('layouts.app')


		
@section('template_title')
    PELIKULOVE | Thank you for your payment
@endsection

@section('template_fastload_css')
@endsection

@section('content')

  <div class="container p-4">  
        <div class="row d-flex flex-row justify-content-center">
        	<div class="card shadow bg-white rounded">
        	
				<div class="card-header">
        		 @if ($order->payment_status ==  'F')
               		<h4>Payment Declined</h4>
               	 @elseif ($order->payment_status ==  'S')
                	<h4>Thank you for your payment</h4>
                 @elseif ($order->payment_status ==  'P')
                	<h4>Payment Pending</h4>
                 @else
                	<h4>Payment Issue</h4>
              	 @endif
    			</div>
    			
				
				<div class="card-body">
				<div class="col-md-8 col-sm-10 col-xs-12 pb-3">
        			<img src="{{ asset('images/logo_dragonpay.png') }}" alt="Dragon Paylogo" class="img-responsive gateway__img">
        			</div>	
        			
				@if ($order->payment_status ==  'S')
				<h5>Your payment details: </h5>
				<hr>
        			<p>Reference No : {{$transaction->refno}}</p>
        			<p>Transaction ID : {{$transaction->txnid}}</p>
       				<p>Item : {{$service->name}} </p>
       				<p>Description : {{$service->course->title}}</p>
        			<p>Amount : ₱{{ $order->amount }}</p>	
					
        			<a class="btn float-right btn-info" href="{{url('/course/'.$service->course->id.'/show')}}" role="button">Back to {{$service->name}} &raquo;</a>
        			
        		@else 	
        		<h5>Your transaction details: </h5>
				<hr>
        			<p>Reference No : {{$transaction->refno}}</p>
        			<p>Transaction ID : {{$transaction->txnid}}</p>
       				<p>Item : {{$service->name}} </p>
       				<p>Description : {{$service->course->title}}</p>
        			<p>Amount : ₱{{ $order->amount }}</p>	
        			<p>Message: {{$transaction->message}}</p>
        			
        			<a class="btn float-right btn-info" href="{{url('/course/'.$service->course->id.'/show')}}" role="button">Back to {{$service->name}}  &raquo;</a>
        			
        		 	
    	 		@endif	
    	 		
    			</div><!--card-body-->
    	
				
			</div><!--card-->     
        </div>	<!-- row -->	 
    </div><!-- container -->

@endsection

@section('footer_scripts')
@endsection
