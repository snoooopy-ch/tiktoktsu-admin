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
                    <div class="col-md col-xl-2">
                        <label class="form-label">タイトル</label>
                        <input type="text" id="search-title" name="search-title" class="form-control" placeholder="Any">
                    </div>
                    <div class="col-md col-xl-2">
                        <label class="form-label">受注期間</label>
                        <input type="text" id="search-day" name="search-day" class="form-control pickadate"
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
                                            <label class="form-label">ニュースを削除しますか？</label>
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
                    <h1>ニュース閲覧</h1>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="news-list" class="table table-hover-animation mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center">番号</th>
                                    <th class="text-center">タイトル</th>
                                    <th class="text-center">カテゴリー</th>
                                    <th class="text-center">投稿者</th>
                                    <th class="text-center">日付</th>
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
        var tradeDates = [];
        let categories = @json($categories);

        $('#search-day').daterangepicker({
                opens: 'right',
                autoUpdateInput: false,
                locale: {
                    format: 'YYYY-MM-DD'
                }
            },
            function(start, end, label) {
                startDate = moment(start).format('YYYY-MM-DD');
                endDate = moment(end).format('YYYY-MM-DD');
                tradeDates = [startDate, endDate];
            }
        );
        $('#search-day').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        });
        $('#search-day').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            tradeDates = [];
        });

        function doSearch() {
            tiktokTable.column(1).search($('#search-title').val());
            tiktokTable.column(3).search(tradeDates.join(':'), false, false);
            tiktokTable.draw();
        }

        tiktokTable = $('#news-list').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: BASE_URL + 'api/newslist',
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
                    className: "text-center"
                }, {
                    data: 'title',
                    className: "text-left"
                }, {
                    data: null,
                    className: "text-center"
                },
                {
                    data: 'writer',
                    className: "text-center"
                }, {
                    data: 'created_at',
                    className: "text-center"
                },
                {
                    data: null,
                    className: "text-center"
                },
            ],
            createdRow: function(row, data, index) {
                var pageInfo = tiktokTable.page.info();

                // Index
                $('td', row).eq(0).html('').append(
                    '<span>' + (pageInfo.page * pageInfo.length + index + 1) + '</span>'
                );

                let link = BASE_URL + 'posts/' + data['id'];
                $('td', row).eq(1).html('').append(
                    '<a href="' + link + '" target="_blank">' + data['title'] + '</a>'
                );

                $('td', row).eq(2).html('').append(
                    data['category'] == null ? '' : (data['category'] in categories ? categories[data[
                        'category']][0] : '')
                );

                $('td', row).eq(5).html('').append(
                    '<a href="#" class="delete_btn list-icons-item" data-popup="tooltip" title="title" data-container="body" data-id="' +
                    data['id'] + '"><i class="feather icon-trash"></i></a>'
                );
            },
            initComplete: function() {},
            language: {
                emptyTable: "{{ trans('app.datatable.language.emptyTable') }}",
                info: "{{ trans('app.datatable.language.info') }}",
                infoEmpty: "{{ trans('app.datatable.language.infoEmpty') }}",
                infoFiltered: "{{ trans('app.datatable.language.infoFiltered') }}",
                infoThousands: "{{ trans('app.datatable.language.infoThousands') }}",
                lengthMenu: "{{ trans('app.datatable.language.lengthMenu') }}",
                loadingRecords: "{{ trans('app.datatable.language.loadingRecords') }}",
                processing: "{{ trans('app.datatable.language.processing') }}",
                search: "{{ trans('app.datatable.language.search') }}",
                zeroRecords: "{{ trans('app.datatable.language.zeroRecords') }}",
                paginate: {
                    first: "{{ trans('app.datatable.language.paginate.first') }}",
                    last: "{{ trans('app.datatable.language.paginate.last') }}",
                    next: "{{ trans('app.datatable.language.paginate.next') }}",
                    previous: "{{ trans('app.datatable.language.paginate.previous') }}",
                },
                aria: {
                    sortAscending: "{{ trans('app.datatable.language.aria.sortAscending') }}",
                    sortDescending: "{{ trans('app.datatable.language.aria.sortDescending') }}",
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
            $('#modal_id').val(id);
            $('#modal_default').modal('show');
        });

        $('#confirm_agree').click(function(e) {
            var id = $('#modal_id').val();
            $.get({
                url: BASE_URL + 'api/deletenews/' + id,
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
