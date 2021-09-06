@extends('layouts.app')

@section('template_title')
  Showing Gift Code: {!! $code->code !!}
@endsection

@section('content')

  <div class="container">
    <div class="row">
      <div class="col-lg-10 offset-lg-1">

        <div class="card">

          <div class="card-header text-white bg-success">
            <div style="display: flex; justify-content: space-between; align-items: center;">
              Showing Gift Code: 
              <br>
              {!! $code->code !!}
              <div class="float-right">
                <a href="{{ route('promo-codes') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="Back to Codes List">
                  <i class="fa fa-fw fa-reply" aria-hidden="true"></i>
                  <span class="hidden-sm hidden-xs">
                    Back to 
                  </span>
                  <span class="hidden-xs">
                    Codes List
                  </span>
                </a>
                
                @if (isset($code->validity)) 
                  {{-- @permission('delete.users') --}}
                  {!! Form::open(array('url' => 'promo-codes/' . $code->id, 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Delete')) !!}
                    {!! Form::hidden('_method', 'DELETE') !!}
                    {!! Form::button(
                        '<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i>  
                        <span class="hidden-xs hidden-sm">Delete</span>
                        <span class="hidden-xs hidden-sm hidden-md"> Gift Code</span>'
                        , array('class' => 'btn btn-danger btn-sm','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete Gift Code', 'data-message' => 'Are you sure you want to delete this Gift Code?')) !!}
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

            @if ($course->title)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  Course Title:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $course->title }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($code->validity)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  Validity:
                </strong>
              </div>

              <div class="col-sm-7">
                @if ($code->validity == 1)
                  Valid
                @else 
                  Used
                @endif
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($code->validity && $code->validity == 0)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  User:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $user->id }} | {{ $user->first_name }} {{ $user->last_name }} | {{ $user->email }} 
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($code->created_at)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  Created at:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $code->created_at }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($code->updated_at)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  Updated at:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $code->updated_at }}
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
