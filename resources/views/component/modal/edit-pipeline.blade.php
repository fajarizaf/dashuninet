<div class="modal modal-blur fade" id="modal-editpipeline" tabindex="-1" role="dialog" aria-hidden="false"
    aria-modal="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            <form method="POST" action="/console/pipeline/update" id="form-pipeline">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" class="pipeline_id" name="pipeline_id" />

                <div class="modal-header">
                    <h5 class="modal-title">Update Pipeline</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="general">

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Customer Name</label>
                                    <input type="text" class="form-control pic_name" name="pic_name"
                                        placeholder="Input PIC Name" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Sales PIC</label>
                                    <input disabled type="text" class="form-control sales_pic" name="sales_pic"
                                        placeholder="Sales PIC" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Place Of Bussines *</label>
                                    <input type="text" class="form-control place_of_bussines" name="place_of_bussines"
                                        placeholder="Input Place Of Bussines" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Area *</label>
                                    <input type="text" class="form-control area" name="area" placeholder="Input Area"
                                        required>
                                </div>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Existing Product Name</label>
                                    <input type="text" class="form-control exist_product" name="exist_product"
                                        placeholder="Input Existing Product Name">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Existing Product Price</label>
                                    <input type="number" class="form-control price_product" name="price_product"
                                        placeholder="Input Existing Product Price">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Existing Product Bandwidth</label>
                                    <input type="text" class="form-control bandwidth_product" name="bandwidth_product"
                                        placeholder="Input Existing Product Bandwidth">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control keterangan" name="keterangan" style="min-height:100px"
                                placeholder=""></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Phone Number *</label>
                                <input type="number" class="form-control telp" name="telp" placeholder="Input Telp"
                                    required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Email Address *</label>
                                <input type="email" class="form-control email" name="email" placeholder="Input Email"
                                    required>
                            </div>
                        </div>
                    </div>

                    <div class="submission">
                        <div class="mb-3">
                            <label class="form-label">Nama Jalan</label>
                            <input type="text" class="form-control nama_jalan" name="nama_jalan"
                                placeholder="Input Nama Jalan">
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <div class="mb-3">
                                    <label class="form-label">RT</label>
                                    <input type="number" class="form-control rt" name="rt" placeholder="Input RT">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="mb-3">
                                    <label class="form-label">RW</label>
                                    <input type="number" class="form-control rw" name="rw" placeholder="Input RW">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Kelurahan</label>
                                    <input type="text" class="form-control kelurahan" name="kelurahan"
                                        placeholder="Input kelurahan">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Kecamatan</label>
                                    <input type="text" class="form-control kecamatan" name="kecamatan"
                                        placeholder="Input Kecamatan">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Kabupaten/Kota</label>
                                    <input type="text" class="form-control kabupaten" name="kabupaten"
                                        placeholder="Input Kabupaten">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Bangunan</label>
                            <select name="jenis_bangunan" class="form-select jenis_bangunan">
                                <option value="Pribadi">Pribadi</option>
                                <option value="Kontrak">Kontrak</option>
                                <option value="Kost">Kost</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="card">
                                <div class="card-header header-field">
                                    <h3 class="card-title">Product</h3>
                                </div>
                                <div class="card-body">
                                    <div class="prod fw-bold fs-3"></div>
                                </div>
                            </div>

                        </div>
                        <div class="mb-3">
                            <label class="form-label">Link Maps</label>
                            <input type="text" class="form-control link_maps" name="link_maps"
                                placeholder="Input Link Maps">
                        </div>
                        <div id="map"></div>

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

    #map {
        height: 300px;
    }

</style>
