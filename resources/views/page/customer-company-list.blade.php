@extends('layouts.console')
@section('container')

<header class="navbar navbar-expand-md">
    <div class="container-xl">
        <div class="d-md-none">Tab Menus</div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu-01"
            aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse pb-2 pb-md-0" id="navbar-menu-01">
            <div class="row flex-fill align-items-center g-2">
                <div class="col-12 col-md-6">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/console/customer/active') }}"
                                title="Customer">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-user-square-rounded">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 13a3 3 0 1 0 0 -6a3 3 0 0 0 0 6z" />
                                        <path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z" />
                                        <path d="M6 20.05v-.05a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v.05" /></svg>
                                </span>
                                <span class="nav-link-title">Customer Personal</span>
                            </a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ url('/console/customer/corporate') }}"
                                title="Customer">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-user-square-rounded">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 13a3 3 0 1 0 0 -6a3 3 0 0 0 0 6z" />
                                        <path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z" />
                                        <path d="M6 20.05v-.05a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v.05" /></svg>
                                </span>
                                <span class="nav-link-title">Customer Corporate</span>
                            </a>
                        </li>
                        @if(session('company_id') == 1)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/console/customer/membership') }}"
                                title="Membership">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-crown">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 6l4 6l5 -4l-2 10h-14l-2 -10l5 4z" /></svg>
                                </span>
                                <span class="nav-link-title">Customer Membership</span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>

                <div class="col-12 col-md-2 text-end">
                    <a class="btn btn-outline-primary" data-bs-toggle="offcanvas" href="#offcanvasStart" role="button"
                        aria-controls="offcanvasStart" id="btn-filter">
                        <svg style="margin-right:10px" xmlns="http://www.w3.org/2000/svg"
                            class="icon icon-tabler icon-tabler-filter-search m-0" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M11.36 20.213l-2.36 .787v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414" />
                            <path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                            <path d="M20.2 20.2l1.8 1.8" /></svg>
                        <span>&nbsp;Filter</span>
                    </a>
                </div>

                <div class="col-12 col-md-1 text-end">
                    <a class="btn btn-outline-primary" href="#offcanvasStart" data-bs-toggle="modal" data-bs-target="#modal-addcontact">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M5 12l14 0"></path></svg>
                        <span>&nbsp;Create Contact</span>
                    </a>
                </div>

                <div class="col-12 col-md-3 text-end">
                    <a class="btn btn-primary" href="#offcanvasStart" data-bs-toggle="modal" data-bs-target="#modal-addcompany">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M5 12l14 0"></path></svg>
                        <span>&nbsp;Create Company</span>
                    </a>
                </div>

            </div>
        </div>
    </div>
</header>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-6 col-sm-4 col-lg-3 col-xl-2">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-primary text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-user-hexagon">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 13a3 3 0 1 0 0 -6a3 3 0 0 0 0 6z" />
                                        <path d="M6.201 18.744a4 4 0 0 1 3.799 -2.744h4a4 4 0 0 1 3.798 2.741" />
                                        <path
                                            d="M19.875 6.27c.7 .398 1.13 1.143 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z" />
                                        </svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="fw-bold text-uppercase">
                                    Total
                                </div>
                                <div class="text-secondary small">
                                    {{ $count_customer }} Users
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
                                <span class="bg-success text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-user-hexagon">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 13a3 3 0 1 0 0 -6a3 3 0 0 0 0 6z" />
                                        <path d="M6.201 18.744a4 4 0 0 1 3.799 -2.744h4a4 4 0 0 1 3.798 2.741" />
                                        <path
                                            d="M19.875 6.27c.7 .398 1.13 1.143 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z" />
                                        </svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="fw-bold text-uppercase">
                                    Active
                                </div>
                                <div class="text-secondary small">
                                    {{ $count_active }} Users
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
                                <span class="bg-danger text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-user-hexagon">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 13a3 3 0 1 0 0 -6a3 3 0 0 0 0 6z" />
                                        <path d="M6.201 18.744a4 4 0 0 1 3.799 -2.744h4a4 4 0 0 1 3.798 2.741" />
                                        <path
                                            d="M19.875 6.27c.7 .398 1.13 1.143 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z" />
                                        </svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="fw-bold text-uppercase">
                                    Inactive
                                </div>
                                <div class="text-secondary small">
                                    {{ $count_deactive }} Users
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br />

        <form method="POST" action="{{ url('/console/invoices/batch_publish') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h3 class="card-title">Data Records</h3>
                    </div>
                </div>

                @if(session()->has('success'))
                    <div class="alert alert-important alert-info alert-dismissible" style="border-radius:0px;"
                        role="alert">
                        <div class="d-flex">
                            <div>
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

                @if(session()->has('failed'))
                    <div class="alert alert-important alert-danger alert-dismissible" style="border-radius:0px;"
                        role="alert">
                        <div class="d-flex">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M5 12l5 5l10 -10"></path>
                                </svg>
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
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M12 9v4"></path>
                                    <path
                                        d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z">
                                    </path>
                                    <path d="M12 16h.01"></path>
                                </svg>
                            </div>
                            <div>
                                {{ session('fraud') }}
                            </div>
                        </div>
                        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer ID</th>
                                <th>Company Name</th>
                                <th>Customer Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th class="text-center">Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($data as $raw)
                                <tr>
                                    <td class="py-2">{{ $loop->iteration }}</td>
                                    <td class="py-2">
                                        {{ $raw->customer_number ? $raw->customer_number : '-' }}
                                    </td>
                                    <td class="py-2">{{ $raw->company_name }}</td>
                                    <td class="py-2">{{ $raw->customer_name }}</td>
                                    <td class="py-2">
                                        <a href="mailto:{{ $raw->customer_email }}" class="link-primary"
                                            title="Send mail to {{ $raw->customer_email }}">{{ $raw->customer_email }}</a>
                                    </td>
                                    <td class="py-2">{{ $raw->customer_telp }}</td>
                                    <td class="py-2 text-center">
                                        <label class="form-check form-check-single form-switch p-0 d-inline-block">
                                            @if($raw->is_active == '1')
                                                @if(session('role_id') != 7)
                                                    <input class="form-check-input btn-active" type="checkbox" checked
                                                        value="{{ $raw->id }}">
                                                @endif
                                                &nbsp;Active
                                            @else
                                                @if(session('role_id') != 7)
                                                    <input class="form-check-input btn-deactive" type="checkbox"
                                                        value="{{ $raw->id }}">
                                                @endif
                                                &nbsp;Active
                                            @endif
                                        </label>
                                    </td>
                                    <td class="py-2 text-end">
                                        <a class="btn btn-outline-primary"
                                            href="{{ url('/console/customer/detail/'.$raw->id) }}">Detail</a>
                                    </td>
                                </tr>
                            @empty

                                <tr>
                                    <td class="py-2" colspan="8">

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

                <div class="card-footer d-flex align-items-center">
                    <ul class="pagination m-0 ms-auto">
                        {{ $data->appends(request()->query())->links() }}
                    </ul>
                </div>
            </div>

        </form>

    </div>

</div>
<form method="POST" action="#" id="form-edit">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
</form>

@include('component.canvas.filter-customer-corporate')
@include('component.modal.add-company')
@include('component.modal.add-contact')

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
                'X-CSRF-TOKEN': $('#form-edit').find('input[name="_token"]').first().val()
            }
        });

        $('.btn-active').change(function () {
            var user_id = this.value;
            console.log(user_id);
            $.ajax({
                type: 'POST',
                url: "{{ route('set_deactive') }}",
                data: {
                    user_id: user_id
                },
                success: function (data) {
                    window.location.reload();
                }
            });
        });


        $('.btn-deactive').change(function () {
            var user_id = this.value;
            $.ajax({
                type: 'POST',
                url: "{{ route('set_active') }}",
                data: {
                    user_id: user_id
                },
                success: function (data) {
                    window.location.reload();
                }
            });
        });


    });

</script>




@endsection
