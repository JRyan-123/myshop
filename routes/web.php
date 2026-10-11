<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CategoryController;


use App\Http\Controllers\ProductController as CustomerProductController;
use App\Http\Controllers\OrderController as CustomerOrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentWebhookController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


// public routes
Route::get('/', [HomeController::class, 'index']);
Route::resource('/products', CustomerProductController::class);
Route::get('/checkout/success', [CustomerOrderController::class, 'success'])->name('checkout.success');
Route::get('/checkout/cancel', [CustomerOrderController::class, 'cancel'])->name('checkout.cancel');


//customers
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/orders', CustomerOrderController::class)->only(['index', 'show', 'store']);
    Route::resource('/carts', CartController::class)->only(['index', 'store']);
    Route::resource('/cart-items', CartItemController::class)->only(['update', 'destroy']);
    Route::resource('/checkout', CheckoutController::class)->only('index');
    Route::resource('/payments', PaymentWebhookController::class);

});



//admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function ()  {
    Route::resource('/',AdminController::class)->only('index');
    Route::resource('/products', AdminProductController::class)->except(['show']);
    Route::resource('/categories', CategoryController::class)->except(['show']);
    Route::resource('/orders', AdminOrderController::class)->only(['index', 'show', 'update']);
});


require __DIR__.'/auth.php';
