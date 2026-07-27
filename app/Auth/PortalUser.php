<?php

namespace App\Auth;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * Lightweight authenticatable representing a logged-in customer portal user.
 * Backed by the API response stored in the session (no local DB table).
 */
class PortalUser implements Authenticatable, FilamentUser, HasAvatar, HasName
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public string $role,
        public ?int $customerId = null,
        public ?string $customerName = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) ($data['id'] ?? 0),
            name: (string) ($data['name'] ?? ''),
            email: (string) ($data['email'] ?? ''),
            role: (string) ($data['role'] ?? 'Viewer'),
            customerId: isset($data['customer_id']) ? (int) $data['customer_id'] : null,
            customerName: $data['customer_name'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'customer_id' => $this->customerId,
            'customer_name' => $this->customerName,
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'Admin';
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function getFilamentName(): string
    {
        return $this->name;
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return null;
    }

    /**
     * Eloquent-compat helpers used by Filament (notifications, user menu, etc.).
     */
    public function getKey(): int
    {
        return $this->id;
    }

    public function getAttributeValue(string $key): mixed
    {
        return $this->getAttribute($key);
    }

    public function getAttribute(string $key): mixed
    {
        return match ($key) {
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'customer_id' => $this->customerId,
            'customer_name' => $this->customerName,
            'avatar_url' => null,
            default => null,
        };
    }

    // --- Authenticatable ---
    public function getAuthIdentifierName(): string
    {
        return 'id';
    }

    public function getAuthIdentifier(): mixed
    {
        return $this->id;
    }

    public function getAuthPasswordName(): string
    {
        return 'password';
    }

    public function getAuthPassword(): string
    {
        return '';
    }

    public function getRememberToken(): string
    {
        return '';
    }

    public function setRememberToken($value): void {}

    public function getRememberTokenName(): string
    {
        return '';
    }
}
