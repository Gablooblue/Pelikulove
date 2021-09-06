@extends('layouts.app')

@section('template_title')
    Showing Test 01
@endsection

@section('template_fastload_css')

.vod-card:hover {
  filter: brightness(50%);  
}

@endsection

@section('content')
  <div class="container">
    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#loginAndSignup">
      Show Modal
    </button>
  </div>

  @include('modals.modal-signup')

@endsection

@section('footer_scripts')

  @include('scripts.signup-modal')

@endsection
