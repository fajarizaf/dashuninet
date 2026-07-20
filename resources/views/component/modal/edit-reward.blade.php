<div class="modal modal-blur fade" id="modal-editreward" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <form enctype="multipart/form-data" method="POST" action="/console/reward/update" id="form-reward">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" class="reward_id" name="reward_id" />

                <div class="modal-header">
                    <h5 class="modal-title">Update Reward</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Reward Name</label>
                                <input type="text" class="form-control reward_name" name="reward_name"
                                    placeholder="Input Reward Name" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Reward Point</label>
                                <input type="number" class="form-control reward_point" name="reward_point"
                                    placeholder="Input Reward Point" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control reward_description" name="keterangan" placeholder=""></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select status" required>
                            <option value="">Select Status</option>
                            <option value="active">active</option>
                            <option value="deactive">deactive</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <div class="form-label">Cover</div>
                        <input type="file" name="upload" class="form-control" accept="image/*">
                        <img id="cover" class="mt-3" src="" />
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
