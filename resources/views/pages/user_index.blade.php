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
                                <div class="ibox-title">รายชื่อผู้ใช้งาน</div>
                                <div>
                                    <a class="btn btn-info btn-sm btn-new" href="javascript:;"><i class="fa fa-plus"></i> เพิ่มผู้ใช้งาน</a>
                                </div>
                            </div>

                            <div class="ibox-body ">
                                <table class="table table-bordered">
                                    <thead class="">
                                        <tr>
                                            <th>#</th>
                                            <th>User Login</th>
                                            <th>ชื่อผู้ใช้งาน</th>
                                            <th width="120px">เปลี่ยนรหัส</th>
                                            <th width="120px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($User as $key => $row)
                                    <tr>
                                        <td>{{ $key=$key+1 }}</td>
                                        <td>{{ $row->user_login }}</td>
                                        <td>{{ $row->user_name }}</td>
                                        <td class="text-center">
                                          <button class="btn btn btn-primary btn-xs m-r-5 btn-pwd" data-unid="{{ $row->unid }}" data-toggle="tooltip" data-original-title="Edit" ><i class="fas fa-key font-14"></i></button>
                                        </td>
                                        <td class="text-center">
                                          <button class="btn btn btn-primary btn-xs m-r-5 btn-edit" data-unid="{{ $row->unid }}" data-toggle="tooltip" data-original-title="Edit" ><i class="fas fa-pencil-alt font-14"></i></button>
                                          <button class="btn btn-danger btn-xs btn-delete" data-unid="{{ $row->unid }}" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash font-14"></i></button>
                                      </td>
                                    </tr>
                                     @endforeach


                                    </tbody>
                                </table>

                                @if($search)
												{{ $dataset->links('pagination.default',compact('search'),['paginator' => $dataset,'link_limit' => $dataset->perPage()]) }}
										 @else
												{{ $dataset->links('pagination.default',['paginator' => $dataset,'link_limit' => $dataset->perPage()]) }}
								 @endif
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
           <h5 class="modal-title text-white" id="exampleModalLongTitle">ข้อมูลผู้ใช้งาน</h5>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>
         <div class="modal-body ">
           <form id="FrmArea" name="FrmArea" action="{{ route('user.add')}}" method="post" enctype="multipart/form-data">
             @csrf
              <input  type="hidden" id="unid" name="unid" value="">

              <div class="row">

                        <div class="col-sm-4 form-group" id="login">
                            <label>User Login</label>
                             <input class="form-control" type="text" id="user_login" name="user_login" placeholder="User Login" required required autocomplete="off">
                        </div>


               <div class="col-sm-4 form-group" id="uname">
                   <label >ชื่อผู้ใช้งาน</label>
                   <input class="form-control" type="text" id="user_name" name="user_name" placeholder="ชื่อผู้ใช้งาน" required autocomplete="off">
               </div>
               <div class="col-sm-4 form-group" id="pwd">
                   <label >รหัสผ่าน</label>
                   <input class="form-control" type="password" id="user_password" name="user_password" placeholder="รหัสผ่าน" required required autocomplete="off">
               </div>
                 </div>
<!--
               <div class="form-group">
                   <button class="btn btn-primary " type="submit">Submit</button>
               </div> -->
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
    var url = "{{ route('user.delete')}}";
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
 var url = "{{ route('user.get')}}";
 $("#FrmArea").attr('action', "{{ route('user.edit')}}");
 $.ajax({
           type: "get",
           url: url,
           data: {unid:unid}, // serializes the form's elements.
           success: function(data){
             var res= data.data;
               $("#unid").val(res.unid);
               $("#user_login").val(res.user_login);
               $("#user_name").val(res.user_name);
               $("#pwd").hide();
               if(res){
                 $("#login").show();
                 $("#uname").show();
                  $('#user_name').prop("readonly", false);
                 $('#OpenFrmArea').modal('show');
               }
           }
         });
   });


   $(".btn-pwd").on('click',function (e){

      $("#pwd").show();
      $("#login").hide();
      $("#uname").show();
      var unid =$(this).data('unid');
     var url = "{{ route('user.get')}}";
      $("#FrmArea").attr('action', "{{ route('user.pwd')}}");
      $.ajax({
                type: "get",
                url: url,
                data: {unid:unid}, // serializes the form's elements.
                success: function(data){
                   //console.log(data);
                    var res= data.data;
                    $("#unid").val(res.unid);

                    $("#user_login").val(res.user_login);
                    $("#user_name").val(res.user_name);
                    $('#user_name').prop("readonly", true);
                    $("#pwd").attr('');
                    if(res){

                      $("#pwd").show();
                      $('#OpenFrmArea').modal('show');
                    }
                }
            });

  });

  $(".btn-new").on('click',function (e){
     $("#pwd").show();
     $("#login").show();
     $("#uname").show();
     $('#user_name').prop("readonly", false);
     $('#OpenFrmArea').modal('show');
 });

  $(".btn-secondary").on('click',function (e){
          location.reload();
   });

   $(".close").on('click',function (e){
           location.reload();
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
