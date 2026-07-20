<div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <form method="POST" action="/console/salesorder/create" id="form-salesorder">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="sales_id" value="1" />
                <input type="hidden" name="pipeline_id" class="pipeline_id" />
                <input type="hidden" name="customer_type" value="personal" />


                <div class="modal-header">
                    <h5 class="modal-title">New Sales Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">



                    <div class="mb-3">
                        <label class="form-label">Customer Name</label>
                        <input type="text" class="form-control customer_name" name="customer_name"
                            placeholder="Input Customer Name" required>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Customer Phone</label>
                                <input type="text" class="form-control customer_phone" name="customer_phone" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Customer Email</label>
                                <input type="email" class="form-control customer_email" name="customer_email" required>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Reference</label>
                        <select class="form-select" name="reference_id">
                            <option value="">-- Select --</option>

                            @forelse($site_employee as $em)
                                <option value="{{ $em->id }}">{{ $em->name }}
                                @empty
                                <option value="">No Employee Found</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="mb-3 general">

                        <label class="form-label abcc">Choose Product</label>

                        <div class="mb-3">
                            <select type="text" class="form-select" id="select-product" name="product_group" required>
                                <option value=""
                                    data-custom-properties="&lt;span class=&quot;avatar avatar-xs&quot; style=&quot;background-color: #efefef;)&quot;&gt;&lt;/span&gt;">

                                </option>
                                @forelse($product_group as $group)
                                    <option value="{{ $group->id }}"
                                        data-custom-properties="&lt;span class=&quot;avatar avatar-xs&quot; style=&quot;background-color: #efefef;)&quot;&gt;&lt;/span&gt;">
                                        {{ $group->product_group_name }} - {{ $group->product_group_headline }}
                                    </option>
                                @empty
                                    <option value=""
                                        data-custom-properties="&lt;span class=&quot;avatar avatar-xs&quot; style=&quot;background-color: #efefef;)&quot;&gt;&lt;/span&gt;">
                                        No Product Available</option>
                                @endforelse
                            </select>
                        </div>

                    </div>

                    <label class="form-label general">Choose Product Plan</label>
                    <div class="form-selectgroup-boxes row mb-3 choose-plan general">
                        <div class="col-lg-6">
                            <label class="form-selectgroup-item">
                                <input type="radio" name="report-type" value="1" class="form-selectgroup-input" checked>
                                <span class="form-selectgroup-label d-flex align-items-center p-3">
                                    <span class="me-3">
                                        <span class="form-selectgroup-check"></span>
                                    </span>
                                    <span class="form-selectgroup-label-content">
                                        <span class="form-selectgroup-title strong mb-1">Simple</span>
                                        <span class="d-block text-secondary">Provide only basic data needed for the
                                            report</span>
                                    </span>
                                </span>
                            </label>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-selectgroup-item">
                                <input type="radio" name="report-type" value="1" class="form-selectgroup-input">
                                <span class="form-selectgroup-label d-flex align-items-center p-3">
                                    <span class="me-3">
                                        <span class="form-selectgroup-check"></span>
                                    </span>
                                    <span class="form-selectgroup-label-content">
                                        <span class="form-selectgroup-title strong mb-1">Advanced</span>
                                        <span class="d-block text-secondary">Insert charts and additional advanced
                                            analyses
                                            to be inserted
                                            in the report</span>
                                    </span>
                                </span>
                            </label>
                        </div>
                    </div>


                    <div class="mb-3 general">

                        <label class="form-label">Product Price</label>
                        <input type="text" class="form-control" name="product_price" id="product_price"
                            placeholder="Input Product Price" required>

                    </div>


                    <div class="card general">
                        <div class="card-header header-field">
                            <h3 class="card-title">Input Product Field</h3>
                        </div>
                        <div class="card-body input-product-field">

                        </div>
                    </div>


                    <div class="mb-3 submission">
                        <!-- <label class="form-label">Product :</label> -->
                        <input type="hidden" name="product_plan" class="input-submission">
                        <input type="hidden" name="product_price" class="input-submission">
                        <div class="card">
                            <div class="card-header header-field">
                                <h3 class="card-title">Product</h3>
                            </div>
                            <div class="card-body">
                                <div class="prod fw-bold fs-3"></div>
                            </div>
                        </div>

                    </div>

                    <div class="card submission" style="display: none">
                        <div class="card-header header-field">
                            <h3 class="card-title">Input Product Field</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3"><label class="form-label">Nama Jalan</label>
                                <input required="" type="text" name="nama-jalan" class="input-submission form-control"
                                    placeholder="Input Nama Jalan"></div>
                            <div class="mb-3"><label class="form-label">RT</label>
                                <input required="" type="text" name="rt" class="input-submission form-control"
                                    placeholder="input RT"></div>
                            <div class="mb-3"><label class="form-label">RW</label>
                                <input required="" type="text" name="rw" class="input-submission form-control"
                                    placeholder="input RW" autocomplete="off"></div>
                            <div class="mb-3"><label class="form-label">Kelurahan</label>
                                <input required="" type="text" name="kelurahan" class="input-submission form-control"
                                    placeholder="input Kelurahan"></div>
                            <div class="mb-3"><label class="form-label">Kecamatan</label>
                                <input required="" type="text" name="kecamatan" class="input-submission form-control"
                                    placeholder="input Kecamatan"></div>
                            <div class="mb-3"><label class="form-label">Kabupaten</label>
                                <input required="" type="text" name="kabupaten" class="input-submission form-control"
                                    placeholder="input Kabupaten"></div>
                            <div class="mb-3"><label class="form-label">Link Maps</label>
                                <input required="" type="text" name="link-maps" class="input-submission form-control"
                                    placeholder="input Link Maps"></div>
                            <div class="mb-3"><label class="form-label">Jenis Bangunan</label>
                                <select required="" class="form-control jenis-bangunan input-submission "
                                    name="jenis-bangunan">
                                    <option value="Pribadi">Pribadi</option>
                                    <option value=" Kontrak"> Kontrak</option>
                                    <option value=" Kost"> Kost</option>
                                </select></div>
                        </div>
                    </div>

                    <br />

                    <div class="mb-3">
                        <label class="form-label">Sales Order Project (Area coverage)</label>
                        <select class="form-select" name="project_id" id="project_so" aria-label="">
                            <option value="">-- Select --</option>

                            @forelse($site_project as $proj)
                                <option value="{{ $proj->id }}">{{ $proj->project_name }}
                                @empty
                                <option value="">No Project Found</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Date Order</label>
                                <input type="date" class="form-control" name="date_order" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Network Availability</label>
                                <select class="form-control" name="network" required>
                                    <option>-- Select --</option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">

                        <label class="form-label">Promo</label>
                        <select name="promo" class="form-select">
                            <option value="">-- Select Promo --</option>
                            <option value="1 Bulan">1 Bulan</option>
                            <option value="3 Bulan disc 30%">3 Bulan disc 30%</option>
                        </select>

                    </div>

                    <div class="mb-3">
                        <label class="form-label">Order Notes</label>
                        <textarea class="form-control" name="order_notes"
                            placeholder="describe related order information" value="" required></textarea>
                    </div>

                </div>


                <div class="modal-footer">
                    <a href="#" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>

            </form>

        </div>
    </div>
</div>


<form style="display:none" method="POST" action="/" id="form-like">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
</form>

<style type="text/css">
    .modal-body .ts-dropdown {
        top: 310px !important;
    }

    .header-field {
        padding: 10px;
        background: #f5f8fc;
    }

    .header-field>.card-title {
        font-size: 14px;
    }

</style>


<script type="text/javascript">
    $(document).ready(function () {

        $.ajaxSetup({
            headers: {

                'X-CSRF-TOKEN': $('#form-like  ').find('input[name="_token"]').first().val()

            }
        });

        $(".choose-plan").html(
            '<div class="alert alert-important alert-info alert-dismissible" role="alert"><div class="d-flex"><div><!-- Download SVG icon from http://tabler-icons.io/i/info-circle --><svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path><path d="M12 9h.01"></path><path d="M11 12h1v4h1"></path></svg></div><div>Select the product first</div></div><a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a></div>'
        );

        $('#select-product').on('change', function () {

            var group_id = this.value

            $.ajax({

                type: 'POST',
                url: "{{ route('get_product_plan') }}",
                data: {
                    group_id: group_id
                },
                success: function (data) {

                    if (data.length != 0) {
                        $(".choose-plan").html('');
                        for (var i = 0; i < data.length; i++) {
                            $(".choose-plan").append(
                                '<div class="col-lg-6" style="padding-top:calc(var(--tblr-gutter-x) * .5);padding-bottom:calc(var(--tblr-gutter-x) * .5)"><label class="form-selectgroup-item"><input type="radio" name="product_plan" value="' +
                                data[i]['id'] +
                                '" class="form-selectgroup-input product-plan" required><span class="form-selectgroup-label d-flex align-items-center p-3"><span class="me-3"><span class="form-selectgroup-check"></span></span><span class="form-selectgroup-label-content"><span class="form-selectgroup-title strong mb-1">' +
                                data[i]['product_name'] +
                                ' - <span class="text-secondary">' + data[i][
                                    'product_plan'
                                ] +
                                '</span></span><span class="d-block text-secondary">' +
                                data[i]['product_desc'] +
                                '</span></span></span></label></div>');
                        }
                    } else {
                        $(".choose-plan").html(
                            '<div class="alert alert-info" role="alert"><div class="d-flex"><div><!-- Download SVG icon from http://tabler-icons.io/i/info-circle --><svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path><path d="M12 9h.01"></path><path d="M11 12h1v4h1"></path></svg></div><div><h4 class="alert-title">Empty Product Plan</h4><div class="text-secondary">Produk belum tersedia untuk saat ini</div></div></div></div>'
                        );
                    }

                }

            });

        });


        $('.choose-plan').on('change', '.product-plan', function () {

            var product_id = this.value

            $.ajax({

                type: 'POST',
                url: "{{ route('get_product_field') }}",
                data: {
                    product_id: product_id
                },
                success: function (data) {

                    $.ajax({

                        type: 'POST',
                        url: "{{ route('get_product_price') }}",
                        data: {
                            product_id: product_id
                        },
                        success: function (data) {

                            if (data.price != 0) {
                                $("#product_price").val(data.price);
                            } else {
                                $("#product_price").val(
                                    'Product price not found');
                            }

                        }

                    });

                    if (data.length != 0) {
                        $(".input-product-field").html('');
                        for (var i = 0; i < data.length; i++) {

                            if (data[i]['field_type'] == 'selectbox') {

                                var input_option = data[i]['select_options'];
                                var arr_option = input_option.split(',')

                                $(".input-product-field").append(
                                    '<div class="mb-3"><label class="form-label">' +
                                    data[i]['field_name'] +
                                    '</label><select required class="form-control ' +
                                    data[i]['field_slug'] + '" name="' + data[i][
                                        'field_slug'
                                    ] + '"></select></div>');

                                for (s = 0; s < arr_option.length; s++) {

                                    $('.' + data[i]['field_slug']).append($('<option>', {
                                        value: arr_option[s],
                                        text: arr_option[s]
                                    }));

                                }
                            }

                            if (data[i]['field_type'] == 'textbox' || data[i][
                                    'field_type'
                                ] == 'link') {
                                $(".input-product-field").append(
                                    '<div class="mb-3"><label class="form-label">' +
                                    data[i]['field_name'] +
                                    '</label><input required type="text" name="' + data[
                                        i]['field_slug'] +
                                    '" class="form-control"  placeholder="input ' +
                                    data[i]['field_name'] +
                                    '" ></div>');
                            }

                        }
                    } else {
                        $(".choose-plan").html(
                            '<div class="alert alert-info" role="alert"><div class="d-flex"><div><!-- Download SVG icon from http://tabler-icons.io/i/info-circle --><svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path><path d="M12 9h.01"></path><path d="M11 12h1v4h1"></path></svg></div><div><h4 class="alert-title">No Product Available</h4><div class="text-secondary">Produk belum tersedia untuk saat ini</div></div></div></div>'
                        );
                    }

                }

            });

        });

    });

</script>
