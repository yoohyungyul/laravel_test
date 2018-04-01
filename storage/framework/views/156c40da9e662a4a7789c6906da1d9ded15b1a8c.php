<div class="widget member-card">
	<div class="member-card-header">
		<a href="#" class="member-card-avatar"><img src="<?php echo e(Auth::user()->photo); ?>" alt="" /></a>
		<h3><?php echo e(Auth::user()->name); ?></h3>
		<p><i class="fa fa-envelope icon"></i><?php echo e(Auth::user()->email); ?></p>
	</div>
	<div class="member-card-content">		
		<img class="hex" src="/front/images/hexagon.png" alt="" />
		<ul>
			<li <?php if($_SERVER['REQUEST_URI'] == "/mypage"): ?> class="active" <?php endif; ?> ><a href="/mypage"><i class="fa fa-user icon"></i>Profile</a></li>
			<?php if(Auth::user()->level != 3): ?>
			<li <?php if(strpos($_SERVER['REQUEST_URI'],"mypage/inquiry") == "1"): ?> class="active" <?php endif; ?>><a href="/mypage/inquiry"><i class="fa fa-envelope icon"></i>Inquiry</a></li>
			<li <?php if(strpos($_SERVER['REQUEST_URI'],"mypage/favoriteClinics") == "1"): ?> class="active" <?php endif; ?>><a href="/mypage/favoriteClinics"><i class="fa fa-heart icon"></i>Favorite Clinics</a></li>
			<?php else: ?>
			<li <?php if(strpos($_SERVER['REQUEST_URI'],"mypage/inquiry/clinic") == "1"): ?> class="active" <?php endif; ?>><a href="/mypage/inquiry/clinic"><i class="fa fa-envelope icon"></i>Inquiry</a></li>
			<li <?php if(strpos($_SERVER['REQUEST_URI'],"mypage/clinic") == "1"): ?> class="active" <?php endif; ?>><a href="/mypage/clinic/view"><i class="fa fa-hospital-o icon"></i>Clinic</a></li>
			<?php endif; ?>
			<li>
			<a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();  document.getElementById('logout-form').submit();" ><i class="fa fa-reply icon"></i>Logout</a>				
				<form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
					<?php echo e(csrf_field()); ?>

				</form>
			</a>
			</li>
		</ul>
	</div>
</div>