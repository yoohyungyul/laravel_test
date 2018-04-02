<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	<span aria-hidden="true">×</span>
  </button>
  <h4 class="modal-title" id="exampleFillInModalTitle">교통정보 수정</h4>
</div>
<div class="modal-body">
  <form autocomplete="off" name="form_mod" method="POST" action="/dbmon/mod/trans" >
  <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
  <input type="hidden" name="trans_id" value="<?php echo e($trans_id); ?>" />  
  <input type="hidden" name="returnurl" value="<?php echo e($returnurl); ?>">  
	<div class="row">
	  <div class="col-xl-6 form-group">
		<h4 class="example-title">교통편명</h4>
		<input type="text" class="form-control" name="facility" placeholder="교통편명" value="<?php echo e($clinicTransportation->facility); ?>">
	  </div>
	  <div class="col-xl-6 form-group">
		<h4 class="example-title">호선</h4>
		<input type="text" class="form-control" name="line_number" placeholder="호선" value="<?php echo e($clinicTransportation->line_number); ?>">
	  </div>
	  <div class="col-xl-6 form-group">
		<h4 class="example-title">하차지점</h4>
		<input type="text" class="form-control" name="alight_point" placeholder="하차지점" value="<?php echo e($clinicTransportation->alight_point); ?>">
	  </div>
	  <div class="col-xl-6 form-group">
		<h4 class="example-title">방향</h4>
		<input type="text" class="form-control" name="direction" placeholder="방향" value="<?php echo e($clinicTransportation->direction); ?>">
	  </div>
	  <div class="col-xl-6 form-group">
		<h4 class="example-title">거리(m)</h4>
		<input type="text" class="form-control" name="distance" placeholder="거리(m)" value="<?php echo e($clinicTransportation->distance); ?>">
	  </div>
	  <div class="col-xl-12 form-group text-center">
		<button type="submit" class="btn btn-danger">수정하기</button>
	  </div>
	</div>
  </form>
</div>