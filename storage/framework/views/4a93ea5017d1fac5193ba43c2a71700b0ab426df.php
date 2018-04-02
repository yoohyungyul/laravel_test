<?php
	$previousImgData  = DB::table('kmh_media')->where('id', $clinicBeforeAfter->previous_media_id)->first();
	$afterImgData  = DB::table('kmh_media')->where('id', $clinicBeforeAfter->after_media_id)->first();

?>

<div class="modal-header ">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="myModalLabel">전후 사진 등록</h4>
</div>
<div class="modal-body">
	<form autocomplete="off" name="form_add" method="POST" action="/member/mod/beforeAfter"  enctype="multipart/form-data" onsubmit="return writeCheck(this);"  >
	<input type="hidden" name="beforeafter_id" value="<?php echo e($beforeafter_id); ?>" />
	<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
	<input type="hidden" name="returnurl" value="<?php echo e($returnurl); ?>"> 

	<div class="row">
		<div class="col-lg-12">
			<div class="form-block border">
				<label for="property-location">제목</label>
				<input type="text" class="border" name="title" placeholder="제목" value="<?php echo e($clinicBeforeAfter-> title); ?>">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="form-block border">
				<label for="property-location">전 사진</label>
				<input type="file" class="form-control" name="b_img"/>
				<?php if(count($previousImgData) > 0): ?>
					<ul>
						<li><input type="hidden" name="previous_media_id" value="<?php echo e($previousImgData->id); ?>" /><a href="<?php echo e($previousImgData->path); ?>" target="_blank"><?php echo e($previousImgData->name); ?></a> <button type="button" class="btn btn-xs btn-danger specialty_removebutton"  >삭제</button></li>
					</ul>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="form-block border">
				<label for="property-location">후 사진</label>
				<input type="file" class="form-control" name="a_img"/>
				<?php if(count($afterImgData) > 0): ?>
					<ul>
						<li><input type="hidden" name="after_media_id" value="<?php echo e($afterImgData->id); ?>" /><a href="<?php echo e($afterImgData->path); ?>" target="_blank"><?php echo e($afterImgData->name); ?></a> <button type="button" class="btn btn-xs btn-danger specialty_removebutton"  >삭제</button></li>
					</ul>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-lg-12 text-right">
			<button type="submit" class="btn btn-primary">수정하기</button>
		</div>
	</div>
	</form>
</div>
<script>
function writeCheck(f) {

	if (f.title && f.title.value == '') {
		alert("제목을 입력해 주세요. ");
		f.title.focus();
		return false;
	}


	if (confirm('정말 수정 하시겠습니까?    '))
	{
		return true;	
	}
	return false;
}

$(document).on('click', 'button.specialty_removebutton', function () { // <-- changes
	$(this).closest('li').remove();
    return false;
});
</script>