@extends('pages.page_stley')
@section('title')
{{ config('app.name') }}
@endsection
@section('page-sidebar')
@include('pages.page_sidemenu')
@endsection
@section('content-wrapper')
<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
        <div class="row justify-content-md-center">
          @if(isset($position))
              @foreach ($position as $key => $row)
                <div class="col-lg-4 col-md-6">
                     <a href="{{ route('check.yearmonth').'?pv='.$row->position_name_eng }}">
                    <div class="ibox bg-success color-white widget-stat">
                        <div class="ibox-body">
                            <h2 class="m-b-5 font-strong">{{ $row->audit_position}}</h2>
                            <div class="m-b-5">ตรวจประเมินพื้นที่ </div><i class="ti-medall-alt widget-stat-icon"></i>
                            <div><i class="fa fa-level-up m-r-5"></i><small>{{ $row->position_eng }}</small></div>
                        </div>
                    </div>
                  </a>
                </div>
              @endforeach
          @else
            <h2 class="m-b-5 font-strong"> ไม่พบข้อมูลการตรวจประเมิน</h2>
          @endif

        </div>


    </div>
    <!-- END PAGE CONTENT-->
    <!-- <footer class="page-footer">
        <div class="font-13">2018 © <b>AdminCAST</b> - All rights reserved.</div>
        <a class="px-4" href="http://themeforest.net/item/adminca-responsive-bootstrap-4-3-angular-4-admin-dashboard-template/20912589" target="_blank">BUY PREMIUM</a>
        <div class="to-top"><i class="fa fa-angle-double-up"></i></div>
    </footer> -->
</div>
@endsection

@section('jsfooter')
    <!-- <script src="./assets/js/scripts/dashboard_1_demo.js" type="text/javascript"></script> -->
@endsection
