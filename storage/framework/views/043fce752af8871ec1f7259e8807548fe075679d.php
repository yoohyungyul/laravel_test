
<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="/global/vendor/html5sortable/sortable.css">

<!-- Page -->
<div class="page">
	<div class="page-header">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/dbmon">관리자홈</a></li>
			<li class="breadcrumb-item"><a href="/dbmon/site">사이트관리</a></li>
			<li class="breadcrumb-item active">배너관리</li>
		</ol>
		<h1 class="page-title">배너관리</h1>
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
						<div class="nav-tabs-horizontal" data-plugin="tabs">
							<ul class="nav nav-tabs" >
								<li class="nav-item" ><a class="nav-link <?php if( $area == 1 and $gubun == 1 ): ?> active <?php endif; ?> "  href="/dbmon/site/banner?area=1&gubun=1" >메인 시술</a></li>
								<li class="nav-item" ><a class="nav-link <?php if( $area == 1 and $gubun == 2 ): ?> active <?php endif; ?> "  href="/dbmon/site/banner?area=1&gubun=2" >메인 병원</a></li>
								<li class="nav-item" ><a class="nav-link <?php if( $area == 1 and $gubun == 3 ): ?> active <?php endif; ?> "  href="/dbmon/site/banner?area=1&gubun=3" >메인 의사</a></li>
								<li class="nav-item" ><a class="nav-link <?php if( $area == 2 and $gubun == 1 ): ?> active <?php endif; ?> "  href="/dbmon/site/banner?area=2&gubun=1" >서브 시술</a></li>
								<li class="nav-item" ><a class="nav-link <?php if( $area == 2 and $gubun == 3 ): ?> active <?php endif; ?> "  href="/dbmon/site/banner?area=2&gubun=3" >서브 의사</a></li>
								<li class="nav-item" ><a class="nav-link <?php if( $area == 3 and $gubun == 1 ): ?> active <?php endif; ?> "  href="/dbmon/site/banner?area=3&gubun=1" >하단 시술</a></li>
							</ul>
						</div>  
					</div>
				</div>	
				<form name="form_list"  method="post" >	
				<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
				<input type="hidden" name="returnurl" value="<?php echo e($_SERVER['REQUEST_URI']); ?>" />

				<input type="hidden" name="area" value="<?php echo e($area); ?>">
				<input type="hidden" name="gubun" value="<?php echo e($gubun); ?>">


				<div class="row row-lg">
					<div class="col-xl-12 pt-20">  
						<ul class="list-group list-group-gap sortable-with-handle list-group-full" data-plugin="sortable" data-handle="i">
							<?php $__currentLoopData = $BannerData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php
								$name  = "";
								$img = "";
								$url = "";


								// 시술
								if($data->gubun == 1) {
									$name = DB::table('kmh_procedure_info')->where('id',$data->b_id)->value('name');
									$img = $data->b_img;
									$url = "/dbmon/procedure_info/mod?id=".$data->b_id;

								// 병원
								} else if($data->gubun == 2) {
									$name = DB::table('kmh_clinic')->where('id',$data->b_id)->value('name');

									$clinic_img = DB::table('kmh_media')->where('of','CLINIC')->where('of_id',$data->b_id)->orderBy('id', 'desc')->value('path');
									if(!$img) $img = "/front/images/1837x1206.png";

									$url = "/dbmon/clinic/view?id=".$data->b_id;

									

								// 의사
								} else if($data->gubun == 3) {

									$clinic_id = DB::table('kmh_clinic_doctor')->where('id',$data->b_id)->value('clinic_id');


									$name = DB::table('kmh_clinic_doctor')->where('id',$data->b_id)->value('first_name_kr');

									$ImgData = DB::table('kmh_media')->where('of','DOCTOR')->where('of_id', $data->b_id)->orderBy('id','desc')->first();
									$img = "/front/images/1197x1350.png";
									if($ImgData) $img = $ImgData->path;




									$url = "/dbmon/clinic/doctor?id=".$clinic_id;

									
								}


							?>
							
							<li class="list-group-item">
								<input type="hidden" name="ord_id[]" value="<?php echo e($data->id); ?>" />
								<i class="icon wb-list sortable-handle" aria-hidden="true"></i> <input type="checkbox"  class="chk" name="id[]" value="<?php echo e($data->id); ?>"/> <a href="<?php echo e($url); ?>" target="_blank" ><img src="<?php echo e($img); ?>" height="20" /> <?php echo e($name); ?></a>
							</li>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</ul>
						
					</div>
				</div>
				<div class="row row-lg">
					<div class="col-xl-12 pt-20">  
						<button type="button" class="btn btn-danger" onclick="fuBannerDel('id[]')">삭제</button>			
						<button type="button" class="btn btn-info" onclick="fuBannerOrder()">순서변경</button>	
						<?php if($gubun == 1): ?> 
							<button type="button" class="btn btn-primary" onclick="fuBannerAdd()">배너등록</button>	
						<?php endif; ?>
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
<script src="/global/vendor/html5sortable/html.sortable.js"></script>



<script src="/global/js/Plugin/html5sortable.js"></script>


<script>
(function(document, window, $) {
'use strict';
var Site = window.Site;
$(document).ready(function() {
  Site.run();
});
})(document, window, jQuery);

function fuBannerAdd() {

	url = "/modal/banner/add?area=<?php echo e($area); ?>&gubun=<?php echo e($gubun); ?>&returnurl=<?php echo e(urlencode($_SERVER['REQUEST_URI'])); ?>";

	
	
	$("#Modal_fade .modal-content").load(url, function() { 
		 $("#Modal_fade").modal("show"); 
	});
}



function fuBannerDel(obj) {
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
		alert("삭제 할 배너를 선택해 주세요");
		return false;
	}

	if (confirm('정말 삭제 하시겠습니까?    '))
	{
		document.form_list.action="/dbmon/del/banner";
		document.form_list.submit();
	}	
}

function fuBannerOrder() {
	

	if (confirm('정말 순서 변경 하시겠습니까?    '))
	{
		document.form_list.action="/dbmon/order/banner";
		document.form_list.submit();
	}	
}

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dbmon_layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>