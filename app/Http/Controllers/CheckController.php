<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Str;
use App\Models\AreaTbl;


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
  //  $unid= isset($request->unid) ? $request->unid :'';
  //  $dataArea =AreaTbl::where('unid','=',$unid)->first();
  //  return response()->json(['result'=> 'success','data'=> $dataArea],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
    $html ='';
    for ($monthNum = 1; $monthNum <= 12; $monthNum++) {

      $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));

      $html .=' <div class="col-sm-3">
                  <div class="alert bg-white ">
                      <a class="btn btn-success btn-block color-'.$monthNum.'" data-munth="'.$monthNum.'" href="#" target="_blank"><h2>'.$monthNum.'. '.  $monthName.'</h2></a>

                   </div>
               </div>';
  }




  return view('pages.check_yearmonth',compact('html'));
  }



  public function get(Request $request){
    $unid= isset($request->unid) ? $request->unid :'';
    $dataArea =AreaTbl::where('unid','=',$unid)->first();
    return response()->json(['result'=> 'success','data'=> $dataArea],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);

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
