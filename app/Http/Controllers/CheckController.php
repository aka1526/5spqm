<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Cookie;
use Session;
use Illuminate\Support\Str;
use App\Models\AreaTbl;
use App\Models\AuditorTbl;
use App\Models\AuditAreaTbl;
use App\Models\AuditpositionTbl;
//use App\Models\PositionsTbl;
use App\Models\PlanPositionTbl;
use App\Models\QuestionsAreaTbl;
use App\Models\QuestionspositionTbl;
use App\Models\QuestionsItemTbl;
use App\Models\QuestionsTbl;
use App\Models\QuestionsResultTbl;
use App\Models\SummaryResultTbl;
use App\Models\UserTbl;
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

    // Cookie::queue('USER_UNID',$row->unid);
    // Cookie::queue('USER_ID',$row->user_login );
    // Cookie::queue('USER_NAME',$row->user_name);
    // Cookie::queue('USER_LEVEL',$row->user_level);
    //
    //dd(Session::get('USER_UNID'));
    $USER_UNID =Cookie::get('USER_UNID') !='' ? Cookie::get('USER_UNID')  : ''  ;
    if($USER_UNID==''){
        return view('pages.user_login');
    }
 //  dd(Session::get('USER_UNID'));
  //  $position =AuditorTbl::where('auditor_unid','=', $USER_UNID)->orderBy('auditor_group')->get();

    $position = AuditorTbl::select('tbl_auditor.*','tbl_auditposition.position_name_eng','position_eng')
                        ->leftJoin("tbl_auditposition", "tbl_auditposition.unid", "=", "tbl_auditor.audit_position_unid")
                        ->where('tbl_auditor.auditor_unid','=', $USER_UNID)
                        ->orderBy('tbl_auditposition.position_no')
                        ->get();


    return view('pages.check_index',compact('position'));
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

        $html  .=  ' <div class="col-sm-4 col-md-3 col-6 p-0 m-0 ">
                    <div class="alert bg-white ">
                        <form id="m'.$monthNum.'" action="" method="post" >
                        <button type="button" class="btn btn-success btn-block btn-month color-'.$monthNum.'" data-month="'.$monthNum.'"  data-pv="'.$pv .'" target="_blank"><h4>'.$monthNum.'. '.  $monthName.'</h4></button>
                        </form >
                     </div>
                 </div>';
     } else {
       $html  .=  ' <div class="col-sm-4 col-md-3 col-md-3 col-6 p-0 m-0">
                   <div class="alert bg-white ">

                       <button type="button" class="btn  btn-block  color-none disabled" data-month="'.$monthNum.'"  data-pv="'.$pv .'" target="_blank"><h4>'.$monthNum.'. '.  $monthName.'</h4></button>

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

      $year = Cookie::get('DOC_YEAR') !='' ? Cookie::get('DOC_YEAR') : $year;
      $pv   =  Cookie::get('DOC_PV') !=''   ? strtoupper(Cookie::get('DOC_PV')) :strtoupper($pv) ;
      $area_unid = Cookie::get('DOC_YEAR') !='' ? Cookie::get('DOC_YEAR') : $year;


      $position_type =$pv;
       Cookie::queue('DOC_MONTH',$moth);

       $USER_UNID =Cookie::get('USER_UNID') !='' ? Cookie::get('USER_UNID') : '';
       if($USER_UNID !=''){
          $AuditArea =  AuditAreaTbl::where('auditor_unid','=',$USER_UNID)
          ->where('status','=','Y')->orderBy('area_index')->get();
       }

       $plan_area_unid=array();
       $auditor_group='';
       foreach ($AuditArea as $key => $row) {
              $plan_area_unid[] = $row->area_unid;
               $auditor_group= $row->auditor_group;


       }


      $dtPlan =PlanPositionTbl::select('tbl_planposition.*','doc_status','area_score','total_score')
      ->leftJoin("tbl_result_summary", "tbl_result_summary.plan_unid", "=", "tbl_planposition.unid")
      ->where('tbl_planposition.position_type','=',$position_type)
      ->where(function($query) use ($plan_area_unid) {
                        if ($plan_area_unid != '') {
                            return $query->whereIn('tbl_planposition.plan_area_unid', $plan_area_unid);
                        }
                    })
    //  ->dd()

    //  ->wherein('tbl_planposition.plan_area_unid','in','('.$plan_area_unid.')') //web line 3
    //  ->where('plan_area_unid','=','b30a86eb99e04624966c295c5ede35fb') // Test

      ->where('tbl_planposition.plan_year','=',$year)
      ->where('tbl_planposition.plan_month','=',$moth)
      ->where('tbl_planposition.plan_groups','=',$auditor_group)
      ->orderBy('tbl_planposition.plan_date')
      ->orderBy('tbl_planposition.plan_area_index')->get();
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
  //  dd($request);
    $year   = Cookie::get('DOC_YEAR')   !='' ? Cookie::get('DOC_YEAR') : '';
    $month  = Cookie::get('DOC_MONTH')  !='' ? Cookie::get('DOC_MONTH') : '';
    $pv     =  Cookie::get('DOC_PV')        !=''  ? strtoupper(Cookie::get('DOC_PV')) : '' ;

    $area_unid =isset($request->area_unid) ? $request->area_unid :'';
    $plan_unid =isset($request->plan_unid) ? $request->plan_unid :'';

    $PlanStatus = SummaryResultTbl::where('plan_unid','=',$plan_unid)->where('doc_status','=','Y')->count();
    $datatype= $PlanStatus > 0 ? 1 : 2;
    $username='5s';
    Cookie::queue('AREA_UNID',$request->area_unid);

   $Questions = QuestionsTbl::select('tbl_questions.*')
                      ->leftJoin("tbl_questions_position", "tbl_questions_position.ques_unid", "=", "tbl_questions.unid")
                      ->leftJoin("tbl_questions_area", "tbl_questions_area.ques_unid", "=", "tbl_questions.unid")
                      ->where('tbl_questions_position.position_type','=',$pv)
                      ->where('tbl_questions_area.area_unid','=',$area_unid)
                      ->first();

 if($Questions ){
     $ques_unid =$Questions->unid;
   }else {
   return back()->with('error','ไม่พบแบบประเมินพื้นที่');
 }


  $QuestionsItem = QuestionsItemTbl::where('item_refunid','=',$ques_unid)->orderBy('item_index')->get();

  $CountResult=  QuestionsResultTbl::where('ques_unid','=',$ques_unid)
            ->where('positions_type','=',$pv)
            ->where('area_unid','=',$area_unid)->count();

$Questions = QuestionsTbl::where('unid','=',$ques_unid)->first();

$Positions =AuditpositionTbl::where('position_name_eng','=',$pv)->first();
$Area =AreaTbl::where('unid','=',$area_unid)->first();
$Plan= PlanPositionTbl::where('unid','=',$plan_unid)->first();

  if($CountResult==0){

      $rowTotal=0;
      $unid_ans =$this->genUnid();
      foreach ($QuestionsItem as $key => $item) {
        $rowTotal++;
            QuestionsResultTbl::insert([
              'unid' =>  $this->genUnid()
              ,'plan_unid' => $Plan->unid
              ,'plan_date' => $Plan->plan_date
              ,'plan_year' => $Plan->plan_year
              ,'plan_month' => $Plan->plan_month
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
        ,'plan_unid' => $Plan->unid
        ,'plan_date' => $Plan->plan_date
        ,'plan_year' => $Plan->plan_year
        ,'plan_month' => $Plan->plan_month
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
        ,'plan_unid' => $Plan->unid
        ,'plan_date' => $Plan->plan_date
        ,'plan_year' => $Plan->plan_year
        ,'plan_month' => $Plan->plan_month
        ,'ques_unid' => $Questions->unid
        ,'ques_rev' => $Questions->ques_rev
        ,'ques_header' => $Questions->ques_header
        ,'positions_type' => $pv
        ,'position_name' => $Positions->position_name
        ,'area_unid' => $Area->unid
        ,'area_name' =>$Area->area_name
        ,'area_owner' =>$Area->area_owner
        ,'result_index' => $rowTotal
        ,'result_toppic' => 'สิ่งที่ดี เป็นตัวอย่างได้'
        ,'result_desc' => ""
        ,'result_val' => 0
        ,'status'=>"Y"
        ,'result_type' => "TEXT"
        ,'create_by'=> $username
        ,'create_time'=> Carbon::now()
        ,'edit_by'=> $username
        ,'edit_time'=>Carbon::now()
        ,'unid_ans' => $unid_ans
      ]);


    $countItem = QuestionsResultTbl::where('unid_ans','=',$unid_ans)->where('result_type','=','VALUE')->count();
    SummaryResultTbl::insert([
      'unid' => $this->genUnid()
      ,'plan_date' => Carbon::now()->format('Y-m-d')
      ,'plan_unid' => $Plan->unid
      ,'plan_date' => $Plan->plan_date
      ,'plan_year' => $Plan->plan_year
      ,'plan_month' => $Plan->plan_month
      ,'doc_status' =>'N'
      ,'questions_unid' => $Questions->unid
      ,'questions_rev' => $Questions->ques_rev
      ,'questions_header' => $Questions->ques_header
      ,'total_item' => $countItem
      ,'total_score' => ($countItem*5)
      ,'area_score' => 0
      ,'audit_date' =>  Carbon::now()
      ,'area_unid' => $Area->unid
      ,'area_name' => $Area->area_name
      ,'area_owner' => $Area->area_owner
      ,'auditor_unid' => $username
      ,'auditor_name' => $username
      ,'auditor_position' => $pv
      ,'position_name' => $Positions->position_name
      ,'create_by' =>$username
      ,'create_time' => Carbon::now()
      ,'edit_by' =>$username
      ,'edit_time' => Carbon::now()
      ,'ans_unid' => $unid_ans
      ]);
}

  $QuestionsResult=  QuestionsResultTbl::where('ques_unid','=',$ques_unid)
            ->where('positions_type','=',$pv)
            ->where('area_unid','=',$area_unid)->orderBy('result_index')->get();
  $html ='';
  $result_toppic_befor='';
  $result_toppic_next='';


// $agent->isDesktop();
// $agent->isMobile();
// $agent->isTablet();
//
//

  if($datatype==1){


  $html .='
  <div class="row">
  <div class="col-xl-12">
  <table class="table table-bordered">

      <tbody>
  ';
  $totalscroe=0;
  foreach ($QuestionsResult as $key => $row) {
    if($row->result_type=='VALUE'){
      $totalscroe=$totalscroe +$row->result_val;
        if($result_toppic_next != $row->result_toppic){
          $result_toppic_next = $row->result_toppic;
          $result_toppic_befor= $row->result_toppic;
        } else {
          $result_toppic_befor='';
        }

        if($result_toppic_befor!='') {
          $html .='<tr class="btn-info">
                 <td colspan="2"><strong> หัวข้อตรวจ :: '.$result_toppic_befor.'</strong></td>
                 <td class="text-center" width="120px">ระดับคะแนน</td>

             </tr>';
        }
            $html .='<tr>

                   <td class="text-center"><strong>'.$row->result_index.'</strong></td>
                   <td>'.$row->result_desc.'</td>

                   <td class="text-center" data-toggle="tooltip" data-original-title="ระดับคะแนน">
                     <div>
                        <span class="h4 m-0">  '.$row->result_val.'</span>
                     </div>
                   </td>
               </tr>';

           } else {

             $html .='<tr class="btn-warning"><td colspan="6"><strong> '.$row->result_toppic.'</strong></td></tr>';

             $html .=' <tr>
                         <td colspan="5">
                              <textarea class="form-control"  data-unid="'.$row->unid.'" rows="3" placeholder="'.$row->result_toppic.'" disabled >'.$row->audit_comment.'</textarea>

                          </td>
                      </tr> ';
           }
         }

         $html .='<tr class="btn-danger "><td class="text-center"  colspan="2"><strong> รวมคะแนน </strong></td>
                 <td class="text-center" >
                   <div>
                      <span class="h4 m-0">  '.$totalscroe.'</span>
                   </div>
                 </td>
                 </tr>';

         $html .='  </tbody>
                 </table>
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
          $RowBack=  0;
          $RowCurrent= $row->result_index ;
          $RowNext= ($row->result_index)+1 < $TotalRow ? ($row->result_index)+1 : $TotalRow  ;
          $audit_check = $row->audit_check;
          $result_val  = $row->result_val;

          if($key==0){

          $html .='
            <div class="row">
              <div class="col-md-12">
                <div class="ibox">
                    <div class="ibox-head">
                        <div class="ibox-title">หัวข้อตรวจ : '.$row->result_toppic.'</div>

                    </div>
                    <div class="ibox-body">
                        <div class="row">
                          <div class="col-md-8">
                             <p> <strong> ข้อที่ '.$row->result_index.'. </strong> '.$row->result_desc.' </p>
                          </div>
                          <div class="col-md-4">
                          <div class="form-group">
                                    <label class="h4 m-0 text-danger mb-3 ">คะแนนตรวจประเมิน</label>';
                                  if($audit_check=='Y'){
                                    $html .='  <div >
                                          <label class="ui-radio ui-radio-danger mr-2" data-toggle="tooltip" data-original-title="0 คะแนน">
                                              <input type="radio" name="check_box" value="0" onclick="saveResult(\''.$row->unid.'\',\'0\')" '. ( $result_val ==0 ? 'checked' : '' ).' >
                                              <span class="input-span"></span>แก้ไข (0)</label>
                                          <label class="ui-radio ui-radio-warning mr-2" data-toggle="tooltip" data-original-title="3 คะแนน">
                                              <input type="radio" name="check_box" value="3" onclick="saveResult(\''.$row->unid.'\',\'3\')" '. ( $result_val ==3 ? 'checked' : '' ).' >
                                              <span class="input-span"></span>พอใช้ (3)</label>
                                          <label class="ui-radio ui-radio-success mt-2" data-toggle="tooltip" data-original-title="5 คะแนน">
                                              <input type="radio" name="check_box" value="5" onclick="saveResult(\''.$row->unid.'\',\'5\')" '. ( $result_val ==5 ? 'checked' : '' ).' >
                                              <span class="input-span"></span>ดีเยี่ยม (5)</label>
                                      </div>';
                                  } else {
                                    $html .='  <div >
                                          <label class="ui-radio ui-radio-danger mr-2" data-toggle="tooltip" data-original-title="0 คะแนน">
                                              <input type="radio" name="check_box" value="0" onclick="saveResult(\''.$row->unid.'\',\'0\')" >
                                              <span class="input-span"></span>แก้ไข (0)</label>
                                          <label class="ui-radio ui-radio-warning mr-2" data-toggle="tooltip" data-original-title="3 คะแนน">
                                              <input type="radio" name="check_box" value="3" onclick="saveResult(\''.$row->unid.'\',\'3\')" >
                                              <span class="input-span"></span>พอใช้ (3)</label>
                                          <label class="ui-radio ui-radio-success mt-2" data-toggle="tooltip" data-original-title="5 คะแนน">
                                              <input type="radio" name="check_box" value="5" onclick="saveResult(\''.$row->unid.'\',\'5\')" >
                                              <span class="input-span"></span>ดีเยี่ยม (5)</label>
                                      </div>';
                                  }

                  $html .='  </div>
                          </div>
                        </div>
                    </div>
                </div>
              </div>
          </div>
          <div class="container">
              <div class="row">
                <div class="col-md text-center">
                  <button class="btn btn-warning btn-back '.($RowCurrent <=1 ? 'disabled' : '') .'" > <i class="fa fa-step-backward"></i>กลับ</button>
                    <button class="btn btn-info" >'.$row->result_index.' / '.count($QuestionsResult).'  </button>
                  <button class="btn btn-primary btn-next" onclick="getResult(\''.$row->unid_ans.'\',\''.$RowNext.'\')"> ถัดไป <i class="fa fa-step-forward"></i></button>
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
