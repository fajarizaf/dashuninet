@extends('layouts.console')
@section('container')

<header class="navbar navbar-expand-md">
    <div class="container-xl">
        <div class="d-md-none">Tab Menus</div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu-01" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse pb-2 pb-md-0" id="navbar-menu-01">
            <div class="row flex-fill align-items-center g-2 justify-content-between">
                <div class="col-12 col-md-auto">
                    <ul class="navbar-nav">
                        <li class="nav-item @if(Request::segment(4) == 'open') active @else @endif">
                            <a class="nav-link" href="{{ url('/console/ticket/list/open') }}" title="Ticket Opened">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-ticket" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M15 5l0 2" /><path d="M15 11l0 2" /><path d="M15 17l0 2" /><path d="M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-3a2 2 0 0 0 0 -4v-3a2 2 0 0 1 2 -2" /></svg>
                                </span>
                                <span class="nav-link-title">Ticket Opened</span>
                            </a>
                        </li>
                        <li class="nav-item @if(Request::segment(4) == 'close') active @else @endif">
                            <a class="nav-link" href="{{ url('/console/ticket/list/close') }}" title="Ticket Closed">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-ticket" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M15 5l0 2" /><path d="M15 11l0 2" /><path d="M15 17l0 2" /><path d="M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-3a2 2 0 0 0 0 -4v-3a2 2 0 0 1 2 -2" /></svg>
                                </span>
                                <span class="nav-link-title">Ticket Closed</span>
                            </a>
                        </li>
                        <li class="nav-item @if(Request::segment(4) == 'overdue') active @else @endif">
                            <a class="nav-link" href="{{ url('/console/ticket/list/overdue') }}" title="Ticket Overdue">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-ticket" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M15 5l0 2" /><path d="M15 11l0 2" /><path d="M15 17l0 2" /><path d="M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-3a2 2 0 0 0 0 -4v-3a2 2 0 0 1 2 -2" /></svg>
                                </span>
                                <span class="nav-link-title">Ticket Overdue</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-12 col-md-auto text-end">
                    @if(session('role_id') == 3 || session('role_id') == 5)
                        <a class="btn btn-primary" href="#offcanvasStart" data-bs-toggle="modal" data-bs-target="#modal-addticket">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                            <span>&nbsp;Create New Ticket</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</header>

<div class="page-body">
    <div class="container-xl">
        <div class="row g-2">
            <div class="col-6 col-sm-4 col-lg-3 col-xl-2">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-primary text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-ticket" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M15 5l0 2" /><path d="M15 11l0 2" /><path d="M15 17l0 2" /><path d="M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-3a2 2 0 0 0 0 -4v-3a2 2 0 0 1 2 -2" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="fw-bold text-uppercase">
                                    Total
                                </div>
                                <div class="text-secondary small">
                                    {{ $count_ticket_open }} Tickets
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
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-ticket" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M15 5l0 2" /><path d="M15 11l0 2" /><path d="M15 17l0 2" /><path d="M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-3a2 2 0 0 0 0 -4v-3a2 2 0 0 1 2 -2" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="fw-bold text-uppercase">
                                    High
                                </div>
                                <div class="text-secondary small">
                                    {{ $count_ticket_high }} Priority
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
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-ticket" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M15 5l0 2" /><path d="M15 11l0 2" /><path d="M15 17l0 2" /><path d="M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-3a2 2 0 0 0 0 -4v-3a2 2 0 0 1 2 -2" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="fw-bold text-uppercase">
                                    Medium
                                </div>
                                <div class="text-secondary small">
                                    {{ $count_ticket_medium }} Priority
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
                                <span class="bg-info text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-ticket" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M15 5l0 2" /><path d="M15 11l0 2" /><path d="M15 17l0 2" /><path d="M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-3a2 2 0 0 0 0 -4v-3a2 2 0 0 1 2 -2" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="fw-bold text-uppercase">
                                    Low
                                </div>
                                <div class="text-secondary small">
                                    {{ $count_ticket_low }} Priority
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
                                <span class="bg-cyan text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-ticket" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M15 5l0 2" /><path d="M15 11l0 2" /><path d="M15 17l0 2" /><path d="M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-3a2 2 0 0 0 0 -4v-3a2 2 0 0 1 2 -2" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="fw-bold text-uppercase">
                                    Overdue
                                </div>
                                <div class="text-secondary small">
                                    {{ $count_ticket_overdue }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br />

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

        <div class="row">
            <div class="col-12 col-sm-4 col-lg-3 col-xxl-2 mb-4">
                <h3 class="m-0">Ticket Support</h3>
                <div class="text-secondary mb-3 small">Select Department</div>

                <ul class="list-group">
                    @forelse($department as $dept)
                        <li class="list-group-item bg-gray-600">
                            <a class="d-flex justify-content-between fw-bold" href="{{ url('/console/ticket/list/open?department='.$dept->id) }}">
                                {{$dept->department_name}}
                                <small class="text-secondary ms-auto">
                                    @inject("Ticket", "App\Http\Controllers\TicketController")
                                    @if(Request::segment(4) == 'open')
                                        {{ $Ticket::count_department_open($dept->id, 'open') }}
                                    @else
                                        {{ $Ticket::count_department_open($dept->id, 'close') }}
                                    @endif
                                </small>
                            </a>
                        </li>

                    @empty
                    @endforelse
                </ul>
            </div>

            <div class="col-12 col-sm-8 col-lg-9 col-xxl-10">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Records</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ticket ID</th>
                                    <th class="satu-baris">Subject</th>
                                    <th class="text-center">Priority</th>
                                    <th class="text-center">Created At</th>
                                    <th class="text-center">Due Date</th>
                                    <th class="text-center">Resolution Time</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $raw)
                                    <tr>
                                        <td class="py-2">{{$loop->iteration}}</td>
                                        <td class="py-2">{{$raw->ticket_number}}</td>
                                        <td class="py-2 satu-baris">{{$raw->title}}</td>
                                        <td class="py-2 text-center">
                                            @php
                                                $stat = $raw->priority;

                                                if ($stat == 'High') {
                                                    $badgeColor = 'border border-danger text-danger';
                                                } elseif($stat == 'Low') {
                                                    $badgeColor = 'border border-info text-info';
                                                } elseif($stat == 'Medium') {
                                                    $badgeColor = 'border border-yellow text-yellow';
                                                } else {
                                                    $badgeColor = '';
                                                }
                                            @endphp
                                            <span class="badge {{$badgeColor}}">{{$raw->priority}}</span>
                                        </td>
                                        <td class="py-2">{{$raw->created_at}}</td>
                                        <td class="py-2">{{$raw->due_date}}</td>
                                        <td class="py-2">{{$raw->hours_difference ? $raw->hours_difference.' minute' : ''}}</td>
                                        <td class="py-2 text-center">
                                            @php
                                                $stat = $raw->status_name;

                                                if ($stat == 'Opened') {
                                                    $badgeColor = 'text-bg-teal';
                                                } elseif($stat == 'Closed') {
                                                    $badgeColor = 'text-bg-secondary';
                                                } elseif($stat == 'Customer Replied') {
                                                    $badgeColor = 'text-bg-info';
                                                } elseif($stat == 'Admin Replied') {
                                                    $badgeColor = 'text-bg-orange';
                                                } else {
                                                    $badgeColor = '';
                                                }
                                            @endphp
                                            <span class="badge {{$badgeColor}}">{{$raw->status_name}}</span>
                                        </td>
                                        <td class="py-2 text-end">
                                            <a class="btn btn-outline-primary" href="{{ url('/console/ticket/detail/'.$raw->id) }}" title="Detail">Detail</a>
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td class="py-2" colspan="8">
                                            <div class="empty">
                                                <p class="empty-title">No results found</p>
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
    </div>
</div>
@include('component.modal.add-ticket')

<style>
    .navbar-overlap:after {
        height: 0px !important;
    }

    .btnactive {
        background-color: #206bc4;
        color: #fff;
    }
    .satu-baris {
        max-width: 200px;               /* Lebar elemen */
        white-space: nowrap;         /* Mencegah teks turun ke baris baru */
        overflow: hidden;            /* Sembunyikan teks yang melebihi lebar */
        text-overflow: ellipsis;     /* Tambahkan "..." di akhir */
    }
</style>

<script type="text/javascript">

    $(document).ready(function () {
        $(".btn_filter").on("click", function () {
            this.form.submit();
        });

        $(document).on('click', '#modal-create', function (e) {
            e.preventDefault();

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
