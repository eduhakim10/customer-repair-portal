<?php

namespace App\Filament\Concerns;

use App\Services\WorkshopApi;
use Filament\Notifications\Notification;
use Livewire\Features\SupportFileUploads\WithFileUploads;

trait HandlesQuotationModals
{
    use WithFileUploads;

    public ?string $activeModal = null;

    public ?int $modalQuotationId = null;

    public $modalPoFile = null;

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

    public function submitUploadPo(): void
    {
        $this->validate([
            'modalPoNumber' => 'required|string|max:100',
            'modalPoDate' => 'required|date',
            'modalPoFile' => 'required|file|mimes:pdf|max:10240',
        ], [
            'modalPoNumber.required' => 'No. PO wajib diisi.',
            'modalPoDate.required' => 'Tanggal PO wajib diisi.',
            'modalPoFile.required' => 'File PO wajib diupload.',
            'modalPoFile.mimes' => 'File PO harus berformat PDF.',
            'modalPoFile.max' => 'Ukuran file maksimal 10MB.',
        ]);

        $id = $this->modalQuotationId;
        $q = $this->findQuotationForModal($id);

        if (! $id || ! $this->modalPoFile) {
            return;
        }

        try {
            $res = app(WorkshopApi::class)->uploadPo(
                $id,
                $this->modalPoNumber,
                $this->modalPoDate,
                $this->modalPoFile,
            );
        } catch (\Throwable $e) {
            report($e);

            Notification::make()
                ->title('Gagal upload PO')
                ->body('Tidak dapat terhubung ke server workshop. Periksa WORKSHOP_API_URL / koneksi server.')
                ->danger()
                ->send();

            return;
        }

        if (! $res->successful()) {
            Notification::make()
                ->title('Gagal upload PO')
                ->body($res->json('message') ?? 'Terjadi kesalahan. Coba lagi.')
                ->danger()
                ->send();

            return;
        }

        $this->closeQuotationModal();
        $this->afterQuotationMutation();

        Notification::make()
            ->title('PO berhasil diupload')
            ->body('Penawaran ' . ($q['offer_number'] ?? '') . ' disetujui. File PO telah dikirim ke MTI.')
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
        $this->modalPoNumber = '';
        $this->modalPoDate = '';
        $this->resetValidation();
    }

    /** Hook for pages to refresh list/detail after upload PO. */
    protected function afterQuotationMutation(): void
    {
        //
    }

    /**
     * @return array<string, mixed>|null
     */
    abstract protected function findQuotationForModal(?int $id): ?array;
}
