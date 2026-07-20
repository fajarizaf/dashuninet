<div class="modal modal-blur fade" id="modal-invoices" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered mod" role="document">

        <div class="modal-content">


            <form method="POST" action="/console/invoices/update" id="form-salesorder">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="modal-header">
                    <h5 class="modal-title">Detail Invoices</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>


                <div class="card" style="border:none;">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="#tabs-home-5" class="nav-link active" data-bs-toggle="tab" aria-selected="true"
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
                                <a href="#tabs-profile-5" class="nav-link" data-bs-toggle="tab" aria-selected="false"
                                    role="tab"
                                    tabindex="-1"><!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                    </svg>
                                    Finance Activity</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body subscription-body">
                        <div class="tab-content">
                            <div class="tab-pane active show" id="tabs-home-5" role="tabpanel">

                                <div class="modal-body">
                                    @if(count($invoices) != 0)
                                    @forelse($invoices as $inv)

                                    <input type="hidden" name="invoice_id" value="{{$inv->id}}" />
                                    <input type="hidden" name="order_id" value="{{ Request::segment(4) }}" />

                                    <div class="d-flex py-1 align-items-center">

                                        <div class="flex-fill">
                                            <div class="font-weight-medium">
                                                <div class="row">
                                                    <div class="col-md-8">

                                                        <table>
                                                            <tr>
                                                                <td>Invoice ID</td>
                                                                <td style="width:20px">:</td>
                                                                <td>
                                                                    @if($inv->invoice_number == '')
                                                                    <span class="badge bg-azure-lt">{{$inv->id}}</span>
                                                                    @else
                                                                    <span
                                                                        class="badge bg-green-lt">{{$inv->invoice_number}}</span>
                                                                    @endif
                                                                </td>
                                                                <td>&nbsp;</td>
                                                                <td>&nbsp;</td>
                                                                <td>&nbsp;</td>
                                                                <td>&nbsp;</td>
                                                                <td>&nbsp;</td>
                                                                <td>&nbsp;</td>
                                                                <td>Invoice Date</td>
                                                                <td style="width:20px">:</td>
                                                                <td>
                                                                    <input class="form-control" name="invoice_date"
                                                                        type="date" value="{{$inv->invoice_date}}" />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Published</td>
                                                                <td style="width:20px">:</td>
                                                                <td>
                                                                    @if($inv->is_publish == 0)
                                                                    <span class="badge badge-outline text-azure">
                                                                        Draft
                                                                    </span>
                                                                    @else
                                                                    <span class="badge bg-green text-green-fg">
                                                                        Publish
                                                                    </span>
                                                                    @endif
                                                                </td>
                                                                <td>&nbsp;</td>
                                                                <td>&nbsp;</td>
                                                                <td>&nbsp;</td>
                                                                <td>&nbsp;</td>
                                                                <td>&nbsp;</td>
                                                                <td>&nbsp;</td>
                                                                <td>Invoice Due Date</td>
                                                                <td style="width:20px">:</td>
                                                                <td>
                                                                    <input class="form-control" name="invoice_duedate" type="date" value="{{$inv->invoice_duedate}}" />
                                                                </td>
                                                            </tr>
                                                        </table>

                                                    </div>
                                                    <div class="col-md-4">

                                                       <p>Pergi ke halaman detail invoices</p>
                                                       <a href="{{ url('/console/invoices/detail/'.$inv->id) }}" class="btn btn-secondary" >Go To Page</a>

                                                    </div>
                                                </div>


                                            </div>



                                        </div>
                                    </div>

                                </div>

                                <div class="modal-body" style="background:#f9f9f9">


                                    <table class="table table-vcenter table-mobile-md card-table">
                                        <thead>
                                            <tr>
                                                <th style="background:none">Item Name</th>
                                                <th style="background:none;width:15%;">Unit Price</th>
                                                <th style="background:none;">Quantity</th>
                                                <th style="background:none;width:15%;">Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @forelse($invoices_item as $inv_item)
                                            <input type="hidden" name="invoice_item_id[]" value="{{$inv_item->id}}" />
                                            <tr>
                                                <td data-label="Name">
                                                    <div class="d-flex py-1 align-items-center">
                                                        <span class="avatar me-2"
                                                            style="background-image: url(./static/avatars/010m.jpg)"></span>
                                                        <div class="flex-fill">
                                                            <div class="font-weight-medium">{{$inv_item->item_name}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td data-label="Title">IDR. {{number_format($inv_item->amount, 0)}}
                                                </td>
                                                <td class="text-secondary" data-label="Promo">
                                                    {{$inv_item->quantity}}
                                                </td>
                                                <td class="text-secondary" data-label="Promo">IDR. {{number_format($inv_item->quantity *
                                                    $inv_item->amount, 0)}}</td>
                                            </tr>
                                            @empty

                                            @endforelse

                                            <tr>
                                                <td class="text-secondary" data-label="Promo" colspan="3"
                                                    style="text-align:right;">
                                                    Sub Total
                                                </td>
                                                <td class="text-secondary" data-label="Promo">IDR. {{number_format($inv->subtotal, 0)}}</td>
                                            </tr>

                                            <tr>
                                                <td class="text-secondary" data-label="Promo" colspan="3"
                                                    style="text-align:right;">
                                                    Tax
                                                </td>
                                                <td class="text-secondary" data-label="Promo">{{$inv->tax}} %</td>
                                            </tr>

                                            <tr>
                                                <td class="text-secondary" data-label="Promo" colspan="3"
                                                    style="text-align:right;">
                                                    Total
                                                </td>
                                                <td class="text-secondary" data-label="Promo">IDR. {{number_format($inv->total, 0)}}
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>

                                    @empty

                                    @endforelse

                                </div>

                            </div>
                            <div class="tab-pane" id="tabs-profile-5" role="tabpanel">

                                <div class="card-body" style="min-height:500px;">

                                    <div class="btn btn-info active w-100" style="width:100%:">
                                        Activity List
                                    </div>

                                    <br />
                                    <br />

                                    <ul class="steps steps-vertical">
                                        @forelse($finance_activity as $activityd)
                                        <li class="step-item">
                                            <div class="h4 m-0">{{$activityd->log_label}} - <span
                                                    class="text-secondary">{{date('Y-M-d
                                                    H:i:s', strtotime($activityd->created_at))}}</span></div>
                                            <div class="text-secondary">{{$activityd->log_entry}}</div>
                                        </li>
                                        @empty
                                        <li class="step-item">
                                            <div class="h4 m-0">Empty Log Activity</span></div>
                                            <div class="text-secondary">Belum ada log tercatat</div>
                                        </li>
                                        @endforelse
                                    </ul>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>



                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    @if($inv->is_publish == 0)
                    <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Publish</button>
                    @else

                    @endif
                    @endif
                </div>
            </form>
        </div>
    </div>

</div>