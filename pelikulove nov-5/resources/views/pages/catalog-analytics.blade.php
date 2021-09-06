@extends('layouts.app')

@section('template_title')
Analytics Catalog
@endsection

@section('template_fastload_css')
@endsection

@section('content')




<div class="container">
    <div class="row d-flex flex-row">
    	<div class="col-md-12 col-lg-12">
        	<div class="card shadow bg-white rounded">
            	<div class="card-header @role('admin', true) bg-secondary text-white text-md-left @endrole">
					Analytics Catalog
				</div>

				<hr>
				
				<div class="card-body mx-2">
					{{-- Blackbox Start --}}
					<div class="card shadow rounded mb-3">
						<div class="card-body row">
							<div class="col-12 mt-3">
								<h4>
									Blackbox Analytics
								</h4>
								<hr>
							</div>

							<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 mb-3">
								<div class="card row justify-content-center mx-1 h-100">
									<div class="row justify-content-center py-4">
										<a href="{{ url('/analytics/vod') }}" class="mx-5">								
											<button class="btn btn-danger mt-2 mb-2"
											role="button"> 	
												<h5 class="mb-0">
													Blackbox Analytics
												</h5>
											</button>
										</a>
									</div>
								</div>
							</div>

							<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 mb-3">
								<div class="card row justify-content-center mx-1 h-100">
									<div class="row justify-content-center py-4">
										<a href="{{ url('analytics/vod/show-all-videos') }}" class="mx-5">								
											<button class="btn btn-danger mt-2 mb-2"
											role="button"> 	
												<h5 class="mb-0">
													All Video Stats
												</h5>
											</button>
										</a>
									</div>
								</div>
							</div>

							<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 mb-3">
								<div class="card row justify-content-center mx-1 h-100">
									<div class="row justify-content-center py-4 ">
										<a href="{{ url('analytics/vod/show-all-users') }}" class="mx-5">								
											<button class="btn btn-danger mt-2 mb-2"
											role="button"> 	
												<h5 class="mb-0">
													All Blackbox Users Stats
												</h5>
											</button>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					{{-- Blackbox End --}}

					{{-- Course Start --}}
					<div class="card shadow rounded mb-3">
						<div class="card-body row">
							<div class="col-12 mt-3">
								<h4>
									Course Analytics
								</h4>
								<hr>
							</div>

							<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 mb-3">
								<div class="card row justify-content-center mx-1 h-100">
									<div class="row justify-content-center py-4">
										<a href="{{ url('analytics/courses') }}" class="mx-5">								
											<button class="btn btn-danger mt-2 mb-2"
											role="button"> 	
												<h5 class="mb-0">
													Course Analytics
												</h5>
											</button>
										</a>
									</div>
								</div>
							</div>
							
							@foreach ($courses as $course)
								<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 mb-3">
									<div class="card row justify-content-center mx-1 h-100">
										<div class="row justify-content-center py-4">
											<a href="{{ url('analytics/courses/' . $course->id . '/show') }}" class="mx-5">								
												<button class="btn btn-danger mt-2 mb-2"
												role="button"> 	
													<h5 class="mb-0">
														{{$course->title}} Stats
													</h5>
												</button>
											</a>
										</div>
									</div>
								</div>
							@endforeach
						</div>
						
					</div>
					{{-- Course End --}}

					{{-- Others Start --}}
					<div class="card shadow rounded mb-3">
						<div class="card-body row">
							<div class="col-12 mt-3">
								<h4>
									Other Analytics
								</h4>
								<hr>
							</div>

							<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 mb-3">
								<div class="card row justify-content-center mx-1 h-100">
									<div class="row justify-content-center py-4">
										<a href="{{ url('/analytics/users') }}" class="mx-5">								
											<button class="btn btn-danger mt-2 mb-2"
											role="button"> 	
												<h5 class="mb-0">
													Registrants and Enrollees Stats
												</h5>
											</button>
										</a>
									</div>
								</div>
							</div>
						</div>
						
					</div>
					{{-- Others End --}}
				</div>

			</div>
        </div>	
    </div> <!-- row -->
</div><!-- container -->

@endsection

@section('footer_scripts')
@endsection