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
                                    <h3 class="text-green">Statistic - Actual</h3>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-2">
                        <a href="{{ url('/console/subscription/statistic/peryear') }}"
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
                            View By Date
                        </a>
                    </div>

                </div>
            </div>
        </div>

        <br />

        <div class="card">
            <div class="table-responsive">
                <table class="table table-vcenter table-bordered table-nowrap card-table">
                    <thead>
                        <tr>
                            <td class="w-20">
                                <h3>Product Plan</h3>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-azure text-azure-fg">Pending</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-azure text-azure-fg">In Progress</span>
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
                        $total_inprogress = 0;
                        $total_activated = 0;
                        $total_cancel = 0;
                        $total_terminated = 0;
                        $total_dismentle = 0;
                        ?>
                        @forelse($stats_status as $stat => $sday)
                            <?php 
                            $total_pending += $sday['product_pending'];
                            $total_inprogress += $sday['product_inprogress'];
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
                                    {{ $sday['product_inprogress'] }}
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
                            <td class="text-center fs-2">{{ $total_inprogress }}</td>
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
