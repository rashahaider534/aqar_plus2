<?php

use App\Http\Controllers\Admin\PropertyController as AdminPropertyController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProvincesController;
use App\Http\Controllers\RentalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('user/register', [AuthController::class, 'register_user']);
//login
Route::post('/user/login', [AuthController::class, 'login_user']);
Route::post('/Admin/login', [AuthController::class, 'login_admin']);
Route::post('/Super_Admin/login', [AuthController::class, 'login_admin']);

//not token
Route::post('filter/properties', [PropertyController::class, 'filter']);
Route::post('property_details', [PropertyController::class, 'property_details']);

//user
Route::prefix('user')->middleware(['auth:sanctum', 'CheckUser'])->group(function () {
    Route::get('notification', [NotificationController::class, 'unread_user']);
    Route::post('refresh/code', [AuthController::class, 'ref_code']);
    Route::post('renting', [RentalController::class, 'renting']);
    Route::post('filter/properties', [PropertyController::class, 'filter_user']);
    Route::post('add/rating', [PropertyController::class, 'addRating']);
    Route::get('properties', [PropertyController::class, 'user_properties']);
    Route::post('addfavorite', [FavoriteController::class, 'favorite']);
    Route::post('booking', [BookingController::class, 'booking']);
    Route::post('booking/cancel', [BookingController::class, 'cancelBooking']);
    Route::post('booking/buy', [BookingController::class, 'completeBooking']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('showprofile', [UserController::class, 'showprofile']);
    Route::post('checkcode', [AuthController::class, 'checkcode']);
    Route::get('showprofile', [UserController::class, 'showprofile']);
    Route::post('checkcode', [AuthController::class, 'checkcode']);
    Route::post('buy', [PurchaseController::class, 'Purchase']);
    Route::post('update/profilephoto', [UserController::class, 'updatephoto']);
    Route::post('Charge_balance', [UserController::class, 'Charge_balance']);
    Route::get('showfavorite', [FavoriteController::class, 'index']);
    Route::post('deletefavorite', [FavoriteController::class, 'deletefavorite']);
    Route::post('property_details', [PropertyController::class, 'property_details']);
    Route::get('show_purchases', [PurchaseController::class, 'show_purchases']);
    Route::get('show_booking', [BookingController::class, 'show_booking']);
    Route::get('show_rental', [BookingController::class, 'show_rental']);
    Route::get('requset_beseller',[UserController::class,'requset_beseller']);
});
//seller
Route::prefix('seller')->middleware(['auth:sanctum', 'CheckSeller'])->group(function () {
     Route::get('notification', [NotificationController::class, 'unread_user']);
    Route::post('refresh/code', [AuthController::class, 'ref_code']);
    Route::post('renting', [RentalController::class, 'renting']);
    Route::post('filter/properties', [PropertyController::class, 'filter_seller']);
    Route::post('add/rating', [PropertyController::class, 'addRating']);
    Route::post('add/property', [PropertyController::class, 'addProperty']);
    Route::get('waiting', [PropertyController::class, 'sellerWaiting']);
    Route::get('rented', [PropertyController::class, 'sellerRented']);
    Route::get('booked', [PropertyController::class, 'sellerBooked']);
    Route::get('solded', [PropertyController::class, 'sellerSolded']);
    Route::post('addfavorite', [FavoriteController::class, 'favorite']);
    Route::post('booking', [BookingController::class, 'booking']);
    Route::post('booking/cancel', [BookingController::class, 'cancelBooking']);
    Route::post('booking/buy', [BookingController::class, 'completeBooking']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('checkcode', [AuthController::class, 'checkcode']);
    Route::post('buy', [PurchaseController::class, 'Purchase']);
    Route::post('update/profilephoto', [UserController::class, 'updatephoto']);
    Route::post('Charge_balance', [UserController::class, 'Charge_balance']);
    Route::get('showfavorite', [FavoriteController::class, 'index']);
    Route::post('deletefavorite', [FavoriteController::class, 'deletefavorite']);
    Route::get('show_rejecte_property', [PropertyController::class, 'show_rejecte_property']);
    Route::get('show_approve_property', [PropertyController::class, 'show_approve_property']);
    Route::post('deleteproperty', [PropertyController::class, 'destroy']);
    Route::post('property_details', [PropertyController::class, 'property_details']);
    Route::get('show_purchases', [PurchaseController::class, 'show_purchases']);
    Route::get('show_booking', [BookingController::class, 'show_booking']);
    Route::get('show_rental', [BookingController::class, 'show_rental']);
    Route::post('update_price', [PropertyController::class, 'update_price']);

});
//Admin
Route::prefix('Admin')->middleware(['auth:sanctum', 'CheckAdmin'])->group(function () {
     Route::get('notification', [NotificationController::class, 'unread_admin']);
    Route::post('request/maintenance', [MaintenanceController::class, 'fixCost']);
    Route::post('approve/seller', [UserController::class, 'approveAccountSeller']);
    Route::get('account/sellers', [UserController::class, 'pendingSellers']);
    Route::post('block/seller', [UserController::class, 'Block']);
    Route::post('approve', [PropertyController::class, 'approve_property']);
    Route::post('reject', [PropertyController::class, 'reject_property']);
    Route::post('/search/users', [UserController::class, 'searchUser']);
    Route::get('wait/properties', [PropertyController::class, 'waitProperties']);
    Route::post('filter/properties', [PropertyController::class, 'filter_admin']);
    Route::get('properties', [\App\Http\Controllers\Admin\PropertyController::class, 'properties']);
    Route::post('property_details', [\App\Http\Controllers\Admin\PropertyController::class, 'property_details']);
    Route::post('property_archive', [\App\Http\Controllers\Admin\PropertyController::class, 'destroy']);
    Route::get('show_archiveproperties', [\App\Http\Controllers\Admin\PropertyController::class, 'show_archived']);
    Route::get('show_Maintenance_Requests', [MaintenanceController::class, 'show_Maintenance_Requests']);
    Route::post('details_maintenance_requests', [MaintenanceController::class, 'details_maintenance_requests']);
    Route::post('logout', [AuthController::class, 'logout']);
});
//SuperAdmin
Route::prefix('SuperAdmin')->middleware(['auth:sanctum', 'CheckSuperAdmin'])->group(function () {
     Route::get('notification', [NotificationController::class, 'unread_admin']);
    Route::post('add/admin', [\App\Http\Controllers\Admin\AdminController::class, 'addAdmin']);
    Route::post('search/admin', [\App\Http\Controllers\Admin\AdminController::class, 'searchAdmin']);
    Route::post('/property-status-percentages', [PropertyController::class, 'getPropertyStatusReport']);
    Route::post('profits_by_month', [PropertyController::class, 'profitsByMonth']);
    Route::post('/search/users', [UserController::class, 'searchUser']);
    Route::post('filter/properties', [PropertyController::class, 'filter_seller']);
    Route::get('show_users_accounts', [UserController::class, 'show_users_accounts']);
    Route::get('count_users_accounts', [UserController::class, 'count_users_accounts']);
    Route::get('show_sellers_accounts', [UserController::class, 'show_sellers_accounts']);
    Route::get('count_sellers_accounts', [UserController::class, 'count_sellers_accounts']);
    Route::get('show_admins_accounts', [\App\Http\Controllers\Admin\AdminController::class, 'show_admins_accounts']);
    Route::get('count_admins_accounts', [\App\Http\Controllers\Admin\AdminController::class, 'count_admins_accounts']);
    Route::post('destroy_admin', [\App\Http\Controllers\Admin\AdminController::class, 'destroy_admin']);
    Route::get('properties', [\App\Http\Controllers\Admin\PropertyController::class, 'properties']);
    Route::post('property_details', [\App\Http\Controllers\Admin\PropertyController::class, 'property_details']);
    Route::get('show_archiveproperties', [\App\Http\Controllers\Admin\PropertyController::class, 'show_archived']);
    Route::get('properties', [\App\Http\Controllers\Admin\PropertyController::class, 'properties']);
    Route::get('properties_purchase_rental_booking', [\App\Http\Controllers\Admin\PropertyController::class, 'properties_purchase_rental_booking']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware(['auth:sanctum', 'CheckAdmin']);
