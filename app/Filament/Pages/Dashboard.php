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

    public array $period = [];

    public ?array $portalUser = null;

    public ?string $dateFrom = null;

    public ?string $dateTo = null;

    public bool $photoModalOpen = false;

    public string $photoModalTitle = '';

    public array $photoModalImages = [];

    public function openServicePhotos(int $serviceId, string $type): void
    {
        $res = app(WorkshopApi::class)->servicePhotos($serviceId, $type);

        if (empty($res['data'])) {
            return;
        }

        $this->photoModalTitle = $type === 'before' ? 'Foto Before' : 'Foto After';
        $this->photoModalImages = $res['data'];
        $this->photoModalOpen = true;
    }

    public function closePhotoModal(): void
    {
        $this->photoModalOpen = false;
        $this->photoModalImages = [];
        $this->photoModalTitle = '';
    }

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
        $this->portalUser = app(WorkshopApi::class)->user();
        $this->loadDashboard();
    }

    public function applyPeriod(): void
    {
        $this->validate([
            'dateFrom' => ['nullable', 'date'],
            'dateTo' => ['nullable', 'date', 'after_or_equal:dateFrom'],
        ], [
            'dateTo.after_or_equal' => 'Tanggal sampai harus sama atau setelah tanggal dari.',
        ]);

        $this->loadDashboard();
    }

    public function resetPeriod(): void
    {
        $this->resetValidation();
        $this->dateFrom = null;
        $this->dateTo = null;
        $this->loadDashboard();
    }

    protected function loadDashboard(): void
    {
        $api = app(WorkshopApi::class);
        $data = $api->dashboard($this->dateFrom, $this->dateTo);

        $this->stats = $data['stats'] ?? [];
        $this->services = $data['services'] ?? [];
        $this->period = $data['period'] ?? [];
        $this->quotations = array_key_exists('quotations', $data)
            ? ($data['quotations'] ?? [])
            : array_slice($api->quotations(), 0, 4);

        $this->dateFrom = $this->period['from'] ?? $this->dateFrom;
        $this->dateTo = $this->period['to'] ?? $this->dateTo;
    }
}
