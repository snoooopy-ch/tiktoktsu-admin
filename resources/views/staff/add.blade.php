@extends('layouts.afterlogin')

@section('title', trans('staff.add_title'))

@section('styles')
    <link href="{{ cAsset('https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link rel="stylesheet"
        href="{{ cAsset('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css') }}">
    <style>
        .dataTables_filter {
            display: none;
        }

    </style>
@endsection

@section('scripts')
    <script src="{{ cAsset('/js/staff-edit.js') }}"></script>
    <script src="{{ cAsset('https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js') }}"></script>
    <script
        src="{{ cAsset('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js') }}">
    </script>
@endsection

@section('contents')
    <div class="row">
        <div class="col-lg-12">
            <form method="post" action="{{ route('staff.post.add') }}" enctype="multipart/form-data">
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
                <div class="card">
                    <div class="card-body pb-2">
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right"><span class="text-danger">*</span>
                                ログインID</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="user_login" value="{{ old('user_login') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right"><span class="text-danger">*</span>
                                {{ trans('staff.table.password') }}</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="password" value="{{ old('password') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right"><span
                                    class="text-danger">*</span>{{ trans('staff.table.pass_conf') }}</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-sm-2 text-sm-right"><span
                                    class="text-danger">*</span>{{ trans('staff.table.role') }}</label>
                            <div class="col-sm-10">
                                <div class="col-form-label col-sm-2 text-sm-right　custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" checked="" name="customCheck[]"
                                        value="admin" id="role_admin">
                                    <label class="custom-control-label" for="role_admin">管理者</label>
                                </div>
                                <div class="col-form-label col-sm-2 text-sm-right　custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" checked="" name="customCheck[]"
                                        value="writer" id="role_writer">
                                    <label class="custom-control-label" for="role_writer">投稿者</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="border-light m-0">
                </div>

                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-primary"><span
                            class="fa fa-save"></span>&nbsp;{{ trans('ui.button.add') }}</button>&nbsp;
                    <a class="btn btn-light" href="{{ route('staff') }}"><span
                            class="fa fa-arrow-left"></span>&nbsp;{{ trans('ui.button.back') }}</a>
                </div>
            </form>
        </div>
    </div>
@endsection
