
<?php $__env->startSection('content'); ?>

<!-- Page -->
<div class="page">
	<div class="page-header">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/dbmon">관리자홈</a></li>
			<li class="breadcrumb-item"><a href="/dbmon/site/setting">사이트 설정</a></li>
		</ol>
		<h1 class="page-title">사이트 정보</h1>
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
		<form autocomplete="off" name="form_add"  method="POST" onsubmit="return r_writeCheck(this);" action="/dbmon/mod/site"  enctype="multipart/form-data" >
		<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>"/>
		<input type="hidden" name="site" value="1" />
		<div class="panel">
			<div class="panel-body container-fluid">
							
				<div class="row row-lg">
					<div class="col-xl-12 pt-20"> 						
						<div class="form-group " >
							<label class="form-control-label" for="inputText">meta title</label>
							<div class="row">
								<div class="col-xl-12">
									<div class="form-group  " >
                                        <input name="meta_title" type="text" class="form-control"  placeholder="meta title" value="<?php echo e($SiteData->meta_title); ?>">   
                                    </div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row row-lg">
					<div class="col-xl-12 pt-20"> 						
						<div class="form-group " >
							<label class="form-control-label" for="inputText">meta description</label>
							<div class="row">
								<div class="col-xl-12">
									<div class="form-group  " >
                                        <input name="meta_description" type="text" class="form-control"  placeholder="meta description" value="<?php echo e($SiteData->meta_description); ?>">   
                                    </div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row row-lg">
					<div class="col-xl-12 pt-20"> 						
						<div class="form-group " >
							<label class="form-control-label" for="inputText">meta keywords</label>
							<div class="row">
								<div class="col-xl-12">
									<div class="form-group  " >
                                        <input name="meta_keywords" type="text" class="form-control"  placeholder="meta keywords" value="<?php echo e($SiteData->meta_keywords); ?>">   
                                    </div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row row-lg">
					<div class="col-xl-6 pt-20"> 						
						<div class="form-group " >
							<label class="form-control-label" for="inputText">전화번호</label>
							<div class="row">
								<div class="col-xl-12">
									<div class="form-group  " >
                                        <input name="site_tel" type="text" class="form-control"  placeholder="전화번호" value="<?php echo e($SiteData->site_tel); ?>">   
                                    </div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-6 pt-20"> 						
						<div class="form-group " >
							<label class="form-control-label" for="inputText">이메일</label>
							<div class="row">
								<div class="col-xl-12">
									<div class="form-group  " >
                                        <input name="site_email" type="text" class="form-control"  placeholder="이메일" value="<?php echo e($SiteData->site_email); ?>">   
                                    </div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row row-lg">
					<div class="col-xl-12 pt-20"> 						
						<div class="form-group " >
							<label class="form-control-label" for="inputText">사이트 정보</label>
							<div class="row">
								<div class="col-xl-12">
									<div class="form-group  " >
                                        <input name="site_info" type="text" class="form-control"  placeholder="사이트 정보" value="<?php echo e($SiteData->site_info); ?>">   
                                    </div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row row-lg">
					<div class="col-xl-12 pt-20"> 						
						<div class="form-group " >
							<label class="form-control-label" for="inputText">사이트 주소</label>
							<div class="row">
								<div class="col-xl-12">
									<div class="form-group  " >
										<textarea  name="site_addr" class="form-control" rows="5"><?php echo e($SiteData->site_addr); ?></textarea>
                                        
                                    </div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row row-lg">
					<div class="col-xl-12 pt-20"> 						
						<div class="form-group " >
							<label class="form-control-label" for="inputText">사이트 영업시간</label>
							<div class="row">
								<div class="col-xl-12">
									<div class="form-group  " >
										<textarea  name="site_open_hours" class="form-control" rows="5" ><?php echo e($SiteData->site_open_hours); ?></textarea>
                                    </div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-12 text-right"><button type="submit" class="btn  btn-success">수정하기</button></div>
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

	//alert("dd");
	//return false;
}

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dbmon_layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>