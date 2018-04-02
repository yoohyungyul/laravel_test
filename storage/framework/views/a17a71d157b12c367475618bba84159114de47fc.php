<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	<span aria-hidden="true">×</span>
  </button>
  <h4 class="modal-title" id="exampleFillInModalTitle">간호등급 등록</h4>
</div>
<div class="modal-body">
	<form autocomplete="off" name="form_add" method="POST" action="/dbmon/add/nursing"  >
	<input type="hidden" name="id" value="<?php echo e($id); ?>" />
	<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
	<input type="hidden" name="returnurl" value="<?php echo e($returnurl); ?>"> 
	<div class="row">
		<div class="col-xl-6 form-group">
			<h4 class="example-title">간호 등급</h4>
			<select  class="form-control " name="nursing_grade_id" >
				<option value="">선택</option>
				<?php $__currentLoopData = $nursingGradeData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
				<option value="<?php echo e($Data->id); ?>" ><?php echo e($Data->gov_name); ?></option>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</select>
		</div>
		<div class="col-xl-6 form-group">
			<h4 class="example-title">등급</h4>
			<select  class="form-control " name="grade" >
				<option value="">선택</option>
				<?php for($i = 1 ; $i <= 7; $i++): ?>
				<option value="<?php echo e($i); ?>" ><?php echo e($i); ?></option>
				<?php endfor; ?>
			</select>
		</div>
		<div class="col-xl-12 form-group text-center">
			<button type="submit" class="btn btn-danger">등록하기</button>
		</div>
	</div>
	</form>
</div>
 