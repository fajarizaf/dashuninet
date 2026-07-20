<div class="modal modal-blur fade" id="modal-edituser" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <form method="POST" action="/console/customer/update" id="form-edit-customer">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="customer_id" value="" class="edit_customer_id" />
                <input type="hidden" name="tipe" value="{{ $tipe }}" class="" />

                <div class="modal-header">
                    <h5 class="modal-title">Edit Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control edit_customer_name" name="customer_name"
                                    required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-control edit_email" name="customer_email"
                                    placeholder="Input Your Email" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="number" class="form-control edit_phone" name="customer_telp"
                                    placeholder="Input Your Password" required>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control edit_email" disabled name="customer_email"
                            placeholder="Input Your Email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="number" class="form-control edit_phone" name="customer_telp"
                            placeholder="Input Your Password" required>
                    </div> -->

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea class="form-control edit_customer_address" name="customer_address"
                            placeholder="Input Your Address"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select edit_status">
                                    <option value="1">Active</option>
                                    <option value="0">Deactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Is Verified?</label>
                                <select name="is_verified" class="form-select edit_verified">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Account Type</label>
                        <select class="form-control contact_type" name="contact_type">
                            <option value="Account Manager">Account Manager</option>
                            <option value="Sales Contact">Sales Contact</option>
                            <option value="Technical Contact">Technical Contact</option>
                            <option value="Billing Contact">Billing Contact</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="text" class="form-control" name="customer_password">
                    </div>

                    <!-- <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="text" class="form-control" name="customer_password">
                    </div> -->

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


<script type="text/javascript">
    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('#form-like  ').find('input[name="_token"]').first().val()
            }
        });

        $("#form-edit-cust").submit(function (e) {

            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = $(this);
            let custsId = $("[name='customer_id']").val(),
                customer_name = $("[name='customer_name']").val(),
                customer_company = $("[name='customer_company']").val(),
                customer_telp = $("[name='customer_telp']").val(),
                customer_address = $("[name='customer_address']").val(),
                customer_password = $("[name='customer_password']").val();
            // var actionUrl = form.attr('action');

            if (customer_password != "") {
                data = {
                    'custId': custsId,
                    'customer_name': customer_name,
                    'customer_telp': customer_telp,
                    'customer_address': customer_address,
                    'customer_password': customer_password,
                }
            } else {
                data = {
                    'custId': custsId,
                    'customer_name': customer_name,
                    'customer_telp': customer_telp,
                    'customer_address': customer_address,
                }
            }

            $.ajax({
                type: "POST",
                url: "<?= env('BACKEND_URL') ?>/customer/update",
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Authorization',
                        "Bearer <?= env('BACKEND_TOKEN') ?>");
                },
                data: JSON.stringify(data),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (data) {
                    alert("Update Success");
                    window.location.reload();
                }
            });

        });


    });

</script>
