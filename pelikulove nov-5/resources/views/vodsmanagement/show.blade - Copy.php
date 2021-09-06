@extends('layouts.app')

@section('template_title')
  Showing Service: {!! $user->name !!}
@endsection

@section('content')

  <div class="container">
    <div class="row">
      <div class="col-lg-10 offset-lg-1">

        <div class="card">

          <div class="card-header text-white bg-success">
            <div style="display: flex; justify-content: space-between; align-items: center;">
              Showing Service: 
              <br>
              {!! $service->name !!}
              <div class="float-right">
                <a href="{{ route('services') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="Back to Services">
                  <i class="fa fa-fw fa-reply" aria-hidden="true"></i>
                  <span class="hidden-sm hidden-xs">
                    Back to 
                  </span>
                  <span class="hidden-xs">
                    Services
                  </span>
                </a>
                
                @if (\App\Models\Order::ifServiceIDIsUsed($service->id)) 
                  <a href="{!! url('services/' . $service->id . '/edit') !!}" class="btn btn-warning btn-sm float-right mr-3" data-toggle="tooltip" data-placement="left" title="Edit">
                    <i class="fa fa-fw fa-reply" aria-hidden="true"></i>
                    <span class="hidden-xs">
                      Edit  
                    </span>
                    <span class="hidden-sm hidden-xs">
                      Service
                    </span>
                  </a>
                  {{-- @permission('delete.users') --}}
                  {!! Form::open(array('url' => 'services/' . $service->id, 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Delete')) !!}
                    {!! Form::hidden('_method', 'DELETE') !!}
                    {!! Form::button(
                        '<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i>  
                        <span class="hidden-xs hidden-sm">Delete</span>
                        <span class="hidden-xs hidden-sm hidden-md"> Service</span>'
                        , array('class' => 'btn btn-danger btn-sm','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete Service', 'data-message' => 'Are you sure you want to delete this service ?')) !!}
                  {!! Form::close() !!}
                  {{-- @endpermission --}}
                @endif
              </div>
            </div>
          </div>

          <div class="card-body">

            @if ($service->name)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  Service Name:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $service->name }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($service->title)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  Course Name:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $service->title }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($service->description)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  Description:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $service->description }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($service->duration)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  Duration:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $service->duration }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($service->amount)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  Amount:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $service->amount }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($service->created_at)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  Created at:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $service->created_at }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($service->updated_at)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  Updated at:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $service->updated_at }}
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
