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
                                <div class="ibox-title">{{ $dtQuestions->ques_header }}</div>
                                <div class="ibox-tools">

                                         <a class="  btn btn-warning btn-sm " href="/questions"><i class="fa fa-backward"></i> กลับ</a>
                                           <!-- <a class="btn btn-info btn-sm btn-new" href="javascript:;"><i class="fa fa-plus"></i> แผน</a> -->
                                   <button type="submit" class="btn btn-info btn-sm btn-newitem"><i class="fa fa-plus-square"></i> เพิ่มหัวข้อ</button>

                                   </div>
                            </div>

                            <div class="ibox-body ">
                                <table class="table table-bordered">
                                    <thead class="">
                                        <tr>
                                            <th>หัวข้อการตรวจ</th>
                                            <th class="text-center">ลำดับ</th>
                                            <th>รายละเอีดยการตรวจ</th>
                                            <th>สร้างเมื่อ</th>
                                            <th width="80px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($dtQuestionsItem as $key => $row)
                                    <tr>

                                        <td>{{ $row->item_toppic }}</td>
                                        <td class="text-center">{{ $row->item_index }}</td>
                                        <td>{{ $row->item_desc }}</td>
                                        <td>{{ $row->create_time }}</td>

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
           <h5 class="modal-title text-white" id="exampleModalLongTitle"> <i class="fa fa-list-ol"></i> {{ $dtQuestions->ques_header }}</h5>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
         <div class="modal-body ">
           <form id="FrmArea" name="FrmArea" action="{{ route('questions.additem')}}" method="post" enctype="multipart/form-data">
             @csrf
              <input  type="hidden" id="unid" name="unid" value="">
              <input  type="hidden" id="item_refunid" name="item_refunid" value="{{ $dtQuestions->unid }}">
              <div class="row">
                        <div class="col-sm-2 form-group">
                            <label>ลำดับ</label>
                            <input class="form-control" type="number" id="item_index" name="item_index" min="1" max="20"  placeholder="ลำดับ" value="{{ count($dtQuestionsItem)+1}}" required>
                        </div>
                        <div class="col-sm-10 form-group">
                            <label>หัวข้อการตรวจ</label>
                             <input class="form-control" type="text" id="item_toppic" name="item_toppic"value="" placeholder="หัวข้อการตรวจ" required>
                        </div>
                    </div>

               <div class="form-group">
                   <label >รายละเอีดยการตรวจ</label>
                   <textarea id="item_desc" name="item_desc" class="form-control" rows="5" style="margin-top: 0px; margin-bottom: 0px; height: 100px;"></textarea>
               </div>

           </form>
         </div>
         <div class="modal-footer">
           <button type="button" class="btn btn-secondary " data-dismiss="modal">Close</button>
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
    var url = "{{ route('questions.deleteitem')}}";
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

 var url = "{{ route('questions.getitem')}}";
 $("#FrmArea").attr('action', "{{ route('questions.edititem')}}");
 $.ajax({
           type: "get",
           url: url,
           data: {unid:unid}, // serializes the form's elements.
           success: function(data)
           {
            // console.log(data);
           var res= data.data;
              $("#unid").val(res.unid);
              $("#item_refunid").val(res.item_refunid);
              $("#item_index").val(res.item_index);
              $("#item_toppic").val(res.item_toppic);
              $("#item_desc").html(res.item_desc);
             if(res){
               $('#OpenFrmArea').modal('show');
           }
           }
         });
   });


   $(".btn-newitem").on('click',function (e){
      $("#unid").val('');
      $("#item_index").val("{{ count($dtQuestionsItem)+1 }}");
      $("#item_toppic").val("{{ Cookie::get('item_toppic') }}");
      $("#item_desc").html('');
      $('#OpenFrmArea').modal('show');
  });

   $(".btn-save").on('click',function (e){
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
