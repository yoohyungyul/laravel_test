
<?php $__env->startSection('content'); ?>

<!-- Page -->
<div class="page">
	<div class="page-header">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/dbmon">관리자홈</a></li>
			<li class="breadcrumb-item"><a href="/dbmon/clinic">병원리스트</a></li>
			<li class="breadcrumb-item active"><?php echo e($ClinicData->name); ?></li>
		</ol>
		<h1 class="page-title">시술정보</h1>
	</div>
	<div class="page-content container-fluid" >	
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
			<div class="panel-body container-fluid">
				<div class="row row-lg">
					<div class="col-xl-12">      
						<?php echo $__env->make('dbmon.clinicTop', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		                
					</div>
				</div>		
				<form name="form_list"  method="get" >	
				<input type="hidden" name="returnurl" value="<?php echo e($_SERVER['REQUEST_URI']); ?>" />
				<div class="row row-lg">
					<div class="col-xl-12">   
						<h4 class="pt-30">시술정보 리스트</h4>
						<table class="table table-hover">
							<thead>
							<tr>
								<th><input type="checkbox" id="checkall" /></th>
								<th>#</th>
								<th>분류</th>
								<th>평가</th>
								<th>수가</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>
								<?php $_i=0; ?>
								<?php $__currentLoopData = $ClinicProcedureData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php
									
									$ThirdProcedureData = DB::table('kmh_procedure_info')->where('id', $data->procedure_info_id)->first();
									$SecondProcedureData = DB::table('kmh_procedure_info')->where('id', $ThirdProcedureData->parent_id)->first();
									$FirstProcedureData = DB::table('kmh_procedure_info')->where('id', $SecondProcedureData->parent_id)->first();

									$procedure = $FirstProcedureData->name ."> ".$SecondProcedureData->name."> ".$ThirdProcedureData->name;


								?>
								
								<tr>
									<td><input type="checkbox"  class="chk" name="id[]" value="<?php echo e($data->id); ?>"/></td>
									<td><?php echo e($ClinicProcedureData->total() - ( ( ($ClinicProcedureData->currentPage() - 1) * $ClinicProcedureData->perPage()) + $_i )); ?></td>
									<td><?php echo e($procedure); ?></td>
									<td><?php echo e($data->score_slug); ?></td>
									<td><?php echo e($data->expense); ?></td>
									<td>
										<button type="button" class="btn btn-info btn-xs" onclick="fuProcedureMod(<?php echo e($data->id); ?>)">수정</button>
									</td>
								</tr>
								<?php $_i++; ?>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</tbody>
						</table>

						
					</div>
				</div>
				<div class="row row-lg">
					<div class="col-xl-12 text-right">
						<?php echo $ClinicProcedureData->render(); ?>

					</div>
				</div>
				<div class="row row-lg">
					<div class="col-6 ">						
						<button type="button" class="btn btn-danger" onclick="fuProcedureDel('id[]')">삭제</button>
						<button type="button" class="btn btn-info" onclick="fuProcedureAdd()">+ 추가</buttoN>
					</div>
					<div class="col-6 text-right ">
						<a class="btn btn-default" href="<?php echo e($returnurl); ?>">돌아가기</a>
					</div>
				</div>
				</form>
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



function fuProcedureAdd() {

  url = "/modal/procedure/add?id=<?php echo e($id); ?>&returnurl=<?php echo e(urlencode($_SERVER['REQUEST_URI'])); ?>";
	
	$("#Modal_fade .modal-content").load(url, function() { 
		 $("#Modal_fade").modal("show"); 
	});
}

function fuProcedureMod(procedure_id) {
	

    url = "/modal/procedure/mod?procedure_id="+procedure_id+"&returnurl=<?php echo e(urlencode($_SERVER['REQUEST_URI'])); ?>";
	
	$("#Modal_fade .modal-content").load(url, function() { 
		 $("#Modal_fade").modal("show"); 
	});
}

function fuProcedureDel(obj) {
	var i, sum=0, tag=[], str="";
    var chk = document.getElementsByName(obj);
    var tot = chk.length;
    for (i = 0; i < tot; i++) {
        if (chk[i].checked == true) {
            tag[sum] = chk[i].value;
            sum++;
        }
    }

	

    if(tag.length == 0)  {
		alert("삭제 할 시술정보 선택해 주세요");
		return false;
	}

	if (confirm('정말 삭제 하시겠습니까?    '))
	{
		document.form_list.action="/dbmon/del/procedure";
		document.form_list.submit();
	}	
}



</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dbmon_layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>