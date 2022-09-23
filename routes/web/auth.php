<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function(){
    Route::prefix('auth')->group(function () {
        Route::post('/', [AuthController::class, 'auth'])->name('auth.access');
        Route::get('login', [AuthController::class, 'index'])->name('auth.login');
        Route::get('register', [AuthController::class, 'register'])->name('auth.register');
        Route::post('regist', [AuthController::class, 'regist'])->name('auth.regist');
    });
});
Route::prefix('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth');
});