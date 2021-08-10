@extends('layouts.afterlogin')

@section('styles')
@endsection

@section('contents')
    <div class="row">
        <div class="col-lg-12">
            <form method="post" action="{{ route('setting.save') }}" enctype="multipart/form-data">
                @csrf
                @if ($errors->any())
                    <div class="card-body">
                        <div class="alert alert-danger">
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

                <div class="card">
                    <div class="card-body pb-2">
                        <div class="form-group row">
                            <label class="col-form-label col-sm-4 col-md-2 text-sm-right"><span class="text-danger">*</span>
                                管理者メールアドレス</label>
                            <div class="col-sm-8 col-md-10">
                                <input type="mail_to" class="form-control" name="mail_to"
                                    value="{{ $setting['mail_to']['value'] }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-sm-4 col-md-2 text-sm-right"><span class="text-danger">*</span>
                                新着TikToker数</label>
                            <div class="col-sm-8 col-md-10">
                                <input type="recent_count" class="form-control" name="recent_count"
                                    value="{{ $setting['recent_count']['value'] }}">
                            </div>
                        </div>
                    </div>
                    <hr class="border-light m-0">
                </div>

                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-primary"><span class="fa fa-save"></span>&nbsp;変更する</button>&nbsp;
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
