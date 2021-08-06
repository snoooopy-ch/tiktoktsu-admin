@extends('layouts.afterlogin')

@section('styles')
    <link href="{{ cAsset('vendor/datatables/datatables.css') }}" rel="stylesheet">
@endsection

@section('contents')
    <div class="row" id="div-main">
        <div class="col-md-12 col-lg-12">
            <form class="mb-2">
                <div class="row">
                    <div class="col-md col-xl-2">
                        <label class="form-label">ユーザーID</label>
                        <input type="text" id="user-login" name="user-login" class="form-control pickadate"
                            placeholder="Any">
                    </div>
                    <div class="col-md">
                        <label class="form-label">ユーザー名</label>
                        <input type="text" id="user-name" name="user-name" class="form-control pickadate" placeholder="Any">
                    </div>
                    <div class="col-md col-xl-2">
                        <label class="form-label">&nbsp;</label>
                        <button type="button" onclick="javascript:doSearch()" class="btn btn-primary btn-block">
                            検索
                        </button>
                    </div>
                    <div class="col-md col-xl-2">
                        <label class="form-label">&nbsp;</label>
                        <button type="button" class="btn btn-primary btn-block"
                            onclick="javascript: deleteSel(); ">選択削除</button>
                    </div>
                </div>
            </form>

            <div class="card">
                <div id="modal_default" class="modal fade" tabindex="-1">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">ユーザー編集</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body modal-middle-height">
                                <input id="modal_user_id" hidden />
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label class="form-label">ユーザー</label>
                                        <input type="text" id="modal_user_login" class="form-control mr-sm-2 mb-2 mb-sm-0"
                                            readonly>
                                        <small id="account-error" class="invalid-feedback">This field is required.</small>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label class="form-label">パスワード</label>
                                        <input type="text" id="modal_user_rawpassword"
                                            class="form-control mr-sm-2 mb-2 mb-sm-0">
                                        <small id="rawpassword-error" class="invalid-feedback">This field is
                                            required.</small>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label class="form-label">名前</label>
                                        <input type="text" id="modal_user_name" class="form-control mr-sm-2 mb-2 mb-sm-0">
                                        <small id="name-error" class="invalid-feedback">This field is required.</small>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col">
                                        <label class="form-label">メールアドレス</label>
                                        <input type="text" id="modal_user_email" class="form-control mr-sm-2 mb-2 mb-sm-0">
                                        <small id="name-error" class="invalid-feedback">This field is required.</small>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col">
                                        <label class="form-label">顧客番号</label>
                                        <input type="text" id="modal_user_number" class="form-control mr-sm-2 mb-2 mb-sm-0">
                                        <small id="name-error" class="invalid-feedback">This field is required.</small>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col">
                                        <label class="form-label">銀行番号</label>
                                        <input type="text" id="modal_bank_number" class="form-control mr-sm-2 mb-2 mb-sm-0">
                                        <small id="name-error" class="invalid-feedback">This field is required.</small>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col">
                                        <label class="form-label">店舗番号</label>
                                        <input type="text" id="modal_shop_number" class="form-control mr-sm-2 mb-2 mb-sm-0">
                                        <small id="name-error" class="invalid-feedback">This field is required.</small>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col">
                                        <label class="form-label">預金種目</label>
                                        <input type="text" id="modal_deposit_kind"
                                            class="form-control mr-sm-2 mb-2 mb-sm-0">
                                        <small id="name-error" class="invalid-feedback">This field is required.</small>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col">
                                        <label class="form-label">口座番号</label>
                                        <input type="text" id="modal_account_number"
                                            class="form-control mr-sm-2 mb-2 mb-sm-0">
                                        <small id="name-error" class="invalid-feedback">This field is required.</small>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col">
                                        <label class="form-label">口座名</label>
                                        <input type="text" id="modal_account_name"
                                            class="form-control mr-sm-2 mb-2 mb-sm-0">
                                        <small id="name-error" class="invalid-feedback">This field is required.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button id="confirm_cancel" type="button" class="btn btn-secondary"
                                    data-dismiss="modal">キャンセル</button>
                                <button id="confirm_agree" type="button" class="btn btn-primary">確認</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-header">
                    <h1>ユーザー閲覧</h1>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="user-list" class="table table-hover-animation mb-0">
                            <thead>
                                <tr>
                                    <th class="text-left">選択</th>
                                    <th class="text-left">no</th>
                                    <th class="text-left">ID</th>
                                    <th class="text-left">パスワード</th>
                                    <th class="text-left">名前</th>
                                    <th class="text-left">メールアドレス</th>
                                    <th class="text-left">顧客番号</th>
                                    <th class="text-left">銀行番号</th>
                                    <th class="text-left">店舗番号</th>
                                    <th class="text-left">預金種目</th>
                                    <th class="text-left">口座番号</th>
                                    <th class="text-left">口座名</th>
                                    <th class="text-left">操作</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
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
                url: BASE_URL + 'api/deleteusers/',
                data: {
                    content: selected
                },
                success: function(result) {
                    selected = [];
                    userTable.ajax.reload();
                },
                error: function(result) {}
            });
        }

        function doSearch() {
            userTable.column(2).search($('#user-login').val());
            userTable.column(4).search($('#user-name').val());
            userTable.draw();
        }

        userTable = $('#user-list').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: BASE_URL + 'api/getusers',
                type: 'POST',
            },
            columnDefs: [{
                'targets': 0,
                'checkboxes': {
                    'selectRow': true
                }
            }],
            bSort: false,
            'stateSave': true,
            order: [2, 'desc'],
            columns: [{
                    data: null,
                    className: "text-left"
                },
                {
                    data: 'id',
                    className: "text-left"
                },
                {
                    data: 'user_login',
                    className: "text-left"
                },
                {
                    data: 'raw_password',
                    className: "text-left"
                },
                {
                    data: 'user_name',
                    className: "text-left"
                },
                {
                    data: 'user_email',
                    className: "text-left"
                },
                {
                    data: 'user_number',
                    className: "text-left"
                },
                {
                    data: 'bank_number',
                    className: "text-left"
                },
                {
                    data: 'shop_number',
                    className: "text-left"
                },
                {
                    data: 'deposit_kind',
                    className: "text-left"
                },
                {
                    data: 'account_number',
                    className: "text-left"
                },
                {
                    data: 'account_name',
                    className: "text-left"
                },
                {
                    data: null
                },
            ],
            createdRow: function(row, data, index) {
                var pageInfo = userTable.page.info();

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

                // user_login
                $('td', row).eq(2).html('').append(
                    '<a href="' + BASE_URL + 'staff/sale/' + data['user_login'] + '">' + data[
                    'user_login'] + '</a>'
                );

                // Password
                $('td', row).eq(3).html('').append(
                    '<span>' + data['raw_password'] + '</span>'
                );

                // user_name
                $('td', row).eq(4).html('').append(
                    '<a href="' + BASE_URL + 'staff/sale/' + data['user_login'] + '">' + data['user_name'] +
                    '</a>'
                );

                // email
                $('td', row).eq(5).html('').append(
                    '<a href="' + BASE_URL + 'staff/sale/' + data['user_login'] + '">' + data[
                    'user_email'] + '</a>'
                );


                $('td', row).eq(12).html('').append(
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
                    userTable.state.clear();
                }
            }
        });

        $(document.body).on('click', 'a.edit_btn', function(e) {
            var id = $(this).data("id");
            $.get({
                url: BASE_URL + 'api/getuser/' + id,
                success: function(result) {
                    $('#modal_user_login').val(result['user_login']);
                    $('#modal_user_rawpassword').val(result['raw_password']);
                    $('#modal_user_name').val(result['user_name']);
                    $('#modal_user_email').val(result['user_email']);
                    $('#modal_user_number').val(result['user_number']);
                    $('#modal_bank_number').val(result['bank_number']);
                    $('#modal_shop_number').val(result['shop_number']);
                    $('#modal_deposit_kind').val(result['deposit_kind']);
                    $('#modal_account_number').val(result['account_number']);
                    $('#modal_account_name').val(result['account_name']);
                    $('#modal_user_id').val(id);
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
                url: BASE_URL + 'api/deleteuser/' + id,
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
            var id = $('#modal_user_id').val();
            $.get({
                url: BASE_URL + 'api/modifyuser/' + id,
                data: {
                    content: {
                        user_login: $('#modal_user_login').val(),
                        raw_password: $('#modal_user_rawpassword').val(),
                        user_name: $('#modal_user_name').val(),
                        user_email: $('#modal_user_email').val(),
                        user_number: $('#modal_user_number').val(),
                        bank_number: $('#modal_bank_number').val(),
                        shop_number: $('#modal_shop_number').val(),
                        deposit_kind: $('#modal_deposit_kind').val(),
                        account_number: $('#modal_account_number').val(),
                        account_name: $('#modal_account_name').val(),
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
