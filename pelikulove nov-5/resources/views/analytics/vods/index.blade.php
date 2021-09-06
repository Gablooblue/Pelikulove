@extends('layouts.app')

@section('template_title')
    Blackbox Analytics
@endsection

@section('template_linked_css')
    <link rel="stylesheet" type="text/css" href="{{ config('usersmanagement.datatablesCssCDN') }}">
    <style type="text/css" media="screen">
        .analytics-table {
            border: 0;
            white-space: nowrap;
        }
        .analytics-table tr td:first-child {
            padding-left: 15px;
        }
        .analytics-table tr td:last-child {
            padding-right: 15px;
        }
        .analytics-table.table-responsive,
        .analytics-table.table-responsive table {
            margin-bottom: 0;
        }     
        .tooltip-inner {
            text-align: left;
            white-space: pre-line;
        }     
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card p-3">
                    <div class="card-header">
                        <div class=""> 
                            <div class="align-self-center">                                
                                <h2 id="card_title" class="text-center">
                                    <span class="">
                                        Blackbox Analytics
                                    </span>
                                </h2>
                            </div>

                            {{-- <div class="btn-group pull-right btn-group-xs align-self-end">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                                    <span class="sr-only">
                                        Show Analytics Menu
                                    </span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="/services/create">
                                        <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                                        Create New Service
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="fa fa-fw fa-group" aria-hidden="true"></i>
                                       Show Deleted Services
                                    </a>
                                </div>
                            </div> --}}
                        </div>
                    </div>

                    <hr>

                    {{-- Top Viewed Videos Start --}}
                    <div class="card bg-white shadow rounded mx-2 my-1">
                        <div class="card-header bg-white rounded py-4">
                            <h2 class="text-center m-0">
                                <span class="badge badge-info" style="font-size: 100%;">
                                    Top Viewed Videos
                                </span>
                            </h2>
                        </div>        
                        <hr class="my-0">
                        <div class="card-body bg-white rounded mx-1 px-1">
                            <div class="row mx-1 mb-2 justify-content-center">
        
                                {{-- By Registered Users Start --}}
                                <div class="card bg-white rounded mx-2 my-2">
                                    <div class="card-header pt-3">
                                        <p class="text-center">By Registered Users (Unique Reg. Users)</p>
                                    </div>
                                    <hr class="mt-n2 mb-2">
                                    <div class="card-body">
                                        @foreach ($allVodStats->sortByDesc('registeredViews') as $vod)
                                            @if ($loop->index < 10) 
                                                <div class="row justify-content-between mx-1 my-1">
                                                    <span class="" data-toggle="tooltip" title="{{$vod->title}}">
                                                        {{ $loop->iteration }}. 
                                                        <a href="{{ route('analytics.vod.show-video', $vod->id) }}">
                                                            {{ \Illuminate\Support\Str::limit($vod->title, 35, $end='...') }}
                                                        </a>
                                                    </span>
                                                    <span class="ml-5">
                                                        <strong>
                                                            {{ $vod->registeredViews }} ({{ $vod->uniqueRegViewsCount }})
                                                        </strong>
                                                    </span>
                                                </div>
                                                <hr class="ml-2 mr-2">
                                            @else 
                                                @if ($loop->index == 10)
                                                    <a id="registeredViewsStart" value="registeredViews" class="mb-2 row justify-content-center listCollapsible" href="#" data-toggle="collapse" 
                                                    data-target="#registeredViewsList" aria-expanded="false" aria-controls="registeredViewsList">
                                                        Show More 
                                                        <i class="fa fa-angle-double-right fa-lg ml-1 mt-1"></i>
                                                    </a>
                                                @endif
                                                <div id="registeredViewsList" class="collapse">
                                                    <div class="row justify-content-between mx-1 my-1">
                                                        <span class="" data-toggle="tooltip" title="{{$vod->title}}">
                                                            {{ $loop->iteration }}. 
                                                            <a href="{{ route('analytics.vod.show-video', $vod->id) }}">
                                                                {{ \Illuminate\Support\Str::limit($vod->title, 35, $end='...') }}
                                                            </a>
                                                        </span>
                                                        <span class="ml-5">
                                                            <strong>
                                                                {{ $vod->registeredViews }}
                                                            </strong>
                                                        </span>
                                                    </div>
                                                    <hr class="ml-2 mr-2">
                                                </div>
                                                @if ($loop->last)
                                                    <a id="registeredViewsEnd" value="registeredViews" class="mb-2 row justify-content-center listCollapsible" href="#" data-toggle="collapse" 
                                                    data-target="#registeredViewsList" aria-expanded="false" aria-controls="registeredViewsList" style="display: none;">
                                                        <i class="fa fa-angle-double-left fa-lg mr-1 mt-1"></i>
                                                        Show Less 
                                                    </a>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                {{-- By Registered Users End --}}
                            </div>
                        </div>
                    </div>
                    {{-- Top Viewed Videos End --}}

                    <hr>                    

                    {{-- Top Page Views Start --}}
                    <div class="card bg-white shadow rounded mx-2 my-1">
                        <div class="card-header bg-white rounded py-4">
                            <h2 class="text-center m-0">
                                <span class="badge badge-info" style="font-size: 100%;">
                                    Top Page Views
                                </span>
                            </h2>
                        </div>        
                        <hr class="my-0">
                        <div class="card-body bg-white rounded mx-1 px-1">
                            <div class="row mx-1 mb-2 justify-content-center">

                                {{-- By All User Start --}}
                                <div class="card bg-white rounded mx-2 my-2">
                                    <div class="card-header pt-3">
                                        <p class="text-center">By All Users (Unique Users)</p>
                                    </div>
                                    <hr class="mt-n2 mb-2">
                                    <div class="card-body">
                                        @foreach ($allVodStats->sortByDesc('totalViews') as $vod)
                                            @if ($loop->index < 10) 
                                                <div class="row justify-content-between mx-1 my-1">
                                                    <span class="" data-toggle="tooltip" title="{{$vod->title}}">
                                                        {{ $loop->iteration }}. 
                                                        <a href="{{ route('analytics.vod.show-video', $vod->id) }}">
                                                            {{ \Illuminate\Support\Str::limit($vod->title, 35, $end='...') }}
                                                        </a>
                                                    </span>
                                                    <span class="ml-5">
                                                        <strong>
                                                            {{ $vod->totalViews }} ({{ $vod->uniqueViewsCount }})
                                                        </strong>
                                                    </span>
                                                </div>
                                                <hr class="ml-2 mr-2">
                                            @else 
                                                @if ($loop->index == 10)
                                                    <a id="totalViewsStart" value="totalViews" class="mb-2 row justify-content-center listCollapsible" href="#" data-toggle="collapse" 
                                                    data-target="#totalViewsList" aria-expanded="false" aria-controls="totalViewsList">
                                                        Show More 
                                                        <i class="fa fa-angle-double-right fa-lg ml-1 mt-1"></i>
                                                    </a>
                                                @endif
                                                <div id="totalViewsList" class="collapse">
                                                    <div class="row justify-content-between mx-1 my-1">
                                                        <span class="" data-toggle="tooltip" title="{{$vod->title}}">
                                                            {{ $loop->iteration }}. 
                                                            <a href="{{ route('analytics.vod.show-video', $vod->id) }}">
                                                                {{ \Illuminate\Support\Str::limit($vod->title, 35, $end='...') }}
                                                            </a>
                                                        </span>
                                                        <span class="ml-5">
                                                            <strong>
                                                                {{ $vod->totalViews }} ({{ $vod->uniqueViewsCount }})
                                                            </strong>
                                                        </span>
                                                    </div>
                                                    <hr class="ml-2 mr-2">
                                                </div>
                                                @if ($loop->last)
                                                    <a id="totalViewsEnd" value="totalViews" class="mb-2 row justify-content-center listCollapsible" href="#" data-toggle="collapse" 
                                                    data-target="#totalViewsList" aria-expanded="false" aria-controls="totalViewsList" style="display: none;">
                                                        <i class="fa fa-angle-double-left fa-lg mr-1 mt-1"></i>
                                                        Show Less 
                                                    </a>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                {{-- By All User End --}}
                                                
                                {{-- By Guest Users Start --}}
                                <div class="card bg-white rounded mx-2 my-2">
                                    <div class="card-header pt-3">
                                        <p class="text-center">By Guest Users</p>
                                    </div>
                                    <hr class="mt-n2 mb-2">
                                    <div class="card-body">
                                        @foreach ($allVodStats->sortByDesc('guestViews') as $vod)
                                            @if ($loop->index < 10) 
                                                <div class="row justify-content-between mx-1 my-1">
                                                    <span class="" data-toggle="tooltip" title="{{$vod->title}}">
                                                        {{ $loop->iteration }}. 
                                                        <a href="{{ route('analytics.vod.show-video', $vod->id) }}">
                                                            {{ \Illuminate\Support\Str::limit($vod->title, 35, $end='...') }}
                                                        </a>
                                                    </span>
                                                    <span class="ml-5">
                                                        <strong>
                                                            {{ $vod->guestViews }}
                                                        </strong>
                                                    </span>
                                                </div>
                                                <hr class="ml-2 mr-2">
                                            @else 
                                                @if ($loop->index == 10)
                                                    <a id="guestViewsStart" value="guestViews" class="mb-2 row justify-content-center listCollapsible" href="#" data-toggle="collapse" 
                                                    data-target="#guestViewsList" aria-expanded="false" aria-controls="guestViewsList">
                                                        Show More 
                                                        <i class="fa fa-angle-double-right fa-lg ml-1 mt-1"></i>
                                                    </a>
                                                @endif
                                                <div id="guestViewsList" class="collapse">
                                                    <div class="row justify-content-between mx-1 my-1">
                                                        <span class="" data-toggle="tooltip" title="{{$vod->title}}">
                                                            {{ $loop->iteration }}. 
                                                            <a href="{{ route('analytics.vod.show-video', $vod->id) }}">
                                                                {{ \Illuminate\Support\Str::limit($vod->title, 35, $end='...') }}
                                                            </a>
                                                        </span>
                                                        <span class="ml-5">
                                                            <strong>
                                                                {{ $vod->guestViews }}
                                                            </strong>
                                                        </span>
                                                    </div>
                                                    <hr class="ml-2 mr-2">
                                                </div>
                                                @if ($loop->last)
                                                    <a id="guestViewsEnd" value="guestViews" class="mb-2 row justify-content-center listCollapsible" href="#" data-toggle="collapse" 
                                                    data-target="#guestViewsList" aria-expanded="false" aria-controls="guestViewsList" style="display: none;">
                                                        <i class="fa fa-angle-double-left fa-lg mr-1 mt-1"></i>
                                                        Show Less 
                                                    </a>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                {{-- By Guest Users End --}}
                            </div>
                        </div>
                    </div>
                    {{-- Top Page Views End --}}

                    <hr>

                    {{-- Other Video Stats Start --}}
                    {{-- <div class="card bg-white shadow rounded mx-2 my-1">
                        <div class="card-header bg-white rounded py-4">
                            <h2 class="text-center m-0">
                                <span class="badge badge-info" style="font-size: 100%;">
                                    Other Video Stats
                                </span>
                            </h2>
                        </div>        
                        <hr class="my-0">
                        <div class="card-body bg-white rounded mx-1 px-1">
                            <div class="row mx-1 mb-2 justify-content-center"> --}}

                                {{-- Top Finishes Video Start --}}
                                {{-- <div class="card bg-white rounded mx-2 my-2">
                                    <div class="card-header pt-3">
                                        <p class="text-center">Top Finished Videos</p>
                                    </div>
                                    <hr class="mt-n2 mb-2">
                                    <div class="card-body">
                                        @foreach ($allVodStats->sortByDesc('finishes') as $vod)
                                            @if ($loop->index < 10) 
                                                <div class="row justify-content-between mx-1 my-1">
                                                    <span class="" data-toggle="tooltip" title="{{$vod->title}}">
                                                        {{ $loop->iteration }}. {{ \Illuminate\Support\Str::limit($vod->title, 35, $end='...') }}
                                                    </span>
                                                    <span class="ml-5">
                                                        <strong>
                                                            {{ $vod->finishes }}
                                                        </strong>
                                                    </span>
                                                </div>
                                                <hr class="ml-2 mr-2">
                                            @else 
                                                @if ($loop->index == 10)
                                                    <a id="topVodsByFinishesStart" value="topVodsByFinishes" class="mb-2 row justify-content-center listCollapsible" href="#" data-toggle="collapse" 
                                                    data-target="#topVodsByFinishesList" aria-expanded="false" aria-controls="topVodsByFinishesList">
                                                        Show More 
                                                        <i class="fa fa-angle-double-right fa-lg ml-1 mt-1"></i>
                                                    </a>
                                                @endif
                                                <div id="topVodsByFinishesList" class="collapse">
                                                    <div class="row justify-content-between mx-1 my-1">
                                                        <span class="" data-toggle="tooltip" title="{{$vod->title}}">
                                                            {{ $loop->iteration }}. {{ \Illuminate\Support\Str::limit($vod->title, 35, $end='...') }}
                                                        </span>
                                                        <span class="ml-5">
                                                            <strong>
                                                                {{ $vod->finishes }}
                                                            </strong>
                                                        </span>
                                                    </div>
                                                    <hr class="ml-2 mr-2">
                                                </div>
                                                @if ($loop->last)
                                                    <a id="topVodsByFinishesEnd" value="topVodsByFinishes" class="mb-2 row justify-content-center listCollapsible" href="#" data-toggle="collapse" 
                                                    data-target="#topVodsByFinishesList" aria-expanded="false" aria-controls="topVodsByFinishesList" style="display: none;">
                                                        <i class="fa fa-angle-double-left fa-lg mr-1 mt-1"></i>
                                                        Show Less 
                                                    </a>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                </div> --}}
                                {{-- Top Finishes Video End --}}
                            {{-- </div>
                        </div>
                    </div> --}}
                    {{-- Other Video Stats End --}}

                    {{-- <hr> --}}

                    {{-- Top Active Users Start --}}
                    <div class="card bg-white shadow rounded mx-2 my-1">
                        <div class="card-header bg-white rounded py-4">
                            <h2 class="text-center m-0">
                                <span class="badge badge-info" style="font-size: 100%;">
                                    Top Active Users
                                </span>
                            </h2>
                        </div>        
                        <hr class="my-0">
                        <div class="card-body bg-white rounded mx-1 px-1">
                            <div class="row mx-1 mb-2 justify-content-center">    

                                {{-- By Videos Viewed Start --}}
                                <div class="card bg-white rounded mx-2 my-2">
                                    <div class="card-header pt-3">
                                        <p class="text-center">By Videos Viewed</p>
                                    </div>
                                    <hr class="mt-n2 mb-2">
                                    <div class="card-body">
                                        @foreach ($allUserStats->sortByDesc('views')->slice(0,30) as $user)
                                            @if ($loop->index < 10) 
                                                <div class="row justify-content-between mx-1 my-1">
                                                    <span class="" data-toggle="tooltip" title="Name: {{$user->name}} &#013;&#010; First Name: {{$user->first_name}} &#013;&#010; Last Name: {{$user->last_name}} &#013;&#010; Email: {{$user->email}}">
                                                        {{ $loop->iteration }}. {{ \Illuminate\Support\Str::limit($user->name, 35, $end='...') }}
                                                    </span>
                                                    <span class="ml-5">
                                                        <strong>
                                                            {{ $user->views }}
                                                        </strong>
                                                    </span>
                                                </div>
                                                <hr class="ml-2 mr-2">
                                            @else 
                                                @if ($loop->index == 10)
                                                    <a id="topUsersByViewsStart" value="topUsersByViews" class="mb-2 row justify-content-center listCollapsible" href="#" data-toggle="collapse" 
                                                    data-target="#topUsersByViewsList" aria-expanded="false" aria-controls="topUsersByViewsList">
                                                        Show More 
                                                        <i class="fa fa-angle-double-right fa-lg ml-1 mt-1"></i>
                                                    </a>
                                                @endif
                                                <div id="topUsersByViewsList" class="collapse">
                                                    <div class="row justify-content-between mx-1 my-1">
                                                        <span class="" data-toggle="tooltip" title="Name: {{$user->name}} &#013;&#010; First Name: {{$user->first_name}} &#013;&#010; Last Name: {{$user->last_name}} &#013;&#010; Email: {{$user->email}}">
                                                            {{ $loop->iteration }}. {{ \Illuminate\Support\Str::limit($user->name, 35, $end='...') }}
                                                        </span>
                                                        <span class="ml-5">
                                                            <strong>
                                                                {{ $user->views }}
                                                            </strong>
                                                        </span>
                                                    </div>
                                                    <hr class="ml-2 mr-2">
                                                </div>
                                                @if ($loop->last)
                                                    <a id="topUsersByViewsEnd" value="topUsersByViews" class="mb-2 row justify-content-center listCollapsible" href="#" data-toggle="collapse" 
                                                    data-target="#topUsersByViewsList" aria-expanded="false" aria-controls="topUsersByViewsList" style="display: none;">
                                                        <i class="fa fa-angle-double-left fa-lg mr-1 mt-1"></i>
                                                        Show Less 
                                                    </a>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                {{-- By Videos Viewed End --}}                                

                                {{-- By Videos Finished Start --}}
                                {{-- <div class="card bg-white rounded mx-2 my-2">
                                    <div class="card-header pt-3">
                                        <p class="text-center">By Videos Finished</p>
                                    </div>
                                    <hr class="mt-n2 mb-2">
                                    <div class="card-body">
                                        @foreach ($allUserStats->sortByDesc('videoFinishes')->slice(0,30) as $user)
                                            @if ($loop->index < 10) 
                                                <div class="row justify-content-between mx-1 my-1">
                                                    <span class="" data-toggle="tooltip" title="Name: {{$user->name}} &#013;&#010; First Name: {{$user->first_name}} &#013;&#010; Last Name: {{$user->last_name}} &#013;&#010; Email: {{$user->email}}">
                                                        {{ $loop->iteration }}. {{ \Illuminate\Support\Str::limit($user->name, 35, $end='...') }}
                                                    </span>
                                                    <span class="ml-5">
                                                        <strong>
                                                            {{ $user->videoFinishes }}
                                                        </strong>
                                                    </span>
                                                </div>
                                                <hr class="ml-2 mr-2">
                                            @else 
                                                @if ($loop->index == 10)
                                                    <a id="topUsersByVideoFinishesStart" value="topUsersByVideoFinishes" class="mb-2 row justify-content-center listCollapsible" href="#" data-toggle="collapse" 
                                                    data-target="#topUsersByVideoFinishesList" aria-expanded="false" aria-controls="topUsersByVideoFinishesList">
                                                        Show More 
                                                        <i class="fa fa-angle-double-right fa-lg ml-1 mt-1"></i>
                                                    </a>
                                                @endif
                                                <div id="topUsersByVideoFinishesList" class="collapse">
                                                    <div class="row justify-content-between mx-1 my-1">
                                                        <span class="" data-toggle="tooltip" title="Name: {{$user->name}} &#013;&#010; First Name: {{$user->first_name}} &#013;&#010; Last Name: {{$user->last_name}} &#013;&#010; Email: {{$user->email}}">
                                                            {{ $loop->iteration }}. {{ \Illuminate\Support\Str::limit($user->name, 35, $end='...') }}
                                                        </span>
                                                        <span class="ml-5">
                                                            <strong>
                                                                {{ $user->videoFinishes }}
                                                            </strong>
                                                        </span>
                                                    </div>
                                                    <hr class="ml-2 mr-2">
                                                </div>
                                                @if ($loop->last)
                                                    <a id="topUsersByVideoFinishesEnd" value="topUsersByVideoFinishes" class="mb-2 row justify-content-center listCollapsible" href="#" data-toggle="collapse" 
                                                    data-target="#topUsersByVideoFinishesList" aria-expanded="false" aria-controls="topUsersByVideoFinishesList" style="display: none;">
                                                        <i class="fa fa-angle-double-left fa-lg mr-1 mt-1"></i>
                                                        Show Less 
                                                    </a>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                </div> --}}
                                {{-- By Videos Finished End --}}
                                
                            </div>
                        </div>
                    </div>
                    {{-- Top Active Users End --}}

                    <hr>
                    
                    {{-- Line Graph Start --}}
                    <div class="card bg-white shadow rounded mx-2 my-1">
                        <div class="card-body bg-white rounded m-1 p-1">  
                            {!! Form::open(array('route' => 'analytics.vod', 'method' => 'POST', 'role' => 'form', 'class' => 'needs-validation')) !!}
                                {!! csrf_field() !!}
                                <div class="row justify-content-between mt-3 mx-5">
                                    <div class="mt-2">
                                        Showing stats from: 
                                    </div>
                                    
                                    @if (isset($startDate) && isset($endDate))
                                        <div>
                                            {!! Form::input('date', 'start_date', Carbon\Carbon::parse($startDate)->format('Y-m-d'), array('id' => 'start_date', 'class' => 'form-control')) !!}
                                        </div>

                                        <div>
                                            {!! Form::input('date', 'end_date', Carbon\Carbon::parse($endDate)->format('Y-m-d'), array('id' => 'end_date', 'class' => 'form-control')) !!}
                                        </div>
                                    @else
                                        <div>
                                            {!! Form::input('date', 'start_date', Carbon\Carbon::parse($allVodStatsByDate->dates->first())->format('Y-m-d'), array('id' => 'start_date', 'class' => 'form-control')) !!}
                                        </div>

                                        <div>
                                            {!! Form::input('date', 'end_date', Carbon\Carbon::now()->format('Y-m-d'), array('id' => 'end_date', 'class' => 'form-control')) !!}
                                        </div>
                                    @endif
                                    
                                    <div class="row justify-content-end">                                
                                        {!! Form::button('Apply', array('class' => 'btn btn-success btn-submit margin-bottom-1 mt-1 mb-1 mr-3','type' => 'submit' )) !!}  
                                    </div>
                                </div>

                            {!! Form::close() !!}
                            <hr>
                            <div class="container">
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                    </div>
                    {{-- Line Graph End --}}

                    <hr>

                    {{-- Other Video Stats Start --}}
                    <div class="card bg-white shadow rounded mx-2 my-1">
                        <div class="card-body bg-white rounded mx-1 px-1">
                            <div class="row mx-1 mb-2 justify-content-center">
                                <div class="col-6">
                                    <a href="{{ route('analytics.vod.showAllVodStats') }}" class="btn btn-info btn-block btn-lg">
                                        Show All Video Stats
                                        <i class="fa fa-angle-double-right fa-lg ml-1 mt-1"></i>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('analytics.vod.showAllUserStats') }}" class="btn btn-info btn-block btn-lg">
                                        Show All Active User Stats
                                        <i class="fa fa-angle-double-right fa-lg ml-1 mt-1"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="row mx-1 mb-2 justify-content-center">
                                <div class="col-6">
                                    <a href="{{ route('analytics.users') }}" class="btn btn-info btn-block btn-lg">
                                        Show All Daily Registrant and Enrollee Stats
                                        <i class="fa fa-angle-double-right fa-lg ml-1 mt-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Other Video Stats End --}}                    
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer_scripts')
    @include('scripts.tooltips')
    {{-- @include('scripts.search-users') --}}
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        
            $('.listCollapsible').click(function (e) {
                var target = e.target;
                var targetValue = target.getAttribute("value");
                var targetID = target.getAttribute("id");
                // console.log(targetID);           

                if (targetID == (targetValue +"Start")) {
                    console.log("on");            
                    $('#' + targetValue + 'Start').css("display", "none");  
                    $('#' + targetValue + 'End').css("display", "flex");  
                } else if (targetID == (targetValue + "End")) {
                    console.log("off");            
                    $('#' + targetValue + 'Start').css("display", "flex");  
                    $('#' + targetValue + 'End').css("display", "none");  
                }    
            });
        });   
        
        $("#reply-spinner").on('click', function(e) {
            $("#reply-spinner").css("display", "inline-block");
        });
    </script>
    @include('scripts.analytics-blackbox-graph')
@endsection
