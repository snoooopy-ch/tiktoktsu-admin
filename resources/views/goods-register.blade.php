@extends('layouts.afterlogin')

@section('styles')
@endsection

@section('contents')
    <div class="content-body">
        <section class="flexbox-container justify-content-center">
            <div class="row flexbox-container justify-content-center">
                <div class="col-lg-3 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div id="dropContainer" class="d-flex flex-column align-items-start p-4">ドラッグドロップ</div>
                        </div>
                        
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div id="selectContainer" class="d-flex flex-column align-items-start p-4" onclick="openFileDialog();">ファイルを選択</div>
                        </div>
                        <input type="file" id="fileInput" hidden onchange="fileSelected(event);"/>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center" id="filename"></div>
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <button type="button" class="btn mb-1 btn-success btn-lg btn-block waves-effect waves-light" onclick="uploadFile();">アップロード</button>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/encoding-japanese/1.0.30/encoding.js" integrity="sha512-ooP6HUsSwhxdioCgjhI3ECNthmwlWGt5u1uz5CImhKO1sA2AzRDdJE6u7BkPaXo68WWKiNfZOH5tYTTY7gn10Q==" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    <script>
        let targetFile;
        dropContainer.ondragover = dropContainer.ondragenter = function(evt) {
            evt.preventDefault();
        };

        dropContainer.ondrop = function(evt) {
            fileInput.files = evt.dataTransfer.files;
            if (evt.dataTransfer.files.length == 1) {
                targetFile = evt.dataTransfer.files[0];
                $('#filename').html(targetFile.name);
            }
           
            evt.preventDefault();
        };

        function readfile(file) {
            reader = new FileReader();
            reader.readAsBinaryString( file );
            reader.onload = function(event) {
                var result = event.target.result;
                var sjisArray = str2Array(result);
                var uniArray = Encoding.convert(sjisArray, 'UNICODE', 'SJIS');
                var result = Encoding.codeToString(uniArray);
                
                allTextLines = result;
                const content = allTextLines.split('\n').join('||');;
                $.LoadingOverlay("show");
                $.post({
                    url: BASE_URL + 'api/addgoods',
                    data: {
                        content: content,
                    },
                    success: function(result) {
                        window.location.href = "{{ route('goods.view')}}";
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
            readfile(targetFile);
        }
    </script>
@endsection
