@extends('layouts.app')

@section('template_title')
    Showing all Payment Methods
@endsection

@section('template_linked_css')
    <link rel="stylesheet" type="text/css" href="{{ config('usersmanagement.datatablesCssCDN') }}">
    <style type="text/css" media="screen">
        .payment-methods-table {
            border: 0;
            white-space: nowrap;
        }
        .payment-methods-table tr td:first-child {
            padding-left: 15px;
        }
        .payment-methods-table tr td:last-child {
            padding-right: 15px;
        }
        .payment-methods-table.table-responsive,
        .payment-methods-table.table-responsive table {
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
                                Showing All Payment Methods
                            </span>

                            <div class="btn-group pull-right btn-group-xs">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                                    <span class="sr-only">
                                        Show Payment Methods Management Menu
                                    </span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="/payment-methods/create">
                                        <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                                        Create New Payment Methods
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">                       

                        <div class="table-responsive payment-methods-table">
                            <table class="table table-striped table-sm data-table">
                                <caption id="user_count">
                                    {{$paymentMethods->count()}} Payment Method(s) Total
                                </caption>
                                <thead class="thead">
                                    <tr>
                                        <th class="text-nowrap">ID</th>
                                        <th class="text-nowrap">Payment Method Name</th>
                                        <th class="text-nowrap hidden-sm hidden-xs ">Description</th>                           
                                        <th class="text-nowrap hidden-sm hidden-xs hidden-md text-nowrap">Created</th>                                          
                                        <th class="text-nowrap hidden-sm hidden-xs hidden-md text-nowrap">Updated</th>                                          
                                        <th class="text-nowrap no-search no-sort">Actions</th>
                                        <th class="no-search no-sort"></th>
                                        <th class="no-search no-sort"></th>
                                    </tr>
                                </thead>
                                <tbody id="services_table">
                                    @foreach($paymentMethods as $paymentMethod)
                                        <tr>
                                            <td>{{$paymentMethod->id}} </td>
                                            <td>{{$paymentMethod->name}}  </td>
                                            <td class="hidden-sm hidden-xs ">  
                                                {{ \Illuminate\Support\Str::limit($paymentMethod->description, 30, $end='...') }}
                                            </td>           		
                                            <td class="text-nowrap hidden-sm hidden-xs hidden-md">{{ \Carbon\Carbon::parse($paymentMethod->created_at)->format('Y-m-d') }} <br>{{ \Carbon\Carbon::parse($paymentMethod->created_at)->format('h:i:s A') }}</td>
                                            <td class="text-nowrap hidden-sm hidden-xs hidden-md">{{ \Carbon\Carbon::parse($paymentMethod->updated_at)->format('Y-m-d') }} <br>{{ \Carbon\Carbon::parse($paymentMethod->updated_at)->format('h:i:s A') }}</td>
                                            
                                            <td>
                                                <a class="btn btn-sm btn-success btn-block" href="{{ URL::to('payment-methods/' . $paymentMethod->id) }}" data-toggle="tooltip" title="Show">
                                                    <i class="fa fa-eye fa-fw" aria-hidden="true"></i> 
                                                    <span class="hidden-xs hidden-sm">Show</span>
                                                    <span class="hidden-xs hidden-sm hidden-md"> Payment Method</span>
                                                </a>
                                            </td>
                                            

                                            @if (\App\Models\Order::ifPaymentMethodIDIsUsed($paymentMethod->id)) 
                                                <td>
                                                    <a class="btn btn-sm btn-info btn-block" href="{{ URL::to('payment-methods/' . $paymentMethod->id . '/edit') }}" data-toggle="tooltip" title="Edit">
                                                        <i class="fas fa-pencil-alt fa-fw" aria-hidden="true"></i> 
                                                        <span class="hidden-xs hidden-sm">Edit</span>
                                                        <span class="hidden-xs hidden-sm hidden-md"> Payment Method</span>
                                                    </a>
                                                </td>
                                                <td>
                                                    {!! Form::open(array('url' => 'payment-methods/' . $paymentMethod->id, 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Delete')) !!}
                                                        {!! Form::hidden('_method', 'DELETE') !!}
                                                        {!! Form::button(
                                                            '<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i>  
                                                            <span class="hidden-xs hidden-sm">Delete</span>
                                                            <span class="hidden-xs hidden-sm hidden-md"> Payment Method</span>'
                                                            , array('class' => 'btn btn-danger btn-sm','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete User', 'data-message' => 'Are you sure you want to delete this service ?')) !!}
                                                    {!! Form::close() !!}
                                                </td>
                                            @else
                                                <td></td>
                                                <td></td>
                                            @endif
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

    @include('modals.modal-delete')

@endsection

@section('footer_scripts')
    @include('scripts.datatables')
    @include('scripts.delete-modal-script')
    @include('scripts.save-modal-script')
    @include('scripts.tooltips')
@endsection
