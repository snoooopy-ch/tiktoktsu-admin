var isRtl;

$(function () {
    isRtl = $('body').attr('dir') === 'rtl' || $('html').attr('dir') === 'rtl';

    // Date
    $('#birthday').datepicker({
        orientation: isRtl ? 'auto right' : 'auto left',
        format: 'yyyy-mm-dd',
    });
});

function readURL(input, img) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            img.attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}

$('#avatar').on('change', function() {
    readURL(this, $('#avatar-img'));
});
