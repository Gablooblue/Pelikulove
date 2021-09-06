@extends('layouts.app')

@section('template_title')
    View All VOD Purchases
@endsection

@section('template_linked_css')
    @if(config('usersmanagement.enabledDatatablesJs'))
        <link rel="stylesheet" type="text/css" href="{{ config('usersmanagement.datatablesCssCDN') }}">
    @endif
    <style type="text/css" media="screen">
        .enrollees-table {
            border: 0;
        }
        .enrollees-table tr td:first-child {
            padding-left: 15px;
        }
        .enrollees-table tr td:last-child {
            padding-right: 15px;
        }
        .enrollees-table.table-responsive,
        .enrollees-table.table-responsive table {
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
                                View All VOD Purchases
                            </span>
						
                            
                        </div>
                    </div>

                    <div class="card-body">

                        
                        <div class="table-responsive enrollees-table">
                            <table class="table table-striped table-sm data-table">
                                <caption id="user_count">
                                    {{ $vodPurchases->count()}} VOD Purchase(s) Total, {{ $vodPurchases->where('status', 1)->count()}} Active, {{ $vodPurchases->where('status', 0)->count()}} InActive
                                </caption>
                                <thead class="thead">
                                    <tr>
                                    	<th>ID</th>
                                        <th>User</th>
                                    	<th>VOD</th>
                         				<th>Currently Owned</th>
                         				<th>Order#</th>
                         				<th>Payment </th>
                                        <th>Amount</th>
                                        <th class="text-nowrap">Last Login</th>
                                        <th class="hidden-sm hidden-xs hidden-md" >Purchased</th>
                                        <th>Expiration</th>
                                       
                                        <th class="text-nowrap no-search no-sort">Actions</th>
                                		<th class="no-search no-sort"></th>
                                      
                                    </tr>
                                </thead>
                                <tbody id="users_table">
                                    @foreach($vodPurchases as $e) 
                                        @if ($e->user_id != 0)
                                            <tr>
                                                <td>
                                                    {{$e->id}}
                                                </td>
                                                
                                                <td>
                                                    <a href="mailto:{{ $e->user->email }}" title="email {{ $e->user->email }}">
                                                        {{ $e->user->email }}
                                                    </a> 
                                                    <br>
                                                    {{$e->user->first_name}} {{$e->user->last_name}}
                                                </td>
                                                
                                                @php 
                                                    $order = \App\Models\Order::find($e->order_id); 
                                                    $service = \App\Models\Service::find($order['service_id']); 
                                                @endphp 
                                                
                                                <td class="text-nowrap">
                                                    {{$e->vod->short_title}} 
                                                    <br>
                                                    <span class="small">
                                                        {{$service['name']}}
                                                    </span>                                                                                                
                                                </td>
                                                
                                                <td>
                                                    @if ($e->status == 1) 
                                                        <span class="text-success">Yes</span> 
                                                    @else 
                                                        <span class="text-danger">No</span> 
                                                    @endif
                                                </td>

                                                <td> 
                                                    {{$e->order_id}}
                                                </td>

                                                <td> 
                                                    @if ($order['payment_id'] == 1)
                                                        @php $badgeClass = 'danger' @endphp
                                                    @elseif ($order['payment_id'] == 2)
                                                        @php $badgeClass = 'warning' @endphp
                                                    @elseif ($order['payment_id'] == 3)
                                                        @php $badgeClass = 'success' @endphp
                                                    @elseif ($order['payment_id'] == 4)
                                                        @php $badgeClass = 'primary' @endphp
                                                    @else
                                                    @php $badgeClass = 'secondary' @endphp
                                                    @endif

                                                    <span class="badge badge-{{$badgeClass}}"> 
                                                        @php 
                                                            $p = \App\Models\PaymentMethod::find($order['payment_id']); 
                                                        @endphp 
                                                        {{$p['name']}}
                                                    </span> 
                                                </td>

                                                <td>{{number_format($order['amount'],2)}}</td>
                                                <td data-sort="{{strtotime($e->created_at)}}" class="text-nowrap">@if ($e->user->lastlogin) {{\Carbon\Carbon::createFromTimeStamp(strtotime($e->user->lastlogin))->diffForHumans()}} @else Never Logged In @endif</td>
                                                
                                                <td data-sort="{{strtotime($e->created_at)}}" class="hidden-sm hidden-xs hidden-md text-nowrap">{{ \Carbon\Carbon::parse($e->created_at)->format('j M Y') }} <br>{{ \Carbon\Carbon::parse($e->created_at)->format('h:i:s A') }}</td>
                                                <td data-sort="{{strtotime($e->created_at . ' +'.$service['duration'].' days')}}" class="hidden-sm hidden-xs hidden-md text-nowrap">{{ \Carbon\Carbon::parse($e->created_at)->addDays($service['duration'])->format('j M Y') }} <br>{{ \Carbon\Carbon::parse($e->created_at)->addDays($service['duration'])->format('h:i:s A') }}</td>
                                                
                                                <td>
                                                    <a class="btn btn-sm btn-success btn-block text-nowrap" href="{{ URL::to('users/' . $e->user_id) }}" data-toggle="tooltip" title="Show">
                                                        <i class="fa fa-eye"></i> Show User
                                                    </a>
                                                </td>
                                                
                                                <td>
                                                    <a class="btn btn-sm btn-info btn-block text-nowrap" href="{{url('/order/'.$e->order_id.'/edit')}}" data-toggle="tooltip" title="Show Order">
                                                        <i class="fa fa-eye"></i> Show Order
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                                
                            </table>

                            
                            @if (\App\Models\LearnerCourse::all()->count() > 500)                            
                                <div class="mt-3 row justify-content-center">
                                    <div>
                                        <h5 class="text-center">
                                            Showing 500 per table
                                        </h5>
                                        <div class="mt-2 row justify-content-center">
                                            {{ $vodPurchases->links() }}
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

@endsection

@section('footer_scripts')
    {{-- @if ((count($vodPurchases) > config('usersmanagement.datatablesJsStartCount')) && config('usersmanagement.enabledDatatablesJs')) --}}
        @include('scripts.datatables')
    {{-- @endif --}}
    
    {{-- @if(config('orders.tooltipsEnabled')) --}}
        @include('scripts.tooltips')
    {{-- @endif --}}
    
@endsection
