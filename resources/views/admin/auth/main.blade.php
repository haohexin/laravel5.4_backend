<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>BackEnd</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{url("/AdminLTE/bootstrap/css/bootstrap.min.css")}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{url("/AdminLTE/dist/css/font-awesome.min.css")}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{url("/AdminLTE/dist/css/ionicons.min.css")}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{url("/AdminLTE/dist/css/AdminLTE.min.css")}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{url("/AdminLTE/dist/css/skins/_all-skins.min.css")}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{url("/AdminLTE/plugins/iCheck/flat/blue.css")}}">
    <!-- Morris chart -->
{{--<link rel="stylesheet" href="{{url("/AdminLTE/plugins/morris/morris.css")}}">--}}
<!-- jvectormap -->
    <link rel="stylesheet" href="{{url("/AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.css")}}">
    <link rel="stylesheet" href="{{url("/AdminLTE/jeDate/skin/jedate.css")}}">
    <link rel="stylesheet" href="{{url("/AdminLTE/sweetalert/sweetalert.css")}}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{url("/AdminLTE/date/css/amazeui.datetimepicker.css")}}"/>
    <link rel="stylesheet" href="{{url("/AdminLTE/plugins/datepicker/datepicker3.css")}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{url("/AdminLTE/plugins/daterangepicker/daterangepicker.css")}}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{url("/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css")}}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <header class="main-header">
        <!-- Logo -->
        <a href="{{url("/admin/index")}}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>K</b>en</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">BackEnd</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{url("/AdminLTE/dist/img/avatar04.png")}}" class="user-image" alt="User Image">
                            <span class="hidden-xs">
                                {{$manager =Auth::guard('admin')->user()->account}}
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-right">
                                    <a href="{{url("/admin/logout")}}" class="btn btn-default btn-flat">登出</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->
                    <li>
                        {{--<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>--}}
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="header">Navigation</li>
                @include('admin.auth.nav')
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{--弹窗--}}
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if (session()->has('flash_notification.message'))
                        <div class="alert alert-{{ session('flash_notification.level') }}">
                            <button type="button" class="close" data-dismiss="alert"
                                    aria-hidden="true">&times;
                            </button>

                            {!! session('flash_notification.message') !!}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- Content Header (Page header) -->
    @yield('content')
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2016-{{ \Carbon\Carbon::now()->year }} <a
                    href="#" target="_blank">ken's backEnd</a>.
        </strong> All rights reserved.
    </footer>
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
{{--<script src="{{url("/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js")}}"></script>--}}
<!-- jQuery UI 1.11.4 -->
<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>

{{--<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>--}}
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="{{url("/AdminLTE/bootstrap/js/bootstrap.min.js")}}"></script>
<!-- Morris.js charts -->
<script src="{{url("/AdminLTE/plugins/raphael/raphael-min.js")}}"></script>
{{--<script src="{{url("/AdminLTE/plugins/morris/morris.min.js")}}"></script>--}}
<!-- Sparkline -->
<script src="{{url("/AdminLTE/plugins/sparkline/jquery.sparkline.min.js")}}"></script>
<!-- jvectormap -->
<script src="{{url("/AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js")}}"></script>
<script src="{{url("/AdminLTE/plugins/jvectormap/jquery-jvectormap-world-mill-en.js")}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{url("/AdminLTE/plugins/knob/jquery.knob.js")}}"></script>
<!-- daterangepicker -->
<script src="{{url("/AdminLTE/plugins/moment/moment.min.js")}}"></script>
<script src="{{url("/AdminLTE/plugins/daterangepicker/daterangepicker.js")}}"></script>
<!-- datepicker -->
<script src="{{url("/AdminLTE/plugins/datepicker/bootstrap-datepicker.js")}}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{url("/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js")}}"></script>
<!-- Slimscroll -->
<script src="{{url("/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js")}}"></script>
<!-- FastClick -->
<script src="{{url("/AdminLTE/plugins/fastclick/fastclick.js")}}"></script>
<!-- AdminLTE App -->
<script src="{{url("/AdminLTE/dist/js/app.min.js")}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{--<script src="{{url("/AdminLTE/dist/js/pages/dashboard.js")}}"></script>--}}
<!-- AdminLTE for demo purposes -->
<script src="{{url("/AdminLTE/dist/js/demo.js")}}"></script>
@yield('js')
</body>
</html>
