<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentCallbackController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

# welcome
Route::get('/', [WelcomeController::class, 'index'])->name('welcome.index');
Route::get('about', [WelcomeController::class, 'about'])->name('welcome.about');
Route::get('shop', [WelcomeController::class, 'shop'])->name('welcome.shop');
Route::get('contact', [WelcomeController::class, 'contact'])->name('welcome.contact');

# product
Route::get('product/{product}', [WelcomeController::class, 'detail'])->name('welcome.detail');
Route::post('product/add-to-cart', [WelcomeController::class, 'addToCart'])->name('welcome.add-to-cart');
Route::post('product/delete-from-cart', [WelcomeController::class, 'deleteFromCart'])->name('welcome.delete-from-cart');

# checkout
Route::middleware(['auth'])->group(function(){
    Route::prefix('checkout')->group(function(){
        Route::match(['get', 'post'], '/', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('order', [CheckoutController::class, 'order'])->name('checkout.order');
        Route::delete('remove-order/{order}', [CheckoutController::class, 'removeOrder'])->name('checkout.remove-order');
        Route::post('cost', [CheckoutController::class, 'cost'])->name('checkout.cost');
    });
});

# payment
Route::post('payments/midtrans-notification', [PaymentCallbackController::class, 'receive']);

# Auth
require base_path('routes/web/auth.php');
# Dashboard
require base_path('routes/web/dashboard.php');
# Profile
require base_path('routes/web/profile.php');