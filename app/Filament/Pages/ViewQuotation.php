<?php

namespace App\Filament\Pages;

use App\Filament\Concerns\HandlesQuotationModals;
use App\Services\WorkshopApi;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class ViewQuotation extends Page
{
    use HandlesQuotationModals;

    protected static ?string $slug = 'quotations/{record}';

    protected static bool $shouldRegisterNavigation = false;

    protected static string $view = 'filament.pages.view-quotation';

    public int $record;

    public ?array $quotation = null;

    public function getTitle(): string|Htmlable
    {
        return $this->quotation['offer_number'] ?? 'Detail Penawaran';
    }

    public function getHeading(): string|Htmlable
    {
        return '';
    }

    public function getBreadcrumbs(): array
    {
        return [
            Quotations::getUrl() => 'Penawaran',
            $this->quotation['offer_number'] ?? 'Detail',
        ];
    }

    public function mount(int $record): void
    {
        $this->record = $record;
        $this->quotation = app(WorkshopApi::class)->quotation($record);

        if (! $this->quotation) {
            abort(404);
        }
    }

    public function printQuotation(): void
    {
        Notification::make()
            ->title('Cetak penawaran')
            ->body('Fitur cetak akan segera tersedia.')
            ->info()
            ->send();
    }

    protected function findQuotationForModal(?int $id): ?array
    {
        if (! $id || $id !== $this->record) {
            return $this->quotation;
        }

        return $this->quotation;
    }
}
