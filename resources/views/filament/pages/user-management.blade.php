@php
    $roleBadges = [
        'Admin' => 'badge-primary',
        'Finance' => 'badge-info',
        'Purchasing' => 'badge-gray',
        'Viewer' => 'badge-gray',
    ];
@endphp

<x-filament-panels::page>
    <div class="portal-page">
        <div class="widget">
            <div class="widget-hd">
                <span class="widget-title">Daftar User Portal</span>
            </div>
            <div style="overflow-x:auto;">
                <table class="mtable">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Login Terakhir</th>
                            @if ($isAdmin)
                                <th style="text-align:right;">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td style="font-weight:600;">{{ $user['name'] }}</td>
                                <td>{{ $user['email'] }}</td>
                                <td>
                                    <span class="badge {{ $roleBadges[$user['role']] ?? 'badge-gray' }}">
                                        {{ $user['role'] }}
                                    </span>
                                </td>
                                <td>
                                    @if ($user['is_active'])
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-danger">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="cell-muted">{{ $user['last_login_at'] ?? '—' }}</td>
                                @if ($isAdmin)
                                    <td style="text-align:right;white-space:nowrap;">
                                        <button
                                            type="button"
                                            wire:click="mountAction('edit', { id: {{ $user['id'] }} })"
                                            class="btn-portal btn-portal-icon"
                                            title="Edit"
                                        >
                                            <i class="fa fa-pen" aria-hidden="true"></i>
                                        </button>
                                        <button
                                            type="button"
                                            wire:click="mountAction('delete', { id: {{ $user['id'] }} })"
                                            class="btn-portal btn-portal-icon"
                                            title="Hapus"
                                            style="color:#dc2626;border-color:#fecaca;margin-left:4px;"
                                        >
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $isAdmin ? 6 : 5 }}" class="portal-empty">Belum ada user.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <x-filament-actions::modals />
</x-filament-panels::page>
