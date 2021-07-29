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
                               <div class="ibox-title">เปลี่ยนรหัสผ่าน</div>

                           </div>
                           <div class="ibox-body">
                             @if(Session::has('error'))
                              <div class="alert alert-danger">
                                {{ Session::get('error') }}
                             
                            </div>
                            @endif
                               <form class="form-horizontal" id="frmuser" name="frmuser" action="{{ route('user.changepwd') }}" method="post">
                                 @csrf
                                 <input class="form-control" type="hidden" id="unid" name="unid" value="{{ $User->unid }}" >
                                   <div class="form-group row">
                                       <label class="col-sm-2 col-form-label">User Name</label>
                                       <div class="col-sm-10">
                                           <input class="form-control" type="text" id="user_login" name="user_login" value="{{ $User->user_login }}"
                                            readonly required>
                                       </div>
                                   </div>
                                   <div class="form-group row">
                                       <label class="col-sm-2 col-form-label">รหัสผ่านใหม่ <br/>(อย่างน้อย 6 ตัวอักษร)</label>
                                       <div class="col-sm-10">
                                         <input class="form-control" type="password" id="new_password" name="new_password" value=""
                                         placeholder="รหัสผ่านใหม่ " required  minlength="6" >
                                       </div>
                                   </div>


                                   <div class="form-group row">
                                       <div class="col-sm-10 ml-sm-auto">
                                           <button class="btn btn-info" type="submit">บันทึก</button>
                                       </div>
                                   </div>
                               </form>
                           </div>
                       </div>
              </div>

           </div>

       </div>
       <!-- END PAGE CONTENT-->
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
