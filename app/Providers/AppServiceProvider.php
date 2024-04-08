<?php

namespace App\Providers;

use App\Classes\WarehouseTransaction;
use App\Classes\WarehouseTransactionsFactory;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(WarehouseTransactionsFactory::class, function ($app) {
            return new WarehouseTransactionsFactory();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
