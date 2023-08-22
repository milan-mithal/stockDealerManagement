<!doctype html>
<html lang="en" dir="ltr">

<head>

	<!-- META DATA -->
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="Noa – Bootstrap 5 Admin & Dashboard Template">
	<meta name="author" content="Spruko Technologies Private Limited">
	<meta name="keywords" content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit.">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- FAVICON -->
	<link rel="shortcut icon" type="image/x-icon" href="{{url('/assets/images/brand/favicon.ico')}}"/>

	<!-- TITLE -->
	<title>Noa – Bootstrap 5 Admin & Dashboard Template </title>

	<!-- BOOTSTRAP CSS -->
	<link id="style" href="{{url('/assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" />

	<!-- STYLE CSS -->
	<link href="{{url('/assets/css/style.css')}}" rel="stylesheet" />
	<link href="{{url('/assets/css/skin-modes.css')}}" rel="stylesheet" />

	<!--- FONT-ICONS CSS -->
	<link href="{{url('/assets/css/icons.css')}}" rel="stylesheet" />

</head>

<body class="ltr app sidebar-mini">

	<!-- GLOBAL-LOADER -->
	<div id="global-loader">
		<img src="{{url('/assets/images/loader.svg')}}" class="loader-img" alt="Loader">
	</div>
	<!-- /GLOBAL-LOADER -->

	<!-- PAGE -->
	<div class="page">
		<div class="page-main">

			@include('common.header')

            @include('common.sidebar')
			
			@yield('content')
			
		</div>

        
		<!-- Modal -->
		<div class="modal fade"  id="largemodal" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-lg " role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" >Alert!</h5>
						<button  class="btn-close" data-bs-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<p>Are you sure want to delete?</p>
					</div>
					<div class="modal-footer">
						<button  class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<button  class="btn btn-primary" onClick=confirmDelete()>Yes</button>
					</div>
				</div>
			</div>
		</div>



		@include('common.footer')
	</div>

	<!-- BACK-TO-TOP -->
	<a href="#top" id="back-to-top"><i class="fa fa-long-arrow-up"></i></a>

	<!-- JQUERY JS -->
	<script src="{{url('/assets/js/jquery.min.js')}}"></script>

	<!-- BOOTSTRAP JS -->
	<script src="{{url('/assets/plugins/bootstrap/js/popper.min.js')}}"></script>
	<script src="{{url('/assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>

	<!-- SIDE-MENU JS-->
	<script src="{{url('/assets/plugins/sidemenu/sidemenu.js')}}"></script>

	<!-- APEXCHART JS -->
	<script src="{{url('/assets/js/apexcharts.js')}}"></script>

	<!-- INTERNAL SELECT2 JS -->
	<script src="{{url('/assets/plugins/select2/select2.full.min.js')}}"></script>

	<!-- CHART-CIRCLE JS-->
	<script src="{{url('/assets/js/circle-progress.min.js')}}"></script>

	<!-- INTERNAL DATA-TABLES JS-->
	<script src="{{url('/assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{url('/assets/plugins/datatable/js/dataTables.bootstrap5.js')}}"></script>
	<script src="{{url('/assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
	<script src="{{url('/assets/plugins/datatable/js/buttons.bootstrap5.min.js')}}"></script>
	<script src="{{url('/assets/plugins/datatable/js/jszip.min.js')}}"></script>
	<script src="{{url('/assets/plugins/datatable/pdfmake/pdfmake.min.js')}}"></script>
	<script src="{{url('/assets/plugins/datatable/pdfmake/vfs_fonts.js')}}"></script>
	<script src="{{url('/assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
	<script src="{{url('/assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
	<script src="{{url('/assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
	<script src="{{url('/assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
	<script src="{{url('/assets/plugins/datatable/responsive.bootstrap5.min.js')}}"></script>
	<script src="{{url('/assets/js/table-data.js')}}"></script>

	<!-- INDEX JS -->
	<script src="{{url('/assets/js/index1.js')}}"></script>

	<!-- REPLY JS-->
	<script src="{{url('/assets/js/reply.js')}}"></script>

	<!-- PERFECT SCROLLBAR JS-->
	<script src="{{url('/assets/plugins/p-scroll/perfect-scrollbar.js')}}"></script>
	<script src="{{url('/assets/plugins/p-scroll/pscroll.js')}}"></script>

    <!-- STICKY JS -->
    <script src="{{url('/assets/js/sticky.js')}}"></script>

    <!-- COLOR THEME JS -->
    <script src="{{url('/assets/js/themeColors.js')}}"></script>

	<!-- CUSTOM JS -->
	<script src="{{url('/assets/js/custom.js')}}"></script>
	<script src="{{url('/assets/js/portalCustom.js')}}"></script>

	@yield('script')

</body>

</html>