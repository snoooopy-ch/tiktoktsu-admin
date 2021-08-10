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
                <div class="col-12">
                    @if ($errors->any())
                        <div class="card-body">
                            <div class="alert alert-danger　alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert">×</button>
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
                </div>

                <div class="col-12">
                    <form action="{{ route('publish.send') }}" method="POST" enctype="form-data/multipart"
                        class="mt-1 mb-1">
                        <h1 class="text-center mb-3 text-primary">TikTokランキングに掲載</h1>
                        <h4 class="text-center mb-3">TikTokの@以降の英数字のみを入力してください(@は不要)。更新後、掲載まで数日かかることがあります。</h4>
                        <div
                            class="d-md-flex d-sm-block justify-content-center align-items-center text-sm-center text-center">
                            @csrf
                            <span>https://www.tiktok.com/@</span>
                            <input class="form-control w-auto mr-1 m-sm-auto m-md-1 m-auto" name="uniqueId" id="uniqueId">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                <i class="feather icon-edit-1"></i> TikTokアカウントを追加
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <div class="card card-body" style="margin-left: 5px; margin-right: 5px;">
            <div class="table table-no-border table-striped table-responsive">
                <table id="userpage-list" class="table table-striped">
                    <thead class="d-none">
                    </thead>
                    <tbody>
                        <tr></tr>
                    </tbody>
                </table>
            </div>

            <div class="card-content mt-3">
                <h4 class="card-title font-weight-bold">急上昇</h4>
                <h6 class="">{{ $start }}~{{ $end }}の間、フォロワー数が急上昇いたTikTokerです。</h6>
                <div class="card-body pr-0 pl-0" style="margin-left: 5px; margin-right: 5px;">
                    <div
                        class="swiper-responsive-breakpoints swiper-container swiper-container-initialized swiper-container-horizontal">
                        <div class="swiper-wrapper"
                            style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms;">
                            @foreach ($surgers as $index => $item)
                                <div class="swiper-slide swiper-slide-active" style="width: 171.8px; margin-right: 50px;">
                                    <img class="img-fluid" src="{{ $item->avatar }}" alt="banner">
                                    <span class="d-block">{{ $item->uniqueId }}</span>
                                    <span class="d-block font-size-xsmall">
                                        <i class="feather icon-users"></i>
                                        +{{ number_format($item->follercount_grow) }}
                                    </span>
                                    <span class="d-block font-size-xsmall">
                                        <i class="feather icon-trending-up"></i>
                                        {{ number_format($item->rate_up, 3) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>

                        <div class="swiper-button-next" tabindex="0" role="button" aria-label="Next slide"
                            aria-disabled="false"></div>
                        <div class="swiper-button-prev" tabindex="0" role="button" aria-label="Previous slide"
                            aria-disabled="false"></div>
                        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                    </div>
                </div>
            </div>

            <div class="card-content mt-3">
                <h4 class="card-title font-weight-bold">新しい登録したTikToker</h4>
                <h6 class="">最近TikToRaに登録されたTikTokerの一覧</h6>
                <div class="card-body pr-0 pl-0" style="margin-left: 5px; margin-right: 5px;">
                    <div
                        class="swiper-responsive-breakpoints swiper-container swiper-container-initialized swiper-container-horizontal">

                        <div class="swiper-wrapper"
                            style="transform: translate3d(0px, 0px, 0px); transition-duration: 0ms;">
                            @foreach ($laster as $index => $item)
                                <div class="swiper-slide swiper-slide-active" style="width: 171.8px; margin-right: 50px;">
                                    <img class="img-fluid" src="{{ $item->avatar }}" alt="banner">
                                    <span class="d-block">{{ $item->uniqueId }}</span>
                                    <span class="d-block font-size-xsmall">
                                        <i class="feather icon-users"></i>
                                        {{ number_format($item->follercount) }}
                                    </span>
                                    <span class="d-block font-size-xsmall">
                                        <i class="feather icon-heart"></i>
                                        {{ number_format($item->heart) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>

                        <div class="swiper-button-next" tabindex="0" role="button" aria-label="Next slide"
                            aria-disabled="false"></div>
                        <div class="swiper-button-prev" tabindex="0" role="button" aria-label="Previous slide"
                            aria-disabled="false"></div>
                        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                    </div>
                </div>
            </div>

            <p>このさいとはTikTokの統計データを独自に収集し分析したランキングサイトです。</p>
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
                    data['grow'] == 0 ? '' : data['grow'] + '↑'
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

    </script>
@endsection
