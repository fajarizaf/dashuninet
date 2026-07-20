@extends('layouts.console')
@section('container')

@include('component.canvas.navbar-customer')

<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-6 col-sm-4 col-lg-3 col-xl-2">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-success text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="fw-bold text-uppercase">
                                    Deposit
                                </div>
                                <div class="text-secondary small">
                                    {{ $count_deposit }} Transaksi
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
                                <span class="bg-danger text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-minus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M5 12l14 0" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="fw-bold text-uppercase">
                                    Transaction
                                </div>
                                <div class="text-secondary small">
                                    {{ $count_usage }} Transaksi
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br />

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Balance History</h3>
            </div>

            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th class="text-center">Tipe</th>
                            <th class="text-center">Deskripsi</th>
                            <th class="text-center">Nominal (IDR)</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse($data as $raw)
                            <tr style="font-size:14px;">
                                <td class="py-2">{{$loop->iteration}}</td>
                                <td class="py-2">{{ $raw->created_at->format('d/m/Y H:i') }}</td>
                                <td class="py-2 text-center">
                                    @if($raw->is_deposit == 1)
                                        Deposit
                                    @else
                                        Penggunaan
                                    @endif
                                </td>
                                <td class="py-2 text-center">
                                    @if($raw->is_deposit == 1)
                                        Penambahan Saldo
                                    @else
                                        Pembayaran Invoice #INV-{{ $raw->invoice_id }}
                                        <a href="{{ url('/console/invoices/detail/' . $raw->invoice_id) }}" class="ms-2 text-primary" title="Lihat Detail Invoice">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="m0 0h24v24H0z" fill="none"/>
                                                <circle cx="12" cy="12" r="2" />
                                                <path d="m22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" />
                                            </svg>
                                        </a>
                                    @endif
                                </td>
                                <td class="py-2 text-center">
                                    @if($raw->is_deposit == 1)
                                        <span class="text-success">+{{ number_format($raw->amount_in, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-danger">-{{ number_format($raw->amount_in, 0, ',', '.') }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty

                            <tr>
                                <td class="py-2" colspan="7">

                                    <div class="empty">
                                        <p class="empty-title">Tidak ada riwayat saldo</p>
                                        <p class="empty-subtitle text-secondary">
                                            Belum ada transaksi saldo untuk customer ini.
                                        </p>
                                    </div>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex align-items-center">
                <ul class="pagination m-0 ms-auto">
                    {{ $data->appends(request()->query())->links() }}
                </ul>
            </div>
        </div>


    </div>
</div>

@endsection

<style>
    .navbar-overlap:after {
        height:0px !important;
    }
</style>
