@extends('layouts.app')

@section('template_title')
    View All Enrollees for {{$course->title}}
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
                                View All Enrollees for {{$course->title}}
                            </span>
						
                            
                        </div>
                    </div>

                    <div class="card-body">

                        
                        <div class="table-responsive enrollees-table">
                            <table class="table table-striped table-sm data-table">
                                <caption id="user_count">
                                    {{ $enrollees->count()}} Enrollee(s) Total
                                </caption>
                                <thead class="thead">
                                    <tr>
                                    	<th>ID</th>
                                        <th>User</th>
                                    	<th>Progress</th>                                      
                                        <th class="text-nowrap">Last Login</th>
                                        <th class="hidden-sm hidden-xs hidden-md" >Enrolled</th>
                                    </tr>
                                </thead>
                                <tbody id="users_table">
                                    @foreach($enrollees as $e) 
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
                                            
                                                <td> 
                                                    @if (isset($completed[$course->id][$e->user_id])) 
                                                        {{count($completed[$course->id][$e->user_id])}} 
                                                    @else 
                                                        0 
                                                    @endif

                                                    /{{$course->lessons->count()}}
                                                </td>
                                            
                                                <td data-sort="{{strtotime($e->created_at)}}" class="text-nowrap">
                                                    @if ($e->user->lastlogin) 
                                                        {{\Carbon\Carbon::createFromTimeStamp(strtotime($e->user->lastlogin))->diffForHumans()}} 
                                                    @else 
                                                        Never Logged In 
                                                    @endif
                                                </td>
                        
                                                <td data-sort="{{strtotime($e->created_at)}}" class="hidden-sm hidden-xs hidden-md text-nowrap">
                                                    {{ \Carbon\Carbon::parse($e->created_at)->format('j M Y') }} 
                                                    <br>
                                                    {{ \Carbon\Carbon::parse($e->created_at)->format('h:i:s A') }}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                                
                            </table>

                            {{-- @if(config('usersmanagement.enablePagination'))
                                {{ $enrollees->links() }}
                            @endif --}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

@endsection

@section('footer_scripts')
    @if ((count($enrollees) > config('usersmanagement.datatablesJsStartCount')) && config('usersmanagement.enabledDatatablesJs'))
        @include('scripts.datatables')
    @endif
    
    @if(config('orders.tooltipsEnabled'))
        @include('scripts.tooltips')
    @endif
    
@endsection
