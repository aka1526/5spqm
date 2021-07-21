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
                   <input class="form-control" type="hidden" id="area_index"  name="area_index" value=""  >
                    <input class="form-control" type="hidden" id="pv"  name="pv" value="{{ $pv}}"  >
                   <div class="btn-group ml-3">

                        <button class="btn btn-info" id="docyear" name="docyear" value="{{ app('request')->input('docyear') }}">{{ app('request')->input('docyear') }}</button>
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
                  <div>
                      <a class="btn btn-warning btn-sm " href="/check"><i class="fa fa-backward"></i> กลับ</a>

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

  .btn-month {
   background:none;
   border:none;
   color:#FFF;
   font-family:Verdana, Geneva, sans-serif;
   cursor:pointer;
 }

 .color-none{
   color: #fff;
   background-color: #a3b8c8;
   border-color: #a3b8c8;
 }
.color-1 {
color: #fff;
background-color: #3333ff;
border-color: #3333ff;
}
.color-2 {
color: #fff;
background-color: #3333ff;
border-color: #3333ff;
}
.color-3 {
color: #fff;
background-color: #3333ff;
border-color: #3333ff;
}
.color-4 {
color: #fff;
background-color: #3333ff;
border-color: #3333ff;
}
.color-5 {
color: #fff;
background-color: #3333ff;
border-color: #3333ff;
}
.color-6 {
color: #fff;
background-color: #3333ff;
border-color: #3333ff;
}
.color-7 {
color: #fff;
background-color: #3333ff;
border-color: #3333ff;
}
.color-8 {
color: #fff;
background-color: #3333ff;
border-color: #3333ff;
}
.color-9 {
color: #fff;
background-color: #3333ff;
border-color: #3333ff;
}
.color-10 {
color: #fff;
background-color: #3333ff;
border-color: #3333ff;
}
.color-11 {
color: #fff;
background-color: #3333ff;
border-color: #3333ff;
}
.color-12 {
color: #fff;
background-color: #3333ff;
border-color: #3333ff;
}

 </style>
@endsection

@section('jsfooter')
    <!-- <script src="./assets/js/scripts/dashboard_1_demo.js" type="text/javascript"></script> -->
    <script type="text/javascript">
      function changeyear(y){
          $("#docyear").val(y);
          $("#docyear").text(y);
         var pv =$("#pv").val();

        window.location.href = '/check/yearmonth?pv='+pv+'&docyear='+ y;
      }

  $('.btn-month').on('click',function(){
    var m= $(this).data('month');
    var y= $("#docyear").val();
    var pv= $(this).data('pv');
    var url ="{{route('check.get')}}" ;
    if (m>0) {
        window.location.href = url+'/'+pv+'/'+y+'/'+m;
      }
  });
    </script>
@endsection
