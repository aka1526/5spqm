<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\AuditorController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\DashboardController;

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



Route::get('/dashboard',            [DashboardController::class,'index'])->name('dashboard.index');
Route::post('/dashboard/add',       [DashboardController::class,'add'])->name('dashboard.add');
Route::post('/dashboard/edit',      [DashboardController::class,'edit'])->name('dashboard.edit');
Route::post('/dashboard/delete',    [DashboardController::class,'delete'])->name('dashboard.delete');
Route::post('/dashboard/editfield', [DashboardController::class,'editfield'])->name('dashboard.editfield');
Route::get('/dashboard/get',        [DashboardController::class,'get'])->name('dashboard.get');
