@extends('layouts.front')

@section('title', 'TikTokランキングに掲載')

@section('styles')
    <link href="{{ cAsset('app-assets/vendors/css/extensions/swiper.min.css') }}" rel="stylesheet">
    <link href="{{ cAsset('app-assets/css/plugins/extensions/swiper.css') }}" rel="stylesheet">
    <style>
        #formerrors {
            display: none;
        }

        .swiper-button-next,
        .swiper-button-prev {
            top: 50px;
        }

    </style>
@endsection

@section('contents')
    <div class="content-body">
        <div class="card card-body" style="">
            <div class="row" style="min-height: 500px">
                @include('frontpage.publishuser')
            </div>
            @include('frontpage.footer')
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ cAsset('app-assets/vendors/js/extensions/swiper.min.js') }}"></script>
    <script src="{{ cAsset('app-assets/js/scripts/extensions/swiper.js') }}"></script>
@endsection
