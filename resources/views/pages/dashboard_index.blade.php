@extends('pages.page_stley')

@section('title')
{{ config('app.name') }}
@endsection

@extends('pages.page_sidemenu')
<!-- @include('pages.page_sidemenu') -->

@section('content-wrapper')
<div class="content-wrapper">

       <div class="page-content fade-in-up">
           <div class="row">
               <div class="col">
                   <div class="ibox ibox-primary">
                       <div class="ibox-head ">
                           <div class="ibox-title">กำหนดแผนการตรวจ</div>
                           <div class="ibox-tools">

                           </div>
                       </div>
                       <div class="ibox-body">
                           <form>
                               <div class="row">
                                   <div class="col-sm-6 form-group">
                                       <label>พื้นที่</label>
                                       <input class="form-control" type="text" placeholder="First Name">
                                   </div>
                                   <div class="col-sm-6 form-group">
                                       <label>ความถี่</label>
                                       <input class="form-control" type="text" placeholder="First Name">
                                   </div>
                               </div>
                               <div class="form-group">
                                   <label>Email</label>
                                   <input class="form-control" type="text" placeholder="Email address">
                               </div>
                               <div class="form-group">
                                   <label>Password</label>
                                   <input class="form-control" type="password" placeholder="Password">
                               </div>
                               <div class="form-group">
                                   <label class="ui-checkbox">
                                       <input type="checkbox">
                                       <span class="input-span"></span>Remamber me</label>
                               </div>
                               <div class="form-group">
                                   <button class="btn btn-default" type="submit">Submit</button>
                               </div>
                           </form>
                       </div>
                   </div>
               </div>

           </div>


       </div>
       <!-- END PAGE CONTENT-->

   </div>

@endsection

@section('jsfooter')
    <!-- <script src="./assets/js/scripts/dashboard_1_demo.js" type="text/javascript"></script> -->
@endsection
