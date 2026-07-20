@extends('layouts.console')
@section('container')

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
                            <li class="nav-item active">
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
                            <li class="nav-item">
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
                            Customer Subscription Status
                        </h2>
                        <div class="text-secondary">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li>
                                    <h3 class="text-green">Statistic - Year</h3>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-2">
                        <a href="{{ url('/console/subscription/statistic/peryear') }}"
                            type="submit" class="form-control btn-filter btnactive">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                <path d="M16 3v4" />
                                <path d="M8 3v4" />
                                <path d="M4 11h16" />
                                <path d="M11 15h1" />
                                <path d="M12 15v3" />
                            </svg>
                            Per Year
                        </a>
                    </div>

                    <div class="col-2">
                        <a href="{{ url('/console/subscription/statistic/permonth') }}"
                            type="submit" class="form-control btn-filter">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                <path d="M16 3v4" />
                                <path d="M8 3v4" />
                                <path d="M4 11h16" />
                                <path d="M11 15h1" />
                                <path d="M12 15v3" />
                            </svg>
                            Per Month
                        </a>
                    </div>

                    <div class="col-2">
                        <a href="{{ url('/console/subscription/statistic/perday') }}"
                            type="submit" class="form-control btn-filter">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                <path d="M16 3v4" />
                                <path d="M8 3v4" />
                                <path d="M4 11h16" />
                                <path d="M11 15h1" />
                                <path d="M12 15v3" />
                            </svg>
                            Per Day
                        </a>
                    </div>

                </div>
            </div>
        </div>

        <br />

        <form method="GET" action="/console/subscription/statistic/peryear" id="form-salesorder">
            <div class="row">
                <div class="col-xl-2">
                    <div class="input-icon mb-2">
                        <select class="form-control" name="filter_year">
                            <option value="{{ $year }}">{{ $year }}</option>
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

        <div class="card">
            <div class="table-responsive">
                <table class="table table-vcenter table-bordered table-nowrap card-table">
                    <thead>
                        <tr>
                            <td class="w-20">
                                <h3>Product Plan</h3>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-azure text-azure-fg">Order Sign</span>
                            </td>
                            <td class="text-center">
                                <div class="text-secondary font-weight-medium">
                                    <span class="badge bg-green text-green-fg">Activated</span>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-yellow text-yellow-fg">Cancel</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-orange text-orange-fg">Terminated</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-orange text-orange-fg">Dismentle</span>
                            </td>
                        </tr>
                    </thead>


                    <tbody>
                        <?php 
                        $total_pending = 0;
                        $total_activated = 0;
                        $total_cancel = 0;
                        $total_terminated = 0;
                        $total_dismentle = 0;
                        ?>
                        @forelse($stats_peryear as $stat => $sday)
                            <?php 
                            $total_pending += $sday['product_pending'];
                            $total_activated += $sday['product_activated'];
                            $total_cancel += $sday['product_cancel'];
                            $total_terminated += $sday['product_terminated'];
                            $total_dismentle += $sday['product_dismentle'];
                            ?>
                            <tr>
                                <td>
                                    <span>{{ $sday['product_name'] }} -
                                        {{ $sday['product_plan'] }}</span>
                                    <div style="font-size:14px" class="text-secondary">
                                        {{ $sday['product_group'] }}</div>
                                </td>
                                <td class="text-center">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                                    {{ $sday['product_pending'] }}
                                </td>
                                <td class="text-center">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                                    {{ $sday['product_activated'] }}
                                </td>
                                <td class="text-center">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                                    {{ $sday['product_cancel'] }}
                                </td>
                                <td class="text-center">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                                    {{ $sday['product_terminated'] }}
                                </td>
                                <td class="text-center">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                                    {{ $sday['product_dismentle'] }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">Some info about feature</td>
                            </tr>
                        @endforelse
                        <tr>
                            <td class="text-bold fs-1">Total</td>
                            <td class="text-center fs-2">{{ $total_pending }}</td>
                            <td class="text-center fs-2">{{ $total_activated }}</td>
                            <td class="text-center fs-2">{{ $total_cancel }}</td>
                            <td class="text-center fs-2">{{ $total_terminated }}</td>
                            <td class="text-center fs-2">{{ $total_dismentle }}</td>
                        </tr>

                    </tbody>
                </table>
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
    // @formatter:off
    document.addEventListener("DOMContentLoaded", function () {
        window.Litepicker && (new Litepicker({
            element: document.getElementById('datepicker-icon'),
            buttonText: {
                previousMonth: `<!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`,
                nextMonth: `<!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`,
            },
        }));
    });
    // @formatter:on

</script>


@endsection
