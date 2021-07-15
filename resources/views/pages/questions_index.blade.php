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

         @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

           <div class="row">
             <div class="col-xl-12">
                        <div class="ibox ibox-primary">

                            <div class="ibox-head">
                                <div class="ibox-title">แบบฟอร์มการตรวจพื้นที่ระบบ 5ส</div>
                                <div>
                                    <a class="btn btn-info btn-sm btn-new" href="javascript:;"><i class="fa fa-plus"></i> เพิ่มฟอร์ม</a>
                                </div>
                            </div>

                            <div class="ibox-body ">
                                <table class="table table-bordered">
                                    <thead class="">
                                        <tr>
                                            <th>#</th>
                                            <th>ชื่อแบบฟอร์ม</th>
                                            <th>ผู้ตรวจ</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($dataQuestions as $key => $row)
                                    <tr>
                                        <td>{{ $row->ques_index }}</td>
                                        <td>{{ $row->ques_header }}</td>
                                         <td>{{ $row->create_time }}</td>
                                        <td>
                                          <button class="btn btn btn-primary btn-xs m-r-5 btn-edit" data-unid="{{ $row->unid }}" data-toggle="tooltip" data-original-title="Edit" ><i class="fa fa-pencil font-14"></i></button>
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
   <div class="modal fade" id="OpenFrmArea" name="OpenFrmArea" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
       <div class="modal-content">
         <div class="modal-header bg-primary ">
           <h5 class="modal-title text-white" id="exampleModalLongTitle">ข้อมูลพื้นที่การตรวจ</h5>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
         <div class="modal-body ">
           <form id="FrmQuestions" name="FrmQuestions" action="{{ route('questions.add')}}" method="post" enctype="multipart/form-data">
             @csrf
              <input  type="hidden" id="unid" name="unid" value="">

              <div class="row">
                        <div class="col-sm-2 form-group">
                            <label>ลำดับ</label>
                            <input class="form-control" type="number" id="ques_index" min="1" max="20" name="ques_index" placeholder="ลำดับ" value="{{ count($dataQuestions)+1}}" required>
                        </div>
                        <!-- <div class="col-sm-2 form-group">
                            <label>Rev.</label>
                            <input class="form-control" type="text" id="ques_rev" min="1" max="20" name="ques_rev" placeholder="ลำดับ" value="00">
                        </div> -->
                        <div class="col-sm-8 form-group">
                            <label>ชื่อแบบฟอร์ม</label>
                             <input class="form-control" type="text" id="ques_header" name="ques_header" placeholder="ชื่อแบบฟอร์ม" required>
                        </div>
                    </div>

                    <div class="row">
                      <div class="col-md">
                        <div class="form-group">
                              <h4> ผู้ตรวจประเมินพื้นที่</h4>
                              <div class="m-b-10">
                                  <label class="ui-checkbox ui-checkbox-inline ui-checkbox-success">
                                      <input type="checkbox" id="position_type" name="position_type[]" value="SELF">
                                      <span class="input-span"></span>หัวหน้าพื้นที่</label>
                                  <label class="ui-checkbox ui-checkbox-inline ui-checkbox-success">
                                      <input type="checkbox" id="commit" name="position_type[]" value="COMMIT">
                                      <span class="input-span"></span>คณะกรรมการ</label>
                                  <label class="ui-checkbox ui-checkbox-inline ui-checkbox-success">
                                      <input type="checkbox" id="top" name="position_type[]"  value="TOP">
                                      <span class="input-span"></span>ผู้บริหาร</label>
                              </div>

                          </div>
                      </div>


                    </div>
                    <div class="row" id="areas" ></div>

               <div class="form-group">
                  <button type="button" class="btn btn-secondary " data-dismiss="modal">Close</button>
                   <button class="btn btn-primary " name="btn-save" id="btn-save"  type="submit">บันทึก</button>
               </div>
           </form>

         </div>
         <!-- <div class="modal-footer">
           <button type="button" class="btn btn-secondary " data-dismiss="modal">Close</button>
           <button type="button" class="btn btn-primary btn-save" name="btn-save" id="btn-save" >Save</button>
         </div> -->
       </div>
     </div>
   </div>

@endsection

@section('jsfooter')
    <!-- <script src="./assets/js/scripts/dashboard_1_demo.js" type="text/javascript"></script> -->
<script>

$(".btn-delete").on('click',function (e){

    var unid =$(this).data('unid');
    var url = "{{ route('area.delete')}}";
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
                                title: 'คุณต้องการลบข้อมูล?',
                                icon: 'success',
                                timer : 1200,
                              }).then(() => {
                                   location.reload();
                              });
                            } else {
                              Swal.fire({
                                title: 'คุณต้องการลบข้อมูล?',
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
 var url = "{{ route('area.get')}}";
 $("#FrmArea").attr('action', "{{ route('area.edit')}}");
 $.ajax({
           type: "get",
           url: url,
           data: {unid:unid}, // serializes the form's elements.
           success: function(data)
           {
           var res= data.data;
             $("#unid").val(res.unid);
             $("#area_index").val(res.area_index);
             $("#area_name").val(res.area_name);
             $("#area_owner").val(res.area_owner);
             if(res){
               $('#OpenFrmArea').modal('show');
             }
           }
         });
   });


   $(".btn-new").on('click',function (e){

    var url ="{{route('questions.get')}}";
    var unid ="";
     $.ajax({
               type: "get",
               url: url,
               data: {unid:unid,"_token": "{{ csrf_token() }}"},
               success: function(data)
               {
                   var res= data.result;
                   console.log(data.area);
                       $("#areas").html(data.area);
                     // $("#area_index").val(res.area_index);
                     // $("#area_name").val(res.area_name);
                     // $("#area_owner").val(res.area_owner);
                     if(res){
                       $('#OpenFrmArea').modal('show');
                     }
               }
             });


  });

   $(".btn-save2").on('click',function (e){
          e.preventDefault();
          var form = $("#FrmArea");
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
                         $('#OpenFrmArea').modal('hide');
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
</script>
@endsection
