<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	<span aria-hidden="true">×</span>
  </button>
  <h4 class="modal-title" id="exampleFillInModalTitle">교통정보 등록</h4>
</div>
<div class="modal-body">
  <form autocomplete="off" name="form_add" method="POST" action="/dbmon/add/trans" >
  <input type="hidden" name="id" value="<?php echo e($id); ?>" />
  <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
  <input type="hidden" name="returnurl" value="<?php echo e($returnurl); ?>">  
	<div class="row">
	  <div class="col-xl-6 form-group">
		<h4 class="example-title">교통편명</h4>
		<input type="text" class="form-control" name="facility" placeholder="교통편명">
	  </div>
	  <div class="col-xl-6 form-group">
		<h4 class="example-title">호선</h4>
		<input type="text" class="form-control" name="line_number" placeholder="호선">
	  </div>
	  <div class="col-xl-6 form-group">
		<h4 class="example-title">하차지점</h4>
		<input type="text" class="form-control" name="alight_point" placeholder="하차지점">
	  </div>
	  <div class="col-xl-6 form-group">
		<h4 class="example-title">방향</h4>
		<input type="text" class="form-control" name="direction" placeholder="방향">
	  </div>
	  <div class="col-xl-6 form-group">
		<h4 class="example-title">거리(m)</h4>
		<input type="text" class="form-control" name="distance" placeholder="거리(m)">
	  </div>
	  <div class="col-xl-12 form-group text-center">
		<button type="submit" class="btn btn-danger">등록하기</button>
	  </div>
	</div>
  </form>
</div>