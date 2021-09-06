@extends('layouts.app')

@section('template_title')
    Welcome {{ Auth::user()->name }}
@endsection

@section('head')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row d-flex flex-row">
            <div class="col-12 col-lg-10 offset-lg-1">

                @include('panels.welcome-panel2')

            </div>
        </div>
    </div>

@endsection
