@extends('layouts.front')

@section('title', trans('errors.title'))

@section('content')

    <div class="bg-full-page bg-primary back-fixed major-bg-brown">
        <div class="mw-500 absolute-center">
            <div class="card color-primary withripple">
                <div class="card-body">
                    <div class="text-center color-dark">
                        <h1 class="color-primary text-big">{{ trans('errors.error_404') }}</h1>
                        <h2>{{ trans('errors.not_found') }}</h2>
                        <p class="lead lead-sm">We have not found what you are looking for.<br>We have put our robots to
                            search.</p>
                        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-raised"><i
                                class="zmdi zmdi-home"></i>
                            {{ trans('menu.home') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
