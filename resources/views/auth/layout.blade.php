<!doctype html>
<html lang="en" dir="ltr">
  <head>

		<!-- META DATA -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="description" content="Shams Naturals">
		<meta name="author" content="Shams Naturals">
		<meta name="keywords" content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit.">

		<!-- FAVICON -->
		<link rel="shortcut icon" type="image/x-icon" href="{{url('/assets/images/brand/favicon.ico')}}" />

		<!-- TITLE -->
		<title>Shams Naturals</title>

		<!-- BOOTSTRAP CSS -->
		<link id="style" href="{{url('/assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" />

		<!-- STYLE CSS -->
		<link href="{{url('/assets/css/style.css')}}" rel="stylesheet"/>
		<link href="{{url('/assets/css/skin-modes.css')}}" rel="stylesheet" />

		<!--- FONT-ICONS CSS -->
		<link href="{{url('/assets/css/icons.css')}}" rel="stylesheet"/>

	</head>

	<body class="ltr login-img">

			<!-- GLOABAL LOADER -->
			<div id="global-loader">
				<img src="{{url('/assets/images/loader.svg')}}" class="loader-img" alt="Loader">
			</div>
			<!-- /GLOABAL LOADER -->

			<!-- PAGE -->
			<div class="page">
				<div>
				    <!-- CONTAINER OPEN -->
					<div class="col col-login mx-auto text-center">
						<a href="index.html" class="text-center">
							<img src="{{url('/assets/images/brand/shamsnaturals-logo.jpg')}}" class="header-brand-img" alt="">
						</a>
					</div>
					<div class="container-login100">
						<div class="wrap-login100 p-0">
							<div class="card-body">
                            @yield('content')
							</div>
						</div>
					</div>
					<!-- CONTAINER CLOSED -->
				</div>
			</div>
			<!-- End PAGE -->


		<!-- BACKGROUND-IMAGE CLOSED -->

		<!-- JQUERY JS -->
		<script src="{{url('/assets/js/jquery.min.js')}}"></script>

		<!-- BOOTSTRAP JS -->
		<script src="{{url('/assets/plugins/bootstrap/js/popper.min.js')}}"></script>
		<script src="{{url('/assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>

		<!-- Perfect SCROLLBAR JS-->
		<script src="{{url('/assets/plugins/p-scroll/perfect-scrollbar.js')}}"></script>

		<!-- STICKY JS -->
		<script src="{{url('/assets/js/sticky.js')}}"></script>

		<!-- COLOR THEME JS -->
		<script src="{{url('/assets/js/themeColors.js')}}"></script>

		<!-- CUSTOM JS -->
		<script src="{{url('/assets/js/custom.js')}}"></script>

	</body>
</html>
