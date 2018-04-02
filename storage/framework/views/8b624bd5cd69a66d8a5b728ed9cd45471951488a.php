<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	<span aria-hidden="true">×</span>
  </button>
  <h4 class="modal-title" id="exampleFillInModalTitle">의사 수정</h4>
</div>
<div class="modal-body">
  <form autocomplete="off" name="form_add" method="POST" action="/dbmon/mod/doctor"  enctype="multipart/form-data" >
  <input type="hidden" name="doctor_id" value="<?php echo e($doctor_id); ?>" />
  <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
  <input type="hidden" name="returnurl" value="<?php echo e($returnurl); ?>">  
	<div class="row">
	  <div class="col-xl-6 form-group">
		<h4 class="example-title">한글 성</h4>
		<input type="text" class="form-control" name="first_name_kr" placeholder="한글 성" value="<?php echo e($DoctorData->first_name_kr); ?>">
	  </div>
	  <div class="col-xl-6 form-group">
		<h4 class="example-title">한글 이름</h4>
		<input type="text" class="form-control" name="last_name_kr" placeholder="한글 이름" value="<?php echo e($DoctorData->last_name_kr); ?>">
	  </div>
	  <div class="col-xl-6 form-group">
		<h4 class="example-title">영문 성</h4>
		<input type="text" class="form-control" name="first_name_en" placeholder="영문 성" value="<?php echo e($DoctorData->first_name_en); ?>">
	  </div>
	  <div class="col-xl-6 form-group">
		<h4 class="example-title">영문 이름</h4>
		<input type="text" class="form-control" name="last_name_en" placeholder="영문 이름" value="<?php echo e($DoctorData->last_name_en); ?>">
	  </div>
	  <div class="col-xl-6 form-group">
		<h4 class="example-title">전화번호</h4>
		<input type="text" class="form-control" name="phone" placeholder="전화번호" value="<?php echo e($DoctorData->phone); ?>">
	  </div>
	  <div class="col-xl-6 form-group">
		<h4 class="example-title">이메일</h4>
		<input type="email" class="form-control" name="email" placeholder="이메일" value="<?php echo e($DoctorData->email); ?>">
	  </div>
	  <div class="col-xl-12 form-group">
		<h4 class="example-title">학력</h4>
		<div class="row">
			<div class="col-xl-6 form-group">
				<select  class="form-control " name="education_id" id="educationSelect">
					<option value="">선택</option>
					<?php $__currentLoopData = $educationData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
						<option value="<?php echo e($Data->id); ?>" <?php if( $Data->id = $DoctorData->education_id): ?> selected="selected" <?php endif; ?>><?php echo e($Data->school_name); ?></option>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</select>
				<input type="text" class="form-control "  id="educationAdd" name="newEducation" placeholder="최종 학력 직접입력" style="display: none;">
			</div>	
			<div class="col-xl-6 form-group">
				<div class="checkbox-custom">
					<input type="checkbox" name="addNewEducation" 
						   id="thereIsNoEducation">
					<label for="thereIsNoEducation">학력을 직접 입력하시겠습니까?</label>
				</div>
			</div>
		</div>		
	  </div>
	  <div class="col-xl-12 form-group">
		<div class="row">
			<div class="col-xl-6 form-group">
				<h4 class="example-title">전문의
					<button type="button" class="btn btn-default btn-xs" id="doctor-specialty-add-btn"> + </button>
				</h4>
				<div id="specialty-form-group">	
					
					<select class="form-control" name="specialty_id[]" style="margin-bottom:5px">
						<option value="">선택</option>	
						<?php $__currentLoopData = $specialtyData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
							<option value="<?php echo e($Data->id); ?>" ><?php echo e($Data->name); ?></option>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</select>
				</div>
				<ul>
					<?php $__currentLoopData = $DoctorSpecialtyData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
					<li><input type="hidden" name="doctor_specialty_uid[]" value="<?php echo e($data->id); ?>" /><?php echo e($data->name); ?> <button type="button" class="btn btn-sm btn-icon btn-flat btn-default specialty_removebutton"  ><i class="icon wb-close" aria-hidden="true"></i></button></li>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</ul>
			</div>
			<div class="col-xl-6 form-group">
				<h4 class="example-title">진료과목
					<button type="button" class="btn btn-default btn-xs" id="doctor-medical-subject-add-btn"> + </button>
				</h4>
				<div id="medical-subject-form-group">					
					<select class="form-control" name="medical_subject_id[]" style="margin-bottom:5px">
						<option value="">선택</option>	
						<?php $__currentLoopData = $medicalSubjectData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
							<option value="<?php echo e($Data->id); ?>" ><?php echo e($Data->gov_name); ?></option>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</select>
				</div>
				<ul>
					<?php $__currentLoopData = $DoctorMedicalSubjectData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
					<li><input type="hidden" name="doctor_medical_subject_uid[]" value="<?php echo e($data->id); ?>" /><?php echo e($data->gov_name); ?> <button type="button" class="btn btn-sm btn-icon btn-flat btn-default specialty_removebutton"  ><i class="icon wb-close" aria-hidden="true"></i></button></li>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</ul>
			</div>
		</div>
	  </div>
	  <div class="col-xl-12 form-group">
		<h4 class="example-title">의사사진</h4>
		<div class="row">
			<div class="col-xl-6 form-group">
				<input type="file" class="form-control" name="d_img[]"/>
			</div>	
			<div class="col-xl-6 form-group">
				<input type="file" class="form-control" name="d_img[]"/>
			</div>	
			<div class="col-xl-6 form-group">
				<input type="file" class="form-control" name="d_img[]"/>
			</div>	
			<div class="col-xl-6 form-group">
				<input type="file" class="form-control" name="d_img[]"/>
			</div>	
			<ul>
				<?php $__currentLoopData = $MediaData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
				<li><input type="hidden" name="media_uid[]" value="<?php echo e($data->id); ?>" /><a href="<?php echo e($data->path); ?>" target="_blank"><?php echo e($data->name); ?></a> <button type="button" class="btn btn-sm btn-icon btn-flat btn-default specialty_removebutton"  ><i class="icon wb-close" aria-hidden="true"></i></button></li>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</ul>
		</div>
	  </div>
	  <div class="col-xl-12 form-group">
		<h4 class="example-title">메모</h4>
		<textarea class="form-control" rows="3" placeholder="메모 입력" name="memo"><?php echo e($DoctorData->memo); ?></textarea>
	  </div>
	  <div class="col-xl-12 form-group text-center">
		<button type="submit" class="btn btn-danger">수정하기</button>
	  </div>
	</div>
  </form>
</div>
<script>
$('#thereIsNoEducation').change(function () {
    if ($('#thereIsNoEducation').is(':checked')) {
        $('#educationAdd').show();
        $('#educationSelect').hide();
    } else {
        $('#educationSelect').show();
        $('#educationAdd').hide();
    }
});

$('#doctor-specialty-add-btn').click(function () {
	var data = `
		<select  class="form-control " name="specialty_id[]" style="margin-bottom:5px">
			<option value="">선택</option>	
			<?php $__currentLoopData = $specialtyData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
			<option value="<?php echo e($Data->id); ?>" ><?php echo e($Data->name); ?></option>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</select>
	`;
	$("#specialty-form-group").append(data);
	/*
    $.get("/dbmon/form-component/doctor/specialty-block", function (data) {
        $("#specialty-form-group").append(data);
    });
	*/
});


$('#doctor-medical-subject-add-btn').click(function () {
	var data = `
		<select class="form-control" name="medical_subject_id[]" style="margin-bottom:5px">
			<option value="">선택</option>	
			<?php $__currentLoopData = $medicalSubjectData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
				<option value="<?php echo e($Data->id); ?>" ><?php echo e($Data->gov_name); ?></option>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</select>
	`;
	 $("#medical-subject-form-group").append(data);
	/*
    $.get(rootPath + "dbmon/form-component/doctor/medical-subject-block", function (data) {
        $("#medical-subject-form-group").append(data);
    });
	*/

})

$(document).on('click', 'button.specialty_removebutton', function () { // <-- changes
	$(this).closest('li').remove();
    return false;
});
</script>