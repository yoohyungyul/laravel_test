
<?php $__env->startSection('content'); ?>
<link href="/front/css/jquery.fancybox.min.css" rel="stylesheet" />

<?php
	$inquiry_img = DB::table('kmh_media')->where('of','INQUIRY')->where('of_id',$id)->orderBy('id', 'desc')->orderBy('id','desc')->get();

	$body_part_name = "";
	if($InquiryData->body_part_id) {
		$body_part_name = DB::table('kmh_procedure_info')->where('id',$InquiryData->body_part_id)->value('name_en');
	}

	$procedure_info_name = "";
	if($InquiryData->procedure_info_id) {
		$procedure_info_name = DB::table('kmh_procedure_info')->where('id',$InquiryData->procedure_info_id)->value('name_en');
	}

	$gender = "";
	if($InquiryData->gender == "1") $gender = "Male";
	if($InquiryData->gender == "2") $gender = "Female";



?>

<section class="subheader">
  <div class="container">
    <h1>Inquiry</h1>
    <div class="breadcrumb right">Home <i class="fa fa-angle-right"></i> <a href="/mypage" class="current">Inquiry</a></div>
    <div class="clear"></div>
  </div>
</section>

<section class="module favorited-properties">
  <div class="container">
	
  
	<div class="row">
		<div class="col-lg-3 col-md-3 sidebar-left">
			<?php echo $__env->make('member.left_menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>		
			
		</div>

		<div class="col-lg-9 col-md-9">

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


			<div class="blog-post">

				<div class="content blog-post-content">
					<?php if($body_part_name or $procedure_info_name): ?>
					<p style="color:#48a0dc">
						<strong>#<?php echo e($body_part_name); ?> <?php if($procedure_info_name): ?> ▶ #<?php echo e($procedure_info_name); ?> <?php endif; ?></strong>
					</p>
					<hr>
					<?php endif; ?>
					<h3><?php echo e($InquiryData->name_en); ?></h3>
					<small >Name : <?php echo e($InquiryData->name); ?> | Email : <?php echo e($InquiryData->email); ?> <?php if($InquiryData->birthday): ?>| Date of Birth : <?php echo e($InquiryData->birthday); ?><?php endif; ?> <?php if($InquiryData->gender): ?>| Gender : <?php echo e($gender); ?><?php endif; ?></small>
					<div class="clear"></div>
					<hr>
					<p style="margin-top:20px"><?php echo e($InquiryData->title); ?></p>
					<p><?php echo str_replace(chr(13),'<br />',$InquiryData->content) ?></p>
					<?php if(count($inquiry_img) > 0): ?>
					<div style="margin-top:10px">	
						<?php $__currentLoopData = $inquiry_img; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<figure>
								<figcaption>
									<a class="fancybox" rel="group_top_<?php echo e($InquiryData->id); ?>" href="<?php echo e($img->path); ?>" ><img src="<?php echo e($img->path); ?>" alt="<?php echo e($img->path); ?>" width="100" ></a>
								</figcaption>
							</figure>
							<!-- <img src="<?php echo e($img->path); ?>" width="100"/> -->
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
					<?php endif; ?>
				</div>
				
					
			</div><!-- end blog post -->

			<button class="right button grey small">Report this clinic </button>
			<div class="clear"></div>
			


			<div class="widget comment-list">
				<h4><span>Messages <span class="button grey"><?php echo e(number_format(count($messageData))); ?></span></span> <img src="/front/images/divider-half.png" alt="" /></h4>
				<?php $__currentLoopData = $messageData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

				<?php

			
					$diff = time() - strtotime($data->d_regis); 

					if ( $diff>86400 ) { 
						$date = 'Written '.ceil($diff/86400).' day ago.';
					} else if ( $diff>3600 ) { 
						$date =  'Written '.ceil($diff/3600).' hour ago.';
					} else if ( $diff>60 ) { 
						$date =  'Written '.ceil($diff/60).' minute ago.'; 
					} else { 
						$date =  'Written '.$diff.' second ago.'; 
					} 

					$inquiry_message_img = DB::table('kmh_media')->where('of','INQUIRY_MESSAGE')->where('of_id',$data->id)->orderBy('id', 'desc')->orderBy('id','desc')->get();

					$memData = DB::table('users')->select('name','level','clinic_id')->where('id',$data->user_id)->first();

					// 병원 아이디이면
					if($memData->level == "3") {
						$name = DB::table('kmh_clinic')->where('id',$memData->clinic_id)->value('name_en');
					} else {
						$name = $memData->name;
					}

					$is_confirm = $data->is_confirm;

					// 내가 쓴글을 읽은걸로 
					if($data->user_id == Auth::user()->id) {
						$is_confirm = 1;
					} else {

						DB::table('kmh_inquiry_message')
							->where('id', $data->id)
							->update(array(			
								'is_confirm' => "1"
							)
						);
					}

				
				?>


				<div class="comment">
					<div class="row">
						<div class="col-lg-12">
							<div class="comment-text">
								<h5><?php if(!$is_confirm): ?><small style="color:#d9534f"><strong>New</strong></small> <?php endif; ?><?php echo e($name); ?> <?php if(Auth::user()->id == $data->user_id): ?><span class="pull-right"><button type="button" class="btn btn-xs btn-danger" onclick="fnMessageDel(<?php echo e($data->id); ?>)">Del</button></span><?php endif; ?></h5>
								<div><?php echo str_replace(chr(13),'<br />',$data->message) ?></div>
								
								<?php if(count($inquiry_message_img) > 0 ): ?>
								<div style="margin-top:10px">
									<?php $__currentLoopData = $inquiry_message_img; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<figure>
										<figcaption>
											<a class="fancybox" rel="group_<?php echo e($data->id); ?>" href="<?php echo e($img->path); ?>" ><img src="<?php echo e($img->path); ?>" alt="<?php echo e($img->path); ?>" width="100" ></a>
										</figcaption>
									</figure>
									<!-- <img src="<?php echo e($img->path); ?>" width="100"/> -->
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</div>
								<?php endif; ?>
								
								<div class="right"><i class="fa fa-clock-o icon"></i><small><?php echo e($date); ?></small></div>
								<div class="clear"></div>
							</div>							
						</div>
					</div>
				</div>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>				
				
			</div><!-- end comment list -->

			<div class="widget comment-form">
				<h4><span>Reply</span> <img src="/front/images/divider-half.png" alt="" /></h4>
				<form autocomplete="off" method="POST" onsubmit="return r_writeCheck(this);" action="/add/inquiry-message"  enctype="multipart/form-data">
				<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
				<input type="hidden" name="id" value="<?php echo e($id); ?>" />
				<input type="hidden" name="clinic_id" value="<?php echo e($InquiryData->clinic_id); ?>" />
				<input type="hidden" name="returnurl" value="<?php echo e($_SERVER['REQUEST_URI']); ?>" />				
					<div class="form-block">
						<label>Message</label>
						<textarea placeholder="Your message..." name="message"></textarea>
					</div>				
					<div class="form-block">
						<label>Files</label>
						<input type="file" name="files[]"/>
						<input type="file" name="files[]"/>
						<input type="file" name="files[]"/>
						<input type="file" name="files[]"/>
					</div>
					<div class="form-block">
						<input type="submit" value="Submit" />
						<a href="<?php echo e($returnurl); ?>" class="button button-icon grey right"><i class="fa fa-angle-right"></i>Back</a>
					</div>
				</form>
			</div>

			
		
		</div><!-- end col -->
	</div><!-- end row -->

  </div><!-- end container -->
</section>


<?php echo $__env->make('layouts.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('layouts.js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<script src="/front/js/jquery.fancybox.js"></script>
<script>

jQuery(document).ready(function(){
  jQuery(".fancybox").fancybox();
});



function r_writeCheck(f) {

	if (f.message && f.message.value == '') {
		alert("Your message. ");
		f.message.focus();
		return false;
	}

	if (confirm('Are you sure you want to submit this?    '))
	{
		return true;
	}
	return false;
}

function fnMessageDel(id) {

	if (confirm('Are you sure you want to delete this?    '))
	{
		var url  = "/del/inquiry-message?id="+ id + "&returnurl=<?php echo e(urlencode($_SERVER['REQUEST_URI'])); ?>";
		location.href = url;
	}
	return false;
}
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>