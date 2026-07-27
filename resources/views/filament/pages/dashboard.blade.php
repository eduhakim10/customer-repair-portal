@php
    $badgeMap = [
        'success' => 'badge-success',
        'warning' => 'badge-warning',
        'info' => 'badge-info',
        'danger' => 'badge-danger',
        'gray' => 'badge-gray',
        'primary' => 'badge-primary',
    ];

    $cards = [
        ['desc' => 'Total Unit Sedang Diperbaiki', 'val' => $stats['sedang_diperbaiki'] ?? 0, 'bg' => '#eff6ff', 'fg' => '#3b82f6', 'icon' => 'fa-car'],
        ['desc' => 'Total Unit Sedang Menunggu', 'val' => $stats['sedang_menunggu'] ?? 0, 'bg' => '#fefce8', 'fg' => '#d97706', 'icon' => 'fa-clock'],
        ['desc' => 'Penawaran Berlangsung', 'val' => $stats['penawaran_berlangsung'] ?? 0, 'bg' => '#fff1f2', 'fg' => '#c8102e', 'icon' => 'fa-file-invoice'],
        ['desc' => 'Total Unit Sudah Diperbaiki', 'val' => $stats['sudah_diperbaiki'] ?? 0, 'bg' => '#f0fdf4', 'fg' => '#16a34a', 'icon' => 'fa-circle-check'],
        ['desc' => 'Total PO Dikeluarkan', 'val' => $stats['total_po'] ?? 0, 'bg' => '#f5f3ff', 'fg' => '#7c3aed', 'icon' => 'fa-file-contract'],
    ];

    $activeServices = collect($services)->filter(fn ($s) => ($s['progress']['badge']['label'] ?? '') !== 'Selesai')->count();
@endphp

<x-filament-panels::page>
    <div class="portal-page">
        <div class="welcome-banner">
            <div>
                <div class="wb-greeting">Selamat datang kembali,</div>
                <div class="wb-name">{{ $portalUser['customer_name'] ?? $portalUser['name'] ?? 'Customer' }} 👋</div>
                <div class="wb-sub">{{ now()->translatedFormat('l, d F Y') }}</div>
            </div>
            <i class="fa fa-truck wb-icon" aria-hidden="true"></i>
        </div>

        <div class="stats-grid">
            @foreach ($cards as $card)
                <div class="stat-card">
                    <div class="stat-desc">{{ $card['desc'] }}</div>
                    <div class="stat-row">
                        <div class="stat-val">{{ $card['val'] }}</div>
                        <div class="stat-icon" style="background:{{ $card['bg'] }};color:{{ $card['fg'] }};">
                            <i class="fa {{ $card['icon'] }}" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="cols-3-2">
            <div class="widget">
                <div class="widget-hd">
                    <span class="widget-title">Penawaran Terbaru</span>
                    <a href="{{ \App\Filament\Pages\Quotations::getUrl() }}" class="btn-portal">
                        <i class="fa fa-arrow-right" aria-hidden="true"></i> Lihat Semua
                    </a>
                </div>
                <div style="overflow-x:auto;">
                    <table class="mtable">
                        <thead>
                            <tr>
                                <th>No. Penawaran</th>
                                <th>Kendaraan</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($quotations as $q)
                                <tr>
                                    <td>
                                        <a href="{{ \App\Filament\Pages\ViewQuotation::getUrl(['record' => $q['id']]) }}" class="ref-link">
                                            {{ $q['offer_number'] ?? '-' }}
                                        </a>
                                    </td>
                                    <td>
                                        <div style="font-weight:600;font-size:12.5px;">{{ $q['vehicle'] ?? '-' }}</div>
                                        <div class="cell-sub">{{ $q['license_plate'] ?? '-' }}</div>
                                    </td>
                                    <td class="cell-muted">
                                        {{ ! empty($q['date']) ? \Illuminate\Support\Carbon::parse($q['date'])->translatedFormat('d M Y') : '-' }}
                                    </td>
                                    <td style="font-weight:600;">Rp {{ number_format((float) ($q['amount'] ?? 0), 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge {{ $badgeMap[$q['status']['color'] ?? 'gray'] ?? 'badge-gray' }}">
                                            {{ $q['status']['label'] ?? '-' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="portal-empty">Belum ada penawaran.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="tfoot-link">
                    <a href="{{ \App\Filament\Pages\Quotations::getUrl() }}">Lihat semua penawaran →</a>
                </div>
            </div>

            <div class="widget">
                <div class="widget-hd">
                    <span class="widget-title">Proses Services</span>
                    @if ($activeServices > 0)
                        <span class="badge badge-primary">{{ $activeServices }} aktif</span>
                    @endif
                </div>
                <div class="widget-body" style="padding-top:12px;padding-bottom:12px;">
                    @forelse ($services as $service)
                        <div class="service-card">
                            <div class="service-hd">
                                <div>
                                    <div class="service-vehicle">{{ $service['vehicle'] }}</div>
                                    <div class="service-plat">
                                        {{ $service['license_plate'] }}
                                        @if (! empty($service['category']))
                                            · {{ $service['category'] }}
                                        @endif
                                    </div>
                                </div>
                                <div class="service-spk">{{ $service['ref'] }}</div>
                            </div>

                            <div class="progress-steps">
                                @foreach ($service['progress']['steps'] as $step)
                                    <div @class([
                                        'progress-step',
                                        'done' => $step['done'],
                                        'active' => $step['active'] && ! $step['done'],
                                    ])>
                                        <div class="step-dot">
                                            @if ($step['done'])
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            @else
                                                {{ $step['no'] }}
                                            @endif
                                        </div>
                                        <div class="step-label">{{ $step['label'] }}</div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="service-meta">
                                <span class="badge {{ $badgeMap[$service['progress']['badge']['color'] ?? 'gray'] ?? 'badge-gray' }}">
                                    {{ $service['progress']['badge']['label'] }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="portal-empty">Belum ada proses services.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
