@extends('layouts.console')
@section('container')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js"></script>
<script src="{{ URL::asset('assets/vendor/morris/morris.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.min.css">
<link rel="stylesheet" href="{{ URL::asset('assets/vendor/morris/morris.css') }}">

<script>

jQuery(document).ready(function () {
        new Morris.Bar({
            // ID of the element in which to draw the chart.
            element: 'displayDays',
            data: {!! $statistic_perday !!} ,
            // The name of the data record attribute that contains x-values.
            xkey : 'month',
            // A list of names of data record attributes that contain y-values.
            ykeys: ['count'],
            // Labels for the ykeys -- will be displayed when you hover over the
            // chart.
            labels: ['Total'],
            barColors: ['#0054a6'],
            xLabelMargin: 10,
            stacked: true
        });
    });

</script>


<header class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar">
            <div class="container-xl">
                <div class="row flex-fill align-items-center">
                    <div class="col">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="{{ url('/console/salesorder/statistic/perday') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-align-box-bottom-center" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path
                                                d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z">
                                            </path>
                                            <path d="M9 15v2"></path>
                                            <path d="M12 11v6"></path>
                                            <path d="M15 13v4"></path>
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Sales Order
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="{{ url('/console/subscription/statistic/actual') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/checkbox -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-align-box-bottom-center" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path
                                                d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z">
                                            </path>
                                            <path d="M9 15v2"></path>
                                            <path d="M12 11v6"></path>
                                            <path d="M15 13v4"></path>
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Subscription
                                    </span>
                                </a>
                            </li>
                            @if(session('company_id') == 1)
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="{{ url('/console/invoices/stat/peryear') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/checkbox -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-align-box-bottom-center" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path
                                                d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z">
                                            </path>
                                            <path d="M9 15v2"></path>
                                            <path d="M12 11v6"></path>
                                            <path d="M15 13v4"></path>
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Revenue
                                    </span>
                                </a>
                            </li>
                            @endif

                            <li class="nav-item active">
                                <a class="nav-link"
                                    href="{{ url('/console/subscription/statistic_rev/peryear') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/checkbox -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-align-box-bottom-center" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path
                                                d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z">
                                            </path>
                                            <path d="M9 15v2"></path>
                                            <path d="M12 11v6"></path>
                                            <path d="M15 13v4"></path>
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Report By Area Location
                                    </span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>


<div class="page-body">

    <div class="container-xl">

        <div class="page-header d-print-none">
            <div class="container">
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <span class="status-indicator status-green status-indicator-animated">
                            <span class="status-indicator-circle"></span>
                            <span class="status-indicator-circle"></span>
                            <span class="status-indicator-circle"></span>
                        </span>
                    </div>
                    <div class="col">
                        <h2 class="page-title">
                            Report By Area Location
                        </h2>
                        <div class="text-secondary">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li>
                                    <h3 class="text-green">Statistic</h3>
                                </li>
                            </ul>
                        </div>
                    </div>

                    @if(session('company_id') == 1)
                    <div class="col-2">
                        <a href="{{ url('/console/subscription/statistic_rev/peryear') }}"
                            type="submit" class="form-control btn-filter btn-active">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-checklist" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M9.615 20h-2.615a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8"></path><path d="M14 19l2 2l4 -4"></path><path d="M9 8h4"></path><path d="M9 12h2"></path></svg>
                            Revenue
                        </a>
                    </div>
                    @endif

                    <div class="col-2">
                        <a href="{{ url('/console/customer/statistic/peryear') }}"
                            type="submit" class="form-control btn-filter">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-checklist" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M9.615 20h-2.615a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8"></path><path d="M14 19l2 2l4 -4"></path><path d="M9 8h4"></path><path d="M9 12h2"></path></svg>
                            Customer
                        </a>
                    </div>

                    <div class="col-2">
                        <a href="{{ url('/console/subscription/statistic_area/peryear') }}"
                            type="submit" class="form-control btn-filter">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-checklist" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M9.615 20h-2.615a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8"></path><path d="M14 19l2 2l4 -4"></path><path d="M9 8h4"></path><path d="M9 12h2"></path></svg>
                            Subscription
                        </a>
                    </div>

                </div>
            </div>
        </div>

        <form method="GET" action="/console/subscription/statistic_rev/peryear" id="form-salesorder">
            <div class="row">
                <div class="col-xl-2">
                    <div class="input-icon mb-2">
                        <select class="form-select" name="filter_area">
                            <option value="">-- Select --</option>
                            @forelse($initProj as $raw)
                            <option value="{{$raw->id}}" {{ $raw->id == $filter_area ? "selected" : "" }}>{{$raw->project_name}}
                                @empty
                            <option value="">No Project Found</option>
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="col-xl-2">
                    <div class="input-icon mb-2">
                        <select class="form-select" name="filter_year">
                            @forelse($initYear as $raw)
                            <option value="{{$raw->year}}" {{ $raw->year == $year ? "selected" : "" }}>{{$raw->year}}
                                @empty
                            <option value="">No Data Found</option>
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="col-xl-2">
                    <button type="submit" class="form-control btn-filter">
                        <svg style="margin-right:10px" xmlns="http://www.w3.org/2000/svg"
                            class="icon icon-tabler icon-tabler-filter-search" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path
                                d="M11.36 20.213l-2.36 .787v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414">
                            </path>
                            <path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                            <path d="M20.2 20.2l1.8 1.8"></path>
                        </svg>
                        Submit
                    </button>
                </div>
            </div>
        </form>


        <div class="row row-cards">
            <div class="col-md-2">
                <div class="card">
                    <div class="card-body">
                        <h3 style="margin-bottom:2px;">Total </h3>
                        <div class="h1 m-0">IDR. {{ $total_paid }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4 mb-4">
            <div class="card-body">
                <div id="displayDays" style="height: 250px;"></div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h3>Growth Revenue</h3>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap datatable">
                        <thead>
                            <tr>
                                <th>Period</th>
                                <th>Revenue</th>
                                @if(session('role_id') == 3 || session('role_id') == 4)
                                <th>Detail</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($month_list as $raw)
                                <tr>
                                    <td>{{ $raw['month'] . ' - ' . $year }}</td>
                                    <td>IDR. {{ number_format($raw['count'], 0) }}</td>
                                    @if(session('role_id') == 3 || session('role_id') == 4)
                                    <td>
                                        <a href="{{ url('/') }}/console/invoices/list/publish?year={{ $year }}&month={{ $raw['number'] }}&filter_area={{ $filter_area }}"
                                            class="dropdown">
                                            <button class="btn btnedit">Detail</button>
                                        </a>
                                    </td>
                                    @endif
                                </tr>
                            @empty

                                <tr>
                                    <td colspan="8">
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

            </div>
        </div>

    </div>

    @endsection

    <style>
        .navbar-overlap:after {
            height: 0px !important;
        }

        .btn-active {
            background-color: #206bc4 !important;
            color: #fff !important;
        }

    </style>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#change_date').change('change', function () {
                this.form.submit();
            });
        });

    </script>
