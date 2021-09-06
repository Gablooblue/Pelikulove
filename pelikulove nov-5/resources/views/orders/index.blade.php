@extends('layouts.app')

@section('template_title')
    {!! trans('orders.showing-all-orders') !!}
@endsection

@section('template_linked_css')
    @if(config('usersmanagement.enabledDatatablesJs'))
        <link rel="stylesheet" type="text/css" href="{{ config('usersmanagement.datatablesCssCDN') }}">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
    @endif
    <style type="text/css" media="screen">
        .orders-table {
            border: 0;
        }
        .orders-table tr td:first-child {
            padding-left: 15px;
        }
        .orders-table tr td:last-child {
            padding-right: 15px;
        }
        .orders-table.table-responsive,
        .orders-table.table-responsive table {
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
                                {!! trans('orders.showing-all-orders') !!}
                            </span>
						
                            
                        </div>
                    </div>

                    <div class="card-body">
                    	<div class="row mb-3">
                    		<div class="col-md-12 col-lg-12 py-3">
                    		<h4>Total Orders:  <span class="badge badge-info badge-pill"> {{$orders->count()}}</span></h4>
   							
                    		</div>
                    		<div class="col-md-6 col-sm-6 col-lg-6">
                    			
									
                    					<ul class="list-group">
  										
  										<li class="list-group-item d-flex justify-content-between align-items-center">
   										 Success
   										 <span class="badge badge-success badge-pill"> {{$orders->where('payment_status', 'S')->count()}}</span>
  										</li>
  										<li class="list-group-item d-flex justify-content-between align-items-center">
    									 Pending
    									<span class="badge badge-warning badge-pill">{{$orders->where('payment_status', 'P')->count()}}</span>
  										</li>
  										<li class="list-group-item d-flex justify-content-between align-items-center">
    									 Waiting (Didn't finish order)
    									<span class="badge badge-primary badge-pill">{{$orders->where('payment_status', 'W')->count()}}</span>
  										</li>
  										<li class="list-group-item d-flex justify-content-between align-items-center">
    									 Failure 
    									<span class="badge badge-danger badge-pill">{{$orders->where('payment_status', 'F')->count()}}</span>
  										</li>
										</ul>
                    				
                    		</div>
                    				
                    		<div class="col-md-6 col-sm-6 col-lg-6">
                    			
                    					<ul class="list-group">
  										@foreach ($services as $service)
  										<li class="list-group-item d-flex justify-content-between align-items-center">
   										 {{$service->name}}
   										 <span class="badge badge-success badge-pill"> {{$orders->where('service_id', $service->id)->count()}}</span>
  										</li>
  										@endforeach
										</ul>
                    		
                    		</div>
                    	</div>
						<div class="row mb-3 mt-2 pt-3 pb-3">
						<div class="col-md-12 col-lg-12 py-3">
                    		<h4>Total Payment: {{number_format($orders->where('payment_status', 'S')->sum('amount'),2)}}</h4>
                    	</div>
						<div class="col-md-4 col-sm-4 col-xs-6 col-lg-2">
							<div class="card card-stats">
								
              					<div class="card-body ">
               						 <div class="row">
                  						<div class="col-3 col-md-3">
                    						
                      						<i class="fa fa-bank fa-lg text-center text-warning"></i>
                    						
                  						</div>
                  						<div class="col-9 col-md-9">
                    						<div class="numbers">
                     						 <p class="card-category text-warning">BDO</p>
                     						 <h5 class="card-title text-warning">{{$orders->where('payment_id', 2)->where('payment_status', 'S')->count()}}</h5>
                    						</div>
                  						</div>
               	 					</div>
              					</div>
              					<div class="card-footer ">
               					 	
               					 	<div class="stats">
                  					 <h4 class="text-right font-weight-bold text-warning">{{number_format($orders->where('payment_id', 2)->where('payment_status', 'S')->sum('amount'),2)}}</h4>
                					</div>
             					</div>
              				</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-6 col-lg-2">
							<div class="card card-stats">
              					<div class="card-body ">
               						 <div class="row">
                  						<div class="col-3 col-md-3">
                    						
                      						<i class="fa fa-lg fa-money text-center text-success"></i>
                    						
                  						</div>
                  						<div class="col-9 col-md-9">
                    						<div class="numbers">
                     						 <p class="card-category text-success">CASH</p>
                     						 <h5 class="card-title text-success">{{$orders->where('payment_id', 3)->where('payment_status', 'S')->count()}}</h5>
                    						</div>
                  						</div>
               	 					</div>
              					</div>
              					<div class="card-footer ">
               					 
               					 	<div class="stats">
                  					 <h4 class="text-right font-weight-bold text-success">{{number_format($orders->where('payment_id', 3)->where('payment_status', 'S')->sum('amount'),2)}}</h4>
                					</div>
             					</div>
              				</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-6 col-lg-2">
							<div class="card card-stats">
              					<div class="card-body ">
               						 <div class="row">
                  						<div class="col-3 col-md-3">
                    						
                      						<i class="fa fa-lg fa-mug-hot text-info"></i>
                    						
                  						</div>
                  						<div class="col-9 col-md-9">
                    						<div class="numbers">
                     						 <p class="card-category text-info">COMPLI</p>
                     						 <h5 class="card-title  text-info">{{$orders->where('payment_id', 6)->where('payment_status', 'S')->count()}}</h5>
                    						</div>
                  						</div>
               	 					</div>
              					</div>
              					<div class="card-footer ">
               					
               					 	<div class="stats">
                  					<h4 class="text-info text-right font-weight-bold">{{number_format($orders->where('payment_id', 6)->where('payment_status', 'S')->sum('amount'),2)}}</h4>
                					</div>
             					</div>
              				</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-6 col-lg-2">
							<div class="card card-stats">
              					<div class="card-body ">
               						 <div class="row">
                  						<div class="col-3 col-md-3">
                    						
                      						<i class="fa fa-lg fa-dragon text-danger"></i>
                    						
                  						</div>
                  						<div class="col-9 col-md-9">
                    						<div class="numbers">
                     						 <p class="card-category text-danger">DRAGONPAY</p>
                     						 <h5 class="card-title text-danger">{{$orders->where('payment_id', 1)->where('payment_status', 'S')->count()}}</h5>
                    						</div>
                  						</div>
               	 					</div>
              					</div>
              					<div class="card-footer ">
               					
               					 	<div class="stats">
                  					 <h4 class="text-right font-weight-bold text-danger">{{number_format($orders->where('payment_id', 1)->where('payment_status', 'S')->sum('amount'),2)}}</h4>
                					</div>
             					</div>
              				</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-6 col-lg-2">
							<div class="card card-stats">
              					<div class="card-body ">
               						 <div class="row">
                  						<div class="col-4 col-md-4">
                    						
                      						<i class="fa fa-lg fa-kiwi-bird text-secondary"></i>
                    						
                  						</div>
                  						<div class="col-8 col-md-8">
                    						<div class="numbers">
                     						 <p class="card-category text-secondary">EARLY</p>
                     						 <h5 class="card-title  text-secondary">{{$orders->where('payment_id', 5)->where('payment_status', 'S')->count()}}</h5>
                    						</div>
                  						</div>
               	 					</div>
              					</div>
              					<div class="card-footer ">
               					
               					 	<div class="stats">
                  					<h4 class="text-secondary text-right font-weight-bold">{{number_format($orders->where('payment_id', 5)->where('payment_status', 'S')->sum('amount'),2)}}</h4>
                					</div>
             					</div>
              				</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-6 col-lg-2">
							<div class="card card-stats">
              					<div class="card-body ">
               						 <div class="row">
                  						<div class="col-4 col-md-4">
                    						
                      						<i class="fab fa-lg fa-paypal text-primary"></i>
                    						
                  						</div>
                  						<div class="col-8 col-md-8">
                    						<div class="numbers">
                     						 <p class="card-category text-primary">PAYPAL</p>
                     						 <h5 class="card-title text-primary">{{$orders->where('payment_id', 4)->where('payment_status', 'S')->count()}}</h5>
                    						</div>
                  						</div>
               	 					</div>
              					</div>
              					<div class="card-footer ">
               					
               					 	<div class="stats">
                  					<h4 class="text-primary text-right font-weight-bold">{{number_format($orders->where('payment_id', 4)->where('payment_status', 'S')->sum('amount'),2)}}</h4>
                					</div>
             					</div>
              				</div>
						</div>
						
						</div>
                        
                        <div class="table-responsive orders-table">
                            <table class="table table-striped table-sm data-table">
                                <caption id="user_count">
                                    {{ trans_choice('orders.orders-table.caption', 1, ['orderscount' => $orders->count()]) }}
                                </caption>
                                <thead class="thead">
                                    <tr>
                                        <th class="text-nowrap">{!! trans('orders.orders-table.id') !!}</th>
                         				<th>{!! trans('orders.orders-table.email') !!}</th>
                                        <th>{!! trans('orders.orders-table.transaction_id') !!}</th>
                                        <th class="hidden-xs">{!! trans('orders.orders-table.ref_no') !!}</th>
                                        <th class="hidden-xs">{!! trans('orders.orders-table.course') !!}</th>
                                        <th>{!! trans('orders.orders-table.payment') !!}</th>
                                        <th>{!! trans('orders.orders-table.status') !!}</th>
                                        <th>{!! trans('orders.orders-table.amount') !!}</th>
                                        <th>Billable</th>
                                        <th class="hidden-xs">{!! trans('orders.orders-table.code') !!}</th>
                                        <th class="hidden-sm hidden-xs hidden-md">{!! trans('orders.orders-table.created') !!}</th>
                                        <th class="hidden-sm hidden-xs hidden-md">{!! trans('orders.orders-table.updated') !!}</th>
                                        <th>{!! trans('orders.orders-table.actions') !!}</th>    
                                    </tr>
                                </thead>
                                <tbody id="users_table">
                                    @foreach($orders as $order)
                                        <tr>
                                        	<td class="small">
												{{$order->id}}
											</td>
                                        	<td class="">
												@if (isset($order->user))
													<a href="mailto:{{ $order->user->email }}" title="email {{ $order->user->email }}">
														{{ $order->user->email }}
													</a> 
													<br>
													{{$order->user->first_name}} {{$order->user->last_name}} 
												@elseif ($order->user_id == 0)
													ticket2me@reserved.com
												@endif
												@if (isset($order->user)) 
													@foreach ($order->user->roles as $user_role)
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
                                            	@endif    
                                        	</td>
                                          	<td class="small">
											   {{$order->transaction_id}}
											</td>
											<td class="hidden-xs small">
												{{$order->ref_no}}
											</td>
											<td class="hidden-xs small">
												@if (isset($order->service->course_id)) 
													@php
														$course= \App\Models\Course::find($order->service->course_id); 
													@endphp
													{{$course->short_title}}
												@elseif (isset($order->service->vod_id)) 
													@php
														$vod= \App\Models\Vod::find($order->service->vod_id); 
													@endphp
													{{$vod->short_title}}
												@endif
											</td>
                                            <td> 
												@if ($order->payment_id == 1)
													@php $badgeClass = 'danger' @endphp
												@elseif ($order->payment_id == 2)
													@php $badgeClass = 'warning' @endphp
												@elseif ($order->payment_id == 3)
													@php $badgeClass = 'success' @endphp
												@elseif ($order->payment_id == 4)
													@php $badgeClass = 'primary' @endphp
												@else
													@php $badgeClass = 'secondary' @endphp
												@endif
												<span class="text-{{$badgeClass}} small"> @php $p = \App\Models\PaymentMethod::find($order->payment_id); @endphp {{$p['name']}}</span><br>
												@if (isset($order->transactions))
													<a class="small badge badge-info" href="{{url('/order/'.$order->id.'/transactions')}}" data-toggle="tooltip" title="Show Transactions">
														<i class="fa fa-eye"></i> Transactions
													</a>
												@endif
                                           	</td>
                                            <td>
												@if ($order->payment_status == 'S')
													@php $badgeClass = 'success'; $text = 'Success'; @endphp
												@elseif ($order->payment_status == 'F')
													@php $badgeClass = 'danger'; $text = 'Failure'; @endphp
												@elseif ($order->payment_status == 'P')
													@php $badgeClass = 'warning'; $text = 'Pending'; @endphp
												@else
													@php $badgeClass = 'primary'; $text = 'Waiting'; @endphp
												@endif
                                            
												<span class="badge badge-{{$badgeClass}}">{{ $text }}</span>
											</td>
                                            <td class="hidden-xs small">
												{{ number_format($order->amount, 2) }}
											</td> 
                                         	<td class="hidden-xs small">
												@if ($order->billable == 1) Yes @else No @endif
											</td>
											<td class="hidden-xs small">
												{{ $order->code }}
											</td>
											<td data-sort="{{strtotime($order->created_at)}}" class="hidden-sm hidden-xs hidden-md text-nowrap small">
												{{date("j M Y", strtotime($order->created_at))}}<br>{{date("H:i:s A", strtotime($order->created_at))}}
											</td>
											<td data-sort="{{strtotime($order->created_at)}}" class="hidden-sm hidden-xs hidden-md text-nowrap small">
												{{date("j M Y", strtotime($order->updated_at))}}<br>{{date("H:i:s A", strtotime($order->updated_at))}}
											</td>
                                            <td>
                                                <a class="btn btn-sm btn-info btn-block text-nowrap" href="{{url('/order/'.$order->id.'/edit')}}" data-toggle="tooltip" title="Edit Order">
                                                    {!! trans('orders.buttons.edit') !!}
                                                </a>
                                            </td>
                                            
                                        </tr>
                                    @endforeach
                                    <tfoot class="thead">
                                    <tr>
                                        <th class="text-nowrap">{!! trans('orders.orders-table.id') !!}</th>
                         				<th>{!! trans('orders.orders-table.email') !!}</th>
                                        <th>{!! trans('orders.orders-table.transaction_id') !!}</th>
                                        <th class="hidden-xs">{!! trans('orders.orders-table.ref_no') !!}</th>
                                        <th class="hidden-xs">{!! trans('orders.orders-table.course') !!}</th>
                                        <th>{!! trans('orders.orders-table.payment') !!}</th>
                                        <th>{!! trans('orders.orders-table.status') !!}</th>
                                        <th>{!! trans('orders.orders-table.amount') !!}</th>
                                        <th>Billable</th>
                                        <th class="hidden-xs">{!! trans('orders.orders-table.code') !!}</th>
                                        <th class="hidden-sm hidden-xs hidden-md">{!! trans('orders.orders-table.created') !!}</th>
                                        <th class="hidden-sm hidden-xs hidden-md">{!! trans('orders.orders-table.updated') !!}</th>
                                        <th>{!! trans('orders.orders-table.actions') !!}</th>
                                  		
                                     
                                    </tr>
                                	</tfoot>
                                </tbody>
                                
							</table>

							<hr>

							{{-- @if(config('usersmanagement.enablePagination')) --}}
								<div class="mt-3 row justify-content-center">
									<div>
										<h5 class="text-center">
											Showing {{ config('usersmanagement.paginateListSize') }} per table
										</h5>
										<div class="mt-2 row justify-content-center">
											{{ $orders->links() }}
										</div>
									</div>
								</div>
							{{-- @endif --}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   

@endsection

@section('footer_scripts')
    @if ((count($orders) > config('usersmanagement.datatablesJsStartCount')) && config('usersmanagement.enabledDatatablesJs'))
        @include('scripts.datatables')
    @endif
   
    @include('scripts.save-modal-script')
    @if(config('orders.tooltipsEnabled'))
        @include('scripts.tooltips')
    @endif

@endsection
