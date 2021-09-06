@extends('layouts.app')

@section('template_title')
	Redemption Page
@endsection

@section('head')
@endsection

@section('content')
	<div class="container">
		<div class="card shadow bg-white rounded">
			<div class="card-body shadow bg-white rounded"
			style="height: auto; overflow-x: hidden; width: auto; min-width: 40vw; max-width: 100vw;">   
				<div class="card-header row justify-content-center p-1 mt-3" style="">
					<h3 class="font-weight-bold">                                            
						Notifications
					</h3>
				</div>
				<hr class="m-1 p-0" style="border: 1px solid #17a2b8; background-color: #17a2b8;">
				@php $notifyCounter = 1; @endphp
				<div class="card-body">
					@foreach (auth()->user()->notifications as $notification)                                   
						<a class="" href="{{ $notification->data['url'] }}" style="border-color: lightgrey; justify-content: normal; 
							background-color: @if ($notification->unread()) aliceblue; @else white; @endif">
							<div class="dropdown-item d-flex align-items-center border-bottom notif-item pt-2 pb-2">
								<div class="d-flex align-items-center p-0">
									@php $user = \App\Models\User::find($notification->data['sender_id']); @endphp
									@if (isset($user)) 
										<img src="
										@if ($user->profile->avatar_status == 1) 
											{{ $user->profile->avatar }} 
										@else 
											{{ Gravatar::get($user->email) }} 
										@endif" 
										alt="{{ $user->name }}" class="user2-avatar-nav m-0 p-0" 
										style="width: 35px; height: 35px; ">
									@else 
										<img src="{!! asset('images/default_avatar.png') !!}" 
										alt="{{ $user->name }}" class="user2-avatar-nav m-0 p-0" 
										style="width: 35px; height: 35px; ">                                                                
									@endif
								</div>     
								<div class="dropdown-item pl-4 p-0" style="white-space: normal;">
									<div class="small font-italic"> 
										{{\Carbon\Carbon::createFromTimeStamp(strtotime($notification->created_at))->diffForHumans()}} - 
										{{\Carbon\Carbon::parse(strtotime($notification->created_at))->isoFormat('MMMM D, YYYY')}}
									</div>
									<span class="font-weight-bold">
										{!! $notification->data['data'] !!}
									</span>
								</div>
								@php $notifyCounter++; @endphp
							</div>
						</a>
					@endforeach
				</div>
			</div>
		</div>
	</div>
@endsection

@section('footer_scripts')

	<script type="text/javascript">

	</script>
   
@endsection