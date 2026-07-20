@extends('layouts.console')
@section('container')


<!-- Page header -->
<div class="page-header d-print-none text-white">
    <div class="container-xl">
        <div class="row g-3 align-items-center justify-content-between">
            <div class="col-auto col-sm-5 col-md-6 col-lg-auto">
                <div class="page-pretitle">Sales Order Detail</div>
                <h2 class="page-title">{{$order->order_number ?? '-'}}</h2>
            </div>
            <div class="col-auto col-sm-7 col-md-6 col-lg-auto ms-auto d-print-none">
                <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ url('/') }}/console/salesorder/" class="btn btn-primary" title="Sales Order List">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-align-left m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M4 6l16 0" /><path d="M4 12l10 0" /><path d="M4 18l14 0" /></svg>
                        <span class="d-none d-sm-inline">&nbsp;Sales Order List</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="subheader">Customer ID</div>
                        @if($customer_number != null)
                            <div class="h3 m-0">{{$customer_number}}</div>
                        @else
                            <div class="h3 m-0">-</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="subheader">Customer Name</div>
                        <div class="h3 m-0">
                            <a href="{{ url('/') }}/console/customer/detail/{{$customer_id}}" class="link-primary" title="Customer Detail">
                                {{$order_detail->customer_name}}
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-external-link"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6" /><path d="M11 13l9 -9" /><path d="M15 4h5v5" /></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="subheader">Customer Phone</div>
                        <div class="h3 m-0">{{$order_detail->customer_phone ?? '-'}}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="subheader">Customer Email</div>
                        <div class="h3 m-0">
                            @if(empty($order_detail->customer_email) === false)
                                <a href="mailto:{{$order_detail->customer_email}}" class="link-primary" title="Send mail to {{$order_detail->customer_email}}" target="_blank">{{$order_detail->customer_email}}</a>
                            @else
                                -
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="divider" style="height:40px;"></div>

        <div class="row row-cards">
            <div class="col-md-12 col-lg-8">
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-exclamation-circle"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 9v4" /><path d="M12 16v.01" /></svg>
                        </div>
                        <div>
                            {{ session('failed') }}
                        </div>
                    </div>
                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-pills card-header-pills">
                            <li class="nav-item">
                                Customer Order Info
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="datagrid">
                            <div class="datagrid-item">
                                <div class="datagrid-title">Date Order</div>
                                <div class="datagrid-content">{{date('Y-M-d', strtotime($order->order_date))}}
                                </div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title d-flex align-items-center gap-2">
                                    <span>Target To Live</span>
                                    @if($order->status_name !='Completed' && $order->status_name !='Cancelled')
                                        @inject("Salesorder", "App\Http\Controllers\SalesorderController")
                                        <span class="text-capitalize">{{ $Salesorder::Get_due_target_tolive(Request::segment(4), $order->target_to_live, $order->status_name) }}</span>
                                    @endif
                                </div>
                                <div class="datagrid-content">
                                    <form method="POST" action="/console/salesorder/set_targettolive" id="form-salesorder">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                        <input type="hidden" name="order_id" value="{{ Request::segment(4) }}" />
                                        <input type="date" class="form-control set_targettolive" name="target_live" value="{{date('Y-m-d', strtotime($order->target_to_live))}}" />
                                    </form>
                                </div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">PIC Sales</div>
                                <div class="datagrid-content">
                                    <div class="d-flex align-items-center fw-bold">
                                        {{$sales_pic}}
                                    </div>
                                </div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Reference</div>
                                <div class="datagrid-content">
                                    <div class="d-flex align-items-center fw-bold">
                                        {{$reference}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(empty($order->order_notes) === false)
                        <div class="datagrid mt-3">
                            <div class="datagrid-item">
                                <div class="datagrid-title">Order Notes</div>
                                <div class="alert alert-yellow m-0 small p-2 fst-italic bg-light">
                                    {{$order->order_notes}}
                                </div>
                            </div>
                        </div>
                        @endif
                        <br />
                        <br />

                        <h3>Product Order :</h3>

                        <div class="card">
                            <div class="table-responsive">
                                <table class="table table-vcenter table-mobile-md card-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Service Name</th>
                                            <th>Price (IDR)</th>
                                            <th class="text-md-center">Billing Cycle</th>
                                            <th class="text-md-center">Promo</th>
                                            <th class="text-md-center">Quantity</th>
                                            <th class="text-md-end">Total (IDR)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($order_item as $item)
                                        <tr>
                                            <td class="py-2" data-label="No.">{{$loop->iteration}}</td>
                                            <td class="py-2" data-label="Service Name">
                                                {{$item['product_name']}}
                                                <div class="text-secondary small">{{$item['product_plan']}}</div>
                                            </td>
                                            <td class="py-2" data-label="Price (IDR)">{{number_format($item['unit_price'], 0, ',', '.')}}</td>
                                            <td class="py-2 text-md-center text-capitalize" data-label="Billing Cycle">
                                                {{$item['billing_cycle']}}
                                            </td>
                                            <td class="py-2 text-md-center" data-label="Promo">
                                                {{$item['promo']}}
                                            </td>
                                            <td class="py-2 text-md-center" data-label="Quantity">
                                                {{$item['quantity']}}
                                            </td>
                                            <td class="py-2 text-md-end" data-label="Total (IDR)">
                                                {{number_format($item['unit_price'], 0, ',', '.')}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-2" colspan="7">
                                                <h4>Service Information Field :</h4>
                                                    <table>
                                                        @forelse($item['fields'] as $field)
                                                        <tr>
                                                            <td class="ps-0 text-capitalize">{{str_replace('-', ' ', $field['field'])}}</td>
                                                            <td class="fw-bold py-0">
                                                                <span class="px-2 d-none d-md-inline">:</span>
                                                                @if($field['field_type'] == "link")
                                                                    @if(filter_var($field['value'], FILTER_VALIDATE_URL) == true)
                                                                        <a target="_blank" href="{{$field['value']}}" class="fw-normal">
                                                                            See Maps
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-external-link"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6"></path><path d="M11 13l9 -9"></path><path d="M15 4h5v5"></path></svg>
                                                                        </a>
                                                                    @else
                                                                        <span class="badge bg-yellow text-blue-fg fw-normal">Link tidak valid</span>
                                                                    @endif
                                                                @else
                                                                    {{ucfirst($field['value'])}}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @empty
                                                        @endforelse
                                                    </table>
                                            </td>
                                        </tr>

                                        @empty
                                        <tr>
                                            <td colspan="7">

                                                <div class="empty">
                                                    <p class="empty-title">No results found</p>
                                                    <p class="empty-subtitle text-secondary">
                                                        Product order is not found
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

                <br />

                <h3>Product Subscription</h3>

                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-vcenter table-mobile-md card-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Service Name</th>
                                    <th class="text-md-center">Billing Account</th>
                                    <th class="text-md-center">Billing Cycle</th>
                                    <th class="text-md-center">Date Live</th>
                                    <th class="text-md-center">Status</th>
                                    <th class="text-md-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subscription as $subs)
                                <tr>
                                    <td class="py-2" data-label="No.">{{$loop->iteration}}</td>
                                    <td class="py-2" data-label="Service Name">
                                        {{$subs->product_name}}
                                        <div class="small text-secondary">{{$subs->product_plan}}</div>
                                    </td>
                                    <td class="py-2 text-md-center" data-label="Billing Account">
                                        @if(empty($subs->billing_account) === false)
                                            <a class="link-blue fw-bold" href="{{ url('/console/invoices/list/bill?billing_account='.$subs->billing_account) }}">{{$subs->billing_account}}</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="py-2 text-md-center text-capitalize" data-label="Billing Cycle">
                                        {{$subs->billingcycle}}
                                    </td>
                                    <td class="py-2 text-md-center" data-label="Date Live">
                                        @if($subs->complete_date  !== null)
                                            <span class="badge bg-green text-green-fg">
                                                {{date('Y-M-d', strtotime($subs->complete_date))}}
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="py-2 text-md-center" data-label="Status">
                                        @php
                                            $stat = $subs;

                                            if (in_array($stat->status_name, ['Activated', 'Completed']) === true) {
                                                $badgeColor = 'text-bg-success';
                                            } elseif ($stat->status_name == 'Deactivated') {
                                                $badgeColor = 'text-bg-danger';
                                            } elseif ($stat->status_name == 'Pending') {
                                                $badgeColor = 'text-bg-secondary';
                                            } elseif ($stat->status_name == 'In Progress') {
                                                $badgeColor = 'text-bg-teal';
                                            } elseif (in_array($stat->status_name, ['Terminated', 'Deleted']) === true) {
                                                $badgeColor = 'border border-danger text-danger';
                                            } elseif ($stat->status_name == 'Dismentle') {
                                                $badgeColor = 'text-bg-yellow';
                                            } elseif ($stat->status_name == 'Canceled') {
                                                $badgeColor = 'text-bg-orange';
                                            } else {
                                                $badgeColor = '';
                                            }
                                        @endphp

                                        <span class="badge {{$badgeColor}} text-uppercase">{{$subs->status_name ?? '-'}}</span>
                                    </td>
                                    <td class="py-2" data-label="Action">
                                        @if(session('role_id') == 2 || session('role_id') == 3 || session('role_id') == 4)
                                        <div class="btn-list flex-nowrap">
                                            <div class="dropdown ms-md-auto">
                                                <button class="btn btn-outline-primary dropdown-toggle align-text-top" data-bs-toggle="dropdown">
                                                    Actions
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">

                                                    @if($subs->status_name == 'Pending')
                                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-inprogress-subscription" href="#" data-product="{{ $subs->product_name}}" data-plan="{{ $subs->product_plan}}" data-subscription_id="{{ $subs->id}}">
                                                            Set In Progress
                                                        </a>
                                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-canceled-subscription" href="#" data-product="{{ $subs->product_name}}" data-plan="{{ $subs->product_plan}}" data-subscription_id="{{ $subs->id}}">
                                                            Set Canceled
                                                        </a>
                                                    @endif

                                                    @if($subs->status_name == 'In Progress')
                                                        <a class="dropdown-item" href="#" data-id="{{ $subs->id}}" onclick="fetchAndShowModal(this)">
                                                            Set Active
                                                        </a>
                                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-dismentle-subscription" href="#" data-product="{{ $subs->product_name}}" data-plan="{{ $subs->product_plan}}" data-subscription_id="{{ $subs->id}}">
                                                            Set Dismentle
                                                        </a>
                                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-canceled-subscription" href="#" data-product="{{ $subs->product_name}}" data-plan="{{ $subs->product_plan}}" data-subscription_id="{{ $subs->id}}">
                                                            Set Canceled
                                                        </a>
                                                    @endif

                                                    @if($subs->status_name == 'Dismentle')
                                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-update-subscription" href="#" data-product="{{ $subs->product_name}}" data-plan="{{ $subs->product_plan}}" data-subscription_id="{{ $subs->id}}">
                                                            Detail
                                                        </a>
                                                    @endif

                                                    @if($subs->status_name == 'Activated')
                                                        <a class="dropdown-item" href="#" data-id="{{ $subs->id}}" onclick="return fetchAndShowDetailModal(event, this)">
                                                            Detail
                                                        </a>
                                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-deactive-subscription" href="#" data-product="{{ $subs->product_name}}" data-plan="{{ $subs->product_plan}}" data-subscription_id="{{ $subs->id}}">
                                                            Set Deactive
                                                        </a>
                                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-dismentle-subscription" href="#" data-product="{{ $subs->product_name}}" data-plan="{{ $subs->product_plan}}" data-subscription_id="{{ $subs->id}}">
                                                            Set Dismentle
                                                        </a>
                                                    @endif

                                                    @if($subs->status_name == 'Deactivated')
                                                        <a class="dropdown-item" href="#" data-id="{{ $subs->id}}" onclick="return fetchAndShowDetailModal(event, this)">
                                                            Detail
                                                        </a>
                                                        <a class="dropdown-item" href="#" data-id="{{ $subs->id}}" onclick="fetchAndShowModal(this)">
                                                            Set Active
                                                        </a>
                                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-terminated-subscription" href="#" data-product="{{ $subs->product_name}}" data-plan="{{ $subs->product_plan}}" data-subscription_id="{{ $subs->id}}">
                                                            Set Terminated
                                                        </a>
                                                    @endif

                                                    @if($subs->status_name == 'Terminated')
                                                        <a class="dropdown-item" href="#" data-id="{{ $subs->id}}" onclick="return fetchAndShowDetailModal(event, this)">
                                                            Detail
                                                        </a>
                                                        <a class="dropdown-item" href="#" data-id="{{ $subs->id}}" onclick="fetchAndShowModal(this)">
                                                            Set Active
                                                        </a>
                                                    @endif

                                                    @if($subs->status_name == 'Canceled')
                                                        <a class="dropdown-item" href="#" data-id="{{ $subs->id}}" onclick="return fetchAndShowDetailModal(event, this)">
                                                            Detail
                                                        </a>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="py-2" colspan="7"></td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <br/>


                @if(session('role_id') == 3 || session('role_id') == 4)

                    @if(count($invoices) != 0)

                    <h3>Invoices History</h3>

                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-vcenter table-mobile-md card-table">
                                <thead>
                                    <tr>
                                        <th>Invoice ID</th>
                                        <th class="text-md-center">Invoice Type</th>
                                        <th class="text-md-center">Invoice Date</th>
                                        <th class="text-md-center">Due Date</th>
                                        <th class="text-md-center">Total (IDR)</th>
                                        <th class="text-md-center">Status</th>
                                        <th class="text-md-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($invoices as $inv)
                                    <tr>
                                        <td class="py-2 text-secondary" data-label="InvoiceID">
                                            @if($inv->is_publish == 0)
                                            <span class="badge text-azure">{{$inv->invoice_id}}</span>
                                            <span class="badge badge-outline text-azure">
                                                Draft
                                            </span>
                                            @else
                                                @if($inv->invoice_number == '')
                                                    <span class="badge bg-green-lt">{{$inv->invoice_id}}</span>
                                                @else
                                                    <span class="badge bg-green-lt">{{$inv->invoice_number}}</span>
                                                @endif
                                                <span class="badge bg-green text-green-fg">
                                                    Publish
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-2 text-secondary text-md-center text-capitalize" data-label="InvoiceTotal">
                                            {{$inv->invoice_type}}
                                        </td>
                                        <td class="py-2 text-secondary text-md-center" data-label="InvoiceDate">
                                            {{date('Y-M-d', strtotime($inv->invoice_date))}}
                                        </td>
                                        <td class="py-2 text-secondary text-md-center" data-label="InvoiceDueDate">
                                            {{date('Y-M-d', strtotime($inv->invoice_duedate))}}
                                        </td>
                                        <td class="py-2 text-secondary text-md-center" data-label="InvoiceTotal">
                                            {{number_format($inv->total, 0, ',', '.')}}
                                        </td>
                                        <td class="py-2 text-secondary text-md-center" data-label="Status">
                                            @php
                                                if ($inv->status_name == 'Unpaid') {
                                                    $badgeColor = 'border border-danger text-danger';
                                                } elseif ($inv->status_name == 'Paid') {
                                                    $badgeColor = 'border border-success text-success';
                                                } elseif ($inv->status_name == 'Canceled') {
                                                    $badgeColor = 'border border-warning text-warning';
                                                } else {
                                                    $badgeColor = 'border border-secondary text-secondary';
                                                }
                                            @endphp

                                            <span class="badge {{$badgeColor}}">
                                                {{$inv->status_name ?? '-'}}
                                            </span>
                                        </td>
                                        <td class="py-2">
                                            @if(session('role_id') == 2 || session('role_id') == 3 || session('role_id') == 4)
                                            <div class="btn-list flex-nowrap">
                                                <div class="dropdown ms-md-auto">
                                                    <button class="btn btn-outline-primary dropdown-toggle align-text-top" data-bs-toggle="dropdown">
                                                        Actions
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" href="{{ url('/console/invoices/detail/'.$inv->invoice_id) }}">
                                                            Detail
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            @else
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td class="py-2" colspan="7"></td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @endif
                @endif

                <br/>

                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">

                                            <div class="row g-3 align-items-center justify-content-between">
                                                <div class="col-auto col-sm-5 col-md-6 col-lg-auto">
                                                    <div class="form-label">Document SPK &nbsp; 
                                                        <!-- <button class="btn" data-bs-toggle="modal" data-bs-target="#modal-upload-spk" style="">Upload</button> -->
                                                    </div>
                                                </div>
                                                <div class="col-auto col-sm-7 col-md-6 col-lg-auto ms-auto d-print-none">
                                                    <div class="d-flex gap-2 justify-content-end">
                                                        @if(session('role_id') == 2 || session('role_id') == 3 || session('role_id') == 5)
                                                            <a href="/console/salesorder/document_spk/{{ Request::segment(4) }}" class="btn btn-outline-cyan">
                                                                Create SPK</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="card mt-2">
                                                <div class="table-responsive">
                                                    <table class="table table-vcenter table-mobile-md card-table">
                                                        <thead>
                                                            <tr>
                                                                <th>Number</th>
                                                                <th class="text-md-center">Type</th>
                                                                <th class="text-md-center">SPK Date</th>
                                                                <th class="text-md-center">SPK To</th>
                                                                <th class="text-md-center">Execution Date</th>
                                                                <th class="text-md-end">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($data_spk as $spk)
                                                            <tr>
                                                                <td class="py-2 text-secondary">
                                                                    {{$spk->spk_number}}
                                                                </td>
                                                                <td class="py-2 text-secondary text-md-center">
                                                                    {{$spk->spk_type}}
                                                                </td>
                                                                <td class="py-2 text-secondary text-md-center">
                                                                    {{date('d-M-Y', strtotime($spk->spk_date))}}
                                                                </td>
                                                                <td class="py-2 text-secondary text-md-center">
                                                                    {{$spk->spk_to}}
                                                                </td>
                                                                <td class="py-2 text-secondary text-md-center">
                                                                    {{date('d-M-Y', strtotime($spk->execution_date))}}
                                                                </td>
                                                                <td class="py-2">
                                                                    @if(session('role_id') == 2 || session('role_id') == 3 || session('role_id') == 5)
                                                                    <div class="btn-list flex-nowrap">
                                                                        <div class="dropdown ms-md-auto">
                                                                            <button class="btn btn-outline-primary dropdown-toggle align-text-top" data-bs-toggle="dropdown">
                                                                                Actions
                                                                            </button>
                                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                                <a class="dropdown-item" href="{{ url('/console/salesorder/spk/'.$spk->id) }}">
                                                                                    Detail
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @else
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            @empty
                                                            <tr>
                                                                <td class="py-2" colspan="7"></td>
                                                            </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>



<!--                                             <br/>    
                                            <div class="row">
                                                <div style="background:#efefef;font-size:11px;padding:5px;" class="col-5">Document</div>
                                                <div style="background:#efefef;font-size:11px;padding:5px;" class="col-5">Tgl Upload</div>
                                                <div style="background:#efefef;font-size:11px;text-align:center;padding:5px;" class="col-2">Action</div>
                                            </div>
                                            @forelse($document_spk as $spk)
                                                <div class="row" style="margin-top:10px;">
                                                    <div class="col-5">{{$spk->document_number}}</div>
                                                    <div class="col-5">{{$spk->created_at}}</div>
                                                    <div class="col-2"><a href="{{ url('/console/salesorder/download_document/'.$spk->document_name) }}" class="btn">Download</a></div>
                                                </div>
                                            @empty
                                                <div class="alert alert-info alert-dismissible" role="alert">
                                                    <div class="d-flex">
                                                        <div>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"></path><path d="M9 17h-2"></path><path d="M13 14h-6"></path><path d="M11 11h-4"></path></svg>
                                                        &nbsp;
                                                        </div>
                                                        <div>
                                                        Belum ada dokumen di upload
                                                        </div>
                                                    </div>
                                                </div>  
                                            @endforelse
 -->                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>                          
                            </div>
                            
                </div>

                <br/>                                   
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <div class="form-label">Upload Document BA &nbsp; <button class="btn" data-bs-toggle="modal" data-bs-target="#modal-upload-ba" style="">Upload</button></div>
                                            <br/>    
                                            <div class="row">
                                                <div style="background:#efefef;font-size:11px;padding:5px;" class="col-5">Document</div>
                                                <div style="background:#efefef;font-size:11px;padding:5px;" class="col-5">Tgl Upload</div>
                                                <div style="background:#efefef;font-size:11px;text-align:center;padding:5px;" class="col-2">Action</div>
                                            </div>
                                            @forelse($document_ba as $ba)
                                                <div class="row" style="margin-top:10px;">
                                                    <div class="col-5">{{$ba->document_number}}</div>
                                                    <div class="col-5">{{$ba->created_at}}</div>
                                                    <div class="col-2"><a href="{{ url('/console/salesorder/download_document/'.$ba->document_name) }}" class="btn">Download</a></div>
                                                </div>
                                            @empty
                                                <div class="alert alert-info alert-dismissible" role="alert">
                                                    <div class="d-flex">
                                                        <div>
                                                        <!-- Download SVG icon from http://tabler-icons.io/i/info-circle -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"></path><path d="M9 17h-2"></path><path d="M13 14h-6"></path><path d="M11 11h-4"></path></svg>
                                                        &nbsp;
                                                        </div>
                                                        <div>
                                                        Belum ada dokumen di upload
                                                        </div>
                                                    </div>
                                                </div>  
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>                          
                            </div>
                            
                </div>

                <br />
                <div class="card-body mb-4">
                    <h3 class="card-title">Sales Activity</h3>
                    <ul class="steps steps-vertical">
                        @forelse($sales_activity as $activity)
                        <li class="step-item">
                            <div class="h4 m-0">{{$activity->log_label}} - <span class="text-secondary">{{date('Y-M-d H:i:s', strtotime($activity->created_at))}}</span></div>
                            <div class="text-secondary">{{$activity->log_entry}}</div>
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

            <div class="col-md-6 col-lg-4">

                <div class="card-tabs">
                    <!-- Cards navigation -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation"><a href="#tab-top-1" class="nav-link active"
                                data-bs-toggle="tab" aria-selected="true" role="tab">Status Activity</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!-- Content of card #1 -->
                        <div id="tab-top-1" class="card tab-pane active show" role="tabpanel">
                            <div class="card-body">
                                <form method="POST" action="/console/salesorder/update_status" id="form-salesorder">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <input type="hidden" name="order_id" value="{{ Request::segment(4) }}" />

                                    <!--
                                    allowed role
                                    2 : Network Engginer
                                    3 : Administrator
                                    6 : Sales Leader
                                    -->

                                    @if(session('role_id') == 2 || session('role_id') == 3 || session('role_id') == 6)
                                    <div class="form-floating" style="width:100%;border-radius:4px">

                                        @if(session('role_id') == 6)
                                        <select class="form-select" name="status_id" id="status_so"
                                            aria-label="Floating label select example">
                                            <option selected="" value="{{$order->status_id}}">{{$order->status_name}}
                                            </option>
                                            <option value="1005">Pending</option>
                                            <option value="1035">Completed</option>
                                            <option value="1008">Canceled</option>
                                        </select>
                                        @elseif(session('role_id') == 3)
                                        <select class="form-select" name="status_id" id="status_so"
                                            aria-label="Floating label select example">
                                            <option selected="" value="{{$order->status_id}}">{{$order->status_name}}
                                            </option>
                                            <option value="1043">Penarikan Kabel DW</option>
                                            <option value="1044">Penyambungan Kabel DW</option>
                                            <option value="1045">Aktivasi Dan Konfigurasi ONT</option>
                                            <option value="1046">Uji Coba Layanan</option>
                                            <option value="1047">Penandatanganan BAA</option>
                                            <option value="1048">Review Layanan</option>
                                            <option value="1005">Pending</option>
                                            <option value="1035">Completed</option>
                                            <option value="1008">Canceled</option>
                                            <option value="1009">Deleted</option>
                                        </select>
                                        @else
                                        <select class="form-select" name="status_id" id="status_so"
                                            aria-label="Floating label select example">
                                            <option selected="" value="{{$order->status_id}}">{{$order->status_name}}
                                            </option>
                                            <option value="1043">Penarikan Kabel DW</option>
                                            <option value="1044">Penyambungan Kabel DW</option>
                                            <option value="1045">Aktivasi Dan Konfigurasi ONT</option>
                                            <option value="1046">Uji Coba Layanan</option>
                                            <option value="1047">Penandatanganan BAA</option>
                                            <option value="1048">Review Layanan</option>
                                            <option value="1005">Pending</option>
                                            <option value="1035">Completed</option>
                                            <option value="1008">Canceled</option>
                                        </select>
                                        @endif
                                        <label for="floatingSelect">Sales Order Status</label>
                                    </div>
                                    @else
                                        <p class="datagrid-title">Sales Order Status :</p>
                                        <div class="h3 m-0">{{$order->status_name}}</div>
                                    @endif

                                </form>

                            </div>
                        </div>

                    </div>
                </div>

                <br />

                <div class="card-tabs">
                    <!-- Cards navigation -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation"><a href="#tab-top-1" class="nav-link active"
                                data-bs-toggle="tab" aria-selected="true" role="tab">Project Area</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!-- Content of card #1 -->
                        <div id="tab-top-1" class="card tab-pane active show" role="tabpanel">
                            <div class="card-body">
                                <form method="POST" action="/console/salesorder/update_project" id="form-project-salesorder">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <input type="hidden" name="order_id" value="{{ Request::segment(4) }}" />

                                    @if(session('role_id') == 1 || session('role_id') == 3 || session('role_id') == 6)
                                    <div class="form-floating" style="width:100%;border-radius:4px">
                                        <select class="form-select text-capitalize" name="project_id" id="project_so"
                                            aria-label="">
                                            @if($order_project == "")
                                            <option value="">Area coverage</option>
                                            @endif

                                            @forelse($site_project as $proj)
                                                <option value="{{ $proj->id }}" {{ $proj->id == $order_project ? "selected" : "" }}>{{ $proj->project_name }}
                                                @empty
                                                <option value="">No Project Found</option>
                                            @endforelse
                                        </select>
                                        <label for="floatingSelect">Sales Order Project</label>
                                    </div>
                                    @else
                                    <div class="form-floating" style="width:100%;border-radius:4px">
                                        <select class="form-select" name="project_id" id="project_so"
                                            aria-label="" disabled="">
                                            @if($order_project == "")
                                            <option value="">Area coverage</option>
                                            @endif

                                            @forelse($site_project as $proj)
                                                    @if($proj->id == $order_project)
                                                    <option value="{{ $proj->id }}" {{ $proj->id == $order_project ? "selected" : "" }}>{{ $proj->project_name }}
                                                    @endif
                                                @empty
                                                <option value="">No Project Found</option>
                                            @endforelse
                                        </select>
                                        <label for="floatingSelect">Sales Order Project</label>
                                    </div>
                                    @endif

                                </form>

                            </div>
                        </div>

                    </div>
                </div>

                <br />

                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Activity Info</h3>
                        @if($order->order_progress == '')
                        <p>There is no information activity updates</p>
                        @else
                        <p class="text-secondary">{{$order->order_progress}}</p>
                        @endif
                    </div>
                    <!-- Card footer -->
                    <div class="card-footer">
                        @if(session('role_id') == 2 || session('role_id') == 3 || session('role_id') == 6)
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal-simple" class="btn btn-primary">Create
                            New Info</a>
                        @else

                        @endif
                    </div>
                </div>

                <br/>                                        
                <div class="card">
                    <!-- Card footer -->
                    <div class="card-footer">
                        <a href="/console/salesorder/document_spk/{{ Request::segment(4) }}" class="btn">
                            Print / Download SPK</a>
                    </div>
                </div>

                <br/>                                        
                <div class="card">
                    <!-- Card footer -->
                    <div class="card-footer">
                        <a href="/console/salesorder/document_ba/{{ Request::segment(4) }}"  class="btn">
                            Print / Download BA</a>
                    </div>
                </div>


            </div>

        </div>

    </div>

</div>

@include('component.modal.update-salesorder-progress')

@include('component.modal.update-subscription')
@include('component.modal.activated-subscription')
@include('component.modal.deactive-subscription')
@include('component.modal.canceled-subscription')
@include('component.modal.terminated-subscription')
@include('component.modal.dismentle-subscription')
@include('component.modal.inprogress-subscription')
@include('component.modal.inprogress-subscription')
@include('component.modal.upload-document-spk')
@include('component.modal.upload-document-ba')

@if(session('role_id') == 3)

@endif


<form style="display:none" method="POST" action="/" id="form-like">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
</form>
    
<script type="text/javascript">

    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('#form-like  ').find('input[name="_token"]').first().val()
            }
        });

        $('#status_so, #project_so').change('change', function () {
            this.form.submit();
        });

        $('.set_targettolive').change('change', function () {
            this.form.submit();
        });

        // document.getElementById('field').innerText = plan;

    });


</script>


<script>
  const inprogressModal = document.getElementById('modal-inprogress-subscription');
  inprogressModal.addEventListener('show.bs.modal', function (event) {
    console.log(event.relatedTarget);
    const button = event.relatedTarget; // Tombol yang ditekan
    const subscription_id = button.getAttribute('data-subscription_id');
    const product = button.getAttribute('data-product');
    const plan = button.getAttribute('data-plan');

    document.getElementById('subscription_id').value = subscription_id;
    document.getElementById('product').innerText = product;
    document.getElementById('plan').innerText = plan;
  });


  const canceledModal = document.getElementById('modal-canceled-subscription');
  canceledModal.addEventListener('show.bs.modal', function (event) {
    console.log(event.relatedTarget);
    const button = event.relatedTarget; // Tombol yang ditekan
    const subscription_id = button.getAttribute('data-subscription_id');
    const product = button.getAttribute('data-product');
    const plan = button.getAttribute('data-plan');

    document.getElementById('c_subscription_id').value = subscription_id;
    document.getElementById('c_product').innerText = product;
    document.getElementById('c_plan').innerText = plan;
  });

  const dismentleModal = document.getElementById('modal-dismentle-subscription');
  dismentleModal.addEventListener('show.bs.modal', function (event) {
    console.log(event.relatedTarget);
    const button = event.relatedTarget; // Tombol yang ditekan
    const subscription_id = button.getAttribute('data-subscription_id');
    const product = button.getAttribute('data-product');
    const plan = button.getAttribute('data-plan');

    document.getElementById('d_subscription_id').value = subscription_id;
    document.getElementById('d_product').innerText = product;
    document.getElementById('d_plan').innerText = plan;
  });

  const deactiveModal = document.getElementById('modal-deactive-subscription');
  deactiveModal.addEventListener('show.bs.modal', function (event) {
    console.log(event.relatedTarget);
    const button = event.relatedTarget; // Tombol yang ditekan
    const subscription_id = button.getAttribute('data-subscription_id');
    const product = button.getAttribute('data-product');
    const plan = button.getAttribute('data-plan');

    document.getElementById('da_subscription_id').value = subscription_id;
    document.getElementById('da_product').innerText = product;
    document.getElementById('da_plan').innerText = plan;
  });

  const terminatedModal = document.getElementById('modal-terminated-subscription');
  terminatedModal.addEventListener('show.bs.modal', function (event) {
    console.log(event.relatedTarget);
    const button = event.relatedTarget; // Tombol yang ditekan
    const subscription_id = button.getAttribute('data-subscription_id');
    const product = button.getAttribute('data-product');
    const plan = button.getAttribute('data-plan');

    document.getElementById('t_subscription_id').value = subscription_id;
    document.getElementById('t_product').innerText = product;
    document.getElementById('t_plan').innerText = plan;
  });

function fetchAndShowModal(button) {
    const subsId = $(button).data('id');  // Ambil data-id dari tombol

    // Kosongkan isi modal sebelum data masuk
    // $('#modalName').text('Loading...');
    // $('#modalEmail').text('');
    // $('#modalPhone').text('');

    // Panggil API (contoh: https://jsonplaceholder.typicode.com/users/{id})
    $.ajax({
      url: `{{ route('get_detail_subs') }}`,
      method: 'POST',
        data: {
            subscription_id: subsId,
        },
      success: function(data) {
        data = JSON.parse(data);
        console.log(data);
        // Isi modal dengan data dari API
        document.getElementById('ac_subscription_id').value = subsId;
        $('.product_name').text(data.subs.product_name);
        $('.product_plan').text(data.subs.product_plan);
        $('.status_name').text(data.subs.status_name);
        $('.subscription_number').text(data.subs.subscription_number ? data.subs.subscription_number : '-');
        $('.billing_account').text(data.subs.billing_account ? data.subs.billing_account : '-');
        $('.billingcycle').text(data.subs.billingcycle ? data.subs.billingcycle : '-');
        $('.expired_date').text(data.subs.expired_date ? data.subs.expired_date : '-');
        $('.amount').val(data.subs.amount);
        const created_at = new Date(data.subs.created_at.replace(' ', 'T')).toLocaleDateString('en-GB');
        $('.created_at').text(created_at);

        const warna = {
          "Pending": "btn-info",
          "Activated": "btn-success",
          "Deactivated": "btn-warning",
          "Terminated": "btn-danger",
          "Canceled": "btn-warning",
          "Dismentle": "btn-warning",
          "In Progress": "btn-warning"
        };
        $('.status_name').addClass(warna[data.subs.status_name]);

        $('.subs_field').html("");
        data.subs_field.forEach(field => {
            let type = "";
            if (field.field_type == "link") {
                type = `<a target="_blank" href="${field.value}" class="badge bg-blue text-blue-fg">Link</a>`;
            } else {
                type = field.value;
            }

            $('.subs_field').append(`<tr><td style="padding-left:0px">${field.field}</td><td style="padding-left:10px;padding-right:10px">:</td><td>${type}</td></tr>`);
        });

        $('.stat').html("");
        $('.note').html("");
        if (data.subs.status_name == "In Progress") {
            $('.stat').append('<td>Progress Start Date</td><td>:</td><td><span class="badge bg-grey text-grey-fg">'+data.subs.progress_date+'</span></td>');
            $('.note').append('<td>Note In Progress</td><td>:</td><td><span class="text-secondary" style="font-size:12px">'+data.subs.suspend_reason+'</span></td>');
        } else if(data.subs.status_name == "Deactivated") {
            $('.stat').append('<td>Deactivated Date</td><td>:</td><td><span class="badge bg-grey text-grey-fg">'+data.subs.deactive_date+'</span></td>');
            $('.note').append('<td>Deactivated Reason</td><td>:</td><td><span class="text-secondary" style="font-size:12px">'+data.subs.suspend_reason+'</span></td>');
        } else if(data.subs.status_name == "Terminated") {
            $('.stat').append('<td>Terminated Date</td><td>:</td><td><span class="badge bg-grey text-grey-fg">'+data.subs.termination_date+'</span></td>');
            $('.note').append('<td>Terminated Reason</td><td>:</td><td><span class="text-secondary" style="font-size:12px">'+data.subs.suspend_reason+'</span></td>');
        } else if(data.subs.status_name == "Canceled") {
            $('.stat').append('<td>Canceled Date</td><td>:</td><td><span class="badge bg-grey text-grey-fg">'+data.subs.cancel_date+'</span></td>');
            $('.note').append('<td>Canceled Reason</td><td>:</td><td><span class="text-secondary" style="font-size:12px">'+data.subs.suspend_reason+'</span></td>');
        } else if(data.subs.status_name == "Dismentle") {
            $('.stat').append('<td>Progress Start Date</td><td>:</td><td><span class="badge bg-grey text-grey-fg">'+data.subs.dismentle_date+'</span></td>');
            $('.note').append('<td>Note In Progress</td><td>:</td><td><span class="text-secondary" style="font-size:12px">'+data.subs.suspend_reason+'</span></td>');
        }


        $('.submit').html("");
        if (data.subs.status_name == "Deactivated" || data.subs.status_name == "Pending" || data.subs.status_name == "Terminated" || data.subs.status_name == "In Progress" || data.subs.status_name == "Dismentle" ) {
            $('.submit').append('Terbit Invoices? <input type="checkbox" id="form-control" name="terbit_invoices" value="true" ><button type="submit" class="btn btn-primary ms-2" data-bs-dismiss="modal">Set Activated</button>');
        }

        // Tampilkan modal
        new bootstrap.Modal(document.getElementById('modal-activated-subscription')).show();
      },
      error: function() {
        alert('Gagal mengambil data. Coba lagi.');
      }
    });
  }


function fetchAndShowDetailModal(event, button) {
    // Prevent default anchor navigation
    if (event && typeof event.preventDefault === 'function') {
        event.preventDefault();
    }
    // Hindari event bubbling yang bisa menutup dropdown sebelum modal tampil
    if (event && typeof event.stopPropagation === 'function') {
        event.stopPropagation();
    }
    const subsId = $(button).data('id');  // Ambil data-id dari tombol

    // Kosongkan isi modal sebelum data masuk
    // $('#modalName').text('Loading...');
    // $('#modalEmail').text('');
    // $('#modalPhone').text('');

    // Panggil API (contoh: https://jsonplaceholder.typicode.com/users/{id})
    $.ajax({
      url: `{{ route('get_detail_subs') }}`,
      method: 'POST',
        data: {
            subscription_id: subsId,
        },
      success: function(data) {
        // Jika response sudah berupa object (JSON otomatis diparse), jangan diparse ulang
        let resp = data;
        if (typeof data === 'string') {
            try {
                resp = JSON.parse(data);
            } catch (e) {
                console.error('JSON parse error in fetchAndShowDetailModal:', e, data);
            }
        }
        data = resp;
        console.log(data);
        // Isi modal dengan data dari API
        // Safe set subscription id if input exists
        const dtInput = document.getElementById('dt_subscription_id');
        if (dtInput) {
            dtInput.value = subsId;
        }
        $('.product_name').text(data.subs.product_name);
        $('.product_plan').text(data.subs.product_plan);
        $('.status_name').text(data.subs.status_name);
        $('.subscription_number').text(data.subs.subscription_number ? data.subs.subscription_number : '-');
        $('.billing_account').text(data.subs.billing_account ? data.subs.billing_account : '-');
        $('.billingcycle').text(data.subs.billingcycle ? data.subs.billingcycle : '-');
        $('.amount').val(data.subs.amount);
        $('.created_at').text(data.subs.created_at);
        $('.is_free').val(data.subs.is_free);

        // const date = new Date(data.subs.complete_date);
        // const complete_date = new Intl.DateTimeFormat('id-ID', {
        //   weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
        // }).format(date);
        // Format tanggal dengan aman (handle null/undefined dan format yang tidak valid)
        const toDateStr = (val) => {
            if (!val) return '-';
            try {
                const iso = String(val).replace(' ', 'T');
                const d = new Date(iso);
                if (!isNaN(d.getTime())) {
                    return d.toLocaleDateString('en-GB');
                }
            } catch (e) {
                console.warn('Invalid date value:', val, e);
            }
            return '-';
        };

        // Format tanggal + jam (HH:mm:ss) dengan aman
        const toDateTimeStr = (val) => {
            if (!val) return '-';
            try {
                const iso = String(val).replace(' ', 'T');
                const d = new Date(iso);
                if (!isNaN(d.getTime())) {
                    const pad = (n) => String(n).padStart(2, '0');
                    const dd = pad(d.getDate());
                    const mm = pad(d.getMonth() + 1);
                    const yyyy = d.getFullYear();
                    const HH = pad(d.getHours());
                    const MM = pad(d.getMinutes());
                    const SS = pad(d.getSeconds());
                    return `${dd}/${mm}/${yyyy} ${HH}:${MM}:${SS}`;
                }
            } catch (e) {
                console.warn('Invalid datetime value:', val, e);
            }
            return '-';
        };

        // Tampilkan tanggal + jam untuk complete_date
        $('.complete_date').text(toDateTimeStr(data.subs.complete_date));
        $('.created_at').text(toDateStr(data.subs.created_at));
        // Expired date untuk modal update-subscription
        // Tampilkan expired_date dengan jam
        $('.expired_date').text(toDateTimeStr(data.subs.expired_date));

        const warna = {
          "Pending": "btn-info",
          "Activated": "btn-success",
          "Deactivated": "btn-warning",
          "Terminated": "btn-danger",
          "Canceled": "btn-warning",
          "Dismentle": "btn-warning",
          "In Progress": "btn-warning"
        };
        $('.status_name').addClass(warna[data.subs.status_name]);

        $('#subs_field').html("");
        data.subs_field.forEach(field => {
            let type = "";
            if (field.field_type == "link") {
                type = `<a target="_blank" href="${field.value}" class="badge bg-blue text-blue-fg">Link</a>`;
            } else {
                type = field.value;
            }

            $('#subs_field').append(`<tr><td style="padding-left:0px">${field.field}</td><td style="padding-left:10px;padding-right:10px">:</td><td>${type}</td></tr>`);
        });

        $('.stat2').html("");
        $('.note2').html("");
        if (data.subs.status_name == "In Progress") {
            $('.stat2').append('<td>Progress Start Date</td><td>:</td><td><span class="badge bg-grey text-grey-fg">'+data.subs.progress_date+'</span></td>');
            $('.note2').append('<td>Note In Progress</td><td>:</td><td><span class="text-secondary" style="font-size:12px">'+data.subs.suspend_reason+'</span></td>');
        } else if(data.subs.status_name == "Deactivated") {
            $('.stat2').append('<td>Deactivated Date</td><td>:</td><td><span class="badge bg-grey text-grey-fg">'+data.subs.deactive_date+'</span></td>');
            $('.note2').append('<td>Deactivated Reason</td><td>:</td><td><span class="text-secondary" style="font-size:12px">'+data.subs.suspend_reason+'</span></td>');
        } else if(data.subs.status_name == "Terminated") {
            $('.stat2').append('<td>Terminated Date</td><td>:</td><td><span class="badge bg-grey text-grey-fg">'+data.subs.termination_date+'</span></td>');
            $('.note2').append('<td>Terminated Reason</td><td>:</td><td><span class="text-secondary" style="font-size:12px">'+data.subs.suspend_reason+'</span></td>');
        } else if(data.subs.status_name == "Canceled") {
            $('.stat2').append('<td>Canceled Date</td><td>:</td><td><span class="badge bg-grey text-grey-fg">'+data.subs.cancel_date+'</span></td>');
            $('.note2').append('<td>Canceled Reason</td><td>:</td><td><span class="text-secondary" style="font-size:12px">'+data.subs.suspend_reason+'</span></td>');
        } else if(data.subs.status_name == "Dismentle") {
            $('.stat2').append('<td>Progress Start Date</td><td>:</td><td><span class="badge bg-grey text-grey-fg">'+data.subs.dismentle_date+'</span></td>');
            $('.note2').append('<td>Note In Progress</td><td>:</td><td><span class="text-secondary" style="font-size:12px">'+data.subs.suspend_reason+'</span></td>');
        }


        if (data.subs_activity.length > 0) {
            $('#subs_activity').html(``);
            data.subs_activity.forEach(field => {
                const log = `<li class="step-item"><div class="h4 m-0">${field.log_label} - <span class="text-secondary"> ${field.created_at}</span></div><div class="text-secondary">${field.log_entry}</div></li>`;
                $('#subs_activity').append(log);
            });            
        } else {
            $('#subs_activity').html(`<li class="step-item"><div class="h4 m-0">Empty Log Activity</span></div><div class="text-secondary">Belum ada log tercatat</div></li>`);
        }

        $('.submit').html("");
        if (data.subs.status_name == "Deactivated"  || data.subs.status_name == "Pending" || data.subs.status_name == "Terminated" || data.subs.status_name == "In Progress" || data.subs.status_name == "Dismentle" ) {
            $('.submit').append('Terbit Invoices? <input type="checkbox" id="form-control" name="terbit_invoices" value="true" ><button type="submit" class="btn btn-primary ms-2" data-bs-dismiss="modal">Set Activated</button>');
        }

        // Tampilkan modal (fallback untuk BS4 jika objek bootstrap tidak tersedia)
        const modalEl = document.getElementById('modal-update-subscription');
        if (window.bootstrap && typeof bootstrap.Modal === 'function') {
            new bootstrap.Modal(modalEl).show();
        } else if (typeof $ !== 'undefined' && $.fn && typeof $.fn.modal === 'function') {
            $(modalEl).modal('show');
        } else {
            // Fallback minimal supaya tetap terlihat meski tanpa Bootstrap JS
            modalEl.classList.add('show');
            modalEl.style.display = 'block';
        }
      },
      error: function() {
        alert('Gagal mengambil data. Coba lagi.');
      }
    });
    // Pastikan tidak ada navigasi default dari anchor
    return false;
  }


</script>


<style type="text/css">
.table-responsive {
    overflow: visible;
}
.mod {
    max-width: 60% !important;
}

.subscription-body {
    padding:0px !important;
}
</style>


@endsection
