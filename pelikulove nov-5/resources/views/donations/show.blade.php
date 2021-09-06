@extends('layouts.app')

@section('template_title')
  Showing Donation #{!! $donation->id !!}
@endsection

@section('content')

  <div class="container">
    <div class="row">
      <div class="col-lg-10 offset-lg-1">

        <div class="card">

          <div class="card-header text-white bg-success">
            <div style="display: flex; justify-content: space-between; align-items: center;">
              Showing Donation #{!! $donation->id !!}
              <div class="float-right">
                
                <a href="{{ route('donations.list') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="Back to Donations">
                  <i class="fa fa-fw fa-reply" aria-hidden="true"></i>
                  <span class="hidden-sm hidden-xs">
                    Back to 
                  </span>
                  <span class="hidden-xs">
                    Donations
                  </span>
                </a>
                  
              </div>
            </div>
          </div>

          <div class="card-body">

            @if ($donation->username)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  Username:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $donation->username }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($donation->first_name)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  First name:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $donation->first_name }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($donation->last_name)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  Last name:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $donation->last_name }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($donation->email)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  Email:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $donation->email }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($donation->notes)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  Notes:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $donation->notes }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($donation->amount)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  Amount:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $donation->amount }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            <div class="col-sm-5 col-6 text-larger">
              <strong>
                Cause:
              </strong>
            </div>

            <div class="col-sm-7">
              @php
                if (isset($donation->cause_id)) {
                    $cause_title = \App\Models\DonationCause::find($donation->cause_id)->title;
                } else {
                    $cause_title = "None";
                }
              @endphp
              {{$cause_title}}
            </div>

            <div class="clearfix"></div>
            <div class="border-bottom"></div>

            @if ($donation->p_name)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  Payment Method:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $donation->p_name }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($donation->created_at)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  Created at:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $donation->created_at }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($donation->updated_at)

              <div class="col-sm-5 col-6 text-larger">
                <strong>
                  Updated at:
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $donation->updated_at }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

          </div>

        </div>
      </div>
    </div>
  </div>

@endsection

@section('footer_scripts')
  @if(config('usersmanagement.tooltipsEnabled'))
    @include('scripts.tooltips')
  @endif
@endsection
