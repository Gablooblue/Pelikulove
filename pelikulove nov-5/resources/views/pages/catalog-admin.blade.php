@extends('layouts.app')

@section('template_title')
Admin Catalog
@endsection

@section('template_fastload_css')
@endsection

@section('content')




<div class="container">
    <div class="row d-flex flex-row">
    	<div class="col-md-12 col-lg-12">
        	<div class="card shadow bg-white rounded">
            	<div class="card-header @role('admin', true) bg-secondary text-white text-md-left @endrole">
					Admin Catalog
				</div>

				<hr>
				
				<div class="card-body mx-2">

					{{-- User Data Start --}}
					<div class="card shadow rounded mb-3">
						<div class="card-body row">
							<div class="col-12 mt-3">
								<h4>
									User Admin
								</h4>
								<hr>
							</div>
							
							<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 mb-3">
								<div class="card row justify-content-center mx-1 h-100">
									<div class="row justify-content-center py-4 ">
										<a href="{{ url('users') }}" class="mx-5">								
											<button class="btn btn-danger mt-2 mb-2"
											role="button"> 	
												<h5 class="mb-0">
													Users
												</h5>
											</button>
										</a>
									</div>
								</div>
							</div>

							<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 mb-3">
								<div class="card row justify-content-center mx-1 h-100">
									<div class="row justify-content-center py-4 ">
										<a href="{{ url('eventlogs') }}" class="mx-5">								
											<button class="btn btn-danger mt-2 mb-2"
											role="button"> 	
												<h5 class="mb-0">
													Eventlogs
												</h5>
											</button>
										</a>
									</div>
								</div>
							</div>

						</div>						
					</div>
					{{-- User Data End --}}

					{{-- Transactions Start --}}
					<div class="card shadow rounded mb-3">
						<div class="card-body row">
							<div class="col-12 mt-3">
								<h4>
									Transactions Admin
								</h4>
								<hr>
							</div>
							<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 mb-3">
								<div class="card row justify-content-center mx-1 h-100">
									<div class="row justify-content-center py-4 ">
										<a href="{{ url('vod-purchases') }}" class="mx-5">								
											<button class="btn btn-danger mt-2 mb-2"
											role="button"> 	
												<h5 class="mb-0">
													VOD Purchases
												</h5>
											</button>
										</a>
									</div>
								</div>
							</div>

							<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 mb-3">
								<div class="card row justify-content-center mx-1 h-100">
									<div class="row justify-content-center py-4 ">
										<a href="{{ url('enrollees') }}" class="mx-5">								
											<button class="btn btn-danger mt-2 mb-2"
											role="button"> 	
												<h5 class="mb-0">
													Enrollees
												</h5>
											</button>
										</a>
									</div>
								</div>
							</div>

							<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 mb-3">
								<div class="card row justify-content-center mx-1 h-100">
									<div class="row justify-content-center py-4 ">
										<a href="{{ url('orders') }}" class="mx-5">								
											<button class="btn btn-danger mt-2 mb-2"
											role="button"> 	
												<h5 class="mb-0">
													Orders
												</h5>
											</button>
										</a>
									</div>
								</div>
							</div>

							<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 mb-3">
								<div class="card row justify-content-center mx-1 h-100">
									<div class="row justify-content-center py-4 ">
										<a href="{{ url('donations/list') }}" class="mx-5">								
											<button class="btn btn-danger mt-2 mb-2"
											role="button"> 	
												<h5 class="mb-0">
													Donations
												</h5>
											</button>
										</a>
									</div>
								</div>
							</div>

						</div>						
					</div>
					{{-- Transactions End --}}

					{{-- Others Start --}}
					<div class="card shadow rounded mb-3">
						<div class="card-body row">
							<div class="col-12 mt-3">
								<h4>
									CMS Admin
								</h4>
								<hr>
							</div>

							<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 mb-3">
								<div class="card row justify-content-center mx-1 h-100">
									<div class="row justify-content-center py-4 ">
										<a href="{{ url('blackbox-admin') }}" class="mx-5">								
											<button class="btn btn-danger mt-2 mb-2"
											role="button"> 	
												<h5 class="mb-0">
													Blackbox Admin
												</h5>
											</button>
										</a>
									</div>
								</div>
							</div>

							<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 mb-3">
								<div class="card row justify-content-center mx-1 h-100">
									<div class="row justify-content-center py-4 ">
										<a href="{{ url('services') }}" class="mx-5">								
											<button class="btn btn-danger mt-2 mb-2"
											role="button"> 	
												<h5 class="mb-0">
													Services
												</h5>
											</button>
										</a>
									</div>
								</div>
							</div>

							<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 mb-3">
								<div class="card row justify-content-center mx-1 h-100">
									<div class="row justify-content-center py-4 ">
										<a href="{{ url('payment-methods') }}" class="mx-5">								
											<button class="btn btn-danger mt-2 mb-2"
											role="button"> 	
												<h5 class="mb-0">
													Payment Methods
												</h5>
											</button>
										</a>
									</div>
								</div>
							</div>

							<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12 mb-3">
								<div class="card row justify-content-center mx-1 h-100">
									<div class="row justify-content-center py-4 ">
										<a href="{{ url('promo-codes') }}" class="mx-5">								
											<button class="btn btn-danger mt-2 mb-2"
											role="button"> 	
												<h5 class="mb-0">
													Promo Codes
												</h5>
											</button>
										</a>
									</div>
								</div>
							</div>

						</div>						
					</div>
					{{-- Others End --}}
					
					{{-- <div class="card shadow rounded mb-3"> --}}
						<div class="card-body row">

							


						</div>
					{{-- </div> --}}
					
				</div>

			</div>
        </div>	
    </div> <!-- row -->
</div><!-- container -->

@endsection

@section('footer_scripts')
@endsection