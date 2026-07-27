@php
    $modalQ = $this->modalQuotation() ?? [];
    $modalNo = $modalQ['offer_number'] ?? 'penawaran';
@endphp

@if ($activeModal === 'approve')
    <div class="portal-modal-overlay" wire:click.self="closeQuotationModal">
        <div class="portal-modal" role="dialog" aria-modal="true">
            <div class="portal-modal-hd">
                <span class="portal-modal-title">Setujui Penawaran</span>
                <button type="button" class="portal-modal-close" wire:click="closeQuotationModal" aria-label="Tutup">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
            </div>
            <div class="portal-modal-bd">
                <div class="portal-alert portal-alert-success">
                    <i class="fa fa-circle-check" aria-hidden="true"></i>
                    <span>Penawaran <strong>{{ $modalNo }}</strong> akan disetujui.</span>
                </div>
                <div class="portal-field">
                    <label>Upload PO (opsional – bisa diupload nanti)</label>
                    <label class="upload-zone">
                        <i class="fa fa-file-arrow-up" aria-hidden="true"></i>
                        <p>
                            Klik untuk upload file PO<br />
                            <span class="upload-hint">PDF, JPG, PNG — maks 5MB</span>
                        </p>
                        <input type="file" wire:model="modalPoFile" accept=".pdf,.jpg,.jpeg,.png" />
                    </label>
                    @error('modalPoFile') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="portal-field">
                    <label>Catatan (opsional)</label>
                    <textarea wire:model="modalNotes" rows="2" placeholder="Catatan untuk tim MTI..."></textarea>
                </div>
            </div>
            <div class="portal-modal-ft">
                <button type="button" class="btn-portal" wire:click="closeQuotationModal">Batal</button>
                <button type="button" class="btn-portal btn-portal-success" wire:click="submitApprove">
                    <i class="fa fa-check" aria-hidden="true"></i> Setujui
                </button>
            </div>
        </div>
    </div>
@endif

@if ($activeModal === 'reject')
    <div class="portal-modal-overlay" wire:click.self="closeQuotationModal">
        <div class="portal-modal" role="dialog" aria-modal="true">
            <div class="portal-modal-hd">
                <span class="portal-modal-title">Tolak Penawaran</span>
                <button type="button" class="portal-modal-close" wire:click="closeQuotationModal" aria-label="Tutup">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
            </div>
            <div class="portal-modal-bd">
                <div class="portal-alert portal-alert-danger">
                    <i class="fa fa-triangle-exclamation" aria-hidden="true"></i>
                    <span>Penawaran <strong>{{ $modalNo }}</strong> akan ditolak.</span>
                </div>
                <div class="portal-field">
                    <label>Alasan Penolakan <span class="req">*</span></label>
                    <select wire:model="modalReason">
                        <option value="">-- Pilih alasan --</option>
                        <option value="Harga terlalu tinggi">Harga terlalu tinggi</option>
                        <option value="Item tidak sesuai">Item tidak sesuai</option>
                        <option value="Anggaran belum tersedia">Anggaran belum tersedia</option>
                        <option value="Menunggu persetujuan internal">Menunggu persetujuan internal</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                    @error('modalReason') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                <div class="portal-field">
                    <label>Keterangan Tambahan</label>
                    <textarea wire:model="modalNotes" rows="3" placeholder="Jelaskan alasan penolakan..."></textarea>
                </div>
            </div>
            <div class="portal-modal-ft">
                <button type="button" class="btn-portal" wire:click="closeQuotationModal">Batal</button>
                <button type="button" class="btn-portal btn-portal-primary" wire:click="submitReject">
                    <i class="fa fa-times" aria-hidden="true"></i> Tolak Penawaran
                </button>
            </div>
        </div>
    </div>
@endif

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
                <button type="button" class="btn-portal btn-portal-primary" wire:click="submitUploadPo">
                    <i class="fa fa-upload" aria-hidden="true"></i> Upload PO
                </button>
            </div>
        </div>
    </div>
@endif
