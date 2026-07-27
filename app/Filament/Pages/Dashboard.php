<?php

namespace App\Filament\Pages;

use App\Services\WorkshopApi;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';

    protected static ?string $navigationLabel = 'Dashboard';

    protected static ?string $navigationGroup = 'Menu Utama';

    protected static ?string $title = 'Dashboard';

    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.dashboard';

    public array $stats = [];

    public array $services = [];

    public array $quotations = [];

    public ?array $portalUser = null;

    public static function getRoutePath(): string
    {
        return '/';
    }

    public function getHeading(): string|Htmlable
    {
        return '';
    }

    public function mount(): void
    {
        $api = app(WorkshopApi::class);
        $data = $api->dashboard();
        $this->stats = $data['stats'] ?? [];
        $this->services = $data['services'] ?? [];
        $this->quotations = array_slice($api->quotations(), 0, 4);
        $this->portalUser = $api->user();
    }
}
