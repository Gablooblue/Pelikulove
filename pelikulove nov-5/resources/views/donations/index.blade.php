@extends('layouts.app')

@section('template_title')
    View All Donations
@endsection

@section('template_linked_css')
    @if(config('usersmanagement.enabledDatatablesJs'))
        <link rel="stylesheet" type="text/css" href="{{ config('usersmanagement.datatablesCssCDN') }}">
    @endif
    <style type="text/css" media="screen">
        .donations-table {
            border: 0;
        }
        .donations-table tr td:first-child {
            padding-left: 15px;
        }
        .donations-table tr td:last-child {
            padding-right: 15px;
        }
        .donations-table.table-responsive,
        .donations-table.table-responsive table {
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
                                View All Donations
                            </span>
						
                            
                        </div>
                    </div>

                    <div class="card-body">

                        
                        <div class="table-responsive donations-table">
                            <table class="table table-striped table-sm data-table">
                                <caption id="user_count">
                                    {{ $donations->count()}} Donation(s) Total }}
                                </caption>
                                <thead class="thead">
                                    <tr>
                                    	<th class="text-nowrap">ID</th>
                                        <th class="text-nowrap">Username</th>
                                    	<th class="text-nowrap">Email</th>
                                        <th class="text-nowrap hidden-sm hidden-xs">Notes </th>                
                                    	<th class="text-nowrap">Amount</th>
                         				<th class="text-nowrap">Cause</th>
                         				<th class="text-nowrap hidden-xs">Payment Method</th>  
                                        <th class="text-nowrap no-search no-sort"></th>           
                                    </tr>
                                </thead>
                                <tbody id="users_table">
                                    @foreach($donations as $donation) 
                                        <tr>
                                            <td>
                                                {{$donation->id}}
                                            </td>
                                            <td>                                                
                                                <span class="" data-toggle="tooltip" title="Name: {{$donation->username}} &#013;&#010; First Name: {{$donation->first_name}} &#013;&#010; Last Name: {{$donation->last_name}} &#013;&#010; Email: {{$donation->email}}">
                                                    {{$donation->username}}
                                                </span>
                                            </td>
                                            <td class="">
                                                {{$donation->email}}
                                            </td>
                                            <td class="hidden-sm hidden-xs">
                                                {{ \Illuminate\Support\Str::limit($donation->notes, 30, $end='...') }}
                                            </td>
                                            <td>
                                                ₱{{$donation->amount}}
                                            </td>
                                            <td class="">
                                                @php
                                                    if (isset($donation->cause_id)) {
                                                        $cause_title = \App\Models\DonationCause::find($donation->cause_id)->title;
                                                    } else {
                                                        $cause_title = "None";
                                                    }
                                                @endphp
                                                {{$cause_title}}
                                            </td>
                                            <td class="hidden-xs">
                                                {{$donation->p_name}}
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-success btn-block" href="{{ route('donations.show', $donation->id) }}" 
                                                    data-toggle="tooltip" title="Show">
                                                    Show
                                                </a>
                                            </td>
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
    {{-- @if ((count($donations) > config('usersmanagement.datatablesJsStartCount')) && config('usersmanagement.enabledDatatablesJs')) --}}
        @include('scripts.datatables')
    {{-- @endif --}}
    
    {{-- @if(config('orders.tooltipsEnabled')) --}}
        @include('scripts.tooltips')
    {{-- @endif --}}
    
@endsection
