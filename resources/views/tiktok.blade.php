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
                    <div class="col-md  col-xl-2">
                        <label class="form-label">ID</label>
                        <input type="text" id="search-id" name="search-id" class="form-control" placeholder="Any">
                    </div>
                    <div class="col-md col-xl-2">
                        <label class="form-label">名前</label>
                        <input type="text" id="search-uniqueId" name="search-uniqueId" class="form-control"
                            placeholder="Any">
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
                <div class="card">
                    <div id="modal_default" class="modal fade" tabindex="-1">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">ご注意</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body modal-middle-height">
                                    <input id="modal_order_id" hidden />
                                    <div class="form-row">
                                        <div class="form-group col">
                                            <label class="form-label">ユーザーを削除しますか？</label>
                                            <input type="text" id="modal_uniqueId" class="form-control mr-sm-2 mb-2 mb-sm-0"
                                                readonly>
                                            <input type="hidden" id="modal_id" class="form-control mr-sm-2 mb-2 mb-sm-0"
                                                hidden>
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
                </div>
                <div class="card-header  d-flex justify-content-between pt-1 pr-1 pl-1">
                    <h1>ユーザー閲覧</h1>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tiktok-list" class="table table-hover-animation mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center">番号</th>
                                    <th class="text-center">TikTokID</th>
                                    <th class="text-center">画像</th>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">ニックネーム</th>
                                    <th class="text-center">Following</th>
                                    <th class="text-center">Follower</th>
                                    <th class="text-center">DiggCount</th>
                                    <th class="text-center">ハット</th>
                                    <th class="text-center">ビデオ</th>
                                    <th class="text-center">操作</th>
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
        function doSearch() {
            tiktokTable.column(1).search($('#search-id').val());
            tiktokTable.column(3).search($('#search-uniqueId').val());
            tiktokTable.draw();
        }

        tiktokTable = $('#tiktok-list').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: BASE_URL + 'api/tiktokusers',
                type: 'POST',
            },
            columnDefs: [{
                'targets': 0,
                'checkboxes': {
                    'selectRow': true
                }
            }],
            'stateSave': true,
            order: [3, 'desc'],
            columns: [{
                    data: null,
                    className: "text-left"
                }, {
                    data: 'tiktok_id',
                    className: "tiktok-avatar"
                }, {
                    data: 'avatar',
                    className: "text-left"
                }, {
                    data: 'uniqueId',
                    className: "text-left"
                },
                {
                    data: 'nickname',
                    className: "text-left"
                },
                {
                    data: 'follercount',
                    className: "text-left"
                },
                {
                    data: 'followingcount',
                    className: "text-left"
                },
                {
                    data: 'diggcount',
                    className: "text-left"
                },
                {
                    data: 'heart',
                    className: "text-left"
                },
                {
                    data: 'videocount',
                    className: "text-left"
                },
                {
                    data: null
                },
            ],
            createdRow: function(row, data, index) {
                var pageInfo = tiktokTable.page.info();

                // Index
                $('td', row).eq(0).html('').append(
                    '<span>' + (pageInfo.page * pageInfo.length + index + 1) + '</span>'
                );
                $('td', row).eq(2).html('').append(
                    '<img src="' + data['avatar'] + '" width="100"/>'
                );

                $('td', row).eq(10).html('').append(
                    '<a href="#" class="delete_btn list-icons-item" data-popup="tooltip" title="title" data-container="body" data-id="' +
                    data['id'] + '" data-uniqueid="' + data['uniqueId'] +
                    '"><i class="feather icon-trash"></i></a>'
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
                    tiktokTable.state.clear();
                }
            }
        });

        $(document.body).on('click', 'a.delete_btn', function(e) {
            var id = $(this).data("id");
            var uniqueId = $(this).data("uniqueid");
            $('#modal_id').val(id);
            $('#modal_uniqueId').val(uniqueId);
            $('#modal_default').modal('show');
        });

        $('#confirm_agree').click(function(e) {
            var id = $('#modal_id').val();
            $.get({
                url: BASE_URL + 'api/deletetiktok/' + id,
                success: function(result) {
                    $('#modal_default').modal('hide');
                    tiktokTable.ajax.reload();
                },
                error: function(result) {
                    $('#modal_default').modal('hide');
                }
            });
        });

        tiktokTable.state.clear();

    </script>
@endsection
