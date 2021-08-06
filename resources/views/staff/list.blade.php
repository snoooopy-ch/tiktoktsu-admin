@extends('layouts.afterlogin')

@section('title', trans('staff.title'))

@section('styles')
    <link href="{{ cAsset('vendor/datatables/datatables.css') }}" rel="stylesheet">
    <link href="{{ cAsset('vendor/daterangepicker/daterangepicker.css') }}" rel="stylesheet">
@endsection

@section('contents')
    <?php global $UserGenderData; ?>
    <?php global $UserRoleData; ?>
    <?php global $StatusData; ?>

    <!-- users list start -->
    <section class="users-list-wrapper">
        <!-- users filter start -->
        <div class="card d-none">
            <div class="card-header">
                <h4 class="card-title">{{ trans('ui.search.filters') }}</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            </div>
            <div class="card-content collapse show">
                <div class="card-body">
                    <div class="users-list-filter">
                        <form>
                            <div class="row">
                                <div class="col-md">
                                    <label class="form-label">{{ trans('staff.table.login_id') }}</label>
                                    <input type="text" id="filter-login_id" class="form-control"
                                        placeholder="{{ trans('ui.search.any') }}">
                                </div>
                                <div class="col-md">
                                    <label class="form-label">{{ trans('staff.table.name') }}</label>
                                    <input type="text" id="filter-name" class="form-control"
                                        placeholder="{{ trans('ui.search.any') }}">
                                </div>
                                <div class="col-md">
                                    <label class="form-label">{{ trans('staff.table.role') }}</label>
                                    <select id="filter-role" class="form-control">
                                        <option value="99">{{ trans('ui.search.any') }}</option>
                                        @foreach (g_enum('UserRoleData') as $index => $role)
                                            <option value="{{ $index }}">{{ $role[0] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md">
                                    <label class="form-label">{{ trans('staff.table.status') }}</label>
                                    <select id="filter-status" class="form-control">
                                        <option value="99">{{ trans('ui.search.any') }}</option>
                                        @foreach (g_enum('StatusData') as $index => $status)
                                            <option value="{{ $index }}">{{ $status[0] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md">
                                    <label class="form-label">{{ trans('staff.table.reged_at') }}</label>
                                    <input type="text" id="filter-date" class="form-control"
                                        placeholder="{{ trans('ui.search.any') }}">
                                </div>
                                <div class="col-md col-xl-2">
                                    <label class="form-label">&nbsp;</label>
                                    <button type="button" onclick="javascript:doSearch()" class="btn btn-primary btn-block">
                                        <i class="fa fa-search"></i>&nbsp;{{ trans('ui.button.search') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- users filter end -->

        <input type="hidden" id="edit-caption" value="{{ trans('ui.button.edit') }}">
        <input type="hidden" id="delete-caption" value="{{ trans('ui.button.delete') }}">

        @if ($message = Session::get('flash_message'))
            <div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">×</button>
                {{ trans($message) }}
            </div>
        @endif

        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <a type="button" class="text-white btn btn-primary" href="{{ route('staff.add') }}">
                        <i class="fa fa-plus"></i>&nbsp;{{ trans('ui.button.add') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="staff-list" class="table">
                            <thead>
                                <tr>
                                    <th>{{ trans('staff.table.no') }}</th>
                                    <th>{{ trans('staff.table.login_id') }}</th>
                                    <th>{{ trans('staff.table.role') }}</th>
                                    <th>{{ trans('staff.table.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- users list ends -->
@endsection


@section('scripts')
    <script src="{{ cAsset('vendor/moment/moment.js') }}"></script>
    <script src="{{ cAsset('vendor/datatables/datatables.js') }}"></script>
    <script src="{{ cAsset('vendor/daterangepicker/daterangepicker.min.js') }}"></script>
    <script src="{{ cAsset('js/staff-list.js') }}"></script>

    <script>
        var UserRoleData = @json($UserRoleData);
        var UserGenderData = @json($UserGenderData);
        var StatusData = @json($StatusData);

        function addButtonClick() {
            $('#modal_default').modal('show');
        }

        $('#confirm_agree').click(function(e) {
            $.get({
                url: BASE_URL + 'api/addstaff/',
                data: {
                    content: {
                        user_login: $('#modal_user_login').val(),
                        password: $('#modal_user_password').val(),
                        password_confirm: $('#modal_user_password_confirm').val(),
                        role: $('#')
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

        function deleteStaff(id) {
            bootbox.confirm({
                message: "{{ trans('ui.alert.ask_delete') }}",
                buttons: {
                    cancel: {
                        className: 'btn btn-light',
                        label: '<i class="fa fa-times"></i> {{ trans('ui.button.cancel') }}'
                    },
                    confirm: {
                        label: '<i class="fa fa-check"></i> {{ trans('ui.button.confirm') }}'
                    }
                },
                callback: function(result) {
                    if (result) {
                        $.ajax({
                            url: BASE_URL + 'ajax/staff/delete',
                            type: 'POST',
                            data: {
                                'id': id,
                            },
                            success: function(result) {
                                listTable.ajax.reload();
                                if (result < 0) {
                                    bootbox.alert("{{ trans('ui.alert.delete_failed') }}");
                                } else if (result == 0) {
                                    bootbox.alert("{{ trans('ui.alert.delete_admin') }}");
                                }
                            },
                            error: function(err) {
                                listTable.ajax.reload();
                                bootbox.alert("{{ trans('ui.alert.delete_failed') }}");
                            }
                        });
                    }
                }
            });
        }

        listTable = $('#staff-list').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
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
            ajax: {
                url: BASE_URL + 'ajax/staff/search',
                type: 'POST',
            },
            columnDefs: [{
                targets: [1],
                orderable: false,
                searchable: false
            }],
            columns: [{
                    data: 'id',
                    className: "text-center"
                },
                {
                    data: 'user_login',
                    className: "text-center"
                },
                {
                    data: 'role',
                    className: "text-center"
                },
                {
                    data: null,
                    className: "text-center"
                },
            ],
            createdRow: function(row, data, index) {
                var pageInfo = listTable.page.info();

                // *********************************************************************
                // Index
                $('td', row).eq(0).html('').append(
                    '<span>' + (pageInfo.page * pageInfo.length + index + 1) + '</span>'
                );

                let role = [];
                if (data['role'] != null) {
                    $.each(data['role'].split(','), function(index, value) {
                        role.push(UserRoleData[value][0]);
                    });
                } else {
                    role = [];
                }

                $('td', row).eq(2).html('').append(role.join(', '));

                $('td', row).eq(3).html('').append(
                    '<a class="btn btn-icon btn-icon-rounded-circle text-danger btn-flat-danger user-tooltip" onclick="deleteStaff(' +
                    data["id"] + ')" title="' + $('#delete-caption').val() + '">' +
                    '<i class="fa fa-remove"></i></a>'
                );
            },
        });

    </script>
@endsection
