<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

// use App\Models\AreaTbl;
// use App\Models\GroupsTbl;
// use App\Models\AuditpositionTbl;
// use App\Models\AuditAreaTbl;
// use App\Models\PlanMasterTbl;
// use App\Models\PlanPositionTbl;

class UserController extends Controller
{

  public function genUnid(){
    $uuid = (string) Str::uuid();
   $uuid = str_replace("-","",$uuid);
    return $uuid;
}

 public function index(Request $request){
    $User =UserTbl::all()->orderBy('user_name')->get();
   return view('pages.user_index',compact('User'));
 }
 public function get(Request $request){

   //dd($request);
   $pv = isset($request->pv) ? $request->pv : '';

    $dataGroups =GroupsTbl::where('group_position','=',$pv)
    ->orderBy('group_position')->orderBy('group_index')->get();

   $dataArea =AreaTbl::where('status','=','Y')->orderBy('area_index')->get();

   foreach ($dataArea as $key => $row) {
        $count =PlanMasterTbl::where('position_type','=',$pv)->where('area_unid', '=',$row->unid)->count();
        $uuid = $this->genUnid();
        if($count==0){
          PlanMasterTbl::insert([
            'unid' => $uuid,
            'area_unid' => $row->unid ,
            'area_index' => $row->area_index ,
            'area_name' => $row->area_name ,
            'area_owner' => $row->area_owner ,
            'position_type' => $pv,
            'groups' => "",
          //  'datestart' => Carbon::now()->format('Y-m-d'),
            //'dateend'=> Carbon::now()->endOfYear()->format('Y-m-d'),
          ]);

        }

   }

   $dataPlanMaster =PlanMasterTbl::where('position_type','=',$pv)->orderBy('area_index')->get();

   $dataPosition =AuditpositionTbl::where('position_name_eng','=',$pv)->first();

  return view('pages.plan_add',compact('dataGroups','dataArea','dataPlanMaster','pv','dataPosition'));
 }
 public function add(Request $request){

 }
 public function edit(Request $request){

 }
 public function editfield(Request $request){

 }
 public function planmasterupdatefield(Request $request){
    $unid=isset($request->unid) ?$request->unid : '';
    $field =isset($request->field) ?$request->field : '';
    $val=isset($request->val) ?$request->val : '';

    $action=false;

    $count =PlanMasterTbl::where('unid','=',$unid)->count();

    if($count>0){
      PlanMasterTbl::where('unid','=',$unid)->update([
          $field => $val,
      ]);
    }


  return response()->json(['result'=> $action],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);


 }

 public function planmastercreateplan(Request $request){

      $position_type =isset($request->position_type) ? $request->position_type : '';
      $plandate =isset($request->plandate) ? $request->plandate : '';


      $Auditposition  = AuditpositionTbl::where('position_name_eng','=',$position_type)->first();
    //  dd($Auditposition);
      $period_qty     = $Auditposition->period_qty ;
      $period_type    = $Auditposition->period_type ;
      $username='5s';


    if($plandate!='' || $position_type !='' || $groups !=''){

     $plandate=  Carbon::createFromFormat('d/m/Y', $plandate)->format('Y-m-d');
      //dd($plandate);
      $plan_date = Carbon::parse($plandate)->format('Y-m-d');
      $plan_month = Carbon::parse($plandate)->format('n');
      $plan_year = Carbon::parse($plandate)->format('Y');

      $IndexStart   =isset($request->groups) ? $request->groups : 1 ;
      $IndexTotal=0;
      $AuditGroups  = GroupsTbl::where('group_position','=',$position_type)->orderBy('group_index')->get();
      $IndexTotal   = $AuditGroups->count();
      //$plan_groups='A';
      $Area  =  AreaTbl::where('status','=','Y')->orderBy('area_index')->get();
      $item = $IndexStart >0 ? $IndexStart -1 : 0;

      $countCheck= PlanPositionTbl::where('position_type','=',$position_type)
        ->where('plan_date','=',$plan_date)->count();

        if($countCheck>0){
            return back()->with('result', 'error')->with('title', 'ข้อมูลซ้ำ');
        }
        foreach ($Area as $key => $rowArea) {

          $plan_groups  = $AuditGroups[$item]->group_name ;
         //dd($plan_groups);
                  $uuid = $this->genUnid();
                  PlanPositionTbl::insert([
                    'unid' => $uuid
                    ,'plan_year'  => $plan_year
                    ,'plan_month' => $plan_month
                    ,'plan_date' => $plan_date
                    ,'plan_area_unid' => $rowArea->unid
                    ,'plan_area_index' => $rowArea->area_index
                    ,'plan_area_name' => $rowArea->area_name
                    ,'plan_area_owner' => $rowArea->area_owner
                    ,'position_type' => $position_type
                    ,'plan_groups' =>  $plan_groups
                    ,'plan_status' => 'Y'
                    ,'create_by' => $username
                    ,'create_time' => Carbon::now()->format('Y-m-d')
                    ,'edit_by' => $username
                    ,'edit_time' => Carbon::now()->format('Y-m-d')
                   ]);

                  PlanMasterTbl::where('area_unid','=',$rowArea->unid)
                  ->where('position_type','=',$position_type)->update([
                      'groups' => $plan_groups,
                      'datestart' => $plan_date
                  ]);
                  $item++;
             $item = $item >= $IndexTotal ? 0 : $item ;
         }
    }
        return back()->with('result', 'success')->with('title', 'บันทึกสำเร็จ');
 }


}
