@extends('layouts.console')
@section('container')



<!-- Page header -->
<div class="page-header d-print-none text-white">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Order
                    &nbsp;
                    &nbsp;
                    <a href="{{ url('/console/order?status_id=1005') }}" class="btn btn-light">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-news"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16 6h3a1 1 0 0 1 1 1v11a2 2 0 0 1 -4 0v-13a1 1 0 0 0 -1 -1h-10a1 1 0 0 0 -1 1v12a3 3 0 0 0 3 3h11" /><path d="M8 8l4 0" /><path d="M8 12l4 0" /><path d="M8 16l4 0" /></svg>
                            {{$pending}} Total Order
                    </a>
                    &nbsp;
                    &nbsp;
                    <a href="{{ url('/console/order?status_id=1050') }}" class="btn btn-dark">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-news-off"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16 6h3a1 1 0 0 1 1 1v9m-.606 3.435a2 2 0 0 1 -3.394 -1.435v-2m0 -4v-7a1 1 0 0 0 -1 -1h-7m-3.735 .321a1 1 0 0 0 -.265 .679v12a3 3 0 0 0 3 3h11" /><path d="M8 12h4" /><path d="M8 16h4" /><path d="M3 3l18 18" /></svg>
                            {{$rejected}} Rejected Order
                    </a>
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <span class="d-none d-sm-inline">
                        <a href="{{ url('/console/salesorder/statistic/perday') }}" class="btn btn-dark">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-align-box-bottom-center" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                                <path d="M9 15v2" />
                                <path d="M12 11v6" />
                                <path d="M15 13v4" />
                            </svg>
                            Statistics
                        </a>
                        <a class="btn" data-bs-toggle="offcanvas" href="#offcanvasStart" role="button"
                            aria-controls="offcanvasStart" id="btn-filter">
                            <svg style="margin-right:10px" xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-filter-search" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M11.36 20.213l-2.36 .787v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414" />
                                <path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                <path d="M20.2 20.2l1.8 1.8" />
                            </svg>
                            Filter
                        </a>
                    </span>
                    <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal"
                        data-bs-target="#modal-report" aria-label="Create new report">
                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                    </a>
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
                        <!-- Download SVG icon from http://tabler-icons.io/i/info-circle -->
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
            <div class="alert alert-important alert-danger alert-dismissible" style="border-radius:0px;" role="alert">
                <div class="d-flex">
                    <div>
                        <!-- Download SVG icon from http://tabler-icons.io/i/info-circle -->
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
                        <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
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
                            <th class="w-1"><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></th>
                            <th >Order Number</th>
                            <th >Customer Name</th>
                            <th >Product Package</th>
                            <th >Date Order</th>
                            <th >Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse($data as $raw)
                        <tr>
                            <td ><input class="form-check-input m-0 align-middle" type="checkbox"
                                    aria-label="Select invoice"></td>
                            <td style="padding-left:0.1em;padding-right:0.1em;">
                                {{$raw->order_id}}</br>
                            </td>
                            <td style="padding-left:0.1em;padding-right:0.1em;"><a href="#" class="text-reset" tabindex="-1">{{$raw->customer_name}}</a></td>
                            <td style="padding-left:0.1em;padding-right:0.1em;">
                                {{$raw->product_name}}
                                <span class="text-secondary">{{$raw->product_plan}}</span>
                                <span class="badge bg-azure-lt">{{$raw->product_type}}</span>
                            </td>
                            <td style="padding-left:0.1em;padding-right:0.1em;">
                                {{date('Y-M-d', strtotime($raw->order_date))}}
                            </td>
                            <td style="padding-left:0.1em;padding-right:0.1em;"><span class="badge bg-azure-lt">{{$raw->status_name}}</span></td>
                            <td class="text-end">
                                <span class="dropdown">
                                    <a href="{{ url('/') }}/console/order/detail/{{$raw->order_id}}">
                                        <button class="btn">Detail</button>
                                    </a>
                                </span>
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

@include('component.canvas.filter-order')

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