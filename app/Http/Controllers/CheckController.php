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
use App\Models\Positions;

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
     //dd($request,$pv,$year,$moth);
      $unid= isset($request->unid) ? $request->unid :'';
      $dataArea =AreaTbl::where('unid','!=',$unid)->get();

      $year = Cookie::get('DOC_YEAR') !='' ? Cookie::get('DOC_YEAR') : $year;
      $pv   =  Cookie::get('DOC_PV') !=''   ? strtoupper(Cookie::get('DOC_PV')) :strtoupper($pv) ;
      $area_unid = Cookie::get('DOC_YEAR') !='' ? Cookie::get('DOC_YEAR') : $year;

      $user_unid = Cookie::get('USER_UNID') !='' ? Cookie::get('USER_UNID') : '';



      $position_type =$pv;
       Cookie::queue('DOC_MONTH',$moth);
       $AUDITOR_UNID =Cookie::get('USER_UNID') !='' ? Cookie::get('USER_UNID') : '';

       if($AUDITOR_UNID !=''){
          $AuditArea =  AuditAreaTbl::where('auditor_unid','=',$AUDITOR_UNID)
          ->where('status','=','Y')->orderBy('area_index')->get();
       }

       $plan_area_unid=array();
       $auditor_group='';
       foreach ($AuditArea as $key => $row) {
              $plan_area_unid[] = $row->area_unid;
               $auditor_group= $row->auditor_group;

       }
    //   dd($auditor_group);
  //  dd($position_type);
      $dtPlan =PlanPositionTbl::where('position_type','=',$position_type)
         ->where(function($query) use ($plan_area_unid) {
                        if ($plan_area_unid != '') {
                            return $query->whereIn('plan_area_unid', $plan_area_unid);
                        }
                    })

      ->where('plan_year','=',$year)
      ->where('plan_month','=',$moth)
      //->where('plan_groups','=',$auditor_group)
      ->where(function($query) use ($auditor_group,$position_type ) {
                     if ($position_type != 'SELF' && $auditor_group !='') {
                         return $query->where('plan_groups', $auditor_group);
                     }
                 })

      ->orderBy('plan_date')->orderBy('plan_area_index')->get();

      $dtSummaryResult =SummaryResultTbl::where('plan_year','=',$year)
      ->where('plan_month','=',$moth)
      ->where('auditor_unid','=',$AUDITOR_UNID)
      ->get();

    // return response()->json(['result'=> 'success','data'=> $dataArea],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
   return view('pages.check_plan',compact('dtPlan','dtSummaryResult','pv'));
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
    $AUDIT_UNID =Cookie::get('USER_UNID') !='' ? Cookie::get('USER_UNID')  : ''  ;
    $AUDIT_NAME =Cookie::get('USER_NAME') !='' ? Cookie::get('USER_NAME')  : ''  ;

    $PlanStatus = SummaryResultTbl::where('plan_unid','=',$plan_unid)
    ->where('auditor_unid', '=',$AUDIT_UNID)
    ->where('doc_status','=','Y')->count();
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
$Questions = QuestionsTbl::where('unid','=',$ques_unid)->first();
$Positions =AuditpositionTbl::where('position_name_eng','=',$pv)->first();
$Area =AreaTbl::where('unid','=',$area_unid)->first();
$Plan= PlanPositionTbl::where('unid','=',$plan_unid)->first();

$CountResult=  QuestionsResultTbl::where('plan_unid','=',$Plan->unid)
          ->where('positions_type','=',$pv)
          ->where('auditor_unid','=',$AUDIT_UNID)
          ->where('area_unid','=',$area_unid)->count();
//dd($CountResult);
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
              ,'auditor_unid' =>$AUDIT_UNID
              ,'auditor_name' =>$AUDIT_NAME
              ,'status'=>"Y"
              ,'result_type' =>  $item->item_type
              ,'create_by'=> $username
              ,'create_time'=>Carbon::now()
              ,'edit_by'=> $username
              ,'edit_time'=>Carbon::now()
              ,'unid_ans' => $unid_ans

            ]);
      }

      $Totalitem=0;
      $Totalscore=0;
      $Score = QuestionsResultTbl::where('plan_unid','=',$Plan->unid)->where('result_type','!=','TEXT')->get();
      foreach ($Score as $key => $val) {
        $Totalitem = $Totalitem+1;
      }

      if($pv=='COMMIT'){
          $Totalscore= (int)$Totalitem*5;
      }elseif($pv=='SELF'){
          $Totalscore= (int)$Totalitem*5;
      }elseif($pv=='TOP'){
            $Totalscore= (int)$Totalitem*10;
      }

      //dd($pv,$Totalscore);

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
      ,'total_item' => $Totalitem
      ,'total_score' =>  $Totalscore
      ,'area_score' => 0
      ,'audit_date' =>  Carbon::now()
      ,'area_unid' => $Area->unid
      ,'area_name' => $Area->area_name
      ,'area_owner' => $Area->area_owner
      ,'auditor_unid' =>$AUDIT_UNID
      ,'auditor_name' =>$AUDIT_NAME
      ,'auditor_position' => $pv
      ,'position_name' => $Positions->position_name
      ,'create_by' =>$username
      ,'create_time' => Carbon::now()
      ,'edit_by' =>$username
      ,'edit_time' => Carbon::now()
      ,'ans_unid' => $unid_ans

      ]);
}

  $QuestionsResult=  QuestionsResultTbl::where('plan_unid','=',$Plan->unid)
            ->where('positions_type','=',$pv)
              ->where('auditor_unid','=',$AUDIT_UNID)
            ->where('area_unid','=',$area_unid)
            ->orderBy('result_index')->get();
  $html ='';
  $result_toppic_befor='';
  $result_toppic_next='';


  if($datatype==1){ // ส่งคะแนนทำแบบประเมินแล้ว


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
      }elseif($row->result_type=='RANGE'){

        if($totalscroe ==0) {
          $html .='<tr class="btn-info">
                 <td width="20px"><strong> ลำดับ</strong></td>
                 <td ><strong> หัวข้อตรวจประเมิน</strong></td>
                 <td class="text-center" width="120px">ระดับคะแนน</td>

             </tr>';
        }

        $totalscroe=$totalscroe +$row->result_val;
          if($result_toppic_next != $row->result_toppic){
            $result_toppic_next = $row->result_toppic;
            $result_toppic_befor= $row->result_toppic;
          } else {
            $result_toppic_befor='';
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

             $html .='<tr class="btn-warning"><td colspan="6"><strong> '.$row->result_toppic.'</strong></td></tr>';

             $html .=' <tr>
                         <td colspan="5">
                              <textarea class="form-control"  data-unid="'.$row->unid.'" rows="3" placeholder="'.$row->result_toppic.'" disabled >'.trim($row->audit_comment).'</textarea>

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
        //dd( $TotalRow );
        foreach ($QuestionsResult as $key => $row) {
          $RowBack=  0;
          $RowCurrent= $row->result_index ;
          $RowNext= ($row->result_index)+1 < $TotalRow ? ($row->result_index)+1 : $TotalRow  ;
          $audit_check = $row->audit_check;
          $result_val  = $row->result_val;
          $result_type = $row->result_type;

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
                             <p> '.$row->result_desc.' </p>
                          </div>
                          <div class="col-md-4">
                          <div class="form-group">
                                    <label class="h4 m-0 text-danger mb-3 ">คะแนนตรวจประเมิน</label>';
                                    if($result_type=="VALUE"){

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
                                    }

                                        if($result_type=="RANGE"){
                                              if($audit_check=='Y'){
                                                $html .='  <div >
                                                <div class="form-group">
                                                         <label></label>
                                                         <select class="form-control" id="check_box" name="check_box" >
                                                             <option value="">--คะแนน--</option>
                                                             <option value="0" '. ( $result_val ==0 ? 'selected' : '' ).'>0 คะแนน</option>
                                                             <option value="1" '. ( $result_val ==1 ? 'selected' : '' ).'>1 คะแนน</option>
                                                             <option value="2" '. ( $result_val ==2 ? 'selected' : '' ).'>2 คะแนน</option>
                                                             <option value="3" '. ( $result_val ==3 ? 'selected' : '' ).'>3 คะแนน</option>
                                                             <option value="4" '. ( $result_val ==4 ? 'selected' : '' ).'>4 คะแนน</option>
                                                             <option value="5" '. ( $result_val ==5 ? 'selected' : '' ).'>5 คะแนน</option>
                                                             <option value="6" '. ( $result_val ==6 ? 'selected' : '' ).'>6 คะแนน</option>
                                                             <option value="7" '. ( $result_val ==7 ? 'selected' : '' ).'>7 คะแนน</option>
                                                             <option value="8" '. ( $result_val ==8 ? 'selected' : '' ).'>8 คะแนน</option>
                                                             <option value="9" '. ( $result_val ==9 ? 'selected' : '' ).'>9 คะแนน</option>
                                                             <option value="10" '. ( $result_val ==10 ? 'selected' : '' ).'>10 คะแนน</option>
                                                         </select>
                                                     </div>
                                                  </div>';
                                              } else {
                                                $html .='  <div >
                                                <div class="form-group">
                                                         <label></label>
                                                         <select class="form-control" onchange="saveResultrange(\''.$row->unid.'\')"  id="check_box" name="check_box" >
                                                             <option value="">--คะแนน--</option>
                                                             <option value="0" >0 คะแนน</option>
                                                             <option value="1">1 คะแนน</option>
                                                             <option value="2">2 คะแนน</option>
                                                             <option value="3">3 คะแนน</option>
                                                             <option value="4">4 คะแนน</option>
                                                             <option value="5">5 คะแนน</option>
                                                             <option value="6">6 คะแนน</option>
                                                             <option value="7">7 คะแนน</option>
                                                             <option value="8">8 คะแนน</option>
                                                             <option value="9">9 คะแนน</option>
                                                             <option value="10">10 คะแนน</option>
                                                         </select>
                                                     </div>
                                                  </div>';
                                              }

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
       // dd($key);
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

  public function score(Request $request){

    $year   = isset($request->year) ? $request->year :'';
    $month  =  isset($request->month) ? $request->month :'';

    $positions = Positions::where('status','=','Y')->orderBy('position_index')->get();

    $Areas =AreaTbl::where('status','=','Y')->orderBy('area_index')->get();

   /*
    $QuestionsResult=  QuestionsResultTbl::where('plan_unid','=',$Plan->unid)
    ->where('positions_type','=',$pv)
      ->where('auditor_unid','=',$AUDIT_UNID)
    ->where('area_unid','=',$area_unid)
    ->orderBy('result_index')->get();
*/
    $html='<table class="table table-bordered table-responsive">';

    foreach ($positions as $key => $position) {
        $positions_type =$position->positions_type;
        $position_name =$position->position_name;
        // "positions_type" => "SELF"
        // "position_name" => "หัวหน้าพื้นที่"
        $html .='
        <thead class="btn-info">
        <tr >
            <td colspan="8" class="text-center">'.$position_name .'</td>
            </tr>
        </thead>
            <tr>
                <th>วันที่ตามแผน</th>
                <th>พื้นที่</th>

                <th class="text-center ">หัวหน้าพื้นที่</th>
                <th class="text-center">ผุ้ตรวจ</th>
                <th class="text-center">คะแนนเต็ม</th>
                <th class="text-center">คะแนนที่ได้</th>
                <th class="text-center"> % ที่ได้</th>
                <th class="text-center">แบบประเมิน</th>

            </tr>
        ';

        // $QuestionsResult=  QuestionsResultTbl::where('plan_year','=',$year )
        // ->where('plan_month','=', $month)
        // ->where('positions_type','=',$positions_type)
        // //->where('auditor_unid','=',$AUDIT_UNID)
        // //->where('area_unid','=',$area_unid)
        // ->orderBy('area_name')
        // ->orderBy('result_index')
        // ->get();


        foreach ($Areas as $a => $area) {
            $area_unid  = $area->unid;
            $SummaryResultTbl =SummaryResultTbl::where('auditor_position','=',$positions_type)
            ->where('plan_year','=',$year )
            ->where('plan_month','=', $month)
            ->where('area_unid','=',$area_unid)
            ->orderBy('plan_date')
             ->get();
              foreach ($SummaryResultTbl as $p => $result) {
                    $unid = $result->unid;
                    $plan_unid = $result->plan_unid;
                    $AUDIT_UNID= $result->auditor_unid;
                    $score_percen=$result->area_score>0 ? ($result->area_score/$result->total_score)*100 : 0;

                    $html .='
                        <tr>
                            <td>'.$result->plan_date.'</td>
                            <td>'.$result->area_name.'</td>
                            <td>'.$result->area_owner.'</td>
                            <td>'.$result->auditor_name.'</td>
                            <td class="text-center">'.$result->total_score.'</td>
                            <td class="text-center">'.$result->area_score.'</td>
                            <td class="text-center">'.number_format( $score_percen,0).' %</td>
                            <td>


                                <form name="testForm" id="testForm" action="/check/scorechecked" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="'.csrf_token().'">

                                <input type="hidden" id="DOC_YEAR" name="DOC_YEAR" value="'.$year.'">
                                <input type="hidden" id="DOC_MONTH" name="DOC_MONTH" value="'.$month.'">
                                <input type="hidden" id="DOC_PV" name="DOC_PV" value="'.$positions_type.'">
                                <input type="hidden" id="AUDIT_UNID" name="AUDIT_UNID" value="'.$AUDIT_UNID.'">
                                <input type="hidden" id="area_unid" name="area_unid" value="'.$area_unid.'">
                                <input type="hidden" id="plan_unid" name="plan_unid" value="'.$plan_unid.'">

                                <button type="submit" class="btn btn btn-warning   btn-sm  m-r-5  " style="cursor: pointer;" data-unid="'.$unid.'" data-toggle="tooltip" data-original-title="คะแนนตรวจประเมิน">

                                <i class="fas fa-thumbs-up"></i> คะแนน</button>
                                </form>
                                </td>
                        </tr>
                    ';

                }
        }


    }

    $html .='</table>';
    return view('pages.check_score',compact('html')) ;
  }

  public function scorechecked(Request $request){
  // dd($request->all());

  $year =isset($request->DOC_YEAR) ? $request->DOC_YEAR :'';
  $month =isset($request->DOC_MONTH) ? $request->DOC_MONTH :'';
  $pv =isset($request->DOC_PV) ? $request->DOC_PV :'';
  $AUDIT_UNID   =isset($request->AUDIT_UNID) ? $request->AUDIT_UNID :'';
  $area_unid =isset($request->area_unid) ? $request->area_unid :'';
  $plan_unid =isset($request->plan_unid) ? $request->plan_unid :'';
 //$AUDIT_UNID =Cookie::get('USER_UNID') !='' ? Cookie::get('USER_UNID')  : ''  ;
 // $AUDIT_NAME =Cookie::get('USER_NAME') !='' ? Cookie::get('USER_NAME')  : ''  ;

//   $PlanStatus = SummaryResultTbl::where('plan_unid','=',$plan_unid)
//   ->where('auditor_unid', '=',$AUDIT_UNID)
//   ->where('doc_status','=','Y')->count();
//   $datatype= $PlanStatus > 0 ? 1 : 2;
$datatype=  1 ;

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
$Questions = QuestionsTbl::where('unid','=',$ques_unid)->first();
$Positions =AuditpositionTbl::where('position_name_eng','=',$pv)->first();
$Area =AreaTbl::where('unid','=',$area_unid)->first();
$Plan= PlanPositionTbl::where('unid','=',$plan_unid)->first();

$CountResult=  QuestionsResultTbl::where('plan_unid','=',$Plan->unid)
        ->where('positions_type','=',$pv)
        //->where('auditor_unid','=',$AUDIT_UNID)
        ->where('area_unid','=',$area_unid)->count();
//dd($CountResult.'dfdf');

$QuestionsResult=  QuestionsResultTbl::where('plan_unid','=',$Plan->unid)
          ->where('positions_type','=',$pv)
            //->where('auditor_unid','=',$AUDIT_UNID)
          ->where('area_unid','=',$area_unid)
          ->orderBy('result_index')->get();
$html ='';
$result_toppic_befor='';
$result_toppic_next='';


if($datatype==1){ // ส่งคะแนนทำแบบประเมินแล้ว


$html .='
<div class="row">
<div class="col-xl-12">
<table class="table table-bordered">

    <tbody>
';
$totalscroe=0;
foreach ($QuestionsResult as $key => $row) {
    $plan_date =$row->plan_date;
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
    }elseif($row->result_type=='RANGE'){

      if($totalscroe ==0) {
        $html .='<tr class="btn-info">
               <td width="20px"><strong> ลำดับ</strong></td>
               <td ><strong> หัวข้อตรวจประเมิน</strong></td>
               <td class="text-center" width="120px">ระดับคะแนน</td>

           </tr>';
      }

      $totalscroe=$totalscroe +$row->result_val;
        if($result_toppic_next != $row->result_toppic){
          $result_toppic_next = $row->result_toppic;
          $result_toppic_befor= $row->result_toppic;
        } else {
          $result_toppic_befor='';
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

           $html .='<tr class="btn-warning"><td colspan="6"><strong> '.$row->result_toppic.'</strong></td></tr>';

           $html .=' <tr>
                       <td colspan="5">
                            <textarea class="form-control"  data-unid="'.$row->unid.'" rows="3" placeholder="'.$row->result_toppic.'" disabled >'.trim($row->audit_comment).'</textarea>

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

return view('pages.check_type3',compact('Questions','QuestionsResult','html','year','month','plan_date')) ;
}



}
