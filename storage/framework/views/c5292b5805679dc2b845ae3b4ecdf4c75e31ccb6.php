
<?php $__env->startSection('content'); ?>

<section class="subheader">
	<div class="container">
		<h1>Treatments</h1>
		<div class="breadcrumb right">Home <i class="fa fa-angle-right"></i> <a href="/treatments" class="current">Treatments</a></div>
		<div class="clear"></div>
	</div>
</section>

<section class="module">
	<div class="container">    
		<div class="row">
			<div class="col-lg-8 col-md-8">
				<div id="accordion" class="content">
					<?php $__currentLoopData = $procedureData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php $procedureSubData	= DB::table('kmh_procedure_info')->where('depth',3)->where('parent_id',$data->id)->orderBy('name_en', 'asc')->get(); ?>
					<h3><?php echo e($data->name_en); ?></h3>
					<div>
						
							<div class="tagcloud01">
								<ul >
								<?php $_i = 0 ?>
								<?php $__currentLoopData = $procedureSubData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php
									$url = "/treatment/".$sub_date->name_url;
								?>
									<li><a href="<?php echo e($url); ?>"><i class="fa fa-tag" aria-hidden="true"></i> <?php echo e($sub_date->name_en); ?></a></li>								
								<?php $_i++ ?>
								
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</ul>
							</div>

							<?php $__currentLoopData = $procedureSubData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						
						<div class="divider"></div>
						<span class=""><a href="/contact">Can't find your treatment? Please ask us to add on the list</a></span>
					</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

				</div>
			</div>
			<div class="col-lg-4 col-md-4 sidebar sidebar-property-single">		
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