<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Cookie;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use App\Models\UserTbl;
use App\Models\AreaTbl;
// use App\Models\GroupsTbl;
// use App\Models\AuditpositionTbl;
use App\Models\AuditorTbl;
use App\Models\AuditAreaTbl;
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
    $User =UserTbl::orderBy('user_login')->orderBy('user_name')->paginate($this->paging);
   return view('pages.user_index',compact('User','search'));
 }

 public function profile(Request $request){
     $USER_UNID = Cookie::get('USER_UNID') ; // Cookie::queue('USER_UNID',$row->unid);
     if($USER_UNID !=''){
       $User =UserTbl::where('unid','=',$USER_UNID)->first();
      return view('pages.user_profile',compact('User'));
     }
   return redirect('/check');
 }

 public function viewpwd(Request $request){
     $USER_UNID = Cookie::get('USER_UNID') ; // Cookie::queue('USER_UNID',$row->unid);
     if($USER_UNID !=''){
       $User =UserTbl::where('unid','=',$USER_UNID)->first();
      return view('pages.user_changepwd',compact('User'));
     }
   return redirect('/check');
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

 public function editbyunid(Request $request){

   $user_unid =isset($request->unid) ? $request->unid :'';
   $user_login =isset($request->user_login) ? $request->user_login :'';
   $user_name =isset($request->user_name) ? $request->user_name :'';


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


     return  redirect()->back();;

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

 public function changepwd(Request $request){
   $user_unid =isset($request->unid) ? $request->unid :'';
   $user_password =isset($request->new_password) ? $request->new_password :'';
   $user_password=Hash::make($user_password);
   $count =UserTbl::where('unid','=',$user_unid)->count();

    $username= Cookie::get('USER_NAME');
    $username= $username !='' ? $username :'5s';
    $action=false;

    if($count > 0 && $user_password !='' ){
        $action=  UserTbl::where('unid','=',$user_unid)->update([
          'user_password' => $user_password
          ,'user_status' => 'Y'
          ,'edit_by' => $username
          ,'edit_time' => Carbon::now()->format('Y-m-d')
         ]);

    }

    if($action){
       return  redirect('/logout') ;
    }else {
       return  redirect()->back()->with('error', 'Data error') ;
    }


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
               'user_login.required'    => '???????????????????????? User Name',
               'user_password.required' => '???????????????????????? Password',
               'user_password.min'      => '???????????????????????????????????????????????? 6 ????????????????????????',
           ]
       );

    $user_login     =isset($request->user_login) ? $request->user_login :'';
    $user_password  =isset($request->user_password) ? $request->user_password :'';

    if($user_login==''){
      return back();
    }
    $countUser = UserTbl::where('user_login','=',$user_login)->where('user_status','=','Y')->count();

    if($countUser==0){
        return back()->with('login','????????????????????????????????????????????????????????????');
    }

      //$check_password=Hash::make($user_password);
      $User = UserTbl::where('user_login','=',$user_login)
      //->where('user_password','=',$check_password)
      ->where('user_status','=','Y')->get();
      foreach ($User as $key => $row) {
           $login  =Hash::check($user_password,$row->user_password);
           if ($login) {
              // Cookie::queue('USER_UNID',$row->unid ,0, null, 'p-quality.com');
              $USER_UNID =$row->unid;
               Cookie::queue('USER_UNID',$row->unid);
               Cookie::queue('USER_LOGIN',$row->user_login );
               Cookie::queue('USER_NAME',$row->user_name);
               Cookie::queue('USER_LEVEL',$row->user_level);

               return redirect()->route('check.index');
               // return view('/check')->with('USER_UNID',$USER_UNID);
           }
      }
      return back()->with('login','??????????????????????????????????????????????????????');

     // $login  =Hash::check($user_password,$User->user_password);
     //
     //  if ($login) {
     //
     //      Cookie::queue('USER_UNID',$User->unid ,0, null, 'p-quality.com');
     //      Cookie::queue('USER_ID',$User->user_login ,0, null, 'p-quality.com');
     //      Cookie::queue('USER_NAME',$User->user_name,0, null, 'p-quality.com');
     //      Cookie::queue('USER_LEVEL',$User->user_level,0, null, 'p-quality.com');
     //
     //
     //      return view('pages.check_index');
     //  } else {
     //      return back()->with('login','??????????????????????????????????????????????????????');
     //  }
 }


 public function login(Request $request){
     return view('pages.user_login');
 }
 public function logout(Request $request){

    Cookie::queue(Cookie::forget('USER_UNID'));
    Cookie::queue(Cookie::forget('USER_LOGIN'));
    Cookie::queue(Cookie::forget('USER_NAME'));
    Cookie::queue(Cookie::forget('USER_LEVEL'));
    Cookie::queue(Cookie::forget('DOC_PV'));
    Cookie::queue(Cookie::forget('DOC_YEAR'));
    Cookie::queue(Cookie::forget('USER_LEVEL'));

     return view('pages.user_login');
 }

}
