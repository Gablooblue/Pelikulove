@extends('layouts.app')


		
@section('template_title')
    Thank you for your payment
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
        			<img src="{{ asset('images/'. $order->payment->logo) }}" alt="Paylogo" class="img-responsive gateway__img">
        			</div>	
				
				{{-- Check if Course or Vod --}}
				@if (isset($service->course_id))
					{{-- If Course --}}
					@if ($order->payment_status ==  'S')
						<h5>Your payment details: </h5>
						<hr>
						<p>Reference No : {{$transaction->refno}}</p>
						<p>Transaction ID : {{$transaction->txnid}}</p>
						<p>Order ID: {{$order->id}}
						<p>Item : {{$service->name}} </p>
						<p>Description : {{$service->course->title}}</p>
						<p>Amount : ₱{{ number_format($order->amount) }}</p>	

						<a class="btn float-right btn-info" href="{{url('/course/'.$service->course->id.'/show')}}" role="button">Back to {{$service->course->title}} &raquo;</a>
					@else 	
						<h5>Your transaction details: </h5>
						<hr>
						<p>Reference No : {{$transaction->refno}}</p>
						<p>Transaction ID : {{$transaction->txnid}}</p>
						<p>Order ID: {{$order->id}}
						<p>Item : {{$service->name}} </p>
						<p>Description : {{$service->course->title}}</p>
						<p>Amount : ₱{{ number_format($order->amount) }}</p>	
						<p>Message: {{$transaction->message}}</p>
						
						<a class="btn float-right btn-info" href="{{url('/course/'.$service->course_id.'/show')}}" role="button">Back to {{$service->course->title}}  &raquo;</a>
					@endif	
				@elseif (isset($service->vod_id))
					{{-- If Vod --}}
					@if ($order->payment_status ==  'S')
						<h5>Your payment details: </h5>
						<hr>
						<p>Reference No : {{$transaction->refno}}</p>
						<p>Transaction ID : {{$transaction->txnid}}</p>
						<p>Order ID: {{$order->id}}
						<p>Item : {{$service->name}} </p>
						<p>Description : {{$service->vod->title}}</p>
						<p>Amount : ₱{{ number_format($order->amount) }}</p>
						@if (isset($order->donation) && $order->donation > 0) 
							<p>Donation : ₱{{ number_format($order->donation) }}</p>
						@endif

						<a class="btn float-right btn-info" href="{{url('/blackbox/'.$service->vod_id.'/watch')}}" role="button">Watch {{$service->vod->title}} now &raquo;</a>
					@else 	
						<h5>Your transaction details: </h5>
						<hr>
						<p>Reference No : {{$transaction->refno}}</p>
						<p>Transaction ID : {{$transaction->txnid}}</p>
						<p>Order ID: {{$order->id}}
						<p>Item : {{$service->name}} </p>
						<p>Description : {{$service->vod->title}}</p>
						<p>Amount : ₱{{ number_format($order->amount) }}</p>
						@if (isset($order->donation) && $order->donation > 0) 
							<p>Donation : ₱{{ number_format($order->donation) }}</p>
						@endif
						<p>Message: {{$transaction->message}}</p>
						
						<a class="btn float-right btn-info" href="{{url('/blackbox')}}" role="button">Back to Vod &raquo;</a>
					@endif						
				@elseif ($service->id == 15)
					{{-- If Donation --}}
					@php
						$donation = \App\Models\Donation::where('order_id', $order->id)->first();
						$d_cause = \App\Models\DonationCause::where('id', $donation->cause_id)->first();
					@endphp
					@if ($order->payment_status ==  'S')
						<h5>Your payment details: </h5>
						<hr>
						<p>Reference No : {{$transaction->refno}}</p>
						<p>Transaction ID : {{$transaction->txnid}}</p>
						<p>Order ID: {{$order->id}}

						@if (isset($d_cause))
							<p>Cause : {{$d_cause->title}} </p>
						@else
							<p>Cause : None </p>
						@endif

						@if (isset($donation->notes))
							<p>Note : {{$donation->notes}}</p>
						@endif
						
						<p>Amount : ₱{{ number_format($order->amount) }}</p>

						<a class="btn float-right btn-info" href="{{url('/home')}}" role="button">Return to Home Page &raquo;</a>
					@else 	
						<h5>Your transaction details: </h5>
						<hr>
						<p>Reference No : {{$transaction->refno}}</p>
						<p>Transaction ID : {{$transaction->txnid}}</p>
						<p>Order ID: {{$order->id}}

						@if (isset($d_cause))
							<p>Cause : {{$d_cause->title}} </p>
						@else
							<p>Cause : None </p>
						@endif

						@if (isset($donation->notes))
							<p>Notes : {{$donation->notes}}</p>
						@endif
						
						<p>Amount : ₱{{ number_format($order->amount) }}</p>
						<p>Message: {{$transaction->message}}</p>						

						<a class="btn float-right btn-info" href="{{url('/home')}}" role="button">Return to Home Page &raquo;</a>
					@endif	
				@endif		
    	 		
    			</div><!--card-body-->
    	
				
			</div><!--card-->     
        </div>	<!-- row -->	 
    </div><!-- container -->

@endsection

@section('footer_scripts')
@endsection
