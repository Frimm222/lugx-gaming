<?php

namespace App\Providers;

use App\Services\CartService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // ...
        View::composer('*', function ($view) {
            $view->with('user', auth()->user());
        });
        $this->app->singleton(CartService::class);
    }
}
