<div class="auth-container">
    <div class="auth-brand">
        <div class="auth-logo-mark" aria-hidden="true">MTI</div>
        <div class="auth-brand-name">Customer Portal</div>
        <div class="auth-brand-sub">PT Mitra Toyotaka Indonesia</div>
    </div>

    <div class="auth-card">
        <div class="auth-card-header">
            <h1 class="auth-card-title">Masuk ke akun Anda</h1>
            <p class="auth-card-desc">Masukkan email dan kata sandi untuk melanjutkan</p>
        </div>

        <div class="auth-card-body">
            @if (app()->environment('local'))
                <div class="demo-box">
                    <strong>Demo Credentials</strong>
                    admin@customer.mti.co.id &nbsp;/&nbsp; password
                </div>
            @endif

            <form wire:submit="authenticate" class="auth-form">
                <div class="field">
                    <label for="email">Alamat Email</label>
                    <input
                        type="email"
                        id="email"
                        wire:model="data.email"
                        placeholder="you@company.com"
                        autocomplete="email"
                        autofocus
                        required
                    />
                    @error('data.email')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="field">
                    <label for="password">Kata Sandi</label>
                    <div class="password-wrap" x-data="{ show: false }">
                        <input
                            :type="show ? 'text' : 'password'"
                            id="password"
                            wire:model="data.password"
                            placeholder="••••••••"
                            autocomplete="current-password"
                            required
                        />
                        <button type="button" class="password-toggle" @click="show = !show" tabindex="-1" aria-label="Tampilkan kata sandi">
                            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16" height="16">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            <svg x-show="show" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16" height="16">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12c1.292 4.338 5.31 7.5 10.066 7.5.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </button>
                    </div>
                    @error('data.password')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="remember-row">
                    <label class="remember-label">
                        <input type="checkbox" wire:model="data.remember" />
                        Ingat saya
                    </label>
                </div>

                <button type="submit" class="btn-signin" wire:loading.attr="disabled" wire:target="authenticate">
                    <span wire:loading.remove wire:target="authenticate">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="16" height="16" style="flex-shrink:0">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                        </svg>
                        Masuk
                    </span>
                    <span wire:loading wire:target="authenticate">Memproses...</span>
                </button>
            </form>

            <div class="auth-divider"></div>
            <p class="auth-help">
                Belum punya akun? Hubungi admin MTI di
                <a href="mailto:support@mti.co.id">support@mti.co.id</a>
            </p>
        </div>
    </div>

    <p class="auth-footer">
        &copy; {{ date('Y') }} <strong>PT Mitra Toyotaka Indonesia</strong>
        &nbsp;·&nbsp; Customer Portal v1.0
    </p>
</div>
