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
                                <span class="bg-primary text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-hexagon"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M12 13a3 3 0 1 0 0 -6a3 3 0 0 0 0 6z" /><path d="M6.201 18.744a4 4 0 0 1 3.799 -2.744h4a4 4 0 0 1 3.798 2.741" /><path d="M19.875 6.27c.7 .398 1.13 1.143 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="fw-bold text-uppercase">
                                    Subscription
                                </div>
                                <div class="text-secondary small">
                                    {{ $count_subs }} Record
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
                            <th>Subscription Number</th>
                            <th>Service Name</th>
                            <th class="text-center">Billing Cycle</th>
                            <th class="text-center">Amount (IDR)</th>
                            <th class="text-center">Activation Date</th>
                            <th class="text-center">Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse($data as $raw)
                            <tr>
                                <td class="py-2">{{$loop->iteration}}</td>
                                <td class="py-2">{{ $raw->subscription_number ?? '-' }}</td>
                                <td class="py-2">
                                    {{$raw->product_name}}
                                    <div class="text-secondary small">{{ $raw->product_plan }} ({{ $raw->product_type }})</div>
                                </td>
                                <td class="py-2 text-center">{{ $raw->billingcycle }}</td>
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
