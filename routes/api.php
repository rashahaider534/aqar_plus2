<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
    
//Route::post('register',[AuthController::class,'register_user']);
//Route::post('login',[AuthController::class,'login_user']);
//Route::post('login1',[AuthController::class,'login_admin']);
//user
Route::prefix('user')->middleware(['auth:sanctum','CheckUser'])->group(function () {
Route::post('logout',[AuthController::class,'logout']);
  //Route::post('checkcode',[AuthController::class,'checkcode']);  
});
//seller
Route::prefix('seller')->middleware(['auth:sanctum','CheckSeller'])->group(function () {
 Route::post('logout',[AuthController::class,'logout']);  
 //Route::post('checkcode',[AuthController::class,'checkcode']); 
});














Route::post('logout',[AuthController::class,'logout'])->middleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware(['auth:sanctum','CheckAdmin']);
