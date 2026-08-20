<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $quotation['offer_number'] ?? 'Penawaran' }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #111827;
            margin: 24px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 16px;
        }
        .brand {
            font-size: 16px;
            font-weight: 700;
            color: #c8102e;
        }
        .meta {
            text-align: right;
            line-height: 1.5;
        }
        .meta strong { font-size: 14px; }
        .section-title {
            font-size: 13px;
            font-weight: 700;
            margin: 18px 0 8px;
        }
        .info {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        .info td {
            padding: 3px 0;
            vertical-align: top;
        }
        .info .label {
            width: 140px;
            color: #6b7280;
        }
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
        }
        table.items th,
        table.items td {
            border: 1px solid #d1d5db;
            padding: 6px 8px;
        }
        table.items th {
            background: #f3f4f6;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.02em;
        }
        table.items td.num,
        table.items th.num {
            text-align: right;
            white-space: nowrap;
        }
        table.items td.center {
            text-align: center;
            color: #6b7280;
            width: 36px;
        }
        tr.group-hd td {
            background: #f9fafb;
            font-weight: 700;
        }
        tr.subtotal td {
            background: #fafafa;
            font-weight: 600;
        }
        .detail {
            color: #6b7280;
            font-size: 11px;
            margin-top: 2px;
        }
        .totals {
            width: 320px;
            margin-left: auto;
            margin-top: 12px;
        }
        .totals .row {
            display: flex;
            justify-content: space-between;
            padding: 4px 0;
        }
        .totals .grand {
            border-top: 2px solid #111827;
            margin-top: 6px;
            padding-top: 8px;
            font-size: 14px;
            font-weight: 700;
        }
        .muted { color: #6b7280; }
        .btn {
            margin-bottom: 16px;
            padding: 8px 14px;
            background: #c8102e;
            color: #fff;
            border: 0;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
        }
        @media print {
            .btn { display: none !important; }
            body { margin: 0; }
            @page { margin: 12mm; }
        }
    </style>
</head>
<body>
@php
    $vehicle = $quotation['vehicle'] ?? [];
    $customer = $quotation['customer'] ?? [];
    $totals = $quotation['totals'] ?? [];
    $lineItems = $quotation['line_items'] ?? [];
    $groupedItems = collect($lineItems)->groupBy(fn ($item) => $item['group'] ?? 'Item');
    $ppnPercent = rtrim(rtrim(number_format((float) ($totals['ppn_percent'] ?? 11), 2, ',', '.'), '0'), ',');
    if ($ppnPercent === '') {
        $ppnPercent = '0';
    }
@endphp

<button type="button" class="btn" onclick="window.print()">Cetak</button>

<div class="header">
    <div>
        <div class="brand">PT Mitra Toyotaka Indonesia</div>
        <div class="muted">Customer Portal — Penawaran</div>
    </div>
    <div class="meta">
        <strong>{{ $quotation['offer_number'] ?? '-' }}</strong><br>
        {{ $quotation['created_at_formatted'] ?? '-' }}
    </div>
</div>

<div class="section-title">Informasi Penawaran</div>
<table class="info">
    <tr>
        <td class="label">Customer</td>
        <td>{{ $customer['name'] ?? '-' }}</td>
        <td class="label">Kendaraan</td>
        <td>{{ $vehicle['name'] ?? '-' }}</td>
    </tr>
    <tr>
        <td class="label">PIC</td>
        <td>{{ $customer['contact'] ?? ($quotation['attn'] ?? '-') }}</td>
        <td class="label">Plat Nomor</td>
        <td>{{ $vehicle['license_plate'] ?? '-' }}</td>
    </tr>
    <tr>
        <td class="label">No. SR</td>
        <td>{{ $quotation['sr_number'] ?? '-' }}</td>
        <td class="label">Jenis Servis</td>
        <td>{{ $quotation['category'] ?? '-' }}</td>
    </tr>
    <tr>
        <td class="label">No. SPK</td>
        <td>{{ $quotation['spk_number'] ?? '-' }}</td>
        <td class="label">No. PO</td>
        <td>{{ $quotation['po_number'] ?? '-' }}</td>
    </tr>
</table>

<div class="section-title">Rincian Pekerjaan &amp; Suku Cadang</div>
<table class="items">
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
            @php $groupSubtotal = collect($items)->sum('subtotal'); @endphp
            <tr class="group-hd">
                <td colspan="6">{{ strtoupper((string) $groupName) }}</td>
            </tr>
            @foreach ($items as $item)
                <tr>
                    <td class="center">{{ $item['no'] }}</td>
                    <td>
                        <div>{{ $item['description'] }}</div>
                        @if (! empty($item['detail']))
                            <div class="detail">{{ $item['detail'] }}</div>
                        @endif
                    </td>
                    <td class="num">{{ $item['qty'] }}</td>
                    <td class="num">Rp {{ number_format((float) $item['unit_price'], 0, ',', '.') }}</td>
                    <td class="num">{{ ! empty($item['discount']) ? $item['discount'] : '–' }}</td>
                    <td class="num">Rp {{ number_format((float) $item['subtotal'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="subtotal">
                <td colspan="5" style="text-align:right;" class="muted">Subtotal {{ $groupName }}</td>
                <td class="num">Rp {{ number_format((float) $groupSubtotal, 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="text-align:center;" class="muted">Belum ada rincian item.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="totals">
    <div class="row">
        <span class="muted">Subtotal</span>
        <span>Rp {{ number_format((float) ($totals['subtotal'] ?? $quotation['amount'] ?? 0), 0, ',', '.') }}</span>
    </div>
    @if (! empty($totals['tax']))
        <div class="row">
            <span class="muted">PPN {{ $ppnPercent }}%</span>
            <span>Rp {{ number_format((float) $totals['tax'], 0, ',', '.') }}</span>
        </div>
    @endif
    @if (! empty($totals['discount']))
        <div class="row">
            <span class="muted">Diskon total</span>
            <span style="color:#16a34a;">– Rp {{ number_format((float) $totals['discount'], 0, ',', '.') }}</span>
        </div>
    @endif
    <div class="row grand">
        <span>TOTAL</span>
        <span>Rp {{ number_format((float) ($totals['grand_total'] ?? $quotation['amount'] ?? 0), 0, ',', '.') }}</span>
    </div>
</div>

</body>
</html>
