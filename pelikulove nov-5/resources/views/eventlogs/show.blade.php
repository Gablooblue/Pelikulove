@extends('layouts.app')

@section('template_title')
  Showing Event Log of {!! $eventlog->name !!}
@endsection

@section('content')

  <div class="container">
    <div class="row">
      <div class="col-lg-10 offset-lg-1">

        <div class="card">

          <div class="card-header text-white bg-success">
            <div style="display: flex; justify-content: space-between; align-items: center;">
              Showing Event Log: 
              <br>
              {!! $eventlog->name !!}
              <div class="float-right">
                <a href="{{ route('eventlogs.index') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="Back to Event Logs">
                  <i class="fa fa-fw fa-reply" aria-hidden="true"></i>
                  <span class="hidden-sm hidden-xs">
                    Back to 
                  </span>
                  <span class="hidden-xs">
                    Event Logs
                  </span>
                </a>
                  
              </div>
            </div>
          </div>

          <div class="card-body">

            @if ($eventlog->id)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  User ID:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $eventlog->id }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($eventlog->name)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  Username:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $eventlog->name }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($eventlog->email)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  Email:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $eventlog->email }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($eventlog->first_name)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  First Name:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $eventlog->first_name }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($eventlog->last_name)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  Last Name:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $eventlog->last_name }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($eventlog->mobile_number)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  Mobile Number:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $eventlog->mobile_number }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($eventlog->gender)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  Gender:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $eventlog->gender }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($eventlog->birthday)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  Birthday:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $eventlog->birthday }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($eventlog->profession)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  Profession:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $eventlog->profession }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($eventlog->interests)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  Interests:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $eventlog->interests }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($eventlog->referer)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  Referer:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $eventlog->referer }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($eventlog->comment)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  Comments / Suggestions:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $eventlog->comment }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($eventlog->created_at)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  Created at:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $eventlog->created_at }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($eventlog->updated_at)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  Updated at:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $eventlog->updated_at }}
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
