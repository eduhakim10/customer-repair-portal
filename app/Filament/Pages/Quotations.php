<?php

namespace App\Filament\Pages;

use App\Filament\Concerns\HandlesQuotationModals;
use App\Services\WorkshopApi;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class Quotations extends Page
{
    use HandlesQuotationModals;

    protected static ?string $navigationIcon = 'heroicon-o-document-currency-dollar';

    protected static ?string $navigationLabel = 'Quotations';

    protected static ?string $navigationGroup = 'Menu Utama';

    protected static ?string $title = 'Penawaran';

    protected static ?int $navigationSort = 2;

    protected static string $view = 'filament.pages.quotations';

    public array $quotations = [];

    public string $tab = 'all';

    public string $search = '';

    public string $statusFilter = '';

    public string $vehicleFilter = '';

    public ?string $dateFrom = null;

    public ?string $dateTo = null;

    public string $draftStatusFilter = '';

    public string $draftVehicleFilter = '';

    public ?string $draftDateFrom = null;

    public ?string $draftDateTo = null;

    public string $sortColumn = 'date';

    public string $sortDirection = 'desc';

    public int $page = 1;

    public int $perPage = 10;

    /** @var array<int, int> */
    public array $selected = [];

    public function getHeading(): string|Htmlable
    {
        return '';
    }

    public function mount(): void
    {
        $this->loadQuotations();
        $this->syncDraftFilters();
    }

    public function loadQuotations(): void
    {
        $this->quotations = app(WorkshopApi::class)->quotations();
    }

    public function setTab(string $tab): void
    {
        $this->tab = $tab;
        $this->page = 1;
        $this->selected = [];
    }

    public function updatedSearch(): void
    {
        $this->page = 1;
    }

    public function syncDraftFilters(): void
    {
        $this->draftStatusFilter = $this->statusFilter;
        $this->draftVehicleFilter = $this->vehicleFilter;
        $this->draftDateFrom = $this->dateFrom;
        $this->draftDateTo = $this->dateTo;
    }

    public function applyFilters(): void
    {
        $this->statusFilter = $this->draftStatusFilter;
        $this->vehicleFilter = $this->draftVehicleFilter;
        $this->dateFrom = $this->draftDateFrom;
        $this->dateTo = $this->draftDateTo;
        $this->page = 1;
    }

    public function clearFilters(): void
    {
        $this->draftStatusFilter = '';
        $this->draftVehicleFilter = '';
        $this->draftDateFrom = null;
        $this->draftDateTo = null;
        $this->applyFilters();
    }

    public function sortBy(string $column): void
    {
        if ($this->sortColumn === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortColumn = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function goToPage(int $page): void
    {
        $this->page = max(1, min($page, $this->totalPages()));
    }

    public function toggleAll(bool $checked): void
    {
        $this->selected = $checked
            ? collect($this->paginatedQuotations())->pluck('id')->map(fn ($id) => (int) $id)->all()
            : [];
    }

    public function clearSelection(): void
    {
        $this->selected = [];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function filteredQuotations(): array
    {
        $items = collect($this->quotations)
            ->filter(function (array $q): bool {
                if ($this->tab !== 'all' && ($q['status']['tab'] ?? '') !== $this->tab) {
                    return false;
                }

                if ($this->search !== '' && ! str_contains($q['search'] ?? '', strtolower($this->search))) {
                    return false;
                }

                if ($this->statusFilter !== '' && ($q['status']['label'] ?? '') !== $this->statusFilter) {
                    return false;
                }

                if ($this->vehicleFilter !== '' && ($q['license_plate'] ?? '') !== $this->vehicleFilter) {
                    return false;
                }

                if ($this->dateFrom && ($q['date'] ?? '') < $this->dateFrom) {
                    return false;
                }

                if ($this->dateTo && ($q['date'] ?? '') > $this->dateTo) {
                    return false;
                }

                return true;
            });

        $items = match ($this->sortColumn) {
            'offer_number' => $items->sortBy('offer_number', SORT_NATURAL | SORT_FLAG_CASE),
            'vehicle' => $items->sortBy('vehicle', SORT_NATURAL | SORT_FLAG_CASE),
            'amount' => $items->sortBy('amount'),
            default => $items->sortBy('date'),
        };

        if ($this->sortDirection === 'desc') {
            $items = $items->reverse();
        }

        return $items->values()->all();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function paginatedQuotations(): array
    {
        $filtered = $this->filteredQuotations();

        return collect($filtered)
            ->slice(($this->page - 1) * $this->perPage, $this->perPage)
            ->values()
            ->all();
    }

    public function totalPages(): int
    {
        return max(1, (int) ceil(count($this->filteredQuotations()) / $this->perPage));
    }

    public function paginationLabel(): string
    {
        $filtered = count($this->filteredQuotations());

        if ($filtered === 0) {
            return 'Menampilkan 0 dari 0 hasil';
        }

        $from = (($this->page - 1) * $this->perPage) + 1;
        $to = min($filtered, $this->page * $this->perPage);

        return "Menampilkan {$from}–{$to} dari {$filtered} hasil";
    }

    public function tabCounts(): array
    {
        $all = count($this->quotations);

        return [
            'all' => $all,
            'pending' => collect($this->quotations)->where('status.tab', 'pending')->count(),
            'approved' => collect($this->quotations)->where('status.tab', 'approved')->count(),
            'rejected' => collect($this->quotations)->where('status.tab', 'rejected')->count(),
        ];
    }

    public function vehicleOptions(): array
    {
        return collect($this->quotations)
            ->map(fn (array $q) => [
                'plate' => $q['license_plate'] ?? '',
                'label' => trim(($q['vehicle'] ?? '') . ' – ' . ($q['license_plate'] ?? '')),
            ])
            ->filter(fn (array $v) => $v['plate'] !== '')
            ->unique('plate')
            ->pluck('label', 'plate')
            ->all();
    }

    public function bulkApprove(): void
    {
        $count = count($this->selected);
        $this->selected = [];
        Notification::make()
            ->title('Penawaran disetujui')
            ->body("{$count} penawaran telah disetujui.")
            ->success()
            ->send();
    }

    public function bulkReject(): void
    {
        $count = count($this->selected);
        $this->selected = [];
        Notification::make()
            ->title('Penawaran ditolak')
            ->body("{$count} penawaran telah ditolak.")
            ->danger()
            ->send();
    }

    public function downloadQuotation(int $id): void
    {
        $q = $this->findQuotation($id);
        Notification::make()
            ->title('Unduh penawaran')
            ->body('Fitur unduh PDF untuk ' . ($q['offer_number'] ?? 'penawaran') . ' akan segera tersedia.')
            ->info()
            ->send();
    }

    protected function findQuotationForModal(?int $id): ?array
    {
        if (! $id) {
            return null;
        }

        $q = $this->findQuotation($id);

        return $q !== [] ? $q : null;
    }

    /**
     * @return array<string, mixed>
     */
    private function findQuotation(int $id): array
    {
        return collect($this->quotations)->firstWhere('id', $id) ?? [];
    }
}
