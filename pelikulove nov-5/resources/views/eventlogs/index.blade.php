@extends('layouts.app')

@section('template_title')
    Showing all Comments
@endsection

@section('template_linked_css')
    <link rel="stylesheet" type="text/css" href="{{ config('usersmanagement.datatablesCssCDN') }}">
    <style type="text/css" media="screen">
        .users-table {
            border: 0;
            white-space: nowrap;
        }
        .users-table tr td:first-child {
            padding-left: 15px;
        }
        .users-table tr td:last-child {
            padding-right: 15px;
        }
        .users-table.table-responsive,
        .users-table.table-responsive table {
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
                                Showing all Comments
                            </span>

                            {{-- <div class="btn-group pull-right btn-group-xs">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                                    <span class="sr-only">
                                        {!! trans('usersmanagement.users-menu-alt') !!}
                                    </span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="/users/create">
                                        <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                                        {!! trans('usersmanagement.buttons.create-new') !!}
                                    </a>
                                    <a class="dropdown-item" href="/users/deleted">
                                        <i class="fa fa-fw fa-group" aria-hidden="true"></i>
                                        {!! trans('usersmanagement.show-deleted-users') !!}
                                    </a>
                                </div>
                            </div> --}}
                        </div>
                    </div>

                    <div class="card-body">                       

                        <div class="table-responsive users-table">
                            <table class="table table-striped table-sm data-table">
                                <caption id="user_count">
                                    {{ $eventlogs->count() }} total comment(s)
                                </caption>
                                <thead class="thead">
                                    <tr>
                                        <th class="text-nowrap">{!! trans('usersmanagement.users-table.id') !!}</th>
                                        <th class="text-nowrap">{!! trans('usersmanagement.users-table.name') !!}</th>
                                        <th class="text-nowrap">{!! trans('usersmanagement.users-table.email') !!}</th>
                                        <th class="text-nowrap">{!! trans('usersmanagement.users-table.fname') !!}</th>
                                        <th class="text-nowrap">{!! trans('usersmanagement.users-table.lname') !!}</th>

                                        <th class="text-nowrap">Mobile Number</th>
                                        <th class="text-nowrap">Gender</th>
                                        <th class="text-nowrap">Birthday</th>
                                        <th class="text-nowrap">Profession</th>
                                        <th class="text-nowrap">Interests</th>
                                        <th class="text-nowrap">Referer</th>
                                        <th class="text-nowrap">Comments/Suggestion</th>

                                        <th class="hidden-sm hidden-xs hidden-md text-nowrap">{!! trans('usersmanagement.users-table.created') !!}</th>
                                        <th class="hidden-sm hidden-xs hidden-md text-nowrap">{!! trans('usersmanagement.users-table.updated') !!}</th>   

                                        <th class="text-nowrap no-search no-sort">Actions</th>
                                                                                
                                    </tr>
                                </thead>
                                <tbody id="users_table">
                                    @foreach($eventlogs as $eventlog)
                                        <tr>
                                            <td>{{$eventlog->id}} </td>
                                            <td>{{$eventlog->name}}  </td>
                                            <td class="hidden-xs"><a href="mailto:{{ $eventlog->email }}" title="email {{ $eventlog->email }}">{{ $eventlog->email }}</a> <br>@if (isset($eventlog->enrolledcourses))<span class="badge badge-success">Enrolled</span>@endif </td>
                                            <td class="hidden-xs">{{$eventlog->first_name}}</td>
                                            <td class="hidden-xs">{{$eventlog->last_name}}</td>

                                            <td class="hidden-xs">{{$eventlog->mobile_number}}</td>
                                            <td class="hidden-xs">{{$eventlog->gender}}</td>
                                            <td class="hidden-xs">{{$eventlog->birthday}}</td>
                                            <td class="hidden-xs">{{$eventlog->profession}}</td>
                                            <td class="hidden-xs">{{$eventlog->interests}}</td>
                                            <td class="hidden-xs">{{ \Illuminate\Support\Str::limit($eventlog->referer, 30, $end='...') }}</td>              		
                                            <td class="hidden-xs">{{ \Illuminate\Support\Str::limit($eventlog->comment, 30, $end='...') }}</td>

                                            <td class="hidden-sm hidden-xs hidden-md text-nowrap">{{ \Carbon\Carbon::parse($eventlog->created_at)->format('Y-m-d') }} <br>{{ \Carbon\Carbon::parse($eventlog->created_at)->format('h:i:s A') }}</td>
                                            <td class="hidden-sm hidden-xs hidden-md text-nowrap">{{ \Carbon\Carbon::parse($eventlog->updated_at)->format('Y-m-d') }} <br>{{ \Carbon\Carbon::parse($eventlog->updated_at)->format('h:i:s A') }}</td>
                                            
                                            <td>
                                                <a class="btn btn-sm btn-success btn-block" href="{{ url('eventlogs/' . $eventlog->log_id) }}" data-toggle="tooltip" title="Show">
                                                    <i class="fa fa-eye fa-fw" aria-hidden="true"></i> 
                                                    <span class="hidden-xs hidden-sm">Show</span>
                                                    <span class="hidden-xs hidden-sm hidden-md"> Event Log</span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                                <tbody id="search_results"></tbody>

                            </table>

                        </div>

                        <hr>

                        {{-- @if(config('usersmanagement.enablePagination')) --}}
                            {{-- <div class="mt-3 row justify-content-center">
                                <div>
                                    <h5 class="text-center">
                                        Showing {{ config('usersmanagement.paginateListSize') }} per table
                                    </h5>
                                    <div class="mt-2 row justify-content-center">
                                        {{ $users->links() }}
                                    </div>
                                </div>
                            </div> --}}
                        {{-- @endif --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer_scripts')
    @include('scripts.datatables')
    @include('scripts.tooltips')
@endsection
