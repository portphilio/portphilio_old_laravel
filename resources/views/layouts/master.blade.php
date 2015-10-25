<!DOCTYPE html>
<html lang="en">
	<head>
		@include('layouts.partials.head')
	</head>
	<body class="no-skin">
		@include('layouts.partials.navbar')
		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>
			<div id="sidebar" class="sidebar responsive">
				@include('layouts.partials.sidebar')
			</div>
			<div class="main-content">
				@include('layouts.partials.main-content')
			</div>
			<div class="footer">
				@include('layouts.partials.footer')
			</div>
			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div>
		<!--[if !IE]> -->
		<script type="text/javascript">
			window.jQuery || document.write("<script src='../assets/js/jquery.js'>"+"<"+"/script>");
		</script>
		<!-- <![endif]-->
		<!--[if IE]>
		<script type="text/javascript">
			window.jQuery || document.write("<script src='../assets/js/jquery1x.js'>"+"<"+"/script>");
		</script>
		<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.js'>"+"<"+"/script>");
		</script>
		@yield('plugin-scripts')
		<script src="assets/js/dashboard.js"></script>
		@yield('page-scripts')
	</body>
</html>