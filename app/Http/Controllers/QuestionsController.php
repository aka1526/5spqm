<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Str;
use App\Models\AreaTbl;
use App\Models\QuestionsTbl;
use App\Models\QuestionspositionTbl;
use App\Models\QuestionsAreaTbl;
class QuestionsController extends Controller
{

  protected  $paging =10;

  public function genUnid(){
    $uuid = (string) Str::uuid();
   $uuid = str_replace("-","",$uuid);
    return $uuid;
}

  public function index(Request $request){
   $dataQuestions =QuestionsTbl::where('status','=','Y')->orderBy('ques_index')->get();
    return view('pages.questions_index',compact('dataQuestions'));
  }
  public function get(Request $request){
     $unid= isset($request->unid) ? $request->unid :'';


    $Arealist =AreaTbl::where('status','=','Y')->orderBy('area_index')->get();

    $maxItem=6;

    $html='
      <div class="col-md-12 form-group" >
          <h4>พื้นทีตรวจ  </h4>

          <div class="row">';

        $html.= ' <div class="col-6 m-b-20">
                    <div class="check-list">';
                    foreach ($Arealist as $key => $row) {
                        if($key <=$maxItem){
                          $html.='
                               <label class="ui-checkbox ui-checkbox-info">
                                 <input type="checkbox" id="areaitem_'.$row->unid.'" name="areaitem[]"  data-unid="'.$row->unid.'" class="check_box" value="'.$row->unid.'" '.$this->getListArea($unid,$row->unid).' >
                                 <span class="input-span"></span>'.$row->area_name.'
                               </label>';
                        }

                      }
            $html.='</div>';
        $html.='</div>';
        $html .='<div class="col-6 m-b-20">
                    <div class="check-list">';
                    foreach ($Arealist as $key => $row) {
                        if($key >$maxItem){
                          $html.='
                               <label class="ui-checkbox ui-checkbox-info">
                                 <input type="checkbox" id="areaitem_'.$row->unid.'" name="areaitem[]" data-unid="'.$row->unid.'"   class="check_box" value="'.$row->unid.'" '.$this->getListArea($unid,$row->unid).' >
                                 <span class="input-span"></span>'.$row->area_name.'
                               </label>';
                        }

                      }
            $html.='</div>';
          $html.='</div>';
        $html.='</div>';
      $html.='</div>';

    return response()->json(['result'=> 'success','area'=> $html],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);

  }
  public function add(Request $request){
  //  dd($request);

    $unid       =isset($request->unid) ? $request->unid:'';
    $ques_index   = isset($request->ques_index) ? $request->ques_index : '1';
    $ques_header    = isset($request->ques_header) ? $request->ques_header : '';
    $position_type  = isset($request->position_type) ? $request->position_type : '';
    $areaitem   = isset($request->areaitem) ? $request->areaitem : '';
/*
    $validated = $request->validate([
         'position_type' =>'required',
          'areaitem' =>'required',
    ]);*/

    $this->validate(
        $request,
        [
          'position_type' => 'required'
          ,  'areaitem' => 'required'
        ],
        [
          'position_type.required' => 'เกิดข้อผิดพลาด คุณไม่ได้เลือกผู้ตรวจประเมิน'
          ,'areaitem.required' => 'เกิดข้อผิดพลาด คุณไม่ได้เลือกพื้นที่ตรวจ'
        ]
    );


    // return Validator::make($position_type, [
    //
    //     'position_type' =>'required', //not checkbox
    // ]);
    // return Validator::make($areaitem, [
    //
    //     'areaitem' =>'required', //not checkbox
    // ]);

    $ques_rev="00";
    $username='5s';
    $action= false;
    if($unid =='') {
        $uuid = $this->genUnid();
        $action=  QuestionsTbl::insert([
          'unid'=> $uuid ,
          'ques_index'=> $ques_index,
          'ques_rev'=> $ques_rev,
          'ques_header'=> $ques_header,
          'status'=> 'Y',
          'create_by' => $username,
          'create_time' => carbon::now(),
          'edit_by' => $username,
          'edit_time' => Carbon::now(),
        ]);
      //  use App\Models\QuestionspositionTbl;
        //use App\Models\QuestionsAreaTbl;

        if($action && ($position_type !='')){

          foreach ($position_type as $key => $ps_type) {
            QuestionspositionTbl::insert([
              'unid' => $this->genUnid()
              ,'ques_unid' => $uuid
              ,'position_type' => $ps_type
              ,  'status'=> 'Y'
              ,'create_by' => $username
              ,'create_time' => carbon::now()
              ,'edit_by' => $username
              ,'edit_time' => Carbon::now()
            ]);
          }

        }

        if($action && $areaitem !=''){
          foreach ($areaitem as $key => $ar_type) {
              $Area =AreaTbl::where('unid','=',$ar_type)->first();
            QuestionsAreaTbl::insert([
                'unid' =>  $this->genUnid()
                ,'ques_unid' => $uuid
                ,'area_index'=> $Area->area_index
                ,'area_unid'=> $Area->unid
                ,'area_name'=> $Area->area_name
                ,'create_by'=> $username
                ,'create_time'=>Carbon::now()
                ,'edit_by'=> $username
                ,'edit_time'=>Carbon::now()
                ,'status'=>"Y"
            ]);
          }
        }

    }

   //return response()->json(['result'=> $action],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
return back();
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

  public function getListArea($AuditUnid=null,$area_unid=null){
    //$AuditArea =AuditAreaTbl::where('auditor_unid','=',$AuditUnid)->where('area_unid','=',$area_unid)->count();
    //$check="";
    //if($AuditArea>0){
      $check="Checked";
    //}

    return $check ;
  }
}
