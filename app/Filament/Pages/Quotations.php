<?php

namespace App\Filament\Pages;

use App\Filament\Concerns\HandlesQuotationModals;
use App\Services\WorkshopApi;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Session;

class Quotations extends Page
{
    use HandlesQuotationModals;

    private const SESSION_QUOTATIONS = 'portal_quotations_cache';

    private const TABS = [
        'all' => 'Semua',
        'sedang_menunggu' => 'Sedang Menunggu',
        'sedang_diperbaiki' => 'Sedang Diperbaiki',
        'sudah_diperbaiki' => 'Sudah Diperbaiki',
        'belum_ada_po' => 'Belum PO',
    ];

    protected static ?string $navigationIcon = 'heroicon-o-document-currency-dollar';

    protected static ?string $navigationLabel = 'Quotations';

    protected static ?string $navigationGroup = 'Menu Utama';

    protected static ?string $title = 'Penawaran';

    protected static ?int $navigationSort = 2;

    protected static string $view = 'filament.pages.quotations';

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

    public bool $ready = false;

    /** @return array<string, string> */
    public static function tabLabels(): array
    {
        return self::TABS;
    }

    public function getHeading(): string|Htmlable
    {
        return '';
    }

    public function mount(): void
    {
        $tab = (string) request()->query('tab', 'all');
        if (array_key_exists($tab, self::TABS)) {
            $this->tab = $tab;
        }

        $from = request()->query('from');
        $to = request()->query('to');
        if (filled($from)) {
            $this->dateFrom = (string) $from;
        }
        if (filled($to)) {
            $this->dateTo = (string) $to;
        }

        $this->syncDraftFilters();

        // Tampilkan data cache dulu (kalau ada) biar halaman tidak kosong,
        // lalu wire:init akan refresh dari API dengan overlay loading.
        if (Session::has(self::SESSION_QUOTATIONS)) {
            $this->ready = true;
        }
    }

    public function loadQuotations(): void
    {
        // Keep list out of Livewire snapshot (avoids 413 on tab/filter clicks).
        $payload = app(WorkshopApi::class)->quotations($this->dateFrom, $this->dateTo);
        Session::put(self::SESSION_QUOTATIONS, $payload);

        $period = $payload['period'] ?? [];
        if (blank($this->dateFrom) && ! empty($period['from'])) {
            $this->dateFrom = $period['from'];
        }
        if (blank($this->dateTo) && ! empty($period['to'])) {
            $this->dateTo = $period['to'];
        }
        $this->syncDraftFilters();

        $this->ready = true;
    }

    /**
     * @return array{data: array<int, array<string, mixed>>, counts: array<string, int>, period: array<string, mixed>}
     */
    protected function quotationsPayload(): array
    {
        $payload = Session::get(self::SESSION_QUOTATIONS, []);

        if (! is_array($payload)) {
            return ['data' => [], 'counts' => [], 'period' => []];
        }

        // Legacy session shape: bare list
        if ($payload !== [] && array_is_list($payload)) {
            return ['data' => $payload, 'counts' => [], 'period' => []];
        }

        return [
            'data' => $payload['data'] ?? [],
            'counts' => $payload['counts'] ?? [],
            'period' => $payload['period'] ?? [],
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function quotationsList(): array
    {
        return $this->quotationsPayload()['data'];
    }

    protected function afterQuotationMutation(): void
    {
        $this->loadQuotations();
    }

    public function setTab(string $tab): void
    {
        if (! array_key_exists($tab, self::TABS)) {
            return;
        }

        $this->tab = $tab;
        $this->page = 1;
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
        $this->loadQuotations();
    }

    public function clearFilters(): void
    {
        $this->draftStatusFilter = '';
        $this->draftVehicleFilter = '';
        $this->draftDateFrom = null;
        $this->draftDateTo = null;
        $this->statusFilter = '';
        $this->vehicleFilter = '';
        $this->dateFrom = null;
        $this->dateTo = null;
        $this->page = 1;
        $this->loadQuotations();
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

    /**
     * @return array<int, array<string, mixed>>
     */
    public function filteredQuotations(): array
    {
        $items = collect($this->quotationsList())
            ->filter(function (array $q): bool {
                if ($this->tab !== 'all') {
                    $buckets = $q['buckets'] ?? [];
                    if (empty($buckets[$this->tab])) {
                        return false;
                    }
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
        $payload = $this->quotationsPayload();
        $counts = $payload['counts'];
        $list = $payload['data'];

        // Prefer API counts (same as dashboard). Fallback: derive from row flags.
        if ($counts === []) {
            $counts = [
                'sedang_menunggu' => collect($list)->filter(fn ($q) => ! empty($q['buckets']['sedang_menunggu']))->count(),
                'sedang_diperbaiki' => collect($list)->filter(fn ($q) => ! empty($q['buckets']['sedang_diperbaiki']))->count(),
                'sudah_diperbaiki' => collect($list)->filter(fn ($q) => ! empty($q['buckets']['sudah_diperbaiki']))->count(),
                'belum_ada_po' => collect($list)->filter(fn ($q) => ! empty($q['buckets']['belum_ada_po']))->count(),
            ];
        }

        return [
            'all' => count($list),
            'sedang_menunggu' => (int) ($counts['sedang_menunggu'] ?? 0),
            'sedang_diperbaiki' => (int) ($counts['sedang_diperbaiki'] ?? 0),
            'sudah_diperbaiki' => (int) ($counts['sudah_diperbaiki'] ?? 0),
            'belum_ada_po' => (int) ($counts['belum_ada_po'] ?? 0),
        ];
    }

    /**
     * @return array<int, string>
     */
    public function portalStatusFilterOptions(): array
    {
        return collect($this->quotationsList())
            ->pluck('status.label')
            ->filter()
            ->unique()
            ->sort()
            ->values()
            ->all();
    }

    public function vehicleOptions(): array
    {
        return collect($this->quotationsList())
            ->map(fn (array $q) => [
                'plate' => $q['license_plate'] ?? '',
                'label' => trim(($q['vehicle'] ?? '') . ' – ' . ($q['license_plate'] ?? '')),
            ])
            ->filter(fn (array $v) => $v['plate'] !== '')
            ->unique('plate')
            ->pluck('label', 'plate')
            ->all();
    }

    public function downloadQuotation(int $id): void
    {
        $url = route('quotations.print', $id);
        $this->js('window.open(' . json_encode($url) . ', "_blank")');
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
        return collect($this->quotationsList())->firstWhere('id', $id) ?? [];
    }
}
