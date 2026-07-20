<div class="modal modal-blur fade" id="modal-editproject" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <form enctype="multipart/form-data" method="POST" action="/console/project/update" id="form-project">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" class="project_id" name="project_id" />

                <div class="modal-header">
                    <h5 class="modal-title">Update Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Project Name</label>
                                <input type="text" class="form-control project_name" name="project_name"
                                    placeholder="Input Project Name" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Project Goals</label>
                                <input type="text" class="form-control project_goals" name="project_goals"
                                    placeholder="Input Project Goals" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Project Address</label>
                        <input type="text" class="form-control project_address" name="project_address"
                            placeholder="Input Project Address" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control project_description" name="project_description"
                            placeholder=""></textarea>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Project Start</label>
                                <input type="text" class="form-control project_start" name="project_start"
                                    id="datepicker-icon3">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Project End</label>
                                <input type="text" class="form-control project_end" name="project_end"
                                    id="datepicker-icon4">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Router Name</label>
                        <select class="form-select router_id" name="router_id" aria-label="">
                            <option value="">-- Select --</option>

                            @forelse($site_router as $rtr)
                                <option value="{{ $rtr->id }}">{{ $rtr->label_name }}
                                @empty
                                <option value="">No Router Found</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control sts" required>
                            <option value="">Select Status</option>
                            <option value="active">active</option>
                            <option value="deactive">deactive</option>
                        </select>
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
