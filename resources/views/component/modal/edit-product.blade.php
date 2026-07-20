<div class="modal modal-blur fade" id="modal-editproduct" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            <form enctype="multipart/form-data" method="POST" action="/console/product/update" id="form-product">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" class="product_id" name="product_id" />

                <div class="modal-header">
                    <h5 class="modal-title">Update Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Product Scope *</label>
                                <select name="product_scope" class="form-select product_scope" required>
                                    <option value="">-- Select --</option>
                                    <option value="corporate">corporate</option>
                                    <option value="retail">retail</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Product Type *</label>
                                <select name="product_type" class="form-select product_type" required>
                                    <option value="">-- Select --</option>
                                    <option value="ISP">ISP</option>
                                    <option value="membership">membership</option>
                                </select>

                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Product Group *</label>
                        <select class="form-select product_group" name="product_group" aria-label="" required>
                            <option value="">-- Select --</option>

                            @forelse($site_product_group as $raw)
                                <option value="{{ $raw->id }}">{{ $raw->product_group_name }}
                                @empty
                                <option value="">No Product Group Found</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Product Name *</label>
                                <input type="text" class="form-control product_name" name="product_name"
                                    placeholder="Input Product Name" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Product Plan *</label>
                                <input type="text" class="form-control product_plan" name="product_plan"
                                    placeholder="Input Product Plan" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control product_desc" name="product_desc" placeholder=""></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Is Hidden? *</label>
                        <select name="is_hidden" class="form-select is_hidden" required>
                            <option value="">-- Select --</option>
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Custom Field</label>
                        <div class="table-responsive mb-3">
                            <table class="table table-transparent border bg-light m-0">
                                <thead>
                                    <tr>
                                        <th>Field Name</th>
                                        <th style="">Type</th>
                                        <th style="width: 10rem;" class="text-end">Order Number</th>
                                    </tr>
                                </thead>
                                <tbody id="tr_clone">
                                    <tr>
                                        <td class="py-2 text-center" colspan="6">
                                            <input type="button"
                                                class="btn btn-outline-cyan add_row text-capitalize py-1 px-2"
                                                value="add" style="float:right" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-label">Payment Type *</div>
                        <div>
                            <label class="form-check form-check-inline">
                                <input class="form-check-input onetime" type="radio" name="payment_type" value="onetime"
                                    required>
                                <span class="form-check-label">Onetime</span>
                            </label>
                            <label class="form-check form-check-inline">
                                <input class="form-check-input recurring" type="radio" name="payment_type"
                                    value="recurring" required>
                                <span class="form-check-label">Recurring</span>
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-check">
                            <input class="form-check-input" type="checkbox" name="deposit_payment" value="1" id="edit_deposit_payment">
                            <span class="form-check-label">Payment Use Deposit</span>
                        </label>
                    </div>

                    <div class="mb-3">
                        <label class="form-check">
                            <input class="form-check-input" type="checkbox" name="allow_promo" value="1" id="edit_allow_promo">
                            <span class="form-check-label">Allow Promo</span>
                        </label>
                    </div>



                    <div class="table-responsive">
                        <table class="table table-transparent border bg-light m-0">

                            <thead>
                                <tr id="title">
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="setupfee">
                                </tr>
                                <tr id="price">
                                </tr>
                                <tr id="enabled">
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mb-3">
                        <div class="form-label">Cover Image</div>
                        <input type="file" name="upload" class="form-control edit_cover"  accept="image/*" required>
                    </div>

                    <div class="mb-3">
                        <img src="" alt="Cover Image" class="img-fluid show_cover" style="max-height: 200px;">
                    </div>

                </div>

                <div class="modal-footer">
                    <a href="#" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">Update</button>
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
    // Function to load existing product fields when edit modal is opened
    window.loadProductFields = function(productData) {
        if (productData.field && productData.field.length > 0) {
            $('#tr_clone').empty();
            $.each(productData.field, function (key, value) {
                var field_type = value['field_type'];
                var option = '';
                var select_options_value = value['select_options'] || '';
                var select_options_display = field_type == 'selectbox' ? 'block' : 'none';
                
                if(field_type == 'selectbox'){
                    option = '<option value="textbox">textbox</option><option value="selectbox" selected>selectbox</option><option value="link">link</option><option value="date">date</option><option value="datetime">datetime</option>';
                }else if(field_type == 'link'){
                    option = '<option value="textbox">textbox</option><option value="selectbox">selectbox</option><option value="link" selected>link</option><option value="date">date</option><option value="datetime">datetime</option>';
                }else if(field_type == 'date'){
                    option = '<option value="textbox">textbox</option><option value="selectbox">selectbox</option><option value="link">link</option><option value="date" selected>date</option><option value="datetime">datetime</option>';
                }else if(field_type == 'datetime'){
                    option = '<option value="textbox">textbox</option><option value="selectbox">selectbox</option><option value="link">link</option><option value="date">date</option><option value="datetime" selected>datetime</option>';
                }else{
                    option = '<option value="textbox" selected>textbox</option><option value="selectbox">selectbox</option><option value="link">link</option><option value="date">date</option><option value="datetime">datetime</option>';
                }
                
                var removeButtonDisplay = key == 0 ? 'none' : 'block';
                
                $('#tr_clone').append(
                    '<tr class="tr_clone">' +
                    '<td class="py-2 text-nowrap">' +
                    '<input type="text" class="form-control" name="field_name[]" value="' + value['field_name'] + '" required />' +
                    '</td>' +
                    '<td class="py-2">' +
                    '<select name="field_type[]" class="form-select field_type" required>' + option + '</select>' +
                    '<input type="text" class="form-control mt-2 select_options" name="select_options[]" value="' + select_options_value + '" placeholder="Options, separated by comma ex: rt,rw,kelurahan,kecamatan" style="display:' + select_options_display + '" />' +
                    '</td>' +
                    '<td class="py-2 text-end d-flex align-items-center gap-1">' +
                    '<input type="number" class="form-control text-end" name="order_number[]" value="' + value['order'] + '" required />' +
                    '<div class="badge text-red border border-red remove_row p-1" title="Remove" style="cursor: pointer;display:' + removeButtonDisplay + ';">' +
                    '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">' +
                    '<path stroke="none" d="M0 0h24v24H0z" fill="none" />' +
                    '<path d="M18 6l-12 12" />' +
                    '<path d="M6 6l12 12" /></svg>&nbsp;' +
                    '</div>' +
                    '</td>' +
                    '</tr>'
                );
            });
            
            $('#tr_clone').append(
                '<tr>' +
                '<td class="py-2 text-center" colspan="6">' +
                '<input type="button" class="btn btn-outline-cyan add_row text-capitalize py-1 px-2" value="add" style="float:right" />' +
                '</td>' +
                '</tr>'
            );
        }
    };

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
        var newRow = '<tr class="tr_clone">' +
            '<td class="py-2 text-nowrap">' +
            '<input type="text" class="form-control" name="field_name[]" value="" required />' +
            '</td>' +
            '<td class="py-2">' +
            '<select name="field_type[]" class="form-select field_type" required>' +
            '<option value="textbox">textbox</option>' +
            '<option value="selectbox">selectbox</option>' +
            '<option value="link">link</option>' +
            '<option value="date">date</option>' +
            '<option value="datetime">datetime</option>' +
            '</select>' +
            '<input type="text" class="form-control mt-2 select_options" name="select_options[]" value="" placeholder="Options, separated by comma ex: rt,rw,kelurahan,kecamatan" style="display:none" />' +
            '</td>' +
            '<td class="py-2 text-end d-flex align-items-center gap-1">' +
            '<input type="number" class="form-control text-end" name="order_number[]" value="" required />' +
            '<div class="badge text-red border border-red remove_row p-1" title="Remove" style="cursor: pointer;display:block;">' +
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">' +
            '<path stroke="none" d="M0 0h24v24H0z" fill="none" />' +
            '<path d="M18 6l-12 12" />' +
            '<path d="M6 6l12 12" /></svg>&nbsp;' +
            '</div>' +
            '</td>' +
            '</tr>';
        
        $(newRow).insertBefore($(this).closest("tr"));
    });

    $(document).on("click", ".remove_row", function () {
        $(this).parent().parent().remove();
    });
</script>
