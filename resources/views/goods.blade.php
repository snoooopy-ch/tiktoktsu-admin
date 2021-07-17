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
                        <label class="form-label">商品コード</label>
                        <input type="text" id="search-good" name="search-good" class="form-control pickadate" placeholder="Any">
                    </div>
                    <div class="col-md">
                        <label class="form-label">商品名</label>
                        <input type="text" id="search-name" name="search-name" class="form-control pickadate" placeholder="Any">
                    </div>
                    <div class="col-md col-xl-2">
                        <label class="form-label">紐づけ先ID</label>
                        <input type="text" id="search-seller" name="search-seller" class="form-control" placeholder="Any">
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
                                <h5 class="modal-title">商品閲覧</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body modal-middle-height">
                                <input id="modal_good_id" hidden/>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label class="form-label">商品コード</label>
                                        <input type="text" id="modal_good_code" class="form-control mr-sm-2 mb-2 mb-sm-0">
                                        <small id="account-error" class="invalid-feedback">This field is required.</small>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label class="form-label">商品名</label>
                                        <input type="text" id="modal_good_name" class="form-control mr-sm-2 mb-2 mb-sm-0">
                                        <small id="name-error" class="invalid-feedback">This field is required.</small>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col">
                                        <label class="form-label">商品価格</label>
                                        <input type="text" id="modal_good_price" class="form-control mr-sm-2 mb-2 mb-sm-0">
                                        <small id="name-error" class="invalid-feedback">This field is required.</small>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col">
                                        <label class="form-label">紐づけ先ID</label>
                                        <input type="text" id="modal_good_seller" class="form-control mr-sm-2 mb-2 mb-sm-0">
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
                <div class="card-header">
                    <h1>商品閲覧</h1>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="good-list" class="table table-hover-animation mb-0">
                            <thead>
                            <tr>
                                <th class="text-left">選択</th>
                                <th class="text-left">no</th>
                                <th class="text-left">商品コード</th>
                                <th class="text-left">商品名</th>
                                <th class="text-left">紐づけ先ID</th>
                                <th class="text-left">商品価格</th>
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
                url: BASE_URL + 'api/deletegoods/',
                data: {
                    content: selected
                },
                success: function(result) {
                    selected = [];
                    goodTable.ajax.reload();
                },
                error: function(result) {
                }
            });
        }

        function doSearch() {
            goodTable.column(2).search($('#search-good').val());
            goodTable.column(3).search($('#search-name').val());
            goodTable.column(4).search($('#search-seller').val());
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
            columns: [
                {data: null, className: "text-left"},
                {data: 'id', className: "text-left"},
                {data: 'good_code', className: "text-left"},
                {data: 'good_name', className: "text-left"},
                {data: 'good_seller', className: "text-left"},
                {data: 'good_price', className: "text-left"},
                {data: null},
            ],
            createdRow: function (row, data, index) {
                var pageInfo = goodTable.page.info();

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
                    '<span>' + number_format(data['good_price']) + '円' + '</span>'
                );
                
                $('td', row).eq(6).html('').append(
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
                    goodTable.state.clear();
                }
            }
        });

        $(document.body).on('click', 'a.edit_btn', function (e) {
            var id = $(this).data("id");
            $.get({
                url: BASE_URL + 'api/getgood/' + id,
                success: function(result) {
                    $('#modal_good_code').val(result['good_code']);
                    $('#modal_good_name').val(result['good_name']);
                    $('#modal_good_price').val(result['good_price']);
                    $('#modal_good_seller').val(result['good_seller']);
                    $('#modal_good_id').val(id);
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
                        good_seller: $('#modal_good_seller').val(),
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
