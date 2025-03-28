<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\UserAuthController;
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