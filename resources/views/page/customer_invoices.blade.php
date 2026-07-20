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
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-license" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M15 21h-9a3 3 0 0 1 -3 -3v-1h10v2a2 2 0 0 0 4 0v-14a2 2 0 1 1 2 2h-2m2 -4h-11a3 3 0 0 0 -3 3v11" /><path d="M9 7l4 0" /><path d="M9 11l4 0" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="fw-bold text-uppercase">
                                    Paid
                                </div>
                                <div class="text-secondary small">
                                    {{ $count_paid }} Invoices
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
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-license" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M15 21h-9a3 3 0 0 1 -3 -3v-1h10v2a2 2 0 0 0 4 0v-14a2 2 0 1 1 2 2h-2m2 -4h-11a3 3 0 0 0 -3 3v11" /><path d="M9 7l4 0" /><path d="M9 11l4 0" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="fw-bold text-uppercase">
                                    Unpaid
                                </div>
                                <div class="text-secondary small">
                                    {{ $count_unpaid }} Invoices
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
                                <span class="bg-orange text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-license" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M15 21h-9a3 3 0 0 1 -3 -3v-1h10v2a2 2 0 0 0 4 0v-14a2 2 0 1 1 2 2h-2m2 -4h-11a3 3 0 0 0 -3 3v11" /><path d="M9 7l4 0" /><path d="M9 11l4 0" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="fw-bold text-uppercase">
                                    Canceled
                                </div>
                                <div class="text-secondary small">
                                    {{ $count_cancel }} Invoices
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
                            <th>Invoice ID</th>
                            <th class="text-center">Invoice Date</th>
                            <th class="text-center">Invoice Due</th>
                            <th class="text-center">Amount (IDR)</th>
                            <th class="text-center">Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse($data as $raw)
                            <tr>
                                <td class="py-2">{{$loop->iteration}}</td>
                                <td class="py-2">
                                    @if($raw->is_publish == 0)
                                        {{ $raw->id }}
                                        <small class="badge text-secondary fw-normal p-1 border"><small>Drafted</small></small>
                                    @else
                                        @if($raw->invoice_number == '')
                                            {{ $raw->id }}
                                        @else
                                            {{ $raw->invoice_number }}
                                        @endif
                                        <small class="badge text-success fw-normal p-1 border border-success"><small>Published</small></small>
                                    @endif
                                </td>
                                <td class="py-2 text-center">{{ $raw->invoice_date }}</td>
                                <td class="py-2 text-center">{{ $raw->invoice_duedate }}</td>
                                <td class="py-2 text-center">{{ number_format($raw->total, 0, ',', '.') }}</td>
                                <td class="py-2 text-center">
                                    @php
                                        $stat = $raw;

                                        if (in_array($stat->status_name, ['Activated', 'Completed', 'Paid']) === true) {
                                            $badgeColor = 'text-bg-success';
                                        } elseif (in_array($stat->status_name, ['Deactivated', 'Unpaid']) === true) {
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
                                    <a href="{{ url('/') }}/console/invoices/detail/{{ $raw->id }}" class="btn btn-outline-primary" title="Detail">Detail</a>
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

<style>
    .navbar-overlap:after {
        height: 0px !important;
    }

    .btnactive {
        background-color: #206bc4;
        color: #fff;
    }

</style>

<script type="text/javascript">
    $(document).ready(function () {
        $(".btn_filter").on("click", function () {
            this.form.submit();
        });
    });

</script>

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
