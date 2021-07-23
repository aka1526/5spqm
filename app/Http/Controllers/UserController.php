<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use App\Models\UserTbl;
// use App\Models\AreaTbl;
// use App\Models\GroupsTbl;
// use App\Models\AuditpositionTbl;
// use App\Models\AuditAreaTbl;
// use App\Models\PlanMasterTbl;
// use App\Models\PlanPositionTbl;

class UserController extends Controller
{

protected  $paging =10;

  public function genUnid(){
    $uuid = (string) Str::uuid();
    $uuid = str_replace("-","",$uuid);
    return $uuid;
}

 public function index(Request $request){
   $search='';
    $User =UserTbl::orderBy('user_name')->paginate($this->paging);
   return view('pages.user_index',compact('User','search'));
 }
 public function get(Request $request){
   $unid  =isset($request->unid) ? $request->unid :'';
   $user  =UserTbl::where('unid','=',$unid)->first();
   $action=false;
   if($user){  $action =true; }
     return response()->json(['result'=> $action,'data' => $user ],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
 }
 public function add(Request $request){
   $user_login =isset($request->user_login) ? $request->user_login :'';
   $user_name =isset($request->user_name) ? $request->user_name :'';
   $user_password =isset($request->user_password) ? $request->user_password :'';
   $user_password=Hash::make($user_password);
   $count =UserTbl::where('user_login','=',$user_login)->count();

    $username='s5';
    $action=false;
    $uuid = $this->genUnid();
    if($count==0){
      $action=  UserTbl::insert([
          'unid' => $uuid
          ,'user_login' => $user_login
          ,'user_name' => $user_name
          ,'user_password' => $user_password
          ,'user_status' => 'Y'
          ,'create_by' => $username
          ,'create_time' => Carbon::now()->format('Y-m-d')
          ,'edit_by' => $username
          ,'edit_time' => Carbon::now()->format('Y-m-d')
         ]);
    }


     return response()->json(['result'=> $action],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);


 }
 public function edit(Request $request){
   $user_unid =isset($request->unid) ? $request->unid :'';
   $user_login =isset($request->user_login) ? $request->user_login :'';
   $user_name =isset($request->user_name) ? $request->user_name :'';
   $user_password =isset($request->user_password) ? $request->user_password :'';
   $user_password=Hash::make($user_password);
   $count =UserTbl::where('unid','=',$user_unid)->count();

    $username='s5';
    $action=false;

    if($count > 0){
        $action=  UserTbl::where('unid','=',$user_unid)->update([
          'user_login' => $user_login
          ,'user_name' => $user_name
          ,'user_status' => 'Y'
          ,'edit_by' => $username
          ,'edit_time' => Carbon::now()->format('Y-m-d')
         ]);
    }


     return response()->json(['result'=> $action],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);

 }

 public function delete(Request $request){
   $unid  =isset($request->unid) ? $request->unid :'';
   $count  =UserTbl::where('unid','=',$unid)->count();
   $action=false;
   if($count>0){
        $action=  UserTbl::where('unid','=',$unid)->delete();
   }

     return response()->json(['result'=> $action  ],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
 }


 public function pwd(Request $request){
   $user_unid =isset($request->unid) ? $request->unid :'';
   $user_password =isset($request->user_password) ? $request->user_password :'';
   $user_password=Hash::make($user_password);
   $count =UserTbl::where('unid','=',$user_unid)->count();

    $username='s5';
    $action=false;

    if($count > 0){
        $action=  UserTbl::where('unid','=',$user_unid)->update([
          'user_password' => $user_password
          ,'user_status' => 'Y'
          ,'edit_by' => $username
          ,'edit_time' => Carbon::now()->format('Y-m-d')
         ]);
    }


     return response()->json(['result'=> $action],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);

 }


 public function editfield(Request $request){

 }

 public function login_check(Request $request){

   $this->validate(
           $request,
           [
               'user_login'             => 'required',
               'user_password'          => 'required|min:6'
           ],
           [
               'user_login.required'    => 'กรุณาใส่ User Name',
               'user_password.required' => 'กรุณาใส่ Password',
               'user_password.min'      => 'รหัสผ่านน้อยกว่า 6 ตัวอักษร',
           ]
       );

    $user_login     =isset($request->user_login) ? $request->user_login :'';
    $user_password  =isset($request->user_password) ? $request->user_password :'';

    if($user_login==''){
      return back();
    }
    $countUser = UserTbl::where('user_login','=',$user_login)->where('user_status','=','Y')->count();

    if($countUser==0){
        return back()->with('login','ไม่พบข้อมูลผู้ใช้งาน');
    }

 }



}
