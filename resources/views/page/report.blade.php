@extends('layouts.console')
@section('container')


<div class="page-body">
    <div class="container-xl">
        <div class="row g-3 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">Administrator</div>
                <h2 class="page-title">Export Data</h2>
            </div>
        </div>

        <br />

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

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Subscription Data</h3>
            </div>

            <div class="card-body">
                <form method="POST" action="/console/report/subs" id="form-report">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="row g-2">
                        <div class="col-6 col-sm-3 col-lg-2 mb-2">
                            <label class="form-label">Date Start</label>
                            <input type="text" class="form-control" name="date_from" id="datepicker-icon" placeholder="YYYY-MM-DD">
                        </div>
                        <div class="col-6 col-sm-3 col-lg-2 mb-2">
                            <label class="form-label">Date End</label>
                            <input type="text" class="form-control" name="date_to" id="datepicker-icon2" placeholder="YYYY-MM-DD">
                        </div>
                        <div class="col-6 col-sm-3 col-lg-2 mb-2">
                            <div class="form-label">Type</div>
                            <select class="form-select" name="type">
                                <option value="">--- Select ---</option>
                                <option value="member">Membership</option>
                                <option value="non">Non Membership</option>
                            </select>
                        </div>
                        <div class="col-6 col-sm-3 col-lg-2 mb-2">
                            <div class="form-label">Status</div>
                            <select class="form-select" name="status">
                                <option value="">--- Select ---</option>
                                <option value="1001">Active</option>
                                <option value="1002">Deactive</option>
                                <option value="1005">Pending</option>
                                <option value="1008">Canceled</option>
                                <!-- <option value="4">Termination</option> -->
                            </select>
                        </div>
                        <div class="col-12 col-sm-4 mb-2">
                            <div class="form-label">Service Name</div>
                            <select class="form-select" name="product">
                                <option value="">--- Select ---</option>
                                @forelse($prod as $product)
                                    <option value="{{ $product->id }}">{{ $product->product_name }} - {{ $product->product_plan }} ( {{ $product->product_type }} )</option>
                                @empty
                                    <option value="">No Service Found</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="col-12 col-sm-5 col-lg-4 col-xl-3 mb-2">
                            <label class="form-label">Customer Name</label>
                            <input type="text" class="form-control edit_comp" name="name" placeholder="Enter Customer Name">
                        </div>
                        <div class="col-12 col-sm-auto mb-2 align-self-end ms-sm-auto">
                            <input type="submit" class="btn btn-primary" value="Export" title="Export">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <br />
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Customer Data</h3>
            </div>

            <div class="card-body">
                <form method="POST" action="/console/report/cust" id="form-report">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="row g-2">
                        <div class="col-6 col-sm-3 col-lg-2 mb-2">
                            <label class="form-label">Date Start</label>
                            <input type="text" class="form-control" name="date_from" id="datepicker-icon3" placeholder="YYYY-MM-DD">
                        </div>
                        <div class="col-6 col-sm-3 col-lg-2 mb-2">
                            <label class="form-label">Date End</label>
                            <input type="text" class="form-control" name="date_to" id="datepicker-icon4" placeholder="YYYY-MM-DD">
                        </div>
                        <div class="col-6 col-sm-3 col-lg-2 mb-2">
                            <div class="form-label">Type</div>
                            <select class="form-select" name="type">
                                <option value="">--- Select ---</option>
                                <option value="member">Membership</option>
                                <option value="non">Non Membership</option>
                            </select>
                        </div>
                        <div class="col-6 col-sm-3 col-lg-2 mb-2">
                            <div class="form-label">Status</div>
                            <select class="form-select" name="status">
                                <option value="">--- Select ---</option>
                                <option value="1">Active</option>
                                <option value="0">Deactive</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-5 col-lg-4 col-xl-3 mb-2">
                            <label class="form-label">Customer Name</label>
                            <input type="text" class="form-control edit_comp" name="name" placeholder="Enter Customer Name">
                        </div>

                        <div class="col-12 col-sm-auto mb-2 align-self-end ms-sm-auto">
                            <input type="submit" class="btn btn-primary" value="Export" title="Export">
                        </div>
                    </div>
                </form>


            </div>


        </div>

        <br />

        <!-- <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Invoices</h3>
            </div>

            <div class="card-body">
                <form method="POST" action="/console/report/inv" id="form-report">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="row">
                        <div class="col-2">
                            <label class="form-label">Invoice issued from</label>
                            <input type="text" class="form-control" name="date_from" id="datepicker-icon5">
                        </div>
                        <div class="col-2">
                            <label class="form-label">Invoice issued to</label>
                            <input type="text" class="form-control" name="date_to" id="datepicker-icon6">
                        </div>
                        <div class="col-2">
                            <label class="form-label">Invoice due date</label>
                            <input type="text" class="form-control" name="due_date" id="datepicker-icon7">
                        </div>
                        <div class="col-2">
                            <label class="form-label">Invoice next due</label>
                            <input type="text" class="form-control" name="next_due" id="datepicker-icon8">
                        </div>
                        <div class="col-2">
                            <label class="form-label">Billing Account</label>
                            <input type="text" class="form-control edit_comp" name="billing">
                        </div>
                        <div class="col-auto mt-3">
                            <div class="form-label">Product Plan</div>
                            <select class="form-select" name="product">
                                <option value="">Choose the Product</option>
@forelse($prod as $product)
                                    <option value="{{ $product->id }}">{{ $product->product_name }} -
                                        {{ $product->product_plan }} ( {{ $product->product_type }} )
@empty
                                    <option value="">No Product Found</option>
@endforelse
                            </select>
                        </div>
                        <div class="col-auto mt-3">
                            <div class="form-label">Invoice Type</div>
                            <select class="form-select" name="type">
                                <option value="">Choose the Invoice Type</option>
                                <option value="register">Register</option>
                                <option value="renew">Renew</option>
                            </select>
                        </div>

                        <div class="col-auto mt-3">
                            <div class="form-label">Customer Name</div>
                            <select class="form-select" name="customer">
                                <option value="">Choose the Customer</option>
@forelse($cust as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->customer_name }} -
                                        {{ $customer->customer_email }}
@empty
                                    <option value="">No Customer Found</option>
@endforelse
                            </select>
                        </div>
                        <div class="col-auto mt-3">
                            <div class="form-label">Invoice Visibility</div>
                            <select class="form-select" name="visibility">
                                <option value="">Choose the Invoice Visibility</option>
                                <option value="0">Draft</option>
                                <option value="1">Publish</option>
                            </select>
                        </div>
                        <div class="col-auto mt-3">
                            <div class="form-label">Invoice Status</div>
                            <select class="form-select" name="status">
                                <option value="">Choose the Invoice Status</option>
                                <option value="1036">Paid</option>
                                <option value="1037">Unpaid</option>
                            </select>
                        </div>
                        <div class="col">
                            <input type="submit" class="btn btn-primary" value="Export"
                                style="float:right;margin-top:27px;">
                        </div>
                    </div>
                </form>


            </div>


        </div>

        <br /> -->

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Invoice Data</h3>
            </div>

            <div class="card-body">
                <form method="POST" action="/console/report/invoice" id="form-report">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="row g-2">
                        <div class="col-6 col-sm-3 col-lg-2 mb-2">
                            <label class="form-label">Date Start</label>
                            <input type="text" class="form-control" name="date_from" id="datepicker-icon5" placeholder="YYYY-MM-DD">
                        </div>
                        <div class="col-6 col-sm-3 col-lg-2 mb-2">
                            <label class="form-label">Date End</label>
                            <input type="text" class="form-control" name="date_to" id="datepicker-icon6" placeholder="YYYY-MM-DD">
                        </div>
                        <div class="col-6 col-sm-3 col-lg-2 mb-2">
                            <label class="form-label">Due Date</label>
                            <input type="text" class="form-control" name="due_date" id="datepicker-icon7" placeholder="YYYY-MM-DD">
                        </div>
                        <div class="col-6 col-sm-3 col-lg-2 mb-2">
                            <label class="form-label">Next Due</label>
                            <input type="text" class="form-control" name="next_due" id="datepicker-icon8" placeholder="YYYY-MM-DD">
                        </div>
                        <div class="col-6 col-sm-3 col-lg-2 mb-2">
                            <div class="form-label">Type</div>
                            <select class="form-select" name="type">
                                <option value="">--- Select ---</option>
                                <option value="register">Register</option>
                                <option value="renew">Renew</option>
                            </select>
                        </div>
                        <div class="col-6 col-sm-3 col-lg-2 mb-2">
                            <div class="form-label">Status</div>
                            <select class="form-select" name="status">
                                <option value="">--- Select ---</option>
                                <option value="1036">Paid</option>
                                <option value="1037">Unpaid</option>
                            </select>
                        </div>

                        <div class="col-12 col-sm-4 col-xl-3 mb-2">
                            <div class="form-label">Customer Name</div>
                            <select class="form-select" name="customer">
                                <option value="">--- Select ---</option>
                                @forelse($cust as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->customer_name }} -
                                        {{ $customer->customer_email }}
                                    @empty
                                    <option value="">No Customer Found</option>
                                @endforelse
                            </select>
                        </div>

                        <div class="col-12 col-sm-auto mb-2 align-self-end ms-sm-auto">
                            <input type="submit" class="btn btn-primary" value="Export" title="Export">
                        </div>
                    </div>
                </form>


            </div>


        </div>

        <br />
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
        document.addEventListener("DOMContentLoaded", function () {
            window.Litepicker && (new Litepicker({
                element: document.getElementById('datepicker-icon'),
                buttonText: {
                    previousMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`,
                    nextMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`,
                },
            }));

            window.Litepicker && (new Litepicker({
                element: document.getElementById('datepicker-icon2'),
                buttonText: {
                    previousMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`,
                    nextMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`,
                },
            }));

            window.Litepicker && (new Litepicker({
                element: document.getElementById('datepicker-icon3'),
                buttonText: {
                    previousMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`,
                    nextMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`,
                },
            }));

            window.Litepicker && (new Litepicker({
                element: document.getElementById('datepicker-icon4'),
                buttonText: {
                    previousMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`,
                    nextMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`,
                },
            }));

            window.Litepicker && (new Litepicker({
                element: document.getElementById('datepicker-icon5'),
                buttonText: {
                    previousMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`,
                    nextMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`,
                },
            }));

            window.Litepicker && (new Litepicker({
                element: document.getElementById('datepicker-icon6'),
                buttonText: {
                    previousMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`,
                    nextMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`,
                },
            }));

            window.Litepicker && (new Litepicker({
                element: document.getElementById('datepicker-icon7'),
                buttonText: {
                    previousMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`,
                    nextMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`,
                },
            }));

            window.Litepicker && (new Litepicker({
                element: document.getElementById('datepicker-icon8'),
                buttonText: {
                    previousMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`,
                    nextMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`,
                },
            }));

        });

    </script>

    <script>
        $(document).ready(function () {

            $.ajaxSetup({
                headers: {

                    'X-CSRF-TOKEN': $('#form-report').find('input[name="_token"]').first().val()

                }
            });

        });

    </script>




    @endsection
