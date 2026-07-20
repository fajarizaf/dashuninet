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
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-history-toggle"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M10 20.777a8.942 8.942 0 0 1 -2.48 -.969" /><path d="M14 3.223a9.003 9.003 0 0 1 0 17.554" /><path d="M4.579 17.093a8.961 8.961 0 0 1 -1.227 -2.592" /><path d="M3.124 10.5c.16 -.95 .468 -1.85 .9 -2.675l.169 -.305" /><path d="M6.907 4.579a8.954 8.954 0 0 1 3.093 -1.356" /><path d="M12 8v4l3 3" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="fw-bold text-uppercase">
                                    Pending
                                </div>
                                <div class="text-secondary small">
                                    {{ $count_redem_pending }} Request
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
                                <span class="bg-yellow text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-license" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 21h-9a3 3 0 0 1 -3 -3v-1h10v2a2 2 0 0 0 4 0v-14a2 2 0 1 1 2 2h-2m2 -4h-11a3 3 0 0 0 -3 3v11" /><path d="M9 7l4 0" /><path d="M9 11l4 0" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="fw-bold text-uppercase">
                                    Proceed
                                </div>
                                <div class="text-secondary small">
                                    {{$count_redem_process}} Request
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
                                <span class="bg-teal text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-tir"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M7 18h8m4 0h2v-6a5 7 0 0 0 -5 -7h-1l1.5 7h4.5" /><path d="M12 18v-13h3" /><path d="M3 17l0 -5l9 0" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="fw-bold text-uppercase">
                                    Shipment
                                </div>
                                <div class="text-secondary small">
                                    {{$count_redem_shipment}} Shipment
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
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-world-check"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M20.946 12.99a9 9 0 1 0 -9.46 7.995" /><path d="M3.6 9h16.8" /><path d="M3.6 15h13.9" /><path d="M11.5 3a17 17 0 0 0 0 18" /><path d="M12.5 3a16.997 16.997 0 0 1 2.311 12.001" /><path d="M15 19l2 2l4 -4" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="fw-bold text-uppercase">
                                    Completed
                                </div>
                                <div class="text-secondary small">
                                    {{$count_redem_complete}} Request
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
                                <span class="bg-secondary text-white avatar">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-world-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20.929 13.131a9 9 0 1 0 -8.931 7.869" /><path d="M3.6 9h16.8" /><path d="M3.6 15h9.9" /><path d="M11.5 3a17 17 0 0 0 0 18" /><path d="M12.5 3a16.992 16.992 0 0 1 2.505 10.573" /><path d="M22 22l-5 -5" /><path d="M17 22l5 -5" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="fw-bold text-uppercase">
                                    Rejected
                                </div>
                                <div class="text-secondary small">
                                    {{$count_redem_reject}} Request
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br />

        <form method="POST" action="{{ url('/console/invoices/batch_publish') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><b>{{$count_redem}}</b> Requests</h3>
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
                                <th>Redem ID</th>
                                <th>Customer Name</th>
                                <th>Reward Request</th>
                                <th class="text-center">Point Requirement</th>
                                <th class="text-center">Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($data as $raw)
                                <tr>
                                    <td class="py-2">{{$loop->iteration}}</td>
                                    <td class="py-2">{{$raw->id}}</td>
                                    <td class="py-2">{{$raw->customer_name}}</td>
                                    <td class="py-2">{{$raw->reward_name}}</td>
                                    <td class="py-2 text-center"><span class="badge text-primary border border-primary">{{$raw->reward_point}} Point</span></td>
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
                                            } elseif (in_array($stat->status_name, ['Dismentle', 'Process']) === true) {
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
                                        <a href="{{ url('/') }}/console/redem/detail/{{$raw->id}}" class="btn btn-outline-primary" title="Detail">Detail</a>
                                    </td>
                                </tr>
                            @empty

                                <tr>
                                    <td class="py-2" colspan="8">

                                        <div class="empty">
                                            <p class="empty-title">No results request redem found</p>
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
        </form>


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
