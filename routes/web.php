<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/products', CustomerProductController::class)->name('profile.edit');
    Route::resource('/orders', CustomerOrderController::class);
    Route::resource('/carts', CartController::class);
    Route::resource('/checkouts', CheckoutController::class);
    Route::resource('/payments', PaymentWebhookController::class);

});



//admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin')->group(function ()  {
    Route::resource('/products', AdminProductController::class);
    Route::resource('/categories', AdminOrderController::class);
    Route::resource('/orders', CategoryController::class);
});
require __DIR__.'/auth.php';
