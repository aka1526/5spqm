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
                                            <th>หัวข้อการตรวจ</th>
                                            <th>พื้นที่</th>
                                            <th>ผู้ตรวจประเมิน</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($dataQuestions as $key => $row)
                                    <tr>
                                        <td>{{ $row->ques_index }}</td>
                                        <td>{{ $row->ques_header }}</td>
                                          <td>
                                            <a href="/questions/edit/{{ $row->unid }}" class="btn btn btn-danger btn-xs m-r-5 " data-unid="{{ $row->unid }}" data-toggle="tooltip" data-original-title="เพิ่มหัวข้อการตรวจ" ><i class="fa fa-plus font-14"></i> หัวข้อ</a>
                                          </td>
                                            <td>
                                            @if(isset($dataQuestionsArea))
                                              @foreach ($dataQuestionsArea as $key => $area)
                                                @if($area->ques_unid == $row->unid  )
                                                          {{ '- '.$area->area_name }}</br>
                                                @endif
                                              @endforeach
                                            @else
                                              -
                                            @endif
                                          </td>
                                         <td>
                                           @if(isset($dataQuestionsposition))
                                             @foreach ($dataQuestionsposition as $key => $p)
                                             @if($p->ques_unid == $row->unid  )


                                               @foreach ($dataAuditposition as $key => $item)
                                                  @if($p->position_type == $item->position_name_eng )
                                                    - {{ $item->position_name }}<br/>
                                                  @endif
                                               @endforeach

                                             @endif

                                             @endforeach
                                           @else
                                             -
                                           @endif
                                         </td>
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
   <div class="modal fade" id="OpenFrmArea" name="OpenFrmArea" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
       <div class="modal-content">
         <div class="modal-header bg-primary ">
           <h5 class="modal-title text-white" id="exampleModalLongTitle">แบบฟอร์มการตรวจพื้นที่ระบบ 5ส</h5>
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

                    <div class="row" id="position">

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
    var url = "{{ route('questions.delete')}}";
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
                                title: 'ลบข้อมูลสำเร็จ?',
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

 var url = "{{ route('questions.get')}}";
 $("#FrmQuestions").attr('action', "{{ route('questions.edit')}}");
 $.ajax({
           type: "get",
           url: url,
           data: {unid:unid}, // serializes the form's elements.
           success: function(data)
           {
             var res= data.result;
              if(res){
                $("#unid").val(data.data.unid);
                $("#ques_index").val(data.data.ques_index);
                $("#ques_header").val(data.data.ques_header);

                $("#position").html(data.position);
                $("#areas").html(data.area);

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
                    if(res){
                        $("#unid").val('');
                        $("#ques_index").val('{{ count($dataQuestions)+1 }}')
                        $("#ques_header").val('');
                        $("#position").html(data.position);
                        $("#areas").html(data.area);
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


</script>
@endsection
