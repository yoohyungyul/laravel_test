<?php $__env->startSection('content'); ?>

<section class="subheader">
	<div class="container">
		<h1>Register</h1>
		<div class="breadcrumb right">Home <i class="fa fa-angle-right"></i> <a href="/register" class="current">Register</a></div>
		<div class="clear"></div>
	</div>
</section>

<section class="module login">
	<div class="container">
		<div class="row">
			<div class="col-lg-4 col-lg-offset-4"> 
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
				<p>Already have an account? <strong><a href="<?php echo e(route('login')); ?>">Login here.</a></strong></p> 
				<form class="login-form" method="POST" action="<?php echo e(route('register')); ?>" autocomplete="off"  onsubmit="return r_writeCheck(this);" >
                <?php echo e(csrf_field()); ?>


				<div class="form-block<?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
					<label>Name</label>
					<input id="name" type="text" class="border" name="name" value="<?php echo e(old('name')); ?>" required autofocus>
					<?php if($errors->has('name')): ?>
						<span class="help-block">
							<strong><?php echo e($errors->first('name')); ?></strong>
						</span>
					<?php endif; ?>
				</div>

				<div class="form-block<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
					<label>Email</label>
					<input id="email" type="email" class="border" name="email" value="<?php echo e(old('email')); ?>" required autofocus>
					<?php if($errors->has('email')): ?>
						<span class="help-block">
							<strong><?php echo e($errors->first('email')); ?></strong>
						</span>
					<?php endif; ?>
				</div>

				<div class="form-block<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
					<label>Password</label>
					<input id="password" type="password" class="border" name="password" required>
					 <?php if($errors->has('password')): ?>
						<span class="help-block">
							<strong><?php echo e($errors->first('password')); ?></strong>
						</span>
					<?php endif; ?>

				</div>
				<div class="form-block">
					<label>Confirm Password</label>
					<input id="password-confirm" type="password" class="border" name="password_confirmation" required>
				</div>
				<div class="form-block">
					<button class="button button-icon" type="submit" id="m_submit"><i class="fa fa-angle-right"></i>Register</button>
				</div>
				<div class="divider"></div>
				<p class="note">By clicking the "Register" button you agree with our <a href="#">Terms and conditions</a></p>    
				</form>
			</div>
		</div><!-- end row -->
	</div>
</section>


<?php echo $__env->make('layouts.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('layouts.js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>
function r_writeCheck(f) {

	

	$('#m_submit').attr("disabled",true);
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>