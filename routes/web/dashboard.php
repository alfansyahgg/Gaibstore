<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('dashboard')->group(function(){
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('product', ProductController::class);
        Route::resource('category', CategoryController::class);
        Route::resource('user', UserController::class);
        Route::resource('order', OrderController::class);
        // transaction
        Route::prefix('trans')->group(function(){
            Route::prefix('destroy')->group(function () {
                Route::delete('products', [ProductController::class, 'destroyProducts'])->name('product.mass-destroy');
                Route::delete('categories', [CategoryController::class, 'destroyCategories'])->name('category.mass-destroy');
                Route::delete('users', [UserController::class, 'destroyUsers'])->name('user.mass-destroy');
                Route::delete('orders', [UserController::class, 'destroyOrders'])->name('order.mass-destroy');
            });
        });
    });
});