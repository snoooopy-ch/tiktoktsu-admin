@extends('layouts.front')

@section('styles')
@endsection

@section('contents')
    <div class="content-body">
        <div class="card card-body" style="">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card px-1">
                        <div class="card-header email-detail-head ml-0 pr-0 pl-0 mb-5">
                            <h3 class="text-bold-400 mb-0 text-primary news-detail-title">
                                {{ $news->title }}
                            </h3>
                        </div>
                        <div class="mail-date">{{ $news->created_at }}</div>
                        <div class="card-body mail-message-wrapper pt-2 mb-0 pr-0 pl-0">
                            <div class="mail-message news-detail">
                                <p>{!! nl2br($news->content) !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('frontpage.newsside')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
