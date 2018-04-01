<?php
	$previousImgData  = DB::table('kmh_media')->where('id', $clinicBeforeAfter->previous_media_id)->first();
	$afterImgData  = DB::table('kmh_media')->where('id', $clinicBeforeAfter->after_media_id)->first();

?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	<span aria-hidden="true">×</span>
  </button>
  <h4 class="modal-title" id="exampleFillInModalTitle">전후 사진 수정</h4>
</div>
<div class="modal-body">
  <form autocomplete="off" name="form_add" method="POST" action="/dbmon/mod/beforeafter"  enctype="multipart/form-data" >
  <input type="hidden" name="beforeafter_id" value="<?php echo e($beforeafter_id); ?>" />
  <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
  <input type="hidden" name="returnurl" value="<?php echo e($returnurl); ?>">  
	<div class="row">
	  <div class="col-xl-12 form-group">
		<h4 class="example-title">제목</h4>
		<input type="text" class="form-control" name="title" placeholder="제목" value="<?php echo e($clinicBeforeAfter-> title); ?>">
	  </div>
	  <div class="col-xl-6 form-group">
		<h4 class="example-title">전 사진</h4>
		<input type="file" class="form-control" name="b_img"/>
		<?php if(count($previousImgData) > 0): ?>
			<ul>
				<li><input type="hidden" name="previous_media_id" value="<?php echo e($previousImgData->id); ?>" /><a href="<?php echo e($previousImgData->path); ?>" target="_blank"><?php echo e($previousImgData->name); ?></a> <button type="button" class="btn btn-sm btn-icon btn-flat btn-default specialty_removebutton"  ><i class="icon wb-close" aria-hidden="true"></i></button></li>
			</ul>
		<?php endif; ?>
	  </div>
	  <div class="col-xl-6 form-group">
		<h4 class="example-title">후 사진</h4>
		<input type="file" class="form-control" name="a_img"/>
		<?php if(count($afterImgData) > 0): ?>
			<ul>
				<li><input type="hidden" name="after_media_id" value="<?php echo e($afterImgData->id); ?>" /><a href="<?php echo e($afterImgData->path); ?>" target="_blank"><?php echo e($afterImgData->name); ?></a> <button type="button" class="btn btn-sm btn-icon btn-flat btn-default specialty_removebutton"  ><i class="icon wb-close" aria-hidden="true"></i></button></li>
			</ul>
		<?php endif; ?>
	  </div>
	  <div class="col-xl-12 form-group text-center">
		<button type="submit" class="btn btn-danger">수정하기</button>
	  </div>
	</div>
  </form>
</div>
<script>
$(document).on('click', 'button.specialty_removebutton', function () { // <-- changes
	$(this).closest('li').remove();
    return false;
});
</script>