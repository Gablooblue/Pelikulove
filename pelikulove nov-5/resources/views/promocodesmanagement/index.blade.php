@extends('layouts.app')

@section('template_title')
    Showing all Promo Codes
@endsection

@section('template_linked_css')
    <link rel="stylesheet" type="text/css" href="{{ config('usersmanagement.datatablesCssCDN') }}">
    <style type="text/css" media="screen">
        .codes-table {
            border: 0;
            white-space: nowrap;
        }
        .codes-table tr td:first-child {
            padding-left: 15px;
        }
        .codes-table tr td:last-child {
            padding-right: 15px;
        }
        .codes-table.table-responsive,
        .codes-table.table-responsive table {
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
                                Showing All Promo Codes
                            </span>

                            <div class="btn-group pull-right btn-group-xs">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                                    <span class="sr-only">
                                        Show Promo Codes Management Menu
                                    </span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="/promo-codes/create">
                                        <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                                        Create New Promo Code
                                    </a>
                                    {{-- <a class="dropdown-item" href="#">
                                        <i class="fa fa-fw fa-group" aria-hidden="true"></i>
                                       Show Deleted Promo Codes
                                    </a> --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">                       

                        <div class="table-responsive codes-table">
                            <table class="table table-striped table-sm data-table">
                                <caption id="user_count">
                                    {{sizeof($codes)}} Promo Codes Total
                                </caption>
                                <thead class="thead">
                                    <tr>
                                        <th class="text-nowrap">Course Title</th>
                                        <th class="text-nowrap">Service Name</th>
                                        <th class="text-nowrap">Code</th>
                                        <th class="text-nowrap">Code Type</th>
                                        <th class="text-nowrap">Amount</th>                                            
                                        <th class="text-nowrap">Start Date</th>                                          
                                        <th class="text-nowrap">End Date</th>    
                                        <th class="text-nowrap hidden-sm hidden-xs hidden-md text-nowrap">Created</th>                                          
                                        <th class="text-nowrap hidden-sm hidden-xs hidden-md text-nowrap">Updated</th>                                          
                                        <th class="text-nowrap no-search no-sort">Actions</th>
                                        <th class="no-search no-sort"></th>
                                        <th class="no-search no-sort"></th>
                                        {{-- @permission('delete.users')<th class="no-search no-sort"></th>@endpermission --}}
                                        {{-- <th class="no-search no-sort"></th> --}}
                                    </tr>
                                </thead>
                                <tbody id="codes_table">
                                    @foreach($codes as $code)
                                        <tr>
                                            <td>{{ \Illuminate\Support\Str::limit($code->course_title, 30, $end='...') }} </td>                                            
                                            <td>{{$code->service_name}} </td>
                                            <td>{{$code->code}} </td>
                                            
                                            @if (isset($code->validity))
                                                <td>Gift Code</td>
                                            @else 
                                                <td>Promo Code</td>
                                            @endif
                                                                                    
                                            @if (isset($code->amount))
                                                <td>{{$code->amount}} </td> 
                                            @else 
                                                <td>Free </td> 
                                            @endif
                                            
                                            @if (isset($code->start_date))
                                                <td class="text-nowrap">{{ \Carbon\Carbon::parse($code->start_date)->format('Y-m-d') }}</td>
                                                <td class="text-nowrap">{{ \Carbon\Carbon::parse($code->end_date)->format('Y-m-d') }}</td>    
                                            @else 
                                                @if ($code->validity == 0)
                                                    <td class="text-nowrap">Used</td>
                                                    <td class="text-nowrap">Used</td> 
                                                @else 
                                                    <td class="text-nowrap">Valid</td>
                                                    <td class="text-nowrap">Valid</td> 
                                                @endif 
                                            @endif

                                            <td class="text-nowrap hidden-sm hidden-xs hidden-md">{{ \Carbon\Carbon::parse($code->created_at)->format('Y-m-d') }} <br>{{ \Carbon\Carbon::parse($code->created_at)->format('h:i:s A') }}</td>
                                            <td class="text-nowrap hidden-sm hidden-xs hidden-md">{{ \Carbon\Carbon::parse($code->updated_at)->format('Y-m-d') }} <br>{{ \Carbon\Carbon::parse($code->updated_at)->format('h:i:s A') }}</td>
                                            												
                                            <td>
                                                <a class="btn btn-sm btn-success btn-block" href="
                                                @if (isset($code->validity))
                                                    {{ URL::to('promo-codes/giftcode/' . $code->id) }}
                                                @else 
                                                    {{ URL::to('promo-codes/promocode/' . $code->id) }}
                                                @endif
                                                " 
                                                data-toggle="tooltip" title="Show">
                                                    <i class="fa fa-eye fa-fw" aria-hidden="true"></i> 
                                                    <span class="hidden-xs hidden-sm">Show</span>
                                                    <span class="hidden-xs hidden-sm hidden-md"> Promo Code</span>
                                                </a> 
                                            </td>

                                            {{-- @if (\App\Models\Order::ifPromoCodeIsUsed($code->id))  --}}
                                            @if (!isset($code->validity)) 
                                                {{-- If Promo Code --}}
                                                <td>
                                                    <a class="btn btn-sm btn-info btn-block" href="{{ URL::to('/promo-codes/' . $code->id . '/editPromoCode') }}" data-toggle="tooltip" title="Edit">
                                                        <i class="fas fa-pencil-alt fa-fw" aria-hidden="true"></i> 
                                                        <span class="hidden-xs hidden-sm">Edit</span>
                                                        <span class="hidden-xs hidden-sm hidden-md"> Promo Code</span>
                                                    </a>
                                                </td>
                                                {{-- @permission('delete.users')  --}}
                                                {{-- <td>
                                                    {!! Form::open(array('url' => 'promo-codes/promocode/' . $code->id, 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Delete')) !!}
                                                        {!! Form::hidden('_method', 'DELETE') !!}
                                                        {!! Form::button(
                                                            '<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i>  
                                                            <span class="hidden-xs hidden-sm">Delete</span>
                                                            <span class="hidden-xs hidden-sm hidden-md"> Gift Code</span>'
                                                            , array('class' => 'btn btn-danger btn-sm','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete User', 'data-message' => 'Are you sure you want to delete this code ?')) !!}
                                                    {!! Form::close() !!}
                                                </td> --}}
                                                {{-- @endpermission --}}
                                                <td></td>
                                            @elseif (isset($code->validity))
                                                {{-- If Gift Code --}}
                                                @if ($code->validity == 1) 
                                                    <td></td>
                                                    {{-- If Gift Code is Valid --}}
                                                    <td>
                                                        {!! Form::open(array('url' => 'promo-codes/' . $code->id, 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Delete')) !!}
                                                            {!! Form::hidden('_method', 'DELETE') !!}
                                                            {!! Form::button(
                                                                '<i class="fa fa-trash fa-fw" aria-hidden="true"></i>  
                                                                <span class="hidden-xs hidden-sm">Delete</span>
                                                                <span class="hidden-xs hidden-sm hidden-md"> Gift Code</span>'
                                                                , array('class' => 'btn btn-danger btn-sm','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete User', 'data-message' => 'Are you sure you want to delete this code ?')) !!}
                                                        {!! Form::close() !!}
                                                    </td>
                                                @else                                                 
                                                    <td></td>
                                                    <td></td>
                                                @endif
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
                                {{ $codes->links() }}
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
    @include('scripts.datatables')
    @include('scripts.delete-modal-script')
    @include('scripts.save-modal-script')
    @include('scripts.tooltips')
@endsection
