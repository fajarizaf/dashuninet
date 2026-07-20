<div class="modal modal-blur fade" id="modal-addpipeline" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            <form method="POST" action="/console/pipeline/create" id="form-pipeline">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                <div class="modal-header">
                    <h5 class="modal-title">New Pipeline</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Customer Name</label>
                                <input type="text" class="form-control" name="pic_name"
                                    placeholder="Input Customer Name" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Place Of Bussines *</label>
                                <input type="text" class="form-control" name="place_of_bussines"
                                    placeholder="Input Place Of Bussines" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Area *</label>
                                <input type="text" class="form-control" name="area" placeholder="Input Area" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">

                        <label class="form-label">Existing Product Name</label>
                        <input type="text" class="form-control" name="exist_product"
                            placeholder="Input Existing Product Name" required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">Existing Product Price</label>
                        <input type="number" class="form-control" name="price_product"
                            placeholder="Input Existing Product Price" required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">Existing Product Bandwidth</label>
                        <input type="text" class="form-control" name="bandwidth_product"
                            placeholder="Input Existing Product Bandwidth" required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">Note</label>
                        <textarea class="form-control" name="keterangan" placeholder="Input Note"></textarea>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">Phone Number *</label>
                        <input type="number" class="form-control" name="telp" placeholder="Input Phone Number" required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">Email Address *</label>
                        <input type="email" class="form-control" name="email" placeholder="Input Email Address"
                            required>

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
