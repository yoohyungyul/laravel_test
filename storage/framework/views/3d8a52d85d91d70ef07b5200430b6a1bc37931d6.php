<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	<span aria-hidden="true">×</span>
  </button>
  <h4 class="modal-title" id="exampleFillInModalTitle">전후 사진 등록</h4>
</div>
<div class="modal-body">
  <form autocomplete="off" name="form_add" method="POST" action="/dbmon/add/beforeafter"  enctype="multipart/form-data" >
  <input type="hidden" name="id" value="<?php echo e($id); ?>" />
  <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
  <input type="hidden" name="returnurl" value="<?php echo e($returnurl); ?>">  
	<div class="row">
	  <div class="col-xl-12 form-group">
		<h4 class="example-title">제목</h4>
		<input type="text" class="form-control" name="title" placeholder="제목">
	  </div>
	  <div class="col-xl-6 form-group">
		<h4 class="example-title">전 사진</h4>
		<input type="file" class="form-control" name="b_img"/>
	  </div>
	  <div class="col-xl-6 form-group">
		<h4 class="example-title">후 사진</h4>
		<input type="file" class="form-control" name="a_img"/>
	  </div>
	  <div class="col-xl-12 form-group text-center">
		<button type="submit" class="btn btn-danger">등록하기</button>
	  </div>
	</div>
  </form>
</div>
<script>
</script>