@extends('layouts.front')

@section('title', '')

@section('styles')
    <style>
        #formerrors {
            display: none;
        }

    </style>
@endsection

@section('contents')
    <div class="content-body">
        <div class="card card-body" style="">
            <div class="row" style="min-height: 500px">
                <div class="col-12">
                    @if ($errors->any())
                        <div class="card-body">
                            <div class="alert alert-danger　alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <ul class="m-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    @if ($message = Session::get('flash_message'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            {{ trans($message) }}
                        </div>
                    @endif
                </div>

                <div class="col-12">
                    <form action="{{ route('publish.send') }}" method="POST" enctype="form-data/multipart"
                        class="mt-5 mb-5">
                        <h1 class="text-center mb-3 text-primary">TikTokランキングに掲載</h1>
                        <h4 class="text-center mb-3">TikTokの@以降の英数字のみを入力してください(@は不要)。更新後、掲載まで数日かかることがあります。</h4>
                        <div class="d-flex justify-content-center align-items-center">
                            @csrf
                            <span>https://www.tiktok.com/@</span>
                            <input class="form-control w-auto mr-1" name="tiktok-uniqueId" id="tiktok-uniqueId">
                            <button type="submit" class="btn btn-primary mr-1 waves-effect waves-light">
                                <i class="feather icon-edit-1"></i> TikTokアカウントを追加
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
