@extends('layouts.console')
@section('container')



<!-- Page header -->
<div class="page-header d-print-none text-white">
    <div class="container-xl">
        <div class="row g-3 align-items-center">
            <div class="col-12 col-sm-7 col-md-6 col-lg-auto">
                <div class="d-flex gap-2 align-items-center justify-content-between justify-content-sm-start">
                    <div>
                        <div class="page-pretitle">Sales</div>
                        <h2 class="page-title">Sales Order</h2>
                    </div>
                    <div>
                        <a href="{{ url('/console/salesorder/incoming/'.Request::segment(4)) }}" class="btn btn-outline-yellow w-40">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-step-into"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3l0 12" /><path d="M16 11l-4 4" /><path d="M8 11l4 4" /><path d="M12 20m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg>
                            Incoming : {{$incoming}} Pending
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-5 col-md-6 col-lg-auto ms-auto d-print-none">
                <div class="d-flex gap-2">
                    <a href="{{ url('/console/salesorder/statistic/perday') }}" class="btn btn-dark ms-sm-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-align-box-bottom-center" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" /><path d="M9 15v2" /><path d="M12 11v6" /><path d="M15 13v4" /></svg>
                        Statistics
                    </a>
                    <a class="btn btn-light ms-auto ms-sm-0" data-bs-toggle="offcanvas" href="#offcanvasStart" role="button" aria-controls="offcanvasStart" id="btn-filter">
                        <svg style="margin-right:10px" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-filter-search m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M11.36 20.213l-2.36 .787v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414" /><path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M20.2 20.2l1.8 1.8" /> </svg>
                        <span class="d-sm-none d-md-inline">&nbsp;Filter</span>
                    </a>
                    <!-- jika bukan Network Engineer & sales Marketing -->
                    @if(session('role_id') != 2 && session('role_id') != 7)
                    <a href="#" id="btn-create-so" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-report">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                        <span class="d-none d-lg-inline">&nbsp;Create New Sales Order</span>
                    </a>
                    @endif
                    <!-- jika admin atau sales corporate -->
                    @if(session('role_id') == 3 || session('role_id') == 8)
                    <a href="{{ url('/console/salesorder/add_so_corporate') }}" class="btn btn btn-info">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                        <span class="d-none d-lg-inline">&nbsp;Create New SO Corporate</span>
                    </a>

                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Records</h3>
            </div>

            @if(session()->has('success'))
            <div class="alert alert-important alert-info alert-dismissible" style="border-radius:0px;" role="alert">
                <div class="d-flex">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l5 5l10 -10"></path></svg>
                    </div>
                    <div>
                        {{ session('success') }}
                    </div>
                </div>
                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
            @endif

            @if(session()->has('failed'))
            <div class="alert alert-important alert-danger alert-dismissible" style="border-radius:0px;" role="alert">
                <div class="d-flex">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l5 5l10 -10"></path></svg>
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
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 9v4"></path><path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z"></path><path d="M12 16h.01"></path></svg>
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
                            <th>Sales PIC</th>
                            <th>Customer Name</th>
                            <!-- <th>Service Name</th> -->
                            <th class="text-center">Order Date</th>
                            <th class="text-center">Delivery Target</th>
                            <th class="text-center">Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse($data as $raw)
                        <tr>
                            <td class="py-2">{{$loop->iteration}}</td>
                            <td class="py-2">
                                {{$raw->order_number ?? '-'}}</br>
                                <span class="badge bg-azure-lt">
                                    <small>{{$raw->first_name}} {{$raw->last_name}}</small>
                                </span>
                            </td>
                            <td class="py-2">{{$raw->customer_name}}</td>
                            <td class="py-2 text-center">
                                {{date('Y-M-d', strtotime($raw->order_date))}}
                            </td>
                            <td class="py-2 text-center">
                                {{date('Y-M-d', strtotime($raw->target_to_live))}}<br/>

                                @inject("Salesorder", "App\Http\Controllers\SalesorderController")

                                @if($raw->status_name !='Completed' && $raw->status_name !='Canceled')
                                    <div class="text-capitalize small fs-normal">{{ $Salesorder::Get_due_target_tolive($raw->id, $raw->target_to_live, $raw->status_name) }}</div>
                                @endif
                            </td>
                            <td class="py-2 text-center">
                                @php
                                    $stat = $raw;

                                    if (in_array($stat->status_name, ['Activated', 'Completed']) === true) {
                                        $badgeColor = 'text-bg-success';
                                    } elseif ($stat->status_name == 'Deactivated') {
                                        $badgeColor = 'text-bg-danger';
                                    } elseif ($stat->status_name == 'Pending') {
                                        $badgeColor = 'text-bg-secondary';
                                    } elseif ($stat->status_name == 'In Progress') {
                                        $badgeColor = 'text-bg-teal';
                                    } elseif (in_array($stat->status_name, ['Terminated', 'Deleted']) === true) {
                                        $badgeColor = 'border border-danger text-danger';
                                    } elseif ($stat->status_name == 'Dismentle') {
                                        $badgeColor = 'text-bg-yellow';
                                    } elseif ($stat->status_name == 'Canceled') {
                                        $badgeColor = 'text-bg-orange';
                                    } else {
                                        $badgeColor = '';
                                    }
                                @endphp
                                <span class="badge {{$badgeColor}}">{{$raw->status_name ?? '-'}}</span>
                            </td>
                            <td class="py-2 text-end">
                                <a href="{{ url('/') }}/console/salesorder/detail/{{$raw->id}}" class="btn btn-outline-primary" title="Detail">Detail</a>
                            </td>
                        </tr>
                        @empty

                        <tr>
                            <td colspan="8">

                                <div class="empty">
                                    <p class="empty-title">No results found</p>
                                    <p class="empty-subtitle text-secondary">
                                        Try adjusting your search or filter to find what you're looking for.
                                    </p>
                                    <div class="empty-action">
                                        <a href="#" class="btn btn-primary" data-bs-target="#modal-report"
                                            data-bs-toggle="modal">
                                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M12 5l0 14"></path>
                                                <path d="M5 12l14 0"></path>
                                            </svg>
                                            Add your first Sales Order
                                        </a>
                                    </div>
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

@include('component.modal.add-salesorder')
@include('component.canvas.filter-salesorder')
<script>

    $(document).ready(function () {

        $(document).on('click', '#btn-create-so', function (e) {
            e.preventDefault();

            var el;
            window.TomSelect && (new TomSelect(el = document.getElementById('select-product'), {
                copyClassesToDropdown: false,
                dropdownParent: '.modal-body',
                controlInput: '<input>',
                render: {
                    item: function (data, escape) {
                        if (data.customProperties) {
                            return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                        }
                        return '<div>' + escape(data.text) + '</div>';
                    },
                    option: function (data, escape) {
                        if (data.customProperties) {
                            return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                        }
                        return '<div>' + escape(data.text) + '</div>';
                    },
                },
            }));


        });


        $(document).on('click', '#btn-filter', function (e) {

            e.preventDefault();

            var el;
            window.TomSelect && (new TomSelect(el = document.getElementById('select-product-filter'), {
                copyClassesToDropdown: false,
                dropdownParent: '.offcanvas-body',
                controlInput: '<input>',
                render: {
                    item: function (data, escape) {
                        if (data.customProperties) {
                            return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                        }
                        return '<div>' + escape(data.text) + '</div>';
                    },
                    option: function (data, escape) {
                        if (data.customProperties) {
                            return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                        }
                        return '<div>' + escape(data.text) + '</div>';
                    },
                },
            }));

        });


        $('#select-product-filter').on('change', function () {

            var product_name = this.value

            $.ajax({

                type: 'POST',
                url: "{{ route('get_order_plan') }}",
                data: { product_name: product_name },
                success: function (data) {

                    if (data.length != 0) {
                        $(".filter-plan").html('');
                        for (var i = 0; i < data.length; i++) {
                            $(".filter-plan").append('<div class="mb-3"><label class="form-selectgroup-item flex-fill"><input type="checkbox" name="product_plan[]" value="' + data[i]['product_plan'] + '" class="form-selectgroup-input"><div class="form-selectgroup-label d-flex align-items-center p-3"><div class="me-3"><span class="form-selectgroup-check"></span></div><div class="form-selectgroup-label-content d-flex align-items-center"><div><div class="font-weight-bold" style="font-weight:bold">' + product_name + '</div><div class="text-secondary">' + data[i]['product_plan'] + '</div></div></div></div></label></div>');
                        }
                    } else {
                        $(".filter-plan").html('<div class="alert alert-info" role="alert"><div class="d-flex"><div><!-- Download SVG icon from http://tabler-icons.io/i/info-circle --><svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path><path d="M12 9h.01"></path><path d="M11 12h1v4h1"></path></svg></div><div><h4 class="alert-title">Empty Product Plan</h4><div class="text-secondary">Produk belum tersedia untuk saat ini</div></div></div></div>');
                    }

                }

            });

        });

    });
</script>


@endsection


