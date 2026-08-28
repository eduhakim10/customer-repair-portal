@php
    $modalQ = $this->modalQuotation() ?? [];
    $modalNo = $modalQ['offer_number'] ?? 'penawaran';
@endphp

@if ($activeModal === 'uploadPo')
    <div class="portal-modal-overlay" wire:click.self="closeQuotationModal">
        <div class="portal-modal" role="dialog" aria-modal="true">
            <div class="portal-modal-hd">
                <span class="portal-modal-title">Upload Purchase Order</span>
                <button type="button" class="portal-modal-close" wire:click="closeQuotationModal" aria-label="Tutup">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
            </div>
            <div class="portal-modal-bd">
                <div class="portal-field">
                    <label>No. PO <span class="req">*</span></label>
                    <input type="text" wire:model="modalPoNumber" placeholder="Cth: PO-2025-0042" />
                    @error('modalPoNumber') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="portal-field">
                    <label>Tanggal PO <span class="req">*</span></label>
                    <input type="date" wire:model="modalPoDate" />
                    @error('modalPoDate') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="portal-field">
                    <label>File PO <span class="req">*</span></label>
                    <label class="upload-zone">
                        <i class="fa fa-file-pdf" style="color:#dc2626;" aria-hidden="true"></i>
                        <p>
                            Drag & drop atau klik untuk pilih file<br />
                            <span class="upload-hint">PDF maks 10MB</span>
                        </p>
                        <input type="file" wire:model="modalPoFile" accept=".pdf" />
                    </label>
                    @error('modalPoFile') <span class="field-error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="portal-modal-ft">
                <button type="button" class="btn-portal" wire:click="closeQuotationModal">Batal</button>
                <button type="button" class="btn-portal btn-portal-primary" wire:click="submitUploadPo" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="submitUploadPo">
                        <i class="fa fa-upload" aria-hidden="true"></i> Upload PO
                    </span>
                    <span wire:loading wire:target="submitUploadPo">Mengunggah…</span>
                </button>
            </div>
        </div>
    </div>
@endif
