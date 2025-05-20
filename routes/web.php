<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

//admin
Route::middleware(['auth:sanctum'])->group(function () {

Route::get('/', function () {
    return view('welcome');
});
});

//user
Route::middleware(['auth:sanctum','CheckUser'])->group(function () {

});
//seller
Route::middleware(['auth:sanctum','CheckSeller'])->group(function () {

});
