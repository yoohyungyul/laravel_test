<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	<span aria-hidden="true">×</span>
  </button>
  <h4 class="modal-title" id="exampleFillInModalTitle">대표시술 등록</h4>
</div>
<div class="modal-body" style="padding-top:20px;">
  <form autocomplete="off" name="form_add" method="POST" action="/dbmon/add/popularprocedur"  enctype="multipart/form-data" >
  <input type="hidden" name="id" value="<?php echo e($id); ?>" />
  <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
  <input type="hidden" name="returnurl" value="<?php echo e($returnurl); ?>">  
	<div class="row">	  
	  <div class="col-xl-12 form-group">
		<h4 class="example-title">제목</h4>
		<input type="text" class="form-control" name="title" placeholder="제목">
	  </div>
	   <div class="col-xl-12 form-group">
		<h4 class="example-title">내용</h4>
		<textarea class="form-control" rows="10" placeholder="내용 입력" name="description"></textarea>
	  </div>
	  
	  <div class="col-xl-12 form-group">
		<h4 class="example-title">이미지</h4>
		<div class="row">
			<div class="col-xl-6 form-group">
				<input type="file" class="form-control" name="p_img[]"/>
			</div>	
			<div class="col-xl-6 form-group">
				<input type="file" class="form-control" name="p_img[]"/>
			</div>	
			<div class="col-xl-6 form-group">
				<input type="file" class="form-control" name="p_img[]"/>
			</div>	
			<div class="col-xl-6 form-group">
				<input type="file" class="form-control" name="p_img[]"/>
			</div>	
		</div>
	  </div>
	 
	  <div class="col-xl-12 form-group text-center">
		<button type="submit" class="btn btn-danger">등록하기</button>
	  </div>
	</div>
  </form>
</div>
<script>
</script>