@extends('layouts.front')

@section('title', "$tiktokInfo->nickname")

@section('styles')
    <link href="{{ cAsset('vendor/datatables/datatables.css') }}" rel="stylesheet">
    <link href="{{ cAsset('app-assets/vendors/css/extensions/swiper.min.css') }}" rel="stylesheet">
    <link href="{{ cAsset('app-assets/css/plugins/extensions/swiper.css') }}" rel="stylesheet">
    <style>
        #formerrors {
            display: none;
        }

        #userhistory-list_info {
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
                <div class="col-12 mb-3 mt-3">
                    <div class="media mb-2">
                        <a class="mr-2 my-25" href="{{ url('https://www.tiktok.com/@' . $tiktokInfo->uniqueId) }}">
                            <img src="{{ $tiktokInfo->avatar }}" alt="users avatar" class="users-avatar-shadow rounded"
                                height="90" width="90">
                        </a>
                        <div class="media-body mt-50">
                            <div class="row">
                                <div class="col-sm-6 col-12">
                                    <h4 class="media-heading">{{ $tiktokInfo->nickname }}</h4>
                                    <span class="text-white badge badge-primary">{{ $tiktokInfo->category }}</span>
                                    <a href="{{ url('https://www.tiktok.com/@' . $tiktokInfo->uniqueId) }}">
                                        <p class="media-heading">{{ $tiktokInfo->uniqueId }}</p>
                                    </a>
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
                <div class="col-lg-4 col-md-6 col-sm-6 col-6">
                    <div class="card text-center bg-transparent">
                        <div class="card-content pl-sm-2 pr-sm-2 pl-0 pr-0">
                            <div class="class-header">
                                <h4 class="mt-1">???????????????</h4>
                            </div>
                            <i class="feather icon-users float-left pl-sm-2 pl-0" style="font-size: 46px"></i>
                            <div class="card-body p-0">
                                <h4 class="card-title">{{ number_format($tiktokInfo->follercount) }}???</h4>
                                <p class="card-text mb-25">???{{ $follerRank }}???/{{ $countInAll }}?????????</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-6">
                    <div class="card text-center bg-transparent">
                        <div class="card-content pl-sm-2 pr-sm-2 pl-0 pr-0">
                            <div class="class-header">
                                <h4 class="mt-1">????????????</h4>
                            </div>
                            <i class="feather icon-users float-left pl-sm-2 pl-0" style="font-size: 46px"></i>
                            <div class="card-body p-0">
                                <h4 class="card-title mt-2">{{ number_format($tiktokInfo->followingcount) }}???</h4>
                                <p class="card-text mb-25">&nbsp;</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-6">
                    <div class="card text-center bg-transparent">
                        <div class="card-content pl-sm-2 pr-sm-2 pl-0 pr-0">
                            <div class="class-header">
                                <h4 class="mt-1">????????????</h4>
                            </div>
                            <i class="feather icon-heart float-left pl-sm-2 pl-0" style="font-size: 46px"></i>
                            <div class="card-body p-0">
                                <h4 class="card-title">{{ number_format($tiktokInfo->heart) }}???</h4>
                                <p class="card-text mb-25">???{{ $heartRank }}???/{{ $countInAll }}?????????</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-6">
                    <div class="card text-center bg-transparent">
                        <div class="card-content pl-sm-2 pr-sm-2 pl-0 pr-0">
                            <div class="class-header">
                                <h4 class="mt-1">??????</h4>
                            </div>
                            <i class="feather icon-film float-left pl-sm-2 pl-0" style="font-size: 46px"></i>
                            <div class="card-body p-0">
                                <h4 class="card-title mt-2">{{ number_format($tiktokInfo->videocount) }}???</h4>
                                <p class="card-text mb-25">&nbsp;</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-6">
                    <div class="card text-center bg-transparent">
                        <div class="card-content pl-sm-2 pr-sm-2 pl-0 pr-0">
                            <div class="class-header">
                                <h4 class="mt-1">??????????????????</h4>
                            </div>
                            <i class="feather icon-star float-left pl-sm-2 pl-0" style="font-size: 46px"></i>
                            <div class="card-body p-0">
                                <h4 class="card-title mt-2">
                                    {{ number_format($tiktokInfo->follercount / $countInAll) }}???/??????
                                </h4>
                                <p class="card-text mb-25">&nbsp;</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-6">
                    <div class="card text-center bg-transparent">
                        <div class="card-content pl-sm-2 pr-sm-2 pl-0 pr-0">
                            <div class="class-header">
                                <h4 class="mt-1">??????????????????</h4>
                            </div>
                            <i class="feather icon-moon float-left pl-sm-2 pl-0" style="font-size: 46px"></i>
                            <div class="card-body p-0">
                                <h4 class="card-title mt-2">{{ number_format($rate, 2) }}%</h4>
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
                            <h4 class="card-title">{{ $tiktokInfo->nickname }}??????????????????????????????????????????</h4>
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
                                    <td style="background-color: #e91e63; color: white;">??????</td>
                                    <td style="background-color: #e91e63; color: white;">??????????????????</td>
                                    <td style="background-color: #e91e63; color: white;">????????????</td>
                                    <td style="background-color: #e91e63; color: white;">?????????</td>
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
    <script src="{{ cAsset('app-assets/vendors/js/charts/chart.min.js') }}"></script>
    <script src="{{ cAsset('app-assets/vendors/js/extensions/swiper.min.js') }}"></script>
    <script src="{{ cAsset('app-assets/js/scripts/extensions/swiper.js') }}"></script>
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
                "emptyTable": "??????????????????????????????????????????",
                "info": " _TOTAL_ ?????? _START_ ?????? _END_ ????????????",
                "infoEmpty": " 0 ?????? 0 ?????? 0 ????????????",
                "infoFiltered": "?????? _MAX_ ??????????????????",
                "infoThousands": ",",
                "lengthMenu": "_MENU_ ?????????",
                "loadingRecords": "???????????????...",
                "processing": "?????????...",
                "search": "??????:",
                "zeroRecords": "??????????????????????????????????????????",
                "paginate": {
                    "first": "??????",
                    "last": "??????",
                    "next": "???",
                    "previous": "???"
                },
                "aria": {
                    "sortAscending": ": ????????????????????????????????????????????????????????????",
                    "sortDescending": ": ????????????????????????????????????????????????????????????"
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
                    text: '{{ $tiktokInfo->nickname }}??????????????????????????????????????????????????????????????????????????????????????????'
                },
                elements: {
                    point: {
                        radius: 0
                    }
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
                    label: "?????????",
                    data: trendHearts,
                    borderColor: $primary,
                    fill: false
                }, {
                    data: trendFoller,
                    label: "???????????????",
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
