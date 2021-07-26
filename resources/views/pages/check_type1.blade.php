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
                   <div class="ibox-title">{{ $QuestionsResult[0]->ques_header }}</div>
                   <div>
                       <a class="btn btn-warning btn-sm " href="/check/get/{{ Cookie::get('DOC_PV').'/'.Cookie::get('DOC_YEAR').'/'.Cookie::get('DOC_MONTH') }}"><i class="fa fa-backward"></i> กลับ</a>

                   </div>
               </div>

                  <div class="ibox-body ">
                      <div class="row">
                          <div class="col-sm-6 form-group">
                              <label>พื้นที่</label>
                              <input class="form-control" type="text" value="{{ $QuestionsResult[0]->area_name }} " readonly>
                          </div>
                          <div class="col-sm-6 form-group">
                              <label>หัวหน้าพื้นที่</label>
                                <input class="form-control" type="text" value="{{ $QuestionsResult[0]->area_owner }} " readonly>
                          </div>
                      </div>
                  </div>
              </div>
           </div>
         </div>
           <div class="row">
             <div class="col-xl-12">
                        <div class="ibox ibox-primary">
                            <div class="ibox-body" id="check-data">
                              {!! $html !!}
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
 // $(".btn-next").on('click',function (e){
 //   alert('dsfsdfs') ;
 //
 //   var url    = "{{ route('result.getnext') }}";
 //   var ans    = $(this).data('ans');
 //   var next   = $(this).data('next');
 //
 //     $.ajax({
 //             type: "POST",
 //             url: url,
 //             data:{ans:ans,next:next,"_token": "{{ csrf_token() }}"},
 //             success: function(data)
 //             {
 //              console.log(data);
 //               if(data){
 //                   $("#check-data").html(data.html);
 //               }
 //             }
 //     });
 //
 //
 //   });



  function getResult(ans,next) {

      var url    = "{{ route('result.getnext') }}";
           $.ajax({
                type: "POST",
                url: url,
                data:{ans:ans,next:next,"_token": "{{ csrf_token() }}"},
                success: function(data)
                {
                 // console.log(data);
                  if(data.result){
                      $("#check-data").html(data.html);
                  }
                }
        });
   }

function saveResult(unid,score){
var url="{{ route('result.scoresave')}}";
  $.ajax({
            type: "POST",
            url: url,
            data:{unid:unid,score:score,"_token": "{{ csrf_token() }}"},
            success: function(data)
            {
            //  console.log(data);
            }
    });

}


 function saveResultrange(unid) {
   var score= $("#check_box").val();
   var url="{{ route('result.scoresave')}}";
     $.ajax({
               type: "POST",
               url: url,
               data:{unid:unid,score:score,"_token": "{{ csrf_token() }}"},
               success: function(data)
               {
               //  console.log(data);
               }
       });
 }

function SaveComment(unid){

var url="{{ route('result.commentsave')}}";
var comment = $('#audit_comment').val();

  $.ajax({
            type: "POST",
            url: url,
            data:{unid:unid,comment:comment,"_token": "{{ csrf_token() }}"},
            success: function(data)
            {
              //console.log(data);
            }
    });

}

function final(ans) {
  var unid = $('#unid').val();
  var url    = "{{ route('result.final') }}";
         $.ajax({
              type: "POST",
              url: url,
              data:{ans:ans,"_token": "{{ csrf_token() }}"},
              success: function(data)
              {
                console.log(data);
                if(data.result){

                        Swal.fire({
                             icon: 'success',
                             title: 'ส่งคะแนน',
                             text: data.data,
                             timer: 1300
                           }).then((result) => {

                             location.href = "{{ route('check.index')}}";
                           })

                 } else {

                         Swal.fire({
                              icon: 'error',
                              title: 'กรุณาให้คะแนน',
                              html: data.data,

                            })
                 }
              }
      });
 }


</script>
@endsection
