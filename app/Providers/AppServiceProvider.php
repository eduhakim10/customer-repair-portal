<?php

namespace App\Providers;

use App\Auth\PortalUserProvider;
use App\Services\WorkshopApi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
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

        // Livewire signed upload URLs follow APP_URL. Force https when APP_URL is https
        // so mixed-content does not block file uploads behind TLS termination.
        if (str_starts_with((string) config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }
    }
}
