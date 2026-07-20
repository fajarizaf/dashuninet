@extends('layouts.console')
@section('container')


<!-- Page header -->
<div class="page-header d-print-none text-white">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    Order Number
                </div>
                <h2 class="page-title">
                {{ Request::segment(4) }}
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <span class="d-none d-sm-inline">
                        <a href="{{ url('/console/salesorder/statistic/perday') }}" class="btn btn-dark">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-align-box-bottom-center" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M3 3m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                                <path d="M9 15v2" />
                                <path d="M12 11v6" />
                                <path d="M15 13v4" />
                            </svg>
                            Statistics
                        </a>
                    </span>
                    <a href="{{ url('/') }}/console/order/" class="btn btn-primary d-none d-sm-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-align-left"
                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M4 6l16 0" />
                            <path d="M4 12l10 0" />
                            <path d="M4 18l14 0" />
                        </svg>
                        Order List
                    </a>
                    <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal"
                        data-bs-target="#modal-report" aria-label="Create new report">
                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
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
                            {{$order_detail->customer_name}}
                            <a href="{{ url('/') }}/console/customer/detail/{{$customer_id}}" class="badge bg-indigo text-indigo-fg">Detail Info</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="subheader">Customer Phone</div>
                        <div class="h3 m-0">{{$order_detail->customer_phone}}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="subheader">Customer Email</div>
                        <div class="h3 m-0">{{$order_detail->customer_email}}</div>
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
                            <!-- Download SVG icon from http://tabler-icons.io/i/info-circle -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M5 12l5 5l10 -10"></path>
                            </svg>
                        </div>
                        <div>
                            {{ session('success') }}
                        </div>
                    </div>
                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-pills card-header-pills">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">
                                    Customer Order Info
                                </a>
                            </li>
                            <li class="nav-item ms-auto">
                                <a class="nav-link" href="#">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/settings -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path
                                            d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z">
                                        </path>
                                        <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">

                        <div class="datagrid">
                            <div class="datagrid-item">
                                <div class="datagrid-title">Date Order</div>
                                <div class="datagrid-content">{{date('Y-M-d H:i:s', strtotime($order->order_date))}}
                                </div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Order Notes</div>
                                <div class="datagrid-content text-secondary">
                                    {{$order->order_notes}}
                                </div>
                            </div>
                        </div>
                        <br />
                        <br />

                        <h3>Product Order :</h3>

                        <div class="card">
                            <div class="table-responsive">
                                <table class="table table-vcenter table-mobile-md card-table">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Unit Price</th>
                                            <th>Billing Cycle</th>
                                            <th>Promo</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse($order_item as $item)

                                        <tr>
                                            <td data-label="Name">
                                                <div class="d-flex py-1 align-items-center">
                                                    <span class="avatar me-2"
                                                        style="background-image: url(./static/avatars/010m.jpg)"></span>
                                                    <div class="flex-fill">
                                                        <div class="font-weight-medium">{{$item->product_name}}</div>
                                                        <span class="text-secondary">{{$item->product_plan}}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td data-label="Title">
                                                <div class="text-secondary">IDR. {{$item->unit_price}}</div>
                                            </td>
                                            <td class="text-secondary" data-label="Promo">
                                                {{$item->billing_cycle}}
                                            </td>
                                            <td class="text-secondary" data-label="Promo">
                                                {{$item->promo}}
                                            </td>
                                            <td class="text-secondary" data-label="Status">
                                                {{$item->quantity}}
                                            </td>
                                            <td>
                                                <div class="btn-list flex-nowrap">
                                                    <div class="text-secondary">IDR.{{$item->unit_price}}</div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">

                                                <h4>Product Information Field :</h4>

                                                <div style="padding-left:0px;" class="text-secondary">
                                                    <table>
                                                        @forelse($order_field as $field)
                                                        <tr>
                                                            <td style="padding-left:0px">{{ucfirst($field->field)}}</td>
                                                            <td style="padding-left:10px;padding-right:10px">:</td>
                                                            <td>
                                                                @if($field->field_type == "link")
                                                                    @if(filter_var($field->value, FILTER_VALIDATE_URL) == true)
                                                                        <a target="_blank" href="{{$field->value}}" class="badge bg-blue text-blue-fg">Link</a>
                                                                    @else
                                                                        <a href="#" class="badge bg-blue text-blue-fg">Link tidak valid</a>
                                                                    @endif
                                                                @else
                                                                    {{ucfirst($field->value)}}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @empty
                                                        @endforelse
                                                    </table>
                                                </div>

                                            </td>
                                        </tr>

                                        @empty
                                        <tr>
                                            <td colspan="5">

                                                <div class="empty">
                                                    <p class="empty-title">No results found</p>
                                                    <p class="empty-subtitle text-secondary">
                                                        Product Order not found
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
                                    <th>Product Name</th>
                                    <th>Billing Cycle</th>
                                    <th>Date Live</th>
                                    <th>Status</th>
                                    <th class="w-1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subscription as $subs)
                                <tr>
                                    <td data-label="Name">
                                        <div class="d-flex py-1 align-items-center">
                                            <span class="avatar me-2"
                                                style="background-image: url(./static/avatars/010m.jpg)"></span>
                                            <div class="flex-fill">
                                                <div class="font-weight-medium">{{$subs->product_name}}</div>
                                                <div class="text-secondary"><a href="#"
                                                    class="text-reset">CSID : {{$subs->subscription_number}}</a>
                                                </div>
                                                <div class="text-secondary"><a href="#"
                                                    class="text-reset">{{$subs->product_plan}}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-secondary" data-label="Promo">
                                        {{$subs->billingcycle}}
                                    </td>
                                    <td class="text-secondary" data-label="Status">
                                        @if($subs->complete_date  !== null)
                                            <span class="badge bg-green text-green-fg">
                                                {{date('Y-M-d', strtotime($subs->complete_date))}}
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-secondary" data-label="Status">

                                        @if($subs->status_name == 'Deactivated')
                                            <a href="#" class="btn btn-outline-warning w-100">
                                                {{$subs->status_name}}
                                            </a>
                                        @endif

                                        @if($subs->status_name == 'Activated')
                                            <a href="#" class="btn btn-outline-success w-100">
                                                {{$subs->status_name}}
                                            </a>
                                        @endif

                                        @if($subs->status_name == 'Pending')
                                            <a href="#" class="btn btn-outline-info w-100">
                                                {{$subs->status_name}}
                                            </a>
                                        @endif

                                        @if($subs->status_name == 'Terminated')
                                            <a href="#" class="btn btn-outline-danger w-100">
                                                {{$subs->status_name}}
                                            </a>
                                        @endif

                                        @if($subs->status_name == 'Canceled')
                                            <a href="#" class="btn btn-outline-secondary w-100">
                                                {{$subs->status_name}}
                                            </a>
                                        @endif

                                    </td>
                                    <td>
                                        @if(session('role_id') == 2 || session('role_id') == 3 || session('role_id') == 4) 
                                        <div class="btn-list flex-nowrap">
                                            <div class="dropdown">
                                                <button class="btn dropdown-toggle align-text-top"
                                                    data-bs-toggle="dropdown">
                                                    Actions
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">

                                                    @if($subs->status_name == 'Pending')
                                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-activated-subscription" href="#">
                                                            Set Active
                                                        </a>
                                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-canceled-subscription" href="#">
                                                            Set Canceled
                                                        </a>
                                                    @endif

                                                    @if($subs->status_name == 'Activated')
                                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-update-subscription" href="#">
                                                            Detail
                                                        </a>
                                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-deactive-subscription" href="#">
                                                            Set Deactive
                                                        </a>
                                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-terminated-subscription" href="#">
                                                            Set Terminated
                                                        </a>
                                                    @endif

                                                    @if($subs->status_name == 'Deactivated')
                                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-update-subscription" href="#">
                                                            Detail
                                                        </a>
                                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-activated-subscription" href="#">
                                                            Set Active
                                                        </a>
                                                    @endif

                                                    @if($subs->status_name == 'Terminated')
                                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-update-subscription" href="#">
                                                            Detail
                                                        </a>
                                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-activated-subscription" href="#">
                                                            Set Active
                                                        </a>
                                                    @endif

                                                    @if($subs->status_name == 'Canceled')
                                                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-update-subscription" href="#">
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
                                    <td colspan="5"></td>
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
                                        <th>Invoice Date</th>
                                        <th>Due Date</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th class="w-1"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($invoices as $inv)
                                    <tr>
                                        <td class="text-secondary" data-label="InvoiceID">
                                            @if($inv->is_publish == 0)
                                            <span class="badge text-azure">{{$inv->id}}</span>
                                            <span class="badge badge-outline text-azure">
                                                Draft
                                            </span>
                                            @else
                                                @if($inv->invoice_number == '')
                                                    <span class="badge bg-green-lt">{{$inv->id}}</span>
                                                @else
                                                    <span class="badge bg-green-lt">{{$inv->invoice_number}}</span>
                                                @endif
                                                <span class="badge bg-green text-green-fg">
                                                    Publish
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-secondary" data-label="InvoiceDate">
                                            {{date('Y-M-d', strtotime($inv->invoice_date))}}
                                        </td>
                                        <td class="text-secondary" data-label="InvoiceDueDate">
                                            {{date('Y-M-d', strtotime($inv->invoice_duedate))}}
                                        </td>
                                        <td class="text-secondary" data-label="InvoiceTotal">
                                            IDR. {{$inv->total}}
                                        </td>
                                        <td class="text-secondary" data-label="Status">
                                            @if($inv->status_name == 'Unpaid')
                                            <a href="#" class="btn btn-info w-100">
                                                {{$inv->status_name}}
                                            </a>
                                            @endif
                                            @if($inv->status_name == 'Paid')
                                            <a href="#" class="btn btn-success w-100">
                                                {{$inv->status_name}}
                                            </a>
                                            @endif
                                            @if($inv->status_name == 'Canceled')
                                            <a href="#" class="btn btn-secondary w-100">
                                                {{$inv->status_name}}
                                            </a>
                                            @endif
                                        </td>
                                        <td>
                                            @if(session('role_id') == 2 || session('role_id') == 3) 
                                            <div class="btn-list flex-nowrap">
                                                <div class="dropdown">
                                                    <button class="btn dropdown-toggle align-text-top"
                                                        data-bs-toggle="dropdown">
                                                        Actions
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        @if($inv->is_publish == 0)
                                                        <a class="dropdown-item" href="{{ url('/console/invoices/detail/'.$inv->id) }}">
                                                            Detail
                                                        </a>
                                                        @else
                                                        <a class="dropdown-item" href="{{ url('/console/invoices/detail/'.$inv->id) }}">
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
                                        <td colspan="5"></td>
                                    </tr>
                                    @endforelse


                                </tbody>
                            </table>
                        </div>
                    </div>

                    @endif
                @endif                            

                <br />
                <div class="card-body">
                    <h3 class="card-title">Sales Activity</h3>
                    <ul class="steps steps-vertical">
                        @forelse($sales_activity as $activity)
                        <li class="step-item">
                            <div class="h4 m-0">{{$activity->log_label}} - <span class="text-secondary">{{date('Y-M-d
                                    H:i:s', strtotime($activity->created_at))}}</span></div>
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
                                data-bs-toggle="tab" aria-selected="true" role="tab">Status Action</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!-- Content of card #1 -->
                        <div id="tab-top-1" class="card tab-pane active show" role="tabpanel">
                            <div class="card-body">
                            
                            @if($order->status_id != '1050')
                            <a href="{{ url('/console/order/approve/'.Request::segment(4)) }}" class="btn btn-warning w-100">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-triangle-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0v.001z" /><path d="M9 13h6" /><path d="M12 10v6" /></svg>
                                Generate And Move To Sales Order
                            </a>

                            <div class="hr-text">or</div>

                            <a href="{{ url('/console/order/reject/'.Request::segment(4)) }}" class="btn btn-outline-primary w-100">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-triangle-minus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0v.001z" /><path d="M9 13h6" /></svg>
                                Reject Order
                            </a>
                            @endif

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
                        @if(session('role_id') == 2 || session('role_id') == 3) 
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal-simple" class="btn btn-primary">Create
                            New Info</a>
                        @else

                        @endif
                    </div>
                </div>


            </div>

        </div>

    </div>

</div>

@include('component.modal.update-order-progress')

@include('component.modal.update-subscription')
@include('component.modal.activated-subscription')
@include('component.modal.deactive-subscription')
@include('component.modal.canceled-subscription')
@include('component.modal.terminated-subscription')

@if(session('role_id') == 3) 

@endif


<script type="text/javascript">

    $(document).ready(function () {
        $('#status_so').change('change', function () {
            this.form.submit();
        });

        $('.set_targettolive').change('change', function () {
            this.form.submit();
        });
    });


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