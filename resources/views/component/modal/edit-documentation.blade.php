<div class="modal modal-blur fade" id="modal-editdocumentation" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <form enctype="multipart/form-data" method="POST" action="/console/documentation/update"
                id="form-documentation">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" class="documentation_id" name="documentation_id" />

                <div class="modal-header">
                    <h5 class="modal-title">Update Documentation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control title" name="title" placeholder="Input title" required>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Platform</label>
                                <select name="app" class="form-select app" required>
                                    <option value="">Select Platform</option>
                                    <option value="mobile">Mobile App</option>
                                    <option value="customer portal">Customer Portal</option>
                                    <option value="dashboard portal">Dashboard Portal</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Type</label>
                                <select name="type" class="form-select type" required>
                                    <option value="">Select Type</option>
                                    <option value="documentation">Documentation</option>
                                    <option value="faq">FAQ</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Is Visible</label>
                                <select name="is_visible" class="form-select is_visible" required>
                                    <option value="">Select Visibility</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Category</label>

                                @inject("Documentation", "App\Http\Controllers\DocController")

                                <select name="categori" class="form-select categori" required>
                                    <option value="">Select Categori</option>
                                    @forelse($categori as $cate)
                                        <option value="{{$cate->id}}">{{ $Documentation::get_name_cat($cate->id)}}</option>
                                    @empty

                                    @endforelse
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea id="tinymce-mytextarea2" name="content" aria-hidden="true"></textarea>
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
