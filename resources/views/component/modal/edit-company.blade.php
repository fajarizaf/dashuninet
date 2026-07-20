<div class="modal modal-blur fade" id="modal-editcompany" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <form method="POST" action="/console/customer/company/update" id="form-banner">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="company_id" class="company_id" value="" />
                <input type="hidden" name="customer_id" class="customer_id" value="" />
                <div class="modal-header">
                    <h5 class="modal-title">Edit Company</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Company Name</label>
                        <input type="text" class="form-control company_name" name="company_name" value="" placeholder="Input Name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Company Email</label>
                        <input type="text" class="form-control company_email" name="company_email" value="" placeholder="Input Email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Company Telp</label>
                        <input type="text" class="form-control company_telp" name="company_telp" value="" placeholder="Input Telp" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Company Address</label>
                        <textarea class="form-control company_address" style="height:100px"  name="company_address"></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <a href="#" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</a>
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
