<p>회원 : <a href="http://clinicinsite.com/dbmon/user/view?id=<?php echo e($data['user_id']); ?>" target="_blank"><?php echo e($data['name']); ?></a></p>
<p>이메일 : <?php echo e($data['email']); ?></p>
<p>생년월일 : <?php echo e($data['birthday']); ?></p>
<p>성별 : <?php echo e($data['gender']); ?></p>
<p>병원 : <?php echo e($data['clinic']); ?> </p>
<p>시술  : <?php echo e($data['procedure']); ?></p>
<p>
내용<br>
<?php echo str_replace(chr(13),'<br />',$data['content']) ?>
</p>
<p>등록일  : <?php echo e($data['d_regis']); ?></p>
