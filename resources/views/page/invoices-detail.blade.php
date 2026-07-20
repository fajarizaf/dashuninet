@extends('layouts.console')
@section('container')

<header class="navbar navbar-expand-md d-print-none">
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
                            <a class="nav-link" href="{{ url('/console/invoices/list/draft') }}" title="Invoices Drafted">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-align-box-bottom-center" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"></path><path d="M9 15v2"></path><path d="M12 11v6"></path><path d="M15 13v4"></path></svg>
                                </span>
                                <span class="nav-link-title">Invoice Drafted</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/console/invoices/list/publish') }}" title="Invoices Published">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-align-box-bottom-center" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"></path><path d="M9 15v2"></path><path d="M12 11v6"></path><path d="M15 13v4"></path></svg>
                                </span>
                                <span class="nav-link-title">Invoice Published</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/console/invoices/list/duedate') }}" title="Invoice Due">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-align-box-bottom-center" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"></path><path d="M9 15v2"></path><path d="M12 11v6"></path><path d="M15 13v4"></path></svg>
                                </span>
                                <span class="nav-link-title">Invoice Due</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/console/invoices/list/pastduedate') }}" title="Invoice Due">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-align-box-bottom-center" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"></path><path d="M9 15v2"></path><path d="M12 11v6"></path><path d="M15 13v4"></path></svg>
                                </span>
                                <span class="nav-link-title">Invoice Past Due</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/console/invoices/list/bill') }}" title="Billing Account">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-align-box-bottom-center" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"></path><path d="M9 15v2"></path><path d="M12 11v6"></path><path d="M15 13v4"></path></svg>
                                </span>
                                <span class="nav-link-title">Billing Account</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/console/invoices/list/proofofpayment') }}" title="Payment Confirmation">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-align-box-bottom-center" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"></path><path d="M9 15v2"></path><path d="M12 11v6"></path><path d="M15 13v4"></path></svg>
                                </span>
                                <span class="nav-link-title">Payment Confirmation</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="page-body">
    <div class="container-xl">
        <div class="page-wrapper">
            <div class="page-header d-print-none">
                <div class="container-xl">
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

                    <div class="row g-3 align-items-center justify-content-between">
                        @forelse($invoices as $row)
                            <div class="col-12 col-sm-auto">
                                <div class="d-flex gap-2 align-items-center justify-content-between">
                                    <h2 class="page-title text-nowrap">Invoice Detail</h2>
                                    <div class="d-flex gap-1 align-items-center">
                                        <span class="badge bg-light text-primary border border-primary text-capitalize">
                                            {{$row->invoice_type}}
                                        </span>
                                        @if($row->is_publish == 0)
                                            <span class="badge bg-light text-secondary border border-secondary">Drafted</span>
                                        @else
                                            <span class="badge bg-light text-success border border-success">Published</span>
                                        @endif

                                        @if($row->status_id == 1036)
                                            <span class="badge text-bg-success">Paid</span>
                                        @elseif($row->status_id == 1037)
                                            <span class="badge text-bg-danger">Unpaid</span>
                                        @elseif($row->status_id == 1008)
                                            <span class="badge text-bg-yellow">Canceled</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-auto">
                                @if(session('role_id') != 2 && session('role_id') != 7)
                                <div class="d-flex gap-1 gap-sm-2">
                                    <button type="button"
                                        class="btn"
                                        onclick="copyToClipboard(`{{ env('CUSTOMER_URL') }}payment/`, `{{ Request::segment(4) }}`)">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="me-0 icon icon-tabler icons-tabler-outline icon-tabler-copy">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M7 7m0 2.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" />
                                            <path
                                                d="M4.012 16.737a2.005 2.005 0 0 1 -1.012 -1.737v-10c0 -1.1 .9 -2 2 -2h10c.75 0 1.158 .385 1.5 1" />
                                        </svg>
                                        &nbsp;Copy Payment Link
                                    </button>
                                    @if($row->is_publish == 0)
                                        <a href="{{ url('/console/invoices/edit/'.Request::segment(4).'') }}" type="button" class="btn btn-outline-info" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                            <span class="d-none d-xl-inline">&nbsp;Edit</span></span>
                                        </a>
                                    @else
                                        <a href="{{ url('/console/invoices/reminder/'.Request::segment(4).'') }}" type="button" class="btn btn-outline-teal" title="Send Reminder">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icn-notif m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"></path><path d="M9 17v1a3 3 0 0 0 6 0v-1"></path></svg>
                                            <span class="d-none d-lg-inline">&nbsp;Send Reminder</span>
                                        </a>
                                    @endif

                                    <button type="button" class="btn btn-outline-cyan" onclick="javascript:window.print();" title="Print Invoice">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2"></path><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"></path><path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z"></path></svg>
                                        <span class="d-none d-lg-inline">&nbsp;Print Invoice</span>
                                    </button>

                                    @if($row->is_publish == 0)
                                        <a href="{{ url('/console/invoices/publish/'.Request::segment(4).'') }}" type="button" class="btn btn-outline-orange" title="Publish & Send To Customer">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail-forward m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 18h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v7.5" /><path d="M3 6l9 6l9 -6" /><path d="M15 18h6" /><path d="M18 15l3 3l-3 3" /></svg>
                                            <span class="d-none d-lg-inline">&nbsp;Publish & Send To Customer</span>
                                        </a>
                                    @endif

                                    <a href="{{ url('/console/invoices/cancel/'.Request::segment(4).'') }}" type="button" class="btn btn-danger" title="Set as Cancel">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-progress-x m-0"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M10 20.777a8.942 8.942 0 0 1 -2.48 -.969" /><path d="M14 3.223a9.003 9.003 0 0 1 0 17.554" /><path d="M4.579 17.093a8.961 8.961 0 0 1 -1.227 -2.592" /><path d="M3.124 10.5c.16 -.95 .468 -1.85 .9 -2.675l.169 -.305" /><path d="M6.907 4.579a8.954 8.954 0 0 1 3.093 -1.356" /><path d="M14 14l-4 -4" /><path d="M10 14l4 -4" /></svg>
                                        <span class="d-sm-none d-md-inline">&nbsp;Set as Cancel</span>
                                    </a>
                                </div>
                                @endif
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
            <!-- Page body -->
            <div class="page-body">
                <div class="container-xl">
                    <div class="card card-lg">
                        <div class="card-body">
                            <div class="row justify-content-between mb-5">
                                <div class="col-12 mb-5">
                                    <div class="d-sm-flex gap-3 justify-content-between align-items-center">
                                        <img class="mb-3 mb-sm-0" src="{{ URL::asset('assets/static/logo-uninet-white.svg') }}" width="200">
                                        <div>
                                            <div class="fw-bold mb-2">{{ $company['name']}}</div>
                                            <div class="mb-2 small">
                                                GRAHA UNINET,<br>
                                                Jl. Warung Buncit Raya, No.25, Pejaten Barat,<br>
                                                Jakarta Selatan - 12710<br>
                                                Phone : 0217940911<br>
                                                Fax : 02179199234<br>
                                            </div>
                                            <div class="mb-2 small">
                                                Website : <a href="https://www.uninet.net.id" class="link-primary" title="Go to site">www.uninet.net.id</a> <br/>
                                                Email : <a href="mailto:info@uninet.net.id" class="link-primary" title="Send mail to info@uninet.net.id">info@uninet.net.id</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="border border-4 border-primary p-4 bg-gray-500 rounded-4">
                                        <div class="row justify-content-between">
                                            <div class="col-12 col-sm-auto order-3 order-sm-2">
                                                <div class="fs-3 fw-bold mb-2">Billing Information</div>
                                                <ul class="ps-0 m-0 list-unstyled">
                                                    <li class="my-1">
                                                        <small class="text-secondary">Customer ID</small>
                                                        <div class="fw-bold">
                                                                {{$customer->customer_number}}
                                                        </div>
                                                    </li>
                                                    <li class="my-1">
                                                        <small class="text-secondary">Invoice ID</small>
                                                        <div class="fw-bold">
                                                            @if($row->invoice_number == '')
                                                                #{{$row->id}}
                                                            @else
                                                                #{{$row->invoice_number}}
                                                            @endif
                                                        </div>
                                                    </li>
                                                    <li class="my-1">
                                                        <small class="text-secondary">Payment Method</small>
                                                        @forelse($invoices_payment as $payment)
                                                            <br/>
                                                            <div class="badge bg-blue text-blue-fg">{{$payment->bank_name}} - ( {{$payment->category}} )</div>
                                                        @empty
                                                            <div class="fw-bold">{{$row->payment_method}}</div>
                                                        @endforelse
                                                    </li>
                                                    <li class="my-1 d-flex gap-4">
                                                        <div>
                                                            <small class="text-secondary">Print Date</small>
                                                            <div class="fw-bold">{{$row->invoice_date ?? '-'}}</div>
                                                        </div>

                                                        <div>
                                                            <small class="text-secondary">Date Due</small>
                                                            <div class="fw-bold">{{$row->invoice_duedate ?? '-'}}</div>
                                                        </div>

                                                        <div>
                                                            <small class="text-secondary">Date Paid</small>
                                                            <div class="fw-bold">{{$row->invoice_datepaid ?? '-'}}</div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-12 col-sm-auto order-2 order-sm-3 mb-4 mb-sm-0">
                                                <div class="fs-3 fw-bold mb-2">Customer Information</div>
                                                    <ul class="ps-0 m-0 list-unstyled">
                                                        <li class="my-1">
                                                            <small class="text-secondary">Customer Name</small>
                                                            <div class="fw-bold">{{$customer->customer_name}}</div>
                                                            <div class="">{{$customer->company_name}}</div>
                                                        </li>
                                                        <li class="my-1">
                                                            <small class="text-secondary">Email Address</small>
                                                            <div class="fw-bold"><a href="mailto:{{$customer->customer_email}}" class="link-primary" title="Send mail to {{$customer->customer_email}}">{{$customer->customer_email}}</a></div>
                                                        </li>
                                                        <li class="my-1">
                                                            <small class="text-secondary">Phone Number</small>
                                                            <div class="fw-bold">{{$customer->customer_telp ?? '-'}}</div>
                                                        </li>
                                                    </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-5">
                                <div class="col-xxl-12 mb-5">
                                    <div class="fs-2 fw-bold mb-3">Order Items</div>

                                    <div class="table-responsive">
                                        <table class="table table-transparent border bg-light m-0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th class="w-100">Service Name</th>
                                                    <th class="text-center">Unit (IDR)</th>
                                                    <th class="text-end">Amount (IDR)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $sub_tagihan = 0;
                                                @endphp

                                                @forelse($invoices_item as $raw)
                                                    @inject("SalesOrder", "App\Http\Controllers\SalesorderController")
                                                    <tr>
                                                        <td class="py-2">{{$loop->iteration}}</td>
                                                        <td class="py-2 text-nowrap">
                                                            <div class="fw-medium mb-1">{{$raw->item_name}}</div>
                                                            @if($raw->order_id != '')
                                                                <a class="link-primary small" href="{{ url('/console/salesorder/detail/'.$raw->order_id) }}" title="Sales Order Detail">SO Reference : {{ $SalesOrder::Get_ordernumber($raw->order_id) }}</a>
                                                            @endif
                                                        </td>
                                                        <td class="py-2 text-center align-center align-middle">{{number_format($raw->amount, 0, ',', '.')}}</td>
                                                        <td class="py-2 text-end align-middle">{{number_format($raw->amount * $raw->quantity, 0, ',', '.')}}</td>
                                                    </tr>
                                                    @php
                                                        $sub_tagihan = $sub_tagihan + $raw->amount;
                                                    @endphp
                                                @empty
                                                @endforelse

                                                <tr style="border-top:2px solid #666">
                                                    <td class="strong fs-3" colspan="2">Subtotal</td>
                                                    <td class="text-end fs-3 fw-bold align-middle" colspan="2">{{number_format($sub_tagihan, 0, ',', '.')}}</td>
                                                </tr>

                                                @forelse($invoices_item_promo as $rew)
                                                    <tr>
                                                        <td class="strong" colspan="2">{{$rew->item_name}}</td>
                                                        <td class="text-end align-middle" colspan="2">- {{number_format($rew->amount, 0, ',', '.')}}</td>
                                                    </tr>
                                                @empty
                                                @endforelse

                                                <tr style="border-top:2px solid #666">
                                                    <td class="strong" colspan="2">Tax (PPN / VAT 11%)</td>
                                                    <td class="text-end align-middle" colspan="2">
                                                        @php
                                                            $t = $row->subtotal * $row->tax;
                                                            $n = $t/ 100;
                                                        @endphp
                                                        {{number_format($n, 0, ',', '.')}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="strong fs-2" colspan="2">Grand Total (IDR)</td>
                                                    <td class="fw-bold text-danger text-end strong fs-2" colspan="2"> {{number_format($row->total, 0, ',', '.')}}</td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
 
                                    
                                        <div class="col-xxl-5">
                                            <div class="border border-primary border-4 text-center h-100 rounded-4 p-4">
                                                <div class="bg-gray-600 p-5 fw-bold text-uppercase rounded-4 mb-4">Payment Information</div>
                                                <div>
                                                    Please transfer Your payment amount exactly of
                                                    <div class="my-2">
                                                        <span class="badge text-bg-primary"><small>IDR</small> <b class="fs-3">{{number_format($row->total, 0, ',', '.')}}</b></span>
                                                    </div>
                                                    To the one of following banks account :
                                                    <hr />
                                                    <ul class="ps-0 m-0 list-unstyled">
                                                        <li class="mb-3">
                                                            <div class="text-secondary mb-1">Bank Name</div>
                                                            <div class="fw-bold">{{ $company['bank_name']}}</div>
                                                        </li>
                                                        <li class="mb-3">
                                                            <div class="text-secondary mb-1">Account Name</div>
                                                            <div class="fw-bold">{{ $company['name']}}</div>
                                                        </li>
                                                        <li class="mb-3">
                                                            <div class="text-secondary mb-1">Account Number</div>
                                                            <div class="fs-3 fw-bold text-primary">{{ $company['account_number']}}</div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-7">
                                            <div class="border border-secondary border-4 text-center rounded-4 p-4 mb-4">
                                                <div class="bg-gray-600 p-5 fw-bold text-uppercase rounded-4 mb-4">Payment Confirmation</div>
                                                <div>
                                                    <p>
                                                        Bagi pelanggan yang telah melakukan transfer pembayaran, mohon segera lakukan konfirmasi pembayaran ke bagian Billing kami dengan mengirim bukti transfer melalui email, telpon, WA atau melalui aplikasi mobile UNAPPS yang sudah tersedia di playstore.
                                                    </p>

                                                    <div class="fw-bold mb-2">Billing Information</div>
                                                    <div>
                                                        Telp : 0217940911<br/>
                                                        Email : <a href="mailto:finance@uni.net.id" class="link-primary" title="finance@uni.net.id">finance@uni.net.id</a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="alert alert-cyan rounded-0 m-0">
                                                <h4>Catatan :</h4>
                                                - Pembayaran akan diakui setelah kami menerima konfirmasi pembayaran <br/>
                                                - Invoice ini berlaku sebagai tanda terima yang sah setelah konfirmasi
                                                - Layanan akan kami suspended apabila tagihan tidak dilakukan pembayaran melebihi dari tanggal jatuh tempo
                                            </div>
                                        </div>

                                 

                                


                            </div>

                        </div>
                    </div>

                    <br/>

                    <div class="d-print-none">
                    <h2>Proof Of Payment</h2>
                    @if($proof_payment_count == 0)
                        <form enctype="multipart/form-data" method="POST" action="/console/invoices/upload/bukti_bayar">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <input type="hidden" name="invoices_id" value="{{ Request::segment(4) }}" />
                            <div class="empty-action" style="border:2px dashed #ccc;padding:10px;">
                                @if(session('role_id') != 2 && session('role_id') != 7)
                                <input type="file" class="bukti_bayar" name="bukti_bayar" style="display:none;" />
                                <div  class="btn btn-primary btn-upload" style="margin-right:10px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M5 12l14 0"></path></svg>
                                    Upload Attachment
                                </div>
                                @endif
                                <span>There is no proof of payment at this time</span>
                            </div>
                        </form>
                    @else


                    <div class="card">
                        <div>
                            <table class="table table-vcenter table-mobile-md card-table">
                            <thead>
                                <tr>
                                <th>Attachment</th>
                                <th>Status</th>
                                <th>Reason</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse($proof_payment as $proof)
                                <tr>
                                    <td data-label="Name">
                                        <a href="{{ url('/console/buktibayar/download/'.$proof->file) }}" class="btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-link" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M9 15l6 -6"></path>
                                            <path d="M11 6l.463 -.536a5 5 0 0 1 7.071 7.072l-.534 .464"></path>
                                            <path d="M13 18l-.397 .534a5.068 5.068 0 0 1 -7.127 0a4.972 4.972 0 0 1 0 -7.071l.524 -.463"></path>
                                            </svg>
                                            Download Bukti Bayar
                                        </a>
                                    </td>
                                    <td data-label="Title">
                                        <span class="badge bg-blue-lt">{{$proof->status}}</span>
                                    </td>
                                    <td data-label="Title">
                                        {{$proof->reject_reason}}
                                    </td>
                                    <td>
                                        <div class="btn-list flex-nowrap">
                                            <form method="POST" action="{{ url('/bukti_bayar/action/') }}">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                            <input type="hidden" name="invoice_id" value="{{ Request::segment(4) }}" />
                                            @if($proof->status != 'Approved')
                                            <div class="btn-list flex-nowrap">
                                                <div class="dropdown">
                                                    <button class="btn dropdown-toggle align-text-top" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Actions
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end" style="">
                                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-rejected-reason" href="#">
                                                            Rejected
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                            @else
                                            @endif
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                @endforelse


                            </tbody>
                            </table>
                        </div>
                        </div>

                    @endif

                    <br/>
                    <br/>
                    <h2>Add Payment Transaction</h2>


                        @if($invoices_transaction_count != 0)

                            <input type="button" class="btn add-payment" value="Add Payment" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-addpayment" />
                            <br/><br/>
                            <div class="card">
                            <div>
                                <table class="table table-vcenter table-mobile-md card-table">
                                <thead>
                                    <tr>
                                    <th>TRX NUMBER</th>
                                    <th>TRX DATE</th>
                                    <th>CURRENCY</th>
                                    <th>GATEWAY</th>
                                    <th>AMOUNT IN</th>
                                    <th>AMOUNT OUT</th>
                                    <th>PAYMENT STATUS</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse($invoices_transaction as $trx)
                                    <tr>
                                        <td>{{$trx->trx_number}}</td>
                                        <td>{{$trx->trx_date}}</td>
                                        <td>{{$trx->currency}}</td>
                                        <td>{{$trx->gateway}}</td>
                                        <td>{{$trx->amount_in}}</td>
                                        <td>{{$trx->amount_out}}</td>
                                        <td><div class="badge bg-azure-lt">{{$trx->payment_status}}</div></td>
                                    </tr>
                                    @empty

                                    @endforelse


                                </tbody>
                                </table>
                            </div>
                            </div>

                        @else
                        
                        <div class="empty-action" style="border:2px dashed #ccc;padding:10px;">
                        @if(session('role_id') != 2 && session('role_id') != 7)
                            <input type="button" class="btn btn-primary add-payment" value="Add Payment" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-addpayment" />
                        @endif
                            <span>There is no transaction of payment at this time</span>
                        </div>

                        @endif



                        <div class="card-body mt-4">
                            <h3 class="card-title">Log Activity</h3>
                            <ul class="steps steps-vertical">
                                @forelse($log_inv as $log)
                                <li class="step-item">
                                    <div class="h4 m-0">{{$log->log_label}} - <span class="text-secondary">{{date('Y-M-d H:i:s', strtotime($log->created_at))}}</span></div>
                                    <div class="text-secondary">{{$log->log_entry}}</div>
                                </li>
                                @empty
                                <li class="step-item">
                                    <div class="h4 m-0">Empty Log Activity</span></div>
                                    <div class="text-secondary">Belum ada log tercatat</div>
                                </li>
                                @endforelse
                            </ul>
                        </div>


                    </div>

                </div>
            </div>

        </div>


    </div>

</div>


@include('component.modal.rejected-proofpayment')
@include('component.modal.add-payment')


<style>
    .navbar-overlap:after {
        height: 0px !important;
    }

    .btnactive {
        background-color: #206bc4;
        color: #fff;
    }

    .tables td {
        padding:4px;
    }

    .btn-upload {
        cursor:pointer;
    }
</style>

<script type="text/javascript">

    $(document).ready(function () {
        $(".btn_filter").on("click", function () {
            this.form.submit();
        });

        $(".btn-upload").on("click", function () {
            $('.bukti_bayar').click();
        });

        $(".bukti_bayar").on("change", function () {
            this.form.submit();
        });
    });

    function copyToClipboard(textToCopy, id) {
        var encode = btoa(id);
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(textToCopy + encode).select();
        const successful = document.execCommand("copy");
        if (successful) {
            alert("Copied the text: " + textToCopy + encode);
        } else {
            // ...
        }
        $temp.remove();
    }


</script>





@endsection
