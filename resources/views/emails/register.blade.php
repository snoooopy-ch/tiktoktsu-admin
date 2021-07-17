<label style="color: #0000FF">Hello {{ $name }}! This is reply message from {{ env('APP_NAME') }}.</label>
<br><br>

<label style="color: red;">{!! nl2br(e($subject)) !!}</label>
<br><br>
<label style="color: #0fbf7e;">{!! nl2br(e($msg)) !!}</label>
<br><br>

<br>Thank for use our program.
