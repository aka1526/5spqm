<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- GLOBAL MAINLY STYLES-->
    <link href="/assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/assets/vendors/font-awesome/css/all.min.css" rel="stylesheet" />
    <link href="/assets/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
    <link href="/assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" />
    <!-- PLUGINS STYLES-->
    <link href="/assets/vendors/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="/assets/css/main.min.css" rel="stylesheet" />
    <!-- sweetalert2 STYLES-->
    <script src="/assets/vendors/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="/assets/vendors/sweetalert2/dist/sweetalert2.min.css">
    <!-- PAGE LEVEL STYLES-->
    <link href="/assets/css/themes/pink.css" rel="stylesheet" id="theme-style">
    <link href="/assets/css/pages/auth-light.css" rel="stylesheet" />
     <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('cssheader')
    @yield('jsheader')
</head>
    @yield('body')

    <script src="/assets/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
    <script src="/assets/vendors/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
    <script src="/assets/vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/assets/vendors/metisMenu/dist/metisMenu.min.js" type="text/javascript"></script>
    <script src="/assets/vendors/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="/assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript"></script>

    <!-- PAGE LEVEL PLUGINS-->
    <script src="/assets/vendors/chart.js/dist/Chart.min.js" type="text/javascript"></script>
    <script src="/assets/vendors/jvectormap/jquery-jvectormap-2.0.3.min.js" type="text/javascript"></script>
    <script src="/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <script src="/assets/vendors/jvectormap/jquery-jvectormap-us-aea-en.js" type="text/javascript"></script>
    <!-- CORE SCRIPTS-->
    <script src="/assets/js/app.min.js" type="text/javascript"></script>
    <!-- PAGE LEVEL SCRIPTS-->

    <script>
    $(document).ready(function(){
    	$("body").addClass("fixed-layout");
      $("#sidebar-collapse").slimScroll({height:"100%",railOpacity:"0.9"});
    });
    </script>
    @yield('jsfooter')


</html>
