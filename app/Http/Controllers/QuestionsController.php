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
use App\Models\QuestionsItemTbl;
use App\Models\PositionsTbl;

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

     $dtQuestions =QuestionsTbl::where('unid','=',$unid)->first();
     $dtQuestionsposition = QuestionspositionTbl::where('ques_unid','=',$unid)->get();
     $Arealist =AreaTbl::where('status','=','Y')->orderBy('area_index')->get();
     $dtPositions = PositionsTbl::where('status','=','Y')->orderBy('position_index')->get();
    $maxItem=6;
    $htmlPosition="";

    $htmlPosition.='<div class="col-md">
                      <div class="form-group">
                        <h4> ผู้ตรวจประเมินพื้นที่</h4>
                        <div class="m-b-10">';
          foreach ($dtPositions as $key => $item) {
          $htmlPosition.='  <label class="ui-checkbox ui-checkbox-inline ui-checkbox-success">
                                <input type="checkbox" id="position_type" name="position_type[]" value="'.$item->positions_type.'"
                                '. $this->getPositionCheck($unid,$item->positions_type).' >
                                <span class="input-span"></span>'.$item->position_name.'</label> ';

          }

        $htmlPosition.='</div>
                    </div>
                  </div>';

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

    return response()->json([
        'result'=> 'success'
        ,'data' =>$dtQuestions
        ,'position' =>$htmlPosition
        ,'area'=> $html],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);

  }
  public function add(Request $request){
  //  dd($request);

    $unid       =isset($request->unid) ? $request->unid:'';
    $ques_index   = isset($request->ques_index) ? $request->ques_index : '1';
    $ques_header    = isset($request->ques_header) ? $request->ques_header : '';
    $position_type  = isset($request->position_type) ? $request->position_type : '';
    $areaitem   = isset($request->areaitem) ? $request->areaitem : '';


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
    $ques_index   = isset($request->ques_index) ? $request->ques_index : '1';
    $ques_header    = isset($request->ques_header) ? $request->ques_header : '';
    $position_type  = isset($request->position_type) ? $request->position_type : '';
    $areaitem   = isset($request->areaitem) ? $request->areaitem : '';

    $ques_rev="00";
    $username='5s';
    $action=false;

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
    if($unid !='') {

      $action=  QuestionsTbl::where('unid','=',$unid)->update([
              'ques_index'=> $ques_index,
              'ques_rev'=> $ques_rev,
              'ques_header'=> $ques_header,
               'edit_by' => $username,
              'edit_time' => Carbon::now(),
            ]);

      if($action && ($position_type !='')){
        QuestionspositionTbl::where('ques_unid','=',$unid)->delete();
        foreach ($position_type as $key => $ps_type) {
          QuestionspositionTbl::insert([
            'unid' => $this->genUnid()
            ,'ques_unid' => $unid
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
          QuestionsAreaTbl::where('ques_unid','=',$unid)->delete();
        foreach ($areaitem as $key => $ar_type) {
            $Area =AreaTbl::where('unid','=',$ar_type)->first();
          QuestionsAreaTbl::insert([
              'unid' =>  $this->genUnid()
              ,'ques_unid' => $unid
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

    //return response()->json(['result'=>$action],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
  return back();
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

  public function editunid(Request $request,$unid=null){

      $unid =isset($unid) ? $unid :'';
      $dtQuestions =QuestionsTbl::where('unid', '=',$unid)->first();
      $dtQuestionsItem=  QuestionsItemTbl::where('item_refunid','=',$unid)->orderBy('item_index')->get();
      return view('pages.questions_item',compact('unid','dtQuestions','dtQuestionsItem')) ;
  }




  public function getListArea($AuditUnid=null,$area_unid=null){
    $AuditArea =QuestionsAreaTbl::where('ques_unid','=',$AuditUnid)->where('area_unid','=',$area_unid)->count();
    $check="";
    if($AuditArea>0){$check="Checked";}
    return $check ;
  }

  public function getPositionCheck($ques_unid=null,$position_type=null){
    $data =QuestionspositionTbl::where('ques_unid','=',$ques_unid)->where('position_type','=',$position_type)->count();
    $check="";
    if($data>0){$check="Checked";}
    return $check ;
  }
}
