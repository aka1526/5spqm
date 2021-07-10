<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- GLOBAL MAINLY STYLES-->
    <link href="./assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="./assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="./assets/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
    <!-- PLUGINS STYLES-->
    <link href="./assets/vendors/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="assets/css/main.min.css" rel="stylesheet" />
    <!-- sweetalert2 STYLES-->
    <script src="./assets/vendors/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="./assets/vendors/sweetalert2/dist/sweetalert2.min.css">
    <!-- PAGE LEVEL STYLES-->
    <link href="assets/css/themes/pink.css" rel="stylesheet" id="theme-style">
     <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('cssheader')
    @yield('jsheader')
</head>
<body class="fixed-navbar ">
    <div class="page-wrapper">
        <!-- START HEADER-->
        <header class="header">
            <div class="page-brand">
                <a class="link sidebar-toggler js-sidebar-toggler" href="#">
                    <span class="brand">5ส.
                        <span class="brand-tip">PQM</span>
                    </span>
                    <span class="brand-mini">5ส</span>
                </a>
            </div>
            <div class="flexbox flex-1">
                <!-- START TOP-LEFT TOOLBAR-->

                <ul class="nav navbar-toolbar">
                    <li >
                        <a class="nav-link sidebar-toggler js-sidebar-toggler"><i class="ti-menu"></i></a>
                    </li>
                    <li >
                      <form class="navbar-search" action="javascript:;">
                           <div class="rel">
                             <div class="text-white"><h4>ทีมตรวจประเมิน 5ส</h4></div>
                               <!--    <span class="search-icon"><i class="ti-search"></i></span>
                            <input class="form-control input-sm" placeholder="Search here..."> -->
                           </div>
                       </form>
                    </li>

                </ul>
                <!-- END TOP-LEFT TOOLBAR-->
                <!-- START TOP-RIGHT TOOLBAR-->
                <ul class="nav navbar-toolbar">

                    <li class="dropdown dropdown-user">
                        <a class="nav-link dropdown-toggle link" data-toggle="dropdown">
                            <img src="./assets/img/admin-avatar.png" />
                         </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                           <a class="dropdown-item" href="login.html"><i class="fa fa-power-off"></i>Logout</a>
                        </ul>
                    </li>
                </ul>
                <!-- END TOP-RIGHT TOOLBAR-->
            </div>
        </header>
        <!-- END HEADER-->
        <!-- START SIDEBAR-->
          @yield('page-sidebar')
        <!-- END SIDEBAR-->
        <!-- START PAGE CONTENT-->
        @yield('content-wrapper')
        <!-- END PAGE CONTENT-->
    </div>

    <!-- BEGIN PAGA BACKDROPS-->
    <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div>
    <!-- END PAGA BACKDROPS-->
    <!-- CORE PLUGINS-->
    <script src="./assets/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/metisMenu/dist/metisMenu.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL PLUGINS-->
    <script src="./assets/vendors/chart.js/dist/Chart.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/jvectormap/jquery-jvectormap-2.0.3.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <script src="./assets/vendors/jvectormap/jquery-jvectormap-us-aea-en.js" type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="assets/js/app.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->

    <script>
    $(document).ready(function(){
    	$("body").addClass("fixed-layout");
      $("#sidebar-collapse").slimScroll({height:"100%",railOpacity:"0.9"});
    });
    </script>
    @yield('jsfooter')
</body>

</html>
