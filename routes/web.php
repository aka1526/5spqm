<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\AuditorController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\CheckController;
use App\Http\Controllers\QuestionsResultController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    //return view('pages.check_index');
    $year=date('Y');
    $month=date('n');
    return redirect('/report/byarea?year='.$year.'&month='.$month );
});

Route::get('/plan',       [PlanController::class,'index'])->name('plan.index');
Route::post('/plan/add',  [PlanController::class,'add'])->name('plan.add');
Route::post('/plan/edit', [PlanController::class,'edit'])->name('plan.edit');
Route::post('/plan/editfield', [PlanController::class,'editfield'])->name('plan.editfield');
Route::get('/plan/get',   [PlanController::class,'get'])->name('plan.get');

Route::get('/area',       [AreaController::class,'index'])->name('area.index');
Route::post('/area/add',  [AreaController::class,'add'])->name('area.add');
Route::post('/area/edit', [AreaController::class,'edit'])->name('area.edit');
Route::post('/area/delete', [AreaController::class,'delete'])->name('area.delete');
Route::post('/area/editfield', [AreaController::class,'editfield'])->name('area.editfield');
Route::get('/area/get',   [AreaController::class,'get'])->name('area.get');


Route::get('/auditor',            [AuditorController::class,'index'])->name('auditor.index');
Route::post('/auditor/add',       [AuditorController::class,'add'])->name('auditor.add');
Route::post('/auditor/edit',      [AuditorController::class,'edit'])->name('auditor.edit');
Route::post('/auditor/delete',    [AuditorController::class,'delete'])->name('auditor.delete');
Route::post('/auditor/editfield', [AuditorController::class,'editfield'])->name('auditor.editfield');
Route::get('/auditor/get',        [AuditorController::class,'get'])->name('auditor.get');

Route::get('/auditor/{unid}',     [AuditorController::class,'memberindex'])->name('auditor.member.index');
Route::get('/auditor/member/get',        [AuditorController::class,'memberget'])->name('auditor.member.get');
Route::post('/auditor/member/add',     [AuditorController::class,'memberadd'])->name('auditor.member.add');
Route::post('/auditor/member/edit',  [AuditorController::class,'memberedit'])->name('auditor.member.edit');
Route::post('/auditor/member/delete',  [AuditorController::class,'memberdelete'])->name('auditor.member.delete');
Route::post('/auditor/member/addauditarea',     [AuditorController::class,'addauditarea'])->name('auditor.member.addauditarea');


Route::get('/plan',            [PlanController::class,'index'])->name('plan.index');
Route::get('/plan/get',        [PlanController::class,'get'])->name('plan.get');
Route::post('/plan/add',       [PlanController::class,'add'])->name('plan.add');
Route::post('/plan/edit',      [PlanController::class,'edit'])->name('plan.edit');
Route::post('/plan/delete',    [PlanController::class,'delete'])->name('plan.delete');
Route::post('/plan/editfield', [PlanController::class,'editfield'])->name('plan.editfield');

Route::post('/planmaster/updatefield',      [PlanController::class,'planmasterupdatefield'])->name('planmaster.updatefield');
Route::post('/planmaster/createplan',      [PlanController::class,'planmastercreateplan'])->name('planmaster.createplan');



Route::get('/dashboard',            [DashboardController::class,'index'])->name('dashboard.index');
Route::post('/dashboard/add',       [DashboardController::class,'add'])->name('dashboard.add');
Route::post('/dashboard/edit',      [DashboardController::class,'edit'])->name('dashboard.edit');
Route::post('/dashboard/delete',    [DashboardController::class,'delete'])->name('dashboard.delete');
Route::post('/dashboard/editfield', [DashboardController::class,'editfield'])->name('dashboard.editfield');
Route::get('/dashboard/get',        [DashboardController::class,'get'])->name('dashboard.get');


Route::get('/questions',            [QuestionsController::class,'index'])->name('questions.index');
Route::get('/questions/get',        [QuestionsController::class,'get'])->name('questions.get');
Route::post('/questions/add',       [QuestionsController::class,'add'])->name('questions.add');
Route::get('/questions/edit/{unid}',      [QuestionsController::class,'editunid'])->name('questions.editunid');
Route::post('/questions/edit',      [QuestionsController::class,'edit'])->name('questions.edit');
Route::post('/questions/delete',    [QuestionsController::class,'delete'])->name('questions.delete');
Route::post('/questions/editfield', [QuestionsController::class,'editfield'])->name('questions.editfield');


Route::post('/questions/additem',       [QuestionsController::class,'additem'])->name('questions.additem');
Route::get('/questions/getitem',        [QuestionsController::class,'getitem'])->name('questions.getitem');
Route::post('/questions/edititem',      [QuestionsController::class,'edititem'])->name('questions.edititem');
Route::post('/questions/deleteitem',      [QuestionsController::class,'deleteitem'])->name('questions.deleteitem');


Route::get('/check',            [CheckController::class,'index'])->name('check.index');
Route::get('/check/yearmonth',    [CheckController::class,'yearmonth'])->name('check.yearmonth');
Route::get('/check/get/{pv?}/{year?}/{month?}',        [CheckController::class,'get'])->name('check.get');

Route::post('/check/add',       [CheckController::class,'add'])->name('check.add');
Route::get('/check/edit/{unid}',[CheckController::class,'editunid'])->name('check.editunid');
Route::post('/check/edit',      [CheckController::class,'edit'])->name('check.edit');
Route::post('/check/delete',    [CheckController::class,'delete'])->name('check.delete');
Route::post('/check/editfield', [CheckController::class,'editfield'])->name('check.editfield');
Route::post('/check/checked', [CheckController::class,'checked'])->name('check.checked');


Route::post('/result/getnext', [QuestionsResultController::class,'getnext'])->name('result.getnext');
Route::post('/result/getback', [QuestionsResultController::class,'getback'])->name('result.getback');
Route::post('/result/score', [QuestionsResultController::class,'scoresave'])->name('result.scoresave');
Route::post('/result/commentsave', [QuestionsResultController::class,'commentsave'])->name('result.commentsave');
Route::post('/result/final', [QuestionsResultController::class,'final'])->name('result.final');
Route::post('/result/delete', [QuestionsResultController::class,'delete'])->name('result.delete');
Route::get('/report/byarea', [QuestionsResultController::class,'reportbyarea'])->name('report.byarea');


Route::get('/user',            [UserController::class,'index'])->name('user.index');
Route::get('/user/get',        [UserController::class,'get'])->name('user.get');
Route::post('/user/add',       [UserController::class,'add'])->name('user.add');
Route::post('/user/edit',      [UserController::class,'edit'])->name('user.edit');
Route::post('/user/pwd',       [UserController::class,'pwd'])->name('user.pwd');
Route::post('/user/delete',    [UserController::class,'delete'])->name('user.delete');
Route::post('/user/editfield', [UserController::class,'editfield'])->name('user.editfield');
Route::get('/user/profile',    [UserController::class,'profile'])->name('user.profile');
Route::post('/user/editbyunid',      [UserController::class,'editbyunid'])->name('user.editbyunid');
Route::get('/user/viewpwd',    [UserController::class,'viewpwd'])->name('user.viewpwd');
Route::post('/user/changepwd',       [UserController::class,'changepwd'])->name('user.changepwd');


Route::post('/login', [UserController::class,'login'])->name('user.login');
Route::get('/logout', [UserController::class,'logout'])->name('user.logout');
Route::post('/login/check', [UserController::class,'login_check'])->name('user.login_check');
