@extends('layouts.front')

@section('title', '')

@section('styles')
    <link href="{{ cAsset('vendor/datatables/datatables.css') }}" rel="stylesheet">
    <style>
        #formerrors {
            display: none;
        }

        #userhistory-list_info {
            display: none;
        }

    </style>
@endsection

@section('contents')
    <div class="content-body">
        <div class="card card-body" style="">
            <div class="row">
                <div class="col-12 mb-3 mt-3">
                    <div class="media mb-2">
                        <a class="mr-2 my-25" href="#">
                            <img src="{{ $tiktokInfo->avatar }}" alt="users avatar" class="users-avatar-shadow rounded"
                                height="90" width="90">
                        </a>
                        <div class="media-body mt-50">
                            <div class="row">
                                <div class="col-sm-6 col-12">
                                    <h4 class="media-heading">{{ $tiktokInfo->nickname }}</h4>
                                    <span class="text-white badge badge-primary">{{ $tiktokInfo->category }}</span>
                                    <p class="media-heading">{{ $tiktokInfo->uniqueId }}</p>
                                </div>
                                <div class="col-sm-12 col-12">
                                    <p class="media-heading">{{ $tiktokInfo->signature }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card border-primary text-center bg-transparent">
                        <div class="card-content">
                            <div class="class-header">
                                <h4 class="mt-1">フォロワー</h4>
                            </div>
                            <i class="feather icon-users float-left mt-2 pl-2" style="font-size: 60px"></i>
                            <div class="card-body">
                                <h4 class="card-title mt-1">{{ number_format($tiktokInfo->follercount) }}人</h4>
                                <p class="card-text mb-25">（{{ $follerRank }}位/{{ $countInAll }}人中）</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card border-primary text-center bg-transparent">
                        <div class="card-content">
                            <div class="class-header">
                                <h4 class="mt-1">フォロー</h4>
                            </div>
                            <i class="feather icon-users float-left mt-2 pl-2" style="font-size: 60px"></i>
                            <div class="card-body">
                                <h4 class="card-title mt-1">{{ number_format($tiktokInfo->followingcount) }}人</h4>
                                <p class="card-text mb-25">&nbsp;</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card border-primary text-center bg-transparent">
                        <div class="card-content">
                            <div class="class-header">
                                <h4 class="mt-1">いいね数</h4>
                            </div>
                            <i class="feather icon-heart float-left mt-2 pl-2" style="font-size: 60px"></i>
                            <div class="card-body">
                                <h4 class="card-title mt-1">{{ number_format($tiktokInfo->heart) }}回</h4>
                                <p class="card-text mb-25">（{{ $heartRank }}位/{{ $countInAll }}人中）</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card border-primary text-center bg-transparent">
                        <div class="card-content">
                            <div class="class-header">
                                <h4 class="mt-1">楽曲</h4>
                            </div>
                            <i class="feather icon-film float-left mt-2 pl-2" style="font-size: 60px"></i>
                            <div class="card-body">
                                <h4 class="card-title mt-1">{{ number_format($tiktokInfo->videocount) }}個</h4>
                                <p class="card-text mb-25">&nbsp;</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card border-primary text-center bg-transparent">
                        <div class="card-content">
                            <div class="class-header">
                                <h4 class="mt-1">平均いいね数</h4>
                            </div>
                            <i class="feather icon-star float-left mt-2 pl-2" style="font-size: 60px"></i>
                            <div class="card-body">
                                <h4 class="card-title mt-1">
                                    {{ number_format($tiktokInfo->follercount / $countInAll) }}回/動画
                                </h4>
                                <p class="card-text mb-25">&nbsp;</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card border-primary text-center bg-transparent">
                        <div class="card-content">
                            <div class="class-header">
                                <h4 class="mt-1">平均いいね率</h4>
                            </div>
                            <i class="feather icon-moon float-left mt-2 pl-2" style="font-size: 60px"></i>
                            <div class="card-body">
                                <h4 class="card-title mt-1">{{ number_format($rate, 2) }}%</h4>
                                <p class="card-text mb-25">&nbsp;</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ $tiktokInfo->nickname }}フォロワー数・ハート数の推移</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body pl-0">
                                <div class="height-300">
                                    <canvas id="line-chart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="card card-body">
                    <div class="table table-no-border table-striped table-responsive">
                        <table id="userhistory-list" class="table table-striped">
                            <thead>
                                <tr>
                                    <td style="background-color: #e91e63; color: white;">日付</td>
                                    <td style="background-color: #e91e63; color: white;">フォロワー数</td>
                                    <td style="background-color: #e91e63; color: white;">いいね数</td>
                                    <td style="background-color: #e91e63; color: white;">投稿数</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ cAsset('vendor/datatables/datatables.js') }}"></script>
    <script src="{{ cAsset('app-assets/vendors/js/charts/chart.min.js') }}"></script>
    <script>
        let historyTable;
        historyTable = $('#userhistory-list').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: BASE_URL + "api/front/userdetail/{{ $tiktokInfo->id }}",
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
                    className: "text-right",
                },
                {
                    data: null,
                    className: "text-right"
                },
                {
                    data: null,
                    className: "text-right"
                }
            ],
            createdRow: function(row, data, index) {
                var pageInfo = historyTable.page.info();

                $('td', row).eq(0).html('').append(
                    data['date']
                );

                $('td', row).eq(1).html('').append(
                    parseInt(data['follercount_grow']).toLocaleString()
                );

                $('td', row).eq(2).html('').append(
                    parseInt(data['heart_grow']).toLocaleString()
                );

                $('td', row).eq(3).html('').append(
                    parseInt(data['videocount_grow']).toLocaleString()
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
                    historyTable.state.clear();
                }
            }
        });

        let trends = @json($trends);
        let trendLabel = [];
        let trendHearts = [];
        let trendFoller = [];
        $(window).on("load", function() {

            var $primary = '#7367F0';
            var $success = '#28C76F';
            var $label_color = '#1E1E1E';
            var grid_line_color = '#dae1e7';
            var $white = '#fff';
            var $black = '#000';

            var themeColors = [$primary, $success];

            // Line Chart
            // ------------------------------------------

            //Get the context of the Chart canvas element we want to select
            var lineChartctx = $("#line-chart");

            // Chart Options
            var linechartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'top',
                },
                hover: {
                    mode: 'label'
                },
                scales: {
                    xAxes: [{
                        display: true,
                        gridLines: {
                            color: grid_line_color,
                        },
                        scaleLabel: {
                            display: true,
                        }
                    }],
                    yAxes: [{
                        display: true,
                        gridLines: {
                            color: grid_line_color,
                        },
                        scaleLabel: {
                            display: true,
                        }
                    }]
                },
                title: {
                    display: true,
                    text: '{{ $tiktokInfo->nickname }}のフォロワー数と全ハート（いいね）数の日別の推移グラフです。'
                }
            };

            for (var i = 0; i < trends.length; i++) {
                trendLabel.push(trends[i].day);
                trendHearts.push(trends[i].heart);
                trendFoller.push(trends[i].foller);
            }

            // Chart Data
            var linechartData = {
                labels: trendLabel,
                datasets: [{
                    label: "ハット",
                    data: trendHearts,
                    borderColor: $primary,
                    fill: false
                }, {
                    data: trendFoller,
                    label: "フォロワー",
                    borderColor: $success,
                    fill: false
                }]
            };

            var lineChartconfig = {
                type: 'line',
                // Chart Options
                options: linechartOptions,
                data: linechartData
            };

            // Create the chart
            var lineChart = new Chart(lineChartctx, lineChartconfig);

        });

    </script>
@endsection
