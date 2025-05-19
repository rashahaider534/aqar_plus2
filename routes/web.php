<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


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
