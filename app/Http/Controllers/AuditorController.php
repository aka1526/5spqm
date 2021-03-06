<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Str;
use App\Models\AuditpositionTbl;
use App\Models\GroupsTbl;
use App\Models\AreaTbl;
use App\Models\AuditorTbl;
use App\Models\AuditAreaTbl;
use App\Models\UserTbl;
class AuditorController extends Controller
{

  protected  $paging =10;

  public function genUnid(){
    $uuid = (string) Str::uuid();
   $uuid = str_replace("-","",$uuid);
    return $uuid;
}

  public function index(Request $request){
   $dataAuditposition =AuditpositionTbl::where('status','=','Y')->orderBy('position_no')->get();
    return view('pages.auditor_index',compact('dataAuditposition'));
  }
  public function get(Request $request){
    $unid= isset($request->unid) ? $request->unid :'';
    $dataset =AuditpositionTbl::where('unid','=',$unid)->first();
    return response()->json(['result'=> 'success','data'=> $dataset],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);

  }
  public function add(Request $request){

    $unid       =isset($request->unid) ? $request->unid:'';

    $position_no   = isset($request->position_no) ? $request->position_no : '1';
    $position_name    = isset($request->position_name) ? $request->position_name : '';
    $position_name_eng    = isset($request->position_name_eng) ? $request->position_name_eng : '';
    $auditor_period   = isset($request->auditor_period) ? $request->auditor_period : '';
    $period_qty     = isset($request->period_qty) ? $request->period_qty : '1';
    $period_type     = isset($request->period_type) ? $request->period_type : '';
    $username='5s';
    $action= false;
    if($unid =='') {
        $uuid = $this->genUnid();
        $action=  AuditpositionTbl::insert([
          'unid'=> $uuid ,
          'position_no' => $position_no,
          'position_name'=> $position_name,
          'position_name_eng'=> $position_name_eng,
          'auditor_period'=> $auditor_period,
          'period_qty'=> $period_qty,
           'period_type'=> $period_type,
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
    $position_no   = isset($request->position_no) ? $request->position_no : '1';
    $position_name    = isset($request->position_name) ? $request->position_name : '';
    $position_name_eng    = isset($request->position_name_eng) ? $request->position_name_eng : '';
    $auditor_period   = isset($request->auditor_period) ? $request->auditor_period : '';
    $period_qty     = isset($request->period_qty) ? $request->period_qty : '1';
    $period_type     = isset($request->period_type) ? $request->period_type : '';

    $username='5s';
    $action=false;
    if($unid !='') {

        $action =AuditpositionTbl::where('unid', '=', $unid)->update([
          'position_no' => $position_no,
          'position_name'=> $position_name,
          'position_name_eng'=> $position_name_eng,
          'auditor_period'=> $auditor_period,
          'period_qty'=> $period_qty,
           'period_type'=> $period_type,
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

        $action =AuditpositionTbl::where('unid', '=', $unid)->delete();
    }

    return response()->json(['result'=>$action],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);

  }
  public function memberindex(Request $request,$unid=null){

    $dataAuditposition =AuditpositionTbl::where('unid','=',$unid)->orderBy('position_no')->first();
    $dataArea =AreaTbl::where('status','=','Y')->orderBy('area_index')->get();
    $dataAuditor =AuditorTbl::where('status','=','Y')->where('audit_position_unid','=',$unid)->orderBy('auditor_item')->get();
    $dtGroup  = GroupsTbl::where('group_position','=',$dataAuditposition->position_name_eng)->orderBy('group_index')->get();
    $dtUser =UserTbl::where('user_status','=','Y')->orderBy('user_name')->get();
    $datamember="";
     return view('pages.auditor_member',compact('dataAuditposition','dtUser','dtGroup','datamember','dataArea','dataAuditor'));

  }

  public function memberadd(Request $request){

    $unid       =isset($request->unid) ? $request->unid:'';
    $audit_position_unid    = isset($request->audit_position_unid) ? $request->audit_position_unid : '';
    $audit_position    = isset($request->audit_position) ? $request->audit_position : '';
    $auditor_group    = isset($request->auditor_group) ? $request->auditor_group : '';
    $auditor_area   = isset($request->auditor_area) ? $request->auditor_area : '';
    $auditor_item   = isset($request->auditor_item ) ? $request->auditor_item  : '1';

    $period_type     = isset($request->period_type) ? $request->period_type : '';
    $area = AreaTbl::where('unid','=',$auditor_area)->first();
    $area_name = isset($area->area_name) ? $area->area_name : '';
    $auditor_unid     = isset($request->auditor_unid) ? $request->auditor_unid : '';
    $auditor_name='';
    if($auditor_unid !=''){
      $auditor =UserTbl::where('unid','=',$auditor_unid)->first();
      $auditor_name     =  $auditor->user_name;
    }


    $username='5s';
    $action= false;

    $CountAuditor =AuditorTbl::where('unid','=',$unid)->count();
    if($CountAuditor==0) {
        $uuid = $this->genUnid();
        $action=  AuditorTbl::insert([
          'unid'=> $uuid ,
          'audit_position_unid' => $audit_position_unid ,
          'audit_position' => $audit_position,
          'auditor_group' => $auditor_group,
          //'auditor_area' => $auditor_area ,
        //  'area_name' => $area_name ,
          'auditor_item' => $auditor_item ,
          'auditor_unid' => $auditor_unid,
          'auditor_name' => $auditor_name,
          'status'=> 'Y',
          'create_by' => $username,
          'create_time' => carbon::now(),
          'edit_by' => $username,
          'edit_time' => Carbon::now(),
          ]);
    } else {

      $action =AuditorTbl::where('unid', '=', $unid)->update([
        'audit_position_unid' => $audit_position_unid ,
        'audit_position' => $audit_position,
        'auditor_group' => $auditor_group,
        //'auditor_area' => $auditor_area ,
        //'area_name' => $area_name ,

        'auditor_item' => $auditor_item ,
        'auditor_unid' => $auditor_unid,
        'auditor_name' => $auditor_name,
      'edit_by'=> $username,
      'edit_time'=> date("Y-m-d H:i:s"),
    ]);
      $action=true;
    }


   return response()->json(['result'=> $action],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);

  }

public function getListArea($AuditUnid=null,$area_unid=null,$position=null){
  $AuditArea =AuditAreaTbl::where('auditor_unid','=',$AuditUnid)
  ->where('position_name_eng','=',$position)
  ->where('area_unid','=',$area_unid)->count();
  $check="";
  if($AuditArea>0){
    $check="Checked";
  }

  return $check ;
}
  public function memberget(Request $request){
    $unid= isset($request->unid) ? $request->unid :'';
    $dataset =AuditorTbl::where('unid','=',$unid)->first();
    $position_unid = $dataset->audit_position_unid;
    $auditunid = $dataset->auditor_unid;
    $Auditposition =AuditpositionTbl::where('unid','=',$position_unid)->first();
    $position =$Auditposition->position_name_eng;

    $Arealist =AreaTbl::where('status','=','Y')->orderBy('area_index')->get();

    $maxItem=6;

    $html='
      <div class="col-md-12 form-group" >
          <label>????????????????????????????????????   </label>
          <div class="row">';

        $html.= ' <div class="col-6 m-b-20">
                    <div class="check-list">';
                    foreach ($Arealist as $key => $row) {
                      $_areaunid= $row->unid ;
                        if($key <=$maxItem){

                          $html.='
                               <label class="ui-checkbox ui-checkbox-info">
                                 <input type="checkbox" id="'.$row->unid.'" name="'.$row->unid.'" onchange="addarea(\''.$row->unid.'\');" class="check_box" value="'.$row->unid.'" '.$this->getListArea($auditunid,$_areaunid,$position).' >
                                 <span class="input-span"></span>'.$row->area_name.'
                               </label>';
                        }

                      }
            $html.='</div>';
        $html.='</div>';
        $html .='<div class="col-6 m-b-20">
                    <div class="check-list">';
                    foreach ($Arealist as $key => $row) {
                        $_areaunid= $row->unid ;
                        if($key >$maxItem){
                          $html.='
                               <label class="ui-checkbox ui-checkbox-info">
                                 <input type="checkbox" id="'.$row->unid.'" name="'.$row->unid.'" onchange="addarea(\''.$row->unid.'\')" class="check_box" value="'.$row->unid.'" '.$this->getListArea($auditunid,$_areaunid,$position).' >
                                 <span class="input-span"></span>'.$row->area_name.'
                               </label>';
                        }

                      }
            $html.='</div>';
          $html.='</div>';
        $html.='</div>';
      $html.='</div>';
    return response()->json(['result'=> 'success','data'=> $dataset,'AuditArea'=> $html],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
  }


  public function memberedit(Request $request){
  //  dd($request);
    $unid       =isset($request->unid) ? $request->unid:'';
    $audit_position_unid    = isset($request->audit_position_unid) ? $request->audit_position_unid : '';
    $audit_position    = isset($request->audit_position) ? $request->audit_position : '';
    $auditor_group    = isset($request->auditor_group) ? $request->auditor_group : '';
    $auditor_area   = isset($request->auditor_area) ? $request->auditor_area : '';
    $auditor_item   = isset($request->auditor_item ) ? $request->auditor_item  : '1';


    $auditor_unid     = isset($request->auditor_unid) ? $request->auditor_unid : '';
    $auditor_name ='';
    if($auditor_unid !=''){
      $auditor =UserTbl::where('unid','=',$auditor_unid)->first();
      $auditor_name     =  $auditor->user_name;
    }



    $period_type     = isset($request->period_type) ? $request->period_type : '';
    $area = AreaTbl::where('unid','=',$auditor_area)->first();
    $Auditposition=  AuditpositionTbl::where('unid','=',$audit_position_unid)->first();
    $area_name = isset($area->area_name) ? $area->area_name : '';
    $username='5s';
    $action=false;
    if($unid !='') {

        $action =AuditorTbl::where('unid', '=', $unid)->where('audit_position_unid', '=', $audit_position_unid)->update([
          'audit_position' => $audit_position
          ,'auditor_group' => $auditor_group
          ,'auditor_item' => $auditor_item
          ,'auditor_unid' => $auditor_unid
          ,'auditor_name' => $auditor_name
          ,'edit_by'=> $username
          ,'edit_time'=> date("Y-m-d H:i:s")
      ]);

    }

  //  dd($action);

 return response()->json(['result'=>$action],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);

  }

  public function memberdelete(Request $request){
    $unid =isset($request->unid) ? $request->unid : '';
    $action=false;
    if($unid !='') {

        $action =AuditorTbl::where('unid', '=', $unid)->delete();
    }

    return response()->json(['result'=>$action],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
  }


public function addauditarea(Request $request){

  $auditor_unid =isset($request->auditor_unid) ? $request->auditor_unid : '';
  $check_unid=isset($request->check_unid) ? $request->check_unid : '';
  $audit_position_unid    = isset($request->audit_position_unid) ? $request->audit_position_unid : '';
  $audit_position         = isset($request->audit_position) ? $request->audit_position : '';
  $auditor_group          = isset($request->auditor_group) ? $request->auditor_group : '';
  $auditor_area           = isset($request->auditor_area) ? $request->auditor_area : '';
  $auditor_item           = isset($request->auditor_item ) ? $request->auditor_item  : '1';
  //$auditor_name           = isset($request->auditor_name) ? $request->auditor_name : '';
  $period_type            = isset($request->period_type) ? $request->period_type : '';

  //$area_name              = isset($area->area_name) ? $area->area_name : '';

  $auditor_unid     = isset($request->auditor_unid) ? $request->auditor_unid : '';
  $auditor_name ='';
  if($auditor_unid !=''){
    $auditor =UserTbl::where('unid','=',$auditor_unid)->first();
    $auditor_name     =  $auditor->user_name;
  }
  $Auditposition=  AuditpositionTbl::where('unid','=',$audit_position_unid)->first();
  $position_name_eng =$Auditposition->position_name_eng;

  $action=false;

  $area  = AreaTbl::where('unid','=',$auditor_area)->first();
  $area_name = $area->area_name;
  AuditAreaTbl::where('auditor_unid','=',$auditor_unid)->where('position_name_eng','=',$position_name_eng )->delete();

  $username='5s';

/*  if($auditor_unid==''){
     $auditor_unid = $this->genUnid();

    if($Auditposition->position_name_eng=='SELF'){
      $action=  AuditorTbl::insert([
        'unid'=> $auditor_unid ,
        'audit_position_unid' => $audit_position_unid ,
        'audit_position' => $audit_position,
        'auditor_group' => $auditor_group,
        'auditor_area' => $auditor_area ,
        'area_name' => $area_name ,
        'auditor_item' => $auditor_item ,
        'auditor_name' => $auditor_name,
        'status'=> 'Y',
        'create_by' => $username,
        'create_time' => carbon::now(),
        'edit_by' => $username,
        'edit_time' => Carbon::now(),
        ]);



    } else {
      $action=  AuditorTbl::insert([
        'unid'=> $auditor_unid ,
        'audit_position_unid' => $audit_position_unid ,
        'audit_position' => $audit_position,
        'auditor_group' => $auditor_group,
        'auditor_area' => "" ,
        'area_name' => "" ,
        'auditor_item' => $auditor_item ,
        'auditor_name' => $auditor_name,
        'status'=> 'Y',
        'create_by' => $username,
        'create_time' => carbon::now(),
        'edit_by' => $username,
        'edit_time' => Carbon::now(),
        ]);
    }
  }*/


    if($Auditposition->position_name_eng=='SELF'){
      //dd($area_name,$auditor_area);
      //  AreaTbl::where('unid', '=', $auditor_area)->dd();
            AreaTbl::where('unid', '=', $auditor_area)->update([
              'area_owner' =>$auditor_name,
             ]);
             //AuditorTbl::where('auditor_unid','=',$auditor_unid)->where('audit_position_unid','=',$audit_position_unid)->dd();
           AuditorTbl::where('auditor_unid','=',$auditor_unid)
           ->where('audit_position_unid','=',$audit_position_unid)->update([
               'auditor_area' => $auditor_area ,
               'area_name' => $area_name ,
             ]) ;
    }

  $username='5s';

  $Auditor  =AuditorTbl::where('auditor_unid','=',$auditor_unid)->where('audit_position_unid','=',$audit_position_unid)->first();
  $Position =AuditpositionTbl::where('unid','=',$Auditor->audit_position_unid)->first();

  foreach (explode(';',$check_unid) as $row){
    //dd($row);
      $uuid = $this->genUnid();
      $area_unid =$row;

      if($area_unid!=''){
        $Area     =AreaTbl::where('unid','=',$area_unid)->first();
        $action=  AuditAreaTbl::insert([
        'unid'=> $uuid ,
        'position_name_eng' => $Position->position_name_eng ,
         'auditor_unid'=> $auditor_unid,
         'auditor_name'=> $Auditor->auditor_name,
         'area_unid'=>  $area_unid,
         'area_index'=> $Area->area_index ,
         'area_name'=> $Area->area_name,
         'area_owner'=> $Area->area_owner,
         'auditor_group' => $Auditor->auditor_group,
         'status'=> "Y",
         'create_by' => $username,
         'create_time' => carbon::now(),
        'edit_by' => $username,
        'edit_time' => Carbon::now(),
        ]);
      }

  }


  return response()->json(['result'=>$action],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
}

  public function editfield(Request $request){

  }
}
