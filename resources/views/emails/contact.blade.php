<label style="color: #0000FF">お世話になっております!</label>
<br><br>

{{ env('APP_NAME') }}から以下のようなお問い合わせが来ました。<br>

↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓<br><br>
<label style="color: black;">タイトル：<br>{!! nl2br(e($title)) !!}</label>
<br><br>
<label style="color: black;">本文：<br>{!! nl2br(e($content)) !!}</label>
<br><br>
<label style="color: black;">送信元 :<br> {!! nl2br(e($email)) !!}</label><br><br>
↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
<br><br>

<br>
