<?php

namespace App\Providers;

use App\Interfaces\Admin\DashboardInterface;
use App\Interfaces\Admin\ProductInterface;
use App\Interfaces\CartInterface;
use App\Interfaces\CheckoutInterface;
use App\Interfaces\OrderInterface;
use App\Repositories\Admin\DashboardRepository;
use App\Repositories\Admin\ProductRepository;
use App\Repositories\CartRepository;
use App\Repositories\CheckoutRepository;
use App\Repositories\OrderRepository;
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

        $this->app->bind(
            OrderInterface::class,
            OrderRepository::class,
        );

        //ADMIN
        $this->app->bind(
            DashboardInterface::class,
            DashboardRepository::class
        );

        $this->app->bind(
            ProductInterface::class,
            ProductRepository::class
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
