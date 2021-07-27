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
                                <div class="ibox-title">ตารางพื้นที่การตรวจ </div>
                                <div>
                                    <a class="btn btn-warning btn-sm " href="/check/yearmonth?pv={{ $pv }}"><i class="fa fa-backward"></i> กลับ</a>

                                </div>
                            </div>

                            <div class="ibox-body ">
                              @if(Session::has('error'))
                                    <div class="alert alert-danger">
                                      {{ Session::get('error') }}

                                  </div>
                                  @endif
                                <table class="table table-bordered">
                                    <thead class="">
                                        <tr>
                                            <th>วันที่</th>
                                            <th >พื้นที่</th>
                                               @if($pv !='SELF')
                                                <th  class="text-center">กลุ่ม</th>
                                                @endif
                                            <th class="text-center">หัวหน้าพื้นที่</th>
                                            <th class="text-center">คะแนนเต็ม</th>
                                            <th class="text-center">คะแนนที่ได้</th>

                                            <th>Action</th>
                                            <th>ลบผลตรวจ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($dtPlan as $key => $row)
                                    <tr>
                                        <td class="text-center"> {{ date("d", strtotime($row->plan_date)) }}</td>
                                         <td>{{ $row->plan_area_name }}</td>

                                         @if($pv !='SELF')
                                       <td  class="text-center"> <button class="btn btn-primary btn-circle"> {{ $row->plan_groups }}</button> </td>
                                          @endif
                                        <td><i class="fa fa-star text-danger"></i> {{ $row->plan_area_owner }}</td>
                                        <td class="text-center h4 m-0">
                                          <button class="btn btn-info btn-rounded">  {{ $row->total_score > 0 ?  $row->total_score : '0' }}</button>
                                        </td>
                                        <td class="text-center h4 m-0">
                                          <button class="btn btn-success  btn-rounded">{{ $row->area_score > 0 ?  $row->area_score : '0' }}</button>
                                        </td>
                                      <td>
                                        @if($row->doc_status !='Y')
                                          <form name="testForm" id="testForm" action="{{route('check.checked')}}" method="POST"  enctype="multipart/form-data" >
                                            @csrf
                                              <input type="hidden" id="area_unid" name="area_unid" value="{{ $row->plan_area_unid }}">
                                              <input type="hidden" id="plan_unid" name="plan_unid" value="{{ $row->unid }}">

                                          <button type=submit class="btn btn btn-primary   m-r-5  " style="cursor: pointer;" data-unid="{{ $row->unid }}" data-toggle="tooltip" data-original-title="ตรวจประเมินพื้นที่" >

                                          <i class="fas fa-balance-scale font-14 btn-check"></i> ตรวจประเมินพื้นที่ </button>
                                          </form>
                                        @else
                                          <form name="testForm" id="testForm" action="{{route('check.checked')}}" method="POST"  enctype="multipart/form-data" >
                                            @csrf
                                              <input type="hidden" id="area_unid" name="area_unid" value="{{ $row->plan_area_unid }}">
                                              <input type="hidden" id="plan_unid" name="plan_unid" value="{{ $row->unid }}">

                                          <button type=submit class="btn btn btn-warning   m-r-5  " style="cursor: pointer;" data-unid="{{ $row->unid }}" data-toggle="tooltip" data-original-title="คะแนนตรวจประเมิน" >

                                            <i class="fas fa-thumbs-up"></i> คะแนนตรวจประเมิน</button>
                                          </form>
                                        @endif


                                    </td>
                                    <td>

                                      @if($row->area_score > 0)
                                            <button type=submit class="btn btn btn-danger   m-r-5 btn-delete "
                                            style="cursor: pointer;" data-unid="{{ $row->unid }}" data-toggle="tooltip" data-original-title="ลบผลตรวจ" >
                                           <i class="fas fa-trash-alt"></i> ลบผลตรวจ</button>
                                      @else
                                            <button type=submit class="btn btn btn-default    m-r-5 btn-delete " disabled >
                                            <i class="fas fa-trash-alt"></i> ลบผลตรวจ</button>
                                      @endif

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
           <form id="FrmArea" name="FrmArea" action="{{ route('area.add')}}" method="post" enctype="multipart/form-data">
             @csrf
              <input  type="hidden" id="unid" name="unid" value="">

              <div class="row">
                        <div class="col-sm-2 form-group">
                            <label>ลำดับ</label>
                            <input class="form-control" type="number" id="area_index" min="1" max="20" name="area_index" placeholder="ลำดับ" value="{{ count($dtPlan)+1}}" required>
                        </div>
                        <div class="col-sm-10 form-group">
                            <label>ชื่อพื้นที่</label>
                             <input class="form-control" type="text" id="area_name" name="area_name" placeholder="ชื่อพื้นที่" required>
                        </div>
                    </div>

               <div class="form-group">
                   <label >หัวหน้าพื้นที่</label>
                   <input class="form-control" type="text" id="area_owner" name="area_owner" placeholder="หัวหน้าพื้นที่" required >
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
    var url = "{{ route('result.delete')}}";

        Swal.fire({
            title: 'คุณต้องการลบผลการตรวจประเมิน?',
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
</script>
@endsection
