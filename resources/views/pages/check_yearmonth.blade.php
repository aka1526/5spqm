@extends('pages.page_stley')
@section('title')
{{ config('app.name') }}
@endsection
@section('page-sidebar')
@include('pages.page_sidemenu')
@endsection
@section('content-wrapper')
<div class="content-wrapper">
     <div class="page-content fade-in-up">
         <div class="ibox">
             <div class="ibox-head">

                 <div class="ibox-title "> แผนการตรวจพื้นที่ ประจำปี
                   <div class="btn-group ml-3">
                                  <button class="btn btn-info" id="docyear" name="docyear" value="{{ date('Y')}}">{{ date('Y')}}</button>
                                  <button class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-angle-down"></i></button>
                                  <ul class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(56px, 33px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    <li>
                                        <a class="dropdown-item" href="javascript:;" onclick="changeyear('{{ date('Y')-1}}');" >{{ date('Y')-1}}</a>
                                    </li>
                                      <li>
                                          <a class="dropdown-item" href="javascript:;" onclick="changeyear('{{ date('Y')}}');" >{{ date('Y')}}</a>
                                      </li>
                                      <li>
                                          <a class="dropdown-item" href="javascript:;" onclick="changeyear('{{ date('Y')+1}}');" >{{ date('Y')+1}}</a>
                                      </li>

                                  </ul>
                              </div>
                 </div>


             </div>
             <div class="ibox-body">
                 <div class="row">
                  {!! $html !!}
                 </div>
             </div>
         </div>


     </div>
     <!-- END PAGE CONTENT-->

 </div>
 <style>
.color-1 {
color: #fff;
background-color: #7f8c8d;
border-color: #7f8c8d;
}
.color-2 {
color: #fff;
background-color: #7f8c8d;
border-color: #7f8c8d;
}
.color-3 {
color: #fff;
background-color: #7f8c8d;
border-color: #7f8c8d;
}
.color-4 {
color: #fff;
background-color: #7f8c8d;
border-color: #7f8c8d;
}
.color-5 {
color: #fff;
background-color: #7f8c8d;
border-color: #7f8c8d;
}
.color-6 {
color: #fff;
background-color: #7f8c8d;
border-color: #7f8c8d;
}
.color-7 {
color: #fff;
background-color: #7f8c8d;
border-color: #7f8c8d;
}
.color-8 {
color: #fff;
background-color: #7f8c8d;
border-color: #7f8c8d;
}
.color-9 {
color: #fff;
background-color: #7f8c8d;
border-color: #7f8c8d;
}
.color-10 {
color: #fff;
background-color: #7f8c8d;
border-color: #7f8c8d;
}
.color-11 {
color: #fff;
background-color: #7f8c8d;
border-color: #7f8c8d;
}
.color-12 {
color: #fff;
background-color: #7f8c8d;
border-color: #7f8c8d;
}

 </style>
@endsection

@section('jsfooter')
    <!-- <script src="./assets/js/scripts/dashboard_1_demo.js" type="text/javascript"></script> -->
    <script type="text/javascript">
      function changeyear(y){
          $("#docyear").val(y);
          $("#docyear").text(y);
      }
    </script>
@endsection
