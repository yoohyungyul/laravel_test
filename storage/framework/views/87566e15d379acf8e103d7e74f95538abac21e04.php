
<?php $__env->startSection('content'); ?>

<!-- Page -->
<div class="page">	
	<div class="page-header">
	    <h1 class="page-title">병원 상담 관리하기</h1>
		<p class="m-b-0">디비몬에 등록되어있는 병원 문의를 확인하고 추가, 수정, 삭제작업을 진행하실 수 있습니다.</p>
	    <ol class="breadcrumb breadcrumb-arrow">
		    <li class="breadcrumb-item"><a href="/" target="_blank">Korea Medical Hub</a></li>
			<li class="breadcrumb-item"><a href="/dbmon/">관리자 홈</a></li>        
            <li class="breadcrumb-item active">문의 관리</li>        
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
				<h3 class="panel-title">상담 리스트 (<?php echo e(number_format( $InquiryData->total()   )); ?>건)</h3>
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
						<th><input type="checkbox" id="checkall" /></th>
						<th>#</th>
						<th>병원</th>
						<th>구분</th>
						<th>제목</th>
						<th>등록인</th>
						<th>등록일</th>
						<th>관리</th>
					</tr>
					</thead>
					<tbody>
						<?php $_i=0 ?>
						<?php $__currentLoopData = $InquiryData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php
							
							$clinic_name = DB::table('kmh_clinic')->where('id',$Data->clinic_id)->value('name');
							$user_name = DB::table('users')->where('id',$Data->user_id)->value('name');

							$newmessageCount = DB::table('kmh_inquiry_message')->where('inquiry_id',$Data->id)->where('is_confirm','0')->count('id');
							$messageCount = DB::table('kmh_inquiry_message')->where('inquiry_id',$Data->id)->where('is_confirm','1')->count('id');


							$body_part_name = DB::table('kmh_procedure_info')->where('id',$Data->body_part_id)->value('name_en');
							$procedure_info_name = DB::table('kmh_procedure_info')->where('id',$Data->procedure_info_id)->value('name_en');

						?>
						<tr>
							<td><input type="checkbox"  class="chk" name="id[]" value="<?php echo e($Data->id); ?>"/></td>
							<td><?php echo e($InquiryData->total() - ( ( ($InquiryData->currentPage() - 1) * $InquiryData->perPage()) + $_i )); ?></td>
							<td><?php echo e($clinic_name); ?></td>
							<td> <?php echo e($body_part_name); ?> <?php if($procedure_info_name): ?>- <?php echo e($procedure_info_name); ?><?php endif; ?> </td>
							<td><?php echo e($Data->title); ?></td>
							<td><?php echo e($user_name); ?></td>
							<td><?php echo e($Data->d_regis); ?></td>
							<td>
								<a href="/dbmon/inquiry/clinic/view?id=<?php echo e($Data->id); ?>&returnurl=<?php echo e(urlencode($_SERVER['REQUEST_URI'])); ?>" class="btn btn-primary btn-xs waves-effect waves-effect">상담 보기</a>
								<a href="/dbmon/inquiry/clinic/view?id=<?php echo e($Data->id); ?>&returnurl=<?php echo e(urlencode($_SERVER['REQUEST_URI'])); ?>#message" class="btn btn-danger btn-xs waves-effect waves-effect"><?php echo e($newmessageCount); ?> 메시지</a>
								<a href="/dbmon/inquiry/clinic/view?id=<?php echo e($Data->id); ?>&returnurl=<?php echo e(urlencode($_SERVER['REQUEST_URI'])); ?>#message" class="btn btn-default btn-xs waves-effect waves-effect"><?php echo e($messageCount); ?> 메시지</a>
							</td>
						</tr>						
						<?php $_i++; ?>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</tbody>
				</table>
				<div class="row">
					<div class="col-md-12 text-right">
						<?php echo $InquiryData->links('vendor.pagination.bootstrap-4'); ?>

					</div>
				</div>
				<hr>
				<div class="row ">
					<div class="col-12 ">						
						<button type="button" class="btn btn-danger" onclick="fuInquiryDel('id[]')">삭제</button>			
					</div>
				</div>
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


function fuInquiryDel(obj) {
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
		alert("삭제 할 상담을 선택해 주세요");
		return false;
	}

	if (confirm('정말 삭제 하시겠습니까?    '))
	{
		document.form_list.action="/dbmon/del/inquiry";
		document.form_list.submit();
	}	
}



</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dbmon_layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>