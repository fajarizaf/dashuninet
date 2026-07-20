@extends('layouts.console')
@section('container')


<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-6 col-sm-4 col-lg-3 col-xl-2">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-warning text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 7v5l3 3" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="fw-bold text-uppercase">
                                    Pending
                                </div>
                                <div class="text-secondary small">
                                    {{ $data->where('status_id', 1034)->count() }} Request
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-lg-3 col-xl-2">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-success text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M5 12l5 5l10 -10" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="fw-bold text-uppercase">
                                    Approved
                                </div>
                                <div class="text-secondary small">
                                    {{ $data->where('status_id', 1035)->count() }} Request
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br/>
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Daftar Request Deposit</h3>
                        <div class="d-flex gap-2">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTopupDeposit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9v6" /><path d="M9 12h6" /><path d="M12 3a9 9 0 1 0 9 9a9 9 0 0 0 -9 -9" /></svg>
                            <span>&nbsp;Topup Deposit</span>
                        </button>
                        <a class="btn btn-outline-primary" data-bs-toggle="offcanvas" href="#offcanvasStart" role="button" aria-controls="offcanvasStart" id="btn-filter">
                            <svg style="margin-right:10px" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-filter-search m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M11.36 20.213l-2.36 .787v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414" /><path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M20.2 20.2l1.8 1.8" /></svg>
                            <span>&nbsp;Filter</span>
                        </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Invoice</th>
                                    <th>Amount</th>
                                    <th>Payment Method</th>
                                    <th>Request Date</th>
                                    <th>Status</th>
                                    <th class="w-1">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $deposit)
                                <tr>
                                    <td>
                                        <span class="text-secondary">#{{ $deposit->id }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex py-1 align-items-center">
                                            <div class="flex-fill">
                                                @if($deposit->customer)
                                                    <div class="font-weight-medium">
                                                        <a href="{{ url('/console/customer/detail/' . $deposit->customer->id) }}" class="text-decoration-none">
                                                            {{ $deposit->customer->customer_name }}
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="font-weight-medium">-</div>
                                                @endif
                                                <div class="text-secondary">{{ $deposit->customer->customer_email ?? '-' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($deposit->invoice)
                                            <span class="badge bg-blue text-blue-fg">INV-{{ $deposit->invoice->id }}</span>
                                        @else
                                            <span class="text-secondary">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="text-success fw-bold">Rp {{ number_format($deposit->amount, 0, ',', '.') }}</span>
                                    </td>
                                    <td>
                                        @if($deposit->payment_method)
                                            <span class="badge">{{ $deposit->payment_method }}</span>
                                        @else
                                            <span class="text-secondary">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $deposit->request_date ? \Carbon\Carbon::parse($deposit->request_date)->format('d M Y H:i') : '-' }}
                                    </td>
                                    <td>
                                        @if($deposit->status_id == 1034)
                                            <span class="badge bg-warning text-warning-fg">Pending</span>
                                        @elseif($deposit->status_id == 1035)
                                            <span class="badge bg-success text-success-fg">Approved</span>
                                        @elseif($deposit->status && $deposit->status->status_name)
                                            <span class="badge">{{ $deposit->status->status_name }}</span>
                                        @else
                                            <span class="badge">Status ID: {{ $deposit->status_id ?? 'N/A' }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-list flex-nowrap">
                                            <a href="{{ url('/console/request-deposit/' . $deposit->id) }}" class="btn btn-sm btn-outline-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                                Detail
                                            </a>
                                            @if($deposit->status_id == 1034)
                                            <button class="btn btn-sm btn-success" onclick="approveDeposit({{ $deposit->id }})">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M5 12l5 5l10 -10" /></svg>
                                                Approve
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-secondary py-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-inbox" width="48" height="48" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" /><path d="M4 13h3l3 3h4l3 -3h3" /></svg>
                                        <div class="mt-3">Tidak ada data request deposit</div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($data->hasPages())
                    <div class="card-footer d-flex align-items-center">
                        {{ $data->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Offcanvas -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasStart" aria-labelledby="offcanvasStartLabel">
    <div class="offcanvas-header">
        <h2 class="offcanvas-title" id="offcanvasStartLabel">Filter Request Deposit</h2>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form method="GET" action="{{ url('/console/request-deposit') }}">
            <div class="mb-3">
                <label class="form-label">Tanggal Request (Dari)</label>
                <input type="date" class="form-control" name="request_date_from" value="{{ $request->request_date_from }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal Request (Sampai)</label>
                <input type="date" class="form-control" name="request_date_to" value="{{ $request->request_date_to }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Customer</label>
                <input type="text" class="form-control" name="customer_name" placeholder="Nama customer" value="{{ $request->customer_name }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select class="form-select" name="status_id">
                    <option value="">Semua Status</option>
                    @foreach($statuses as $status)
                    <option value="{{ $status->id }}" {{ $request->status_id == $status->id ? 'selected' : '' }}>
                        {{ $status->status_name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Amount (Dari)</label>
                <input type="number" class="form-control" name="amount_from" placeholder="0" value="{{ $request->amount_from }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Amount (Sampai)</label>
                <input type="number" class="form-control" name="amount_to" placeholder="0" value="{{ $request->amount_to }}">
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary w-100">Apply Filter</button>
                <a href="{{ url('/console/request-deposit') }}" class="btn btn-outline-secondary w-100 mt-2">Reset Filter</a>
            </div>
        </form>
    </div>
</div>

<!-- Modal Topup Deposit -->
<div class="modal fade" id="modalTopupDeposit" tabindex="-1" aria-labelledby="modalTopupDepositLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTopupDepositLabel">Topup Deposit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formTopupDeposit">
          <div class="mb-3">
            <label class="form-label">Customer</label>
            <select class="form-select" name="customer_id" required>
              <option value="">Pilih Customer</option>
              @foreach($customers as $cust)
                <option value="{{ $cust->id }}">{{ $cust->customer_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Amount (Rp)</label>
            <input type="number" class="form-control" name="amount" min="1" placeholder="0" required />
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" onclick="submitTopupDeposit()">Buat Topup</button>
      </div>
    </div>
  </div>
  </div>

<script>
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

function submitTopupDeposit() {
    const form = document.getElementById('formTopupDeposit');
    const formData = new FormData(form);
    const payload = {
        customer_id: formData.get('customer_id'),
        amount: formData.get('amount')
    };

    if (!payload.customer_id || !payload.amount) {
        alert('Mohon lengkapi data topup');
        return;
    }

    fetch('/console/request-deposit/create', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Topup deposit berhasil dibuat');
            // Tutup modal lalu reload
            const modalEl = document.getElementById('modalTopupDeposit');
            const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
            modal.hide();
            location.reload();
        } else {
            alert('Error: ' + (data.message || 'Gagal membuat topup'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat membuat topup deposit');
    });
}
</script>

@endsection