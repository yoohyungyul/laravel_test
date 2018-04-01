
<?php $__env->startSection('content'); ?>

<!-- Page -->
<div class="page">	
	<div class="page-header">
	    <h1 class="page-title">병원 등록 신청</h1>
		<p class="m-b-0">디비몬에 등록되어있는 병원 등록 신청 리스트를 확인하실 수 있습니다.</p>
	    <ol class="breadcrumb breadcrumb-arrow">
		    <li class="breadcrumb-item"><a href="/" target="_blank">Korea Medical Hub</a></li>
			<li class="breadcrumb-item"><a href="/dbmon/">관리자 홈</a></li>        
            <li class="breadcrumb-item active">병원 등록 신청</li>        
		</ol>
	</div>

	

	<div class="page-content container-fluid">

		 <?php if(Session::has('success')): ?>
		 <div class="alert dark alert-success alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		  <?php echo e(Session::get('success')); ?>

		</div>
		<?php endif; ?>
		<?php if(Session::has('danger')): ?>
		<div class="alert dark alert-danger alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		  <?php echo e(Session::get('danger')); ?>

		</div>
		<?php endif; ?>

		
			
		<div class="panel">
		
			<div class="panel-heading">
				<h3 class="panel-title">관리자 신청 리스트 (<?php echo e(number_format( $clinicRegData->total()   )); ?>건)</h3>
				<!-- <div class="panel-actions">
					<button type="button" data-toggle="modal" data-target="#clinic-search-modal" class="btn btn-xs btn-primary waves-effect">상세 검색</button>
				</div> -->
			</div>

			<div class="panel-body">
				<form name="form_list"  method="post" >	
				<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
				<input type="hidden" name="returnurl" value="<?php echo e($_SERVER['REQUEST_URI']); ?>" />
				<table class="table table-hover">
					<thead>
					<tr>
						<th>#</th>
						<th>병원명</th>
						<th>병원주소</th>
						<th>담당자</th>
						<th>담당자 이메일</th>
						<th>담당자 휴대폰</th>
						<th>담당자 사무실번호</th>
						<th>등록일</th>
					</tr>
					</thead>
					<tbody>
						<?php $_i=0 ?>
						<?php $__currentLoopData = $clinicRegData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

						
						
						<tr>
							<td><?php echo e($clinicRegData->total() - ( ( ($clinicRegData->currentPage() - 1) * $clinicRegData->perPage()) + $_i )); ?></td>							
							<td><?php echo e($Data->clinic_name); ?></td>
							<td><?php echo e($Data->clinic_addr); ?></td>
							<td><?php echo e($Data->name); ?></td>
							<td><?php echo e($Data->email); ?></td>
							<td><?php echo e($Data->hp); ?></td>
							<td><?php echo e($Data->tel); ?></td>
							<td><?php echo e($Data->d_regis); ?></td>
							
						</tr>						
						<?php $_i++; ?>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</tbody>
				</table>
				<div class="row">
					<div class="col-md-12 text-right">
						<?php echo $clinicRegData->links('vendor.pagination.bootstrap-4'); ?>

					</div>
				</div>
				<!-- <hr>
				<div class="row ">
					<div class="col-12 ">						
						<button type="button" class="btn btn-danger" onclick="fuClinicAdminDel('id[]')">삭제</button>			
						<button type="button" class="btn btn-primary" onclick="fuClinicAdminApp('id[]')">승인</button>			
					</div>
				</div> -->
				</form>
			</div>
		</div>
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

	$("#checkall").click(function(){
        //클릭되었으면
        if($("#checkall").prop("checked")){
            //input태그의 name이 chk인 태그들을 찾아서 checked옵션을 true로 정의
            $(".chk").prop("checked",true);
            //클릭이 안되있으면
        }else{
            //input태그의 name이 chk인 태그들을 찾아서 checked옵션을 false로 정의
            $(".chk").prop("checked",false);
        }
    })


});
})(document, window, jQuery);

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dbmon_layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>