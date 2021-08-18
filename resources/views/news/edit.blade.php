@extends('layouts.afterlogin')

@section('styles')
    <link href="{{ cAsset('vendor/datatables/datatables.css') }}" rel="stylesheet">
    <link href="{{ cAsset('vendor/daterangepicker/daterangepicker.css') }}" rel="stylesheet">
@endsection

@section('contents')
    <div class="row" id="div-main">
        <div class="col-md-12 col-lg-12">
            <form action="{{ route('news.update') }}" method="POST">
                <input type="hidden" name="news-id" value="{{ $news->id }}">
                @csrf
                <div class="row">
                    <div class="col-sm-12 col-12 m-auto">

                        @if (Session::has('success'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ Session::get('success') }}
                            </div>
                        @elseif(Session::has('failed'))
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ Session::get('failed') }}
                            </div>
                        @endif

                        <div class="card shadow">

                            <div class="card-header">
                                <h4 class="card-title">ニュースを編集する</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label> タイトル </label>
                                    <input type="text" class="form-control" name="title" placeholder="タイトルを入力してください。"
                                        value="{{ $news->title }}">
                                </div>
                                <div class="form-group">
                                    <label> カテゴリー </label>
                                    <select class="form-control" id="modal_modify-category" name="category">
                                        @foreach ($categories as $id => $category)
                                            <option value="{{ $id }}"
                                                {{ $id == $news->category ? 'selected' : '' }}>{{ $category[0] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label> 本文 </label>
                                    <textarea class="form-control" id="content" placeholder="コンテンツを入力してください。"
                                        name="content">{{ $news->content }}</textarea>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success"> 保存 </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ cAsset('vendor/datatables/datatables.js') }}"></script>
    <script src="{{ cAsset('vendor/moment/moment.js') }}"></script>
    <script src="{{ cAsset('vendor/daterangepicker/daterangepicker.min.js') }}"></script>
    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>


    <script>
        CKEDITOR.replace('content', {
            filebrowserUploadUrl: "{{ route('news.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });

    </script>
@endsection
