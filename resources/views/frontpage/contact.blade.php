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
            <div class="row">
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
                    @if (Session::get('ret') && ($message = Session::get('ret')['flash_message']))
                        <div class="alert alert-success alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            {{ trans($message) }}
                        </div>
                    @endif
                </div>
                <div class="col-lg-12">
                    <form method="post" action="{{ route('contact.send') }}" enctype="multipart/form-data">
                        <h1 class="text-center mb-3 text-primary">お問い合わせ</h1>
                        @csrf
                        @if ($errors->any())
                            <div class="card-body">
                                <div class="alert alert-danger">
                                    <ul class="m-0 text-white">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                        @if (Session::get('ret') && ($message = Session::get('ret')['flash_message']))
                            <div id="success_alert" class="alert alert-success alert-dismissible fade show"
                                style="color: white !important; display:none !important;">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ trans($message) }}
                            </div>
                        @endif

                        <div class="card card-gray-back">
                            <div class="card-body pb-2">
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-4 text-sm-right"><span class="text-danger">*</span>
                                        メールアドレス</label>
                                    <div class="col-sm-8">
                                        @if (Session::get('ret') && ($email = Session::get('ret')['email']))
                                            <input type="email" class="form-control" name="email"
                                                value="{{ $email }}">
                                        @else
                                            <input type="email" class="form-control" name="email"
                                                value="{{ old('email') }}">
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-4 text-sm-right"><span class="text-danger">*</span>
                                        タイトル</label>
                                    <div class="col-sm-8">
                                        @if (Session::get('ret') && ($title = Session::get('ret')['title']))
                                            <input type="text" class="form-control" name="title"
                                                value="{{ $title }}">
                                        @else
                                            <input type="text" class="form-control" name="title"
                                                value="{{ old('title') }}">
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-4 text-sm-right"><span class="text-danger">*</span>
                                        メール本文</label>
                                    <div class="col-sm-8">
                                        @if (Session::get('ret') && ($content = Session::get('ret')['content']))
                                            <textarea type="text" class="form-control" name="content"
                                                rows="5">{{ $content }}</textarea>
                                        @else
                                            <textarea type="text" class="form-control" name="content"
                                                rows="5">{{ old('content') }}</textarea>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-3">
                            <button id="submit" type="submit" class="btn btn-primary"><span
                                    class="fa fa-save"></span>&nbsp;送信</button>&nbsp;
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
