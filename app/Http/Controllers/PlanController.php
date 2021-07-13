<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Str;
use App\Models\AreaTbl;
use App\Models\GroupsTbl;
use App\Models\AuditpositionTbl;

class PlanController extends Controller
{
 public function index(Request $request){
   return view('pages.plan_index');
 }
 public function get(Request $request){
   //dd($request);
   $pv = isset($request->pv) ? $request->pv : '';

   $dataGroups =GroupsTbl::where('group_position','=',$pv)
    ->orderBy('group_position')->orderBy('group_index')->get();

   $dataArea =AreaTbl::where('status','=','Y')->orderBy('area_index')->get();
   $dataPosition =AuditpositionTbl::where('position_name_eng','=',$pv)->first();

  return view('pages.plan_add',compact('dataGroups','dataArea','pv','dataPosition'));
 }
 public function add(Request $request){

 }
 public function edit(Request $request){

 }
 public function editfield(Request $request){

 }

}
