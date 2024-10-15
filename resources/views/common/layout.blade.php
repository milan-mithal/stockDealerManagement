<!doctype html>
<html lang="en" dir="ltr">

<head>
    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Shams Naturals">
    <meta name="author" content="Shams Naturals">
    <meta name="keywords" content="Shams Naturals">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('/assets/images/brand/favicon.ico') }}" />
    <!-- TITLE -->
    <title>Shams Naturals</title>
    <!-- BOOTSTRAP CSS -->
    <link id="style" href="{{ url('/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
    <!-- STYLE CSS -->
    <link href="{{ url('/assets/css/style.css') }}" rel="stylesheet" />
    <link href="{{ url('/assets/css/skin-modes.css') }}" rel="stylesheet" />
    <!--- FONT-ICONS CSS -->
    <link href="{{ url('/assets/css/icons.css') }}" rel="stylesheet" />
</head>

<body class="ltr app sidebar-mini">
    <!-- GLOBAL-LOADER -->
    <div id="global-loader">
        <img src="{{ url('/assets/images/loader.svg') }}" class="loader-img" alt="Loader">
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
        <div class="modal fade" id="largemodal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Alert!</h5>
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary"
                            onclick="event.preventDefault();
                                    document.getElementById('delete-form').submit();">Yes</button>
                    </div>
                    <form id="delete-form" method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
        @include('common.footer')
    </div>
    <!-- BACK-TO-TOP -->
    {{-- <a href="#top" id="back-to-top"><i class="fa fa-long-arrow-up"></i></a> --}}
    <!-- JQUERY JS -->
    <script src="{{ url('/assets/js/jquery.min.js') }}"></script>
    <!-- BOOTSTRAP JS -->
    <script src="{{ url('/assets/plugins/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ url('/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- SIDE-MENU JS-->
    <script src="{{ url('/assets/plugins/sidemenu/sidemenu.js') }}"></script>
    <!-- APEXCHART JS -->
    <script src="{{ url('/assets/js/apexcharts.js') }}"></script>
    <!-- INTERNAL SELECT2 JS -->
    <script src="{{ url('/assets/plugins/select2/select2.full.min.js') }}"></script>
    <!-- CHART-CIRCLE JS-->
    <script src="{{ url('/assets/js/circle-progress.min.js') }}"></script>
    <!-- INTERNAL DATA-TABLES JS-->
    <script src="{{ url('/assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('/assets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ url('/assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ url('/assets/plugins/datatable/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ url('/assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ url('/assets/plugins/datatable/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ url('/assets/plugins/datatable/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ url('/assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ url('/assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ url('/assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ url('/assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ url('/assets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ url('/assets/js/table-data.js') }}"></script>
    <!-- INDEX JS -->
    <script src="{{ url('/assets/js/index1.js') }}"></script>
    <!-- REPLY JS-->
    <script src="{{ url('/assets/js/reply.js') }}"></script>
    <!-- bootstrap-datepicker js (Date picker Style-01) -->
    <script src="{{ url('/assets/plugins/bootstrap-datepicker/js/datepicker.js') }}"></script>
    <!-- STICKY JS -->
    <script src="{{ url('/assets/js/sticky.js') }}"></script>
    <!-- COLOR THEME JS -->
    <script src="{{ url('/assets/js/themeColors.js') }}"></script>
    <!-- CUSTOM JS -->
    <script src="{{ url('/assets/js/custom.js') }}"></script>
    <script src="{{ url('/assets/js/portalCustom.js?ver=1.5') }}"></script>
    @if (Auth::check() && Auth::user()->role == 'admin')
        <script>
            $(document).ready(function() {
                setInterval('showNewOrders()', 30000);
            });
        </script>
    @endif
    <script>
        $(document).on('click', '.page-link', function(event) {
            event.preventDefault();
            var pageNumber = $(this).text();
            $('html, body').animate({
                scrollTop: $("#global-loader").offset().top
            }, 100);
            if ($(this).parent().hasClass('previous')) {
                $('html, body').animate({
                    scrollTop: $("#global-loader").offset().top
                }, 100);
            } else if ($(this).parent().hasClass('next')) {
                $('html, body').animate({
                    scrollTop: $("#global-loader").offset().top
                }, 100);
            }
        });
    </script>
    @yield('script')
</body>

</html>
