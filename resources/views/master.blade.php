<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@php echo str_replace("_", " ", env('APP_NAME')); @endphp</title>

    <link rel="stylesheet" href="{{asset('fonts/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/sb-admin-2.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-select.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/select.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/fixedColumns.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-datepicker3.css')}}">
    <link rel="stylesheet" href="{{asset('css/fixedHeader.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/responsive.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/buttons.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/print.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/pace-theme-default.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/table-custom.css')}}">
    <!-- CSS Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- CSS Loading -->
    <link rel="stylesheet" href="{{asset('assets/js/jquery-loading-master/src/loading.css')}}" type="text/css">
    <!-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"> -->

    <!-- <script src="../resources/js/jquery.min.js"></script> -->
    <!-- <script src="../resources/js/jquery-3.5.1.js"></script> -->
    <script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('js/popper.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('js/jquery.easing.min.js')}}"></script>
    <script src="{{asset('js/jquery.mask.min.js')}}"></script>
    <script src="{{asset('js/jquery-ui.js')}}"></script>
    <!-- <script src="../resources/js/datepicker.min.js"></script> -->
    <script src="{{asset('js/sb-admin-2.min.js')}}"></script>
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('js/dataTables.select.min.js')}}"></script>
    <script src="{{asset('js/datatables-demo.js')}}"></script>
    <script src="{{asset('js/dataTables.fixedColumns.min.js')}}"></script>
    <script src="{{asset('js/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{asset('js/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{asset('js/Chart.min.js')}}"></script>
    <script src="{{asset('js/chart-area-demo.js')}}"></script>
    <script src="{{asset('js/chart-pie-demo.js')}}"></script>
    <script src="{{asset('js/sweatalert.js')}}"></script>
    <script src="{{asset('js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('js/jszip.min.js')}}"></script>
    <script src="{{asset('js/buttons.flash.min.js')}}"></script>
    <script src="{{asset('js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('js/pace.min.js')}}"></script>
    <script src="{{asset('js/print.min.js')}}"></script>
    <script src="{{asset('js/jquery.number.min.js')}}"></script>
    <!-- JS Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- JS loading -->
    <script src="{{asset('assets/js/jquery-loading-master/src/loading.js')}}"></script>
    {{-- <script src="../resources/js/jquery.number.min.js.map"></script> --}}
    <script>
         var link = "{{url('/')}}";
        setInterval(refreshToken, 3900000); // 65min

        function refreshToken() {
            $.get('get-csrf').done(function(data) {
                if (data != document.querySelector('meta[name="csrf-token"]').content) {
                    console.log("token expired");
                    window.location.href = "/promosi/public/login";
                } else {
                    console.log("token valid");
                }
            });
        }
    </script>
    <!-- <script>
        $(document).ready(function() {
            $("#sidebarToggle").click(function() {
                $("#accordionSidebar").toggleClass("toggled");
            });
        });
    </script> -->
</head>

<body id="page-top">
    <div id="wrapper">
        @include('sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                @include('header')

                @yield('content')
            </div>
        </div>
    </div>

    @stack('page-script')
</body>

</html>
