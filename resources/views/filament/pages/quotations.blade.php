@php
    $badgeMap = [
        'success' => 'badge-success',
        'warning' => 'badge-warning',
        'info' => 'badge-info',
        'danger' => 'badge-danger',
        'gray' => 'badge-gray',
        'primary' => 'badge-primary',
        'purple' => 'badge-purple',
    ];
    $rows = $this->paginatedQuotations();
    $filteredCount = count($this->filteredQuotations());
    $counts = $this->tabCounts();
    $vehicles = $this->vehicleOptions();
    $tabs = [
        'all' => 'Semua',
        'pending' => 'Menunggu Persetujuan',
        'approved' => 'Disetujui',
        'rejected' => 'Ditolak',
    ];
    $totalPages = $this->totalPages();
@endphp

<x-filament-panels::page>
    <div class="portal-page">
        <div class="page-hd">
            <div>
                <div class="page-title">Penawaran</div>
                <div class="page-sub">Kelola dan setujui penawaran dari MTI</div>
            </div>
        </div>

        <div class="resource-card">
            <div class="portal-tabs">
                @foreach ($tabs as $key => $label)
                    <button
                        type="button"
                        wire:click="setTab('{{ $key }}')"
                        @class(['portal-tab', 'active' => $tab === $key])
                    >
                        {{ $label }}
                        <span class="tab-count">{{ $counts[$key] ?? 0 }}</span>
                    </button>
                @endforeach
            </div>

            <div class="tbl-toolbar">
                <div class="search-box">
                    <i class="fa fa-magnifying-glass" aria-hidden="true"></i>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari quotation number, kendaraan..." />
                </div>

                <div class="filter-dropdown" x-data="{ open: false }">
                    <button type="button" class="btn-portal btn-portal-sm" @click="open = !open">
                        <i class="fa fa-sliders" aria-hidden="true"></i> Filter
                    </button>
                    <div class="filter-panel" :class="{ open: open }" @click.outside="open = false">
                        <div class="filter-panel-hd">
                            <span>Filter</span>
                            <button type="button" class="btn-portal btn-portal-sm" wire:click="clearFilters">Reset</button>
                        </div>
                        <div class="filter-field">
                            <label>Status</label>
                            <select wire:model="draftStatusFilter">
                                <option value="">Semua Status</option>
                                <option>Menunggu</option>
                                <option>Disetujui</option>
                                <option>PO Diupload</option>
                                <option>Proses Servis</option>
                                <option>Ditolak</option>
                            </select>
                        </div>
                        <div class="filter-field">
                            <label>Kendaraan</label>
                            <select wire:model="draftVehicleFilter">
                                <option value="">Semua Kendaraan</option>
                                @foreach ($vehicles as $plate => $label)
                                    <option value="{{ $plate }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="filter-field">
                            <label>Tanggal Dari</label>
                            <input type="date" wire:model="draftDateFrom" />
                        </div>
                        <div class="filter-field">
                            <label>Tanggal Sampai</label>
                            <input type="date" wire:model="draftDateTo" />
                        </div>
                        <div class="filter-panel-ft">
                            <button type="button" class="btn-portal btn-portal-sm" @click="open = false">Batal</button>
                            <button type="button" class="btn-portal btn-portal-sm btn-portal-primary" wire:click="applyFilters" @click="open = false">
                                <i class="fa fa-check" aria-hidden="true"></i> Terapkan
                            </button>
                        </div>
                    </div>
                </div>

                <div class="tbl-toolbar-right">
                    <span style="font-size:12px;color:#9ca3af;">{{ $filteredCount }} data</span>
                </div>
            </div>

            <div style="overflow-x:auto;">
                <table class="ftable">
                    <thead>
                        <tr>
                            <th style="width:40px;">
                                <input
                                    type="checkbox"
                                    wire:change="toggleAll($event.target.checked)"
                                    @checked(count($selected) && count($selected) === count($rows) && count($rows) > 0)
                                />
                            </th>
                            <th class="sortable" wire:click="sortBy('offer_number')">
                                Quotation Number
                                <i @class([
                                    'fa sort-icon',
                                    'fa-sort' => $sortColumn !== 'offer_number',
                                    'fa-chevron-up sort-icon active' => $sortColumn === 'offer_number' && $sortDirection === 'asc',
                                    'fa-chevron-down sort-icon active' => $sortColumn === 'offer_number' && $sortDirection === 'desc',
                                ]) aria-hidden="true"></i>
                            </th>
                            <th class="sortable" wire:click="sortBy('vehicle')">
                                Kendaraan
                                <i @class([
                                    'fa sort-icon',
                                    'fa-sort' => $sortColumn !== 'vehicle',
                                    'fa-chevron-up sort-icon active' => $sortColumn === 'vehicle' && $sortDirection === 'asc',
                                    'fa-chevron-down sort-icon active' => $sortColumn === 'vehicle' && $sortDirection === 'desc',
                                ]) aria-hidden="true"></i>
                            </th>
                            <th class="sortable" wire:click="sortBy('date')">
                                Tanggal
                                <i @class([
                                    'fa sort-icon',
                                    'fa-sort' => $sortColumn !== 'date',
                                    'fa-chevron-up sort-icon active' => $sortColumn === 'date' && $sortDirection === 'asc',
                                    'fa-chevron-down sort-icon active' => $sortColumn === 'date' && $sortDirection === 'desc',
                                ]) aria-hidden="true"></i>
                            </th>
                            <th>Jenis Servis</th>
                            <th class="sortable" wire:click="sortBy('amount')">
                                Total
                                <i @class([
                                    'fa sort-icon',
                                    'fa-sort' => $sortColumn !== 'amount',
                                    'fa-chevron-up sort-icon active' => $sortColumn === 'amount' && $sortDirection === 'asc',
                                    'fa-chevron-down sort-icon active' => $sortColumn === 'amount' && $sortDirection === 'desc',
                                ]) aria-hidden="true"></i>
                            </th>
                            <th>Status</th>
                            <th style="width:130px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rows as $q)
                            @php
                                $code = $q['status']['code'] ?? '';
                                $isRejected = $code === 'ditolak';
                            @endphp
                            <tr wire:key="quotation-{{ $q['id'] }}">
                                <td>
                                    <input type="checkbox" wire:model.live="selected" value="{{ $q['id'] }}" />
                                </td>
                                <td>
                                    <a href="{{ \App\Filament\Pages\ViewQuotation::getUrl(['record' => $q['id']]) }}" class="ref-link" @if($isRejected) style="color:#9ca3af;text-decoration:line-through;" @endif>
                                        {{ $q['offer_number'] ?? '-' }}
                                    </a>
                                </td>
                                <td>
                                    <div style="font-weight:600;font-size:13px;@if($isRejected)color:#9ca3af;@endif">{{ $q['vehicle'] ?? '-' }}</div>
                                    <div class="cell-sub">
                                        {{ $q['license_plate'] ?? '-' }}
                                        @if (! empty($q['vehicle_year']))
                                            · {{ $q['vehicle_year'] }}
                                        @endif
                                    </div>
                                </td>
                                <td class="cell-muted">
                                    {{ ! empty($q['date']) ? \Illuminate\Support\Carbon::parse($q['date'])->translatedFormat('d M Y') : '-' }}
                                </td>
                                <td style="font-size:12.5px;@if($isRejected)color:#9ca3af;@endif">{{ $q['category'] ?? '-' }}</td>
                                <td style="font-weight:700;@if($isRejected)color:#9ca3af;@endif">Rp {{ number_format((float) ($q['amount'] ?? 0), 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge {{ $badgeMap[$q['status']['color'] ?? 'gray'] ?? 'badge-gray' }}">
                                        {{ $q['status']['label'] ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="row-actions">
                                        <a href="{{ \App\Filament\Pages\ViewQuotation::getUrl(['record' => $q['id']]) }}" class="btn-portal btn-portal-sm btn-portal-icon" title="Lihat Detail">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>

                                        @if ($code === 'menunggu')
                                            <button type="button" class="btn-portal btn-portal-sm btn-portal-icon btn-portal-success" title="Setujui" wire:click="openQuotationModal('approve', {{ $q['id'] }})">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            </button>
                                            <button type="button" class="btn-portal btn-portal-sm btn-portal-icon btn-portal-danger-outline" title="Tolak" wire:click="openQuotationModal('reject', {{ $q['id'] }})">
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </button>
                                        @elseif ($code === 'disetujui')
                                            <button type="button" class="btn-portal btn-portal-sm btn-portal-primary" wire:click="openQuotationModal('uploadPo', {{ $q['id'] }})">
                                                <i class="fa fa-upload" aria-hidden="true"></i> Upload PO
                                            </button>
                                        @elseif ($code === 'po_diupload')
                                            <button type="button" class="btn-portal btn-portal-sm btn-portal-icon" title="Download" wire:click="downloadQuotation({{ $q['id'] }})">
                                                <i class="fa fa-download" aria-hidden="true"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="portal-empty">Belum ada penawaran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if (count($selected))
                <div class="bulk-bar">
                    <span class="bulk-count">{{ count($selected) }}</span> baris dipilih
                    <div class="bulk-actions">
                        <button type="button" class="bulk-btn bulk-btn-approve" wire:click="bulkApprove">
                            <i class="fa fa-check" aria-hidden="true"></i> Setujui Semua
                        </button>
                        <button type="button" class="bulk-btn bulk-btn-reject" wire:click="bulkReject">
                            <i class="fa fa-times" aria-hidden="true"></i> Tolak Semua
                        </button>
                    </div>
                    <button type="button" class="bulk-close" wire:click="clearSelection" aria-label="Batal pilih">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                </div>
            @endif

            <div class="pagination">
                <span>{{ $this->paginationLabel() }}</span>
                @if ($totalPages > 1)
                    <div class="page-btns">
                        <button type="button" class="page-btn" wire:click="goToPage({{ $page - 1 }})" @disabled($page <= 1)>
                            <i class="fa fa-chevron-left" style="font-size:11px;" aria-hidden="true"></i>
                        </button>
                        @for ($p = 1; $p <= min($totalPages, 5); $p++)
                            <button type="button" class="page-btn @if($page === $p) active @endif" wire:click="goToPage({{ $p }})">{{ $p }}</button>
                        @endfor
                        @if ($totalPages > 5)
                            <span style="padding:0 4px;color:#9ca3af;">...</span>
                            <button type="button" class="page-btn @if($page === $totalPages) active @endif" wire:click="goToPage({{ $totalPages }})">{{ $totalPages }}</button>
                        @endif
                        <button type="button" class="page-btn" wire:click="goToPage({{ $page + 1 }})" @disabled($page >= $totalPages)>
                            <i class="fa fa-chevron-right" style="font-size:11px;" aria-hidden="true"></i>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @include('filament.components.quotation-modals')
</x-filament-panels::page>
