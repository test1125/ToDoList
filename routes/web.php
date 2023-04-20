<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//タスクCRUD
Route::get('/', [TaskController::class, 'index']);
Route::post('/store', [TaskController::class, 'store'])->name('store');
Route::post('/update', [TaskController::class, 'update'])->name('update');
Route::post('/destroy', [TaskController::class, 'destroy'])->name('update');

//ユーザー登録
Route::get('/register', [UserController::class, 'create']);
Route::post('/user/store', [UserController::class, 'store']);

//ログイン
Route::get('/login', [AuthController::class, 'showLoginForm']);
Route::post('/user/login', [AuthController::class, 'login']);

//ログアウト
Route::post('/logout', [AuthController::class, 'logout']);

// Route::post('/value', [TaskController::class, 'ShowValue']);
// Route::get('/login', fn() => view('login'));
// Route::get('/register', fn() => view('register'));