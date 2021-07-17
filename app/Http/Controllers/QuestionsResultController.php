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


class QuestionsResultController extends Controller
{

  protected  $paging =10;

  public function genUnid(){
    $uuid = (string) Str::uuid();
   $uuid = str_replace("-","",$uuid);
    return $uuid;
  }

  public function getnext(Request $request){

   $ans = isset($request->ans) ? $request->ans :'';
   $next = isset($request->next) ? $request->next :'';


           $html .=' ';
           $TotalRow = count($QuestionsResult);
           $RowBack= 0;
           $RowCurrent=0 ;
           $RowNext=0  ;

           foreach ($QuestionsResult as $key => $row) {
             $RowBack= ($row->result_index)-1 > 0 ? $row->result_index-1 : 0;
             $RowCurrent= $row->result_index ;
             $RowNext= ($row->result_index)+1 < $TotalRow ? ($row->result_index)+1 : $TotalRow  ;
             if($RowNext==$next){


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
                     <button class="btn btn-warning btn-back '.($RowCurrent <=1 ? 'disabled' : '') .'"  data-ans="'.$row->unid_ans.'" data-current="'. $RowCurrent .'" data-back="'.$RowBack.'"> <i class="fa fa-step-backward"></i>กลับ</button>
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


    return response()->json(['result'=> 'success','data'=> $html ],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);

  }

}
