<div class="modal modal-blur fade" id="modal-addproduct" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            <form enctype="multipart/form-data" method="POST" action="/console/product/create" id="form-product">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                <div class="modal-header">
                    <h5 class="modal-title">New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Product Scope *</label>
                                <select name="product_scope" class="form-select" required>
                                    <option value="">-- Select --</option>
                                    <option value="corporate">corporate</option>
                                    <option value="retail">retail</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Product Type *</label>
                                <select name="product_type" class="form-select" required>
                                    <option value="">-- Select --</option>
                                    <option value="ISP">ISP</option>
                                    <option value="membership">membership</option>
                                </select>

                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Product Group *</label>
                        <select class="form-select" name="product_group" aria-label="" required>
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
                                <input type="text" class="form-control" name="product_name"
                                    placeholder="Input Product Name" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Product Plan *</label>
                                <input type="text" class="form-control" name="product_plan"
                                    placeholder="Input Product Plan" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="product_desc" placeholder=""></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Is Hidden? *</label>
                        <select name="is_hidden" class="form-select" required>
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
                                <tbody>

                                    <tr class="tr_clone">
                                        <td class="py-2 text-nowrap">
                                            <input type="text" class="form-control text-start" name="field_name[]"
                                                value="" required />
                                        </td>
                                        <td class="py-2">
                                            <select name="field_type[]" class="form-select field_type" required>
                                                <option value="textbox">textbox</option>
                                                <option value="selectbox">selectbox</option>
                                                <option value="link">link</option>
                                                <option value="date">date</option>
                                                <option value="datetime">datetime</option>
                                            </select>
                                            <input type="text" class="form-control mt-2 select_options"
                                                name="select_options[]" value=""
                                                placeholder="Options, separated by comma ex: rt,rw,kelurahan,kecamatan"
                                                style="display:none" />
                                        </td>
                                        <td class="py-2 text-end d-flex align-items-center gap-1">
                                            <input type="number" class="form-control text-end" name="order_number[]"
                                                value="" required />
                                            <div class="badge text-red border border-red remove_row p-1" title="Remove"
                                                style="cursor: pointer;display:none;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M18 6l-12 12" />
                                                    <path d="M6 6l12 12" /></svg>&nbsp;
                                            </div>
                                        </td>
                                    </tr>

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
                                <input class="form-check-input payment_type" type="radio" name="payment_type"
                                    value="onetime" required>
                                <span class="form-check-label">Onetime</span>
                            </label>
                            <label class="form-check form-check-inline">
                                <input class="form-check-input payment_type" type="radio" name="payment_type"
                                    value="recurring" uired>
                                <span class="form-check-label">Recurring</span>
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-check">
                            <input class="form-check-input" type="checkbox" name="deposit_payment" value="1">
                            <span class="form-check-label">Payment Use Deposit</span>
                        </label>
                    </div>

                    <div class="table-responsive onetime w-50" style="display:none">
                        <table class="table table-transparent border bg-light m-0">
                            <thead>
                                <tr>
                                    <th class="text-start">#</th>
                                    <th class="text-end">Onetime</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="tr_clone">
                                    <td class="py-2 text-start">
                                        Setup Fee
                                    </td>
                                    <td class="py-2">
                                        <input type="number" class="form-control text-end" name="setup_fee[]"
                                            value="" />
                                    </td>
                                </tr>
                                <tr class="tr_clone">
                                    <td class="py-2 text-start">
                                        Price
                                    </td>
                                    <td class="py-2">
                                        <input type="hidden" name="billing_cycle[]" value="onetime" />
                                        <input type="number" class="form-control text-end" name="price[]" value="" />
                                    </td>
                                </tr>
                                <tr class="tr_clone">
                                    <td class="py-2 text-start">
                                        Enable
                                    </td>
                                    <td class="py-2">
                                        <label class="form-check">
                                            <input class="form-check-input" type="checkbox" name="enabled[]"
                                                value="onetime">
                                            <!-- <span class="form-check-label">Checkbox input</span> -->
                                        </label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive recurring" style="display:none">
                        <table class="table table-transparent border bg-light m-0">
                            <thead>
                                <tr>
                                    <th class="text-start">#</th>
                                    <th class="text-end">Monthly</th>
                                    <th class="text-end">Quarterly</th>
                                    <th class="text-end">Semi-Annually</th>
                                    <th class="text-end">Annually</th>
                                    <th class="text-end">Biennially</th>
                                    <th class="text-end">Triennially</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="tr_clone">
                                    <td class="py-2 text-start">
                                        Setup Fee
                                    </td>
                                    <td class="py-2">
                                        <input type="number" class="form-control text-end" name="setup_fee[]"
                                            value="" />
                                    </td>
                                    <td class="py-2">
                                        <input type="number" class="form-control text-end" name="setup_fee[]"
                                            value="" />
                                    </td>
                                    <td class="py-2">
                                        <input type="number" class="form-control text-end" name="setup_fee[]"
                                            value="" />
                                    </td>
                                    <td class="py-2">
                                        <input type="number" class="form-control text-end" name="setup_fee[]"
                                            value="" />
                                    </td>
                                    <td class="py-2">
                                        <input type="number" class="form-control text-end" name="setup_fee[]"
                                            value="" />
                                    </td>
                                    <td class="py-2">
                                        <input type="number" class="form-control text-end" name="setup_fee[]"
                                            value="" />
                                    </td>
                                </tr>
                                <tr class="tr_clone">
                                    <td class="py-2 text-start">
                                        Price
                                    </td>
                                    <td class="py-2">
                                        <input type="hidden" name="billing_cycle[]" value="monthly" />
                                        <input type="number" class="form-control text-end" name="price[]" value="" />
                                    </td>
                                    <td class="py-2">
                                        <input type="hidden" name="billing_cycle[]" value="quarterly" />
                                        <input type="number" class="form-control text-end" name="price[]" value="" />
                                    </td>
                                    <td class="py-2">
                                        <input type="hidden" name="billing_cycle[]" value="semi-annually" />
                                        <input type="number" class="form-control text-end" name="price[]" value="" />
                                    </td>
                                    <td class="py-2">
                                        <input type="hidden" name="billing_cycle[]" value="annually" />
                                        <input type="number" class="form-control text-end" name="price[]" value="" />
                                    </td>
                                    <td class="py-2">
                                        <input type="hidden" name="billing_cycle[]" value="biennially" />
                                        <input type="number" class="form-control text-end" name="price[]" value="" />
                                    </td>
                                    <td class="py-2">
                                        <input type="hidden" name="billing_cycle[]" value="triennially" />
                                        <input type="number" class="form-control text-end" name="price[]" value="" />
                                    </td>
                                </tr>
                                <tr class="tr_clone">
                                    <td class="py-2 text-start">
                                        Enable
                                    </td>
                                    <td class="py-2">
                                        <label class="form-check">
                                            <input class="form-check-input" type="checkbox" name="enabled[]"
                                                value="monthly">
                                            <!-- <span class="form-check-label">Checkbox input</span> -->
                                        </label>
                                    </td>
                                    <td class="py-2">
                                        <label class="form-check">
                                            <input class="form-check-input" type="checkbox" name="enabled[]"
                                                value="quarterly">
                                        </label>
                                    </td>
                                    <td class="py-2">
                                        <label class="form-check">
                                            <input class="form-check-input" type="checkbox" name="enabled[]"
                                                value="semi-annually">
                                        </label>
                                    </td>
                                    <td class="py-2">
                                        <label class="form-check">
                                            <input class="form-check-input" type="checkbox" name="enabled[]"
                                                value="annually">
                                        </label>
                                    </td>
                                    <td class="py-2">
                                        <label class="form-check">
                                            <input class="form-check-input" type="checkbox" name="enabled[]"
                                                value="biennially">
                                        </label>
                                    </td>
                                    <td class="py-2">
                                        <label class="form-check">
                                            <input class="form-check-input" type="checkbox" name="enabled[]"
                                                value="triennially">
                                        </label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mb-3">
                        <div class="form-label">Cover Image</div>
                        <input type="file" name="upload" class="form-control" accept="image/*" required>
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
