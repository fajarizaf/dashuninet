@extends('layouts.console')
@section('container')


<!-- Page header -->
<div class="page-header d-print-none text-white">
    <div class="container-xl">
        <div class="row g-3 align-items-center justify-content-between">
            <div class="col-auto col-sm-5 col-md-6 col-lg-auto">
                <div class="page-pretitle">Redem Number</div>
                <h2 class="page-title">{{$detail->id}}</h2>
            </div>
            <div class="col-auto col-sm-7 col-md-6 col-lg-auto ms-auto d-print-none">
                <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ url('/') }}/console/redem/queue" class="btn btn-primary" title="Redem List">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-align-left m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M4 6l16 0" /><path d="M4 12l10 0" /><path d="M4 18l14 0" /></svg>
                        <span class="d-none d-sm-inline">&nbsp;Redem List</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-md-12 col-lg-8">
                @if(session()->has('success'))
                    <div class="alert alert-important alert-info alert-dismissible" style="border-radius:0px;" role="alert">
                        <div class="d-flex">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l5 5l10 -10"></path></svg>
                            </div>
                            <div>
                                {{ session('success') }}
                            </div>
                        </div>
                        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
                @endif

                @if(session()->has('failed'))
                    <div class="alert alert-important alert-danger alert-dismissible" style="border-radius:0px;" role="alert">
                        <div class="d-flex">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l5 5l10 -10"></path></svg>
                            </div>
                            <div>
                                {{ session('failed') }}
                            </div>
                        </div>
                        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-pills card-header-pills">
                            <li class="nav-item">
                            Membership Request Info
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">

                        <div class="datagrid">
                            <div class="datagrid-item">
                                <div class="datagrid-title">Redem ID</div>
                                <div class="datagrid-content">{{$detail->id}}</div>
                            </div>
                            <div class="datagrid-item text-center">
                                <div class="datagrid-title">Redem Date</div>
                                <div class="datagrid-content">{{date('Y-M-d', strtotime($detail->created_at))}}</div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Customer Name</div>
                                <div class="datagrid-content">{{$detail->customer_name}}</div>
                            </div>
                        </div>
                        <br />
                        <br />

                        <h3>Request Redem Item :</h3>

                        <div class="card">
                            <div class="table-responsive">
                                <table class="table table-vcenter table-mobile-md card-table">
                                    <thead>
                                        <tr>
                                            <th>Reward Name</th>
                                            <th>Reward Description</th>
                                            <th class="text-end">Point Requirement</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td class="py-2" data-label="Name">
                                                {{$detail->reward_name}}
                                            </td>
                                            <td class="py-2" data-label="Title">
                                                <div class="text-secondary">{{$detail->reward_description}}</div>
                                            </td>
                                            <td class="py-2 text-end" data-label="Promo">
                                                <span class="badge border-primary text-primary">{{$detail->reward_point}} Point</span>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <form method="POST" action="/console/redem/update" id="form-salesorder">


                <br />

                <h3>Shipping Address</h3>

                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-vcenter table-mobile-md card-table">
                            <thead>
                                <tr>
                                    <th>Shipment Address</th>
                                    <th class="text-center">Shipment AWB</th>
                                    <th class="text-end">Expedition Name</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>

                                    <td width="50%" class="py-2" data-label="Promo">
                                        {{$detail->shipment_address ?? '-'}}
                                    </td>

                                    <td width="30%" class="py-2" data-label="Promo">
                                        <input class="form-control" name="no_resi" value="{{$detail->shipment_awb}}" placeholder="Enter Shipment AWB *" required />
                                    </td>

                                    <td width="20%" class="py-2 text-end" data-label="Promo">

                                        @inject("Redem", "App\Http\Controllers\RedemController")

                                        <select class="form-control" name="expedition_id">
                                            @if($detail->expedition_id != '')
                                                <option selected="selected" value="{{$detail->expedition_id}}">{{ $Redem::get_expedition_name($detail->expedition_id) }}</option>
                                            @else
                                                <option value="">Select</option>
                                            @endif
                                            @forelse($expedition as $exp)
                                                <option value="{{$exp->id}}">{{$exp->expedition_name}}</option>
                                            @empty

                                            @endforelse
                                        </select>

                                    </td>

                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>


                <br />

                <h3>Redem Point Transaction</h3>

                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-vcenter table-mobile-md card-table">
                            <thead>
                                <tr>
                                    <th>Transaction Type</th>
                                    <th class="text-center">Transaction Date</th>
                                    <th class="py-2">Point Deducted</th>
                                    <th class="text-end">Status</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse($redem_transaction as $transaction)
                                <tr>

                                    <td width="50%" class="py-2" data-label="Transaction Type">
                                        @if($transaction->amount_in == '')
                                            Debit Point
                                        @else
                                            Credit Point
                                        @endif
                                    </td>

                                    <td width="50%" class="py-2 text-center" data-label="Transaction Date">
                                        {{date('Y-M-d', strtotime($transaction->created_at))}}
                                    </td>

                                    <td width="30%" class="py-2 text-center" data-label="Point Deducted">
                                        <span class="badge text-danger border border-danger">
                                            @if($transaction->amount_in == '')
                                                - {{$transaction->amount_out}}
                                            @else
                                                + {{$transaction->amount_in}}
                                            @endif
                                        </span>
                                    </td>

                                    <td width="20%" class="py-2 text-end" data-label="Status">
                                        <span class="badge text-bg-success">Succeed</span>
                                    </td>

                                </tr>
                                @empty
                                <tr>
                                    <td class="py-2" colspan="3">No Transaction Found</td>
                                </tr>
                                @endforelse


                            </tbody>
                        </table>
                    </div>
                </div>


                <br />

                <div class="card-body">
                    <h3 class="card-title">Admin Activity</h3>
                    <ul class="steps steps-vertical">
                        @forelse($admin_activity as $activity)
                        <li class="step-item">
                            <div class="h4 m-0">{{$activity->log_label}} - <span class="text-secondary">{{date('Y-M-d
                                    H:i:s', strtotime($activity->created_at))}}</span></div>
                            <div class="text-secondary">{{$activity->log_entry}}</div>
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

            <div class="col-md-6 col-lg-4">

                <div class="card-tabs">
                    <!-- Cards navigation -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation"><a href="#tab-top-1" class="nav-link active"
                                data-bs-toggle="tab" aria-selected="true" role="tab">Status Activity</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!-- Content of card #1 -->
                        <div id="tab-top-1" class="card tab-pane active show" role="tabpanel">
                            <div class="card-body">

                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <input type="hidden" name="redem_id" value="{{ Request::segment(4) }}" />

                                    @if(session('role_id') == 2 || session('role_id') == 3)
                                    <div class="form-floating" style="width:100%;border-radius:4px">
                                        <select class="form-select" name="action_type" id="action_type"
                                            aria-label="Floating label select example">
                                            <option value="{{$detail->status_id}}">{{$detail->status_name}}</option>
                                            <option value="1005">Pending</option>
                                            <option value="1037">Process</option>
                                            <option value="1049">Shipment</option>
                                            <option value="1035">Complete</option>
                                            <option value="1050">Rejected</option>
                                        </select>
                                        <label for="floatingSelect">Request Redem Status</label>
                                    </div>
                                    @else
                                        <p class="datagrid-title">Request Redem Status :</p>
                                        <div class="h3 m-0">{{$detail->status_name}}</div>
                                    @endif

                            </div>
                        </div>

                    </div>
                </div>

                <br />

                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Redem Notes</h3>

                        <textarea id="redem_notes" name="redem_notes" class="form-control" placeholder="Redem Notes">{{$detail->redem_note}}</textarea>

                    </div>
                    <!-- Card footer -->
                    <div class="card-footer">
                        @if(session('role_id') == 3)
                            <input type="submit" class="btn btn-primary" value="Update" />
                        @else

                        @endif
                    </div>
                </div>

                </form>

            </div>

        </div>

    </div>

</div>

@if(session('role_id') == 3)

@endif



<style type="text/css">
.table-responsive {
    overflow: visible;
}
.mod {
    max-width: 60% !important;
}

.subscription-body {
    padding:0px !important;
}
</style>


@endsection
