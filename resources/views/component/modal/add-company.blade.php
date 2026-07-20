<div class="modal modal-blur fade" id="modal-addcompany" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <form method="POST" action="/console/customer/company/add" id="form-banner">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                <div class="modal-header">
                    <h5 class="modal-title">New Company</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Company Name</label>
                        <input type="text" class="form-control" name="company_name" placeholder="Input Name"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Company Email</label>
                        <input type="text" class="form-control" name="company_email" placeholder="Input Email"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Company Telp</label>
                        <input type="text" class="form-control" name="company_telp" placeholder="Input Telp"
                            required>
                    </div>

                </div>

                <div class="modal-body">
                    <h3>Account Manager ( Personal In Charge )</h3>

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="customer_name" placeholder="Input Personal Name"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" name="customer_email" placeholder="Input Personal Email"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telp</label>
                        <input type="text" class="form-control" name="customer_telp" placeholder="Input Personal Telp"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="text" class="form-control" name="password" placeholder="Password Login to Customer Portal" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <a href="#" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</a>
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
