<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Cookie;
use Illuminate\Support\Str;
use App\Models\AreaTbl;
use App\Models\PositionsTbl;
use App\Models\PlanPositionTbl;
use App\Models\QuestionsAreaTbl;
use App\Models\QuestionspositionTbl;
use App\Models\QuestionsItemTbl;
use App\Models\QuestionsTbl;
use App\Models\QuestionsResultTbl;
use Jenssegers\Agent\Agent;

class CheckController extends Controller
{

  protected  $paging =10;

  public function genUnid(){
    $uuid = (string) Str::uuid();
    $uuid = str_replace("-","",$uuid);
    return $uuid;
}

  public function index(Request $request){
   $dataArea =AreaTbl::where('status','=','Y')->orderBy('area_index')->get();
    return view('pages.check_index',compact('dataArea'));
  }

  public function yearmonth(Request $request){
    //dd($request);
    $pv =isset($request->pv) ? $request->pv : '';
    $docyear =isset($request->docyear) ? $request->docyear : date('Y');
  //  $unid= isset($request->unid) ? $request->unid :'';
  //  $dataArea =AreaTbl::where('unid','=',$unid)->first();
  //  return response()->json(['result'=> 'success','data'=> $dataArea],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
    Cookie::queue('DOC_YEAR',$docyear);
    Cookie::queue('DOC_PV',$pv);
    $html ='';
    for ($monthNum = 1; $monthNum <= 12; $monthNum++) {
      $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));

     if($this->getMonthPlan($docyear,$monthNum,$pv)) {

        $html  .=  ' <div class="col-sm-3">
                    <div class="alert bg-white ">
                        <form id="m'.$monthNum.'" action="" method="post" >
                        <button type="button" class="btn btn-success btn-block btn-month color-'.$monthNum.'" data-month="'.$monthNum.'"  data-pv="'.$pv .'" target="_blank"><h2>'.$monthNum.'. '.  $monthName.'</h2></button>
                        </form >
                     </div>
                 </div>';
     } else {
       $html  .=  ' <div class="col-sm-3">
                   <div class="alert bg-white ">

                       <button type="button" class="btn  btn-block  color-none disabled" data-month="'.$monthNum.'"  data-pv="'.$pv .'" target="_blank"><h2>'.$monthNum.'. '.  $monthName.'</h2></button>

                    </div>
                </div>';
     }

  }




  return view('pages.check_yearmonth',compact('html','pv'));
  }

  public function getMonthPlan($plan_year=null,$plan_month=null,$pv='')    {
      $PlanCount =PlanPositionTbl::where('plan_year','=',$plan_year)
      ->where('plan_month', '=',$plan_month)
      ->where('position_type','=',$pv)
      ->orderBy('plan_month')->count();

      $stat =  $PlanCount > 0 ? true : false ;
      return $stat;
    }

  public function get(Request $request,$pv=null,$year=null,$moth=null){
      $unid= isset($request->unid) ? $request->unid :'';
      $dataArea =AreaTbl::where('unid','!=',$unid)->get();

      $year= Cookie::get('DOC_YEAR') !='' ? Cookie::get('DOC_YEAR') : $year;
      $pv =  Cookie::get('DOC_PV') !=''   ? strtoupper(Cookie::get('DOC_PV')) :strtoupper($pv) ;


      $position_type =$pv;
       Cookie::queue('DOC_MONTH',$moth);
      $dtPlan =PlanPositionTbl::where('position_type','=',$position_type)
      ->where('plan_area_unid','=','319bf8c4dad7499ca5552fd3ab52f6c1') //web line 3
    //  ->where('plan_area_unid','=','b30a86eb99e04624966c295c5ede35fb') // Test

      ->where('plan_year','=',$year)->where('plan_month','=',$moth)->orderBy('plan_date')->orderBy('plan_area_index')->get();
    // return response()->json(['result'=> 'success','data'=> $dataArea],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
   return view('pages.check_plan',compact('dtPlan','pv'));
  }
  public function add(Request $request){
    $unid       =isset($request->unid) ? $request->unid:'';

    $area_index   = isset($request->area_index) ? $request->area_index : '0';
    $area_name    = isset($request->area_name) ? $request->area_name : '';
    $area_owner   = isset($request->area_owner) ? $request->area_owner : '';
    $username='5s';
    $action= false;
    if($unid =='') {
        $uuid = $this->genUnid();
    $action=  AreaTbl::insert([
        'unid'=> $uuid ,
        'area_index'=> $area_index,
        'area_name'=> $area_name,
        'area_owner'=> $area_owner,
        'status'=> 'Y',
        'create_by' => $username,
        'create_time' => carbon::now(),
        'edit_by' => $username,
        'edit_time' => Carbon::now(),
      ]);
    }
  //  return back();

   return response()->json(['result'=> $action],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);

  }

  public function edit(Request $request){
    $unid       =isset($request->unid) ? $request->unid:'';
    $area_index   = isset($request->area_index) ? $request->area_index : '0';
    $area_name    = isset($request->area_name) ? $request->area_name : '';
    $area_owner   = isset($request->area_owner) ? $request->area_owner : '';
    $username='5s';
    $action=false;
    if($unid !='') {

        $action =AreaTbl::where('unid', '=', $unid)->update([
        'area_index'=> $area_index,
        'area_name'=> $area_name,
        'area_owner'=> $area_owner,
        'edit_by'=> $username,
        'edit_time'=> date("Y-m-d H:i:s"),
      ]);

    }

 return response()->json(['result'=>$action],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);

  }

  public function delete(Request $request){
    $unid =isset($request->unid) ? $request->unid : '';
    $action=false;
    if($unid !='') {

        $action =AreaTbl::where('unid', '=', $unid)->delete();
    }

 return response()->json(['result'=>$action],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);

  }
  public function editfield(Request $request){

  }

  public function checked(Request $request){
    $year   = Cookie::get('DOC_YEAR')   !='' ? Cookie::get('DOC_YEAR') : '';
    $month  = Cookie::get('DOC_MONTH')  !='' ? Cookie::get('DOC_MONTH') : '';
    $pv     =  Cookie::get('DOC_PV')        !=''  ? strtoupper(Cookie::get('DOC_PV')) : '' ;
    $area_unid =isset($request->area_unid) ? $request->area_unid :'';
    $datatype  =isset($request->datatype) ? $request->datatype : 1;
    $username='5s';
    Cookie::queue('AREA_UNID',$request->area_unid);

   $Questions = QuestionsTbl::select('tbl_questions.*')
                      ->leftJoin("tbl_questions_position", "tbl_questions_position.ques_unid", "=", "tbl_questions.unid")
                      ->leftJoin("tbl_questions_area", "tbl_questions_area.ques_unid", "=", "tbl_questions.unid")
                      ->where('tbl_questions_position.position_type','=',$pv)
                      ->where('tbl_questions_area.area_unid','=',$area_unid)
                      ->first();
 $ques_unid =$Questions->unid;
  $QuestionsItem = QuestionsItemTbl::where('item_refunid','=',$ques_unid)->orderBy('item_index')->get();

  $CountResult=  QuestionsResultTbl::where('ques_unid','=',$ques_unid)
            ->where('positions_type','=',$pv)
            ->where('area_unid','=',$area_unid)->count();
  if($CountResult==0){
      $Questions = QuestionsTbl::where('unid','=',$ques_unid)->first();
      $Positions =PositionsTbl::where('positions_type','=',$pv)->first();
      $Area =AreaTbl::where('unid','=',$area_unid)->first();
      $rowTotal=0;
      $unid_ans =$this->genUnid();
      foreach ($QuestionsItem as $key => $item) {
        $rowTotal++;
            QuestionsResultTbl::insert([
              'unid' =>  $this->genUnid()
              ,'ques_unid' => $Questions->unid
              ,'ques_rev' => $Questions->ques_rev
              ,'ques_header' => $Questions->ques_header
              ,'positions_type' => $pv
              ,'position_name' => $Positions->position_name
              ,'area_unid' =>$Area->unid
              ,'area_name' =>$Area->area_name
              ,'area_owner' =>$Area->area_owner
              ,'result_index' =>$item->item_index
              ,'result_toppic' =>$item->item_toppic
              ,'result_desc' =>$item->item_desc
              ,'result_val' => 0
              ,'status'=>"Y"
              ,'result_type' => "VALUE"
              ,'create_by'=> $username
              ,'create_time'=>Carbon::now()
              ,'edit_by'=> $username
              ,'edit_time'=>Carbon::now()
              ,'unid_ans' => $unid_ans
            ]);
      }

      ///
      $rowTotal =$rowTotal+1;
      QuestionsResultTbl::insert([
        'unid' =>  $this->genUnid()
        ,'ques_unid' => $Questions->unid
        ,'ques_rev' => $Questions->ques_rev
        ,'ques_header' => $Questions->ques_header
        ,'positions_type' => $pv
        ,'position_name' => $Positions->position_name
        ,'area_unid' =>$Area->unid
        ,'area_name' =>$Area->area_name
        ,'area_owner' =>$Area->area_owner
        ,'result_index' => $rowTotal
        ,'result_toppic' => 'สิ่งที่ควรปรับปรุง'
        ,'result_desc' => ""
        ,'result_val' => 0
        ,'status'=>"Y"
          ,'result_type' => "TEXT"
        ,'create_by'=> $username
        ,'create_time'=>Carbon::now()
        ,'edit_by'=> $username
        ,'edit_time'=>Carbon::now()
          ,'unid_ans' => $unid_ans
      ]);

      $rowTotal =$rowTotal+1;
      QuestionsResultTbl::insert([
        'unid' =>  $this->genUnid()
        ,'ques_unid' => $Questions->unid
        ,'ques_rev' => $Questions->ques_rev
        ,'ques_header' => $Questions->ques_header
        ,'positions_type' => $pv
        ,'position_name' => $Positions->position_name
        ,'area_unid' =>$Area->unid
        ,'area_name' =>$Area->area_name
        ,'area_owner' =>$Area->area_owner
        ,'result_index' => $rowTotal
        ,'result_toppic' => 'สิ่งที่ดี เป็นตัวอย่างได้'
        ,'result_desc' => ""
        ,'result_val' => 0
        ,'status'=>"Y"
        ,'result_type' => "TEXT"
        ,'create_by'=> $username
        ,'create_time'=>Carbon::now()
        ,'edit_by'=> $username
        ,'edit_time'=>Carbon::now()
        ,'unid_ans' => $unid_ans
      ]);

  }

  $QuestionsResult=  QuestionsResultTbl::where('ques_unid','=',$ques_unid)
            ->where('positions_type','=',$pv)
            ->where('area_unid','=',$area_unid)->orderBy('result_index')->get();
  $html ='';
  $result_toppic_befor='';
  $result_toppic_next='';
 $agent = new Agent();

// $agent->isDesktop();
// $agent->isMobile();
// $agent->isTablet();
//
//$datatype =$agent->isDesktop() ? 1 : 2 ;

  if($datatype==1){

  $html .='
  <div class="row">
  <div class="col-xl-12">
  <table class="table table-bordered">
      <thead class="">
          <tr>

              <th>หัวข้อตรวจ</th>
              <th>ลำดับ</th>
              <th>รายละเอียดการตรวจ</th>
              <th class="text-center" width="80px">แก้ไข</th>
              <th class="text-center" width="80px">พอใช้</th>
              <th class="text-center" width="80px">ดีเยี่ยม</th>
          </tr>
      </thead>
      <tbody>
  ';
  foreach ($QuestionsResult as $key => $row) {
    if($row->result_type=='VALUE'){
        if($result_toppic_next != $row->result_toppic){
          $result_toppic_next = $row->result_toppic;
          $result_toppic_befor= $row->result_toppic;
        } else {
          $result_toppic_befor='';
        }

      $html .='<tr>
                   <td><strong>'.$result_toppic_befor.'</strong></td>
                   <td class="text-center">'.$row->result_index.'</td>
                   <td>'.$row->result_desc.'</td>

                   <td class="text-center">
                     <label class="ui-radio ui-radio-success">
                      <input type="radio" id="check_'.$row->unid.'" name="check_'.$row->unid.'">
                      <span class="input-span"></span>
                       </label>
                   </td>
                   <td class="text-center">
                     <label class="ui-radio ui-radio-success">
                      <input type="radio" id="check_'.$row->unid.'" name="check_'.$row->unid.'">
                      <span class="input-span"></span>
                       </label>
                   </td>
                   <td class="text-center">
                     <label class="ui-radio ui-radio-success">
                      <input type="radio" id="check_'.$row->unid.'" name="check_'.$row->unid.'">
                      <span class="input-span"></span>
                       </label>
                   </td>
               </tr>';
           } else {
            $html .=' <tr>
                         <td colspan="6">
                            <div class="form-group">
                              <label><h5 class="m-t-20 m-b-20">'.$row->result_toppic.'</h5> </label>
                              <textarea class="form-control"  data-unid="'.$row->unid.'" rows="3" placeholder="'.$row->result_toppic.'"></textarea>
                             </div>
                          </td>
                      </tr> ';
           }
         }

         $html .='  </tbody>
                 </table>
               </div>
               </div>

               <div class="row">
                 <div  class="col-md-6">
                   <div class="form-group row">
                               <div class="col-sm-10 ml-sm-auto">
                                   <button class="btn btn-info" type="submit">ส่งคะแนน</button>
                               </div>
                           </div>
                 </div>
               </div>
               ';
             }

if($datatype==2){
        $html .=' ';
        $TotalRow = count($QuestionsResult);
        $RowBack= 0;
        $RowCurrent=0 ;
        $RowNext=0  ;

        foreach ($QuestionsResult as $key => $row) {
          $RowBack= ($row->result_index)-1 > 0 ? $row->result_index-1 : 0;
          $RowCurrent= $row->result_index ;
          $RowNext= ($row->result_index)+1 < $TotalRow ? ($row->result_index)+1 : $TotalRow  ;
          if($key==0){


            // result_type
          $html .='
        <div class="row">
          <div class="col-md-12">
            <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">'.$row->result_toppic.'</div>
                        <div>
                            <a class="btn btn-info btn-sm btn-new" href="javascript:;"> รายการที่ '.$row->result_index.' / '.count($QuestionsResult).' </a>
                        </div>
                    </div>
                    <div class="ibox-body">
                        <div class="row">
                          <div class="col-md-8">
                             <p> <strong> ข้อที่ '.$row->result_index.') </strong> '.$row->result_desc.' </p>
                          </div>
                          <div class="col-md-4">
                          <div class="form-group">
                                    <label>คะแนนตรวจประเมิน</label>

                                    <div>
                                        <label class="ui-radio ui-radio-success">
                                            <input type="radio" name="test">
                                            <span class="input-span"></span>แก้ไข</label>
                                        <label class="ui-radio ui-radio-success">
                                            <input type="radio" name="test">
                                            <span class="input-span"></span>พอใช้</label>
                                        <label class="ui-radio ui-radio-success">
                                            <input type="radio" name="test">
                                            <span class="input-span"></span>ดีเยี่ยม</label>
                                    </div>
                                </div>
                          </div>
                        </div>
                    </div>
                </div>
              </div>
          </div>
          <div class="container">
              <div class="row">
                <div class="col-md text-center">
                  <button class="btn btn-warning btn-back"  data-ans="'.$row->unid_ans.'" data-current="'. $RowCurrent .'" data-back="'.$RowBack.'"> <i class="fa fa-step-backward"></i>กลับ</button>
                  <button class="btn btn-primary btn-next"  data-ans="'.$row->unid_ans.'" data-current="'. $RowCurrent .'" data-next="'.$RowNext.'"> ถัดไป <i class="fa fa-step-forward"></i></button>
                </div>

              </div>
            </div>
            <p/>
          ';
        }
          if($TotalRow == ($RowCurrent-1)){
            $html .='<div class="row">
                        <div  class="col-md-6">
                          <div class="form-group row">
                                      <div class="col-sm-10 ml-sm-auto">
                                          <button class="btn btn-info" type="submit">ส่งคะแนน '.$RowCurrent.$TotalRow.'</button>
                                      </div>
                                  </div>
                        </div>
                      </div>';
          }
        }
      }




    return view('pages.check_type1',compact('Questions','QuestionsResult','html')) ;
  }


}
