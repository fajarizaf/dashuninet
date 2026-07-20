<div class="modal modal-blur fade" id="modal-addpromo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <form method="POST" action="/console/promo/create" id="form-project">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                <div class="modal-header">
                    <h5 class="modal-title">New Promo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label class="form-label">Promotion Code</label>
                                    <input type="text" class="form-control text_code" name="promo_code" required>
                                </div>
                                <div class="col-lg-8">
                                    <label class="form-label">Generate Code</label>
                                    <a href="#" class="btn btn-warning generate_code" name="generate_code">Auto Generate Code</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Promotion Label</label>
                                <input type="text" class="form-control" name="promo_label" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Promotion Type</label>
                                <select name="promo_type" class="form-control promo_type" required>
                                    <option value="Percentage">Percentage</option>
                                    <option value="Fixed Amount">Fixed Amount</option>
                                    <option value="Free Month">Free Month</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Promotion Description</label>
                        <textarea class="form-control" name="promo_description" placeholder=""></textarea>
                    </div>

                </div>

                <div class="modal-body" style="background:#efefef">

                    <div class="row">

                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Subscription Month - <small>Minimum berlangganan</small></label>
                                <select name="subscription_month" class="form-control">
                                    <option value="1">1 Month</option>
                                    <option value="2">2 Month</option>
                                    <option value="3">3 Month</option>
                                    <option value="4">4 Month</option>
                                    <option value="5">5 Month</option>
                                    <option value="6">6 Month</option>
                                    <option value="7">7 Month</option>
                                    <option value="8">8 Month</option>
                                    <option value="9">9 Month</option>
                                    <option value="10">10 Month</option>
                                    <option value="11">11 Month</option>
                                    <option value="12">12 Month</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label box-label">Discount (%)</label>
                                <div class="box-value">
                                    <input type="text" name="value" class="form-control" placeholder="percentage" />
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="modal-body">
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="row">
                                <span class="col">Free Setup ( Biaya Pasang )</span>
                                <span class="col-auto">
                                    <label class="form-check form-check-single form-switch">
                                        <input class="form-check-input" name="free_setup" type="checkbox" value="1" checked="">
                                    </label>
                                </span>
                            </label>
                            <br />
                            <br />
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Start Date</label>
                                        <input class="form-control" name="start_date" type="date">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">End Date</label>
                                        <input class="form-control" name="end_date" type="date">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Maximum User</label>
                                <input type="text" name="max_user" class="form-control" />
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Is Active</label>
                                <select name="is_active" class="form-control">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
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

<script type="text/javascript">
    $(document).ready(function() {

        $('.promo_type').change(function() {
            var type = $(this).val();
            if (type == 'Percentage') {
                $('.box-label').html('Discount(%)');
                $('.box-value').html('<input type="text" name="value" class="form-control value" placeholder="percentage" />');
            }
            if (type == 'Fixed Amount') {
                $('.box-label').html('Discount(IDR)');
                $('.box-value').html('<input type="text" name="value" class="form-control value" placeholder="IDR." />');
            }
            if (type == 'Free Month') {
                $('.box-label').html('Free Month');
                $('.box-value').html('<select name="subscription_month" class="form-control"><option value="1">1 Month</option><option value="2">2 Month</option><option value="3">3 Month</option><option value="4">4 Month</option><option value="5">5 Month</option><option value="6">6 Month</option><option value="7">7 Month</option><option value="8">8 Month</option><option value="9">9 Month</option><option value="10">10 Month</option><option value="11">11 Month</option><option value="12">12 Month</option></select><br/><label class="form-label">Period Free</label><select name="period_free" class="form-control" <label class="form-label">End Date</label>><option value="First Month">First Month</option><option value="Last Month">Last Month</option></select>');

            }

        })

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('#form-project').find('input[name="_token"]').first().val()
            }
        });


        $('.generate_code').click(function() {

            $.ajax({

                type: 'GET'
                , url: "{{ route('generate_promo_code') }}"
                , success: function(data) {
                    $('.text_code').val(data);
                }
            });


        });


    });

</script>
