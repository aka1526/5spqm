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
             if( $row->result_index == $next){
               if($row->result_type=='VALUE'){
             $html .='
               <div class="row">
                 <div class="col-md-12">
                   <div class="ibox">
                           <div class="ibox-head">
                               <div class="ibox-title">'.$row->result_toppic.'</div>

                           </div>
                       <div class="ibox-body">
                           <div class="row">
                             <div class="col-md-8">
                                <p> <strong> ข้อที่ '.$row->result_index.'. </strong> '.$row->result_desc.' </p>
                             </div>
                             <div class="col-md-4">
                             <div class="form-group">
                                        <label class="h4 m-0 text-danger mb-3 ">คะแนนตรวจประเมิน</label>

                                        <div >
                                            <label class="ui-radio ui-radio-danger" data-toggle="tooltip" data-original-title="0 คะแนน">
                                                <input type="radio" name="check_box" value="0" onclick="saveResult(\''.$row->unid.'\',\'0\')" >
                                                <span class="input-span"></span>แก้ไข (0)</label>
                                            <label class="ui-radio ui-radio-warning" data-toggle="tooltip" data-original-title="3 คะแนน">
                                                <input type="radio" name="check_box" value="3" onclick="saveResult(\''.$row->unid.'\',\'3\')" >
                                                <span class="input-span"></span>พอใช้ (3)</label>
                                            <label class="ui-radio ui-radio-success" data-toggle="tooltip" data-original-title="5 คะแนน">
                                                <input type="radio" name="check_box" value="5" onclick="saveResult(\''.$row->unid.'\',\'5\')" >
                                                <span class="input-span"></span>ดีเยี่ยม (5)</label>
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
                     <button class="btn btn-warning btn-back '.($RowCurrent <=1 ? 'disabled' : '') .'"  data-ans="'.$row->unid_ans.'" data-current="'. $RowCurrent .'" data-back="'.$RowBack.'" onclick="getResult(\''.$row->unid_ans.'\',\''.$RowBack.'\')"> <i class="fa fa-step-backward"></i>กลับ</button>
                     <button class="btn btn-info" > '.$row->result_index.' / '.count($QuestionsResult).'  </button>
                     <button class="btn btn-primary btn-next"  data-ans="'.$row->unid_ans.'" data-current="'. $RowCurrent .'" data-next="'.$RowNext.'" onclick="getResult(\''.$row->unid_ans.'\',\''.$RowNext.'\')"> ถัดไป <i class="fa fa-step-forward"></i></button>
                   </div>

                 </div>
               </div>
               <p/>
             ';
           }else {

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
                           <textarea class="form-control"  data-unid="'.$row->unid.'" rows="3" placeholder="'.$row->result_toppic.'"></textarea>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>

                       <div class="container">
                           <div class="row">
                             <div class="col-md text-center">
                               <button class="btn btn-warning btn-back '.($RowCurrent <=1 ? 'disabled' : '') .'"  data-ans="'.$row->unid_ans.'" data-current="'. $RowCurrent .'" data-back="'.$RowBack.'" onclick="getResult(\''.$row->unid_ans.'\',\''.$RowBack.'\')"> <i class="fa fa-step-backward"></i>กลับ</button>
                                <button class="btn btn-info" >'.$row->result_index.' / '.count($QuestionsResult).'  </button>
                               <button class="btn btn-primary btn-next"  data-ans="'.$row->unid_ans.'" data-current="'. $RowCurrent .'" data-next="'.$RowNext.'" onclick="getResult(\''.$row->unid_ans.'\',\''.$RowNext.'\')"> ถัดไป <i class="fa fa-step-forward"></i></button>
                             </div>

                           </div>
                         </div>
                         <p/>
                         ';
           }
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


    return response()->json(['result'=> true,'html'=> $html ],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);

  }

}
