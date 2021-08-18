@extends('layouts.front')

@section('title', "$categoryName->name")

@section('styles')
    <link href="{{ cAsset('vendor/datatables/datatables.css') }}" rel="stylesheet">
    <link href="{{ cAsset('app-assets/vendors/css/extensions/swiper.min.css') }}" rel="stylesheet">
    <link href="{{ cAsset('app-assets/css/plugins/extensions/swiper.css') }}" rel="stylesheet">
    <style>
        #formerrors {
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
        <div class="card card-body" style="margin-left: 5px; margin-right: 5px;">
            <h4 class="card-title font-weight-bold">@yield('title')</h4>
            <div class="table table-no-border table-striped table-responsive">
                <div class="btn-group mb-1" role="group" aria-label="Basic example">
                    <button type="button" id="order-foller" data-order="follercount"
                        class="btn btn-outline-light waves-effect waves-light btn-group-item">フォロワー数順</button>
                    <button type="button" id="order-like" data-order="heart"
                        class="btn btn-outline-light waves-effect waves-light btn-group-item">いいね数順</button>
                    <button type="button" id="order-video" data-order="videocount"
                        class="btn btn-outline-light waves-effect waves-light btn-group-item">動画投稿数順</button>
                </div>

                <table id="userpage-list" class="table table-striped">
                    <thead class="d-none">
                    </thead>
                    <tbody>
                        <tr></tr>
                    </tbody>
                </table>
            </div>

            @include('frontpage.footer')

            <p>このサイトはTikTokの統計データを独自に収集し分析したランキングサイトです。</p>
        </div>
    </div>


@endsection
@section('scripts')
    <script src="{{ cAsset('vendor/datatables/datatables.js') }}"></script>
    <script src="{{ cAsset('app-assets/vendors/js/extensions/swiper.min.js') }}"></script>
    <script src="{{ cAsset('app-assets/js/scripts/extensions/swiper.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/encoding-japanese/1.0.30/encoding.js"
        integrity="sha512-ooP6HUsSwhxdioCgjhI3ECNthmwlWGt5u1uz5CImhKO1sA2AzRDdJE6u7BkPaXo68WWKiNfZOH5tYTTY7gn10Q=="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
    </script>

    <script>
        let userTable;
        userTable = $('#userpage-list').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: BASE_URL + 'api/front/getusers',
                type: 'POST',
                data: function(data) {
                    data.key = '{{ app('request')->route('key') }}';
                    data.period = '{{ app('request')->route('period') }}';
                    data.category = '{{ app('request')->route('category') }}';
                    data.user = '{{ app('request')->route('user') }}';
                    data.order = $('.btn.btn-outline-light.waves-effect.waves-light.btn-group-item.active')
                        .data('order');
                }
            },
            columnDefs: [{
                'targets': 0,
                'checkboxes': {
                    'selectRow': true
                }
            }],
            bSort: false,
            columns: [{
                    data: null,
                    className: "text-center",
                    width: '50px'
                },
                {
                    data: null,
                    className: "text-center",
                    width: '100px'
                },
                {
                    data: null,
                    className: "text-left"
                },
                {
                    data: 'nickname',
                    className: "text-left nickname"
                },
                {
                    data: null,
                    className: "text-center text-primary"
                }
            ],
            createdRow: function(row, data, index) {
                $(row).attr('data-id', data['id']);
                var pageInfo = userTable.page.info();

                $('td', row).eq(0).html('').append(
                    '<span>' + (pageInfo.page * pageInfo.length + index + 1) + '</span>'
                );

                $('td', row).eq(1).html('').append(
                    '<img src="' + data['avatar'] + '" width="80"/>'
                );

                $('td', row).eq(2).html('').append(
                    '<span>' + data['uniqueId'] + '</span><br>' +
                    '<i class="feather icon-users"></i><span>&nbsp;' + data['follercount']
                    .toLocaleString() + '</span><br>' +
                    '<i class="feather icon-heart"></i><span>&nbsp;' + data['heart'].toLocaleString() +
                    '</span><br>' +
                    '<i class="feather icon-tv"></i><span>&nbsp;' + data['videocount'].toLocaleString() +
                    '</span>'
                );

                $('td', row).eq(3).html('').append(
                    data['nickname'] + '<br>' + data['signature']
                );


                $('td', row).eq(4).html('').append(
                    data['grow'] == 0 ? '' : parseInt(data['grow']).toLocaleString() + '↑'
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

        $(document).on('click', '#userpage-list tr', function() {
            let user_id = $(this).data('id');
            window.location.href = BASE_URL + 'tiktok/' + user_id;
        });

        $(document).on('click', '#order-foller', function(e) {
            activateButton($(e.target));
            userTable.clear().draw();
        });

        $(document).on('click', '#order-like', function(e) {
            activateButton($(e.target));
            userTable.clear().draw();
        });

        $(document).on('click', '#order-video', function(e) {
            activateButton($(e.target));
            userTable.clear().draw();
        });

        function activateButton(target) {
            $('.btn.btn-outline-light.waves-effect.waves-light.btn-group-item').removeClass('active');
            target.addClass('active');
        }

    </script>
@endsection
