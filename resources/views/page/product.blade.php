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
                        <h2 class="page-title">Product</h2>
                    </div>
                </div>
            </div>
            <div class="col-auto">
                <div class="d-flex gap-2">
                    <a href="#" id="btn-create-so" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modal-addproduct">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" /></svg>
                        <span class="d-none d-sm-inline">&nbsp;Create New Product</span>
                    </a>
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
            <div class="alert alert-important alert-danger alert-dismissible" style="border-radius:0px;" role="alert">
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

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Records</h3>
            </div>

            <div class="table-responsive">
                <table class="table card-table table-vcenter datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th class="text-center">Product Plan</th>
                            <th>Product Scope</th>
                            <th>Product Type</th>
                            <th>Product Description</th>
                            <th>Is Hidden?</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse($data as $raw)
                            <tr>
                                <td class="py-2">{{ $loop->iteration }}</td>
                                <td class="py-2">
                                    {{ $raw->product_name }}
                                </td>
                                <td class="py-2 text-center">
                                    <span class="badge bg-orange-lt">
                                        {{ $raw->product_plan }}
                                    </span>
                                </td>
                                <td class="py-2">
                                    {{ $raw->product_scope }}
                                </td>
                                <td class="py-2">
                                    {{ $raw->product_type }}
                                </td>
                                <td class="py-2 small" style="max-width:300px;white-space: pre-wrap">{!!
                                    $raw->product_desc !!}</td>
                                <td class="py-2">
                                    @php
                                        $stat = $raw->is_hidden;

                                        if (in_array($stat, ['0']) === true) {
                                        $badgeColor = 'text-bg-success';
                                        $text = "No";
                                        } elseif (in_array($stat, ['1']) === true) {
                                        $badgeColor = 'text-bg-danger';
                                        $text = "Yes";
                                        } else {
                                        $badgeColor = '';
                                        $text = "-";
                                        }
                                    @endphp
                                    <span class="badge {{ $badgeColor }}">{{ $text }}</span>
                                </td>
                                <td class="py-2 text-end">
                                    <button class="btn btn-outline-primary btnedit" product_id="{{ $raw->id }}"
                                        title="Edit">Edit</button>
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
                                        <div class="empty-action">
                                            <a href="#" class="btn btn-primary" data-bs-target="#modal-addproduct"
                                                data-bs-toggle="modal">
                                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M12 5l0 14"></path>
                                                    <path d="M5 12l14 0"></path>
                                                </svg>
                                                Add your first Product
                                            </a>
                                        </div>
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


@include('component.modal.add-product')
@include('component.modal.edit-product')


<script>
    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('#form-product').find('input[name="_token"]').first().val()
            }
        });


        $('.payment_type').change(function () {
            if (this.value == "recurring") {
                $('.recurring').show();
                $('.onetime').hide();
            } else {
                $('.onetime').show();
                $('.recurring').hide();
            }
        });

        $('.btnedit').click(function () {

            var product_id = $(this).attr('product_id');

            $.ajax({

                type: 'POST',
                url: "{{ route('product_detail') }}",
                data: {
                    product_id: product_id
                },
                success: function (data) {
                    $('#modal-editproduct').modal('show');
                    $('.product_id').val(data.prod.id);
                    $('.product_name').val(data.prod.product_name);
                    $('.product_plan').val(data.prod.product_plan);
                    $('.product_desc').val(data.prod.product_desc);
                    $('.product_scope').val(data.prod.product_scope);
                    $('.product_group').val(data.prod.product_group);
                    $('.product_type').val(data.prod.product_type);
                    $('.show_cover').attr('src', '{{ env('BACKEND_URL') }}/image/get/ums/' + data.prod.cover);
                    if (data.prod.allow_promo == 1) {
                        $('#edit_allow_promo').prop('checked', true);
                    } else {
                        $('#edit_allow_promo').prop('checked', false);
                    }
                    $('.is_hidden').val(data.prod.is_hidden);

                    // Set checkbox deposit_payment berdasarkan deposit_payment
                    if (data.prod.deposit_payment == 1) {
                        $('#edit_deposit_payment').prop('checked', true);
                    } else {
                        $('#edit_deposit_payment').prop('checked', false);
                    }

                    if (data.price[0].payment_type == 'onetime') {
                        $('.onetime').attr('checked', true);
                    } else {
                        $('.recurring').attr('checked', true);
                    }

                    $('#title').empty();
                    $('#setupfee').empty();
                    $('#price').empty();
                    $('#enabled').empty();
                    $.each(data.price, function (key, value) {
                        if (key == 0) {
                            $('#title').append(
                                '<th class="text-start">#</th>'
                            );
                            $('#setupfee').append(
                                '<td class="py-2 text-start">Setup Fee</td>'
                            );
                            $('#price').append(
                                '<td class="py-2 text-start">Price</td>'
                            );
                            $('#enabled').append(
                                '<td class="py-2 text-start">Enable</td>'
                            );
                        }

                        let enabled = value['enabled'];
                        enabled = enabled == 1 ? 'checked' : '';

                        $('#title').append(
                            '<th class="text-end">' + value['billing_cycle'] +
                            '<input type="hidden" name="billing_cycle[]" value="' +
                            value['billing_cycle'] +
                            '" /></th>'
                        );
                        $('#setupfee').append(
                            '<td class="py-2"><input type="number" class="form-control text-end" name="setup_fee[]" value="' +
                            value['setup_fee'] +
                            '" /></td>'
                        );
                        $('#price').append(
                            '<td class="py-2"><input type="number" class="form-control text-end" name="price[]" value="' +
                            value['price'] +
                            '" /></td>'
                        );
                        $('#enabled').append(
                            '<td class="py-2"><label class="form-check"><input class="form-check-input" type="checkbox" name="enabled[]" value="' +
                            value['billing_cycle'] +
                            '"  ' +
                            enabled +
                            '></label></td>'
                        );
                    });

                    // Load product fields using the function from edit-product modal
                    if (typeof window.loadProductFields === 'function') {
                        window.loadProductFields(data);
                    }

                }
            });
        });



    });

</script>

<script type="text/javascript">
    $(document).on("change", ".field_type", function () {
        $tr = $(this).parent().parent();
        if (this.value == "selectbox") {
            console.log('field_type selectbox dipilih');
            $tr[0].querySelector('.select_options').style.display = 'block';
        } else {
            console.log('field_type bukan selectbox dipilih');
            $tr[0].querySelector('.select_options').style.display = 'none';
        }
    });

    $(document).on("click", ".add_row", function () {
        $tr = $(this).closest("tr").prev().clone();
        $tr[0].querySelector('.remove_row').setAttribute('style', 'cursor:pointer;display:block');
        // $tr[0].querySelector('.product').length = 0;
        $tr.insertBefore($(this).closest("tr"));
    });

    $(document).on("click", ".remove_row", function () {
        $(this).parent().parent().remove();
    });

</script>

@endsection
