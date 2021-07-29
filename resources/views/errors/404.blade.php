<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title>Page Error 404</title>
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
     <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body class="fixed-navbar ">
  <div class="container mt-5 pt-5">
       <div class="alert alert-danger text-center">
           <h2 class="display-3">404</h2>
           <p class="display-5">Oops! Something is wrong.</p>

       </div>
      <div class="text-center"> <a class="btn btn-primary" href="/" > <i class="fas fa-home"></i> กลับสู่หน้าหลัก </a></div>
      </p>
   </div>
</body>
</html>
