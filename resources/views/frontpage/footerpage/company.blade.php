@extends('layouts.front')

@section('title', '運営会社')

@section('styles')
    <link href="{{ cAsset('vendor/datatables/datatables.css') }}" rel="stylesheet">
    <style>
        #formerrors {
            display: none;
        }

        #company-list_info {
            display: none;
        }

    </style>
@endsection

@section('contents')
    <div class="content-body">
        <div class="card">
            <div class="card-header">
                <h1 class="text-center mt-3 mb-2 text-primary mr-auto ml-auto">運営会社</h1>
            </div>
            <div class="card-body">
                <div class="table table-no-border table-striped table-responsive">
                    <table id="company-list" class="table table-striped">
                        <thead class="d-none">
                        </thead>
                        <tbody>
                            <tr>
                                <td>会社名</td>
                                <td>株式会社ウェブスタイル（WEBSTYLE Inc.）</td>
                            </tr>
                            <tr>
                                <td>代表者</td>
                                <td>小林誠</td>
                            </tr>
                            <tr>
                                <td>設立年月日</td>
                                <td>2016年10月3日</td>
                            </tr>
                            <tr>
                                <td>資本金</td>
                                <td>100万円</td>
                            </tr>
                            <tr>
                                <td>事業内容</td>
                                <td>WEBサイトの企画・運営・制作全般</td>
                            </tr>
                            <tr>
                                <td>所在地</td>
                                <td>〒372-0818 群馬県伊勢崎市連取元町20-7</td>
                            </tr>
                            <tr>
                                <td>ウェブサイト</td>
                                <td><a href="https://www.wstyle.co.jp/">https://www.wstyle.co.jp/</a></td>
                            </tr>
                            <tr>
                                <td>プライバシーポリシー</td>
                                <td><a href="https://tiktoktsu.com/privacy/">https://tiktoktsu.com/privacy/</a></td>
                            </tr>
                            <tr>
                                <td>メディア紹介実績</td>
                                <td><a href="https://tiktoktsu.com/media/">https://tiktoktsu.com/media/</a></td>
                            </tr>
                            <tr>
                                <td>お問い合わせ</td>
                                <td>こちらのフォームよりお問い合わせください</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ cAsset('vendor/datatables/datatables.js') }}"></script>
    <script>
        let companyTable;
        companyTable = $('#company-list').DataTable({
            processing: true,
            serverSide: false,
            searching: true,
            bSort: false,
            bPaginate: false,
        });

    </script>
@endsection
