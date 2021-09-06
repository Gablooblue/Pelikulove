@extends('layouts.app')
		
@section('template_title')
   Showing Blackbox Category: {{ $vodCategory->name }}
@endsection

@section('template_fastload_css')
@endsection

@section('videocss')
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel='stylesheet' href='https://unpkg.com/plyr@3/dist/plyr.css'> --}}
@endsection

@section('content')
    <div class="container">  
        <div class="row d-flex flex-row">
            <div class="card shadow bg-white rounded w-100">
                <div class="card-header bg-secondary text-white text-md-left">
                    <div class="row d-flex justify-content-between ml-2 mr-2">      
                        <h3>
                            Showing Blackbox Category: {{ $vodCategory->name }}
                        </h3>
                        <div class="pull-right">
                            <a href="{{ url('blackbox-admin') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="Back to Blackbox Admin">
                                <i class="fa fa-fw fa-reply" aria-hidden="true"></i>
                                <span class="hidden-sm hidden-xs">Back to </span>
                                <span class="hidden-xs">Blackbox Admin</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Category Description Start --}}
                <div class="card-body">	   
                    <div class="card shadow bg-white rounded">  
                        <div class="card-header">   
                        <h4 class="text-center">
                            <strong>
                            Category Information
                            </strong>                                        
                        </h4>
                        <hr>
                        </div>
                        <div class="d-flex flex-row mt-n4">  
                            <div class="card-body">
                                <div class="card lesson-card mb-3 bg-white rounded">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <h3 class="mb-2"> 
                                                    <strong>
                                                        Category {{ $vodCategory->corder }}
                                                    </strong>
                                                    <div class="btn-group pull-right btn-group-xs mt-n2 mr-2">
                                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                                                            <span class="sr-only">
                                                                Show Category Admin Menu
                                                            </span>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="/blackbox-admin/category/edit/{{ $vodCategory->id }}">
                                                                <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                                                                Edit Category
                                                            </a>
                                                        </div>
                                                    </div>     
                                                    <hr>
                                                </h3>
                                                <h3>
                                                    {{ $vodCategory->name }} 
                                                    @if ($vodCategory->hidden == 1)
                                                        <span class="badge badge-secondary ml-2">
                                                            Unlisted
                                                        </span>
                                                    @endif
                                                </h3>
                                                <p class="pt-2">
                                                    {!! $vodCategory->description !!} 
                                                </p>
                                                @php 
                                                    $categoryVods = \App\Models\Vod::getAllVodsByCategory($vodCategory->id);
                                                @endphp
                                                @if (sizeOf($categoryVods) > 1)
                                                    {{ sizeOf($categoryVods) }} Vods &raquo;
                                                @else 
                                                    {{ sizeOf($categoryVods) }} Vod &raquo;
                                                @endif  
                                            </div>
                                        </div>  
                                    </div> <!--card-body-->
                                </div> <!--card-->
                            </div> <!--card-body-->
                        </div>
                    </div><!--card-->
                </div><!--card-body-->
                {{-- Category Description End --}}
                    
                @if (count($categoryVods) > 0)
                    {{-- Vod Start --}}    
                    <div class="card-body">	   
                        <div class="card shadow bg-white rounded">  
                            <div class="card-header">   
                            <h4 class="text-center">
                                <strong>
                                    Category Blackbox's Information
                                </strong>     
                                <div class="btn-group pull-right btn-group-xs mt-n2 mr-2">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                                    <span class="sr-only">
                                        Show Blackbox Admin Menu
                                    </span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{ route('vodsmanagement.createVod', $vodCategory->id) }}">
                                        <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                                        Add New Video
                                    </a>
                                    <a class="dropdown-item" href="{{ route('vodsmanagement.rearrangeCategoryVods', $vodCategory->id) }}">
                                        <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                                        Rearrange Blackbox
                                    </a>
                                </div>
                                </div>                                     
                            </h4>
                            <hr>
                            </div>
                            <div class="d-flex flex-row mt-n4">    
                            @if (count($categoryVods ) > 0)
                                <div class="card-body">
                                @foreach ($categoryVods as $vod)
                                    <div class="card lesson-card mb-3 bg-white rounded">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="container">
                                                    <h3 class="mb-2">                                                        
                                                        <strong>
                                                            Blackbox {{ $vod->vorder }}
                                                        </strong>
                                                        <div class="btn-group pull-right btn-group-xs mt-n2 mr-2">
                                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                                                            <span class="sr-only">
                                                            Show Blackbox Admin Menu
                                                            </span>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item btn" href="/blackbox-admin/category/{{ $vodCategory->id }}/vod/edit/{{ $vod->id }}">
                                                            <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                                                            Edit Video
                                                            </a>   

                                                            @if (!\App\Models\VodPurchase::ifVodIDIsUsed($vod->id))                                                           
                                                            {!! Form::open(array('url' => '/blackbox-admin/category/' . $vodCategory->id . '/vod/remove/' . $vod->id, 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Delete')) !!}
                                                                {!! Form::hidden('_method', 'DELETE') !!}
                                                                {!! Form::button(
                                                                    '<i class="fa fa-trash fa-fw" aria-hidden="true"></i>  
                                                                    <span class="hidden-xs hidden-sm">Delete</span>
                                                                    <span class="hidden-xs hidden-sm hidden-md"> Vod</span>'
                                                                    , array('class' => 'btn btn-danger dropdown-item bg-warning','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete Vod', 'data-message' => 'Are you sure you want to delete this Vod ?')) !!}
                                                            {!! Form::close() !!}
                                                            @endif
                                                        </div>
                                                        </div>     
                                                        <hr>
                                                    </h3>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <img class="" src="{{ asset('images/vods/'.$vod->thumbnail) }}"
                                                                style="border-radius:10px; max-width: 102%;" alt="{{ $vod->short_title }}">

                                                            {{-- <div class="">

                                                            </div> --}}
                                                            <button class="btn btn-primary btn-block rounded mx-1 mt-2" type="button" data-toggle="collapse" 
                                                            data-target="#vod_{{ $vod->id }}" aria-expanded="false" aria-controls="vod_{{ $vod->id }}"
                                                            id="vod_btn_{{ $vod->id }}">
                                                                Show Video
                                                            </button>
                                                        </div>
                                                        <div class="col-8">
                                                            <h3>
                                                                <a href="{{ url('blackbox/' . $vod->id . '/watch') }}" target="_blank">
                                                                    {{ $vod->short_title }} 
                                                                </a>                                                                
                                                                @if (isset($vod->duration))    
                                                                    <span class="small">
                                                                        <span class="badge badge-secondary ml-2">
                                                                            {{ $vod->duration }} mins
                                                                        </span>
                                                                    </span> 
                                                                @endif
                                                            </h3> 
                                                            <p class="pt-2 mb-0 pb-0">
                                                                {!! $vod->description !!} 
                                                            </p>  
                                                            <div class="pt-2 pl-2 row mb-0 pb-0"> 
                                                                <h4 class="mb-0 pb-0">
                                                                    @if ($vod->paid == 0)     
                                                                        <span class="badge badge-primary ml-2">
                                                                            Free
                                                                        </span>
                                                                    @else     
                                                                        <span class="badge badge-danger ml-2">
                                                                            Paid
                                                                        </span>
                                                                    @endif
                                                                    {{-- @if (isset($vod->maturity_rating))     
                                                                        <span class="badge badge-warning ml-2">
                                                                            {{ $vod->maturity_rating }}
                                                                        </span>
                                                                    @endif --}}
                                                                    @if (isset($vod->year_released))     
                                                                        <span class="badge badge-info ml-2">
                                                                            {{ $vod->year_released }}
                                                                        </span>
                                                                    @endif
                                                                    @if ($vod->hidden)     
                                                                        <span class="badge badge-warning ml-2">
                                                                            Unlisted
                                                                        </span>
                                                                    @endif
                                                                    @if ($vod->private)     
                                                                        <span class="badge badge-danger ml-2">
                                                                            Private
                                                                        </span>
                                                                    @endif
                                                                    @if ($vod->donate_btn)     
                                                                        <span class="badge badge-success ml-2">
                                                                            Donate Button
                                                                        </span>
                                                                    @endif
                                                                </h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="vod_{{ $vod->id }}" class="collapse">
                                                        <hr>
                                                        <div class="row d-flex justify-content-center"> 
                                                            {{-- <video id="video-frame" controls playsinline 
                                                            poster="https://learn.pelikulove.com/images/obb.png">
                                                            </video> --}}                                                    
                                                            <video style="max-width: 95%;" controls playsinline controlsList="nodownload"
                                                            oncontextmenu="return false;"
                                                            poster="{{ asset('images/vods/'.$vod->thumbnail) }}">
                                                                <source src="{{ $vod->video }}" />
                                                            </video>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>  
                                            <hr>   
                                            <div class="row ml-1 mr-1 mt-3">
                                                <a class="btn btn-block btn-info" 
                                                href="{{ url('blackbox-admin/category/' . $vodCategory->id . '/vod/edit/' . $vod->id ) }}" role="button">
                                                    Edit Video 
                                                </a>
                                            </div>
                                            @if ($vod->paid)
                                                <div class="row ml-1 mr-1 mt-1">
                                                    <a class="btn btn-block btn-info" 
                                                    href="{{ url('blackbox-admin/category/' . $vodCategory->id . '/vod/' . $vod->id . '/services') }}" role="button">
                                                        Show Services 
                                                    </a>
                                                </div>
                                            @endif
                                            
                                        </div> <!--card-body-->
                                    </div> <!--card-->
                                @endforeach
                                </div> <!--card-body-->
                            @endif
                            </div>
                        </div><!--card-->
                    </div><!--card-body-->
                    {{-- Vod End --}} 
                @else                     
                    <div class="card-body">	   
                        <div class="card shadow bg-white rounded">  
                            <div class="card-header">   
                            <h4 class="text-center">
                                <strong>
                                    Category Blackbox's Videos
                                </strong>      
                                <div class="btn-group pull-right btn-group-xs mt-n2 mr-2">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                                    <span class="sr-only">
                                        Show Blackbox Admin Menu
                                    </span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{ route('vodsmanagement.createVod', $vodCategory->id) }}">
                                        <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                                        Add New Video
                                    </a>
                                </div>
                                </div>                                      
                            </h4>
                            <hr>
                            <div class="card-body">
                                <h2 class="text-center m-0">
                                    <span class="badge badge-info" style="font-size: 100%;">
                                        No Videos yet
                                    </span>
                                </h2>
                            </div> 
                        </div> 
                    </div> 
                @endif

            </div><!--card-->     
        </div>	<!-- row -->	 
    </div><!-- container -->

    @include('modals.modal-delete')
@endsection

@section('videojs2')

    {{-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src='https://cdn.polyfill.io/v2/polyfill.min.js?features=es6,Array.prototype.includes,CustomEvent,Object.entries,Object.values,URL'></script>
	<script src='https://unpkg.com/plyr@3'></script>

	@include('scripts.show-video-vod')

	<script src="{{ asset('/js/moment.js') }}"></script> --}}

@endsection	

@section('footer_scripts')
    @include('scripts.delete-modal-script')

    <script>
        $(document).ready(function(){     
                   
            @if (count($categoryVods ) > 0)
                @foreach ($categoryVods as $vod)

                    $('#vod_{{ $vod->id }}').on('show.bs.collapse', function (e) {
                        console.log('show collapse body ' + {{ $vod->id }});
                        $("#vod_btn_{{ $vod->id }}").html("Hide Video");
                        console.log($("#vod_btn_{{ $vod->id }}").html());
                    });

                    $('#vod_{{ $vod->id }}').on('hide.bs.collapse', function (e) {
                        console.log('hide collapse body ' + {{ $vod->id }});
                        $("#vod_btn_{{ $vod->id }}").html("Show Video");
                        console.log($("#vod_btn_{{ $vod->id }}").html());
                    });

                    
                @endforeach
            @endif

        });
    </script>

@endsection
