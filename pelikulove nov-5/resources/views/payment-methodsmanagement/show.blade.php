@extends('layouts.app')

@section('template_title')
  Showing Payment Method: {!! $paymentMethod->name !!}
@endsection

@section('content')

  <div class="container">
    <div class="row">
      <div class="col-lg-10 offset-lg-1">

        <div class="card">

          <div class="card-header text-white bg-success">
            <div style="display: flex; justify-content: space-between; align-items: center;">
              Showing Payment Method: 
              <br>
              {!! $paymentMethod->name !!}
              <div class="float-right">
                <a href="{{ route('payment-methods') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="Back to Payment Methods">
                  <i class="fa fa-fw fa-reply" aria-hidden="true"></i>
                  <span class="hidden-sm hidden-xs">
                    Back to 
                  </span>
                  <span class="hidden-xs">
                    Payment Methods
                  </span>
                </a>
                
                @if (\App\Models\Order::ifPaymentMethodIDIsUsed($paymentMethod->id)) 
                  <a href="{!! url('payment-methods/' . $paymentMethod->id . '/edit') !!}" class="btn btn-warning btn-sm float-right mr-3" data-toggle="tooltip" data-placement="left" title="Edit">
                    <i class="fa fa-fw fa-reply" aria-hidden="true"></i>
                    <span class="hidden-xs">
                      Edit  
                    </span>
                    <span class="hidden-sm hidden-xs">
                      Payment Method
                    </span>
                  </a>
                  {{-- @permission('delete.users') --}}
                  {!! Form::open(array('url' => 'payment-methods/' . $paymentMethod->id, 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Delete')) !!}
                    {!! Form::hidden('_method', 'DELETE') !!}
                    {!! Form::button(
                        '<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i>  
                        <span class="hidden-xs hidden-sm">Delete</span>
                        <span class="hidden-xs hidden-sm hidden-md"> Payment Method</span>'
                        , array('class' => 'btn btn-danger btn-sm','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete Payment Method', 'data-message' => 'Are you sure you want to delete this Payment Method ?')) !!}
                  {!! Form::close() !!}
                  {{-- @endpermission --}}
                @endif
                  
              </div>
            </div>
          </div>

          <div class="card-body">

            @if ($paymentMethod->name)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  Payment Method Name:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $paymentMethod->name }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($paymentMethod->description)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  Description:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $paymentMethod->description }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($paymentMethod->created_at)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  Created at:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $paymentMethod->created_at }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($paymentMethod->updated_at)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  Updated at:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $paymentMethod->updated_at }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

          </div>

        </div>
      </div>
    </div>
  </div>

  @include('modals.modal-delete')

@endsection

@section('footer_scripts')
  @include('scripts.delete-modal-script')
  @if(config('usersmanagement.tooltipsEnabled'))
    @include('scripts.tooltips')
  @endif
@endsection
