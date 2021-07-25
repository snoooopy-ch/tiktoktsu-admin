var isRtl;
var listTable;
var filterDates = [];

$(function () {
    isRtl = $('body').attr('dir') === 'rtl' || $('html').attr('dir') === 'rtl';

    // Date
    $('#filter-date').daterangepicker({
        opens: isRtl ? 'right' : 'left',
        autoUpdateInput: false,
        locale: {
            format: 'YYYY-MM-DD'
        }
    },
        function (start, end, label) {
            var startDate = moment(start).format('YYYY-MM-DD');
            var endDate = moment(end).format('YYYY-MM-DD');
            filterDates = [startDate, endDate];
        }
    );
    $('#filter-date').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' ~ ' + picker.endDate.format('YYYY-MM-DD'));
    });
    $('#filter-date').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
        filterDates = [];
    });


});

function doSearch() {
    var login_id = $('#filter-login_id').val();
    var name = $('#filter-name').val();
    var role = $('#filter-role').val();
    var status = $('#filter-status').val();

    listTable.column(1).search(login_id, false, false);
    listTable.column(2).search(name, false, false);
    listTable.column(7).search(role, false, false);
    listTable.column(8).search(status, false, false);
    listTable.column(9).search(filterDates.join(':'), false, false).draw();
}
