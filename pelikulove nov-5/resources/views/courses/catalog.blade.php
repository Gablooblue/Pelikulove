@extends('layouts.app')

@section('template_title')
Course Catalog
@endsection

@section('template_fastload_css')
@endsection

@section('content')




<div class="container">
    <div class="row d-flex flex-row">
    	<div class="col-md-12 col-lg-12">
        	<div class="card shadow bg-white rounded">
            	<div class="card-header @role('admin', true) bg-secondary text-white text-md-left @endrole">
					Course Catalog
				</div>

				<hr>
				
				<div class="card-body row">
					@foreach ($courses as $course)
						<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 mb-3">
							<div class="card row justify-content-center mx-1 h-100">
								<div class="row justify-content-center py-4 px-3">
									<h5 class="col-12 text-center">
										<strong>
											{{$course->title}}
										</strong>
									</h5>	
										
									@php										
										if (!Auth::check()) {
											$link = url('/course/' . $course->id . '/show');
											$disabled = "";
											$test = "Enroll Now";
										} elseif (\App\Models\LearnerCourse::ifEnrolled($course->id, Auth::user()->id)) {
											$link = url('/course/' . $course->id . '/show');
											$disabled = "";
											$test = "Resume Learning";
										} elseif ($course->private == 1) {
											// $link = "#";
											$link = '';
											// $disabled = "disabled";
											$disabled = "disabled";
											$test = "Enroll Now";
										} else {
											// $link = "#";
											$link = url('/course/' . $course->id . '/show');
											// $disabled = "disabled";
											$disabled = "";
											$test = "Enroll Now";
										}
									@endphp
									<a href="{{$link}}" class="">								
										<button class="btn btn-danger mt-2 mb-2 {{$disabled}}"
										role="button"> 	
											<strong>
												{{$test}}
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
    </div> <!-- row -->
</div><!-- container -->

@endsection

@section('footer_scripts')
@endsection