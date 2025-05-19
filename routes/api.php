<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
    
Route::post('user/register',[AuthController::class,'register_user']);
Route::post('seller/register',[AuthController::class,'register_seller']);

Route::post('/user/login',[AuthController::class,'login_user']);
Route::post('/seller/login',[AuthController::class,'login_user']);
Route::post('/Admin/login',[AuthController::class,'login_admin']);
Route::post('/Super_Admin/login',[AuthController::class,'login_admin']);
Route::post('/Maintenance/login',[AuthController::class,'login_admin']);


//user
Route::prefix('user')->middleware(['auth:sanctum','CheckUser'])->group(function () {
Route::post('logout',[AuthController::class,'logout']);
  Route::post('checkcode',[AuthController::class,'checkcode']);  
});
//seller
Route::prefix('seller')->middleware(['auth:sanctum','CheckSeller'])->group(function () {
 Route::post('logout',[AuthController::class,'logout']);  
 Route::post('checkcode',[AuthController::class,'checkcode']); 
});
//Admin
Route::prefix('Admin')->middleware(['auth:sanctum','CheckAdmin'])->group(function () {
Route::post('logout',[AuthController::class,'logout']);
});
//SuperAdmin
Route::prefix('SuperAdmin')->middleware(['auth:sanctum','CheckSuperAdmin'])->group(function () {
Route::post('logout',[AuthController::class,'logout']);
});
//Maintenance
Route::prefix('Maintenance')->middleware(['auth:sanctum','CheckMaintenance'])->group(function () {
Route::post('logout',[AuthController::class,'logout']);
});














Route::post('logout',[AuthController::class,'logout'])->middleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware(['auth:sanctum','CheckAdmin']);