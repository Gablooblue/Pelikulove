@extends('layouts.app')

@section('template_title')
    Sales Report for {{$period}}
@endsection

@section('template_linked_css')
    @if(config('usersmanagement.enabledDatatablesJs'))
        <link rel="stylesheet" type="text/css" href="{{ config('usersmanagement.datatablesCssCDN') }}">
    @endif
    <style type="text/css" media="screen">
        .orders-table {
            border: 0;
        }
        .orders-table tr td:first-child {
            padding-left: 15px;
        }
        .orders-table tr td:last-child {
            padding-right: 15px;
        }
        .orders-table.table-responsive,
        .orders-table.table-responsive table {
            margin-bottom: 0;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">

                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                Sales Report for {{$period}}
                            </span>
						
                            
                        </div>
                    </div>

                    <div class="card-body">
						<div class="row mt-2 mb-2 ">
							<div class="col-md-3">
							<h5>Orders: <span class="pl-3 font-weight-bold text-danger">{{count($sales)}}</span> </h5>
							</div>
							<div class="col-md-3">
							<h5>Total Amount: <span class="pl-3 font-weight-bold text-danger">{{number_format($ta,2)}}</span></h5>
							</div>
							<div class="col-md-3">
							<h5>Net Amount: <span class="pl-3 font-weight-bold text-danger">{{$ta > 0 ? number_format($ta-$tsf,2) : "0.00"}}</span></h5>
							</div>
							<div class="col-md-3">
							<h5>Service Fees: <span class="pl-3 font-weight-bold text-danger">{{number_format($tsf,2)}}</span></h5>
							</div>
						</div>
                        
                        <div class="table-responsive orders-table">
                        
                            <table class="table table-striped table-sm data-table">
                                <caption id="order_count">
                                    {{ $sales->count()}} Sales Total
                                </caption>
                                <thead class="thead">
                                    <tr>
                                    	
                                    		
                                       <tr>
                                        <th class="text-nowrap">{!! trans('orders.orders-table.id') !!}</th>
                                        <th class="hidden-sm hidden-xs hidden-md text-nowrap">Date </th>    
                                     
                         				<th>{!! trans('orders.orders-table.email') !!}</th>
                                       
                                        <th class="hidden-xs">{!! trans('orders.orders-table.course') !!}</th>
                                         <th class="hidden-xs">Billable</th>
                                           <th>Payment</th>
                                        <th class="text-right text-nowrap">Sales {!! trans('orders.orders-table.amount') !!}</th>
                                        <th class="text-right text-nowrap">Net Amount</th>
                                        <th class="text-right text-nowrap">Net Service Fee</th>
                                     	
                                    </tr>
                                    
                                    
                                </thead>
                                     	
                                <tbody id="users_table">
                           
                               
                                    @foreach($sales as $value) 
                                    	@php $a = $value->amount; $sf = 0;
                                    	 if ($value->amount > 1666 && $value->billable == 1)  $sf = $value->amount * .03;
                                    	 if ($value->amount <= 1666 && $value->billable == 1) $sf = 50;
                                    	 $na = $a  - $sf; @endphp
                                        <tr>
                                        
                                        <th>{{$value->id}}</th>
                                         <td data-sort="{{strtotime($value->created_at)}}" class="hidden-sm hidden-xs hidden-md text-nowrap">{{ \Carbon\Carbon::parse($value->created_at)->format('j M Y') }} <br>{{ \Carbon\Carbon::parse($value->created_at)->format('h:i:s A') }}</td>
                                      
                         				 <td>{{$value->user->email}}<br> {{$value->user->first_name}} {{$value->user->last_name}}</td>
                
                                         <td class="hidden-xs">{{$value->service->name}}<br><span class="small">{{$value->service->name}}</span></td>
                                         <td class="hidden-xs">@if ($value->billable == 1) Yes @else No @endif</th>
                                         <td>{{$value->payment->name}}</td>
                                         <td class="text-right">{{ number_format($value->amount, 2) }}</td> 
                                         <td class="text-right">{{$na > 0 ? number_format($na,2) : "0.00"}}  </th>
                                         <td class="text-right">{{number_format($sf,2)}}</th>
                                             
                                        </tr>
                                    @endforeach
                                </tbody>
                                
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

@endsection

@section('footer_scripts')
    @if ((count($sales) > config('usersmanagement.datatablesJsStartCount')) && config('usersmanagement.enabledDatatablesJs'))
        @include('scripts.datatables')
    @endif
    
    @if(config('orders.tooltipsEnabled'))
        @include('scripts.tooltips')
    @endif
    
@endsection
