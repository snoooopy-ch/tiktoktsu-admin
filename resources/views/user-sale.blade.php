@extends('layouts.afterlogin')

@section('styles')
    <link href="{{ cAsset('vendor/datatables/datatables.css') }}" rel="stylesheet">
    <link href="{{ cAsset('vendor/daterangepicker/daterangepicker.css') }}" rel="stylesheet">
@endsection

@section('contents')
    <div class="row" id="div-main">
        <div class="col-md-12 col-lg-12">
            <form class="mb-2">
                <div class="row">
                    <div class="col-md">
                        <label class="form-label">期間</label>
                        <input type="text" id="filter-period" name="filter-period" class="form-control pickadate"
                            placeholder="Any">
                    </div>
                    <div class="col-md col-xl-2">
                        <label class="form-label">商品コード</label>
                        <input type="text" id="good-code" name="good-code" class="form-control" placeholder="Any">
                    </div>
                    <div class="col-md">
                        <label class="form-label">商品名</label>
                        <input type="text" id="good-name" name="good-name" class="form-control" placeholder="Any">
                    </div>
                    <div class="col-md col-xl-2">
                        <label class="form-label">&nbsp;</label>
                        <button type="button" onclick="javascript:doSearch()" class="btn btn-primary btn-block">
                            検索
                        </button>
                    </div>
                </div>
            </form>

            <div class="card">
                <div class="card-header">
                    <h1>{{ $user->user_name }}様の履歴</h1>
                    <h3>その期間の売上は<span id="description" style="color: red"></span></h3>
                    <input id="user_login" value="{{ $user->user_login }}" hidden />
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="user-sale-list" class="table table-hover-animation mb-0">
                            <thead>
                                <tr>
                                    <th class="text-left">no</th>
                                    <th class="text-left">日付</th>
                                    <th class="text-left">商品コード</th>
                                    <th class="text-left">商品名</th>
                                    <th class="text-left">商品価格</th>
                                    <th class="text-left">商品数量</th>
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
    <script src="{{ cAsset('vendor/moment/moment.js') }}"></script>
    <script src="{{ cAsset('vendor/daterangepicker/daterangepicker.min.js') }}"></script>

    <script>
        var tradeDates = [];
        $('#filter-period').daterangepicker({
                opens: 'right',
                autoUpdateInput: false,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            },
            function(start, end, label) {
                startDate = moment(start).format('YYYY-MM-DD');
                endDate = moment(end).format('YYYY-MM-DD');
                tradeDates = [startDate, endDate];
            }
        );
        $('#filter-period').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        });
        $('#filter-period').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            tradeDates = [];
        });

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

        // Unused
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
            userTable.column(1).search(tradeDates.join(':'), false, false);
            userTable.column(2).search($('#good-code').val());
            userTable.column(3).search($('#good-name').val());
            userTable.draw();
        }

        userTable = $('#user-sale-list').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: BASE_URL + 'staff/sale/getsales/' + $('#user_login').val(),
                type: 'POST',
            },
            columnDefs: [{
                'targets': 0,
                'checkboxes': {
                    'selectRow': true
                }
            }],
            'stateSave': true,
            order: [1, 'desc'],
            columns: [{
                    data: null,
                    className: "text-left"
                },
                {
                    data: 'order_date',
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
                    data: 'order_price',
                    className: "text-left"
                },
                {
                    data: 'order_count',
                    className: "text-left"
                },
            ],
            createdRow: function(row, data, index) {
                var pageInfo = userTable.page.info();

                // Index
                $('td', row).eq(0).html('').append(
                    '<span>' + (pageInfo.page * pageInfo.length + index + 1) + '</span>'
                );

                $('td', row).eq(4).html('').append(
                    '<span>' + number_format(data['order_price']) + '円' + '</span>'
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
            drawCallback: function(response) {
                if (performance.navigation.type == 1) {
                    userTable.state.clear();
                }

                if (response.json.price !== undefined) {
                    $('#description').html(number_format(response.json.price) + '円');
                }
            }
        });

        // Unused
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

        // Unused
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

        // Unused
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
