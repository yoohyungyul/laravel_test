
<?php $__env->startSection('content'); ?>


<!-- Page -->
<div class="page">
	<div class="page-header">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/dbmon">관리자홈</a></li>
			<li class="breadcrumb-item"><a href="/dbmon/procedureInfo">시술 관리하기</a></li>
		</ol>
		<h1 class="page-title">시술 정보 등록</h1>
	</div>
	<div class="page-content container-fluid" >
		<form autocomplete="off" name="form_add"  method="POST" onsubmit="return r_writeCheck(this);" action="/dbmon/add/procedure_info"  enctype="multipart/form-data" >
		<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
		<input type="hidden" name="returnurl" value="/dbmon/procedureInfo" />

		<div class="panel">
			<div class="panel-body container-fluid">
				
				<div class="row row-lg">
					<div class="col-xl-12">	
						<div class="form-group" >
							<label class="form-control-label" for="inputText">시술 사진</label>
							<div class="form-group  row">                                
								<div class="col-xs-6 col-md-3">
									<input type="file" data-plugin="dropify" data-default-file="" name="img"/>
                                </div>
                            </div>
						</div>
						<div class="form-group  pt-30" >
							
							<div class="row">
								<div class="col-md-2">
									<label class="form-control-label" for="inputText">구분</label>
									<div class="form-group  " >
                                        <select class="form-control"  name="depth">
											<option value="2">1차</option>
											<option value="3">2차</option>
										</select>
                                    </div>
								</div>
								<div class="col-md-2">
									<label class="form-control-label" for="inputText">1차 시술</label>
									<div class="form-group  " >
                                        <select class="form-control"  name="parent_id">
											<option value="1"  >선택안함</option>
											<?php $__currentLoopData = $ProcedureData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($data->id); ?>"  ><?php echo e($data->name); ?></option>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</select>
                                    </div>
								</div>
							</div>
						</div>
						<div class="form-group  pt-30" >
							<label class="form-control-label" for="inputText">시술 이름</label>
							<div class="row">
								<div class="col-xl-6">
									<div class="form-group  " >
                                        <input type="text" class="form-control" name="name"  placeholder="한글 이름" value="">   
										<p class="text-help">- 한글이름</p>
                                    </div>
								</div>
								<div class="col-xl-6">
									<div class="form-group  " >
										<input type="text" class="form-control"  name="name_en" placeholder="영문 이름" value=""/>
										<p class="text-help">- 영문이름</p>
									</div>
								</div>
							</div>
						</div>


						<div class="form-group  pt-30" >
							<label class="form-control-label" for="inputText">관련 시술</label>
							<div class="row">
								<div class="col-xl-12">
								
									<div class="form-group  " >
										<div class="select2-primary">
											<select class="form-control" multiple="multiple" data-plugin="select2" name="relation[]">
												<?php $__currentLoopData = $ProcedureSubData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											  <option value="<?php echo e($data->id); ?>"  >												
											   <?php echo e($data->name); ?></option>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											</select>
										  </div>                                        
									</div>
								</div>
							</div>
						</div>


					
						<div class="form-group  pt-30" >
							<label class="form-control-label" for="inputText">내용</label>
							<div class="row">								
								<div class="col-xl-12">
									<div class="form-group  " >
										<textarea class="form-control" placeholder="내용 입력" name="description"rows="10"></textarea>					

									</div>
								</div>
							</div>							
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-6"><a href="/dbmon/procedureInfo" class="btn  btn-default">돌아가기</a></div>
					<div class="col-6 text-right"><button type="submit" class="btn  btn-success">등록하기</button></div>
				</div>
			</div>
		</div>
		
		</form>
	</div>
</div>
 <!-- End Page -->  



<!-- Footer -->  
<?php echo $__env->make('dbmon_layouts.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<!-- End Footer -->

<!-- Javascript -->
<?php echo $__env->make('dbmon_layouts.js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<!-- End Javascript -->



<script>
(function(document, window, $) {
'use strict';
var Site = window.Site;
$(document).ready(function() {
  Site.run();
});
})(document, window, jQuery);

function r_writeCheck(f) {

	if (f.name && f.name.value == '') {
		alert("시술명을 입력해 주세요 ");
		f.name.focus();
		return false;
	}

	if (f.name_en && f.name_en.value == '') {
		alert("시술명_영문을 입력해 주세요 ");
		f.name_en.focus();
		return false;
	}


	if (confirm('정말 등록 하시겠습니까?    '))
	{
		return true;
	}	

	return false;
}


</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dbmon_layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>