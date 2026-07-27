<?php

namespace App\Filament\Pages\Auth;

use App\Auth\PortalUser;
use App\Services\WorkshopApi;
use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    protected static string $layout = 'filament.layouts.auth';

    protected static string $view = 'filament.pages.auth.login';

    public function hasLogo(): bool
    {
        return false;
    }

    public function getTitle(): string|Htmlable
    {
        return 'Masuk – MTI Customer Portal';
    }

    public function getHeading(): string|Htmlable
    {
        return '';
    }

    public function getSubHeading(): ?string
    {
        return null;
    }

    public function authenticate(): ?LoginResponse
    {
        $data = $this->form->getState();

        $user = app(WorkshopApi::class)->login($data['email'], $data['password']);

        if (! $user) {
            throw ValidationException::withMessages([
                'data.email' => 'Email atau password salah.',
            ]);
        }

        Filament::auth()->login(
            PortalUser::fromArray($user),
            $data['remember'] ?? false,
        );

        session()->regenerate();

        return app(LoginResponse::class);
    }
}
