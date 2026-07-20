@extends('layouts.console')
@section('container')

<header class="navbar navbar-expand-md">
    <div class="container-xl">
        <div class="d-md-none">Tab Menus</div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu-01" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse pb-2 pb-md-0" id="navbar-menu-01">
            <div class="row flex-fill align-items-center g-2">
                <div class="col-12 col-md-10">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/console/redem/queue') }}" title="Redem Queue">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-hexagonal-prism"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20.792 6.996l-3.775 2.643a2.005 2.005 0 0 1 -1.147 .361h-7.74c-.41 0 -.81 -.126 -1.146 -.362l-3.774 -2.641" /><path d="M8 10v11" /><path d="M16 10v11" /><path d="M3.853 18.274l3.367 2.363a2 2 0 0 0 1.147 .363h7.265c.41 0 .811 -.126 1.147 -.363l3.367 -2.363c.536 -.375 .854 -.99 .854 -1.643v-9.262c0 -.655 -.318 -1.268 -.853 -1.643l-3.367 -2.363a2 2 0 0 0 -1.147 -.363h-7.266c-.41 0 -.811 .126 -1.147 .363l-3.367 2.363a2.006 2.006 0 0 0 -.853 1.644v9.261c0 .655 .318 1.269 .853 1.644z" /></svg>
                                </span>
                                <span class="nav-link-title">Redem Queue</span>
                            </a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ url('/console/redem/complete') }}" title="Redem Completed">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-align-box-bottom-center" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"></path><path d="M9 15v2"></path><path d="M12 11v6"></path><path d="M15 13v4"></path></svg>
                                </span>
                                <span class="nav-link-title">Redem Completed</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-12 col-md-2 text-end">
                    <a class="btn btn-outline-primary" data-bs-toggle="offcanvas" href="#offcanvasStart" role="button" aria-controls="offcanvasStart" id="btn-filter">
                        <svg style="margin-right:10px" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-filter-search m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M11.36 20.213l-2.36 .787v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414" /><path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M20.2 20.2l1.8 1.8" /></svg>
                        <span>&nbsp;Filter</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-6 col-sm-4 col-lg-3 col-xl-2">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-success text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-license" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 21h-9a3 3 0 0 1 -3 -3v-1h10v2a2 2 0 0 0 4 0v-14a2 2 0 1 1 2 2h-2m2 -4h-11a3 3 0 0 0 -3 3v11" /><path d="M9 7l4 0" /><path d="M9 11l4 0" /></svg>
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
        </div>

        <br />

        <form method="POST" action="{{ url('/console/invoices/batch_publish') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><b>{{$count_redem_complete}}</b> Requests</h3>
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
                                    <td class="py-2 text-center"><span class="badge">{{$raw->reward_point}} Point</span></td>
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
                                        <a href="{{ url('/') }}/console/redem/detail/{{$raw->id}}" class="btn btn-outline-primary">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty

                                <tr>
                                    <td colspan="8">

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

@include('component.canvas.filter-redem-complete')

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
