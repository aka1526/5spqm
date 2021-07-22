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

           <div class="row">
             <div class="col-xl-12">
                        <div class="ibox ibox-primary">

                            <div class="ibox-head">
                                <div class="ibox-title">รายชื่อสมาชิกทีม {{ isset($dataAuditposition->position_name) ? $dataAuditposition->position_name : '' }}  </div>
                                <div>
                                    <a class="btn btn-warning btn-sm " href="/auditor"><i class="fa fa-backward"></i> กลับ</a>
                                    <a class="btn btn-info btn-sm btn-membernew" href="javascript:;"><i class="fa fa-plus"></i> เพิ่มสมาชิก</a>
                                </div>
                            </div>

                            <div class="ibox-body ">
                                <table class="table table-bordered">
                                    <thead class="">
                                        <tr>
                                            <th>#</th>
                                            <th>ชื่อทีมตรวจ</th>
                                            @if( $dataAuditposition->position_name_eng =='SELF' )
                                            <th>พื้นที่</th>
                                            @endif
                                            <th>ทีมตรวจ</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @foreach ($dataAuditor as $key => $row)
                                      <tr>
                                          <td>{{ $row->auditor_item }}</td>
                                          <td>{{ $row->auditor_name }}</td>

                                          @if( $dataAuditposition->position_name_eng =='SELF' )
                                          <td>{{ $row->area_name }}</td>
                                          @endif
                                          <td>{{ $row->auditor_group }}</td>
                                          <td>
                                            <button class="btn btn btn-primary btn-xs m-r-5 btn-edit" data-unid="{{ $row->unid }}" data-toggle="tooltip" data-original-title="Edit" ><i class="fas fa-pencil-alt font-14"></i></button>
                                            <button class="btn btn-danger btn-xs btn-delete" data-unid="{{ $row->unid }}" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash font-14"></i></button>
                                        </td>
                                      </tr>
                                       @endforeach


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

           </div>

       </div>
       <!-- END PAGE CONTENT-->

   </div>

   <!-- Modal -->
   <div class="modal fade" id="OpenFrmSelf" name="OpenFrmSelf" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
     <div class="modal-dialog  modal-dialog-centered" role="document">
       <div class="modal-content">
         <div class="modal-header bg-primary ">
           <h5 class="modal-title text-white" id="exampleModalLongTitle">ข้อมูลสมาชิก</h5>
           <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
         <div class="modal-body ">

           <form id="FrmAuditor" name="FrmAuditor" action="{{ route('auditor.member.add')}}" method="post" enctype="multipart/form-data">
             @csrf
              <input  type="hidden" id="unid" name="unid" value="">
              <input  type="hidden" id="audit_position_unid" name="audit_position_unid" value="{{  $dataAuditposition->unid }}">
              <input  type="hidden" id="audit_position" name="audit_position" value="{{  $dataAuditposition->position_name }}">
              <div class="row">
                        <div class="col-sm-2 form-group">
                            <label>ลำดับ</label>
                            <input class="form-control" type="number" id="auditor_item" min="1" max="20" name="auditor_item" placeholder="ลำดับ" value="{{ count($dataAuditor)+1}}" required>
                        </div>
                        <div class="col-sm-10 form-group">


        										<label class="col-sm-3 col-form-label">รหัสสินค้า</label>
        										<div class="col-sm-9">
        											<select class="form-control selectpicker" data-size="10"
        											data-live-search="true" data-style="btn-primary" id="CODE_MASTER" name="CODE_MASTER">
         										 <option value="">Select</option>
         										 	@<?php foreach ($dtUser as $key => $value): ?>
         										 				<option value="{{ $value->unid }}"  >{{ $value->user_name }}</option>
         										 	<?php endforeach; ?>

         										</select>
        										</div>

                            <!-- <label>ชื่อผู้ตรวจ</label> -->

                             <!-- <input class="form-control" type="text" id="auditor_name" name="auditor_name" placeholder="ชื่อผู้ตรวจ" required> -->
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                          <label >กลุ่ม</label>
                          <select class="form-control input-sm" id="auditor_group" name="auditor_group"  {{ strtolower($dataAuditposition->position_name_eng ) =='self' ? 'disabled' : 'required' }} >
                              <option value=""></option>
                              @foreach ($dtGroup  as $key => $grow)
                                <option value="{{ $grow->group_name }}">{{ $grow->group_name }}</option>
                              @endforeach

                          </select>
                        </div>
                    </div>
                    <div id="areaauditdata"></div>
           </form>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Close</button>
           <button type="button" class="btn btn-primary btn-save" name="btn-save" id="btn-save" >Save</button>
         </div>
       </div>
     </div>
   </div>

@endsection

@section('jsfooter')
    <!-- <script src="./assets/js/scripts/dashboard_1_demo.js" type="text/javascript"></script> -->
<script>

$(".btn-delete").on('click',function (e){

    var unid =$(this).data('unid');

    var url = "{{ route('auditor.member.delete')}}";
        Swal.fire({
            title: 'คุณต้องการลบข้อมูล?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'

        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                          type: "POST",
                          url: url,
                          data:{unid:unid,"_token": "{{ csrf_token() }}"},
                          success: function(data)
                          {
                            if(data.result){
                              Swal.fire({
                                title: 'ลบข้อมูลเรียบร้อย?',
                                icon: 'success',
                                timer : 1200,
                              }).then(() => {
                                   location.reload();
                              });
                            } else {
                              Swal.fire({
                                title: 'เกิดข้อผิดพลาด?',
                                icon: 'error',
                                timer : 1200,
                              }).then(() => {
                                   location.reload();
                              });
                            }

                          }
                  });
            }
        });

   });


$(".btn-edit").on('click',function (e){
 e.preventDefault();

 var unid =$(this).data('unid');
 var url = "{{ route('auditor.member.get')}}";
  $("#FrmAuditor").attr('action', "{{ route('auditor.member.edit')}}");
 $.ajax({
           type: "get",
           url: url,
           data: {unid:unid}, // serializes the form's elements.
           success: function(data)
           {
              //console.log(data.AuditArea);
           var res= data.data;

           $("#unid").val(res.unid);

            $("#auditor_name").val(res.auditor_name);
            $("#audit_position_unid").val(res.audit_position_unid);
            $("#audit_position").val(res.audit_position);
            $("#auditor_group").val(res.auditor_group);

            $("#auditor_item").val(res.auditor_item);
            $("#auditor_name").val(res.auditor_name);
            $("#auditor_area").val(res.auditor_area);
            $("#area_name").val(res.area_name);
            $("#areaauditdata").html(data.AuditArea);
            if(res){
              $('#OpenFrmSelf').modal('show');
            }
           }
         });
   });


   $(".btn-membernew").on('click',function (e){
     var unid =$(this).data('unid');
     var url = "{{ route('auditor.member.get')}}";
     $.ajax({
               type: "get",
               url: url,
               data: {unid:unid}, // serializes the form's elements.
               success: function(data)
               {
                // console.log(data.AuditArea);
                 $("#areaauditdata").html(data.AuditArea);
                }
      });
      $('#OpenFrmSelf').modal('show');
  });

   $(".btn-save").on('click',function (e){
          e.preventDefault();
          var form = $("#FrmAuditor");
          var url = form.attr('action');

          $.ajax({
                 type: "POST",
                 url: url,
                 data: form.serialize(),
                 success: function(data)
                 {
                   if(data.result){
                     Swal.fire({
                      icon: 'success',
                      title: 'บันทึกสำเร็จ...',
                      timer : 1200
                      }).then((result) => {
                         $('#OpenFrmArea').modal('hide');
                          location.reload();
                      });
                   } else {

                     Swal.fire({
                      icon: 'error',
                      title: 'เกิดข้อผิดพลาด!...',
                      timer : 1200
                      }).then((result) => {
                         $('#OpenFrmAuditor').modal('hide');
                          location.reload();
                      });
                   }
                 }
          });
      });

$(".check_box").on('click', function () {
      /*    var check_unid = "";
          var auditor_unid =$("#unid").val();

          $(":checkbox").each(function () {
              var ischecked = $(this).is(":checked");
              if (ischecked) {
                  check_unid += $(this).val() + ";";
              }
          });

          // your awesome code calling ajax
          var url ="{{route('auditor.member.addauditarea') }}";

            $.ajax({
              type: "POST",
              url: url,
              data: {auditor_unid:auditor_unid,check_unid:check_unid,"_token": "{{ csrf_token() }}"}, // serializes the form's elements.
              success: function(data)
              {
              //  console.log(data);
                  //alert(data); // show response from the php script.
              }
            });*/
          //
});

function addarea(auditor_area){
  var check_unid = "";
  var auditor_item =$("#auditor_item").val();
  var auditor_unid =$("#unid").val();
  var audit_position_unid =$("#audit_position_unid").val();
  var audit_position =$("#audit_position").val();
  var auditor_name =$("#auditor_name").val();

  $(":checkbox").each(function () {
        var ischecked = $(this).is(":checked");
        if (ischecked) {
            check_unid += $(this).val() + ";";
        }
  });

  //alert(auditor_name);
  // your awesome code calling ajax

var url ="{{route('auditor.member.addauditarea') }}";
$.ajax({
 type: "POST",
  url: url,
  data: {
    auditor_item:auditor_item,
    auditor_unid:auditor_unid,
    auditor_area : auditor_area,
    audit_position_unid:audit_position_unid,
    audit_position:audit_position,
    auditor_name:auditor_name,
    check_unid:check_unid,
    "_token": "{{ csrf_token() }}"}, // serializes the form's elements.
  success: function(data){
      //console.log(data);
      $("#unid").val(data.auditor_unid);

      }
    });
  //
}

$(".btn-close").on('click', function () {
  location.reload();
  });

</script>
@endsection
