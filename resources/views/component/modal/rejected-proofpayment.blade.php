<div class="modal modal-blur fade" id="modal-rejected-reason" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <form method="POST" action="{{ url('/console/buktibayar/rejected') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="invoice_id" value="{{ Request::segment(4) }}" />
                
                <div class="modal-header">
                    <h5 class="modal-title">Reject Proof Of Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Rejected Reason<span class="form-label-description"></span></label>
                        <textarea class="form-control" name="rejected_reason" rows="6" required></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Submit</button>
                </div>

            </form>
        </div>
    </div>

</div>