@extends('layouts.console')
@section('container')



<!-- Page header -->
<div class="page-header d-print-none text-white">
    <div class="container-xl">
        <div class="row g-3 align-items-center justify-content-between">
            <div class="col-auto">
                <div class="d-flex gap-2 align-items-center justify-content-between justify-content-sm-start">
                    <div>
                        <div class="page-pretitle">Administrator</div>
                        <h2 class="page-title">Promo Management</h2>
                    </div>
                </div>
            </div>
            <div class="col-auto">
                <div class="d-flex gap-2">
                    @if(session('role_id') != 2)
                    <a href="#" id="btn-create-so" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-addpromo">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" /></svg>
                        <span class="d-none d-sm-inline">&nbsp;Create Promo</span>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        @if(session()->has('success'))
        <div class="alert alert-important alert-info alert-dismissible" style="border-radius:0px;" role="alert">
            <div class="d-flex">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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
        <div class="alert alert-important alert-danger alert-dismissible" style="border-radius:0px;" role="alert">
            <div class="d-flex">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 9v4"></path>
                        <path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z"></path>
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

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Records</h3>
            </div>

            <div class="table-responsive">
                <table class="table card-table table-vcenter datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Promotion Code</th>
                            <th>Promotion Label</th>
                            <th class="text-center">Promotion Description</th>
                            <th class="text-center">Free Setup</th>
                            <th class="text-center">Is Active</th>
                            <th class="text-center">Edit</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse($data as $raw)
                        <tr>
                            <td class="py-2">{{$loop->iteration}}</td>
                            <td class="py-2">
                                {{ $raw->promotion_code }}
                            </td>
                            <td class="py-2 small" style="max-width:300px;white-space: pre-wrap">{{$raw->promotion_label}}</td>
                            <td class="py-2 small" style="max-width:300px;white-space: pre-wrap">{{$raw->promotion_desc}}</td>
                            <td class="py-2 text-center">
                                <span class="badge">
                                    <label class="form-check form-check-single form-switch">
                                        <input class="form-check-input" name="free_setup" type="checkbox" @if($raw->setup_free == 1) checked="" @endif>
                                    </label>
                                </span>
                            </td>
                            <td class="py-2 text-center">
                                <label class="form-check form-check-single form-switch d-inline-block p-0">
                                    @if($raw->is_active == '1')
                                    <badge class="badge bg-green" style="color:#fff">Active</badge>
                                    @else
                                    <badge class="badge bg-red" style="color:#fff">Deactive</badge>
                                    @endif
                                </label>
                            </td>
                            <td class="py-2 text-end">
                                <button class="btn btn-outline-primary btnedit" promo_id="{{ $raw->id }}" title="Edit">Edit</button>
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
    </div>

</div>

@include('component.modal.add-promo')
@include('component.modal.edit-promo')

<script>

    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('#form-project').find('input[name="_token"]').first().val()
            }
        });

        $('.btnedit').click(function() {

            var promo_id = $(this).attr('promo_id');

            $.ajax({

                type: 'GET'
                , url: "{{ route('promo_detail') }}"
                , data: {
                    id: promo_id
                }
                , success: function(data) {
                    $('#modal-editpromo').modal('show');
                    $('.promo_id').val(data.id);
                    $('.promo_code').val(data.promotion_code);
                    $('.promo_label').val(data.promotion_label);
                    $(".promo_type").val(data.type).change();
                    $(".promo_description").val(data.promotion_desc);
                    $(".subscription_month").val(data.subscription_month).change();
                    $(".period_free").val(data.period_free).change();
                    $(".value").val(data.value);
                    $(".start_date").val(data.start_date);
                    $(".end_date").val(data.end_date);
                    $(".max_user").val(data.max_user);
                    if(data.setup_free == 1) {
                        $(".free_setup").prop('checked', true);
                    } else {
                        $(".free_setup").prop('checked', false);
                    }

                    if(data.type == null) {
                        $('.box-type').hide('fast');
                    } else {
                        $('.box-type').show('fast');
                    }
 
                }
            });

        });


        $('.btn-active').change(function() {
            var area_id = this.value;
            $.ajax({
                type: 'POST'
                , url: "{{ route('set_deactive_project') }}"
                , data: {
                    area_id: area_id
                }
                , success: function(data) {
                    window.location.reload();
                }
            });
        });


        $('.btn-deactive').change(function() {
            var area_id = this.value;
            $.ajax({
                type: 'POST'
                , url: "{{ route('set_active_project') }}"
                , data: {
                    area_id: area_id
                }
                , success: function(data) {
                    window.location.reload();
                }
            });
        });

    });

</script>


<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
        window.Litepicker && (new Litepicker({
            element: document.getElementById('datepicker-icon')
            , buttonText: {
                previousMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`
                , nextMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`
            , }
        , }));

        window.Litepicker && (new Litepicker({
            element: document.getElementById('datepicker-icon2')
            , buttonText: {
                previousMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`
                , nextMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`
            , }
        , }));

        window.Litepicker && (new Litepicker({
            element: document.getElementById('datepicker-icon3')
            , buttonText: {
                previousMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`
                , nextMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`
            , }
        , }));

        window.Litepicker && (new Litepicker({
            element: document.getElementById('datepicker-icon4')
            , buttonText: {
                previousMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`
                , nextMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`
            , }
        , }));

    });

</script>


@endsection
