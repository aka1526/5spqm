<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\AuditorController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\CheckController;
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
    return view('pages.index');
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
Route::get('/check/get',        [CheckController::class,'get'])->name('check.get');
Route::get('/check/yearmonth',    [CheckController::class,'yearmonth'])->name('check.yearmonth');

Route::post('/check/add',       [CheckController::class,'add'])->name('check.add');
Route::get('/check/edit/{unid}',[CheckController::class,'editunid'])->name('check.editunid');
Route::post('/check/edit',      [CheckController::class,'edit'])->name('check.edit');
Route::post('/check/delete',    [CheckController::class,'delete'])->name('check.delete');
Route::post('/check/editfield', [CheckController::class,'editfield'])->name('check.editfield');
