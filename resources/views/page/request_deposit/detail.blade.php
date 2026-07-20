@extends('layouts.console')
@section('container')

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    Request Deposit
                </div>
                <h2 class="page-title">
                    Detail Request #{{ $deposit->id }}
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{ url('/console/request-deposit') }}" class="btn btn-outline-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
                        Kembali
                    </a>
                    @if($deposit->status_id != 1035 && $deposit->status_id != 1040)
                    <button class="btn btn-warning" onclick="setInProgress({{ $deposit->id }})">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 7v5l3 3" /></svg>
                        Set In Progress
                    </button>
                    @endif
                    @if($deposit->status_id != 1035)
                    <button class="btn btn-success" onclick="approveDeposit({{ $deposit->id }})">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M5 12l5 5l10 -10" /></svg>
                        Approve Request
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <!-- Informasi Request Deposit -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-wallet me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12"></path><path d="M20 12v4h-4a2 2 0 0 1 0 -4h4"></path></svg>
                            Informasi Request Deposit
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">ID Request</label>
                                    <span class="badge bg-blue text-blue-fg">#REQDEP-{{ $deposit->id }}</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Customer</label>
                                    <div class="form-control-plaintext">
                                        <div class="fw-bold">{{ $deposit->customer->customer_name ?? '-' }}</div>
                                        <div class="text-secondary small">{{ $deposit->customer->customer_email ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Amount</label>
                                    <div class="form-control-plaintext">
                                        <span class="text-success fw-bold fs-3">Rp {{ number_format($deposit->amount, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Payment Method</label>
                                    <div class="form-control-plaintext">
                                        <span class="badge">{{ $deposit->payment_method }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <div class="form-control-plaintext">
                                        @if($deposit->status_id == 1034)
                            <span class="badge bg-warning text-warning-fg">Pending</span>
                        @elseif($deposit->status_id == 1040)
                            <span class="badge bg-orange text-orange-fg">In Progress</span>
                        @elseif($deposit->status_id == 1035)
                            <span class="badge bg-success text-success-fg">Approved</span>
                        @else
                            <span class="badge">{{ $deposit->status->status_name ?? 'Unknown' }}</span>
                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Request</label>
                                    <div class="form-control-plaintext">
                                        {{ $deposit->request_date ? \Carbon\Carbon::parse($deposit->request_date)->format('d M Y H:i') : '-' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Proses</label>
                                    <div class="form-control-plaintext">
                                        {{ $deposit->process_date ? \Carbon\Carbon::parse($deposit->process_date)->format('d M Y H:i') : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Invoice -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-invoice me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M9 7l1 0" /><path d="M9 13l6 0" /><path d="M13 17l2 0" /></svg>
                            Informasi Invoice
                        </h3>
                    </div>
                    <div class="card-body">
                        @if($deposit->invoice)
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Invoice Number</label>
                                    <div class="form-control-plaintext">
                                        <span class="badge bg-blue text-blue-fg">#{{ $deposit->invoice->id }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Invoice Date</label>
                                    <div class="form-control-plaintext">
                                        {{ $deposit->invoice->invoice_date ? \Carbon\Carbon::parse($deposit->invoice->invoice_date)->format('d M Y') : '-' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Due Date</label>
                                    <div class="form-control-plaintext">
                                        {{ $deposit->invoice->invoice_duedate ? \Carbon\Carbon::parse($deposit->invoice->invoice_duedate)->format('d M Y') : '-' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Subtotal</label>
                                    <div class="form-control-plaintext">
                                        Rp {{ number_format($deposit->invoice->subtotal, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Total</label>
                                    <div class="form-control-plaintext">
                                        <span class="fw-bold">Rp {{ number_format($deposit->invoice->total, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Status Invoice</label>
                                    <div class="form-control-plaintext">
                                        @if($deposit->invoice->status_id == 1036)
                                            <span class="badge bg-success text-success-fg">Paid</span>
                                        @else
                                            <span class="badge bg-warning text-warning-fg">Unpaid</span>
                                        @endif
                                        <a href="{{ url('/console/invoices/detail/' . $deposit->invoice->id) }}" class="btn btn-outline-primary ms-2" title="Lihat Detail Invoice">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="m0 0h24v24H0z" fill="none"/>
                                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                                <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                                            </svg>
                                            Lihat Invoices
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Bukti Pembayaran</label>
                                    <div class="form-control-plaintext">
                                        @if($deposit->invoice->invoicesProofPayment->count() > 0 && $deposit->invoice->invoicesProofPayment->first()->file)
                                            <div class="d-flex gap-2 mb-2">
                                                <button class="btn btn-outline-primary btn-sm" onclick="viewProof({{ $deposit->invoice->id }})">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                                    Preview Bukti
                                                </button>
                                                <button class="btn btn-outline-success btn-sm" onclick="showUploadForm({{ $deposit->invoice->id }})">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-upload" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 9l5 -5l5 5" /><path d="M12 4l0 12" /></svg>
                                                    Ganti Bukti
                                                </button>
                                            </div>
                                            <small class="text-success">✓ Bukti pembayaran sudah diupload</small>
                                        @else
                                            <div class="alert alert-info">
                                                Pelanggan belum melakukan upload bukti transfer melalui portal pelanggan.
                                            </div>
                                            <small class="text-warning">Belum ada bukti pembayaran</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="text-center text-secondary py-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-x" width="48" height="48" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M10 12l4 4m0 -4l-4 4" /></svg>
                            <div class="mt-3">Invoice tidak ditemukan</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Timeline/History -->
        <div class="row row-deck row-cards mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock-history me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M20.983 12.548a9 9 0 1 0 -8.45 8.436" /><path d="M12 7v5l2 2" /><path d="M19 22v-6" /><path d="M22 19l-3 -3l-3 3" /></svg>
                            Timeline Request
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-point timeline-point-primary"></div>
                                <div class="timeline-content">
                                    <div class="timeline-time">{{ $deposit->created_at ? $deposit->created_at->format('d M Y H:i') : '-' }}</div>
                                    <div class="timeline-title">Request Deposit Dibuat</div>
                                    <div class="text-secondary">Request deposit dengan amount Rp {{ number_format($deposit->amount, 0, ',', '.') }} telah dibuat</div>
                                </div>
                            </div>
                            <br/>
                            @if($deposit->process_date && $deposit->status_id == 1040)
                            <div class="timeline-item">
                                <div class="timeline-point timeline-point-warning"></div>
                                <div class="timeline-content">
                                    <div class="timeline-time">{{ \Carbon\Carbon::parse($deposit->process_date)->format('d M Y H:i') }}</div>
                                    <div class="timeline-title">Request Deposit In Progress</div>
                                    <div class="text-secondary">Request deposit sedang dalam proses</div>
                                </div>
                            </div>
                            <br/>
                            @endif
                            @if($deposit->process_date && $deposit->status_id == 1035)
                            <div class="timeline-item">
                                <div class="timeline-point timeline-point-success"></div>
                                <div class="timeline-content">
                                    <div class="timeline-time">{{ \Carbon\Carbon::parse($deposit->process_date)->format('d M Y H:i') }}</div>
                                    <div class="timeline-title">Request Deposit Diapprove</div>
                                    <div class="text-secondary">Request deposit telah disetujui dan status invoice diubah menjadi paid</div>
                                </div>
                            </div>
                            @endif
                            <br/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk menampilkan bukti pembayaran -->
<div class="modal modal-blur fade" id="proofModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bukti Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div id="proofContent">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk upload bukti transfer -->
<div class="modal modal-blur fade" id="uploadModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Bukti Transfer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="uploadForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pilih File Bukti Transfer</label>
                        <input type="file" class="form-control" id="proofFile" name="proof_file" accept=".jpg,.jpeg,.png,.pdf" required>
                        <div class="form-text">Format yang didukung: JPG, JPEG, PNG, PDF. Maksimal 5MB.</div>
                    </div>
                    <div class="mb-3">
                        <div id="filePreview" class="text-center" style="display: none;">
                            <img id="previewImage" src="" alt="Preview" class="img-fluid" style="max-height: 200px;">
                            <div id="previewPdf" style="display: none;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-type-pdf" width="48" height="48" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4"/><path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4"/><path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6"/><path d="M17 18h2"/><path d="M20 15h-3v6"/><path d="M11 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1z"/></svg>
                                <div class="mt-2">File PDF dipilih</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="uploadBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-upload" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 9l5 -5l5 5" /><path d="M12 4l0 12" /></svg>
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let currentInvoiceId = null;

function setInProgress(depositId) {
    if (confirm('Apakah Anda yakin ingin mengubah status request deposit ini menjadi In Progress?')) {
        fetch(`/console/request-deposit/${depositId}/set-in-progress`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Status request deposit berhasil diubah menjadi In Progress!');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memproses request');
        });
    }
}

function approveDeposit(depositId) {
    if (confirm('Apakah Anda yakin ingin menyetujui request deposit ini?')) {
        fetch(`/console/request-deposit/${depositId}/approve`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Request deposit berhasil diapprove!');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memproses request');
        });
    }
}

function viewProof(invoiceId) {
    const modal = new bootstrap.Modal(document.getElementById('proofModal'));
    const proofContent = document.getElementById('proofContent');
    
    // Reset content
    proofContent.innerHTML = '<div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>';
    
    // Show modal
    modal.show();
    
    // Load proof image
    fetch(`/console/request-deposit/proof/${invoiceId}`)
        .then(response => {
            if (response.ok) {
                return response.blob();
            }
            throw new Error('File tidak ditemukan');
        })
        .then(blob => {
            const imageUrl = URL.createObjectURL(blob);
            const contentType = blob.type;
            
            if (contentType.startsWith('image/')) {
                proofContent.innerHTML = `<img src="${imageUrl}" class="img-fluid" alt="Bukti Pembayaran">`;
            } else if (contentType === 'application/pdf') {
                proofContent.innerHTML = `
                    <div class="text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-type-pdf" width="64" height="64" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4"/><path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4"/><path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6"/><path d="M17 18h2"/><path d="M20 15h-3v6"/><path d="M11 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1z"/></svg>
                        <div class="mt-3">File PDF</div>
                        <a href="${imageUrl}" target="_blank" class="btn btn-primary mt-2">Buka PDF</a>
                    </div>
                `;
            } else {
                proofContent.innerHTML = `<div class="text-info">File: ${blob.type}</div>`;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            proofContent.innerHTML = '<div class="text-danger">Gagal memuat bukti pembayaran</div>';
        });
}

function showUploadForm(invoiceId) {
    currentInvoiceId = invoiceId;
    const modal = new bootstrap.Modal(document.getElementById('uploadModal'));
    
    // Reset form
    document.getElementById('uploadForm').reset();
    document.getElementById('filePreview').style.display = 'none';
    
    modal.show();
}

// File preview handler
document.getElementById('proofFile').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('filePreview');
    const previewImage = document.getElementById('previewImage');
    const previewPdf = document.getElementById('previewPdf');
    
    if (file) {
        preview.style.display = 'block';
        
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';
                previewPdf.style.display = 'none';
            };
            reader.readAsDataURL(file);
        } else if (file.type === 'application/pdf') {
            previewImage.style.display = 'none';
            previewPdf.style.display = 'block';
        }
    } else {
        preview.style.display = 'none';
    }
});

// Upload form handler
document.getElementById('uploadForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData();
    const fileInput = document.getElementById('proofFile');
    const uploadBtn = document.getElementById('uploadBtn');
    
    if (!fileInput.files[0]) {
        alert('Silakan pilih file terlebih dahulu');
        return;
    }
    
    formData.append('proof_file', fileInput.files[0]);
    
    // Disable button and show loading
    uploadBtn.disabled = true;
    uploadBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Uploading...';
    
    fetch(`/console/request-deposit/upload-proof/${currentInvoiceId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Bukti transfer berhasil diupload!');
            bootstrap.Modal.getInstance(document.getElementById('uploadModal')).hide();
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat upload file');
    })
    .finally(() => {
        // Re-enable button
        uploadBtn.disabled = false;
        uploadBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-upload" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 9l5 -5l5 5" /><path d="M12 4l0 12" /></svg> Upload';
    });
});
</script>

@endsection