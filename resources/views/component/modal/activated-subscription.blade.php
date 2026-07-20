<div class="modal modal-blur fade" id="modal-activated-subscription" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">


            <form method="POST" action="/console/subscription/set_active" >
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="order_id" value="{{ Request::segment(4) }}" />
                <input type="hidden" name="subscription_id"  id="ac_subscription_id" value="-" />
                
                <div class="modal-header">
                    <h5 class="modal-title">Detail Subscription</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <h1 class="font-weight-medium "></h1>
                </div>
                <div class="modal-body">

                    <div class="d-flex py-1 align-items-center">
                        <span class="avatar me-2" style="background-image: url(./static/avatars/010m.jpg)"></span>
                        <div class="flex-fill">
                            <div class="font-weight-medium product_name"></div>
                            <div class="text-secondary"><a href="#" class="text-reset product_plan"></a></div>
                        </div>

                        <div class="py-1 align-items-center">
                            <span class="text=secondary">Status :</span>
                                <a href="#" class="btn w-100 status_name">
                                </a>
                        </div>
                    </div>
                    

                </div>

                <div class="modal-body">

                    <div class="accordion" id="accordion-example">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading-1">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse-1" aria-expanded="false">
                                    Product Information Field
                                </button>
                            </h2>
                            <div id="collapse-1" class="accordion-collapse collapse" data-bs-parent="#accordion-example"
                                style="">
                                <div class="accordion-body pt-0">

                                    <div style="padding-left:0px;" class="text-secondary">
                                        <table class="subs_field">
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
                            <td><span class="text-reset created_at"></span>
                            <!-- <td><span class="text-reset">{{date('Y-M-d H:i:s', strtotime($subs->created_at))}}</span> -->
                            </td>
                        </tr>
                        <tr>
                            <td>Billing Cycle</td>
                            <td>:</td>
                            <td><span class="text-reset billingcycle"></span></td>
                        </tr>
                        <tr>
                            <td>Reccuring Amount</td>
                            <td>:</td>
                            <td>
                                <input type="text" class="form-control amount" name="amount" value="" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td>Date Live</td>
                            <td>:</td>
                            <td>
                                <input type="date" class="form-control" name="date_live" value="{{date('Y-m-d')}}" required>
                            </td>
                        </tr>
                        <tr class="stat">
                        </tr>
                        <tr class="note">
                        </tr>
                        
                        
                    </table>

                    

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    <div class="submit"></div>
                </div>
            </form>
        </div>
    </div>

</div>