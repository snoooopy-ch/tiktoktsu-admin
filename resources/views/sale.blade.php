@extends('layouts.afterlogin')

@section('styles')
    <link href="{{ cAsset('vendor/datepick/css/pickadate.css') }}" rel="stylesheet">
    <link href="{{ cAsset('vendor/datatables/datatables.css') }}" rel="stylesheet">
@endsection

@section('contents')
    <div class="content-body">
        <form class="mb-2">
            <div class="row">
                <div class="col-md col-xl-2">
                    <label class="form-label">受注期間を選択してください。</label>
                    <input type="text" id="select-month" name="select-month" class="form-control pickadate" placeholder="Any">
                </div>
                <div class="col-md">
                    <label class="form-label">ユーザーID</label>
                    <input type="text" id="user-login" name="user-login" class="form-control pickadate" placeholder="Any">
                </div>
                <div class="col-md col-xl-2">
                    <label class="form-label">&nbsp;</label>
                    <button type="button" onclick="javascript:doSearch()" class="btn btn-primary btn-block">
                        検索
                    </button>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md">
                    <label class="form-label">振込日を入力してください。</label>
                    <input type="text" id="transfer-day" name="period" class="form-control pickadate" placeholder="Any">
                </div>
                <div class="col-md col-xl-2">
                    <label class="form-label">&nbsp;</label>
                    <button type="button" onclick="javascript:doCSVDownload();" class="btn btn-primary btn-block">
                        CSVダウンロード
                    </button>
                </div>
                <div class="col-md col-xl-2">
                    <label class="form-label">&nbsp;</label>
                    <button type="button" onclick="javascript:doPDFDownload()" class="btn btn-primary btn-block">
                        PDFダウンロード
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="row" id="div-main">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h1>履歴</h1>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="sales-list" class="table table-hover-animation mb-0">
                            <thead>
                            <tr>
                                <th class="text-left">no</th>
                                <th class="text-left">サービス区分</th>
                                <th class="text-left">実行日</th>
                                <th class="text-left">受取人銀行番号</th>
                                <th class="text-left">受取人支店番号</th>
                                <th class="text-left">受取人預金種目</th>
                                <th class="text-left">受取人口座番号</th>
                                <th class="text-left">受取人口座名</th>
                                <th class="text-left">金額</th>
                                <th class="text-left">数量</th>
                                <th class="text-left">顧客番号</th>
                                <th class="text-left">登録者ユーザID</th>
                                <th class="text-left">登録者氏名</th>
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
    <script src="{{ cAsset('vendor/datepick/js/picker.js') }}"></script>
    <script src="{{ cAsset('vendor/datepick/js/picker.date.js') }}"></script>
    <script src="{{ cAsset('vendor/datepick/js/picker.time.js') }}"></script>
    <script src="{{ cAsset('vendor/datepick/js/legacy.js') }}"></script>
    <script src="{{ cAsset('vendor/datatables/datatables.js') }}"></script>
    <script src="{{ cAsset('vendor/moment/moment.js') }}"></script>

    <script>
    // Date
    var tradeDates = [];
    var transferDate = '';

    function selectMonth(selectObject) {
        var month = selectObject.value - 1;
        var date = new Date(), y = date.getFullYear();
        var firstDay = moment(new Date(y, month, 1)).format('YYYY-MM-DD');
        var lastDay = moment(new Date(y, month + 1, 0)).format('YYYY-MM-DD');
        tradeDates = [firstDay, lastDay];

        // salesTable.column(2).search(tradeDates.join(':'), false, false);
        // salesTable.draw();
    }

    $('#select-month').pickadate({
        today: 'Ok',
        format: 'yyyy-mm',
        formatSubmit: 'yyyy-mm-dd',
        selectYears: true,
        selectMonths: true,
        onSet: function(context) {
            var tmpDate = $('#select-month').val() + '-01';

            var date = new Date(tmpDate), y = date.getFullYear(), month = date.getMonth();
            var firstDay = moment(new Date(y, month, 1)).format('YYYY-MM-DD');
            var lastDay = moment(new Date(y, month + 1, 0)).format('YYYY-MM-DD');
            tradeDates = [firstDay, lastDay];
        },
    });


    $('#transfer-day').pickadate({
        format: 'yyyy-mm-dd',
        onSet: function(context) {
            var tmpDate = $('#transfer-day').val();
            transferDate = tmpDate;
        },
    });

    function doSearch() {
        salesTable.column(2).search(tradeDates.join(':'), false, false);
        salesTable.column(11).search($('#user-login').val());
        salesTable.draw();
    }

    salesTable = $('#sales-list').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        ajax: {
            url: BASE_URL + 'api/getsales',
            type: 'POST',
        },
        'stateSave': true,
        columnDefs: [
                {
                    'targets': 0,
                    'checkboxes': {
                    'selectRow': true
                    }
                }
            ],
        order: [3, 'desc'],
        columns: [
            {data: null, className: "text-center"},
            {data: null, className: "text-center"},
            {data: 'order_date', className: "text-center"},
            {data: 'bank_number', className: "text-center"},
            {data: 'shop_number', className: "text-center"},
            {data: 'deposit_kind', className: "text-center"},
            {data: 'account_number', className: "text-center"},
            {data: 'account_name', className: "text-center"},
            {data: 'order_price', className: "text-left"},
            {data: 'order_count', className: "text-left"},
            {data: 'user_number', className: "text-center"},
            {data: 'user_login', className: "text-center"},
            {data: 'user_name', className: "text-center"},
        ],
        createdRow: function (row, data, index) {
            var pageInfo = salesTable.page.info();

            // Index
            $('td', row).eq(0).html('').append(
                '<span>' + (pageInfo.page * pageInfo.length + index + 1) + '</span>'
            );

            $('td', row).eq(1).html('').append(3);

            $('td', row).eq(8).html('').append(
                '<span>' + number_format(data['order_price']) + '円' + '</span>'
            );
            
        },
        initComplete: function() {
        },
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
        drawCallback: function () {
            if (performance.navigation.type == 1) {
                salesTable.state.clear();
            }
        }
    });

    $(document.body).on('click', 'a.edit_btn', function (e) {
        var id = $(this).data("id");
        $.get({
            url: BASE_URL + 'api/getorder/' + id,
            success: function(result) {
                $('#modal_order_date').val(result['order_date']);
                $('#modal_good_code').val(result['good_code']);
                $('#modal_order_count').val(result['order_count']);
                $('#modal_order_id').val(id);
                $('#modal_default').modal('show');

            },
            error: function(result) {
            }
        });
        
        e.stopImmediatePropagation();
        e.preventDefault();
    });


    $(document.body).on('click', 'a.delete_btn', function (e) {
        var id = $(this).data("id");
        $.get({
            url: BASE_URL + 'api/deleteorder/' + id,
            success: function(result) {
                location.reload();
            },
            error: function(result) {
            }
        });
        e.stopImmediatePropagation();
        e.preventDefault();
    });

    $('#confirm_agree').click(function(e) {
        var id = $('#modal_order_id').val();
        $.get({
            url: BASE_URL + 'api/modifyorder/' + id,
            data: {
                content: {
                    order_date: $('#modal_order_date').val(),
                    good_code: $('#modal_good_code').val(),
                    order_count: $('#modal_order_count').val(),
                }
            },
            success: function(result) {
                location.reload();
            },
            error: function(result) {
                
            }
        });
        $('#modal_default').modal('hide');
        e.stopImmediatePropagation();
        e.preventDefault();
    });

    function doCSVDownload() {
        var link = document.createElement('a');
        link.setAttribute('href', (BASE_URL + 'sales/csvdownload?orderDates=' + tradeDates.join(':') + '&tradeDay=' + transferDate));
        link.click();
    }

    function doPDFDownload() {
        var link = document.createElement('a');
        link.setAttribute('href', (BASE_URL + 'sales/pdfdownload?orderDates=' + tradeDates.join(':') + '&tradeDay=' + transferDate));
        link.click();
    }

    function downloadCSV(url) {  
        var link = document.createElement('a');
        link.setAttribute('href', url);
        link.click();
    }

</script>
@endsection
