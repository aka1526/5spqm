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
                                 <form name="frmPlan" id="frmPlan"  method="POST" action="{{ route('planmaster.createplan')}}" enctype="multipart/form-data" >
                                    @csrf
                                    <input  type="hidden" id='position_type' name='position_type' value="{{ $dataPosition->position_name_eng }}">
                                  <div class="ibox-head">
                                      <div class="ibox-title">สร้างแผนตรวจ  {{ $dataPosition->position_name }}</div>
                                      <div class="ibox-title">วันที่   </div>
                                      <div >
                                        <div class="form-group" id="date_2">
                                             <label class="font-normal"></label>
                                             <div class="input-group date">
                                                 <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                 <input class="form-control" type="text" id='plandate' name='plandate' value="{{ date('d/m/Y')}}">
                                             </div>
                                         </div>
                                      </div>

                                      <div class="ibox-title">กลุ่มเริ่มต้น   </div>
                                      <div >

                                           @if($dataPosition->position_name_eng =='SELF')
                                              <input  type="hidden" id="groups" name="groups" value="">
                                             @else
                                             <div class="form-group" >
                                               <label class="font-normal"></label>
                                                <select class="form-control input-sm col-sm" id="groups" name="groups" required>
                                                    <option value="">--เลือก--</option>
                                                  @foreach ($dataGroups as $key => $rowGroup)
                                                      <option value="{{ $rowGroup->group_index }}"  >{{ $rowGroup->group_name }}</option>
                                                  @endforeach
                                                  </select>
                                              </div >
                                           @endif



                                     </div>

                                      <div class="ibox-tools">

                                        <a class="  btn btn-warning btn-sm " href="/plan"><i class="fa fa-backward"></i> กลับ</a>
                                          <!-- <a class="btn btn-info btn-sm btn-new" href="javascript:;"><i class="fa fa-plus"></i> แผน</a> -->
                                  <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-plus-square"></i> สร้างแผน</button>
                                  <button type="button" data-pv="{{ $pv}}" class="btn btn-danger btn-delete btn-sm"><i class="fa fa-trash"></i> ลบแผน</button>
                                  </div>


                                  </div>
                                 </form>
                                 @if (session()->has('result'))
                                    <script type="text/javascript">
                                      Swal.fire({
                                          icon: "{{ session('result') }}",
                                          title: "{{ session('title') }}",
                                          showConfirmButton: false,
                                          timer: 1500
                                        });
                                      </script>
                                  @endif

                                  <div class="ibox-body ">
                                      <table class="table table-bordered">
                                          <thead class="">
                                              <tr>
                                                  <th>#</th>
                                                  <th>พื้นที่</th>
                                                  <th>หัวหน้าพื้นที่</th>
                                                  <th>ความถี่</th>
                                                  <th>วันที่ล่าสุด</th>
                                                  <th>กลุ่ม/ทีม</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                            @foreach ($dataPlanMaster as $key => $row)
                                            <tr>
                                               <td>{{ $row->area_index}}</td>
                                               <td>{{ $row->area_name}}</td>
                                               <td>{{ $row->area_owner }}</td>
                                              <td>{{ $dataPosition->auditor_period}}</td>
                                              <td>{{ ($row->datestart !='') ?  date('d-m-Y',strtotime($row->datestart)) : '' }}</td>

                                               <td>  {{  ($row->groups !='') ? $row->groups :'-' }}</td>
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
    // $('#date_5 .input-daterange').datepicker({
    //     keyboardNavigation: false,
    //     forceParse: false,
    //     autoclose: true,
    //     format: "dd/mm/yyyy"
    // });

    $('#date_2 .input-group.date').datepicker({
       startView: 1,
       todayBtn: "linked",
       keyboardNavigation: false,
       forceParse: false,
       autoclose: true,
       format: "dd/mm/yyyy"
   });

});


$('.Groupcheck').on('change',function () {
  var unid =$(this).data('unid');
  var val =$(this).val();
  var field='';
//  alert(val);
   var url ="{{ route('planmaster.updatefield')}}";
        $.ajax({
           type: "POST",
           url: url,
           data: {unid:unid,field:field,val:val}, // serializes the form's elements.
           success: function(data)
           {
               //alert(data); // show response from the php script.
           }

});
});


$(".btn-delete").on('click',function (e){
	e.preventDefault();
	var pv =$(this).data('pv');
    var plandate= $("#plandate").val();

Swal.fire({
				title: "คุณต้องการลบ แผนวันที่ "+ plandate+ ' ?',
				//text: "Once deleted, you will not be able to recover this imaginary file!",
				icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
				})
				.then((willDelete) => {
				if (willDelete) {
                    var url="{{route('planmaster.DeletePlanMasterPlan')}}";
                    $.ajax({
                            type: "POST",
                            url: url,
                            data:{position_type:pv,plandate:plandate,"_token": "{{ csrf_token() }}"}, // serializes the form's elements.
                            success: function(data)
                            {
                                Swal.fire({
                                        title: data.msg,
                                        //text: "Once deleted, you will not be able to recover this imaginary file!",
                                        icon: data.result,

                                        });

                            }
                    });

				}
				});
		});


</script>
@endsection
