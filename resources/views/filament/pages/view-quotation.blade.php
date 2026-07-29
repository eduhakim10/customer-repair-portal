@php
    $q = $quotation ?? [];
    $badgeMap = [
        'success' => 'badge-success',
        'warning' => 'badge-warning',
        'info' => 'badge-info',
        'danger' => 'badge-danger',
        'purple' => 'badge-purple',
    ];
    $status = $q['status'] ?? [];
    $vehicle = $q['vehicle'] ?? [];
    $code = $status['code'] ?? '';
    $lineItems = $q['line_items'] ?? [];
    $totals = $q['totals'] ?? [];
    $canUploadPo = $code === 'menunggu';
    $groupedItems = collect($lineItems)->groupBy(fn ($item) => $item['group'] ?? 'Item');
    $groupIcons = ['JASA' => 'fa-wrench', 'SUKU CADANG' => 'fa-cogs'];
@endphp

<x-filament-panels::page>
    <div class="portal-page">
        <div class="record-header">
            <div>
                <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                    <span class="rh-id">{{ $q['offer_number'] ?? '-' }}</span>
                    <span class="badge {{ $badgeMap[$status['color'] ?? 'gray'] ?? 'badge-gray' }}">{{ $status['label'] ?? '-' }}</span>
                </div>
                <div class="rh-sub">
                    Dibuat {{ $q['created_at_formatted'] ?? '-' }}
                    @if (! empty($q['attn']))
                        &nbsp;·&nbsp; SA: {{ $q['attn'] }}
                    @endif
                    &nbsp;·&nbsp; {{ $vehicle['name'] ?? '-' }} – {{ $vehicle['license_plate'] ?? '-' }}
                </div>
            </div>
            <div class="rh-actions">
                <button type="button" class="btn-portal btn-portal-sm" wire:click="printQuotation">
                    <i class="fa fa-print" aria-hidden="true"></i> Cetak
                </button>
                @if ($canUploadPo)
                    <button type="button" class="btn-portal btn-portal-sm btn-portal-primary" wire:click="openQuotationModal('uploadPo', {{ $record }})">
                        <i class="fa fa-upload" aria-hidden="true"></i> Upload PO
                    </button>
                @endif
            </div>
        </div>

        <div class="view-layout">
            <div>
                <div class="portal-card">
                    <div class="portal-card-hd">
                        <span class="portal-card-title"><i class="fa fa-car" style="color:#c8102e;margin-right:6px;"></i>Informasi Kendaraan & Pekerjaan</span>
                    </div>
                    <div class="portal-card-body">
                        <div class="ilist">
                            <div class="il-item">
                                <div class="il-label">Kendaraan</div>
                                <div class="il-value">{{ $vehicle['name'] ?? '-' }}</div>
                            </div>
                            <div class="il-item">
                                <div class="il-label">Plat Nomor</div>
                                <div class="il-value primary">{{ $vehicle['license_plate'] ?? '-' }}</div>
                            </div>
                            <div class="il-item">
                                <div class="il-label">Warna / Tipe</div>
                                <div class="il-value">
                                    {{ collect([$vehicle['color'] ?? null, $vehicle['type'] ?? null])->filter()->implode(' · ') ?: '-' }}
                                </div>
                            </div>
                            <div class="il-item">
                                <div class="il-label">No. Rangka</div>
                                <div class="il-value">{{ $vehicle['chassis_number'] ?? '-' }}</div>
                            </div>
                            <div class="il-item">
                                <div class="il-label">Jenis Servis</div>
                                <div class="il-value">{{ $q['category'] ?? '-' }}</div>
                            </div>
                            <div class="il-item">
                                <div class="il-label">Klasifikasi Kerusakan</div>
                                <div class="il-value">{{ $q['damage_classification'] ?? '-' }}</div>
                            </div>
                            <div class="il-item">
                                <div class="il-label">Tanggal Penawaran</div>
                                <div class="il-value">{{ $q['created_at_formatted'] ?? '-' }}</div>
                            </div>
                            <div class="il-item">
                                <div class="il-label">Estimasi Selesai</div>
                                <div class="il-value">
                                    {{ ! empty($q['service']['due_date']) ? \Illuminate\Support\Carbon::parse($q['service']['due_date'])->translatedFormat('d M Y') : '-' }}
                                </div>
                            </div>
                            <div class="il-item">
                                <div class="il-label">No. SR</div>
                                <div class="il-value">{{ $q['sr_number'] ?? '-' }}</div>
                            </div>
                            <div class="il-item">
                                <div class="il-label">No. SPK</div>
                                <div class="il-value">{{ $q['spk_number'] ?? '-' }}</div>
                            </div>
                            <div class="il-item">
                                <div class="il-label">No. PO</div>
                                <div class="il-value">{{ $q['po_number'] ?? '-' }}</div>
                            </div>
                            @if (! empty($q['service']['complaint']))
                                <div class="il-item" style="grid-column:span 3;">
                                    <div class="il-label">Keluhan Customer</div>
                                    <div class="il-value" style="font-size:13px;color:#374151;">{{ $q['service']['complaint'] }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="portal-card">
                    <div class="portal-card-hd">
                        <span class="portal-card-title"><i class="fa fa-list-check" style="color:#c8102e;margin-right:6px;"></i>Rincian Pekerjaan & Suku Cadang</span>
                    </div>
                    <div style="overflow-x:auto;">
                        <table class="itable">
                            <thead>
                                <tr>
                                    <th style="width:36px;">#</th>
                                    <th>Uraian</th>
                                    <th class="num">Qty</th>
                                    <th class="num">Harga Satuan</th>
                                    <th class="num">Diskon</th>
                                    <th class="num">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($groupedItems as $groupName => $items)
                                    @php
                                        $icon = $groupIcons[strtoupper((string) $groupName)] ?? 'fa-layer-group';
                                        $groupSubtotal = collect($items)->sum('subtotal');
                                    @endphp
                                    <tr class="group-hd">
                                        <td colspan="6"><i class="fa {{ $icon }}" style="margin-right:6px;color:#6b7280;" aria-hidden="true"></i>{{ strtoupper($groupName) }}</td>
                                    </tr>
                                    @foreach ($items as $item)
                                        <tr>
                                            <td style="color:#9ca3af;font-size:11.5px;">{{ $item['no'] }}</td>
                                            <td>
                                                <div style="font-weight:600;font-size:13px;">{{ $item['description'] }}</div>
                                                @if (! empty($item['detail']))
                                                    <div class="cell-sub">{{ $item['detail'] }}</div>
                                                @endif
                                            </td>
                                            <td class="num">{{ $item['qty'] }}</td>
                                            <td class="num">Rp {{ number_format((float) $item['unit_price'], 0, ',', '.') }}</td>
                                            <td class="num" style="color:#16a34a;">
                                                {{ ! empty($item['discount']) ? $item['discount'] : '–' }}
                                            </td>
                                            <td class="num">Rp {{ number_format((float) $item['subtotal'], 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="subtotal">
                                        <td colspan="5" style="text-align:right;font-size:12px;color:#6b7280;">Subtotal {{ $groupName }}</td>
                                        <td class="num">Rp {{ number_format((float) $groupSubtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="portal-empty">Belum ada rincian item.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="total-area">
                        <div class="total-row">
                            <span class="cell-muted">Subtotal</span>
                            <span style="font-weight:600;">Rp {{ number_format((float) ($totals['subtotal'] ?? $q['amount'] ?? 0), 0, ',', '.') }}</span>
                        </div>
                        @if (! empty($totals['tax']))
                            <div class="total-row">
                                <span class="cell-muted">PPN 11%</span>
                                <span style="font-weight:600;">Rp {{ number_format((float) $totals['tax'], 0, ',', '.') }}</span>
                            </div>
                        @endif
                        @if (! empty($totals['discount']))
                            <div class="total-row" style="font-size:12px;">
                                <span class="cell-muted">Diskon total</span>
                                <span style="color:#16a34a;">– Rp {{ number_format((float) $totals['discount'], 0, ',', '.') }}</span>
                            </div>
                        @endif
                        <div class="total-row grand">
                            <span>TOTAL</span>
                            <span>Rp {{ number_format((float) ($totals['grand_total'] ?? $q['amount'] ?? 0), 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div class="side-section">
                    <div class="side-hd"><i class="fa fa-clock" style="color:#c8102e;margin-right:6px;"></i>Status & Riwayat</div>
                    <div class="side-body">
                        <div class="timeline">
                            @foreach ($q['timeline'] ?? [] as $step)
                                <div class="tl-item">
                                    <div class="tl-left">
                                        <div @class(['tl-dot', $step['state'] ?? 'pending'])></div>
                                        <div class="tl-line"></div>
                                    </div>
                                    <div class="tl-body">
                                        <div @class(['tl-title', 'pending' => ($step['state'] ?? '') === 'pending', 'active' => ($step['state'] ?? '') === 'active'])>{{ $step['title'] }}</div>
                                        <div class="tl-time">{{ $step['time'] ?? '-' }}</div>
                                        @if (! empty($step['note']))
                                            <div class="tl-note">{{ $step['note'] }}</div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="side-section">
                    <div class="side-hd"><i class="fa fa-building" style="color:#c8102e;margin-right:6px;"></i>Informasi Customer</div>
                    <div class="side-body" style="display:flex;flex-direction:column;gap:10px;">
                        <div>
                            <div class="il-label">Perusahaan</div>
                            <div class="il-value" style="font-size:13px;">{{ $q['customer']['name'] ?? '-' }}</div>
                        </div>
                        <div>
                            <div class="il-label">PIC</div>
                            <div class="il-value" style="font-size:13px;">{{ $q['customer']['contact'] ?? '-' }}</div>
                        </div>
                        <div>
                            <div class="il-label">Telepon</div>
                            <div class="il-value" style="font-size:13px;">{{ $q['customer']['phone'] ?? '-' }}</div>
                        </div>
                        <div>
                            <div class="il-label">Email</div>
                            <div class="il-value" style="font-size:13px;color:#3b82f6;">{{ $q['customer']['email'] ?? '-' }}</div>
                        </div>
                    </div>
                </div>

                @if (! empty($q['notes']) || ! empty($q['payment_terms']) || ! empty($q['delivery_terms']) || ! empty($q['validity_terms']))
                    <div class="side-section">
                        <div class="side-hd"><i class="fa fa-note-sticky" style="color:#c8102e;margin-right:6px;"></i>Syarat & Catatan</div>
                        <div class="side-body" style="display:flex;flex-direction:column;gap:10px;font-size:12.5px;color:#374151;line-height:1.6;">
                            @if (! empty($q['payment_terms']))
                                <div>
                                    <div class="il-label">Payment Terms</div>
                                    <div>{{ $q['payment_terms'] }}</div>
                                </div>
                            @endif
                            @if (! empty($q['delivery_terms']))
                                <div>
                                    <div class="il-label">Delivery Terms</div>
                                    <div>{{ $q['delivery_terms'] }}</div>
                                </div>
                            @endif
                            @if (! empty($q['validity_terms']))
                                <div>
                                    <div class="il-label">Validity</div>
                                    <div>{{ $q['validity_terms'] }}</div>
                                </div>
                            @endif
                            @if (! empty($q['notes']))
                                <div>
                                    <div class="il-label">Catatan SA</div>
                                    <div>{{ $q['notes'] }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                @if ($canUploadPo)
                    <div class="side-actions">
                        <button type="button" class="btn-portal btn-portal-primary btn-portal-block" wire:click="openQuotationModal('uploadPo', {{ $record }})">
                            <i class="fa fa-upload" aria-hidden="true"></i> Upload PO
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @include('filament.components.quotation-modals')
</x-filament-panels::page>
