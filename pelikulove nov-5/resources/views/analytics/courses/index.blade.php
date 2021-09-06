@extends('layouts.app')

@section('template_title')
    Courses Analytics
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
                                        Courses Analytics
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

                    {{-- <div class="card bg-white shadow rounded mx-2 my-1"> --}}
                        <div class="row mx-1 mb-2 justify-content-center">

                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                <h4 class="text-center">
                                    Total Students
                                </h4>
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Lifetime
                                        <span class="badge badge-success badge-pill"> 
                                            {{ $data->allStudents->count() }}
                                        </span>
                                    </li>   
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Currently Enrolled Students
                                        <span class="badge badge-success badge-pill"> 
                                            {{ $data->allEnrolledStudents->count() }}
                                        </span>
                                    </li>  
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Total Paid Students
                                        <span class="badge badge-success badge-pill"> 
                                            {{ $data->allPaidStudents->count() }}
                                        </span>
                                    </li>                                       
                                </ul>                                
                            </div>                            

                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                <h4 class="text-center">
                                    Total Active Students
                                </h4>
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Within 3 Days
                                        <span class="badge badge-success badge-pill"> 
                                            {{ $data->allActiveStudents3D->count() }}
                                        </span>
                                    </li>   
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Within 1 Week
                                        <span class="badge badge-success badge-pill"> 
                                            {{ $data->allActiveStudents1W->count() }}
                                        </span>
                                    </li>   
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Within 3 Weeks
                                        <span class="badge badge-success badge-pill"> 
                                            {{ $data->allActiveStudents3W->count() }}
                                        </span>
                                    </li>                                      
                                </ul>                                
                            </div>                         

                            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                <h4 class="text-center">
                                    Student Activity
                                </h4>
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Total Comments
                                        <span class="badge badge-success badge-pill"> 
                                            {{ $data->allComments->count() }}
                                        </span>
                                    </li>    
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Total Submissions
                                        <span class="badge badge-success badge-pill"> 
                                            {{ $data->allSubmissions->count() }}
                                        </span>
                                    </li>                                     
                                </ul>                                
                            </div>                              
                        </div>  
                    {{-- </div>                   --}}
                       
                    <hr>
                    
                    <div class="card bg-white shadow rounded mx-2 my-1">
                        <div class="card-header bg-white rounded py-4">
                            <h2 class="text-center m-0">
                                <span class="badge badge-info" style="font-size: 100%;">
                                    All Courses
                                </span>
                            </h2>
                        </div>        
                        <hr class="my-0">
                        <div class="card-body bg-white rounded mx-1 px-1">
                            <div class="row mx-1 mb-2 justify-content-center">
        
                                @foreach ($data->allCourses as $course)
                                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12 my-2">
                                        <div class="card row justify-content-center mx-1">
                                            <div class="row justify-content-center py-4">
                                                <h4 class="col-12 text-center">
                                                    <strong>
                                                        {{ $course->short_title }}
                                                    </strong>
                                                </h4>	
                                                
                                                <a href="{{ route('analytics.course', $course->id) }}" class="">	
                                                    <button class="btn mt-2 mb-2 text-light" role="button"
                                                    style="background-color: indianred"> 	
                                                        <strong>
                                                            View Course
                                                        </strong>
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach                                  
                            </div>                         
                        </div>  
                    </div>        

                    <hr>

                    {{-- Top Viewed Lessons Start --}}
                    <div class="card bg-white shadow rounded mx-2 my-1">
                        <div class="card-header bg-white rounded py-4">
                            <h2 class="text-center m-0">
                                <span class="badge badge-info" style="font-size: 100%;">
                                    Top Viewed Lessons and Topics
                                </span>
                            </h2>
                        </div>        
                        <hr class="my-0">
                        <div class="card-body bg-white rounded mx-1 px-1">
                            <div class="row mx-1 mb-2 justify-content-center">

                                {{-- By Top Views Lessons Start --}}
                                <div class="card bg-white rounded mx-2 my-2">
                                    <div class="card-header pt-3">
                                        <p class="text-center">Top Viewed Lessons</p>
                                    </div>
                                    <hr class="mt-n2 mb-2">
                                    <div class="card-body">
                                        @foreach ($data->allLessons->sortByDesc('totalViews')->slice(0, 30) as $lesson)
                                            @php
                                                $lesson2 = \App\Models\Lesson::find($lesson->id);
                                                if (!isset($lesson2->course()->first()->title)) {
                                                    dd($lesson2->course()->first());
                                                }
                                            @endphp
                                            @if ($loop->index < 10) 
                                                <div class="row justify-content-between mx-1 my-1">
                                                    <span class="" data-toggle="tooltip" title="{{$lesson2->course()->first()->title}}">
                                                        {{ $loop->iteration }}. 
                                                        <a href="{{ url('lesson/' . $lesson->id. '/topic/' . $lesson2->topics()->first()->id . '/show') }}" target="_blank">
                                                            {{ \Illuminate\Support\Str::limit($lesson->title, 35, $end='...') }}
                                                        </a>
                                                    </span>
                                                    <span class="ml-5">
                                                        <strong>
                                                            {{ $lesson->totalViews }}
                                                        </strong>
                                                    </span>
                                                </div>
                                                <hr class="ml-2 mr-2">
                                            @else 
                                                @if ($loop->index == 10)
                                                    <a id="lessonViewsStart" value="lessonViews" class="mb-2 row justify-content-center listCollapsible" href="#" data-toggle="collapse" 
                                                    data-target="#lessonViewsList" aria-expanded="false" aria-controls="lessonViewsList">
                                                        Show More 
                                                        <i class="fa fa-angle-double-right fa-lg ml-1 mt-1"></i>
                                                    </a>
                                                @endif
                                                <div id="lessonViewsList" class="collapse">
                                                    <div class="row justify-content-between mx-1 my-1">
                                                        <span class="" data-toggle="tooltip" title="{{$lesson2->course()->first()->title}}">
                                                            {{ $loop->iteration }}. 
                                                            <a href="{{ url('lesson/' . $lesson->id. '/topic/' . $lesson2->topics()->first()->id . '/show') }}" target="_blank">
                                                                {{ \Illuminate\Support\Str::limit($lesson->title, 35, $end='...') }}
                                                            </a>
                                                        </span>
                                                        <span class="ml-5">
                                                            <strong>
                                                                {{ $lesson->totalViews }}
                                                            </strong>
                                                        </span>
                                                    </div>
                                                    <hr class="ml-2 mr-2">
                                                </div>
                                                @if ($loop->last)
                                                    <a id="lessonViewsEnd" value="lessonViews" class="mb-2 row justify-content-center listCollapsible" href="#" data-toggle="collapse" 
                                                    data-target="#lessonViewsList" aria-expanded="false" aria-controls="lessonViewsList" style="display: none;">
                                                        <i class="fa fa-angle-double-left fa-lg mr-1 mt-1"></i>
                                                        Show Less 
                                                    </a>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                {{-- By Top Views Lessons End --}}

                                {{-- By Top Views Topics Start --}}
                                <div class="card bg-white rounded mx-2 my-2">
                                    <div class="card-header pt-3">
                                        <p class="text-center">Top Viewed Topics</p>
                                    </div>
                                    <hr class="mt-n2 mb-2">
                                    <div class="card-body">
                                        @foreach ($data->allTopics->sortByDesc('totalViews')->slice(0, 30) as $topic)
                                            @php
                                                $lesson = \App\Models\Lesson::find($topic->lesson_id);
                                                $course = \App\Models\Course::find($lesson->course_id);
                                            @endphp
                                            @if ($loop->index < 10) 
                                                <div class="row justify-content-between mx-1 my-1">
                                                    <span class="" data-toggle="tooltip" data-html="true" title="{{$course->title}} <br> {{$lesson->title}}">
                                                        {{ $loop->iteration }}. 
                                                        <a href="{{ url('lesson/' . $topic->lesson_id. '/topic/' . $topic->id . '/show') }}" target="_blank">
                                                            {{ \Illuminate\Support\Str::limit($topic->title, 35, $end='...') }}
                                                        </a>
                                                    </span>
                                                    <span class="ml-5">
                                                        <strong>
                                                            {{ $topic->totalViews }}
                                                        </strong>
                                                    </span>
                                                </div>
                                                <hr class="ml-2 mr-2">
                                            @else 
                                                @if ($loop->index == 10)
                                                    <a id="topicViewsStart" value="topicViews" class="mb-2 row justify-content-center listCollapsible" href="#" data-toggle="collapse" 
                                                    data-target="#topicViewsList" aria-expanded="false" aria-controls="topicViewsList">
                                                        Show More 
                                                        <i class="fa fa-angle-double-right fa-lg ml-1 mt-1"></i>
                                                    </a>
                                                @endif
                                                <div id="topicViewsList" class="collapse">
                                                    <div class="row justify-content-between mx-1 my-1">
                                                        <span class="" data-toggle="tooltip" data-html="true" title="{{$course->title}} <br> {{$lesson->title}}">
                                                            {{ $loop->iteration }}. 
                                                            <a href="{{ url('lesson/' . $topic->lesson_id. '/topic/' . $topic->id . '/show') }}" target="_blank">
                                                                {{ \Illuminate\Support\Str::limit($topic->title, 35, $end='...') }}
                                                            </a>
                                                        </span>
                                                        <span class="ml-5">
                                                            <strong>
                                                                {{ $topic->totalViews }}
                                                            </strong>
                                                        </span>
                                                    </div>
                                                    <hr class="ml-2 mr-2">
                                                </div>
                                                @if ($loop->last)
                                                    <a id="topicViewsEnd" value="topicViews" class="mb-2 row justify-content-center listCollapsible" href="#" data-toggle="collapse" 
                                                    data-target="#topicViewsList" aria-expanded="false" aria-controls="topicViewsList" style="display: none;">
                                                        <i class="fa fa-angle-double-left fa-lg mr-1 mt-1"></i>
                                                        Show Less 
                                                    </a>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                {{-- By Top Views Topics End --}}
                            </div>
                        </div>
                    </div>
                    {{-- Top Viewed Lessons End --}}

                    {{-- Top Active Students Start --}}
                    {{-- <div class="card bg-white shadow rounded mx-2 my-1">
                        <div class="card-header bg-white rounded py-4">
                            <h2 class="text-center m-0">
                                <span class="badge badge-info" style="font-size: 100%;">
                                    Top Active Students
                                </span>
                            </h2>
                        </div>        
                        <hr class="my-0">
                        <div class="card-body bg-white rounded mx-1 px-1">
                            <div class="row mx-1 mb-2 justify-content-center">

                                <div class="card bg-white rounded mx-2 my-2">
                                    <div class="card-header pt-3">
                                        <p class="text-center">Within 3 Days</p>
                                    </div>
                                    <hr class="mt-n2 mb-2">
                                    <div class="card-body">
                                        @php
                                            $data = $data->allActiveStudents3D->first();
                                        @endphp
                                        @if (isset($data))
                                            @foreach ($data->allActiveStudents3D->sortByDesc('lastlogin')->slice(0, 30) as $user)
                                                @if ($loop->index < 10) 
                                                    <div class="row justify-content-between mx-1 my-1">
                                                        <span class="" data-toggle="tooltip" title="Name: {{$user->name}} &#013;&#010; First Name: {{$user->first_name}} &#013;&#010; Last Name: {{$user->last_name}} &#013;&#010; Email: {{$user->email}}">
                                                            {{ $loop->iteration }}. {{ \Illuminate\Support\Str::limit($user->name, 35, $end='...') }}
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
                                                            <span class="" data-toggle="tooltip" title="Name: {{$user->name}} &#013;&#010; First Name: {{$user->first_name}} &#013;&#010; Last Name: {{$user->last_name}} &#013;&#010; Email: {{$user->email}}">
                                                                {{ $loop->iteration }}. {{ \Illuminate\Support\Str::limit($user->name, 35, $end='...') }}
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
                                        @else
                                            No activity yet
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="card bg-white rounded mx-2 my-2">
                                    <div class="card-header pt-3">
                                        <p class="text-center">Within 1 Week</p>
                                    </div>
                                    <hr class="mt-n2 mb-2">
                                    <div class="card-body">
                                        @foreach ($data->allActiveStudents1W->sortByDesc('lastlogin')->slice(0, 30) as $user)
                                            @if ($loop->index < 10) 
                                                <div class="row justify-content-between mx-1 my-1">
                                                    <span class="" data-toggle="tooltip" title="Name: {{$user->name}} &#013;&#010; First Name: {{$user->first_name}} &#013;&#010; Last Name: {{$user->last_name}} &#013;&#010; Email: {{$user->email}}">
                                                        {{ $loop->iteration }}. {{ \Illuminate\Support\Str::limit($user->name, 35, $end='...') }}
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
                                                        <span class="" data-toggle="tooltip" title="Name: {{$user->name}} &#013;&#010; First Name: {{$user->first_name}} &#013;&#010; Last Name: {{$user->last_name}} &#013;&#010; Email: {{$user->email}}">
                                                            {{ $loop->iteration }}. {{ \Illuminate\Support\Str::limit($user->name, 35, $end='...') }}
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
                                
                                <div class="card bg-white rounded mx-2 my-2">
                                    <div class="card-header pt-3">
                                        <p class="text-center">Within 3 Weeks</p>
                                    </div>
                                    <hr class="mt-n2 mb-2">
                                    <div class="card-body">
                                        @foreach ($data->allActiveStudents3W->sortByDesc('lastlogin')->slice(0, 30) as $user)
                                            @if ($loop->index < 10) 
                                                <div class="row justify-content-between mx-1 my-1">
                                                    <span class="" data-toggle="tooltip" title="Name: {{$user->name}} &#013;&#010; First Name: {{$user->first_name}} &#013;&#010; Last Name: {{$user->last_name}} &#013;&#010; Email: {{$user->email}}">
                                                        {{ $loop->iteration }}. {{ \Illuminate\Support\Str::limit($user->name, 35, $end='...') }}
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
                                                        <span class="" data-toggle="tooltip" title="Name: {{$user->name}} &#013;&#010; First Name: {{$user->first_name}} &#013;&#010; Last Name: {{$user->last_name}} &#013;&#010; Email: {{$user->email}}">
                                                            {{ $loop->iteration }}. {{ \Illuminate\Support\Str::limit($user->name, 35, $end='...') }}
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
                                
                            </div>
                        </div> 
                    </div> --}}
                    {{-- Top Active Students End --}}

                    <hr>

                    {{-- Viewing Log Table --}}
                    <div class="card bg-white shadow rounded mx-2 my-1">
                        <div class="card-header bg-white rounded py-3">
                            <h2 class="text-center">
                                <span class="badge badge-info" style="font-size: 100%;">
                                    Enrollments
                                </span>
                            </h2>
                        </div>        
                        <hr class="my-0">
                        <div class="card-body">                       

                            <div class="table-responsive analytics-table">
                                <table class="table table-striped table-sm data-table">
                                    <caption id="user_count">
                                        {{ $data->allStudents->count() }} Enrollments Total
                                    </caption>
                                    <thead class="thead">
                                        <tr>
                                            <th class="text-nowrap">Date</th>
                                            <th class="text-nowrap hidden-sm hidden-xs hidden-md">Course</th>
                                            <th class="text-nowrap hidden-lg hidden-xl">Course</th>
                                            <th class="text-nowrap">Username</th>  
                                            <th class="text-nowrap hidden-sm hidden-xs hidden-md">First Name</th>
                                            <th class="text-nowrap hidden-sm hidden-xs hidden-md">Last Name</th>
                                            <th class="text-nowrap">Service</th>   
                                            <th class="text-nowrap">Duration</th>       
                                            <th class="text-nowrap">Status</th>       
                                            {{-- <th class="text-nowrap">Finishes</th>              --}}
                                        </tr>
                                    </thead>
                                    <tbody id="analytics_table">
                                        @foreach($data->allStudents->sortByDesc('learnercourse_created_at') as $enrollment)
                                            <tr class="table-hoverable">
                                                <td>{{ Carbon\Carbon::parse($enrollment->learnercourse_created_at)->format('Y-m-d') }}</td>    
                                                <td class="hidden-sm hidden-xs hidden-md">{{ $enrollment->title }}</td>    
                                                <td class="hidden-lg hidden-xl">{{ $enrollment->short_title }}</td>      
                                                <td>{{ $enrollment->username }}</td> 
                                                <td class="hidden-sm hidden-xs hidden-md">{{ $enrollment->first_name }}</td> 
                                                <td class="hidden-sm hidden-xs hidden-md">{{ $enrollment->last_name }}</td> 
                                                <td>{{ $enrollment->service_name }}</td>    
                                                <td>{{ $enrollment->duration }}</td>         	
                                                <td>{{ $enrollment->status }}</td>       	
                                                {{-- <td class="text-nowrap hidden-sm hidden-xs hidden-md">                                                    
                                                    <a href="{{ route('analytics.vod.show-video', $enrollment->id) }}">
                                                        {{ \Illuminate\Support\Str::limit($enrollment->title, 35, $end='...') }}
                                                    </a>
                                                </td>
                                                <td class="text-nowrap hidden-lg hidden-xl">{{ \Illuminate\Support\Str::limit($enrollment->title, 20, $end='...') }}</td> --}}
                                                    	
                                                {{-- <td>{{ $enrollment->finishes }}</td>       		                                       --}}
                                            </tr>
                                        @endforeach
                                    </tbody>

                                    <tbody id="search_results"></tbody>

                                </table>

                            </div>
                        </div>
                    </div>
                    
                    {{-- Line Graph Start --}}
                    {{-- <div class="card bg-white shadow rounded mx-2 my-1">
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
                    </div> --}}
                    {{-- Line Graph End --}}

                    {{-- <hr> --}}

                    {{-- Other Video Stats Start --}}
                    {{-- <div class="card bg-white shadow rounded mx-2 my-1">
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
                    </div> --}}
                    {{-- Other Video Stats End --}}                    
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer_scripts')
    @include('scripts.datatables')
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
    </script>
    {{-- @include('scripts.analytics-blackbox-graph') --}}
@endsection
