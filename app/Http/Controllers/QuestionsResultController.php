<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Cookie;
use DB;
use Illuminate\Support\Str;
use App\Models\AreaTbl;
use App\Models\QuestionsTbl;
use App\Models\QuestionspositionTbl;
use App\Models\QuestionsAreaTbl;
use App\Models\QuestionsItemTbl;
use App\Models\PositionsTbl;


class QuestionsResultController extends Controller
{

  protected  $paging =10;

  public function genUnid(){
    $uuid = (string) Str::uuid();
   $uuid = str_replace("-","",$uuid);
    return $uuid;
  }

  public function getnext(Request $request){

    return response()->json(['result'=> 'success','data'=> $request ],200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);

  }

}
