@extends('pages.page_stley')
@section('title')
{{ config('app.name') }}
@endsection

<!-- @yield('cssheader') -->
<!-- @yield('jsheader') -->
@section('cssheader')
<link href="/assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet" />
 <link href="/assets/vendors/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" />
@endsection


@section('page-sidebar')
@include('pages.page_sidemenu')
@endsection
@section('content-wrapper')
<div class="content-wrapper">
    <!-- START PAGE CONTENT-->
    <div class="page-content fade-in-up">
      <div class="row">
                   <div class="col-xl-12">
                              <div class="ibox ibox-primary">
                                  <div class="ibox-head">
                                      <div class="ibox-title">สร้างแผนตรวจ  {{ $dataPosition->position_name }}
                                      </div>
                                      <div >
                                        <div class="form-group" id="date_5">
                                             <label class="font-normal"></label>
                                             <div class="input-daterange input-group" id="datepicker">
                                                 <input class="input-sm form-control" type="text" name="start" value="{{ date('d/m/Y') }}">
                                                 <span class="input-group-addon p-l-10 p-r-10">to</span>
                                                 <input class="input-sm form-control" type="text" name="end" value=" {{ \Carbon\Carbon::now()->endOfYear()->format('d/m/Y')}}">
                                             </div>
                                         </div>
                                      </div>
                                      <div>
                                          <a class="btn btn-info btn-sm btn-new" href="javascript:;"><i class="fa fa-plus"></i> เพิ่มแผนตรวจ</a>
                                      </div>
                                  </div>
                                  <div class="ibox-body ">
                                      <table class="table table-bordered">
                                          <thead class="">
                                              <tr>
                                                  <th>#</th>
                                                  <th>พื้นที่</th>
                                                  <th>หัวหน้าพื้นที่</th>
                                                  <th>ความถี่</th>
                                                  <th>Action</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                            @foreach ($dataArea as $key => $row)
                                            <tr>
                                               <td>{{ $row->area_index}}</td>
                                               <td>{{ $row->area_name}}</td>
                                               <td>{{ $row->area_owner}}</td>
                                                <td>{{ $dataPosition->auditor_period}}</td>
                                               <td>
                                                 <button class="btn btn btn-primary btn-xs m-r-5 btn-edit" data-unid="b30a86eb99e04624966c295c5ede35fb" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil font-14"></i></button>

                                               </td>
                                             </tr>
                                            @endforeach

                                        </tbody>
                                      </table>
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
<script src="/assets/vendors/moment/min/moment.min.js" type="text/javascript"></script>
<script src="/assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="/assets/vendors/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
<script>
$(document).ready(function(){


    $('#date_5 .input-daterange').datepicker({
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true,
        format: "dd/mm/yyyy"
    });
 
});
</script>
@endsection
