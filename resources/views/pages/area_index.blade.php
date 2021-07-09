@extends('pages.page_stley')

@section('title')
{{ config('app.name') }}
@endsection

@extends('pages.page_sidemenu')
<!-- @include('pages.page_sidemenu') -->

@section('content-wrapper')
<div class="content-wrapper">

       <div class="page-content fade-in-up">
           <div class="row">
               <div class="col">
                   <div class="ibox ibox-primary">
                       <div class="ibox-head ">
                           <div class="ibox-title">กำหนดพื้นที่การตรวจ</div>
                           <div class="ibox-tools">

                           </div>
                       </div>
                       <div class="ibox-body">
                           <form id="FrmArea" name="FrmArea" action="{{ route('area.add')}}" method="post" enctype="multipart/form-data">
                             @csrf
                              <input  type="hidden" id="unid" name="unid" value="">
                              <div class="row">
                                <div class="col-2">
                                  <div class="form-group">
                                      <label>ลำดับ</label>
                                      <input class="form-control" type="number" id="area_index" min="1" max="20" name="area_index" placeholder="ลำดับ" value="{{ count($dataArea)+1}}" required>
                                  </div>
                                </div>

                              </div>


                               <div class="form-group">
                                   <label>ชื่อพื้นที่</label>
                                   <input class="form-control" type="text" id="area_name" name="area_name" placeholder="ชื่อพื้นที่" required>
                               </div>
                               <div class="form-group">
                                   <label>หัวหน้าพื้นที่</label>
                                   <input class="form-control" type="text" id="area_owner" name="area_owner" placeholder="หัวหน้าพื้นที่" required >
                               </div>

                               <div class="form-group">
                                   <button class="btn btn-primary " type="submit">Submit</button>
                               </div>
                           </form>
                       </div>
                   </div>
               </div>

           </div>

           <div class="row">
             <div class="col-xl-12">
                        <div class="ibox ibox-primary">
                            <div class="ibox-head">
                                <div class="ibox-title">ตารางพื้นที่การตรวจ</div>
                            </div>
                            <div class="ibox-body ">
                                <table class="table table-bordered">
                                    <thead class="">
                                        <tr>
                                            <th>#</th>
                                            <th>พื้นที่</th>
                                            <th>หัวหน้าพื้นที่</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($dataArea as $key => $row)
                                    <tr>
                                        <td>{{ $row->area_index }}</td>
                                        <td>{{ $row->area_name }}</td>
                                        <td>{{ $row->area_owner }}</td>
                                        <td>
                                          <button class="btn btn-default btn-xs m-r-5" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil font-14"></i></button>
                                          <button class="btn btn-default btn-xs" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash font-14"></i></button>
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

@endsection

@section('jsfooter')
    <!-- <script src="./assets/js/scripts/dashboard_1_demo.js" type="text/javascript"></script> -->
@endsection
