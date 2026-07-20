<div class="modal modal-blur fade" id="modal-addpayment" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <form method="POST" action="/console/invoices/add/payment" id="form-invoices">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="invoice_id" value="{{ Request::segment(4) }}" />

                <div class="modal-header">
                    <h5 class="modal-title">Add Payment Transaction</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Payment Date</label>
                                <input type="date" class="form-control" name="payment_date" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Payment Method</label>
                                <select class="form-select" name="payment_method">
                                    <option value="Bank Transfer">Bank Transfer</option>
                                    <option value="Free">Free</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">

                        <label class="form-label">Transaction ID</label>
                        <input type="text" class="form-control" name="transaction_id">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">Amount</label>
                        <input type="number" class="form-control" name="amount"
                            required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">Transaction Fees</label>
                        <input type="number" class="form-control" name="fees">

                    </div>

                </div>


                <div class="modal-footer">
                    <a href="#" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">Add Transaction</button>
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

