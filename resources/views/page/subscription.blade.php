@extends('layouts.console')
@section('container')



<!-- Page header -->
<div class="page-header d-print-none text-white">
    <div class="container-xl">
        <div class="row g-3 align-items-center">
            <div class="col-12 col-sm-auto">
                <div class="d-flex gap-2 align-items-end justify-content-between justify-content-sm-start">
                    <div>
                        <div class="page-pretitle">Billing</div>
                        <h2 class="page-title">Subscription</h2>
                    </div>
                    <div>
                        <span class="px-2 py-1 rounded bg-light text-dark fw-bold">
                            Total : {{ $count_subs }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-auto ms-auto d-print-none">
                <div class="d-sm-flex gap-2">
                    <a href="{{ url('/console/subscription?subscription_status=1013') }}" class="btn btn-outline-light" title="{{ $count_inprogress }} In Progress">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-news m-0"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M16 6h3a1 1 0 0 1 1 1v11a2 2 0 0 1 -4 0v-13a1 1 0 0 0 -1 -1h-10a1 1 0 0 0 -1 1v12a3 3 0 0 0 3 3h11" /><path d="M8 8l4 0" /><path d="M8 12l4 0" /><path d="M8 16l4 0" /></svg>
                        <span class="d-none d-xxl-inline">&nbsp;{{ $count_inprogress }} In Progress</span>
                    </a>
                    <a href="{{ url('/console/subscription?subscription_status=1001') }}" class="btn btn-outline-light" title="{{ $count_activated }} Active">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-input-check m-0"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M20 13v-4a2 2 0 0 0 -2 -2h-12a2 2 0 0 0 -2 2v5a2 2 0 0 0 2 2h6" /><path d="M15 19l2 2l4 -4" /></svg>
                        <span class="d-none d-xxl-inline">&nbsp;{{ $count_activated }} Active</span>
                    </a>
                    <a href="{{ url('/console/subscription?subscription_status=1002') }}" class="btn btn-outline-light" title="{{ $count_deactivated }} Deactive">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-input-x m-0"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M20 13v-4a2 2 0 0 0 -2 -2h-12a2 2 0 0 0 -2 2v5a2 2 0 0 0 2 2h7" /><path d="M22 22l-5 -5" /><path d="M17 22l5 -5" /></svg>
                        <span class="d-none d-xxl-inline">&nbsp;{{ $count_deactivated }} Deactive</span>
                    </a>
                    <a href="{{ url('/console/subscription?subscription_status=1005') }}" class="btn btn-outline-light" title="{{ $count_pending }} Pending">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-progress m-0"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M10 20.777a8.942 8.942 0 0 1 -2.48 -.969" /><path d="M14 3.223a9.003 9.003 0 0 1 0 17.554" /><path d="M4.579 17.093a8.961 8.961 0 0 1 -1.227 -2.592" /><path d="M3.124 10.5c.16 -.95 .468 -1.85 .9 -2.675l.169 -.305" /><path d="M6.907 4.579a8.954 8.954 0 0 1 3.093 -1.356" /></svg>
                        <span class="d-none d-xxl-inline">&nbsp;{{ $count_pending }} Pending</span>
                    </a>
                    <a href="{{ url('/console/subscription?subscription_status=1008') }}" class="btn btn-outline-light" title="{{ $count_canceled }} Cancel">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-cloud-cancel m-0"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M12 18.004h-5.343c-2.572 -.004 -4.657 -2.011 -4.657 -4.487c0 -2.475 2.085 -4.482 4.657 -4.482c.393 -1.762 1.794 -3.2 3.675 -3.773c1.88 -.572 3.956 -.193 5.444 1c1.488 1.19 2.162 3.007 1.77 4.769h.99a3.45 3.45 0 0 1 2.756 1.373" /><path d="M19 19m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M17 21l4 -4" /></svg>
                        <span class="d-none d-xxl-inline">&nbsp;{{ $count_canceled }} Cancel</span>
                    </a>
                    <a href="{{ url('/console/subscription?subscription_status=1011') }}" class="btn btn-outline-light d-none d-md-inline" title="{{ $count_terminated }} Terminate">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-progress-x m-0"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M10 20.777a8.942 8.942 0 0 1 -2.48 -.969" /><path d="M14 3.223a9.003 9.003 0 0 1 0 17.554" /><path d="M4.579 17.093a8.961 8.961 0 0 1 -1.227 -2.592" /><path d="M3.124 10.5c.16 -.95 .468 -1.85 .9 -2.675l.169 -.305" /><path d="M6.907 4.579a8.954 8.954 0 0 1 3.093 -1.356" /><path d="M14 14l-4 -4" /><path d="M10 14l4 -4" /></svg>
                        <span class="d-none d-xxl-inline">&nbsp;{{ $count_terminated }} Terminate</span>
                    </a>
                    <a class="btn btn-light ms-auto ms-sm-0" data-bs-toggle="offcanvas" href="#offcanvasStart" role="button" aria-controls="offcanvasStart" id="btn-filter" title="Filter">
                        <svg style="margin-right:10px" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-filter-search m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M11.36 20.213l-2.36 .787v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414" /><path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M20.2 20.2l1.8 1.8" /> </svg>
                        <span class="d-none d-lg-inline">&nbsp;Filter</span>
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
                <div class="alert alert-important alert-danger alert-dismissible" style="border-radius:0px;"
                    role="alert">
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
                            <th>Billing Account</th>
                            <th>Customer Name</th>
                            <th>Service Name</th>
                            <th>Subscription Number</th>
                            <th class="text-center">Amount (IDR)</th>
                            <th class="text-center">Activation Date</th>
                            <th class="text-center">Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse($data as $raw)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td class="py-2">{{ $raw->billing_account ?? '-' }}</td>
                                <td class="py-2">{{ $raw->customer_name }}</td>
                                <td class="py-2" data-label="Name">
                                    {{ $raw->product_name }}
                                    <div class="text-secondary small">{{ $raw->product_plan }} ({{ $raw->product_type }})</div>
                                </td>
                                <td class="py-2">{{ $raw->subscription_number ?? '-' }}</td>
                                <td class="py-2 text-center">{{ number_format($raw->amount, 0, ',', '.') }}</td>
                                <td class="py-2 text-center">{{ $raw->complete_date ?? '-' }}</td>
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
                                    <a href="{{ url('/') }}/console/salesorder/detail/{{$raw->order_id}}" class="btn btn-outline-primary" title="Detail">Detail</a>
                                </td>
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


@include('component.canvas.filter-subscription')


<script>
    $(document).ready(function () {

        $.ajaxSetup({
            headers: {

                'X-CSRF-TOKEN': $('#form-pipeline').find('input[name="_token"]').first().val()

            }
        });

        $('.btnedit').click(function () {

            var pipeline_id = $(this).attr('pipeline_id');

            $.ajax({

                type: 'POST',
                url: "{{ route('pipeline_detail') }}",
                data: {
                    pipeline_id: pipeline_id
                },
                success: function (data) {

                    $('#modal-editpipeline').modal('show');
                    $('.pipeline_id').val(data.id);
                    $('.pic_name').val(data.pic_name);
                    $('.position_name').val(data.position_name);
                    $('.place_of_bussines').val(data.place_of_bussines);
                    $('.exist_product').val(data.exist_product);
                    $('.price_product').val(data.price_product);
                    $('.keterangan').val(data.keterangan);
                    $('.telp').val(data.telp);
                    $('.email').val(data.email);

                }

            });

        });


        $(document).on('click', '#btn-create-so', function (e) {
            e.preventDefault();

            var pipeline_id = $(this).attr('pipeline_id');

            $.ajax({

                type: 'POST',
                url: "{{ route('pipeline_detail') }}",
                data: {
                    pipeline_id: pipeline_id
                },
                success: function (data) {

                    $('.pipeline_id').val(data.id);
                    $('.customer_name').val(data.pic_name);
                    $('.customer_phone').val(data.telp);
                    $('.customer_email').val(data.email);

                }

            });

            var el;
            window.TomSelect && (new TomSelect(el = document.getElementById('select-product'), {
                copyClassesToDropdown: false,
                dropdownParent: '.modal-body',
                controlInput: '<input>',
                render: {
                    item: function (data, escape) {
                        if (data.customProperties) {
                            return '<div><span class="dropdown-item-indicator">' + data
                                .customProperties + '</span>' + escape(data.text) +
                                '</div>';
                        }
                        return '<div>' + escape(data.text) + '</div>';
                    },
                    option: function (data, escape) {
                        if (data.customProperties) {
                            return '<div><span class="dropdown-item-indicator">' + data
                                .customProperties + '</span>' + escape(data.text) +
                                '</div>';
                        }
                        return '<div>' + escape(data.text) + '</div>';
                    },
                },
            }));


        });




    });

</script>


@endsection
