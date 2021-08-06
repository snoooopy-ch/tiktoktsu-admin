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
    <script src="{{ cAsset('vendor/datatables/datatables.js') }}"></script>

    <script>
        var selected = [];
        $(document.body).on('click', 'input.checkbox', function(e) {
            e.stopImmediatePropagation();
            // e.preventDefault();

            if ($(this).is(':checked')) {
                selected.push($(this).val());
            } else {
                removeItem = $(this).val().toString();
                selected = jQuery.grep(selected, function(value) {
                    return value != removeItem;
                });
            }

        });

        function deleteSel() {
            $.get({
                url: BASE_URL + 'api/deletegoods/',
                data: {
                    content: selected
                },
                success: function(result) {
                    selected = [];
                    goodTable.ajax.reload();
                },
                error: function(result) {}
            });
        }

        function doSearch() {
            goodTable.column(2).search($('#search-good').val());
            goodTable.column(3).search($('#search-name').val());
            goodTable.draw();
        }

        goodTable = $('#good-list').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: BASE_URL + 'api/getgoods',
                type: 'POST',
            },
            'stateSave': true,
            order: [1, 'desc'],
            columns: [{
                    data: null,
                    className: "text-left"
                },
                {
                    data: 'id',
                    className: "text-left"
                },
                {
                    data: 'good_code',
                    className: "text-left"
                },
                {
                    data: 'good_name',
                    className: "text-left"
                },
                {
                    data: 'good_price',
                    className: "text-left"
                },
                {
                    data: null
                },
            ],
            createdRow: function(row, data, index) {
                var pageInfo = goodTable.page.info();

                if ($.inArray(data['id'].toString(), selected) != -1) {
                    $('td', row).eq(0).html('').append(
                        '<input id="checkbox-' + data['id'] +
                        '" class="checkbox" name="checkItem" type="checkbox" value="' + data['id'] +
                        '" checked>'
                    );
                } else {
                    $('td', row).eq(0).html('').append(
                        '<input id="checkbox-' + data['id'] +
                        '" class="checkbox" name="checkItem" type="checkbox" value="' + data['id'] + '">'
                    );
                }

                // Index
                $('td', row).eq(1).html('').append(
                    '<span>' + (pageInfo.page * pageInfo.length + index + 1) + '</span>'
                );

                $('td', row).eq(4).html('').append(
                    '<span>' + number_format(data['good_price']) + '円' + '</span>'
                );

                $('td', row).eq(5).html('').append(
                    '<a href="#" class="edit_btn list-icons-item pr-1" data-popup="tooltip" title="title" data-container="body" data-id="' +
                    data['id'] + '"><i class="feather icon-edit"></i></a>' +
                    '<a href="#" class="delete_btn list-icons-item" data-popup="tooltip" title="title" data-container="body" data-id="' +
                    data['id'] + '"><i class="feather icon-trash"></i></a>'
                );
            },
            initComplete: function() {},
            "language": {
                "emptyTable": "テーブルにデータがありません",
                "info": " _TOTAL_ 件中 _START_ から _END_ まで表示",
                "infoEmpty": " 0 件中 0 から 0 まで表示",
                "infoFiltered": "（全 _MAX_ 件より抽出）",
                "infoThousands": ",",
                "lengthMenu": "_MENU_ 件表示",
                "loadingRecords": "読み込み中...",
                "processing": "処理中...",
                "search": "検索:",
                "zeroRecords": "一致するレコードがありません",
                "paginate": {
                    "first": "先頭",
                    "last": "最終",
                    "next": "次",
                    "previous": "前"
                },
                "aria": {
                    "sortAscending": ": 列を昇順に並べ替えるにはアクティブにする",
                    "sortDescending": ": 列を降順に並べ替えるにはアクティブにする"
                }
            },
            drawCallback: function() {
                if (performance.navigation.type == 1) {
                    goodTable.state.clear();
                }
            }
        });

        $(document.body).on('click', 'a.edit_btn', function(e) {
            var id = $(this).data("id");
            $.get({
                url: BASE_URL + 'api/getgood/' + id,
                success: function(result) {
                    $('#modal_good_code').val(result['good_code']);
                    $('#modal_good_name').val(result['good_name']);
                    $('#modal_good_price').val(result['good_price']);
                    $('#modal_good_id').val(id);
                    $('#modal_default').modal('show');

                },
                error: function(result) {}
            });

            e.stopImmediatePropagation();
            e.preventDefault();
        });


        $(document.body).on('click', 'a.delete_btn', function(e) {
            var id = $(this).data("id");
            $.get({
                url: BASE_URL + 'api/deletegood/' + id,
                success: function(result) {
                    location.reload();
                },
                error: function(result) {

                }
            });
            e.stopImmediatePropagation();
            e.preventDefault();
        });

        $('#confirm_agree').click(function(e) {
            var id = $('#modal_good_id').val();
            $.get({
                url: BASE_URL + 'api/modifygood/' + id,
                data: {
                    content: {
                        good_code: $('#modal_good_code').val(),
                        good_name: $('#modal_good_name').val(),
                        good_price: $('#modal_good_price').val(),
                    }
                },
                success: function(result) {
                    location.reload();
                },
                error: function(result) {

                }
            });
            $('#modal_default').modal('hide');
            e.stopImmediatePropagation();
            e.preventDefault();
        });

    </script>
@endsection
