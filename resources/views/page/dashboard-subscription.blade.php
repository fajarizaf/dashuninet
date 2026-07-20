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
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/console/dashboard/sales_order') }}" title="Sales Order">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-invoice"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M9 7l1 0" /><path d="M9 13l6 0" /><path d="M13 17l2 0" /></svg>
                                </span>
                                <span class="nav-link-title">Sales Order</span>
                            </a>
                        </li>
                        <li class="nav-item active">
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
                <div class="fw-bold fs-3">Subscription By Project Area - <u>All</u></div>
            </div>
            <div class="col-6 col-sm-4 col-md-auto">
                <div class="p-2 rounded border border-primary bg-primary text-white shadow-sm">
                    <div class="text-light small fw-medium">Subscription</div>
                    <div class="fs-3 fw-bold">Total : 800</div>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-md-auto">
                <div class="p-2 alert alert-vk border-vk bg-white m-0 shadow-sm">
                    <div class="text-secondary small fw-medium">Pending</div>
                    <div class="fs-3 fw-bold">500</div>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-md-auto">
                <div class="p-2 alert alert-cyan border-cyan bg-white m-0 shadow-sm">
                    <div class="text-secondary small fw-medium">On Progress</div>
                    <div class="fs-3 fw-bold">500</div>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-md-auto">
                <div class="p-2 alert alert-success border-success bg-white m-0 shadow-sm">
                    <div class="text-secondary small fw-medium">Activated</div>
                    <div class="fs-3 fw-bold">300</div>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-md-auto">
                <div class="p-2 alert alert-yellow border-yellow bg-white m-0 shadow-sm">
                    <div class="text-secondary small fw-medium">Suspended</div>
                    <div class="fs-3 fw-bold">300</div>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-md-auto">
                <div class="p-2 alert alert-orange border-orange bg-white m-0 shadow-sm">
                    <div class="text-secondary small fw-medium">Canceled</div>
                    <div class="fs-3 fw-bold">300</div>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-md-auto">
                <div class="p-2 alert alert-danger border-danger bg-white m-0 shadow-sm">
                    <div class="text-secondary small fw-medium">Dismentled</div>
                    <div class="fs-3 fw-bold">300</div>
                </div>
            </div>
            <div class="col-6 col-sm-4 col-md-auto">
                <div class="p-2 alert alert-secondary border-secondary bg-white m-0 shadow-sm">
                    <div class="text-secondary small fw-medium">Terminated</div>
                    <div class="fs-3 fw-bold">300</div>
                </div>
            </div>
        </div>

        <div class="rounded bg-white p-4 shadow-sm">
            <div class="row align-items-center g-1 mb-3">
                <div class="col-12 col-xl-auto fw-bold fs-5 me-lg-auto">Data Filter :</div>
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
                <div class="col-12 col-sm-auto">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text" id="">Date From</span>
                        <input type="date" class="form-control" />
                        <span class="input-group-text" id="">To</span>
                        <input type="date" class="form-control" />
                    </div>
                </div>
                <div class="col-6 col-sm-auto">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text" id="">Sort By</span>
                        <select class="form-select">
                            @foreach([
                                'Product Name',
                                'Pending',
                                'On Progress',
                                'Activated',
                                'Suspended',
                                'Canceled',
                                'Dismentled',
                                'Terminated',
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
            </div>

            <div>
                @foreach([
                    ['service' => 'Uninet Basic - 30 Mbps', 'description' => 'Broadband'],
                    ['service' => 'Uninet Silver - 100 Mbps', 'description' => 'Broadband'],
                    ['service' => 'Uninet Gold - 200 Mbps', 'description' => 'Broadband'],
                    ['service' => 'Uninet Bronze - 50 Mbps', 'description' => 'Broadband'],
                    ['service' => 'Uninet Basic - 30 Mbps', 'description' => 'Membership'],
                    ['service' => 'Uninet Bronze - 50 Mbps', 'description' => 'Membership'],
                    ['service' => 'Uninet Silver - 100 Mbps', 'description' => 'Membership'],
                    ['service' => 'Uninet Gold - 200 Mbps', 'description' => 'Membership'],
                    ['service' => 'Uninet Titanium - 500 Mbps', 'description' => 'Membership'],
                    ['service' => 'Uninet Platinum - 1 Gbps', 'description' => 'Membership'],
                ] as $service)
                <div class="badge d-block text-start my-2 my-xl-1 py-2">
                    <div class="row g-1 align-items-center">
                        <div class="col-12 col-xl-2 me-auto">
                            <div class="fw-bold mb-1">{{$service['service']}}</div>
                            <div class="fw-normal">{{$service['description']}}</div>
                        </div>
                        <div class="col-12 col-md-2 col-xl-1">
                            <div class="rounded bg-white p-1 border border-2">
                                <div class="fw-normal mb-1 text-primary">Subscription</div>
                                <div class="fw-bold">200</div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-3 col-md-2 col-xl-1">
                            <div class="rounded bg-white p-1">
                                <div class="fw-normal mb-1 text-vk">Pending</div>
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
                                <div class="fw-normal mb-1 text-green">Activated</div>
                                <div class="fw-bold">200</div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-3 col-md-2 col-xl-1">
                            <div class="rounded bg-white p-1">
                                <div class="fw-normal mb-1 text-yellow">Suspended</div>
                                <div class="fw-bold">200</div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-3 col-md-2 col-xl-1">
                            <div class="rounded bg-white p-1">
                                <div class="fw-normal mb-1 text-orange">Canceled</div>
                                <div class="fw-bold">200</div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-3 col-md-2 col-xl-1">
                            <div class="rounded bg-white p-1">
                                <div class="fw-normal mb-1 text-danger">Dismentled</div>
                                <div class="fw-bold">200</div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-3 col-md-2 col-xl-1">
                            <div class="rounded bg-white p-1">
                                <div class="fw-normal mb-1 text-secondary">Terminated</div>
                                <div class="fw-bold">200</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
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
