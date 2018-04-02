<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="bootstrap admin template">
  <meta name="author" content="">
  <title>DB Monstar</title>
  <!-- Stylesheets -->
  <link rel="apple-touch-icon" href="/img/apple-touch-icon.png">
  <link rel="shortcut icon" href="/img/favicon.ico">
  <!-- Stylesheets -->
  <link rel="stylesheet" href="/global/css/bootstrap.min.css">
  <link rel="stylesheet" href="/global/css/bootstrap-extend.min.css">
  <link rel="stylesheet" href="/assets/css/site.min.css">
  <!-- Plugins -->
  <link rel="stylesheet" href="/global/vendor/bootstrap-select/bootstrap-select.css">
  <link rel="stylesheet" href="/global/vendor/animsition/animsition.css">
  <link rel="stylesheet" href="/global/vendor/asscrollable/asScrollable.css">
  <link rel="stylesheet" href="/global/vendor/switchery/switchery.css">
  <link rel="stylesheet" href="/global/vendor/intro-js/introjs.css">
  <link rel="stylesheet" href="/global/vendor/slidepanel/slidePanel.css">
  <link rel="stylesheet" href="/global/vendor/flag-icon-css/flag-icon.css">
  <link rel="stylesheet" href="/global/vendor/chartist/chartist.css">
  <link rel="stylesheet" href="/global/vendor/jvectormap/jquery-jvectormap.css">
  <link rel="stylesheet" href="/global/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css">
  <link rel="stylesheet" href="/assets/examples/css/dashboard/v1.css">
  <link rel="stylesheet" href="/global/vendor/bootstrap-datepicker/bootstrap-datepicker.css">
  <link rel="stylesheet" href="/global/vendor/dropify/dropify.css">
  <link rel="stylesheet" href="/assets/examples/css/structure/alerts.css">
  <link rel="stylesheet" href="/global/vendor/summernote/summernote.css">
  <link rel="stylesheet" href="/global/vendor/select2/select2.css">
  <!-- Fonts -->
  <link rel="stylesheet" href="/global/fonts/weather-icons/weather-icons.css">
  <link rel="stylesheet" href="/global/fonts/web-icons/web-icons.min.css">
  <link rel="stylesheet" href="/global/fonts/brand-icons/brand-icons.min.css">
  <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>


  <!--[if lt IE 9]>
    <script src="/global/vendor/html5shiv/html5shiv.min.js"></script>
    <![endif]-->
  <!--[if lt IE 10]>
    <script src="/global/vendor/media-match/media.match.min.js"></script>
    <script src="/global/vendor/respond/respond.min.js"></script>
    <![endif]-->
  <!-- Scripts -->
  <script src="/global/vendor/breakpoints/breakpoints.js"></script>
  <script>
  Breakpoints();
  </script>
</head>
<body class="animsition site-menubar-unfold site-menubar-keep">
	<!-- modal 창 모음 Start-->
	@include('dbmon_layouts.modal')  
	<!-- modal 창 End -->

	<!--[if lt IE 8]>
	<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
	<![endif]-->

	<!-- Top -->  
	@include('dbmon_layouts.top')
	<!-- End Top -->

	<!-- Side Menu -->  
	@include('dbmon_layouts.side_menu')
	<!-- End Side Menu -->



	@yield('content')

	
</body>
</html>