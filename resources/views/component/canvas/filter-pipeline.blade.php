<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasStart" aria-labelledby="offcanvasStartLabel"
    aria-modal="true" role="dialog">
    <div class="offcanvas-header">
        <h2 class="offcanvas-title" id="offcanvasStartLabel">
            <svg style="margin-right:10px;margin-top:5px;" xmlns="http://www.w3.org/2000/svg"
                class="icon icon-tabler icon-tabler-filter-search" width="24" height="24" viewBox="0 0 24 24"
                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path
                    d="M11.36 20.213l-2.36 .787v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414" />
                <path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                <path d="M20.2 20.2l1.8 1.8" />
            </svg>
            Filter Pipeline
        </h2>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="col-md-6 col-xl-12">


            <form method="GET" action="/console/pipeline" id="form-salesorder">
                <div class="mb-3">
                    <label class="form-label">PIC Name</label>
                    <div class="input-icon mb-3">
                        <input type="text" value="" name="pic_name" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Year Created</label>
                    <select type="text" class="form-select" name="year">
                        <option value="">Select Year</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Month Created</label>
                    <select type="text" class="form-select" name="month">
                        <option value="">Select Month</option>
                        <option value="01">Januari</option>
                        <option value="02">Februari</option>
                        <option value="03">Maret</option>
                        <option value="04">April</option>
                        <option value="05">Mei</option>
                        <option value="06">Juni</option>
                        <option value="07">Juli</option>
                        <option value="08">Agustus</option>
                        <option value="09">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>


                <!-- <div class="mb-3">
                    <label class="form-label">Position Name</label>
                    <div class="input-icon mb-3">
                        <input type="text" value="" name="position_name" class="form-control">
                    </div>
                </div> -->

                <div class="mb-3">
                    <label class="form-label">Created By</label>
                    <select type="text" class="form-select" name="sales_pic">
                        <option value="">Choose PIC Sales</option>
                        @forelse($sales_pic as $sales)
                            <option value="{{ $sales->id }}">{{ $sales->first_name }} {{ $sales->last_name }}
                            </option>
                        @empty
                            <option value="">No Sales Found</option>
                        @endforelse
                    </select>
                </div>




        </div>
        <div class="mt-3">
            <button class="btn btn-primary" type="submit" data-bs-dismiss="offcanvas">
                Filter
            </button>
        </div>
        </form>
    </div>
</div>





<style type="text/css">
    .ts-dropdown {
        top: 330px;
        padding-left: 20px;
    }

    .form-selectgroup-label {
        text-align: left;
    }

</style>


<script type="text/javascript">
    $(document).ready(function () {

        $.ajaxSetup({
            headers: {

                'X-CSRF-TOKEN': $('#form-like  ').find('input[name="_token"]').first().val()
            }
        });




    });

</script>
