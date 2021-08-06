@extends('layouts.front')

@section('title', '')

@section('styles')
    <link href="{{ cAsset('vendor/datatables/datatables.css') }}" rel="stylesheet">
    <style>
        #formerrors {
            display: none;
        }

    </style>
@endsection

@section('contents')
    <div class="content-body">
        <div class="card card-body" style="">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-content">
                            <!--Search Result-->
                            <div id="search-results" class="card-body p-0">
                                <ul class="media-list p-0">
                                    <!--search with image-->
                                    @foreach ($news as $index => $item)
                                        <li class="media d-sm-flex d-block news-item">
                                            @if ($item->thumb != '')
                                                <div class="media-left pr-sm-2 pr-0">
                                                    <a href="{{ route('posts.view', ['id' => $item->id]) }}">
                                                        <img class="media-object" src="{{ $item->thumb }}"
                                                            alt="Generic placeholder image" width="160px">
                                                    </a>
                                                </div>
                                            @endif
                                            <div class="media-body pr-sm-50 pr-0">
                                                <span class="m-0">{{ $item->created_at }}</span>
                                                <span class="text-white badge badge-info">{{ $item->category }}</span>
                                                <h5 class="text-bold-400 mb-0"><a class="news-list-title"
                                                        href="{{ route('posts.view', ['id' => $item->id]) }}">{{ $item->title }}</a>
                                                </h5>
                                                <p class="mb-0"><a href="{{ route('posts.view', ['id' => $item->id]) }}"
                                                        class="success">{{ route('posts.view', ['id' => $item->id]) }}</a>
                                                </p>
                                                <p>{!! nl2br($item->content) !!}</p>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        {!! $news->links('vendor.pagination.bootstrap-4') !!}
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('frontpage.news.newsside')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ cAsset('vendor/datatables/datatables.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/encoding-japanese/1.0.30/encoding.js"
        integrity="sha512-ooP6HUsSwhxdioCgjhI3ECNthmwlWGt5u1uz5CImhKO1sA2AzRDdJE6u7BkPaXo68WWKiNfZOH5tYTTY7gn10Q=="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
    </script>
@endsection
