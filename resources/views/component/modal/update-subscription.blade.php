<div class="modal modal-blur fade" id="modal-update-subscription" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">


            <form method="POST" action="/console/subscription/set_update">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="order_id" value="{{ Request::segment(4) }}" />
                <input type="hidden" name="subscription_id"  id="dt_subscription_id" value="-" />

                <div class="modal-header">
                    <h5 class="modal-title">Detail Subscription</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>



                <div class="card" style="border:none;">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="#tabs-home-7" class="nav-link active" data-bs-toggle="tab" aria-selected="true"
                                    role="tab"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M5 12l-2 0l9 -9l9 9l-2 0"></path>
                                        <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"></path>
                                        <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"></path>
                                    </svg>
                                    Data</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="#tabs-profile-7" class="nav-link" data-bs-toggle="tab" aria-selected="false"
                                    role="tab"
                                    tabindex="-1"><!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                    </svg>
                                    Operational Activity</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body subscription-body">
                        <div class="tab-content">
                            <div class="tab-pane active show" id="tabs-home-7" role="tabpanel">


                                <div class="modal-body">


                                    <div class="d-flex py-1 align-items-center">
                                        <span class="avatar me-2"
                                            style="background-image: url(./static/avatars/010m.jpg)"></span>
                                        <div class="flex-fill">
                                            <div class="font-weight-medium product_name"></div>
                                            <div class="text-secondary"><a href="#"
                                                    class="text-reset product_plan"></a></div>
                                        </div>

                                        <div class="py-1 align-items-center">
                                            <span class="text=secondary">Status :</span>
                                            <a href="#" class="btn w-100 status_name">
                                            </a>

                                        </div>

                                    </div>


                                </div>

                                <div class="modal-body ">

                                    <div class="accordion" id="accordion-example">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="heading-1">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapse-1"
                                                    aria-expanded="false">
                                                    Product Information Field
                                                </button>
                                            </h2>
                                            <div id="collapse-1" class="accordion-collapse collapse"
                                                data-bs-parent="#accordion-example" style="">
                                                <div class="accordion-body pt-0">

                                                    <div style="padding-left:0px;" class="text-secondary">
                                                        <table id="subs_field">
                                                        </table>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <table class="table">
                                        <tr>
                                            <td>Subscription Number</td>
                                            <td>:</td>
                                            <td>
                                                <span class="text-reset subscription_number">
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Billing Account</td>
                                            <td>:</td>
                                            <td>
                                                <span class="text-reset billing_account"> 
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Subscription Date</td>
                                            <td>:</td>
                                            <td><span class="text-reset created_at"></span></td>
                                        </tr>
                                        <tr>
                                            <td>Billing Cycle</td>
                                            <td>:</td>
                                            <td><span class="text-reset billingcycle"></span></td>
                                        </tr>
                                        <tr>
                                            <td>Layanan Gratis?</td>
                                            <td>:</td>
                                            <td>
                                                <select name="is_free" class="form-select is_free">
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Reccuring Amount</td>
                                            <td>:</td>
                                            <td>
                                                <input type="text" class="form-control" name="amount amount"
                                                    value="" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-file-text" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                    <path
                                                        d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                                    <path d="M9 9l1 0" />
                                                    <path d="M9 13l6 0" />
                                                    <path d="M9 17l6 0" />
                                                </svg>
                                                Next Invoices<br />
                                                <span class="text-secondary" style="font-size:10px;">Tanggal terbit
                                                    tagihan
                                                    berikutnya</span>
                                            </td>
                                            <td>:</td>
                                            <td>
                                                
                                                <div class="row g-2">
                                                <div class="col-4">
                                                    <select name="next_year" class="form-select">
                                                        <option value="{{\Carbon\Carbon::parse($subs->next_due_date)->format('Y')}}">{{\Carbon\Carbon::parse($subs->next_due_date)->format('Y')}}</option>
                                                        <option value="2024">2024</option>
                                                        <option value="2025">2025</option>
                                                        <option value="2026">2026</option>
                                                        <option value="2027">2027</option>
                                                        <option value="2028">2028</option>
                                                        <option value="2029">2029</option>
                                                        <option value="2030">2030</option>
                                                        <option value="2031">2031</option>
                                                        <option value="2032">2032</option>
                                                        <option value="2033">2033</option>
                                                        <option value="2034">2034</option>
                                                    </select>
                                                </div>
                                                <div class="col-4">
                                                    <select name="next_month" class="form-select">
                                                        <option value="{{\Carbon\Carbon::parse($subs->next_due_date)->format('m')}}">{{\Carbon\Carbon::parse($subs->next_due_date)->format('m')}}</option>
                                                        <option value="01">01</option>
                                                        <option value="02">02</option>
                                                        <option value="03">03</option>
                                                        <option value="04">04</option>
                                                        <option value="05">05</option>
                                                        <option value="06">06</option>
                                                        <option value="07">07</option>
                                                        <option value="08">08</option>
                                                        <option value="09">09</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                    </select>
                                                </div>
                                                <div class="col-3">
                                                    <input type="text" value="01" disabled class="form-control" />
                                                </div>
                                                </div>
                                            
                                            </td>
                                            
                                        </tr>
                                        <tr>
                                            <td>Date Live</td>
                                            <td>:</td>
                                            <td>
                                                <span class="badge bg-green text-green-fg">
                                                    <span class="badge bg-green text-green-fg complete_date">
                                                    </span>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Expired Date</td>
                                            <td>:</td>
                                            <td>
                                                <span class="expired_date"></span>
                                            </td>
                                        </tr>
                                        <tr class="stat2">
                                        </tr>
                                        <tr class="note2">
                                        </tr>

                                    </table>

                                </div>

                            </div>
                            <div class="tab-pane" id="tabs-profile-7" role="tabpanel">

                                <div class="card-body">

                                    <div class="btn btn-info active w-100" style="width:100%:">
                                        Activity List
                                    </div>

                                    <br/>
                                    <br/>

                                    <ul class="steps steps-vertical" id="subs_activity">
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>



                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Update</button>
                </div>
            </form>
        </div>
    </div>

</div>