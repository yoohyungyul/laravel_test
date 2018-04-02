<?php
use Illuminate\Support\Facades\Input;

$SiteData = DB::table('kmh_site_setting')->first();
?>
<!DOCTYPE html>
<html lang="en">
	<head>

		@include('layouts.meta')	

		<!-- CSS file links -->
		<link href="/front/css/bootstrap.min.css" rel="stylesheet" media="screen"></link>
		<link href="/front/assets/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" media="screen">
		<link href="/front/assets/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet">
		<link href="/front/assets/slick-1.6.0/slick.css" rel="stylesheet">
		<link href="/front/assets/chosen-1.6.2/chosen.min.css" rel="stylesheet">
		<link href="/front/css/nouislider.min.css" rel="stylesheet">
		<link href="/front/css/style.css" rel="stylesheet" type="text/css" media="all" />
		<link href="/front/css/responsive.css" rel="stylesheet" type="text/css" media="all" />
		<link href="/front/css/datepicker.css" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i" rel="stylesheet">

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="/front/js/html5shiv.min.js"></script>
			<script src="/front/js/respond.min.js"></script>
		<![endif]-->
	</head>
<body>

<!-- modal 창 모음 Start-->
	@include('layouts.modal')  
	<!-- modal 창 End -->

<header class="header-default">

  <!-- <div class="top-bar">
    <div class="container">
    
        <div class="top-bar-right right">
		  @if(@Auth::guest()) 
			<a href="{{ route('login') }}" class="top-bar-item"><i class="fa fa-sign-in icon"></i>Login</a>
			<a href="{{ route('register') }}" class="top-bar-item"><i class="fa fa-user-plus icon"></i>Register</a>
			@else
				@if(Auth::user()->level < "2")
				<a href="/dbmon" class="top-bar-item" target="_blank">관리자</a>
				@endif
				<a href="{{ route('logout') }}" onclick="event.preventDefault();  document.getElementById('logout-form').submit();"  class="top-bar-item"><i class="fa fa-sign-out icon"></i>Logout</a>				
					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						{{ csrf_field() }}
					</form>
				</a>
				<a href="/mypage" class="top-bar-item"><i class="fa fa-user-plus icon"></i>My page</a>
				@if(Auth::user()->level == "3")
				<a href="/mypage/clinic/view" class="top-bar-item"><i class="fa fa fa-hospital-o icon"></i>Clinic</a>
				@endif
			@endif
          <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
  </div> -->

  <div class="container">

   
    <div class="navbar-header">

      <div class="header-details">
        <div class="header-item header-search left" style="border-left:0px">
          <table>
              <tr>
              <td><i class="fa fa-search"></i></td>
              <td class="header-item-text">
                <form autocomplete="off" class="search-form" method="GET" action="/search">
                  <input type="text" placeholder="Search..." name="keyword" value="{{ Input::get('keyword') }}"/>
                  <button type="submit"><i class="fa fa-search"></i></button>
                </form>
              </td>
            </tr>
          </table>
        </div>
        <!-- <div class="header-item header-phone left">
          <table>
            <tr>
              <td><i class="fa fa-phone"></i></td>
              <td class="header-item-text">
                Call us anytime<br/>
                <span>{{$SiteData->site_tel}}</span>
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
                <span>{{$SiteData->site_email}}</span>
              </td>
            </tr>
          </table>
        </div> -->
        <div class="clear"></div>
      </div>

      <a class="navbar-brand" href="/"><img src="/front/images/logo_clinicinsite.png" alt="kmhglobal" style="max-width:172px;" /></a>


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
		  @if(@Auth::guest()) 
		  <a href="{{ route('login') }}" class="button small alt button-icon"><i class="fa fa-user"></i>Login</a>
		  <!-- <a href="/mypage" class="button small alt button-icon"><i class="fa fa-plus"></i>Login</a> -->
		  @else 
          <a href="/mypage" class="button small alt button-icon"><i class="fa fa-user"></i>My Page</a>
		  @endif
        </div>
		 <ul class="nav navbar-nav right">
          <li @if($_SERVER['REQUEST_URI'] == "/") class="current-menu-item" @endif ><a href="/" class="active">Home</a></li>
          <li @if(strpos($_SERVER['REQUEST_URI'],"find-my-clinic") == "1" or strpos($_SERVER['REQUEST_URI'],"clinic") == "1") class="current-menu-item" @endif ><a href="/find-my-clinic" >Find My Clinic</a></li>
		  <li @if(strpos($_SERVER['REQUEST_URI'],"doctors") == "1") class="current-menu-item" @endif ><a href="/doctors" >Doctors</a></li>          
          <li @if(strpos($_SERVER['REQUEST_URI'],"treatment") == "1") class="current-menu-item" @endif ><a href="/treatments">Treatments</a></li>
		  @if(!@Auth::guest()) 
			@if(Auth::user()->level < 3)
			  <li ><a href="/dbmon">DB Mon</a></li>
			@endif
		  @endif
        </ul>


        <div class="clear"></div>

      </div>

      </div>
    </div>

  </div>
</header> 

<!-- 상단 메뉴까지 -->

@yield('content')	

<style>
#toTop {background:none; position:fixed; bottom:10px; right:1px; cursor:pointer; text-decoration:none; border-radius:5px; -moz-border-radius:5px; -webkit-border-radius:5px; padding:5px;z-index:11}
</style>

<div id="toTop" style=""><a  href="#"><img src="/front/images/up-arrow-icon.png" width="35" height="35" alt="Go to top"></a></div>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-105334147-1', 'auto');
  ga('send', 'pageview');

</script>

</body>
</html>