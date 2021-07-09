<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\AreaController;

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
Route::post('/area/editfield', [AreaController::class,'editfield'])->name('area.editfield');
Route::get('/area/get',   [AreaController::class,'get'])->name('area.get');
