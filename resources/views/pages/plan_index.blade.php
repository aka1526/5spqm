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
        <div class="row">
            <div class="col-lg-4 col-md-6">
               <a href="">
                <div class="ibox bg-success color-white widget-stat">
                    <div class="ibox-body">
                        <h2 class="m-b-5 font-strong">TOP Audit</h2>
                        <div class="m-b-5">สร้างแผนตรวจประเมินพื้นที่</div><i class="fa fa-calendar widget-stat-icon"></i>
                        <div><i class="fa fa-level-up m-r-5"></i><small>TOP AUDIT</small></div>
                    </div>
                </div>
              </a>
            </div>
            <div class="col-lg-4 col-md-6">
              <a href="">
                <div class="ibox bg-info color-white widget-stat">
                    <div class="ibox-body">
                        <h2 class="m-b-5 font-strong">Committee Audit</h2>
                        <div class="m-b-5">สร้างแผนตรวจประเมินพื้นที่</div><i class="fa fa-calendar widget-stat-icon"></i>
                        <div><i class="fa fa-level-up m-r-5"></i><small>Committee Audit</small></div>
                    </div>
                </div>
              </a>
            </div>
            <div class="col-lg-4 col-md-6">
             <a href="">
                <div class="ibox bg-warning color-white widget-stat">
                    <div class="ibox-body">
                        <h2 class="m-b-5 font-strong">Self Audit</h2>
                        <div class="m-b-5">สร้างแผนตรวจประเมินพื้นที่</div><i class="fa fa-calendar widget-stat-icon"></i>
                        <div><i class="fa fa-level-up m-r-5"></i><small>Self Audit</small></div>
                    </div>
                </div>
              </a>
            </div>

        </div>


        <style>
            .visitors-table tbody tr td:last-child {
                display: flex;
                align-items: center;
            }

            .visitors-table .progress {
                flex: 1;
            }

            .visitors-table .progress-parcent {
                text-align: right;
                margin-left: 10px;
            }
        </style>

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
