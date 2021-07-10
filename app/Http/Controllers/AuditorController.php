<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Str;
use App\Models\AuditpositionTbl;
use App\Models\AreaTbl;
use App\Models\AuditorTbl;

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
    $datamember="";
     return view('pages.auditor_member',compact('dataAuditposition','datamember','dataArea','dataAuditor'));

  }

  public function memberadd(Request $request){

    $unid       =isset($request->unid) ? $request->unid:'';
    $audit_position_unid    = isset($request->audit_position_unid) ? $request->audit_position_unid : '';
    $audit_position    = isset($request->audit_position) ? $request->audit_position : '';
    $auditor_group    = isset($request->auditor_group) ? $request->auditor_group : '';
    $auditor_area   = isset($request->auditor_area) ? $request->auditor_area : '';
    $auditor_item   = isset($request->auditor_item ) ? $request->auditor_item  : '1';
    $auditor_name     = isset($request->auditor_name) ? $request->auditor_name : '';
    $period_type     = isset($request->period_type) ? $request->period_type : '';
    $area = AreaTbl::where('unid','=',$auditor_area)->first();
    $area_name = isset($area->area_name) ? $area->area_name : '';
    $username='5s';
    $action= false;
    if($unid =='') {
        $uuid = $this->genUnid();
        $action=  AuditorTbl::insert([

          'unid'=> $uuid ,
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
    }
  //  return back();

   return response()->json(['result'=> $action],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);

  }

  public function memberget(Request $request){
    $unid= isset($request->unid) ? $request->unid :'';
    $dataset =AuditorTbl::where('unid','=',$unid)->first();
    return response()->json(['result'=> 'success','data'=> $dataset],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
  }


  public function memberedit(Request $request){
    $unid       =isset($request->unid) ? $request->unid:'';
    $audit_position_unid    = isset($request->audit_position_unid) ? $request->audit_position_unid : '';
    $audit_position    = isset($request->audit_position) ? $request->audit_position : '';
    $auditor_group    = isset($request->auditor_group) ? $request->auditor_group : '';
    $auditor_area   = isset($request->auditor_area) ? $request->auditor_area : '';
    $auditor_item   = isset($request->auditor_item ) ? $request->auditor_item  : '1';
    $auditor_name     = isset($request->auditor_name) ? $request->auditor_name : '';
    $period_type     = isset($request->period_type) ? $request->period_type : '';
    $area = AreaTbl::where('unid','=',$auditor_area)->first();
    $area_name = isset($area->area_name) ? $area->area_name : '';
    $username='5s';
    $action=false;
    if($unid !='') {

        $action =AuditorTbl::where('unid', '=', $unid)->update([
          'audit_position_unid' => $audit_position_unid ,
          'audit_position' => $audit_position,
          'auditor_group' => $auditor_group,
          'auditor_area' => $auditor_area ,
          'area_name' => $area_name ,
          'auditor_item' => $auditor_item ,
          'auditor_name' => $auditor_name,
        'edit_by'=> $username,
        'edit_time'=> date("Y-m-d H:i:s"),
      ]);

    }

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


  public function editfield(Request $request){

  }
}
