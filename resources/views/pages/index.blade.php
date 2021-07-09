@extends('pages.page_stley')

@section('title')
{{ config('app.name') }}
@endsection

@include('pages.page_sidemenu')

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
                        <div class="m-b-5">ตรวจประเมินพื้นที่</div><i class="ti-medall-alt widget-stat-icon"></i>
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
                        <div class="m-b-5">ตรวจประเมินพื้นที่</div><i class="ti-announcement widget-stat-icon"></i>
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
                        <div class="m-b-5">ตรวจประเมินพื้นที่</div><i class="ti-stamp widget-stat-icon"></i>
                        <div><i class="fa fa-level-up m-r-5"></i><small>Self Audit</small></div>
                    </div>
                </div>
              </a>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-8">

                <div class="ibox">
                    <div class="ibox-body">
                        <div class="flexbox mb-4">
                            <div>
                                <h3 class="m-0">Statistics</h3>
                                <div>Your shop sales analytics</div>
                            </div>
                            <div class="d-inline-flex">
                                <div class="px-3" style="border-right: 1px solid rgba(0,0,0,.1);">
                                    <div class="text-muted">WEEKLY INCOME</div>
                                    <div>
                                        <span class="h2 m-0">$850</span>
                                        <span class="text-success ml-2"><i class="fa fa-level-up"></i> +25%</span>
                                    </div>
                                </div>
                                <div class="px-3">
                                    <div class="text-muted">WEEKLY SALES</div>
                                    <div>
                                        <span class="h2 m-0">240</span>
                                        <span class="text-warning ml-2"><i class="fa fa-level-down"></i> -12%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <canvas id="bar_chart" style="height:260px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">Statistics</div>
                    </div>
                    <div class="ibox-body">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <canvas id="doughnut_chart" style="height:160px;"></canvas>
                            </div>
                            <div class="col-md-6">
                                <div class="m-b-20 text-success"><i class="fa fa-circle-o m-r-10"></i>Desktop 52%</div>
                                <div class="m-b-20 text-info"><i class="fa fa-circle-o m-r-10"></i>Tablet 27%</div>
                                <div class="m-b-20 text-warning"><i class="fa fa-circle-o m-r-10"></i>Mobile 21%</div>
                            </div>
                        </div>
                        <ul class="list-group list-group-divider list-group-full">
                            <li class="list-group-item">Chrome
                                <span class="float-right text-success"><i class="fa fa-caret-up"></i> 24%</span>
                            </li>
                            <li class="list-group-item">Firefox
                                <span class="float-right text-success"><i class="fa fa-caret-up"></i> 12%</span>
                            </li>
                            <li class="list-group-item">Opera
                                <span class="float-right text-danger"><i class="fa fa-caret-down"></i> 4%</span>
                            </li>
                        </ul>
                    </div>
                </div>
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

@endsection
