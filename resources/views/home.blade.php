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
                        <label class="form-label">受注期間</label>
                        <input type="text" id="search-day" name="search-day" class="form-control pickadate" placeholder="Any">
                    </div>
                    <div class="col-md col-xl-2">
                        <label class="form-label">商品コード</label>
                        <input type="text" id="search-good" name="search-good" class="form-control pickadate" placeholder="Any">
                    </div>
                    <div class="col-md col-xl-2">
                        <label class="form-label">&nbsp;</label>
                        <button type="button" onclick="javascript:doSearch()" class="btn btn-primary btn-block">
                            検索
                        </button>
                    </div>
                    <div class="col-md col-xl-2">
                        <label class="form-label">&nbsp;</label>
                        <button type="button" class="btn btn-primary btn-block" onclick="javascript: deleteSel(); ">選択削除</button>
                    </div>
                </div>
            </form>
            <div class="card">
                <div id="modal_default" class="modal fade" tabindex="-1">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">注文閲覧</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body modal-middle-height">
                                <input id="modal_order_id" hidden/>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label class="form-label">注文日時</label>
                                        <input type="text" id="modal_order_date" class="form-control mr-sm-2 mb-2 mb-sm-0">
                                        <small id="account-error" class="invalid-feedback">This field is required.</small>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label class="form-label">商品コード</label>
                                        <input type="text" id="modal_good_code" class="form-control mr-sm-2 mb-2 mb-sm-0">
                                        <small id="name-error" class="invalid-feedback">This field is required.</small>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col">
                                        <label class="form-label">数量</label>
                                        <input type="text" id="modal_order_count" class="form-control mr-sm-2 mb-2 mb-sm-0">
                                        <small id="name-error" class="invalid-feedback">This field is required.</small>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button id="confirm_cancel" type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                                <button id="confirm_agree" type="button" class="btn btn-primary">確認</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-header  d-flex justify-content-between pt-1 pr-1 pl-1">
                    <h1>注文閲覧</h1>
                    
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="order-list" class="table table-hover-animation mb-0">
                            <thead>
                            <tr>
                                <th class="text-left">選択</th>
                                <th class="text-left">no</th>
                                <th class="text-left">受注日時</th>
                                <th class="text-left">商品コード</th>
                                <th class="text-left">数量</th>
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
    <script src="{{ cAsset('vendor/moment/moment.js') }}"></script> 
    <script src="{{ cAsset('vendor/daterangepicker/daterangepicker.min.js') }}"></script>
    
    <script>
        var tradeDates = [];
        $('#search-day').daterangepicker({
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
        $('#search-day').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        });
        $('#search-day').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            tradeDates = [];
        });

        function doSearch() {
            orderTable.column(2).search(tradeDates.join(':'), false, false);
            orderTable.column(3).search($('#search-good').val());
            orderTable.draw();
        }

        var selected = [];
        $(document.body).on('click', 'input.checkbox', function (e) {
            e.stopImmediatePropagation();
            // e.preventDefault();

            if( $(this).is(':checked') ) {
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
                url: BASE_URL + 'api/deleteorders/',
                data: {
                    content: selected
                },
                success: function(result) {
                    selected = [];
                    orderTable.ajax.reload();
                },
                error: function(result) {
                }
            });
        }

        orderTable = $('#order-list').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: BASE_URL + 'api/getorders',
                type: 'POST',
            },
            columnDefs: [
                {
                    'targets': 0,
                    'checkboxes': {
                    'selectRow': true
                    }
                }
            ],
            'stateSave': true,
            order: [1, 'desc'],
            columns: [
                {data: null, className: "text-left"},
                {data: 'id', className: "text-left"},
                {data: 'order_date', className: "text-left"},
                {data: 'good_code', className: "text-left"},
                {data: 'order_count', className: "text-left"},
                {data: null},
            ],
            createdRow: function (row, data, index) {
                var pageInfo = orderTable.page.info();

                if ($.inArray(data['id'].toString(), selected) != -1) {
                    $('td', row).eq(0).html('').append(
                        '<input id="checkbox-' + data['id'] + '" class="checkbox" name="checkItem" type="checkbox" value="' + data['id'] + '" checked>'
                    );
                } else {
                    $('td', row).eq(0).html('').append(
                        '<input id="checkbox-' + data['id'] + '" class="checkbox" name="checkItem" type="checkbox" value="' + data['id'] + '">'
                    );
                }

                // Index
                $('td', row).eq(1).html('').append(
                    '<span>' + (pageInfo.page * pageInfo.length + index + 1) + '</span>'
                );

                $('td', row).eq(5).html('').append(
                    '<a href="#" class="edit_btn list-icons-item pr-1" data-popup="tooltip" title="title" data-container="body" data-id="' +  data['id']  + '"><i class="feather icon-edit"></i></a>' + 
                    '<a href="#" class="delete_btn list-icons-item" data-popup="tooltip" title="title" data-container="body" data-id="' +  data['id']  + '"><i class="feather icon-trash"></i></a>'
                );
            },
            initComplete: function() {
            },
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
            drawCallback: function () {
                if (performance.navigation.type == 1) {
                    orderTable.state.clear();
                }
            }
        });

        $(document.body).on('click', 'a.edit_btn', function (e) {
            var id = $(this).data("id");
            $.get({
                url: BASE_URL + 'api/getorder/' + id,
                success: function(result) {
                    $('#modal_order_date').val(result['order_date']);
                    $('#modal_good_code').val(result['good_code']);
                    $('#modal_order_count').val(result['order_count']);
                    $('#modal_order_id').val(id);
                    $('#modal_default').modal('show');

                },
                error: function(result) {
                }
            });
            
            e.stopImmediatePropagation();
            e.preventDefault();
        });


        $(document.body).on('click', 'a.delete_btn', function (e) {
            var id = $(this).data("id");
            $.get({
                url: BASE_URL + 'api/deleteorder/' + id,
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
            var id = $('#modal_order_id').val();
            $.get({
                url: BASE_URL + 'api/modifyorder/' + id,
                data: {
                    content: {
                        order_date: $('#modal_order_date').val(),
                        good_code: $('#modal_good_code').val(),
                        order_count: $('#modal_order_count').val(),
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

        orderTable.state.clear();

    </script>
@endsection
