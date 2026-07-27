@php
    $user = app(\App\Services\WorkshopApi::class)->user() ?? [];
    $name = $user['customer_name'] ?? $user['name'] ?? 'Customer';
    $email = $user['email'] ?? '';
    $parts = preg_split('/\s+/', trim($name)) ?: ['C'];
    $initials = strtoupper(substr($parts[0], 0, 1) . substr($parts[1] ?? '', 0, 1));
@endphp

<div class="portal-sidebar-footer">
    <div class="portal-sb-user">
        <div class="portal-sb-avatar">{{ $initials }}</div>
        <div class="portal-sb-user-info">
            <div class="portal-sb-uname">{{ $name }}</div>
            <div class="portal-sb-uemail">{{ $email }}</div>
        </div>
    </div>

    <form action="{{ filament()->getLogoutUrl() }}" method="post" class="portal-sb-logout-form">
        @csrf
        <button type="submit" class="portal-sb-logout">
            <i class="fa fa-right-from-bracket" aria-hidden="true"></i>
            Keluar
        </button>
    </form>
</div>
