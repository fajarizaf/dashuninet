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
            Filter Order
        </h2>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="col-md-6 col-xl-12">


            <form method="GET" action="/console/order" id="form-salesorder">

                <div class="mb-3">
                    <label class="form-label">Order Number</label>
                    <div class="input-icon mb-3">
                        <input type="text" value="" name="salesorder_number" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Customer Name</label>
                    <div class="input-icon mb-3">
                        <input type="text" value="" name="customer_name" class="form-control">
                    </div>
                </div>


                <div class="mb-3">
                    <label class="form-label">Select Product</label>
                    <select type="text" class="form-select" id="select-product-filter" name="product_name">
                        <option value="">Choose the Product</option>
                        @forelse($product_filter as $group)
                        <option value="{{$group->id}}">{{$group->product_name}} - {{$group->product_plan}} ( {{$group->product_type}} )
                            @empty
                        <option value="">No Product Found</option>
                        @endforelse
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Select Plan</label>

                    <div class="filter-plan">
                        <div class="alert alert-important alert-info alert-dismissible" role="alert">
                            <div class="d-flex">
                                <div><!-- Download SVG icon from http://tabler-icons.io/i/info-circle --><svg
                                        xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path>
                                        <path d="M12 9h.01"></path>
                                        <path d="M11 12h1v4h1"></path>
                                    </svg></div>
                                <div>Select the product first</div>
                            </div><a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>

                    </div>

                </div>

                <div class="mb-3">
                    <label class="form-label">Date Order</label>
                    <input type="date" class="form-control" id="select_orderdate" name="date_order">
                </div>


                <div class="mb-3">
                    <label class="form-label">Select Status</label>
                    <select type="text" class="form-select" name="status_id">
                        <option value="">Choose status</option>
                        <option value="1005">Pending</option>
                        <option value="1050">Rejected</option>
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

        'X-CSRF-TOKEN': $('#form-like  ').find('input[name="_token"]'
    }
});




});

</script>