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
                                <div class="ibox-title">ทีมตรวจ/Auditor</div>
                                <div>
                                    <a class="btn btn-info btn-sm btn-new" href="javascript:;"><i class="fa fa-plus"></i> เพิ่มทีมตรวจ</a>
                                </div>
                            </div>

                            <div class="ibox-body ">
                                <table class="table table-bordered">
                                    <thead class="">
                                        <tr>
                                            <th>#</th>
                                            <th>ชื่อทีมตรวจ</th>
                                            <th>ความถี่</th>
                                            <th>สมาชิก</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($dataAuditposition as $key => $row)
                                    <tr>
                                        <td>{{ $row->position_no }}</td>
                                        <td>{{ $row->position_name }}</td>
                                        <td>{{ $row->auditor_period }}</td>
                                        <td>
                                            <a href="/auditor/{{ $row->unid }}" class="btn btn btn-primary btn-xs m-r-5 btn-member" data-unid="{{ $row->unid }}" data-toggle="tooltip" data-original-title="Edit" ><i class="fa fa-users font-14"></i> รายชื่อ</button>
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
   <div class="modal fade" id="OpenFrmAuditor" name="OpenFrmAuditor" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered" role="document">
       <div class="modal-content">
         <div class="modal-header bg-primary ">
           <h5 class="modal-title text-white" id="exampleModalLongTitle">ข้อมูลพื้นที่การตรวจ</h5>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
         <div class="modal-body ">
           <form id="FrmAuditor" name="FrmAuditor" action="{{ route('auditor.add')}}" method="post" enctype="multipart/form-data">
             @csrf
              <input  type="hidden" id="unid" name="unid" value="">

              <div class="row">
                        <div class="col-sm-2 form-group">
                            <label>ลำดับ</label>
                            <input class="form-control" type="number" id="position_no" min="1" max="20" name="position_no" placeholder="ลำดับ" value="{{ count($dataAuditposition)+1}}" required>
                        </div>
                        <div class="col-sm-5 form-group">
                            <label>ชื่อทีมตรวจ</label>
                             <input class="form-control" type="text" id="position_name" name="position_name" placeholder="ชื่อทีมตรวจ" required>
                        </div>
                        <div class="col-sm-5 form-group">
                            <label>ประเภท</label>

                             <select class="form-control input-sm" id="position_name_eng" name="position_name_eng" required>
                                 <option value=""></option>
                                 <option value="SELF">Self Audit</option>
                                 <option value="COMMIT">Committee Audit</option>
                                 <option value="TOP">Top Audit</option>
                             </select>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 form-group">
                          <label >ความถี่</label>
                          <input class="form-control" type="text" id="auditor_period" name="auditor_period" placeholder="ความถี่" required >
                            </div>
                        <div class="col-sm-3 form-group">
                            <label>จำนวน 1 ครั้งต่อ</label>
                             <input class="form-control" type="number" max="10" min="1" id="period_qty" name="period_qty" placeholder="จำนวน" required>
                        </div>
                        <div class="col-sm-3 form-group">
                            <label >Month/Week</label>
                              <select class="form-control input-sm" id="period_type" name="period_type" required>
                                  <option value=""></option>
                                  <option value="WEEK">Week</option>
                                  <option value="MONTH">Month</option>
                              </select>
                        </div>
                    </div>

               <div class="form-group">

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

    var url = "{{ route('auditor.delete')}}";
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
 var url = "{{ route('auditor.get')}}";

 $("#FrmAuditor").attr('action', "{{ route('auditor.edit')}}");
 $.ajax({
           type: "get",
           url: url,
           data: {unid:unid}, // serializes the form's elements.
           success: function(data)
           {
             console.log(data);
           var res= data.data;
             $("#unid").val(res.unid);
             $("#position_no").val(res.position_no);
             $("#position_name").val(res.position_name);
             $("#position_name_eng").val(res.position_name_eng);
             $("#auditor_period").val(res.auditor_period);
             $("#period_qty").val(res.period_qty);
              $("#period_type").val(res.period_type);
             if(res){
               $('#OpenFrmAuditor').modal('show');
             }
           }
         });
   });


   $(".btn-new").on('click',function (e){
      $('#OpenFrmAuditor').modal('show');
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
</script>
@endsection
