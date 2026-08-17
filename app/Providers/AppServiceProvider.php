<?php

namespace App\Providers;

use App\Interfaces\CartInterface;
use App\Interfaces\CheckoutInterface;
use App\Repositories\CartRepository;
use App\Repositories\CheckoutRepository;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            CartInterface::class,
            CartRepository::class
        );

        $this->app->bind(
            CheckoutInterface::class,
            CheckoutRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
    }
}
