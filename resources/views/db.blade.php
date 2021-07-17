@extends('layouts.afterlogin')

@section('styles')
<style>
#formerrors {
    display: none;
}
</style>
@endsection

@section('contents')
    <div class="content-body">
        <section class="flexbox-container justify-content-center">
            <div class="card-body flexbox-container justify-content-center"  id="formerrors">
                <div class="alert alert-danger">
                    <ul class="m-0">
                    </ul>
                </div>
            </div>
            <div class="row flexbox-container justify-content-center">
                <div class="col-lg-3 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('db.download') }}">
                                <div class="d-flex flex-column align-items-start p-4">SQLダウンロード</div>
                            </a>
                        </div>
                        
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div id="selectContainer" class="d-flex flex-column align-items-start p-4" onclick="openFileDialog();">SQLファイルを選択</div>
                        </div>
                        <input type="file" id="fileInput" hidden onchange="fileSelected(event);"/>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center" id="filename"></div>
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <button type="button" class="btn mb-1 btn-success btn-lg btn-block waves-effect waves-light" onclick="uploadFile();">SQLアップロード</button>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/encoding-japanese/1.0.30/encoding.js" integrity="sha512-ooP6HUsSwhxdioCgjhI3ECNthmwlWGt5u1uz5CImhKO1sA2AzRDdJE6u7BkPaXo68WWKiNfZOH5tYTTY7gn10Q==" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.js" integrity="sha512-otOZr2EcknK9a5aa3BbMR9XOjYKtxxscwyRHN6zmdXuRfJ5uApkHB7cz1laWk2g8RKLzV9qv/fl3RPwfCuoxHQ==" crossorigin="anonymous"></script>

    <script>
        let targetFile;

        function readfile(file) {
            reader = new FileReader();
            reader.readAsBinaryString(file);
            reader.onload = function(event) {
                var result = event.target.result;
                var sjisArray = str2Array(result);
                var uniArray = Encoding.convert(sjisArray, 'UNICODE', 'SJIS');
                var result = Encoding.codeToString(uniArray);
                
                content = result.split('\n').join('||');

                $.LoadingOverlay("show");
                $.post({
                    url: BASE_URL + 'api/addorders',
                    data: {
                        content: content,
                    },
                    success: function(result) {
                        $.LoadingOverlay("hide");

                        var errors = result.errors;
                        var html = '';

                        $.each(errors, function(key, val){
                            html += '<li>' + val + '</li>';
                        });

                        if (html == '') {
                            html += '<li>' + result.message + '</li>';
                        }
                        
                        $('#formerrors').css('display', 'block');
                        $('#formerrors ul').html('');
                        $('#formerrors ul').html(html);
                    },
                    error: function(result) {
                        $.LoadingOverlay("hide");
                    }
                });
            }
        }

        function str2Array(str) {
            var array = [],i,il=str.length;
            for(i=0;i<il;i++) array.push(str.charCodeAt(i));
            return array;
        }

        function openFileDialog() {
            $('#fileInput').trigger('click');
        }

        function fileSelected(event) {
            targetFile = event.target.files[0];
            $('#filename').html(targetFile.name);
        }

        function uploadFile() {
            var formData = new FormData();
            var imagefile = document.querySelector('#file');
            formData.append("uploadFile", targetFile);
            $.LoadingOverlay("show");
            $.ajax({
                contentType: false,
                processData: false,
                url: BASE_URL + 'db/upload',
                type: 'POST',
                data: formData,
                success: function(result) {
                $.LoadingOverlay("hide");
                    console.log(result);
                },
                error: function(err) {
                    $.LoadingOverlay("hide");
                    console.log(err);
                }
            });
        }
    </script>
@endsection
