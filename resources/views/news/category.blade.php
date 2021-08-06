@extends('layouts.afterlogin')

@section('styles')
    <link href="{{ cAsset('vendor/datatables/datatables.css') }}" rel="stylesheet">
@endsection

@section('contents')
    <div class="row" id="div-main">
        <div class="col-md-12 col-lg-12">
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
            <form action="{{ route('news.category.add') }}" method="POST" enctype="multipart/form-data" class="mb-2">
                @csrf
                <div class="row">
                    <div class="col-md col-xl-2">
                        <label class="form-label">カテゴリー名</label>
                        <input type="text" id="add-category" name="add-category" class="form-control" placeholder="Any">
                    </div>
                    <div class="col-md col-xl-2">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary btn-block">
                            追加
                        </button>
                    </div>
                </div>
            </form>
            <div class="card">
                <div class="card-header  d-flex justify-content-between pt-1 pr-1 pl-1">
                    <h1>カテゴリー一覧</h1>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="category-list" class="table table-hover-animation mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center">番号</th>
                                    <th class="text-center">カテゴリー名</th>
                                    <th class="text-center">ニュース数</th>
                                    <th class="text-center">操作</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="modal_delete" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">カテゴリー削除</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body modal-middle-height">
                    <input id="modal_order_id" hidden />
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">カテゴリーを削除しますか？</label>
                            <input type="text" id="modal_delete-category" class="form-control mr-sm-2 mb-2 mb-sm-0"
                                readonly>
                            <input type="hidden" id="modal_delete-id" class="form-control mr-sm-2 mb-2 mb-sm-0" hidden>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="confirm_delete_cancel" type="button" class="btn btn-secondary"
                        data-dismiss="modal">キャンセル</button>
                    <button id="confirm_delete_agree" type="button" class="btn btn-primary">確認</button>
                </div>
            </div>
        </div>
    </div>

    <div id="modal_modify" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">カテゴリー編集</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body modal-middle-height">
                    <input id="modal_order_id" hidden />
                    <div class="form-row">
                        <div class="form-group col">
                            <label class="form-label">カテゴリータイトルを変更したいですか？</label>
                            <input type="text" id="modal_modify-category" class="form-control mr-sm-2 mb-2 mb-sm-0">
                            <input type="hidden" id="modal_modify-id" class="form-control mr-sm-2 mb-2 mb-sm-0" hidden>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="confirm_modify_cancel" type="button" class="btn btn-secondary"
                        data-dismiss="modal">キャンセル</button>
                    <button id="confirm_modify_agree" type="button" class="btn btn-primary">確認</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ cAsset('vendor/datatables/datatables.js') }}"></script>
    <script src="{{ cAsset('vendor/moment/moment.js') }}"></script>

    <script>
        let categoryTable = null;

        categoryTable = $('#category-list').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: BASE_URL + 'api/news/getcategories',
                type: 'POST',
            },
            columnDefs: [{
                'targets': 0,
            }],
            bSort: false,
            'stateSave': true,
            columns: [{
                data: null,
                className: "text-center"
            }, {
                data: 'category',
                className: "text-center"
            }, {
                data: 'count',
                className: "text-center"
            }, {
                data: null,
                className: "text-center"
            }, ],
            createdRow: function(row, data, index) {
                var pageInfo = categoryTable.page.info();

                // Index
                $('td', row).eq(0).html('').append(
                    '<span>' + (pageInfo.page * pageInfo.length + index + 1) + '</span>'
                );

                $('td', row).eq(3).html('').append(
                    '<a href="#" class="delete_btn list-icons-item" data-popup="tooltip" title="title" data-container="body" data-id="' +
                    data['id'] + '" data-category="' + data['category'] +
                    '"><i class="feather icon-trash"></i></a>&nbsp;&nbsp;' +
                    '<a href="#" class="edit_btn list-icons-item" data-popup="tooltip" title="title" data-container="body" data-id="' +
                    data['id'] + '" data-category="' + data['category'] +
                    '"><i class="feather icon-edit"></i></a>'
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
                    categoryTable.state.clear();
                }
            }
        });

        $(document.body).on('click', 'a.delete_btn', function(e) {
            var id = $(this).data("id");
            var category = $(this).data("category");
            $('#modal_delete-id').val(id);
            $('#modal_delete-category').val(category);
            $('#modal_delete').modal('show');
        });

        $('#confirm_delete_agree').click(function(e) {
            var id = $('#modal_delete-id').val();
            $.get({
                url: BASE_URL + 'api/deletenewscategory/' + id,
                success: function(result) {
                    $('#modal_delete').modal('hide');
                    categoryTable.ajax.reload();
                },
                error: function(result) {
                    $('#modal_delete').modal('hide');
                }
            });
        });

        $(document.body).on('click', 'a.edit_btn', function(e) {
            var id = $(this).data("id");
            var category = $(this).data("category");
            $('#modal_modify-id').val(id);
            $('#modal_modify-category').val(category);
            $('#modal_modify').modal('show');
        });

        $('#confirm_modify_agree').click(function(e) {
            var id = $('#modal_modify-id').val();
            var category = $('#modal_modify-category').val();
            $.post({
                url: BASE_URL + 'api/modifynewscategory/' + id,
                data: {
                    category: category
                },
                success: function(result) {
                    $('#modal_modify').modal('hide');
                    categoryTable.ajax.reload();
                },
                error: function(result) {
                    $('#modal_modify').modal('hide');
                }
            });
        });

        categoryTable.state.clear();

    </script>
@endsection
