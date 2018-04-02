<p>이름 : {{$data['name']}}</p>
<p>이메일 : {{$data['email']}}</p>
<p>제목 : {{$data['subject']}}</p>
<p>전화번호 : {{$data['phone']}}</p>
<p>내용<br>
<?php echo str_replace(chr(13),'<br />',$data['message']) ?>
</p>
<p>등록일  : {{$data['d_regis']}}</p>