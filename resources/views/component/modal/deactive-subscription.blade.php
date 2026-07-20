<div class="modal modal-blur fade" id="modal-deactive-subscription" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <form method="POST" action="/console/subscription/set_deactive">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="order_id" value="{{ Request::segment(4) }}" />
                <input type="hidden" name="subscription_id" id="da_subscription_id" value="-" />

                <div class="modal-header">
                    <h5 class="modal-title">Deactive Subscription</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">


                    <div class="d-flex py-1 align-items-center">
                        <span class="avatar me-2" style="background-image: url(./static/avatars/010m.jpg)"></span>
                        <div class="flex-fill">
                            <div class="font-weight-medium" id="da_product">-</div>
                            <div class="text-secondary"><a href="#" class="text-reset" id="da_plan">-</a></div>
                        </div>
                    </div>

                    <br /><br />

                    <div class="mb-3">
                        <label class="form-label">Deactive Reason<span class="form-label-description"></span></label>
                        <textarea class="form-control" name="deactive_reason" rows="6" required></textarea>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Set Deactive</button>
                </div>
            </form>
        </div>
    </div>

</div>
