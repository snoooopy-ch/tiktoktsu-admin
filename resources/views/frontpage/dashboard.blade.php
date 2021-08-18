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

        .swiper-button-next,
        .swiper-button-prev {
            top: 50px;
        }

    </style>
@endsection

@section('contents')
    <div class="content-body">
        <div class="card card-body" style="">
            <div class="row">
                @include('frontpage.publishuser')
            </div>
        </div>
    </div>

    <div class="content-body">
        <div class="card card-body" style="margin-left: 5px; margin-right: 5px;">
            <div class="table table-no-border table-striped table-responsive position-relative">
                <table id="userpage-list" class="table table-striped">
                    <thead class="d-none">
                    </thead>
                    <tbody>
                        <tr></tr>
                    </tbody>
                </table>

                <div class="btn-group position-absolute" role="group" aria-label="Basic example" style="top: 0; right: 0;">
                    <button type="button" data-order="follower" data-period="week"
                        class="btn btn-outline-light waves-effect waves-light btn-group-item"><i
                            class="feather icon-users"></i>&nbsp;周</button>
                    <button type="button" data-order="follower" data-period="month"
                        class="btn btn-outline-light waves-effect waves-light btn-group-item"><i
                            class="feather icon-users"></i>&nbsp;月</button>
                    <button type="button" data-order="follower" data-period=""
                        class="btn btn-outline-light waves-effect waves-light btn-group-item"><i
                            class="feather icon-users"></i>&nbsp;総</button>
                    <button type="button" data-order="heart" data-period="week"
                        class="btn btn-outline-light waves-effect waves-light btn-group-item"><i
                            class="feather icon-heart"></i>&nbsp;周</button>
                    <button type="button" data-order="heart" data-period="month"
                        class="btn btn-outline-light waves-effect waves-light btn-group-item"><i
                            class="feather icon-heart"></i>&nbsp;月</button>
                    <button type="button" data-order="heart" data-period=""
                        class="btn btn-outline-light waves-effect waves-light btn-group-item"><i
                            class="feather icon-heart"></i>&nbsp;総</button>
                </div>
            </div>

            @include('frontpage.footer')

            <div class="p-1 bg-primary text-white">新着投稿</div>
            <ul class="media-list p-0 row">
                <!--search with image-->
                @foreach ($news as $index => $item)
                    <li class="media d-sm-flex d-block news-item col-6">
                        @if ($item->thumb != '')
                            <div class="media-left pr-sm-2 pr-0">
                                <a href="{{ route('posts.view', ['id' => $item->id]) }}">
                                    <img class="media-object" src="{{ $item->thumb }}" alt="Generic placeholder image"
                                        width="160px">
                                </a>
                            </div>
                        @endif
                        <div class="media-body pr-sm-50 pr-0">
                            <h5 class="text-bold-400 mb-0"><a class="news-list-title text-dark"
                                    href="{{ route('posts.view', ['id' => $item->id]) }}">{{ $item->title }}</a>
                            </h5>
                            <span class="m-0">{{ date('Y:m:d', strtotime($item->created_at)) }}</span>
                            <span class="text-white badge badge-info">{{ $item->category }}</span>
                        </div>
                    </li>
                @endforeach
            </ul>
            <div class="d-flex justify-content-end mt-1 mb-2">
                <a href="{{ route('posts') }}">新着記事をもっと見る</a>
            </div>

            <div class="p-1 bg-primary text-white">よく読まれているニュース</div>
            <ul class="media-list p-0 row">
                <!--search with image-->
                @foreach ($topNews as $index => $item)
                    <li class="media d-block news-item col-6 col-sm-6 col-md-3 match-height">
                        @if ($item->thumb != '')
                            <a href="{{ route('posts.view', ['id' => $item->id]) }}">
                                <img class="media-object w-100" src="{{ $item->thumb }}" alt="Generic placeholder image">
                            </a>
                        @endif
                        <div class="media-body pr-sm-50 pr-0 mt-1">
                            <h5 class="text-bold-400 mb-0"><a class="news-list-title text-dark"
                                    href="{{ route('posts.view', ['id' => $item->id]) }}">{{ $item->title }}</a>
                            </h5>
                            <span class="m-0">{{ date('Y:m:d', strtotime($item->created_at)) }}</span>
                            <span class="text-white badge badge-info">{{ $item->category }}</span>

                        </div>
                    </li>
                @endforeach
            </ul>

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
                    data.key = $('.btn.btn-outline-light.waves-effect.waves-light.btn-group-item.active')
                        .data('order');
                    data.period = $('.btn.btn-outline-light.waves-effect.waves-light.btn-group-item.active')
                        .data('period');
                    data.category = '{{ app('request')->route('category') }}';
                    data.user = '{{ app('request')->route('user') }}'
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
        })

        $(document).on('click', '.btn-group button', function(e) {
            activateButton($(e.target));
            userTable.clear().draw();
        });

        function activateButton(target) {
            $('.btn.btn-outline-light.waves-effect.waves-light.btn-group-item').removeClass('active');
            target.addClass('active');
        }

    </script>
@endsection
