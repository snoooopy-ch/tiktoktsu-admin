@extends('layouts.front')

@section('title', '')

@section('styles')
    <style>
        #formerrors {
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
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ cAsset('app-assets/vendors/js/charts/chart.min.js') }}"></script>
    <script>
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
