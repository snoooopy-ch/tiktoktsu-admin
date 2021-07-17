<!DOCTYPE html>
<html class="loading" lang="jp" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>{{ env('APP_NAME') }} | {{ trans('ui.login.title') }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ cAsset("favicon.png") }}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet") }}">
    
    <style>
        @font-face {
            font-family: "customFont";
            src: url("{{ cAsset('fonts/ipag.ttf') }}");
            font-weight: normal;
        }

        div, td {
            font-family: ipag !important;
            overflow-wrap: break-word;
            text-align: center !important;
            font-size: 14px;
        }

        p, span {
            font-family: ipag !important;
            overflow-wrap: break-word;
            word-wrap: break-word;
            hyphens: auto;
        }

        p {
            max-width: 21cm;
        }

        @page {
            size: A4 portrait;
            margin: 0.5cm;
            height: auto;
            padding-right: 100px;
        }
    </style>
</head>


<body>
    <div class="row" id="div-main">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h1>履歴</h1>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="sales-list-pdf">
                            <thead>
                            <tr>
                                <th class="text-left">サービス<br/>区分</th>
                                <th class="text-left">実行日</th>
                                <th class="text-left">受取人<br/>銀行番号</th>
                                <th class="text-left">受取人<br/>支店番号</th>
                                <th class="text-left">受取人<br/>預金種目</th>
                                <th class="text-left">受取人<br/>口座番号</th>
                                <th class="text-left">受取人<br/>口座名</th>
                                <th class="text-left">金額</th>
                                <th class="text-left">顧客番号</th>
                                <th class="text-left">登録者<br/>ユーザID</th>
                                <th class="text-left">登録者<br/>氏名</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($allData as $i => $data) { 
                                
                            ?>
                            <tr>
                                <td scope="row">3</td>
                                <td>{{ $tradeDay }}</td>
                                <td>{{ sprintf('%04d', $data->bank_number) }}</td>
                                <td>{{ sprintf('%03d', $data->shop_number) }}</td>
                                <td>{{ $data->deposit_kind }}</td>
                                <td>{{ sprintf('%07d', $data->account_number) }}</td>
                                <td>{{ $data->account_name }}</td>
                                <td>{{ number_format($data->order_price) . '円' }}</td>
                                <td>{{ $data->user_number }}</td>
                                <td>{{ $data->user_login }}</td>
                                <td>{{ $data->user_name }}</td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>


