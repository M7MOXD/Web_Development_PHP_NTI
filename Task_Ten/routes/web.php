<?php

use App\Http\Controllers\adminController;
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

Route::get('users', [adminController::class, 'index']);

Route::get('users/create', [adminController::class, 'create']);

Route::post('users/store', [adminController::class, 'store']);

Route::get('users/update/{id}', [adminController::class, 'update']);

Route::post('users/save/{id}', [adminController::class, 'save']);

Route::get('users/delete/{id}', [adminController::class, 'delete']);

Route::get('login', [adminController::class, 'login']);

Route::post('loging', [adminController::class, 'loging']);

Route::get('logout', [adminController::class, 'logout']);
