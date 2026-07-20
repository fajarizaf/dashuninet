@extends('layouts.console')
@section('container')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js"></script>
<script src="{{ URL::asset('assets/vendor/morris6/dist/morris.js') }}" crossorigin='anonymous'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.min.css">
<link rel="stylesheet" href="{{ URL::asset('assets/vendor/morris/moris.css') }}">

<header class="navbar navbar-expand-md">
    <div class="container-xl">
        <div class="d-md-none">Tab Menus</div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu-01" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse pb-2 pb-md-0" id="navbar-menu-01">
            <div class="row flex-fill align-items-center justify-content-between g-2">
                <div class="col-auto">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/console/dashboard') }}" title="Dashboard">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-align-box-bottom-center" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"></path><path d="M9 15v2"></path><path d="M12 11v6"></path><path d="M15 13v4"></path></svg>
                                </span>
                                <span class="nav-link-title">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ url('/console/dashboard/sales_order') }}" title="Sales Order">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-invoice"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M9 7l1 0" /><path d="M9 13l6 0" /><path d="M13 17l2 0" /></svg>
                                </span>
                                <span class="nav-link-title">Sales Order</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/console/dashboard/subscription') }}" title="Subscription">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-box"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" /><path d="M12 12l8 -4.5" /><path d="M12 12l0 9" /><path d="M12 12l-8 -4.5" /></svg>
                                </span>
                                <span class="nav-link-title">Subscription</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/console/dashboard/revenue') }}" title="Revenue">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-coins"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 14c0 1.657 2.686 3 6 3s6 -1.343 6 -3s-2.686 -3 -6 -3s-6 1.343 -6 3z" /><path d="M9 14v4c0 1.656 2.686 3 6 3s6 -1.344 6 -3v-4" /><path d="M3 6c0 1.072 1.144 2.062 3 2.598s4.144 .536 6 0c1.856 -.536 3 -1.526 3 -2.598c0 -1.072 -1.144 -2.062 -3 -2.598s-4.144 -.536 -6 0c-1.856 .536 -3 1.526 -3 2.598z" /><path d="M3 6v10c0 .888 .772 1.45 2 2" /><path d="M3 11c0 .888 .772 1.45 2 2" /></svg>
                                </span>
                                <span class="nav-link-title">Revenue</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-5 col-lg-auto">
                    <form class="d-flex gap-1">
                        <div class="input-group">
                            <span class="input-group-text" id="">Dataset</span>
                            <select class="form-select">
                                <option value="">Counter</option>
                                <option value="">Amount (IDR)</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text" id="">Year</span>
                            <select class="form-select">
                                <option value="">2024</option>
                                <option value="">2023</option>
                                <option value="">2022</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="page-body">
    <div class="container-xl">
        <div class="row g-2 mb-4">
            <div class="col-12 mb-1">
                <div class="fw-bold fs-3">Sales Order By Project Area - <u>All</u></div>
            </div>
            <div class="col-6 col-sm-4 col-md-auto">
                <div class="p-2 rounded border border-primary bg-primary text-white shadow-sm">
                    <div class="text-light small fw-medium">Sales Order</div>
                    <div class="fs-3 fw-bold">Total : 607</div>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-md-auto">
                <div class="p-2 alert alert-cyan border-cyan bg-white m-0 shadow-sm">
                    <div class="text-secondary small fw-medium">On Progress</div>
                    <div class="fs-3 fw-bold">62</div>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-md-auto">
                <div class="p-2 alert alert-warning border-warning bg-white m-0 shadow-sm">
                    <div class="text-secondary small fw-medium">Outstanding</div>
                    <div class="fs-3 fw-bold">18</div>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-md-auto">
                <div class="d-block p-2 alert alert-danger border-danger bg-white m-0 shadow-sm">
                    <div class="text-secondary small fw-medium">Canceled</div>
                    <div class="fs-3 fw-bold">13</div>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-md-auto">
                <div class="p-2 alert alert-teal border-teal bg-white m-0 shadow-sm">
                    <div class="text-secondary small fw-medium">Completed</div>
                    <div class="fs-3 fw-bold">75</div>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-md-auto">
                <div class="p-2 alert alert-secondary border-secondary bg-white m-0 shadow-sm">
                    <div class="text-secondary small fw-medium">Deleted</div>
                    <div class="fs-3 fw-bold">75</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="rounded bg-white p-4 shadow-sm">
                    <div class="row align-items-center g-1 mb-3">
                        <div class="col-12 col-lg-auto fw-bold fs-5 me-lg-auto">Data Filter :</div>
                        <div class="col-12 col-sm-auto">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text" id="">Project Area</span>
                                <select class="form-select">
                                    @foreach([
                                        'All',
                                        'Villa Dago',
                                        'Vimala Hills',
                                        'Jababeka',
                                        'Bekasi',
                                        'Bangka',
                                        'Gunawarman',
                                    ] as $area)
                                    <option value="">{{$area}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6 col-sm-auto">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text" id="">Sort By</span>
                                <select class="form-select">
                                    @foreach([
                                        'Date',
                                        'Sales Order',
                                        'On Progress',
                                        'Outstanding',
                                        'Canceled',
                                        'Completed',
                                    ] as $area)
                                    <option value="">{{$area}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6 col-sm-auto">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text" id="">Order By</span>
                                <select class="form-select">
                                    @foreach([
                                        'Descending',
                                        'Ascending',
                                    ] as $area)
                                    <option value="">{{$area}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text" id="">Period By</span>
                                <select class="form-select">
                                    <option value="">--- Select ---</option>
                                    <option value="">Month</option>
                                    <option value="">Date</option>
                                </select>
                                <select class="form-select d-none"> {{-- Appear when Month is selected --}}
                                    <option value="">--- Select ---</option>
                                    <option value="">December</option>
                                    <option value="">November</option>
                                    <option value="">October</option>
                                    <option value="">September</option>
                                    <option value="">August</option>
                                    <option value="">July</option>
                                    <option value="">June</option>
                                    <option value="">May</option>
                                    <option value="">April</option>
                                    <option value="">March</option>
                                    <option value="">February</option>
                                    <option value="">January</option>
                                </select>
                                <input type="date" class="form-control d-none"> {{-- Appear when Month is selected --}}
                            </div>
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-12">
                            <div>
                                @for($i=1;$i<=12;$i++)
                                    <div class="badge d-block text-start my-2 my-xl-1 py-2">
                                        <div class="row g-1 align-items-center">
                                            <div class="col-12 col-xl-2 me-auto">
                                                <div class="small text-seconadry fw-normal mb-1">Date</div>
                                                {{'2024-'.sprintf('%02d', $i)}}
                                            </div>
                                            <div class="col-12 col-md-2 col-xl-1">
                                                <div class="rounded bg-white p-1 border border-2">
                                                    <div class="fw-normal mb-1 text-primary">Sales Order</div>
                                                    <div class="fw-bold">200</div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-sm-3 col-md-2 col-xl-1">
                                                <div class="rounded bg-white p-1">
                                                    <div class="fw-normal mb-1 text-cyan">On Progress</div>
                                                    <div class="fw-bold">200</div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-sm-3 col-md-2 col-xl-1">
                                                <div class="rounded bg-white p-1">
                                                    <div class="fw-normal mb-1 text-warning">Outstanding</div>
                                                    <div class="fw-bold">200</div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-sm-3 col-md-2 col-xl-1">
                                                <div class="rounded bg-white p-1">
                                                    <div class="fw-normal mb-1 text-danger">Canceled</div>
                                                    <div class="fw-bold">200</div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-sm-3 col-md-2 col-xl-1">
                                                <div class="rounded bg-white p-1">
                                                    <div class="fw-normal mb-1 text-teal">Completed</div>
                                                    <div class="fw-bold">200</div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-sm-3 col-md-2 col-xl-1">
                                                <div class="rounded bg-white p-1">
                                                    <div class="fw-normal mb-1 text-secondary">Deleted</div>
                                                    <div class="fw-bold">200</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .navbar-overlap:after {
        height: 0px !important;
    }
</style>
@endsection
