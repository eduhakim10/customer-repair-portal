<?php

namespace App\Filament\Concerns;

use Filament\Notifications\Notification;
use Livewire\Features\SupportFileUploads\WithFileUploads;

trait HandlesQuotationModals
{
    use WithFileUploads;

    public ?string $activeModal = null;

    public ?int $modalQuotationId = null;

    public $modalPoFile = null;

    public string $modalNotes = '';

    public string $modalReason = '';

    public string $modalPoNumber = '';

    public string $modalPoDate = '';

    public function openQuotationModal(string $type, int $id): void
    {
        $this->resetModalForm();
        $this->activeModal = $type;
        $this->modalQuotationId = $id;
    }

    public function closeQuotationModal(): void
    {
        $this->activeModal = null;
        $this->modalQuotationId = null;
        $this->resetModalForm();
    }

    public function submitApprove(): void
    {
        $q = $this->findQuotationForModal($this->modalQuotationId);
        $this->closeQuotationModal();

        Notification::make()
            ->title('Penawaran disetujui')
            ->body(($q['offer_number'] ?? 'Penawaran') . ' berhasil disetujui.')
            ->success()
            ->send();
    }

    public function submitReject(): void
    {
        $this->validate([
            'modalReason' => 'required|string',
        ], [
            'modalReason.required' => 'Pilih alasan penolakan.',
        ]);

        $q = $this->findQuotationForModal($this->modalQuotationId);
        $this->closeQuotationModal();

        Notification::make()
            ->title('Penawaran ditolak')
            ->body(($q['offer_number'] ?? 'Penawaran') . ' telah ditolak. Tim MTI akan diberitahu.')
            ->danger()
            ->send();
    }

    public function submitUploadPo(): void
    {
        $this->validate([
            'modalPoNumber' => 'required|string',
            'modalPoDate' => 'required|date',
            'modalPoFile' => 'required|file|mimes:pdf|max:10240',
        ], [
            'modalPoNumber.required' => 'No. PO wajib diisi.',
            'modalPoDate.required' => 'Tanggal PO wajib diisi.',
            'modalPoFile.required' => 'File PO wajib diupload.',
        ]);

        $q = $this->findQuotationForModal($this->modalQuotationId);
        $this->closeQuotationModal();

        Notification::make()
            ->title('PO berhasil diupload')
            ->body('File PO untuk ' . ($q['offer_number'] ?? 'penawaran') . ' tersimpan dan dikirim ke MTI.')
            ->success()
            ->send();
    }

    /**
     * @return array<string, mixed>|null
     */
    public function modalQuotation(): ?array
    {
        return $this->findQuotationForModal($this->modalQuotationId);
    }

    protected function resetModalForm(): void
    {
        $this->modalPoFile = null;
        $this->modalNotes = '';
        $this->modalReason = '';
        $this->modalPoNumber = '';
        $this->modalPoDate = '';
        $this->resetValidation();
    }

    /**
     * @return array<string, mixed>|null
     */
    abstract protected function findQuotationForModal(?int $id): ?array;
}
