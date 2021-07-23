@extends('pages.page_stley_login')

@section('title')
{{ config('app.name') }}
@endsection

@section('body')
<body class="bg-silver-300">
    <div class="content">
        <div class="brand">
            <a class="link" href="/">กลับสู่หน้าหลัก</a>
        </div>
        <form id="login-form" action="{{ route('user.login_check')}}" method="post" enctype="multipart/form-data">
          @csrf
            <h2 class="login-title">ทีมตรวจประเมิน 5ส</h2>
            <div class="form-group">
                <div class="input-group-icon right">
                    <div class="input-icon"><i class="fa fa-envelope"></i></div>
                    <input class="form-control" type="text" name="user_name" id="user_name" placeholder="User Name" autocomplete="off">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group-icon right">
                    <div class="input-icon"><i class="fa fa-lock font-16"></i></div>
                    <input class="form-control" type="password" name="user_password" id="user_password" placeholder="Password">
                </div>
            </div>
            <div class="form-group d-flex justify-content-between">

                <a href="#">ลืมรหัสผ่าน?</a>
            </div>
            <div class="form-group">
                <button class="btn btn-info btn-block" type="submit">Login</button>
            </div>


        </form>
    </div>
    <!-- BEGIN PAGA BACKDROPS-->
    <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div>
    <!-- END PAGA BACKDROPS-->
    <!-- CORE PLUGINS -->

</body>

@endsection

@section('jsfooter')
<script src="/assets/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
<script src="/assets/vendors/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
<script src="/assets/vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
<!-- PAGE LEVEL PLUGINS -->
<script src="/assets/vendors/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>
<!-- CORE SCRIPTS-->
<script src="assets/js/app.js" type="text/javascript"></script>
<!-- PAGE LEVEL SCRIPTS-->
<script type="text/javascript">
    $(function() {
        $('#login-form').validate({
            errorClass: "help-block",
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true
                }
            },
            highlight: function(e) {
                $(e).closest(".form-group").addClass("has-error")
            },
            unhighlight: function(e) {
                $(e).closest(".form-group").removeClass("has-error")
            },
        });
    });
</script>
@endsection
