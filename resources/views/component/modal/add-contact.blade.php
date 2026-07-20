<div class="modal modal-blur fade" id="modal-addcontact" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <form enctype="multipart/form-data" method="POST" action="/console/customer/contact/add" id="form-banner">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                <div class="modal-header">
                    <h5 class="modal-title">New Contact</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Select Company</label>
                        <select class="form-control" name="company_id">
                            <option value="">Select</option>
                            @forelse($site_company as $site)
                                <option value="{{$site->id}}">{{$site->company_name}}</option>
                            @empty

                            @endforelse
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contact Type</label>
                        <select class="form-control" name="contact_type">
                            <option value="Sales Contact">Sales Contact</option>
                            <option value="Technical Contact">Technical Contact</option>
                            <option value="Billing Contact">Billing Contact</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contact Name</label>
                        <input type="text" class="form-control" name="customer_name" placeholder="Contact Name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contact Email</label>
                        <input type="text" class="form-control" name="customer_email" placeholder="Contact email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contact Telp</label>
                        <input type="text" class="form-control" name="customer_telp" placeholder="Contact Telp" required>
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
