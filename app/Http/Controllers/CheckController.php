<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Cookie;
use Illuminate\Support\Str;
use App\Models\AreaTbl;

use App\Models\PlanPositionTbl;


class CheckController extends Controller
{

  protected  $paging =10;

  public function genUnid(){
    $uuid = (string) Str::uuid();
    $uuid = str_replace("-","",$uuid);
    return $uuid;
}

  public function index(Request $request){
   $dataArea =AreaTbl::where('status','=','Y')->orderBy('area_index')->get();
    return view('pages.check_index',compact('dataArea'));
  }

  public function yearmonth(Request $request){
    //dd($request);
    $pv =isset($request->pv) ? $request->pv : '';
    $docyear =isset($request->docyear) ? $request->docyear : date('Y');
  //  $unid= isset($request->unid) ? $request->unid :'';
  //  $dataArea =AreaTbl::where('unid','=',$unid)->first();
  //  return response()->json(['result'=> 'success','data'=> $dataArea],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
    Cookie::queue('DOC_YEAR',$docyear);
    Cookie::queue('DOC_PV',$pv);
    $html ='';
    for ($monthNum = 1; $monthNum <= 12; $monthNum++) {
      $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));

     if($this->getMonthPlan($docyear,$monthNum,$pv)) {

        $html  .=  ' <div class="col-sm-3">
                    <div class="alert bg-white ">
                        <form id="m'.$monthNum.'" action="" method="post" >
                        <button type="button" class="btn btn-success btn-block btn-month color-'.$monthNum.'" data-month="'.$monthNum.'"  data-pv="'.$pv .'" target="_blank"><h2>'.$monthNum.'. '.  $monthName.'</h2></button>
                        </form >
                     </div>
                 </div>';
     } else {
       $html  .=  ' <div class="col-sm-3">
                   <div class="alert bg-white ">

                       <button type="button" class="btn  btn-block  color-none disabled" data-month="'.$monthNum.'"  data-pv="'.$pv .'" target="_blank"><h2>'.$monthNum.'. '.  $monthName.'</h2></button>

                    </div>
                </div>';
     }

  }




  return view('pages.check_yearmonth',compact('html','pv'));
  }

  public function getMonthPlan($plan_year=null,$plan_month=null,$pv='')    {
      $PlanCount =PlanPositionTbl::where('plan_year','=',$plan_year)
      ->where('plan_month', '=',$plan_month)
      ->where('position_type','=',$pv)
      ->orderBy('plan_month')->count();

      $stat =  $PlanCount > 0 ? true : false ;
      return $stat;
    }

  public function get(Request $request,$pv=null,$year=null,$moth=null){
      $unid= isset($request->unid) ? $request->unid :'';
      $dataArea =AreaTbl::where('unid','!=',$unid)->get();
      $position_type= isset($request->pv) ?strtoupper($request->pv ) :'';

      $dtPlan =PlanPositionTbl::where('position_type','=',$position_type)
      ->where('plan_area_unid','=','36863c6e0e654ba7b3907fc986418405')
      ->where('plan_year','=',$year)->where('plan_month','=',$moth)->orderBy('plan_date')->orderBy('plan_area_index')->get();
    // return response()->json(['result'=> 'success','data'=> $dataArea],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
   return view('pages.check_plan',compact('dtPlan','pv'));
  }
  public function add(Request $request){
    $unid       =isset($request->unid) ? $request->unid:'';

    $area_index   = isset($request->area_index) ? $request->area_index : '0';
    $area_name    = isset($request->area_name) ? $request->area_name : '';
    $area_owner   = isset($request->area_owner) ? $request->area_owner : '';
    $username='5s';
    $action= false;
    if($unid =='') {
        $uuid = $this->genUnid();
    $action=  AreaTbl::insert([
        'unid'=> $uuid ,
        'area_index'=> $area_index,
        'area_name'=> $area_name,
        'area_owner'=> $area_owner,
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
}
