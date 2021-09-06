@extends('layouts.app')

@section('template_title')
    All Active User Stats
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
                                All Active User Stats
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

                    {{-- Date Range Start --}}
                    {{-- <div class="card bg-white shadow rounded mx-2 my-1">
                        <div class="card-body">   
                            {!! Form::open(array('route' => 'analytics.vod.showAllUserStats', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}
                                {!! csrf_field() !!}
                                <div class="row justify-content-between mx-2">
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
                                            {!! Form::input('date', 'start_date', Carbon\Carbon::parse($firstVodView->created_at)->format('Y-m-d'), array('id' => 'start_date', 'class' => 'form-control')) !!}
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
                        </div>
                    </div> --}}
                    {{-- Date Range End --}}

                    {{-- Viewing Log Table --}}
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

                            <div class="table-responsive analytics-table">
                                <table class="table table-striped table-sm data-table">
                                    <caption id="user_count">
                                        {{$allUserStats->count()}} User(s) Total
                                    </caption>
                                    <thead class="thead">
                                        <tr>
                                            <th class="text-nowrap">User ID</th>
                                            <th class="text-nowrap">Username</th>
                                            <th class="text-nowrap hidden-sm hidden-xs">First Name</th>
                                            <th class="text-nowrap hidden-sm hidden-xs">Last Name</th>
                                            <th class="text-nowrap hidden-sm hidden-xs hidden-md">Email</th>
                                            <th class="text-nowrap">Total Views</th>     
                                            {{-- <th class="text-nowrap">Finishes</th>              --}}
                                        </tr>
                                    </thead>
                                    <tbody id="analytics_table">
                                        @foreach($allUserStats->sortByDesc('views') as $user)
                                            <tr class="table-hoverable">
                                                <td>{{ $user->id }}</td>       	
                                                <td>{{ $user->name }}</td>       	 		                                 
                                                <td class="text-nowrap hidden-sm hidden-xs">{{ $user->first_name }}</td>
                                                <td class="text-nowrap hidden-sm hidden-xs">{{ $user->last_name }}</td>
                                                <td class="text-nowrap hidden-sm hidden-xs hidden-md">{{ $user->email }}</td>
                                                <td>{{ $user->views }}</td>       	 		                          
                                                {{-- <td>{{ $user->videoFinishes }}</td>       	 		                                       --}}
                                            </tr>
                                        @endforeach
                                    </tbody>

                                    <tbody id="search_results"></tbody>

                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer_scripts')
    @include('scripts.datatables')
    @include('scripts.tooltips')
    <script>

        $(document).ready(function(){ 
            // document.getElementsByName("DataTables_Table_0_length").value = '25';            
    
            // $('.data-table').dataTable({
            //     "order": [ 5, 'asc' ],
            // });
            
            var table = $('.data-table').DataTable()

            table
                .order( [ 5, 'desc' ] )
                .page
                    .len(25)
                .draw();
        });

    </script>
@endsection
