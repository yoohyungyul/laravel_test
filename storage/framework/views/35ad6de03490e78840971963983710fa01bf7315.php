
<?php $__env->startSection('content'); ?>

<!-- Page -->
<div class="page">	
	<div class="page-header">
	    <h1 class="page-title">병원정보서비스</h1>
		<p class="m-b-0">병원정보서비스 심평원 공공데이터 확인이 가능합니다.</p>
	    <ol class="breadcrumb breadcrumb-arrow">
		    <li class="breadcrumb-item"><a href="/" target="_blank">Korea Medical Hub</a></li>
			<li class="breadcrumb-item"><a href="/dbmon/">관리자 홈</a></li>        
            <li class="breadcrumb-item active">병원정보서비스</li>        
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
				<h3 class="panel-title">병원정보서비스</h3>			
			</div>

			<div class="panel-body">				
				<table class="table table-hover">
					<thead>
					<tr>
						<th>#</th>
						<th>병원명</th>
						<th>종별코드명</th>
						<th>시도/시군구/읍면동</th>
						<th>(우편번호)주소</th>
						<th>X, Y좌표</th>
					</tr>
					</thead>
					<tbody>
						<?php $_i=0 ?>
						<?php $__currentLoopData = $medicInsttData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
							<td><?php echo e($medicInsttData->total() - ( ( ($medicInsttData->currentPage() - 1) * $medicInsttData->perPage()) + $_i )); ?></td>
							<td><?php echo e($data->yadm_nm); ?></td>
							<td><?php echo e($data->cl_cd_nm); ?></td>
							<td><?php echo e($data->sido_cd_nm); ?> / <?php echo e($data->sggu_cd_nm); ?></td>
							<td>(<?php echo e($data->post_no); ?>) <?php echo e($data->addr); ?></td>
							<td><?php echo e($data->x_pos); ?> <?php echo e($data->y_pos); ?></td>
						</tr>
						<?php $_i++; ?>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</tbody>
				</table>
				<div class="row">
					<div class="col-md-12 text-right">
						<?php echo $medicInsttData->links('vendor.pagination.bootstrap-4'); ?>

					</div>
				</div>
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
	//최상단 체크박스 클릭
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