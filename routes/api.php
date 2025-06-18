<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PropertyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('user/register',[AuthController::class,'register_user']);
//login
Route::post('/user/login',[AuthController::class,'login_user']);
Route::post('/Admin/login',[AuthController::class,'login_admin']);
Route::post('/Super_Admin/login',[AuthController::class,'login_admin']);

//not token
Route::get('properties',[PropertyController::class,'properties']);
Route::post('filter/name',[PropertyController::class,'filter_name']);
Route::post('filter/province',[PropertyController::class,'filter_province']);
Route::post('filter/price',[PropertyController::class,'filter_price']);
Route::post('filter/room',[PropertyController::class,'filter_room']);
Route::post('filter/area',[PropertyController::class,'filter_area']);
Route::post('filter/type',[PropertyController::class,'filter_type']);
//user
Route::prefix('user')->middleware(['auth:sanctum','CheckUser'])->group(function () {
Route::get('properties',[PropertyController::class,'user_properties']);
Route::post('filter/area',[PropertyController::class,'filter_area_user']);
Route::post('filter/type',[PropertyController::class,'filter_type_user']);
Route::post('filter/price',[PropertyController::class,'filter_price_user']);
Route::post('filter/province',[PropertyController::class,'filter_province_user']);
Route::post('filter/room',[PropertyController::class,'filter_room_user']);
Route::post('filter/name',[PropertyController::class,'filter_name_user']);
Route::post('booking',[BookingController::class,'booking']);
Route::post('booking/cancel',[BookingController::class,'cancelBooking']);
Route::post('logout',[AuthController::class,'logout']);
Route::get('showprofile',[UserController::class,'showprofile']);
Route::post('checkcode',[AuthController::class,'checkcode']);
Route::get('showprofile',[UserController::class,'showprofile']);
Route::post('checkcode',[AuthController::class,'checkcode']);
Route::post('buy',[PurchaseController::class,'Purchase']);
Route::post('update/profilephoto',[UserController::class,'updatephoto']);
});
//seller
Route::prefix('seller')->middleware(['auth:sanctum','CheckSeller'])->group(function () {
Route::post('filter/area',[PropertyController::class,'filter_area_seller']);
Route::post('filter/type',[PropertyController::class,'filter_type_seller']);
Route::post('filter/price',[PropertyController::class,'filter_price_seller']);
Route::post('filter/province',[PropertyController::class,'filter_province_seller']);
Route::post('filter/room',[PropertyController::class,'filter_room_seller']);
Route::post('filter/name',[PropertyController::class,'filter_name_seller']);
Route::get('properties',[PropertyController::class,'seller_properties']);
Route::post('logout',[AuthController::class,'logout']);
Route::post('checkcode',[AuthController::class,'checkcode']);
Route::post('buy',[PurchaseController::class,'Purchase']);
Route::post('update/profilephoto',[UserController::class,'updatephoto']);
});
//Admin
Route::prefix('Admin')->middleware(['auth:sanctum','CheckAdmin'])->group(function () {
Route::get('wait/properties',[PropertyController::class,'waitProperties']);
Route::post('filter/seller',[PropertyController::class,'filter_seller_Admin']);
Route::post('filter/name',[PropertyController::class,'filter_name_Admin']);
Route::post('filter/status',[PropertyController::class,'filter_status_Admin']);
Route::post('logout',[AuthController::class,'logout']);
});
//SuperAdmin
Route::prefix('SuperAdmin')->middleware(['auth:sanctum','CheckSuperAdmin'])->group(function () {
Route::post('filter/seller',[PropertyController::class,'filter_seller_Admin']);
Route::post('filter/name',[PropertyController::class,'filter_name_Admin']);
Route::post('filter/status',[PropertyController::class,'filter_status_Admin']);
Route::post('logout',[AuthController::class,'logout']);
});














Route::post('logout',[AuthController::class,'logout'])->middleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware(['auth:sanctum','CheckAdmin']);
