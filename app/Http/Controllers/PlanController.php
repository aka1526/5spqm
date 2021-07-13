<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Str;
use App\Models\AreaTbl;
use App\Models\GroupsTbl;
use App\Models\AuditpositionTbl;
use App\Models\PlanMasterTbl;

class PlanController extends Controller
{

  public function genUnid(){
    $uuid = (string) Str::uuid();
   $uuid = str_replace("-","",$uuid);
    return $uuid;
}

 public function index(Request $request){
   return view('pages.plan_index');
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
             'datestart' => Carbon::now()->format('Y-m-d'),
             'dateend'=> Carbon::now()->endOfYear()->format('Y-m-d'),
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

}
