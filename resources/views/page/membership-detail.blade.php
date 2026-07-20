@extends('layouts.console')
@section('container')

@include('component.canvas.navbar-customer')

<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-6 col-sm-4 col-lg-3 col-xl-2">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-primary text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-hexagon"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M12 13a3 3 0 1 0 0 -6a3 3 0 0 0 0 6z" /><path d="M6.201 18.744a4 4 0 0 1 3.799 -2.744h4a4 4 0 0 1 3.798 2.741" /><path d="M19.875 6.27c.7 .398 1.13 1.143 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="fw-bold text-uppercase">
                                    Subscription
                                </div>
                                <div class="text-secondary small">
                                    {{ $count_subs }} Record
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
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-license" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M15 21h-9a3 3 0 0 1 -3 -3v-1h10v2a2 2 0 0 0 4 0v-14a2 2 0 1 1 2 2h-2m2 -4h-11a3 3 0 0 0 -3 3v11" /><path d="M9 7l4 0" /><path d="M9 11l4 0" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="fw-bold text-uppercase">
                                    Invoice
                                </div>
                                <div class="text-secondary small">
                                    {{ $count_inv }} Record
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
                                <span class="bg-teal text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-license" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M15 21h-9a3 3 0 0 1 -3 -3v-1h10v2a2 2 0 0 0 4 0v-14a2 2 0 1 1 2 2h-2m2 -4h-11a3 3 0 0 0 -3 3v11" /><path d="M9 7l4 0" /><path d="M9 11l4 0" /></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="fw-bold text-uppercase">
                                    Transaction
                                </div>
                                <div class="text-secondary small">
                                    {{ $count_trx }} Record
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <br />

        <div class="row">
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

                @if($count_company != 0)
                <div class="card">
                    <div class="card-header header-field">
                        <h3 class="card-title">Company Information</h3>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-sm-4">
                            <div class="col-12 col-sm-auto">
                                <table class="tables">
                                    <tbody>
                                        <tr >
                                            <td style="width:45%">Company Name</td>
                                            <td style="width:6%">:</td>
                                            <td>
                                                {{ $company->company_name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Company Email</td>
                                            <td>:</td>
                                            <td>
                                                {{ $company->company_email }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Company Telp</td>
                                            <td>:</td>
                                            <td>
                                                {{ $company->company_telp }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Company Address</td>
                                            <td>:</td>
                                            <td>
                                                {{ $company->company_address }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-auto text-right">

                                @if(isset($data->referral_code))
                                    <div class="mb-1 ref_code">Referral Code</div>
                                    <div class="mb-3 h2">{{ $data->referral_code }} <button type="button"
                                            class="btn btn-md mb-1"
                                            onclick="copyToClipboard(`{{ env('REGISTER_URL') }}{{ $data->referral_code }}`)">

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
                                        </button>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">

                        @if(session('role_id') != 7)
                            <div customer_id="{{ $data->id }}" company_id="{{ $company->company_id }}" class="btnedit-company btn btn-primary w-30">
                                <span class="">Edit</span>
                            </div>
                        @endif
                        <form method="POST" action="#" id="form-edit">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        </form>
                    </div>
                </div>
                <br/>
                @endif


                <div class="card">
                    <div class="card-header header-field">
                        <h3 class="card-title">Customer Profile</h3>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-sm-4">
                            <div class="col-auto">
                                @if($data->customer_photo != '')
                                    <span class="avatar avatar-xl rounded" style="background-image: url('{{ env('BACKEND_URL') }}/image/get/ums/{{ $data->customer_photo }}')"></span>
                                @else
                                    <span class="avatar avatar-xl mb-3 rounded" style="">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-circle"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" /></svg>
                                    </span>
                                @endif
                            </div>
                            <div class="col-12 col-sm-auto">
                                <table class="tables">
                                    <tbody>
                                        <tr>
                                            <td>Customer ID</td>
                                            <td>
                                                <span class="px-2">:</span>
                                                {{ $data->customer_number ?? '-' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Name</td>
                                            <td>
                                                <span class="px-2">:</span>
                                                {{ $data->customer_name ?? '-' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Joined At</td>
                                            <td>
                                                <span class="px-2">:</span>
                                                {{ $data->created_at }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Email Address</td>
                                            <td>
                                                <span class="px-2">:</span>
                                                <a class="link-primary" href="mailto:{{$data->customer_email}}" title="Send mail to {{$data->customer_email}}">{{ $data->customer_email }}</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Phone Number</td>
                                            <td>
                                                <span class="px-2">:</span>
                                                {{ $data->customer_telp ?? '-' }}
                                            </td>
                                        </tr>

                                        @if($count_company != 0)
                                        <tr>
                                            <td>Account Type</td>
                                            <td>
                                                <span class="px-2">:</span>
                                                <span class="badge {{($data->status === 'Active') ? 'text-bg-info' : 'text-bg-info'}}">{{ $company->contact_type }}</span>
                                            </td>
                                        </tr>
                                        @endif

                                        <tr>
                                            <td>Account Status</td>
                                            <td>
                                                <span class="px-2">:</span>
                                                <span class="badge {{($data->status === 'Active') ? 'text-bg-success' : 'text-bg-danger'}}">{{ $data->status }}</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-auto text-right">
                                @if(isset($data->referral_code))
                                    <div class="mb-1 ref_code">Referral Code</div>
                                    <div class="mb-3 h2">{{ $data->referral_code }} <button type="button"
                                            class="btn btn-md mb-1"
                                            onclick="copyToClipboard(`{{ env('REGISTER_URL') }}{{ $data->referral_code }}`)">

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
                                        </button>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">

                        @if(session('role_id') != 7)
                        <div customer_id="{{ $customer_id }}" class="btnedit btn btn-primary w-30">
                            <span class="">Edit</span>
                        </div>
                        @endif
                        <form method="POST" action="#" id="form-edit">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        </form>
                    </div>
                </div>

                @if(isset($data->referral_code))
                    <div class="card">
                        <div class="card-body">
                            <h3>Membership Subscription</h3>

                            <div class="card">
                                <div class="table-responsive">
                                    <table class="table table-vcenter table-mobile-md card-table">
                                        <thead>
                                            <tr>
                                                <th>Membership Type</th>
                                                <th>Subscription Date</th>
                                                <th>Activation Date</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>
                                                <td data-label="Name">
                                                    <div class="d-flex py-1 align-items-center">
                                                        <div class="flex-fill">
                                                            <div class="font-weight-medium">
                                                                {{ $data->product_name }} Membership <br /> Plan
                                                                {{ $data->product_plan }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td data-label="Title">
                                                    <div class="text-secondary">{{ $data->subscription_date }}</div>
                                                </td>
                                                <td data-label="Title">
                                                    <div class="text-secondary">
                                                        {{ $data->complete_date ? $data->complete_date : '-' }}
                                                    </div>
                                                </td>
                                                <td class="text-secondary" data-label="Promo">
                                                    <label class="form-check form-check-single form-switch">
                                                        @if(session('role_id') != 7)
                                                        <input class="form-check-input btn-status" type="checkbox" {{ ($data->is_active_subs == '1') ? 'checked' : '' }} value="{{ $data->id }}">&nbsp;
                                                        @endif
                                                    </label>

                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <br />

                <div class="card">
                    <div class="card-body">
                        <h3>Customer Subscription</h3>

                        <div class="card">
                            <div class="table-responsive">
                                <table class="table table-vcenter table-mobile-md card-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Service Name</th>
                                            <th class="text-center">Order Date</th>
                                            <th class="text-center">Activation Date</th>
                                            <th class="text-end">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($dataSubs as $subs)
                                            <tr>
                                                <td class="py-2" data-label="No.">{{$loop->iteration}}</td>
                                                <td class="py-2" data-label="Service Name">
                                                    {{ $subs->product_name ?? '-' }}
                                                    <div class="text-secondary small">{{ $subs->product_plan }} ({{ $subs->product_type }})</div>
                                                </td>
                                                <td class="py-2" data-label="Order Date">
                                                    <div class="text-md-center">{{ ($subs->subscription_date) ? date('Y-M-d', strtotime($subs->subscription_date)) : '-' }}</div>
                                                </td>
                                                <td class="py-2" data-label="Activation Date">
                                                    <div class="text-md-center">
                                                        {{ ($subs->complete_date) ? date('Y-M-d', strtotime($subs->complete_date)) : '-' }}
                                                    </div>
                                                </td>
                                                <td class="py-2 text-md-end" data-label="Status">
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
                                                    <span class="badge {{$badgeColor}} text-capitalize">{{$subs->status_name ?? '-'}}</span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="py-2">
                                                    <p>No Data Subscription</p>
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

                <div class="card">
                    <div class="card-body">
                        <h3>Latest Invoice</h3>

                            <div class="card">
                                <div class="table-responsive">
                                    <table class="table table-vcenter table-mobile-md card-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Invoice ID</th>
                                                <th class="text-center">Invoice Date</th>
                                                <th class="text-center">Amount (IDR)</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        @forelse($dataInv as $inv)

                                            <tr>
                                                <td class="py-2" data-label="No.">{{$loop->iteration}}</td>
                                                <td class="py-2" data-label="Invoice ID">
                                                    @if($inv->is_publish == 0)
                                                        {{ $inv->id }}
                                                        <small class="badge text-secondary fw-normal p-1 border"><small>Drafted</small></small>
                                                    @else
                                                        @if($inv->invoice_number == '')
                                                            {{ $inv->id }}
                                                        @else
                                                            {{ $inv->invoice_number }}
                                                        @endif
                                                        <small class="badge text-success fw-normal p-1 border border-success"><small>Published</small></small>
                                                    @endif
                                                </td>
                                                <td class="py-2 text-md-center" data-label="Invoice Date">{{ $inv->invoice_date }}</td>
                                                <td class="py-2 text-md-center" data-label="Amount">{{ number_format($inv->total, 0, ',', '.') }}</td>
                                                <td class="py-2 text-md-center" data-label="Status">
                                                    @php
                                                        $stat = $inv;

                                                        if (in_array($stat->status_name, ['Activated', 'Completed', 'Paid']) === true) {
                                                            $badgeColor = 'text-bg-success';
                                                        } elseif (in_array($stat->status_name, ['Deactivated', 'Unpaid']) === true) {
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
                                                    <span class="badge {{$badgeColor}}">{{$inv->status_name ?? '-'}}</span>
                                                </td>
                                                <td class="py-2 text-md-end" data-label="Action">
                                                    <a class="btn btn-outline-primary" href="{{ url('/console/invoices/detail/'.$inv->id) }}" title="Detail">Detail</a>
                                                </td>
                                            </tr>

                                        @empty
                                            <tr>
                                                <td class="py-2" colspan="6">No Data Invoice</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                    </div>
                </div>

                <br />

                @if(isset($data->referral_code))
                    <div class="card">
                        <div class="card-body">
                            <h3>Latest Request Redem</h3>

                            @forelse($dataRedem as $rdm)

                                <div class="card">
                                    <div class="table-responsive">
                                        <table class="table table-vcenter table-mobile-md card-table">
                                            <thead>
                                                <tr>
                                                    <th>Reward Request</th>
                                                    <th>Point Requirement</th>
                                                    <th>Request Date</th>
                                                    <th>Request Status</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <td data-label="Name">
                                                        <div class="d-flex py-1 align-items-center">
                                                            <span class="avatar me-2"
                                                                style="background-image: url('{{ env('BACKEND_URL') }}/image/get/ums/'.$rdm->reward_cover)"></span>
                                                            <div class="flex-fill">
                                                                <div class="font-weight-medium">
                                                                    {{ $rdm->reward_name }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td data-label="Title">
                                                        <div class="text-secondary">{{ $rdm->reward_point }} Point
                                                        </div>
                                                    </td>
                                                    <td data-label="Title">
                                                        <div class="text-secondary">{{ $rdm->created_at }}</div>
                                                    </td>
                                                    <td data-label="Title">
                                                        <span
                                                            class="badge bg-orange text-orange-fg">{{ $rdm->status_name }}</span>
                                                    </td>
                                                    <td class="text-secondary" data-label="Promo">
                                                        <a class="btn btn-primary"
                                                            href="{{ url('/console/redem/detail/'.$rdm->id) }}">Detail</a>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <br />

                            @empty
                                <p>No Data Request</p>
                            @endforelse

                        </div>
                    </div>
                @endif



                <br />
            </div>
            <div class="col-md-6 col-lg-4">
                <!-- Customer Balance Card -->
                <div class="card" style="background: linear-gradient(135deg, #4FC3F7 0%, #29B6F6 100%); color: white; margin-bottom: 1rem;">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-primary text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-wallet"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12"/><path d="M20 12v4h-4a2 2 0 0 1 0 -4h4"/></svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="fw-bold text-uppercase mb-1" style="font-size: 0.875rem;">
                                    Customer Balance
                                </div>
                                <div class="h2 mb-2 d-flex justify-content-between align-items-center">
                                    <div>
                                        IDR. {{ number_format($customer_balance, 0, ',', '.') }}                         
                                    </div>
                                    <a href="{{ url('/console/customer/balance-history/'.Request::segment(4)) }}" class="btn btn-sm btn-light text-primary fw-bold">
                                        Balance History
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if(isset($data->referral_code))
                    <div class="card">
                        <div class="card-header header-field">
                            <h3 class="card-title">Point Customer</h3>
                        </div>
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-1">Member Point :</div>
                                    <div class="mb-3 h2">{{ $data->points }} <span class="h4">Point</span></div>
                                </div>
                                <div class="col-auto text-right">
                                    <a class="btn btn-primary"
                                        href="{{ url('/console/customer/point/'. $customer_id) }}">History
                                        Transaction</a>

                                </div>
                            </div>

                        </div>
                    </div>

                    <br />

                    <div class="card">
                        <div class="card-header header-field">
                            <h3 class="card-title">Downline Customer</h3>
                        </div>
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-1">Total Member :</div>
                                </div>
                                <div class="col-auto">
                                    @if(isset($dataDownline->status) && $dataDownline->status != "Failed")
                                        <div class="mb-1 h2">{{ number_format($dataDownline->data->count, 0) }}
                                        </div>
                                    @else
                                        <div class="mb-1 h2">0</div>
                                    @endif
                                    <div class="">Member</div>

                                </div>
                            </div>




                        </div>

                        <div class="card-body p-1">
                            @if(isset($dataDownline->status) && $dataDownline->status != "Failed")

                                <table class="table table-vcenter table-mobile-md card-table">
                                    <tbody>

                                        @forelse($dataDownline->data->rows as $dwn)

                                            <tr>
                                                <td data-label="Name">

                                                    <div class="d-flex py-1 align-items-center">
                                                        <?php if($dwn->customer_photo != ''){ ?>
                                                        <span class="avatar me-2"
                                                            style="background-image: url('{{ env('BACKEND_URL') }}/image/get/ums/{{ $dwn->customer_photo }}')"></span>
                                                        <?php }else{ ?>
                                                        <span class="avatar me-2" style="">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="icon icon-tabler icons-tabler-outline icon-tabler-user-circle">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                                                <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                                                <path
                                                                    d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                                                            </svg> </span>
                                                        <?php } ?>

                                                        <div class="flex-fill">
                                                            <div class="font-weight-medium fs-5">
                                                                <a class=""
                                                                    href="{{ url('/console/customer/detail/'.$dwn->customer_id) }}">
                                                                    {{ $dwn->customer_name }}
                                                                </a>
                                                                <br />
                                                                <span
                                                                    class="badge bg-info text-white">{{ $dwn->product_name }}</span>
                                                                Membership
                                                                {{ $dwn->product_plan }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-secondary fs-5" data-label="Promo">
                                                    <span
                                                        class="badge bg-orange text-orange-fg fs-3">{{ $dwn->total_downline }}
                                                    </span> Member
                                                </td>
                                            </tr>
                                        @empty
                                            <!-- <p class="p-4">No Data Member</p> -->
                                        @endforelse

                                    </tbody>
                                </table>
                                <div class="text-center p-4">
                                    <a class="btn btn-primary"
                                        href="{{ url('/console/customer/downline/'. $customer_id) }}">Selengkapnya</a>

                                </div>
                            @endif

                        </div>

                    </div>

                    <br />
                @endif
            </div>

        </div>



    </div>

</div>

@include('component.modal.edit-customer')
@include('component.modal.edit-company')

<style>
    .navbar-overlap:after {
        height: 0px !important;
    }

    .btnactive {
        background-color: #206bc4;
        color: #fff;
    }

</style>

<script>
    $(document).ready(function () {

        $(".btn_filter").on("click", function () {
            this.form.submit();
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('#form-pipeline').find('input[name="_token"]').first().val()
            }
        });

        $('.btn-status').change(function () {
            var member_id = this.value;
            var is_active =
                '<?php echo isset($data->is_active_subs) ? $data->is_active_subs == 1 ? 0 : 1 : 0 ?>'
            $.ajax({
                type: 'POST',
                url: "{{ route('set_status') }}",
                data: {
                    member_id: member_id,
                    is_active: is_active
                },
                success: function (data) {
                    window.location.reload();
                }
            });
        });

        $('.btnedit').click(function () {

            var customer_id = $(this).attr('customer_id');

            $.ajax({

                type: 'POST',
                url: "{{ route('customer_detail') }}",
                data: {
                    customer_id: customer_id
                },
                success: function (data) {
                    console.log(data);

                    $('#modal-edituser').modal('show');
                    $('.edit_customer_id').val(customer_id);
                    $('.edit_customer_name').val(data.customer_name);
                    $('.edit_comp').val(data.customer_company);
                    $('.edit_email').val(data.customer_email);
                    $('.edit_phone').val(data.customer_telp);
                    $('.edit_customer_address').val(data.customer_address);
                    $('.edit_status').val(data.is_active);
                    $('.edit_verified').val(data.is_verified);
                    $('.contact_type').val(data.contact_type);
                    // $(".edit_user_role").val(data.role_id).change();


                }

            });

        });


        $('.btnedit-company').click(function () {

            var company_id = $(this).attr('company_id');
            var customer_id = $(this).attr('customer_id');

            $.ajax({

                type: 'POST',
                url: "{{ route('company_detail') }}",
                data: {
                    company_id: company_id
                },
                success: function (data) {

                    $('#modal-editcompany').modal('show');
                    $('.company_id').val(data.id);
                    $('.customer_id').val(customer_id);
                    $('.company_name').val(data.company_name);
                    $('.company_email').val(data.company_email);
                    $('.company_telp').val(data.company_telp);
                    $('.company_address').html(data.company_address);

                }

            });

        });


    });

    function copyToClipboard(textToCopy) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(textToCopy).select();
        const successful = document.execCommand("copy");
        if (successful) {
            alert("Copied the text: " + textToCopy);
        } else {
            // ...
        }
        $temp.remove();
    }

</script>




@endsection
