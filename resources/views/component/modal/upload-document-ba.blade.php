<div class="modal modal-blur fade" id="modal-upload-ba" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">
            <form method="POST" action="/console/salesorder/upload/document" enctype="multipart/form-data">
                <input type="text" style="display:none" name="_token" value="{{ csrf_token() }}" />
                <input type="text" style="display:none" name="order_id" value="{{ Request::segment(4) }}" />
                <input type="text" style="display:none" name="document_type" value="ba" />      
                
                <div class="modal-header">
                    <h5 class="modal-title">Upload Document BA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Pilih Dokument<span class="form-label-description"></span></label>
                        <input type="file" name="upload" class="form-control">
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