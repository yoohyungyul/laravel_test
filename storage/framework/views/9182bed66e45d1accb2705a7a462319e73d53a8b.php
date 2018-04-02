<!DOCTYPE html>
<html lang="en">
	<head>

		<?php echo $__env->make('layouts.meta', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>	

		<!-- CSS file links -->
		<link href="/front/css/bootstrap.min.css" rel="stylesheet" media="screen"></link>
		<link href="/front/assets/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" media="screen">
		<link href="/front/assets/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet">
		<link href="/front/assets/slick-1.6.0/slick.css" rel="stylesheet">
		<link href="/front/assets/chosen-1.6.2/chosen.min.css" rel="stylesheet">
		<link href="/front/css/nouislider.min.css" rel="stylesheet">
		<link href="/front/css/style.css" rel="stylesheet" type="text/css" media="all" />
		<link href="/front/css/responsive.css" rel="stylesheet" type="text/css" media="all" />
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i" rel="stylesheet">

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="/front/js/html5shiv.min.js"></script>
			<script src="/front/js/respond.min.js"></script>
		<![endif]-->
	</head>
<body>

<header>

<div class="top-bar">
	<div class="container">
		<div class="top-bar-left left">
			<a href="mailto:hello@homely.com" class="top-bar-item left"><i class="fa fa-envelope icon"></i> hello@homely.com</a>
			<div class="top-bar-item left"><i class="fa fa-phone icon"></i> 123-456-5675</div>
			<div class="clear"></div>
        </div>
        <div class="top-bar-right right">		
			<?php if(@Auth::guest()): ?> 
			<a href="<?php echo e(route('login')); ?>" class="top-bar-item"><i class="fa fa-sign-in icon"></i>Login</a>
			<a href="<?php echo e(route('register')); ?>" class="top-bar-item"><i class="fa fa-user-plus icon"></i>Register</a>
			<?php else: ?>
				<?php if(Auth::user()->level == "1"): ?>
				<a href="/dbmon" class="top-bar-item" target="_blank">관리자</a>
				<?php endif; ?>
			<a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();  document.getElementById('logout-form').submit();"  class="top-bar-item"><i class="fa fa-sign-out icon"></i>Logout</a>				
				<form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
					<?php echo e(csrf_field()); ?>

				</form>
			</a>
			<a href="/mypage" class="top-bar-item"><i class="fa fa-user-plus icon"></i>My page</a>
			<?php endif; ?>
			<ul class="top-bar-item right social-icons">
				<li><a href="#"><i class="fa fa-facebook"></i></a></li>
				<li><a href="#"><i class="fa fa-twitter"></i></a></li>
				<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
			</ul>
			<div class="clear"></div>
        </div>
		<div class="clear"></div>
	</div>
</div>

<div class="container">
    <!-- logo -->
    <div class="navbar-header">
        <a class="navbar-brand" href="/"><img src="/front/images/logo-kmh.png" alt="kmhglobal" style="max-width:172px;" /></a>
    </div>

    <!-- nav toggle -->
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>

	<style>
		.navbar-nav li a.active {color:#48a0dc}
	</style>

    <!-- main menu -->
    <div class="navbar-collapse collapse">
      <div class="main-menu-wrap">
        <div class="member-actions right">
          <a href="user-submit-property.html" class="button small alt button-icon"><i class="fa fa-plus"></i>Submit Property</a>
        </div>

        <ul class="nav navbar-nav right">
          <li ><a href="/" class="active">Home</a></li>
          <li ><a href="/find-my-clinic" >Find My Clinic</a></li>
		  <li ><a href="/doctors" >Doctors</a></li>          
          <li><a href="/contact">Contact</a></li>
        </ul>
        <div class="clear"></div>
      </div>
    </div>

  </div><!-- end container -->
</header>
<!-- 
<header class="header-default">

  <div class="top-bar">
    <div class="container">
        <div class="top-bar-left left">
          <ul class="top-bar-item right social-icons">
            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
          </ul>
          <div class="clear"></div>
        </div>
        <div class="top-bar-right right">
          <a href="login.html" class="top-bar-item"><i class="fa fa-sign-in icon"></i>Login</a>
          <a href="register.html" class="top-bar-item"><i class="fa fa-user-plus icon"></i>Register</a>
          <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
  </div>

  <div class="container">

   
    <div class="navbar-header">

      <div class="header-details">
        <div class="header-item header-search left">
          <table>
              <tr>
              <td><i class="fa fa-search"></i></td>
              <td class="header-item-text">
                <form class="search-form">
                  <input type="text" placeholder="Search..." />
                  <button type="submit"><i class="fa fa-search"></i></button>
                </form>
              </td>
            </tr>
          </table>
        </div>
        <div class="header-item header-phone left">
          <table>
            <tr>
              <td><i class="fa fa-phone"></i></td>
              <td class="header-item-text">
                Call us anytime<br/>
                <span>(+200) 123 456 5665</span>
              </td>
            </tr>
          </table>
        </div>
        <div class="header-item header-phone left">
          <table>
            <tr>
              <td><i class="fa fa-envelope"></i></td>
              <td class="header-item-text">
                Drop us a line<br/>
                <span>hello@homely.com</span>
              </td>
            </tr>
          </table>
        </div>
        <div class="clear"></div>
      </div>

      <a class="navbar-brand" href="index.html"><img src="/front/images/logo-kmh.png" alt="kmhglobal" style="max-width:172px;" /></a>


      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

    </div>


    <div class="navbar-collapse collapse">
      <div class="main-menu-wrap">
        <div class="container-fixed">

        <div class="member-actions right">
          <a href="user-submit-property.html" class="button small alt button-icon"><i class="fa fa-plus"></i>Submit Property</a>
        </div>
        <ul class="nav navbar-nav right">
          <li><a href="/">Home</a></li>
          <li class="menu-item-has-children">
            <a href="property-listing-grid.html">Properties</a>
            <ul class="sub-menu">
              <li><a href="property-listing-grid.html">Listing Grid</a></li>
              <li><a href="property-listing-grid-sidebar.html">Listing Grid Sidebar</a></li>
              <li><a href="property-listing-row.html">Listing Row</a></li>
              <li><a href="property-listing-row-sidebar.html">Listing Row Sidebar</a></li>
              <li><a href="property-listing-map.html">Listing Map</a></li>
              <li class="menu-item-has-children">
                <a href="property-single.html">Property Single</a>
                <ul class="sub-menu">
                  <li><a href="property-single.html">Property Single Classic</a></li>
                  <li><a href="property-single-full.html">Property Single Full Width</a></li>
                </ul>
              </li>
            </ul>
          </li>
          <li class="menu-item-has-children">
            <a href="agent-listing-grid.html">Agents</a>
            <ul class="sub-menu">
              <li><a href="agent-listing-grid.html">Agent Listing Grid</a></li>
              <li><a href="agent-listing-grid-sidebar.html">Agent Listing Grid Sidebar</a></li>
              <li><a href="agent-listing-row.html">Agent Listing Row</a></li>
              <li><a href="agent-listing-row-sidebar.html">Agent Listing Row Sidebar</a></li>
              <li><a href="agent-single.html">Agent Single</a></li>
            </ul>
          </li>
          <li class="menu-item-has-children">
            <a href="blog-right-sidebar.html">Blog</a>
            <ul class="sub-menu">
              <li><a href="blog-right-sidebar.html">Blog Right Sidebar</a></li>
              <li><a href="blog-left-sidebar.html">Blog Left Sidebar</a></li>
              <li><a href="blog-full-width.html">Blog Full Width</a></li>
              <li><a href="blog-creative.html">Blog Creative</a></li>
              <li><a href="blog-single.html">Blog Single</a></li>
            </ul>
          </li>
          <li class="menu-item-has-children">
            <a href="#">Pages</a>
            <ul class="sub-menu">
              <li><a href="about.html">About</a></li>
              <li><a href="faq.html">FAQ</a></li>
              <li><a href="404.html">404 Error</a></li>
              <li><a href="login.html">Login</a></li>
              <li><a href="register.html">Register</a></li>
			  <li class="menu-item-has-children">
                <a href="user-my-properties.html">User Pages</a>
                <ul class="sub-menu">
				  <li><a href="user-profile.html">User Profile</a></li>
                  <li><a href="user-my-properties.html">My Properties</a></li>
				  <li><a href="user-favorite-properties.html">Favorited Properties</a></li>
                  <li><a href="user-submit-property.html">Submit Property</a></li>
                </ul>
              </li>
              <li><a href="elements.html">Elements</a></li>
            </ul>
          </li>
          <li><a href="contact.php">Contact</a></li>
        </ul>
        <div class="clear"></div>

      </div>

      </div>
    </div>

  </div>
</header> -->

<!-- 상단 메뉴까지 -->

<?php echo $__env->yieldContent('content'); ?>	


</body>
</html>