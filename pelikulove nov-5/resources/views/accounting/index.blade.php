@extends('layouts.app')

@section('template_title')
   Sales Invoices
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
                                Sales Invoices
                            </span>
						
                            
                        </div>
                    </div>

                    <div class="card-body">

                        
                        <div class="table-responsive orders-table">
                            <table class="table table-striped table-sm data-table">
                                <caption id="order_count">
                                    {{ $invoices->count()}} Invoice(s) Total
                                </caption>
                                <thead class="thead">
                                    <tr>
                                    	<th>Month Year</th>
                                    	<th class="text-right">Paid</th>
                                    	<th class="text-right">Orders</th>
                                        <th class="text-right">Sales</th>
                                        <th class="text-right">Net Amount</th>
                                    	<th class="text-right">Net Service Fee</th>
                                    	
                                    	
                                    	
                                    </tr>
                                </thead>
                                <tbody id="users_table">@php $c = $ts = $sf = 0;  $month = ""; @endphp
                                    @foreach($invoices as $invoice) @php  
    										  $c = $invoice->orders + $c; $ts = $ts + $invoice->sales;; $sf = $invoice->net_servicefee + $sf; list($mon, $year) = explode(" ", $invoice->period);
    										  $date = strtotime($mon . " 1 " . $year);
    										  $month = date('m', $date);
    										  
    										  @endphp
                                        <tr>
                                         <td><a href="{{URL::to('accounting/' . $year . '/' . $month )}}">{{$invoice->period}}</a></td>
                                          <td class="text-right">@if ($invoice->paid == 0) No @else Yes @endif</td>
                                          <td class="text-right">{{$invoice->orders}}</td>
                                          <td class="text-right">@if ($invoice->sales > 0) {{number_format($invoice->sales,2)}} @else 0.00 @endif</td>
                                          <td class="text-right">@if ($invoice->net_amount > 0) {{number_format($invoice->net_amount,2)}} @else 0.00 @endif</td></td>
                                          <td class="text-right">@if ($invoice->net_servicefee > 0)  {{number_format($invoice->net_servicefee,2)}} @else 0.00 @endif</td></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tr>
                                         <td>TOTAL</td>
                                          <td>&nbsp;</td>
                                          <td class="text-right">{{$c}}</td>
                                          <td class="text-right">@if ($ts > 0) {{number_format($ts,2)}} @else 0.00 @endif</td>
                                          <td class="text-right">@if ($ts-$sf > 0) {{number_format($ts-$sf,2)}} @else 0.00 @endif</td>
                                          <td class="text-right">@if ($sf > 0) {{number_format($sf,2)}} @else 0.00 @endif</td>
                                          
                                        </tr>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

@endsection

@section('footer_scripts')
    @if ((count($invoices) > config('usersmanagement.datatablesJsStartCount')) && config('usersmanagement.enabledDatatablesJs'))
        @include('scripts.datatables')
    @endif
    
    @if(config('orders.tooltipsEnabled'))
        @include('scripts.tooltips')
    @endif
    
@endsection
