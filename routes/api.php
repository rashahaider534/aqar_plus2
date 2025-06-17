<?php

use App\Http\Controllers\AuthController;
<<<<<<< HEAD
use App\Http\Controllers\UserController;
=======
use App\Http\Controllers\BookingController;
>>>>>>> 84eefa064ecf3d255c965eb52089eafd32eb87e5
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('user/register',[AuthController::class,'register_user']);
//login
Route::post('/user/login',[AuthController::class,'login_user']);
Route::post('/Admin/login',[AuthController::class,'login_admin']);
Route::post('/Super_Admin/login',[AuthController::class,'login_admin']);


//user
Route::prefix('user')->middleware(['auth:sanctum','CheckUser'])->group(function () {
Route::post('booking',[BookingController::class,'booking']);
Route::post('booking/cancel',[BookingController::class,'cancelBooking']);
Route::post('logout',[AuthController::class,'logout']);
<<<<<<< HEAD
  Route::post('checkcode',[AuthController::class,'checkcode']);
  Route::get('showprofile',[UserController::class,'showprofile']);
=======
Route::post('checkcode',[AuthController::class,'checkcode']);  

>>>>>>> 84eefa064ecf3d255c965eb52089eafd32eb87e5
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















Route::post('logout',[AuthController::class,'logout'])->middleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware(['auth:sanctum','CheckAdmin']);
