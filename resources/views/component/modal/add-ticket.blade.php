<div class="modal modal-blur fade" id="modal-addticket" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <form enctype="multipart/form-data" method="POST" action="/console/ticket/create" id="form-ticket">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                <div class="modal-header">
                    <h5 class="modal-title">New Ticket
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <div class="form-label">Select Customer</div>
                        <select type="text" class="form-select" id="select-product" name="customer_id" required>
                            <option value="">
                                -- Choose the Customer --
                            </option>
                            @forelse($cust as $customer)
                                <option value="{{ $customer->id }}"
                                    data-custom-properties="&lt;span class=&quot;avatar avatar-xs&quot; style=&quot;background-color: #efefef;)&quot;&gt;&lt;/span&gt;">
                                    {{ $customer->customer_number }}
                                    {{ $customer->customer_name }} -
                                    {{ $customer->customer_email }}
                                </option>
                            @empty
                                <option value=""
                                    data-custom-properties="&lt;span class=&quot;avatar avatar-xs&quot; style=&quot;background-color: #efefef;)&quot;&gt;&lt;/span&gt;">
                                    No Customer Found</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" placeholder="Input Title" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea class="form-control" name="message" placeholder="" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Priority</label>
                        <select name="priority" class="form-select" required>
                            <option value="">-- Select Priority --</option>
                            <option value="High">High</option>
                            <option value="Medium">Medium</option>
                            <option value="Low">Low</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <div class="form-label">Upload Attachments</div>
                        <input type="file" name="upload" class="form-control" required>
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
        top: 100px !important;
    }

    .header-field {
        padding: 10px;
        background: #f5f8fc;
    }

    .header-field>.card-title {
        font-size: 14px;
    }

</style>
