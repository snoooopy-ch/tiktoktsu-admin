@extends('layouts.afterlogin')

@section('styles')
@endsection

@section('contents')
    <div class="row">
        <div class="col-lg-12">
            <form method="post" action="{{ route('admin.passwordupdate') }}" enctype="multipart/form-data">
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
                            <label class="col-form-label col-sm-2 text-sm-right"><span class="text-danger">*</span>
                                現在のパスワード</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="old_password" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right"><span class="text-danger">*</span>
                                新しいパスワード</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="password" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right"><span class="text-danger">*</span>
                                新しいパスワード（確認）</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="password_confirm" value="">
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
