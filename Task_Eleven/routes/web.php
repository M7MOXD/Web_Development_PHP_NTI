<?php

use App\Http\Controllers\personController;
use App\Http\Controllers\taskController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::middleware('auth')->group(function(){
Route::get('person', [personController::class, 'index']);
Route::get('person/{id}/edit', [personController::class, 'edit']);
Route::post('person/{id}/update', [personController::class, 'update']);
Route::get('person/{id}/delete', [personController::class, 'destroy']);

Route::get('task', [taskController::class, 'index']);
Route::get('task/{id}/edit', [taskController::class, 'edit']);
Route::post('task/{id}/update', [taskController::class, 'update']);
Route::get('task/{id}/delete', [taskController::class, 'destroy']);
Route::get('task/create', [taskController::class, 'create']);
Route::post('task', [taskController::class, 'store']);
});

Route::get('person/create', [personController::class, 'create']);
Route::post('person', [personController::class, 'store']);
Route::get('login', [personController::class, 'login'])->name('login');
Route::post('loging', [personController::class, 'loging']);
