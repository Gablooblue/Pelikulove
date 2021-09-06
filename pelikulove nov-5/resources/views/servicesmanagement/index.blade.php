@extends('layouts.app')

@section('template_title')
    Showing all Services
@endsection

@section('template_linked_css')
    {{-- @if(config('usersmanagement.enabledDatatablesJs')) --}}
          <link rel="stylesheet" type="text/css" href="{{ config('usersmanagement.datatablesCssCDN') }}">
	{{-- @endif --}}
    <style type="text/css" media="screen">
        .services-table {
            border: 0;
            white-space: nowrap;
        }
        .services-table tr td:first-child {
            padding-left: 15px;
        }
        .services-table tr td:last-child {
            padding-right: 15px;
        }
        .services-table.table-responsive,
        .services-table.table-responsive table {
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
                        @if(!empty($success))
                            <div class="alert alert-success alert-dismissible">
                                <h1>{{Session::get('success')}}</h1>
                            </div>
                        @endif

                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                Showing All Services
                            </span>

                            <div class="btn-group pull-right btn-group-xs">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                                    <span class="sr-only">
                                        Show Services Management Menu
                                    </span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="/services/create">
                                        <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                                        Create New Service
                                    </a>
                                    {{-- <a class="dropdown-item" href="#">
                                        <i class="fa fa-fw fa-group" aria-hidden="true"></i>
                                       Show Deleted Services
                                    </a> --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">                       

                        <div class="table-responsive services-table">
                            <table class="table table-striped table-sm data-table">
                                <caption id="user_count">
                                    {{$services->count()}} Service(s) Total
                                </caption>
                                <thead class="thead">
                                    <tr>
                                        <th class="text-nowrap">ID</th>
                                        <th class="text-nowrap">Course Name</th>
                                        <th class="text-nowrap">Service Name</th>
                                        <th class="text-nowrap hidden-sm hidden-xs ">Description</th>
                                        <th class="text-nowrap">Status</th>
                                        <th class="text-nowrap">Duration</th>
                                        <th class="text-nowrap">Amount</th>                                            
                                        <th class="text-nowrap hidden-sm hidden-xs hidden-md text-nowrap">Created</th>                                          
                                        <th class="text-nowrap hidden-sm hidden-xs hidden-md text-nowrap">Updated</th>                                          
                                        <th class="text-nowrap no-search no-sort">Actions</th>
                                        <th class="no-search no-sort"></th>
                                        <th class="no-search no-sort"></th>
                                        {{-- @permission('delete.users')<th class="no-search no-sort"></th>@endpermission --}}
                                        {{-- <th class="no-search no-sort"></th> --}}
                                    </tr>
                                </thead>
                                <tbody id="services_table">
                                    @foreach($services as $service)
                                        <tr>
                                            <td>{{$service->id}} </td>
                                            <td>{{$service->title}}  </td>
                                            <td>{{$service->name}}  </td>
                                            <td class="hidden-sm hidden-xs ">  
                                                {{-- <div style="width: 500px;"> --}}
                                                    {{ \Illuminate\Support\Str::limit($service->description, 30, $end='...') }}
                                                {{-- </div> --}}
                                            </td>
                                            @php
                                                if ($service->available == 1)
                                                    $status = "Available";
                                                else 
                                                    $status = "Not Available";
                                            @endphp
                                            <td>{{$status}} </td>
                                            <td>{{$service->duration}} Days </td>
                                            <td>{{$service->amount}}  </td>              		
                                            <td class="text-nowrap hidden-sm hidden-xs hidden-md">{{ \Carbon\Carbon::parse($service->created_at)->format('Y-m-d') }} <br>{{ \Carbon\Carbon::parse($service->created_at)->format('h:i:s A') }}</td>
                                            <td class="text-nowrap hidden-sm hidden-xs hidden-md">{{ \Carbon\Carbon::parse($service->updated_at)->format('Y-m-d') }} <br>{{ \Carbon\Carbon::parse($service->updated_at)->format('h:i:s A') }}</td>
                                            												
                                            <td>
                                                <a class="btn btn-sm btn-success btn-block" href="{{ URL::to('services/' . $service->id) }}" data-toggle="tooltip" title="Show">
                                                    <i class="fa fa-eye fa-fw" aria-hidden="true"></i> 
                                                    <span class="hidden-xs hidden-sm">Show</span>
                                                    <span class="hidden-xs hidden-sm hidden-md"> Service</span>
                                                </a>
                                            </td>

                                            @if (\App\Models\Order::ifServiceIDIsUsed($service->id)) 
                                                <td>
                                                    <a class="btn btn-sm btn-info btn-block" href="{{ URL::to('services/' . $service->id . '/edit') }}" data-toggle="tooltip" title="Edit">
                                                        <i class="fas fa-pencil-alt fa-fw" aria-hidden="true"></i> 
                                                        <span class="hidden-xs hidden-sm">Edit</span>
                                                        <span class="hidden-xs hidden-sm hidden-md"> Service</span>
                                                    </a>
                                                </td>
                                                {{-- @permission('delete.users')  --}}
                                                <td>
                                                    {!! Form::open(array('url' => 'services/' . $service->id, 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Delete')) !!}
                                                        {!! Form::hidden('_method', 'DELETE') !!}
                                                        {!! Form::button(
                                                            '<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i>  
                                                            <span class="hidden-xs hidden-sm">Delete</span>
                                                            <span class="hidden-xs hidden-sm hidden-md"> Service</span>'
                                                            , array('class' => 'btn btn-danger btn-sm','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete User', 'data-message' => 'Are you sure you want to delete this service ?')) !!}
                                                    {!! Form::close() !!}
                                                </td>
                                                {{-- @endpermission --}}
                                            @else
                                                <td></td>
                                                <td></td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                                {{-- <tbody id="search_results"></tbody> --}}
                                    <tbody id="search_results"></tbody>
                                {{-- @endif --}}

                            </table>

                            {{-- @if(config('usersmanagement.enablePagination'))
                                {{ $services->links() }}
                            @endif --}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('modals.modal-delete')

@endsection

@section('footer_scripts')
    {{-- @if ((count($services) > config('usersmanagement.datatablesJsStartCount')) && config('usersmanagement.enabledDatatablesJs')) --}}
        @include('scripts.datatables')
    {{-- @endif --}}
    @include('scripts.delete-modal-script')
    @include('scripts.save-modal-script')
    @include('scripts.tooltips')
    {{-- @include('scripts.search-users') --}}
@endsection
