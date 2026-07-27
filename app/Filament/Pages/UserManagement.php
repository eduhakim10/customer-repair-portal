<?php

namespace App\Filament\Pages;

use App\Services\WorkshopApi;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class UserManagement extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'User Management';

    protected static ?string $navigationGroup = 'Pengaturan';

    protected static ?string $title = 'User Management';

    protected static ?int $navigationSort = 3;

    protected static string $view = 'filament.pages.user-management';

    private const ROLES = [
        'Admin' => 'Admin',
        'Finance' => 'Finance',
        'Purchasing' => 'Purchasing',
        'Viewer' => 'Viewer',
    ];

    public array $users = [];

    public bool $isAdmin = false;

    public function mount(): void
    {
        $this->isAdmin = (app(WorkshopApi::class)->user()['role'] ?? null) === 'Admin';
        $this->loadUsers();
    }

    public function loadUsers(): void
    {
        $this->users = app(WorkshopApi::class)->users();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('create')
                ->label('Tambah User')
                ->icon('heroicon-o-plus')
                ->visible(fn () => $this->isAdmin)
                ->modalHeading('Tambah User Baru')
                ->form([
                    TextInput::make('name')->label('Nama Lengkap')->required()->maxLength(255),
                    TextInput::make('email')->label('Email')->email()->required(),
                    TextInput::make('password')->label('Password')->password()->minLength(8)->required(),
                    Select::make('role')->label('Role')->options(self::ROLES)->default('Viewer')->required(),
                ])
                ->action(function (array $data): void {
                    $res = app(WorkshopApi::class)->createUser($data);

                    if ($res->successful()) {
                        Notification::make()->title('User berhasil ditambahkan')->success()->send();
                        $this->loadUsers();
                    } else {
                        Notification::make()
                            ->title('Gagal menambah user')
                            ->body($res->json('message') ?? implode(' ', collect($res->json('errors') ?? [])->flatten()->all()))
                            ->danger()
                            ->send();
                    }
                }),
        ];
    }

    public function editAction(): Action
    {
        return Action::make('edit')
            ->label('Edit')
            ->icon('heroicon-o-pencil')
            ->visible(fn () => $this->isAdmin)
            ->modalHeading('Edit User')
            ->fillForm(fn (array $arguments): array => collect($this->users)->firstWhere('id', $arguments['id']) ?? [])
            ->form([
                TextInput::make('name')->label('Nama Lengkap')->required(),
                TextInput::make('email')->label('Email')->email()->required(),
                TextInput::make('password')->label('Password baru')->password()->minLength(8)
                    ->helperText('Kosongkan jika tidak ingin mengubah'),
                Select::make('role')->label('Role')->options(self::ROLES)->required(),
                Toggle::make('is_active')->label('Aktif')->default(true),
            ])
            ->action(function (array $arguments, array $data): void {
                if (empty($data['password'])) {
                    unset($data['password']);
                }

                $res = app(WorkshopApi::class)->updateUser((int) $arguments['id'], $data);

                if ($res->successful()) {
                    Notification::make()->title('User diperbarui')->success()->send();
                    $this->loadUsers();
                } else {
                    Notification::make()->title('Gagal memperbarui user')->body($res->json('message') ?? 'Error')->danger()->send();
                }
            });
    }

    public function deleteAction(): Action
    {
        return Action::make('delete')
            ->label('Hapus')
            ->icon('heroicon-o-trash')
            ->color('danger')
            ->requiresConfirmation()
            ->visible(fn () => $this->isAdmin)
            ->action(function (array $arguments): void {
                $res = app(WorkshopApi::class)->deleteUser((int) $arguments['id']);

                if ($res->successful()) {
                    Notification::make()->title('User dihapus')->success()->send();
                    $this->loadUsers();
                } else {
                    Notification::make()->title('Gagal menghapus user')->body($res->json('message') ?? 'Error')->danger()->send();
                }
            });
    }
}
