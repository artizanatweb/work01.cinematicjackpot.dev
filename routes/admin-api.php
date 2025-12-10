<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;

Route::post('login', [AuthController::class, 'login'])
//    ->middleware('web')
    ->name('login');

Route::middleware(['auth:sanctum', 'admin.user'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);
});
