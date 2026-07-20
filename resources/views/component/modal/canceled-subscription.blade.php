<div class="modal modal-blur fade" id="modal-canceled-subscription" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <form method="POST" action="/console/subscription/set_canceled">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="order_id" value="{{ Request::segment(4) }}" />
                <input type="hidden" name="subscription_id" id="c_subscription_id" value="-" />

                <div class="modal-header">
                    <h5 class="modal-title">Cancel Subscription</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">


                    <div class="d-flex py-1 align-items-center">
                        <span class="avatar me-2" style="background-image: url(./static/avatars/010m.jpg)"></span>
                        <div class="flex-fill">
                            <div class="font-weight-medium" id="c_product">-</div>
                            <div class="text-secondary"><a href="#" class="text-reset" id="c_plan">-</a></div>
                        </div>
                    </div>
                    <br />
                    <div class="mb-3">
                        <label class="form-label">Cancel Reason<span class="form-label-description"></span></label>
                        <select class="form-control select-cancel" name="cancel_reason" required>
                            <option>Select</option>
                            <option value="Pelanggan menunggu terlalu lama">Pelanggan menunggu terlalu lama</option>
                            <option value="ODP terlalu jauh dari alamat pelanggan">ODP terlalu jauh dari alamat
                                pelanggan</option>
                            <option value="Area diluar jangkauan">Area diluar jangkauan</option>
                            <option value="Lainya">Lainya</option>
                        </select>
                    </div>
                    <div class="mb-3 text-cancel">
                        <label class="form-label">Catatan<span class="form-label-description"></span></label>
                        <textarea class="form-control " name="catatan"></textarea>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Set Cancel</button>
                </div>
            </form>
        </div>
    </div>

</div>


<script>
    $(document).ready(function () {

    });

</script>
