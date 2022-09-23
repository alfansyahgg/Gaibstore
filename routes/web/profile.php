<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::prefix('profile')->group(function(){
        Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('purchase', [ProfileController::class, 'purchase'])->name('profile.purchase');
        Route::get('purchase-detail/{order}', [ProfileController::class, 'purchaseDetail'])->name('profile.purchase-detail');
        Route::get('account', [ProfileController::class, 'account'])->name('profile.account');
        Route::put('update-account/{user}', [ProfileController::class, 'updateAccount'])->name('profile.update-account');
        Route::put('/{profile}', [ProfileController::class, 'update'])->name('profile.update');
    });
});