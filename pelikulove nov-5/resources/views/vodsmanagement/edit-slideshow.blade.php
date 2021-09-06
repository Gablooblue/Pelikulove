@extends('layouts.app')
		
@section('template_title')
    Edit Blackbox Slideshow
@endsection

@section('template_fastload_css')
@endsection

@section('content')
    <div class="container">  
        <div class="row d-flex flex-row">
            <div class="card shadow bg-white rounded">
                <div class="card-header bg-secondary text-white text-md-left">
                    <div class="row d-flex justify-content-between ml-2 mr-2">      
                        <h3>
                            Edit Blackbox Slideshow
                        </h3>
                        <div class="pull-right pt-1">
                            <a href="{{ url('/blackbox-admin') }}" class="btn btn-light btn-sm float-right" data-toggle="tooltip" data-placement="left" title="Back to Blackbox Admin">
                                <i class="fa fa-fw fa-reply" aria-hidden="true"></i>
                                <span class="hidden-sm hidden-xs">Back to </span>
                                <span class="hidden-xs">Blackbox Admin</span>
                            </a>
                        </div>
                    </div>
                </div>
                    
                {{-- Category Start --}}    
                <div class="card-body">	   
                    <div class="card shadow bg-white rounded">  
                        <div class="card-header">   
                        <h4 class="text-center">
                            <strong>
                                Blackbox Slideshows
                            </strong>     
                            <div class="btn-group pull-right btn-group-xs mt-n2 mr-2">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                                    <span class="sr-only">
                                    Show Slideshows Admin Menu
                                    </span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">
                                    <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                                    Create New Slideshow
                                    </a>
                                    <a class="dropdown-item" href="#">
                                    <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                                    Rearrange Slideshows
                                    </a>
                                </div>
                            </div>                                     
                        </h4>
                        <hr>
                        </div>
                        <div class="d-flex flex-row mt-n4">    
                        @if (count($vodSlideshows ) > 0)
                            <div class="card-body">
                            @foreach ($vodSlideshows as $vodSlideshow)
                                <div class="card lesson-card mb-3 bg-white rounded">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <h3 class="mb-2">                                                        
                                                    <strong>
                                                        Slideshow {{ $vodSlideshow->order }}: 
                                                    </strong>   
                                                    {{ $vodSlideshow->name }}
                                                    <div class="btn-group pull-right btn-group-xs mt-n2 mr-2">
                                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                                                            <span class="sr-only">
                                                            Show Slideshow Admin Menu
                                                            </span>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="#">
                                                            <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                                                            Edit Slideshow
                                                            </a>
                                                            <a class="dropdown-item" href="#">
                                                            <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                                                            Delete Slideshow
                                                            </a>
                                                        </div>
                                                    </div>    
                                                    <hr>
                                                    <img class="d-block" style="max-width: 100%;" 
                                                    src="{{ asset('images/slideshows/' . $vodSlideshow->thumbnail) }}" alt="{{ $vodSlideshow->thumbnail }}">
                                                </h3>
                                            </div>          
                                        </div>  
                                        {{-- <hr>   
                                        <div class="row ml-1 mr-1 mt-3">
                                            <a class="btn btn-block btn-info" 
                                            href="{{ url('/vod-admin/category/' . $vodSlideshow->id) }}" role="button">
                                                Remove Category
                                            </a>
                                        </div> --}}
                                    </div> <!--card-body-->
                                </div> <!--card-->
                            @endforeach
                            </div> <!--card-body-->
                        @endif
                        </div>
                    </div><!--card-->
                </div><!--card-body-->
                {{-- Category End --}} 
            </div><!--card-->     
        </div>	<!-- row -->	 
    </div><!-- container -->
@endsection

@section('footer_scripts')

@endsection
