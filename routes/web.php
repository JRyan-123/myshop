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

Route::get('/', [HomeController::class, 'index']);

Route::get('/products', function () {
    return Inertia::render('Products/Index');
})->middleware(['auth', 'verified'])->name('products.index');


Route::resource('/products', CustomerProductController::class);

//customers
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/orders', CustomerOrderController::class);
    Route::resource('/carts', CartController::class);
    Route::resource('/cart-items', CartItemController::class);
    Route::resource('/checkout', CheckoutController::class);
    Route::resource('/payments', PaymentWebhookController::class);

});



//admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function ()  {
    Route::resource('/',AdminController::class);
    Route::resource('/products', AdminProductController::class);
    Route::resource('/categories', CategoryController::class);
    Route::resource('/orders', AdminOrderController::class);
});
require __DIR__.'/auth.php';
