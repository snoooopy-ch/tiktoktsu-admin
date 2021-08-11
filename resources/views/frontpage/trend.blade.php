@extends('layouts.front')

@section('title', '')

@section('styles')
    <link href="{{ cAsset('vendor/datatables/datatables.css') }}" rel="stylesheet">
    <link href="{{ cAsset('app-assets/vendors/css/extensions/swiper.min.css') }}" rel="stylesheet">
    <link href="{{ cAsset('app-assets/css/plugins/extensions/swiper.css') }}" rel="stylesheet">
    <style>
        #formerrors {
            display: none;
        }

        #trend-list_info {
            display: none;
        }

        .swiper-button-next,
        .swiper-button-prev {
            top: 50px;
        }

    </style>
@endsection

@section('contents')
    <div class="content-body">
        <div class="card card-body" style="">
            <h4 class="card-title font-weight-bold">最近流行する動画</h4>
            <div class="row">
                <div class="card card-body">
                    <div class="table table-no-border table-striped table-responsive">
                        <table id="trend-list" class="table table-striped">
                            <thead class="d-none">
                                <tr>
                                </tr>
                            </thead>
                            <tbody>
                                <tr></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @include('frontpage.footer')
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ cAsset('vendor/datatables/datatables.js') }}"></script>
    <script src="{{ cAsset('app-assets/vendors/js/extensions/swiper.min.js') }}"></script>
    <script src="{{ cAsset('app-assets/js/scripts/extensions/swiper.js') }}"></script>
    <script>
        let trendTable;
        trendTable = $('#trend-list').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: BASE_URL + "trend/recent",
                type: 'POST',
            },
            columnDefs: [{
                'targets': 0,
                'checkboxes': {
                    'selectRow': true
                }
            }],
            bSort: false,
            bPaginate: false,
            columns: [{
                    data: null,
                    className: "text-center",
                    width: '150px'
                },
                {
                    data: null,
                    className: "text-left",
                },
                {
                    data: null,
                    className: "text-center"
                },
                {
                    data: null,
                    className: "text-center"
                },
                {
                    data: null,
                    className: "text-center"
                }
            ],
            createdRow: function(row, data, index) {
                var pageInfo = trendTable.page.info();

                $('td', row).eq(0).html('').append(
                    '<img src="' + data['video_cover'] + '" width="100"/>'
                );

                $('td', row).eq(1).html('').append(
                    '<span>' + data['title'] + '</span><br>' +
                    '<i class="feather icon-message-circle"></i><span>&nbsp;コメント数：' + data['comment_count']
                    .toLocaleString() + '</span><br>' +
                    '<i class="feather icon-play"></i><span>&nbsp;プレイ数：' + data['play_count']
                    .toLocaleString() +
                    '</span><br>' +
                    '<i class="feather icon-share"></i><span>&nbsp;シェア数：' + data['share_count']
                    .toLocaleString() +
                    '</span>'
                );

                $('td', row).eq(2).html('').append(
                    '<img src="' + data['tiktok_avatar'] + '" width="80"/>'
                );

                $('td', row).eq(3).html('').append(
                    data['tiktoker']
                );

                $('td', row).eq(4).html('').append(
                    data['create_time']
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
                    trendTable.state.clear();
                }
            }
        });

    </script>
@endsection
