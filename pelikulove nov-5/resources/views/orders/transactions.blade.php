@extends('layouts.app')

@section('template_title')
    View All Order Transactions
@endsection

@section('template_linked_css')
    @if(config('usersmanagement.enabledDatatablesJs'))
        <link rel="stylesheet" type="text/css" href="{{ config('usersmanagement.datatablesCssCDN') }}">
    @endif
    <style type="text/css" media="screen">
        .transactions-table {
            border: 0;
        }
        .transactions-table tr td:first-child {
            padding-left: 15px;
        }
        .transactions-table tr td:last-child {
            padding-right: 15px;
        }
        .transactions-table.table-responsive,
        .transactions-table.table-responsive table {
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
                                View All Transactions for Order # {{$order->id}}
                            </span>
							
                            <div class="btn-group pull-right btn-group-xs ">
                            	
                            	<a href="{{url('/order/'.$order->id.'/edit')}}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="top" title="{{ trans('orders.tooltips.back-orders') }}">
                                    <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                                    Back to  Order # {{$order->id}}
                                </a>
                                
                            </div>
                            
                        </div>
                    </div>

                    <div class="card-body">

                        
                        <div class="table-responsive transactions-table">
                            <table class="table table-striped table-sm data-table">
                                <caption id="user_count">
                                    {{ $transactions->count()}} Transactions(s) Total
                                </caption>
                                <thead class="thead">
                                    <tr>
                                    	<th>Transaction ID</th>
                                        <th>Ref No</th>
                                    
                         				 <th>Amount</th>
                         				 <th>Status</th>
                         				 <th>Message</th>
                         				 <th>IP Addr</th>
                                        
                                        <th>Date</th>
                                	
                                      
                                    </tr>
                                </thead>
                                <tbody id="users_table">
                                    @foreach($transactions as $t)
                                        <tr>
                                           <td>{{$t->txnid}}</td>
                                           <td>{{$t->refno}}</td>
                                       
                                            <td>{{$t->amount}}</td>
                                         	<td>{{$t->status}}</td>
                                           <td> {{$t->message}}</td>
                                           <td> {{$t->ip_addr}}</td>
                                            
                                            <td data-sort="{{strtotime($t->created_at)}}" class="hidden-sm hidden-xs hidden-md text-nowrap">{{ \Carbon\Carbon::parse($t->created_at)->format('j M Y') }} <br>{{ \Carbon\Carbon::parse($t->created_at)->format('h:i:s A') }}</td>
                                             
                                            
                                           
                                        </tr>
                                    @endforeach
                                </tbody>
                                
                            </table>

                            {{-- @if(config('usersmanagement.enablePagination'))
                                {{ $transactions->links() }}
                            @endif --}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

@endsection

@section('footer_scripts')
    @if ((count($transactions) > config('usersmanagement.datatablesJsStartCount')) && config('usersmanagement.enabledDatatablesJs'))
        @include('scripts.datatables')
    @endif
    
    @if(config('orders.tooltipsEnabled'))
        @include('scripts.tooltips')
    @endif
    
@endsection
