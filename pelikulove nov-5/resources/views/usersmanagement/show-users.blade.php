@extends('layouts.app')

@section('template_title')
    {!! trans('usersmanagement.showing-all-users') !!}
@endsection

@section('template_linked_css')
    @if(config('usersmanagement.enabledDatatablesJs'))
          <link rel="stylesheet" type="text/css" href="{{ config('usersmanagement.datatablesCssCDN') }}">
	@endif
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
                                {!! trans('usersmanagement.showing-all-users') !!}
                            </span>

                            <div class="btn-group pull-right btn-group-xs">
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
                            </div>
                        </div>
                    </div>

                    <div class="card-body">                       

                        <div class="table-responsive users-table">
                            <table class="table table-striped table-sm data-table">
                                <caption id="user_count">
                                    {{ trans_choice('usersmanagement.users-table.caption', 1, ['userscount' => $users->count()]) }}
                                </caption>
                                <thead class="thead">
                                    <tr>
                                        <th class="text-nowrap">{!! trans('usersmanagement.users-table.id') !!}</th>
                                        <th class="text-nowrap">{!! trans('usersmanagement.users-table.name') !!}</th>
                                        <th class="text-nowrap hidden-xs">{!! trans('usersmanagement.users-table.email') !!}</th>
                                        <th class="text-nowrap hidden-xs">{!! trans('usersmanagement.users-table.fname') !!}</th>
                                        <th class="text-nowrap hidden-xs">{!! trans('usersmanagement.users-table.lname') !!}</th>
                                        <th class="text-nowrap">Courses</th>
                                        <th class="text-nowrap">{!! trans('usersmanagement.users-table.role') !!}</th>
                                        <th class="hidden-sm hidden-xs hidden-md text-nowrap">Last Login</th>
                                        <th class="hidden-sm hidden-xs hidden-md text-nowrap">{!! trans('usersmanagement.users-table.created') !!}</th>
                                        <th class="hidden-sm hidden-xs hidden-md text-nowrap">{!! trans('usersmanagement.users-table.updated') !!}</th>
                                        <th class="text-nowrap">{!! trans('usersmanagement.users-table.actions') !!}</th>
                                        <th class="no-search no-sort"></th>
                                        @permission('delete.users')<th class="no-search no-sort"></th>@endpermission
                                        <th class="no-search no-sort"></th>
                                    </tr>
                                </thead>
                                <tbody id="users_table">
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{$user->id}} </td>
                                            <td>{{$user->name}}  </td>
                                            <td class="hidden-xs"><a href="mailto:{{ $user->email }}" title="email {{ $user->email }}">{{ $user->email }}</a> <br>@if (count($user->enrolledcourses) > 0)<span class="badge badge-success">Enrolled</span>@endif </td>
                                            <td class="hidden-xs">{{$user->first_name}}</td>
                                            <td class="hidden-xs">{{$user->last_name}}</td>
                                            <td>
                                                @foreach ($user->enrolledcourses as $c)
                                                    {{$c->course->short_title}}<br>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($user->roles as $user_role)
                                                   @if ($user_role->name == 'Student')
                                                        @php $badgeClass = 'primary' @endphp
                                                    @elseif ($user_role->name == 'Admin' || $user_role->name == 'Moderator' )
                                                        @php $badgeClass = 'info' @endphp
                                                    @elseif ($user_role->name == 'Mentor')
                                                    	@php $badgeClass = 'success' @endphp
                                                    @elseif ($user_role->name == 'Unverified')
                                                        @php $badgeClass = 'danger' @endphp
                                                    @else
                                                        @php $badgeClass = 'default' @endphp
                                                    @endif
                                                    <span class="badge badge-{{$badgeClass}}">{{ $user_role->name }}</span> 
                                                @endforeach
                                            </td>
                                            <td class="text-nowrap">
                                                @if ($user->lastlogin) 
                                                    {{ \Carbon\Carbon::parse($user->lastlogin)->format('Y-m-d h:i A') }}
                                                    <br>
                                                    {{\Carbon\Carbon::createFromTimeStamp(strtotime($user->lastlogin))->diffForHumans()}} 
                                                @else 
                                                    Never Logged In 
                                                @endif
                                            </td>
              		
                                            <td class="hidden-sm hidden-xs hidden-md text-nowrap">{{ \Carbon\Carbon::parse($user->created_at)->format('Y-m-d') }} <br>{{ \Carbon\Carbon::parse($user->created_at)->format('h:i:s A') }}</td>
                                            <td class="hidden-sm hidden-xs hidden-md text-nowrap">{{ \Carbon\Carbon::parse($user->updated_at)->format('Y-m-d') }} <br>{{ \Carbon\Carbon::parse($user->updated_at)->format('h:i:s A') }}</td>
                                            <td>
                                              <a class="btn btn-sm btn-success btn-block" href="{{ URL::to('order/create/' . $user->id) }}" data-toggle="tooltip" title="Enroll">
                                                  <i class="fas fa-user-plus"></i> Enroll
                                                </a>
                                            </td>
                                            
                                            @permission('delete.users') 
   												<td>
                                                {!! Form::open(array('url' => 'users/' . $user->id, 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Delete')) !!}
                                                    {!! Form::hidden('_method', 'DELETE') !!}
                                                    {!! Form::button(trans('usersmanagement.buttons.delete'), array('class' => 'btn btn-danger btn-sm','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete User', 'data-message' => 'Are you sure you want to delete this user ?')) !!}
                                                {!! Form::close() !!}
                                            	</td>
                                            @endpermission
												
                                            <td>
                                                <a class="btn btn-sm btn-success btn-block" href="{{ URL::to('users/' . $user->id) }}" data-toggle="tooltip" title="Show">
                                                    {!! trans('usersmanagement.buttons.show') !!}
                                                </a>
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-info btn-block" href="{{ URL::to('users/' . $user->id . '/edit') }}" data-toggle="tooltip" title="Edit">
                                                    {!! trans('usersmanagement.buttons.edit') !!}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tbody id="search_results"></tbody>
                                @if(config('usersmanagement.enableSearchUsers'))
                                    <tbody id="search_results"></tbody>
                                @endif

                            </table>

                        </div>

                        <hr>

                        {{-- @if(config('usersmanagement.enablePagination')) --}}
                            <div class="mt-3 row justify-content-center">
                                <div>
                                    <h5 class="text-center">
                                        Showing {{ config('usersmanagement.paginateListSize') }} per table
                                    </h5>
                                    <div class="mt-2 row justify-content-center">
                                        {{ $users->links() }}
                                    </div>
                                </div>
                            </div>
                        {{-- @endif --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('modals.modal-delete')

@endsection

@section('footer_scripts')
    @if ((count($users) > config('usersmanagement.datatablesJsStartCount')) && config('usersmanagement.enabledDatatablesJs'))
        @include('scripts.datatables')
    @endif
    @include('scripts.delete-modal-script')
    @include('scripts.save-modal-script')
    @if(config('usersmanagement.tooltipsEnabled'))
        @include('scripts.tooltips')
    @endif
    @if(config('usersmanagement.enableSearchUsers'))
        @include('scripts.search-users')
    @endif
@endsection
