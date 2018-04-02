
<?php $__env->startSection('content'); ?>


<link href="/front/css/datepicker.css" rel="stylesheet">

<section class="subheader">
  <div class="container">
    <h1>SEND MULTIPLE INQUIRY</h1>
    <div class="breadcrumb right">Home <i class="fa fa-angle-right"></i> SEND MULTIPLE INQUIRY</div>
    <div class="clear"></div>
  </div>
</section>

<section class="module favorited-properties">
  <div class="container">
	
  
	<div class="row">
		
		<div class="col-lg-8 col-md-8">

			 <?php if(Session::has('success')): ?>			
			 <div class="row">
				<div class="col-lg-12">
					<div class="alert-box success"><i class="fa fa-check icon"></i> <?php echo e(Session::get('success')); ?></div>
				</div>
			</div>
			<?php endif; ?>
			<?php if(Session::has('danger')): ?>
			
			 <div class="row">
				<div class="col-lg-12">
					<div class="alert-box error"><i class="fa fa-close icon"></i> <?php echo e(Session::get('danger')); ?></div>
				</div>
			</div>
			<?php endif; ?>

			<div class="property-single-item property-main">
				<div class="property-header">
					<div class="property-title">
						<p><strong style="color:#48a0dc">SELECT CLINIC</strong></p>
						<ul>
							<?php $__currentLoopData = $ClinicData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<li><label><input type="checkbox" name="clinic_id" value="<?php echo e($data->id); ?>" checked="checked" /> <?php echo e($data->name_en); ?></label></li>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</ul>
					</div>
					<div>
						<form autocomplete="off" method="POST" onsubmit="return r_writeCheck(this);" action="/add/send-multiple-inquiry"  enctype="multipart/form-data">
						<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
						<input type="hidden" name="returnurl" value="<?php echo e($returnurl); ?>" />
							<div class="row">
								<div class="col-md-6">
					
									<div class="form-block">
										<label>Full Name</label>
										<input class="border" type="text" name="name" value="" />
									</div>
								</div>
								<div class="col-md-6">
					
									<div class="form-block">
										<label>Email</label>
										<input class="border" type="text" name="name" value="" />
									</div>
								</div>
								<div class="col-md-6">
					
									<div class="form-block">
										<label>Gender</label>
										<label style="float:left;margin-right:50px"><input class="border" type="radio" name="gender" value="2"/> Female</label>
										<label><input class="border" type="radio" name="gender" value="1"/> Male</label>
										<div class="clear"></div>
									</div>
								</div>
								<div class="col-md-6">
					
									<div class="form-block">
										<label>Date of Birth</label>
										<input type="text"  data-plugin="datepicker">
									</div>
								</div>

								<div class="col-md-6">
					
									<div class="form-block">
										<label>Password</label>
										<input class="border" type="text" name="name" value="" />
									</div>
								</div>

								<div class="col-md-6">
					
									<div class="form-block">
										<label>Confirm Password</label>
										<input class="border" type="text" name="name" value="" />
									</div>
								</div>

								<div class="col-md-12">
					
									<div class="form-block">
										<label>type your inquiry here</label>
										<textarea class="border" /></textarea>
									</div>
								</div>

								<div class="col-md-12">
					
									<div class="form-block">
										<label>Files</label>
										<input type="file" />
										<input type="file" />
										<input type="file" />
										<input type="file" />
									</div>
								</div>							

							</div>
							<hr>
							<div class="row">
								<div class="col-md-12">								
								By sending an inquiry, you're agreeing to create an account, ClinicInsite <a href="" target="_blank">privacy</a> and <a href="" target="_blank">terms.</a> <br>
								You'll be notified via email by ClinicInsite when the clinic responses to your inquiry.
								</div>
								<div class="col-md-12">
									<div class="form-block text-right">
										<button type="submit" class="button button-icon"><i class="fa fa-check"></i>Send</button>
									</div>
								</div>

							</div>

						</form>
					</div>
				</div>
			</div>

			
		
		</div><!-- end col -->
		<div class="col-lg-4 col-md-4 sidebar sidebar-property-single">		
			<?php echo $__env->make('layouts.popural_treatment', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
			<?php echo $__env->make('layouts.popural_doctor', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


		</div><!-- end row -->
	</div><!-- end row -->

  </div><!-- end container -->
</section>


<?php echo $__env->make('layouts.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('layouts.js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>




<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>