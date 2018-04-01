
<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="/global/vendor/summernote/summernote.css">
<?php
	$blogImageData = DB::table('kmh_media')->where('of','BLOG')->where('of_id',$blogData->id)->first();	
?>

<!-- Page -->
<div class="page">
	<div class="page-header">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/dbmon">관리자홈</a></li>
			<li class="breadcrumb-item"><a href="/dbmon/blog">블로그 리스트</a></li>
		</ol>
		<h1 class="page-title">블로그 수정</h1>
	</div>
	<div class="page-content container-fluid" >
		<form autocomplete="off" name="form_add"  method="POST" onsubmit="return r_writeCheck(this);" action="/dbmon/mod/blog"  enctype="multipart/form-data" >
		<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
		<input type="hidden" name="id" value="<?php echo e($id); ?>">
		<input type="hidden" name="returnurl" value="<?php echo e($returnurl); ?>">
		<div class="panel">
			<div class="panel-body container-fluid">
				
				<div class="row row-lg">
					<div class="col-xl-12 pt-20">	

						<div class="form-group  " >
							<label class="form-control-label" for="inputText">대표 이미지</label>
							<div class="form-group  row">                                
								<div class="col-xs-6 col-md-3">
									<input type="file" data-plugin="dropify" data-default-file="" name="b_img"/>
                                </div>
                            </div>	
							<?php if($blogImageData): ?>
								<label class="form-control-label" for="inputText">등록된 사진 </label><br>
							
								<a href="<?php echo e($blogImageData->path); ?>" target="_blank" ><img src="<?php echo e($blogImageData->path); ?>" alt="<?php echo e($blogImageData->name); ?>" height="200"/></a>	
							<?php endif; ?>
						</div>

						

						<div class="form-group " >
							<label class="form-control-label" for="inputText">제목</label>
							<div class="row">
								<div class="col-xl-12">
									<div class="form-group  " >
                                        <input name="title" type="text" class="form-control"  placeholder="제목" value="<?php echo e($blogData->title); ?>">							
                                    </div>
								</div>
							</div>
						</div>

						<div class="form-group " >
							<label class="form-control-label" for="inputText">내용</label>
							<div class="row">
								<div class="col-xl-12">
									<div class="form-group  " >
										<textarea id="summernote" data-plugin="summernote" name="content"  ><?php echo e($blogData->content); ?></textarea>
                                    </div>
								</div>
							</div>
						</div>

						

					</div>
				</div>
				
				<div class="row">
					<div class="col-6"><a href="<?php echo e($returnurl); ?>" class="btn  btn-default">돌아가기</a></div>
					<div class="col-6 text-right"><button type="submit" class="btn  btn-success">수정하기</button></div>
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


<script src="/global/js/Plugin/summernote.js"></script>


<script>
(function(document, window, $) {
'use strict';
var Site = window.Site;
$(document).ready(function() {
  Site.run();
  $("#summernote").summernote({
		height: 700
	});
});
})(document, window, jQuery);



function r_writeCheck(f) {


	if (f.title && f.title.value == '') {
		alert("블로그명을 입력해 주세요. ");
		f.title.focus();
		return false;
	}

	if (f.content && f.content.value == '') {
		alert("블로그 내용을 입력해 주세요. ");
		f.content.focus();
		return false;
	}
	

	if (confirm('정말 수정 하시겠습니까?    '))
	{
		return true;
	}

	return false;


}
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dbmon_layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>