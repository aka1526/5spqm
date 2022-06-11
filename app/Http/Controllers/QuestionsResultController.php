<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Cookie;
use DB;
use Illuminate\Support\Str;
use App\Models\AreaTbl;
use App\Models\QuestionsTbl;
use App\Models\QuestionspositionTbl;
use App\Models\QuestionsAreaTbl;
use App\Models\QuestionsItemTbl;
use App\Models\PositionsTbl;
use App\Models\QuestionsResultTbl;
use App\Models\SummaryResultTbl;

class QuestionsResultController extends Controller
{

  protected  $paging =10;

  public function genUnid(){
    $uuid = (string) Str::uuid();
   $uuid = str_replace("-","",$uuid);
    return $uuid;
  }

  public function getnext(Request $request){

         $ans   = isset($request->ans) ? $request->ans :'';
         $next  = isset($request->next) ? $request->next : 0;

         if($next==0){
            $html="";
             return response()->json(['result'=> false,'html'=> $html ],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
         }
         $QuestionsResult=  QuestionsResultTbl::where('unid_ans','=',$ans)
                ->orderBy('result_index')->get();

           $html ='';
           $TotalRow = count($QuestionsResult);
           $RowBack= 0;
           $RowCurrent=0 ;
           $RowNext=0  ;

           foreach ($QuestionsResult as $key => $row) {
             $RowBack= ($row->result_index)-1 > 0 ? $row->result_index-1 : 0;
             $RowCurrent= $row->result_index ;
             $RowNext= ($row->result_index)+1 < $TotalRow ? ($row->result_index)+1 : $TotalRow  ;
             $audit_check = $row->audit_check;
             $result_val  = $row->result_val;
             if( $row->result_index == $next){
               if($row->result_type=='VALUE'){
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
                                        if($audit_check=='Y'){
                                            $html .='<div >
                                                <label class="ui-radio ui-radio-danger mr-2" data-toggle="tooltip" data-original-title="0 คะแนน">
                                                    <input type="radio" name="check_box" value="0" onclick="saveResult(\''.$row->unid.'\',\'0\')" '. ( $result_val ==0 ? 'checked' : '' ).' >
                                                    <span class="input-span"></span>แก้ไข (0)</label>
                                                <label class="ui-radio ui-radio-warning mr-2"  data-toggle="tooltip" data-original-title="3 คะแนน">
                                                    <input type="radio" name="check_box" value="3" onclick="saveResult(\''.$row->unid.'\',\'3\')" '. ( $result_val ==3 ? 'checked' : '' ).'>
                                                    <span class="input-span"></span>พอใช้ (3)</label>
                                                <label class="ui-radio ui-radio-success mt-2" data-toggle="tooltip" data-original-title="5 คะแนน">
                                                    <input type="radio" name="check_box" value="5" onclick="saveResult(\''.$row->unid.'\',\'5\')" '. ( $result_val ==5 ? 'checked' : '' ).'>
                                                    <span class="input-span"></span>ดีเยี่ยม (5)</label>
                                            </div>';
                                        } else {
                                          $html .='<div >
                                              <label class="ui-radio ui-radio-danger mr-2" data-toggle="tooltip" data-original-title="0 คะแนน">
                                                  <input type="radio" name="check_box" value="0" onclick="saveResult(\''.$row->unid.'\',\'0\')" >
                                                  <span class="input-span"></span>แก้ไข (0)</label>
                                              <label class="ui-radio ui-radio-warning mr-2"  data-toggle="tooltip" data-original-title="3 คะแนน">
                                                  <input type="radio" name="check_box" value="3" onclick="saveResult(\''.$row->unid.'\',\'3\')" >
                                                  <span class="input-span"></span>พอใช้ (3)</label>
                                              <label class="ui-radio ui-radio-success mt-2" data-toggle="tooltip" data-original-title="5 คะแนน">
                                                  <input type="radio" name="check_box" value="5" onclick="saveResult(\''.$row->unid.'\',\'5\')" >
                                                  <span class="input-span"></span>ดีเยี่ยม (5)</label>
                                          </div>';
                                        }

                                   $html .='</div>
                             </div>
                           </div>
                       </div>
                   </div>
                 </div>
             </div>
             <div class="container">
                 <div class="row">
                   <div class="col-md text-center">
                     <button class="btn btn-warning btn-back '.($RowCurrent <=1 ? 'disabled' : '') .'"  data-ans="'.$row->unid_ans.'" data-current="'. $RowCurrent .'" data-back="'.$RowBack.'" onclick="getResult(\''.$row->unid_ans.'\',\''.$RowBack.'\')"> <i class="fa fa-step-backward"></i>กลับ</button>
                     <button class="btn btn-info" > '.$row->result_index.' / '.count($QuestionsResult).'  </button>
                     <button class="btn btn-primary btn-next"  data-ans="'.$row->unid_ans.'" data-current="'. $RowCurrent .'" data-next="'.$RowNext.'" onclick="getResult(\''.$row->unid_ans.'\',\''.$RowNext.'\')"> ถัดไป <i class="fa fa-step-forward"></i></button>
                   </div>

                 </div>
               </div>
               <p/>
             ';
           } elseif($row->result_type=='RANGE') {
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
                            <p>'.$row->result_desc.' </p>
                         </div>
                         <div class="col-md-4">
                         <div class="form-group">
                                    <label class="h4 m-0 text-danger mb-3 ">คะแนนตรวจประเมิน</label>';
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

                         $html .='</div>
                   </div>
                 </div>
             </div>
         </div>
       </div>
   </div>
   <div class="container">
       <div class="row">
         <div class="col-md text-center">
           <button class="btn btn-warning btn-back '.($RowCurrent <=1 ? 'disabled' : '') .'"  data-ans="'.$row->unid_ans.'" data-current="'. $RowCurrent .'" data-back="'.$RowBack.'" onclick="getResult(\''.$row->unid_ans.'\',\''.$RowBack.'\')"> <i class="fa fa-step-backward"></i>กลับ</button>
            <button class="btn btn-info" >'.$row->result_index.' / '.count($QuestionsResult).'  </button>';
            if($row->result_index ==count($QuestionsResult)) {
                $html .=' <button class="btn btn-primary btn-next"  data-ans="'.$row->unid_ans.'" data-current="'. $RowCurrent .'" data-next="'.$RowNext.'" onclick="final(\''.$row->unid_ans.'\')"> ส่งคะแนน <i class="fas fa-sign-in-alt"></i></button>';
            } else {
                  $html .=' <button class="btn btn-primary btn-next"  data-ans="'.$row->unid_ans.'" data-current="'. $RowCurrent .'" data-next="'.$RowNext.'" onclick="getResult(\''.$row->unid_ans.'\',\''.$RowNext.'\')"> ถัดไป <i class="fa fa-step-forward"></i></button>';
            }

$html .=' </div>
       </div>
     </div>
     <p/>

   ';

           } else   {

             $html .='
                <div class="row">
                  <div class="col-md-12">
                   <div class="ibox">
                       <div class="ibox-head">
                           <div class="ibox-title">'.$row->result_toppic.'</div>

                       </div>
                       <div class="ibox-body">
                           <div class="form-group">
                           <label><h5 class="m-t-20 m-b-20">'.$row->result_toppic.'</h5> </label>
                             <input type="hidden" name="unid" id="unid" value="'.$row->unid.'" >
                           <textarea class="form-control"  id="audit_comment" name="audit_comment"
                              data-unid="'.$row->unid.'" rows="3" onchange="SaveComment(\''.$row->unid.'\')" placeholder="'.$row->result_toppic.'">'.trim($row->audit_comment).'</textarea>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>

                       <div class="container">
                           <div class="row">
                             <div class="col-md text-center">
                               <button class="btn btn-warning btn-back '.($RowCurrent <=1 ? 'disabled' : '') .'"  data-ans="'.$row->unid_ans.'" data-current="'. $RowCurrent .'" data-back="'.$RowBack.'" onclick="getResult(\''.$row->unid_ans.'\',\''.$RowBack.'\')"> <i class="fa fa-step-backward"></i>กลับ</button>
                                <button class="btn btn-info" >'.$row->result_index.' / '.count($QuestionsResult).'  </button>';
                                if($row->result_index ==count($QuestionsResult)) {
                                    $html .=' <button class="btn btn-primary btn-next"  data-ans="'.$row->unid_ans.'" data-current="'. $RowCurrent .'" data-next="'.$RowNext.'" onclick="final(\''.$row->unid_ans.'\')"> ส่งคะแนน <i class="fas fa-sign-in-alt"></i></button>';
                                } else {
                                      $html .=' <button class="btn btn-primary btn-next"  data-ans="'.$row->unid_ans.'" data-current="'. $RowCurrent .'" data-next="'.$RowNext.'" onclick="getResult(\''.$row->unid_ans.'\',\''.$RowNext.'\')"> ถัดไป <i class="fa fa-step-forward"></i></button>';
                                }

                    $html .=' </div>
                           </div>
                         </div>
                         <p/>
                         ';
           }

         }

    }


    return response()->json(['result'=> true,'html'=> $html ],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);

  }


  public function scoresave(Request $request){

  $unid   =isset($request->unid) ? $request->unid : '' ;
  $score  =isset($request->score)? $request->score : '' ;
  $count  =QuestionsResultTbl::where('unid','=',$unid)->count();
  $action =false;
    if($count>0){
      $Result  =QuestionsResultTbl::where('unid','=',$unid)->first();
      if($Result->result_type =='VALUE'){
        $action = QuestionsResultTbl::where('unid','=',$unid)->update([
          'result_val' => $score,
          'audit_check' => 'Y'
        ]);
      }
      if($Result->result_type =='RANGE'){
        $action = QuestionsResultTbl::where('unid','=',$unid)->update([
          'result_val' => $score,
          'audit_check' => 'Y'
        ]);
      }
    }
      return response()->json(['result'=> $action  ],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
  }

  public function commentsave(Request $request){

  $unid   =isset($request->unid) ? $request->unid : '' ;
  $audit_comment  =isset($request->comment)? $request->comment : '' ;
  $count  =QuestionsResultTbl::where('unid','=',$unid)->count();
  $action =false;
    if($count>0){
      $Result  =QuestionsResultTbl::where('unid','=',$unid)->first();
      if($Result->result_type =='TEXT'){
        $action = QuestionsResultTbl::where('unid','=',$unid)->update([
          'audit_comment' => $audit_comment,
          'audit_check' => 'Y'
        ]);
      }
    }
      return response()->json(['result'=> $action  ],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
  }

  public function final(Request $request){
        $ans   =isset($request->ans ) ? $request->ans  : '' ;
        $unid   =isset($request->unid ) ? $request->unid  : '' ;
      //  $Count  =QuestionsResultTbl::where('unid','=',$unid)->count();

        $NoCheck = QuestionsResultTbl::where('unid_ans','=',$ans)->where('result_type','=','VALUE')->where('audit_check','=','N')->get();
        $_NotCheck='';
          foreach ($NoCheck as $key => $value) {
            $_NotCheck .= 'ข้อ .'.$value->result_index.' <br/>';
          }

        if($_NotCheck!=''){
            return response()->json(['result'=> false,'data'=>  $_NotCheck],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
        }
        $username='5s';
        $score=0;
        $Totalscore=0;
        $Totalitem=0;
        if($ans !=''){
          $Score = QuestionsResultTbl::where('unid_ans','=',$ans)->where('result_type','!=','TEXT')->orderby('result_index')->get();


          foreach ($Score as $key => $val) {
            $Totalitem = $Totalitem+1;
            $score = $score+$val->result_val ;
          }

         $positions_type =$Score[0]->positions_type;

          if($positions_type=='COMMIT'){
              $Totalscore= (int)$Totalitem*5;
          }elseif($positions_type=='TOP'){
              $Totalscore= (int)$Totalitem*10;
          }
        }

        SummaryResultTbl::where('ans_unid','=',$ans)->update([
          'area_score'=> $score
        //  ,'total_item' => $Totalitem
        //  ,'total_score' => $Totalscore
          ,'doc_status' => 'Y'
          ,'edit_by'=> $username
          ,'edit_time'=>Carbon::now()
        ]);


       $url="check/get/". Cookie::get('DOC_PV').'/'.Cookie::get('DOC_YEAR').'/'.Cookie::get('DOC_MONTH') ;

          return response()->json(['result'=> true,'data'=> 'ส่งคะแนนสำเร็จ','url'=> $url ],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
  }

    public function delete(Request $request){
      $auditor_unid = Cookie::get('USER_UNID') ;
      $unid   =isset($request->unid ) ? $request->unid  : '' ;
      if($unid !='' && $auditor_unid !=''){
        DB::beginTransaction();
        try {
           QuestionsResultTbl::where('plan_unid','=',$unid)->where('auditor_unid','=',$auditor_unid)->delete();
           SummaryResultTbl::where('plan_unid','=',$unid)->where('auditor_unid','=',$auditor_unid)->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
      }
      return response()->json(['result'=> 'success','msg'=>'ลบข้อมูลสำเสร็จ'],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);

    }
    public function reportbyarea(Request $request){
      $year=isset($request->year) ? $request->year : date('Y');
      $month=isset($request->month) ? $request->month : date('n');
      $Areadb = AreaTbl::where('status','=','Y')->orderby('area_index')->get();

      $Area = [];
      $SeltResult= [];
      $CommitResult= [];
      $TopResult= [];
      foreach ($Areadb as $key => $value) {
          $Area[]       = $value->area_name ;// AreaTbl::select('area_name')->where('status','=','Y')->get();
          $SummaryResult1 = SummaryResultTbl::select(DB::raw('round(sum(area_score)/sum(total_score)*100,0) as area_score'))->where('plan_year','=',$year)->where('plan_month','=',$month)
                            ->where('area_unid','=',$value->unid)->where('auditor_position','=','SELF')
                            ->where('doc_status','=','Y')->first();
          $SeltResult[] = isset($SummaryResult1->area_score )   ? $SummaryResult1->area_score : 0 ;

          $SummaryResult2 = SummaryResultTbl::select(DB::raw('round(sum(area_score)/sum(total_score)*100,0) as area_score'))->where('plan_year','=',$year)->where('plan_month','=',$month)
                            ->where('area_unid','=',$value->unid)->where('auditor_position','=','COMMIT')
                            ->where('doc_status','=','Y')->first();
          $CommitResult[] = isset($SummaryResult2->area_score )   ? $SummaryResult2->area_score : 0 ;

          $SummaryResult3 = SummaryResultTbl::select(DB::raw('round(sum(area_score)/sum(total_score)*100,0) as area_score'))->where('plan_year','=',$year)->where('plan_month','=',$month)
                            ->where('area_unid','=',$value->unid)->where('auditor_position','=','TOP')
                            ->where('doc_status','=','Y')->first();
          $TopResult[] = isset($SummaryResult3->area_score )   ? $SummaryResult3->area_score : 0 ;
      }


  return view('pages.report_byarea')
  ->with('Year',$year)
  ->with('Month',$month)
  ->with('Area',json_encode($Area,JSON_UNESCAPED_UNICODE))
  ->with('SeltResult',json_encode($SeltResult,JSON_NUMERIC_CHECK))
  ->with('CommitResult',json_encode($CommitResult,JSON_NUMERIC_CHECK))
  ->with('TopResult',json_encode($TopResult,JSON_NUMERIC_CHECK))
  ;
    // return view('pages.report_byarea', [
    //    'Area' => json_encode($Area, JSON_UNESCAPED_UNICODE)
    // ]);

    }

}
