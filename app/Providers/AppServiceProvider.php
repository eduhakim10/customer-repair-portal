<?php

namespace App\Providers;

use App\Auth\PortalUserProvider;
use App\Services\WorkshopApi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(WorkshopApi::class, fn () => new WorkshopApi());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Auth::provider('portal', fn () => new PortalUserProvider());
    }
}
