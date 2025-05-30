<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\Service\ServiceController;
use App\Http\Controllers\ServiceProviderAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::controller(UserAuthController::class)->group(function () {
    Route::post('user/register', 'register')->name('user.register');
    Route::post('user/login', 'login')->name('user.login');
    Route::post('user/logout', 'logout')->name('user.logout');
});
Route::controller(AdminAuthController::class)->group(function () {
    Route::post('admin/register', 'register')->name('admin.register');
    Route::post('admin/login', 'login')->name('admin.login');
    Route::post('admin/logout', 'logout')->name('admin.logout');
});
Route::controller(ServiceProviderAuthController::class)->group(function () {
    Route::post('provider/register', 'register')->name('provider.register');
    Route::post('provider/login', 'login')->name('provider.login');
    Route::post('provider/logout', 'logout')->name('provider.logout');
});
Route::controller(ServiceController::class)->group(function(){
    Route::get('services', 'index')->name('all.services');
    Route::get('services/{id}', 'show')->name('subservices');
    Route::get('services/{id}/providers', 'getProvidersByService')->name('services.providers');
});