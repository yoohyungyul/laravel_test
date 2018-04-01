<p>이름 : <?php echo e($data['name']); ?></p>
<p>이메일 : <?php echo e($data['email']); ?></p>
<p>제목 : <?php echo e($data['subject']); ?></p>
<p>전화번호 : <?php echo e($data['phone']); ?></p>
<p>내용<br>
<?php echo str_replace(chr(13),'<br />',$data['message']) ?>
</p>
<p>등록일  : <?php echo e($data['d_regis']); ?></p>