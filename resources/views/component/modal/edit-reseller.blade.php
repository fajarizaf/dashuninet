<div class="modal modal-blur fade" id="modal-editreseller" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <form enctype="multipart/form-data" method="POST" action="/console/reseller/update" id="form-edit-reseller">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" class="reseller_id" name="reseller_id" />

                <div class="modal-header">
                    <h5 class="modal-title">Update Reseller</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Reseller Name</label>
                                <input type="text" class="form-control reseller_name" name="reseller_name"
                                    placeholder="Input Reseller Name" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Reseller Phone</label>
                                <input type="text" class="form-control reseller_phone" name="reseller_phone"
                                    placeholder="Input Reseller Phone" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Reseller Address</label>
                        <input type="text" class="form-control reseller_address" name="reseller_address"
                            placeholder="Input Reseller Address" required>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Owner Name</label>
                                <input type="text" class="form-control owner_name" name="owner_name"
                                    placeholder="Input Owner Name" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Owner Email</label>
                                <input type="email" class="form-control owner_email" name="owner_email"
                                    placeholder="Input Owner Email" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Input Password">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bandwidth Limit (Mbps)</label>
                        <input type="number" class="form-control bandwidth" name="bandwidth"
                            placeholder="Input Bandwidth (Mbps)" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control sts" required>
                            <option value="">Select Status</option>
                            <option value="active">active</option>
                            <option value="deactive">deactive</option>
                        </select>
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


<!-- <form style="display:none" method="POST" action="/" id="form-like">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
</form> -->

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
