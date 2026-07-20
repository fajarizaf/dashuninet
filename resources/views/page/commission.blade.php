@extends('layouts.console')
@section('container')



<!-- Page header -->
<div class="page-header d-print-none text-white">
    <div class="container-xl">
        <div class="row g-3 align-items-center">
            <div class="col-auto col-sm-7 col-md-6 col-lg-auto">
                <div class="d-flex gap-2 align-items-center justify-content-between justify-content-sm-start">
                    <div>
                        <div class="page-pretitle">Sales Order</div>
                        <h2 class="page-title">Comission</h2>
                    </div>
                </div>
            </div>
            <div class="col-auto col-sm-5 col-md-6 col-lg-auto ms-auto d-print-none">
                <div class="d-flex gap-2 justify-content-end">
                    <a class="btn btn-light ms-auto ms-sm-0" data-bs-toggle="offcanvas" href="#offcanvasStart"
                        role="button" aria-controls="offcanvasStart" id="btn-filter" title="Filter">
                        <svg style="margin-right:10px" xmlns="http://www.w3.org/2000/svg"
                            class="icon icon-tabler icon-tabler-filter-search m-0" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M11.36 20.213l-2.36 .787v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414" />
                            <path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                            <path d="M20.2 20.2l1.8 1.8" /> </svg>
                        <span class="d-sm-none d-md-inline">&nbsp;Filter</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

    <div class="">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Records Commission</h3>
            </div>

            @if(session()->has('success'))
                <div class="alert alert-important alert-info alert-dismissible" style="border-radius:0px;" role="alert">
                    <div class="d-flex">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M5 12l5 5l10 -10"></path>
                            </svg>
                        </div>
                        <div>
                            {{ session('success') }}
                        </div>
                    </div>
                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            @endif

            @if(session()->has('failed'))
                <div class="alert alert-important alert-danger alert-dismissible" style="border-radius:0px;"
                    role="alert">
                    <div class="d-flex">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M5 12l5 5l10 -10"></path>
                            </svg>
                        </div>
                        <div>
                            {{ session('failed') }}
                        </div>
                    </div>
                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            @endif

            @if(session()->has('fraud'))
                <div class="alert alert-important alert-warning alert-dismissible" role="alert">
                    <div class="d-flex">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 9v4"></path>
                                <path
                                    d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z">
                                </path>
                                <path d="M12 16h.01"></path>
                            </svg>
                        </div>
                        <div>
                            {{ session('fraud') }}
                        </div>
                    </div>
                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer <br>Number</th>
                            <th>Subscription<br>Name</th>
                            <th>@Price (IDR)</th>
                            <th>Customer Name</th>
                            <th>Sales Name</th>
                            <th>Sales <br>Commission<br>(IDR)</th>
                            <th>Reference <br>By</th>
                            <th>Reference <br>Commission<br>(IDR)</th>
                            <th>Latest <br>Invoice paid</th>
                            <th>Count <br>Invoice<br>paid</th>
                            <th>Ready <br>To Process</th>
                            <th>Payment <br>Status</th>
                            @if(session('role_id') == 3)
                                <th>Action</th>
                            @endif
                            <!-- <th class="text-end">Action</th> -->
                        </tr>
                    </thead>
                    <tbody>

                        @forelse($data as $raw)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="py-2 small">{{ $raw->customer_number }}</td>
                                <td class="py-2 small">{{ $raw->product_name }}
                                    <div class="text-secondary small">{{ $raw->product_plan }}
                                        ({{ $raw->product_type }})</div>
                                </td>
                                <td class="py-2 fw-bold">
                                    {{ number_format($raw->total, 0, ',', '.') }}
                                </td>
                                <td class="py-2 small">{{ $raw->customer_name }}</td>
                                <td class="py-2 small">{{ $raw->sales_name }}</td>
                                <td class="py-2 fw-bold">
                                    {{ $raw->name ? number_format($raw->total*30/100, 0, ',', '.') : number_format($raw->total*50/100, 0, ',', '.') }}
                                </td>
                                <td class="py-2 small">
                                    {{ $raw->name ? $raw->name : '-' }}</td>
                                <td class="py-2 fw-bold">
                                    {{ $raw->name ? number_format($raw->total*20/100, 0) : '-' }}
                                </td>
                                <td class="py-2">{{ $raw->invoice_datepaid }}</td>
                                <td class="py-2">{{ $raw->jml }}</td>
                                <td class="py-2">
                                    @php
                                        $stat = $raw;

                                        if ($raw->jml > 2) {
                                        $bColor = 'text-bg-success';
                                        $text = "Yes";
                                        } else {
                                        $bColor = 'text-bg-secondary';
                                        $text = "No";
                                        }
                                    @endphp
                                    <span class="badge {{ $bColor }}">{{ $text }}</span>

                                </td>
                                <td class="py-2">
                                    @php
                                        $stat = $raw;

                                        if (in_array($stat->payment_status, ['Activated', 'Completed']) === true) {
                                        $badgeColor = 'text-bg-success';
                                        } elseif ($stat->payment_status == 'Pending') {
                                        $badgeColor = 'text-bg-secondary';
                                        } elseif ($stat->payment_status == 'On Progress') {
                                        $badgeColor = 'text-bg-teal';
                                        } else {
                                        $badgeColor = '';
                                        }
                                    @endphp
                                    <span
                                        class="badge {{ $badgeColor }}">{{ $raw->payment_status ?? '-' }}</span>
                                </td>
                                @if(session('role_id') == 3)
                                    <td class="">
                                        <div class="btn-list flex-nowrap">
                                            <div class="dropdown ms-md-auto">
                                                <button class="btn btn-outline-primary dropdown-toggle align-text-top"
                                                    data-bs-toggle="dropdown">
                                                    Actions
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item btn-action" order_id="{{ $raw->id }}"
                                                        p_status="Pending">
                                                        Set Pending
                                                    </a>
                                                    <a class="dropdown-item btn-action" order_id="{{ $raw->id }}"
                                                        p_status="On Progress" href="#">
                                                        Set On Progress
                                                    </a>
                                                    <a class="dropdown-item btn-action" order_id="{{ $raw->id }}"
                                                        p_status="Completed" href="#">
                                                        Set Completed
                                                    </a>

                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                @endif

                            </tr>

                        @empty
                            <tr>
                                <td class="py-2" colspan="8">
                                    <div class="empty">
                                        <p class="empty-title">No results found</p>
                                        <p class="empty-subtitle text-secondary">
                                            Try adjusting your search or filter to find what you're looking for.
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
<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />

@include('component.canvas.filter-comission')



<script>
    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('#_token').val()
            }
        });

        $('.btn-action').click(function () {
            var order_id = $(this).attr('order_id');
            var p_status = $(this).attr('p_status');
            console.log(order_id);
            console.log(p_status);
            $.ajax({
                type: 'POST',
                url: "{{ route('set_payment_status') }}",
                data: {
                    order_id: order_id,
                    p_status: p_status
                },
                success: function (data) {
                    window.location.reload();
                }
            });
        });

    });

</script>


@endsection
