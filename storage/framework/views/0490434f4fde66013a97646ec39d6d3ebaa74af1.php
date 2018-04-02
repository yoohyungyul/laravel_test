<?php
$SiteData = DB::table('kmh_site_setting')->first();


$BlogData = DB::table('kmh_blog')->orderBy('d_upis','desc')->take(2)->get();

$TreatmentsBannerData = DB::table('kmh_banner')
->join('kmh_procedure_info', 'kmh_procedure_info.id', '=', 'kmh_banner.b_id')	
->select('parent_id','kmh_procedure_info.id','name_en')
->where('area','3')->where('gubun','1')->orderBy('b_ord','asc')->take(7)->get();


?>
<!-- 하단 부분 시작 -->

<!-- <section class="module cta newsletter">
  <div class="container">
	<div class="row">
		<div class="col-lg-7 col-md-7">
			<h3>Sign up for our <strong>newsletter.</strong></h3>
			<p>Lorem molestie odio. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
		</div>
		<div class="col-lg-5 col-md-5">
			<form method="post" id="newsletter-form" class="newsletter-form">
				<input type="email" placeholder="Your email..." />
				<button type="submit" form="newsletter-form"><i class="fa fa-send"></i></button>
			</form>
		</div>
	</div>
  </div>
</section> -->

<style>
ul.sitemap li { padding-bottom:5px;}
ul.sitemap li a{ font-size:18px;color:#Fff;font-weight:600;}
</style>

<footer id="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-4 widget footer-widget">			
				<ul class="sitemap" >
					<li><a href="/find-my-clinic">Find My Clinic</a></li>
					<li><a href="/doctors">Doctors</a></li>
					<li><a href="/treatments">Treatments</a></li>
					<li><a href="/#medical_subject">Departments</a></li>
					<li><a href="/contact">Contact us</a></li>
					<li><a href="/blog">Blog</a></li>
					<li><a href="/mypage/clinic/view">Clinic member</a></li>
					<li><a href="about">About</a></li>
				</ul>
               <!--  <a class="footer-logo" href="index.html"><img src="/front/images/logo_clinicinsite.png" alt="clinic insite" /></a>
                <p><?php echo e($SiteData->site_info); ?></p>
                <div class="divider"></div>
                <ul class="social-icons circle">
                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                    <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                    <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                </ul> -->
            </div>
            <div class="col-lg-3 col-md-3 col-sm-4 widget footer-widget from-the-blog">
                <h4><span>From the Blog</span> <img src="/front/images/divider-half.png" alt="" /></h4>
                <ul>
					<?php $__currentLoopData = $BlogData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                      <a href="#"><h3><?php echo e($data->title); ?></h3></a>
                      <p><?php echo mb_substr(strip_tags($data->content), 0, 50, "UTF-8"); ?><br/> <a href="/blogView?id=<?php echo e($data->id); ?>&returnurl=<?php echo e(urlencode($_SERVER['REQUEST_URI'])); ?>">Read More</a></p>
                      <div class="clear"></div>
                    </li>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-4 widget footer-widget">
                <h4 style="margin-bottom:0px;"><span>Top Treatments</span></h4>
				<ul class="sitemap" >
				<?php $_i = 1;?>
				<?php $__currentLoopData = $TreatmentsBannerData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php
					?>
					<li style="width: 100%;  white-space: nowrap;  overflow: hidden;  text-overflow: ellipsis;"><a href="/find-my-clinic?body_part_id=<?php echo e($data->parent_id); ?>&procedure_info_id=<?php echo e($data->id); ?>">#<?php echo e($_i); ?> <?php echo e($data->name_en); ?></a></li>
					<?php $_i++;?>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</ul>
                
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 widget footer-widget newsletter">
				<a class="footer-logo" href="index.html"><img src="/front/images/logo_clinicinsite_white.png" alt="clinic insite" /></a>
				<p><?php echo e($SiteData->site_info); ?></p>
				<p>created by<span class="right"><img src="/front/images/logo_22ND_blue.png" style="height:30px"></span></p>
                <!-- <h4><span>Newsletter</span> <img src="/front/images/divider-half.png" alt="" /></h4>
                <p><b>Subscribe to our newsletter!</b> Vel lorem ipsum. Lorem molestie odio. Interdum et malesuada fames ac ante ipsum primis in faucibus. </p>

				<form autocomplete="off" role="form" class="subscribe-form" name="newsletter_form "method="POST" action="/add/newsletter" onsubmit="return n_writeCheck(this);" >
					<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                    <input type="email" name="email" placeholder="Your email" />
                    <input type="submit" name="submit" value="SEND" class="button small alt" />
                </form> -->
            </div>
        </div><!-- end row -->
    </div><!-- end footer container -->
</footer>

<div class="bottom-bar">
    <div class="container">
    © 2017  |  ClinicInsite by |  All Rights Reserved
    </div>
</div>
<script>
	function n_writeCheck(f) {

		if (f.email && f.email.value == '') {
			alert("Please write your email address. ");
			f.email.focus();
			return false;
		}

		$.ajax({
            url:'/add/newsletter?email='+f.email.value,
            type:'get',
            success:function(data){
				if(data) {
					alert("You have successfully registered.");
					f.email.value= "";
				}
            },
			complete : function(data) {
				 flag = true;
		   },
			error:function(request,status,error){
			  
		   }
        })

		return false;
	}
</script>
