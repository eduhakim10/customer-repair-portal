<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class CustomerPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('customer')
            ->path('/')
            ->login(Login::class)
            ->authGuard('portal')
            ->brandName('MTI Customer Portal')
            ->brandLogo(fn () => view('filament.brand.logo'))
            ->brandLogoHeight('2.25rem')
            ->font('Inter')
            ->colors([
                'primary' => Color::hex('#c8102e'),
            ])
            ->darkMode(false)
            ->sidebarWidth('16rem')
            ->sidebarCollapsibleOnDesktop(false)
            ->maxContentWidth(MaxWidth::Full)
            ->simplePageMaxContentWidth(MaxWidth::Small)
            ->navigationGroups([
                NavigationGroup::make('Menu Utama')->collapsible(false),
                NavigationGroup::make('Pengaturan')->collapsible(false),
            ])
            ->renderHook(
                PanelsRenderHook::SIDEBAR_FOOTER,
                fn () => view('filament.hooks.sidebar-footer'),
            )
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn () => view('filament.hooks.auth-styles'),
                scopes: [Login::class],
            )
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn () => view('filament.hooks.portal-theme'),
            )
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
