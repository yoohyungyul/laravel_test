
<?php $__env->startSection('content'); ?>

<?php
	$blog_image = DB::table('kmh_media')->where('of','BLOG')->where('of_id',$blogData->id)->value('path');	
?>
<section class="subheader" style="padding-top: 80px;">
	<div class="container">
		<div class="clear"></div>
	</div>
</section>

<section class="module">
	<div class="container">  
		<div class="row">
			<div class="col-lg-8 col-md-8">		
				<div class="blog-post">
					<a href="#" class="blog-post-img">
						<div class="img-fade"></div>
						<!-- <div class="blog-post-date"><span>11</span>FEB</div> -->
						<img src="<?php echo e($blog_image); ?>" alt="" />
					</a>
					<div class="content blog-post-content">
						<h3><a href="#"><?php echo e($blogData->title); ?></a></h3>
						<ul class="blog-post-details">
							<!-- <li><i class="fa fa-folder-open-o icon"></i>Posted in <a href="#">News</a></li>
							<li><i class="fa fa-comment-o icon"></i>6 Comments</li>
							<li><i class="fa fa-share-alt icon"></i>Share</li> -->
						</ul>
						<p><?php echo str_replace(chr(13),'<br />',$blogData->content) ?></p>
					</div>				
				</div>
				<div class="row">
					<div class="col-lg-12">
						<a href="/blog" class="btn btn-default ">List</a>
						<a href="<?php echo e($returnurl); ?>" class="btn btn-default right">Back</a>
					</div>
				</div>
				<hr>
			
			</div><!-- end col -->
		
			<div class="col-lg-4 col-md-4 sidebar sidebar-property-single">		
				<?php echo $__env->make('layouts.clinic_search', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
				<?php echo $__env->make('layouts.popural_treatment', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
				<?php echo $__env->make('layouts.popural_doctor', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


			</div><!-- end row -->
		</div>
	</div><!-- end container -->
</section>

<?php echo $__env->make('layouts.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('layouts.js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>