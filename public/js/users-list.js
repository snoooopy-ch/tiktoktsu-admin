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
        function(start, end, label) {
            var startDate = moment(start).format('YYYY-MM-DD');
            var endDate = moment(end).format('YYYY-MM-DD');
            filterDates = [startDate, endDate];
        }
    );
    $('#filter-date').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' ~ ' + picker.endDate.format('YYYY-MM-DD'));
    });
    $('#filter-date').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        filterDates = [];
    });

    initTable();
});

function doSearch() {
    var account = $('#filter-account').val();
    var name = $('#filter-name').val();
    var loginned = $('#filter-loginned').val();
    var status = $('#filter-status').val();

    listTable.column(1).search(account, false, false);
    listTable.column(2).search(name, false, false);
    listTable.column(8).search(loginned, false, false);
    listTable.column(9).search(status, false, false);
    listTable.column(10).search(filterDates.join(':'), false, false).draw();
}

$('#modal-btn-submit').on('click', function() {
    let id = $('#edit-id').val();
    let account = $('#account').val();
    let name = $('#name').val();
    let gender = $('#gender').val();
    let email = $('#email').val();
    let mobile = $('#mobile').val();
    let address = $('#address').val();
    let status = $('#status').val();

    $.ajax({
        url: BASE_URL + 'ajax/users/' + (id == 0 ? 'add' : 'edit'),
        type: 'POST',
        data: {
            id: id,
            account: account,
            name: name,
            gender: gender,
            email: email,
            mobile: mobile,
            address: address,
            status: status,
        },
        success: function(result) {
            $('#modal-users').modal('hide');
            listTable.ajax.reload();
        },
        error: function(err) {
            var errorMsg = err['responseJSON']['errors'];
            $('#frm-modal').find('select').removeClass('is-invalid');
            $('#frm-modal').find('input').removeClass('is-invalid');

            if (errorMsg['account'] != null) {
                $('#account').addClass('is-invalid');
                document.getElementById('account-error').innerHTML = errorMsg['account'];
            }
            if (errorMsg['name'] != null) {
                $('#name').addClass('is-invalid');
                document.getElementById('name-error').innerHTML = errorMsg['name'];
            }
            if (errorMsg['email'] != null) {
                $('#email').addClass('is-invalid');
                document.getElementById('email-error').innerHTML = errorMsg['email'];
            }
            if (errorMsg['gender'] != null) {
                $('#gender').addClass('is-invalid');
                document.getElementById('gender-error').innerHTML = errorMsg['gender'];
            }
            if (errorMsg['email'] != null) {
                $('#email').addClass('is-invalid');
                document.getElementById('email-error').innerHTML = errorMsg['email'];
            }
            if (errorMsg['mobile'] != null) {
                $('#mobile').addClass('is-invalid');
                document.getElementById('mobile-error').innerHTML = errorMsg['mobile'];
            }
            if (errorMsg['address'] != null) {
                $('#address').addClass('is-invalid');
                document.getElementById('address-error').innerHTML = errorMsg['address'];
            }
            if (errorMsg['status'] != null) {
                $('#status').addClass('is-invalid');
                document.getElementById('status-error').innerHTML = errorMsg['status'];
            }
        },
    });
});

$('#checkPageItemAll').on('click', function() {
    if ($(this).hasClass('allChecked')) {
        $('input[type="checkbox"]').prop('checked', false);
        $('#btn-activate-all').prop('disabled', true);
        $('#btn-bann-all').prop('disabled', true);
    } else {
        $('input[type="checkbox"]').prop('checked', true);
        $('#btn-activate-all').prop('disabled', false);
        $('#btn-bann-all').prop('disabled', false);
    }
    $(this).toggleClass('allChecked');
});

$('#users-list tbody').on('change', 'input[type="checkbox"]', function(){
    var data = listTable.$('input[type="checkbox"]').serialize();
    var selCount = data.split('checkItem').length - 1;
    $('#btn-activate-all').prop('disabled', !selCount);
    $('#btn-bann-all').prop('disabled', !selCount);

    // If checkbox is not checked
    if(!this.checked){
        var el = $('#transfer-list-select-all').get(0);

        if(el && el.checked && ('indeterminate' in el)){
            el.indeterminate = true;
        }
    }
});
