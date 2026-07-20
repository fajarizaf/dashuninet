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
                                <span class="nav-link-title">Invoices Drafted</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/console/invoices/list/publish') }}" title="Invoices Published">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-align-box-bottom-center" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"></path><path d="M9 15v2"></path><path d="M12 11v6"></path><path d="M15 13v4"></path></svg>
                                </span>
                                <span class="nav-link-title">Invoices Published</span>
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
                                <h2 class="page-title text-nowrap">Edit Invoice</h2>
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
                            <div class="d-flex gap-1 gap-sm-2">
                                <button type="button" class="btn btn-outline-cyan" onclick="javascript:window.print();" title="Print Invoice">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2"></path><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"></path><path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z"></path></svg>
                                    <span class="">&nbsp;Print Invoice</span>
                                </button>
                            </div>
                        </div>
                    @empty
                    @endforelse
                    </div>
                </div>
            </div>


            <!-- Page body -->
            <div class="page-body">
                <div class="container-xl">
                    <form method="POST" action="{{ url('/console/invoices/editupdate') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="invoice_id" value="{{ Request::segment(4) }}" />

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
                                                            <div>
                                                                <select name="method_payment" class="form-select">
                                                                    <option value="Bank Transfer">Bank Transfer</option>
                                                                    <option value="Free">Free</option>
                                                                </select>
                                                            </div>
                                                        </li>
                                                        <li class="my-1 d-flex gap-4">
                                                            <div>
                                                                <small class="text-secondary">Print Date</small>
                                                                <div><input type="date" class="form-control" name="invoice_date" value="{{$row->invoice_date}}" /></div>
                                                            </div>
                                                            <div>
                                                                <small class="text-secondary">Date Due</small>
                                                                <div><input type="date" class="form-control" name="invoice_duedate" value="{{$row->invoice_duedate}}" /></div>
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
                                                        <th style="width: 10rem;">Billing Account</th>
                                                        <th style="width: 35rem;">Service Name</th>
                                                        <th class="text-center">Quantity</th>
                                                        <th class="text-end">@Price (IDR)</th>
                                                        <th class="text-end">Amount (IDR)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $sub_tagihan = 0;
                                                    @endphp

                                                    @forelse($invoices_item as $raw)
                                                        <tr class="tr_clone">
                                                            <td class="py-2 text-nowrap">
                                                                <select  name="billing_account[]" class="form-control">
                                                                   
                                                                        <option value="{{$raw->billing_account}}">{{$raw->billing_account}}</option>
                                                                        @forelse($billing_account as $bilcount)
                                                                            @if(empty($bilcount->billing_account) === false)
                                                                            <option value="{{$bilcount->billing_account}}">{{$bilcount->billing_account}}</option>
                                                                            @endif
                                                                        @empty
                                                                        @endforelse
                                                                  
                                                                </select>
                                                            </td>
                                                            <td class="py-2">
                                                                <input type="hidden" name="product_id[]" value="{{$raw->product_id}}" />
                                                                <input type="text" class="form-control" name="item_name[]" value="{{$raw->item_name}}" />
                                                            </td>
                                                            <td class="py-2 text-center">
                                                                <input type="text" class="form-control text-center" name="item_qty[]" value="{{$raw->quantity}}" />
                                                            </td>
                                                            <td class="py-2 text-center">
                                                                <input type="text" class="form-control text-end" name="unit_amount[]" value="{{$raw->amount}}" />
                                                            </td>
                                                            <td class="py-2 text-end d-flex align-items-center gap-1">
                                                                <input type="text" class="form-control text-end" name="amount[]" value="{{$raw->amount * $raw->quantity}}" />
                                                                @if($sub_tagihan != 0)
                                                                    <div class="badge text-red border border-red remove_row p-1" title="Remove" style="cursor: pointer;">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>&nbsp;
                                                                    </div>
                                                                @else
                                                                    <div class="badge text-red border border-red remove_row p-1" title="Remove" style="cursor: pointer;display:none;">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>&nbsp;
                                                                    </div>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @php
                                                            $sub_tagihan = $sub_tagihan + 1;
                                                        @endphp
                                                    @empty
                                                    @endforelse

                                                    <tr>
                                                        <td class="py-2 text-center" colspan="5">
                                                            <input type="button" class="btn btn-outline-cyan add_row text-capitalize py-1 px-2" value="add" style="float:right" />
                                                        </td>
                                                    </tr>
                                                    <tr style="border-top:2px solid #666">
                                                        <td class="strong align-middle fs-3" colspan="4">Subtotal</td>
                                                        <td>
                                                            <input type="text" class="form-control text-end fs-3 fw-bold" name="subtotal" value="{{$row->subtotal}}" />
                                                        </td>
                                                    </tr>
                                                    <tr style="border-top:2px solid #666">
                                                        <td class="strong align-middle" colspan="4">Tax (VAT Rate)</td>
                                                        <td>
                                                            <div class="input-group">
                                                                <input type="text" name="tax" class="form-control text-end fw-bold" placeholder="tax" value="{{$row->tax}}">
                                                                <span class="input-group-text">%</span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="strong fs-2 align-middle" colspan="4">Grand Total (IDR)</td>
                                                        <td class="fw-bold" colspan="2">
                                                            <input type="text" class="form-control text-end fs-2 fw-bold" name="total" value="{{$row->total}}" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5" class="text-end">
                                                            <input type="submit" class="btn btn-primary text-capitalize" value="save" style="float:right" />
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
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

    .tables td {
        padding:4px;
    }
</style>

<script type="text/javascript">

    $(document).ready(function () {
        $(".btn_filter").on("click", function () {
            this.form.submit();
        });

        $(".btn-upload").on("change", function () {
            $('.bukti_bayar').click();
        });

        $(".bukti_bayar").on("change", function () {
            this.form.submit();
        });

        $(".form-select").on("change", function () {
            this.form.submit();
        });


    });

    $(".add_row").on("click", function() {
        $tr = $(this).closest("tr").prev().clone();
        $tr[0].querySelector('.remove_row').setAttribute('style', 'cursor:pointer');
        $tr.insertBefore($(this).closest("tr"));
    });

    $(document).on("click", ".remove_row", function(){
        $(this).parent().parent().remove();
    });

</script>





@endsection
