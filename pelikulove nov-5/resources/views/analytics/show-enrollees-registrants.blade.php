@extends('layouts.app')

@section('template_title')
    Registrants and Enrollees Stats
@endsection

@section('template_linked_css')
    <link rel="stylesheet" type="text/css" href="{{ config('usersmanagement.datatablesCssCDN') }}">
    <style type="text/css" media="screen">
        .analytics-table {
            border: 0;
            white-space: nowrap;
        }
        .analytics-table tr td:first-child {
            padding-left: 15px;
        }
        .analytics-table tr td:last-child {
            padding-right: 15px;
        }
        .analytics-table.table-responsive,
        .analytics-table.table-responsive table {
            margin-bottom: 0;
        }     
        .tooltip-inner {
            text-align: left;
            white-space: pre-line;
        }     
        .table-hoverable:hover {
            border: 2px solid #444 !important;
            text-decoration: underline;  
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card p-3">
                    <div class="card-header">
                        <div class="div-title" style="display: flex; justify-content: space-between; align-items: center;">
                            <h2>
                                Registrants and Enrollees Stats
                            </h2>
                            <div class="pull-right">
                                <a href="{{ route('analytics.vod') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="Back to Blackbox Analytics">
                                    <i class="fa fa-fw fa-reply" aria-hidden="true"></i>
                                    <span class="hidden-sm hidden-xs">Back to </span>
                                    <span class="hidden-xs">Blackbox Analytics</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <hr>

                    {{-- Top Viewed Videos Start --}}
                    <div class="row mx-1 mb-2 justify-content-center">

                        {{-- Total Views Start --}}
                        <div class="card bg-white rounded mx-2 my-2">
                            <div class="card-header pt-3">
                                <h3 class="text-center">
                                    {{-- <strong> --}}
                                        Total Registrants
                                    {{-- </strong> --}}
                                </h3>
                            </div>
                            <hr class="mt-n2 mb-2">
                            <div class="card-body">
                                <div class="row justify-content-center mx-1 my-1">
                                    <h3 class="">
                                        {{ $totalStats->usersCount }}
                                    </h3>
                                </div>
                                <hr class="ml-2 mr-2">
                            </div>
                        </div>
                        {{-- Total Views End --}}

                        {{-- Total Views Start --}}
                        <div class="card bg-white rounded mx-2 my-2">
                            <div class="card-header pt-3">
                                <h3 class="text-center">
                                    {{-- <strong> --}}
                                        Ricky Lee Registrants
                                    {{-- </strong> --}}
                                </h3>
                            </div>
                            <hr class="mt-n2 mb-2">
                            <div class="card-body">
                                <div class="row justify-content-center mx-1 my-1">
                                    <h3 class="">
                                        {{ $rlUsers->count() }}
                                    </h3>
                                </div>
                                <hr class="ml-2 mr-2">
                            </div>
                        </div>
                        {{-- Total Views End --}}

                        {{-- Guest Users Start --}}
                        <div class="card bg-white rounded mx-2 my-2">
                            <div class="card-header pt-3">
                                <h3 class="text-center">
                                    {{-- <strong> --}}
                                        Lifetime No. of Enrollees
                                    {{-- </strong> --}}
                                </h3>
                            </div>
                            <hr class="mt-n2 mb-2">
                            <div class="card-body">
                                <div class="row justify-content-center mx-1 my-1">
                                    <h3 class="">
                                        {{ $totalStats->enrolleesCount }}
                                    </h3>
                                </div>
                                <hr class="ml-2 mr-2">
                            </div>
                        </div>
                        {{-- Guest Users End --}}

                        {{-- Guest Users Start --}}
                        <div class="card bg-white rounded mx-2 my-2">
                            <div class="card-header pt-3">
                                <h3 class="text-center">
                                    {{-- <strong> --}}
                                        Current No. of Enrollees
                                    {{-- </strong> --}}
                                </h3>
                            </div>
                            <hr class="mt-n2 mb-2">
                            <div class="card-body">
                                <div class="row justify-content-center mx-1 my-1">
                                    <h3 class="">
                                        {{ $totalStats->activeEnrolleesCount }}
                                    </h3>
                                </div>
                                <hr class="ml-2 mr-2">
                            </div>
                        </div>
                        {{-- Guest Users End --}}

                        {{-- Guest Users Start --}}
                        <div class="card bg-white rounded mx-2 my-2">
                            <div class="card-header pt-3">
                                <h3 class="text-center">
                                    {{-- <strong> --}}
                                        Total Paid Enrollees
                                    {{-- </strong> --}}
                                </h3>
                            </div>
                            <hr class="mt-n2 mb-2">
                            <div class="card-body">
                                <div class="row justify-content-center mx-1 my-1">
                                    <h3 class="">
                                        {{ $totalStats->paidEnrolleesCount }}
                                    </h3>
                                </div>
                                <hr class="ml-2 mr-2">
                            </div>
                        </div>
                        {{-- Guest Users End --}}
                    </div>
                    
                    {{-- Viewing Log Table Start --}}
                    <div class="card bg-white shadow rounded mx-2 my-1">
                        {{-- <div class="card-header bg-white rounded py-3">
                            <h2 class="text-center">
                                <span class="badge badge-info" style="font-size: 100%;">
                                    Viewing Log Table
                                </span>
                            </h2>
                        </div>        
                        <hr class="my-0"> --}}
                        <div class="card-body">   
                            {!! Form::open(array('route' => 'analytics.users', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}
                                {!! csrf_field() !!}
                                <div class="row justify-content-between mt-3 mx-5">
                                    <div class="mt-2">
                                        Showing stats from: 
                                    </div>
                                    
                                    @if (isset($startDate) && isset($endDate))
                                        <div>
                                            {!! Form::input('date', 'start_date', Carbon\Carbon::parse($startDate)->format('Y-m-d'), array('id' => 'start_date', 'class' => 'form-control')) !!}
                                        </div>

                                        <div>
                                            {!! Form::input('date', 'end_date', Carbon\Carbon::parse($endDate)->format('Y-m-d'), array('id' => 'end_date', 'class' => 'form-control')) !!}
                                        </div>
                                    @else
                                        <div>
                                            {!! Form::input('date', 'start_date', Carbon\Carbon::parse($allUserStatsByDate->dates->first())->format('Y-m-d'), array('id' => 'start_date', 'class' => 'form-control')) !!}
                                        </div>

                                        <div>
                                            {!! Form::input('date', 'end_date', Carbon\Carbon::now()->format('Y-m-d'), array('id' => 'end_date', 'class' => 'form-control')) !!}
                                        </div>
                                    @endif
                                    
                                    <div class="row justify-content-end">                                
                                        {!! Form::button('Apply', array('class' => 'btn btn-success btn-submit margin-bottom-1 mt-1 mb-1 mr-3','type' => 'submit' )) !!}  
                                    </div>
                                </div>

                            {!! Form::close() !!}
                            <hr>                   

                            <div class="table-responsive analytics-table">
                                <table class="table table-striped table-sm data-table">
                                    <caption id="user_count">
                                        {{$allUserStatsByDate->dates->count()}} Days Total
                                    </caption>
                                    <thead class="thead">
                                        <tr>
                                            <th class="text-nowrap">Date</th>
                                            <th class="text-nowrap">Verbose Date</th>
                                            <th class="text-nowrap">Total Registrants</th>    
                                            <th class="text-nowrap">Direct Registrants</th>    
                                            <th class="text-nowrap">Manual Registrants</th> 
                                            <th class="text-nowrap">Ricky Lee Registrants</th>   
                                            <th class="text-nowrap">Total Enrollees</th>   
                                            <th class="text-nowrap">Paid Enrollees</th>   
                                            <th class="text-nowrap">Free Enrollees</th>      
                                        </tr>
                                    </thead>
                                    <tbody id="analytics_table">
                                        @foreach($allUserStatsByDate->dates as $vod)
                                            <tr class="table-hoverable">
                                                <td>{{ $allUserStatsByDate->dates[$loop->index] }}</td>
                                                <td>{{ \Carbon\Carbon::parse($allUserStatsByDate->dates[$loop->index])->isoFormat('MMMM D, YYYY - dddd') }}</td>
                                                <td>{{ $allUserStatsByDate->totalRegistrants[$loop->index] }}</td>
                                                <td>{{ $allUserStatsByDate->websiteRegistrants[$loop->index] }}</td>
                                                <td>{{ $allUserStatsByDate->adminRegistrants[$loop->index] }}</td>

                                                @php
                                                    $rlUsers = collect();
                                                    $rlUsers = \App\Models\RegisterLog::where('created_at', 'LIKE', $allUserStatsByDate->dates[$loop->index] . '%');
                                                @endphp

                                                <td>{{ $rlUsers->count() }}</td>

                                                <td>{{ $allUserStatsByDate->totalEnrollees[$loop->index] }}</td>
                                                <td>{{ $allUserStatsByDate->paidEnrollees[$loop->index] }}</td>
                                                <td>{{ $allUserStatsByDate->freeEnrollees[$loop->index] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                    <tbody id="search_results"></tbody>

                                </table>

                            </div>
                        </div>
                    </div>                    
                    {{-- Viewing Log Table End --}}
                    
                    {{-- Line Graph Start --}}
                    <div class="card bg-white shadow rounded mx-2 my-1">
                        <div class="card-body bg-white rounded m-1 p-1">  
                            <div class="container">
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                    </div>
                    {{-- Line Graph End --}}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer_scripts')
    @include('scripts.datatables')
    @include('scripts.tooltips')
    {{-- @include('scripts.search-users') --}}
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        
            $('.listCollapsible').click(function (e) {
                var target = e.target;
                var targetValue = target.getAttribute("value");
                var targetID = target.getAttribute("id");
                // console.log(targetID);           

                if (targetID == (targetValue +"Start")) {
                    console.log("on");            
                    $('#' + targetValue + 'Start').css("display", "none");  
                    $('#' + targetValue + 'End').css("display", "flex");  
                } else if (targetID == (targetValue + "End")) {
                    console.log("off");            
                    $('#' + targetValue + 'Start').css("display", "flex");  
                    $('#' + targetValue + 'End').css("display", "none");  
                }    
            })

            var table = $('.data-table').DataTable();

            table.order( [ 0, 'desc' ] ).page.len(25).draw();
        });   
        
        $("#reply-spinner").on('click', function(e) {
            $("#reply-spinner").css("display", "inline-block");
        });
    </script>
    @include('scripts.analytics-registrants-enrollees-graph')
@endsection
