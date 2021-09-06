@extends('layouts.app')
		
@section('template_title')
Blackbox Administration
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
                            Blackbox Administration
                        </h3>
                    </div>
                </div>

                {{-- Carousel Start --}}
                {{-- <div class="card-body">	
                    <div class="card shadow bg-white rounded">
                        <div class="card-header">   
                            <h4 class="text-center">
                                <strong>
                                Carousel Slides
                                </strong>                    
                            </h4>
                            <hr>
                        </div>
                        <div class="d-flex flex-row mt-n4">
                            <div class="card-body">
                                <div class="row m-1">
                                    <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner">
                                            @for ($index = 0; $index < sizeOf($vodSlideshows); $index++)                                            
                                                <div class="carousel-item @if ($index == 0) active @endif">
                                                    <img class="d-block" style="max-width: 100%;" 
                                                    src="{{ asset('images/slideshows/' . $vodSlideshows[$index]->thumbnail) }}" alt="Slide {{ $vodSlideshows[$index]->thumbnail }}">
                                                </div>
                                            @endfor

                                            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                            
                                            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </div>
                                    </div>  
                                </div>   
                                <hr>
                                <div class="row m-1 mt-2">
                                    <a class="btn btn-block btn-info" href="{{ url('/blackbox-admin/slideshow/edit') }}" role="button">
                                        Edit Carousel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div> <!--card-->
                </div> <!--card-body-->    --}}
                {{-- Carousel End --}}   
                    
                {{-- Category Start --}}    
                <div class="card-body">	   
                    <div class="card shadow bg-white rounded">  
                        <div class="card-header">   
                        <h4 class="text-center">
                            <strong>
                            Categories' Information
                            </strong>     
                            <div class="btn-group pull-right btn-group-xs mt-n2 mr-2">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                                <span class="sr-only">
                                Show Categories Admin Menu
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{ route('vodsmanagement.createCategory') }}">
                                    <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                                    Add New Category
                                </a>
                                <a class="dropdown-item" href="{{ route('vodsmanagement.rearrangeCategory') }}">
                                    <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                                    Rearrange Categories
                                </a>
                                <a class="dropdown-item" href="{{ route('vodsmanagement.createVod', $vodCategories[0]->id) }}">
                                    <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                                    Add New Video
                                </a>
                            </div>
                            </div>                                     
                        </h4>
                        <hr>
                        </div>
                        <div class="d-flex flex-row mt-n4">    
                        @if (count($vodCategories ) > 0)
                            <div class="card-body">
                            @foreach ($vodCategories as $vodCategory)
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
                                                        <a class="dropdown-item" href="{{ route('vodsmanagement.createVod', $vodCategory->id) }}">
                                                            <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                                                            Add New Video
                                                        </a>
                                                    </div>
                                                    </div>     
                                                    <hr>
                                                </h3>
                                                <h3>
                                                    <a href="{{ url('blackbox/' . $vodCategory->id ) }}" target="_blank">                             
                                                        {{ $vodCategory->name }} 
                                                    </a>                         
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
                                                    {{ sizeOf($categoryVods) }} Videos &raquo;
                                                @else 
                                                    {{ sizeOf($categoryVods) }} Video &raquo;
                                                @endif 
                                            </div>
                                        </div>  
                                        <hr>   
                                        <div class="row ml-1 mr-1 mt-3">
                                            <a class="btn btn-block btn-info" 
                                            href="{{ url('/blackbox-admin/category/' . $vodCategory->id) }}" role="button">
                                                View Category
                                            </a>
                                        </div>
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
