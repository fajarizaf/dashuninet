@extends('layouts.console')
@section('container')

<header class="navbar navbar-expand-md">
    <div class="container-xl">
        <div class="d-md-none">Tab Menus</div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu-01" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse pb-2 pb-md-0" id="navbar-menu-01">
            <div class="row flex-fill align-items-center g-2 justify-content-between">
                <div class="col-12 col-md-auto">
                    <ul class="navbar-nav">
                        <li class="nav-item @if(Request::segment(4) == 'open') active @else @endif">
                            <a class="nav-link" href="{{ url('/console/ticket/list/open') }}" title="Ticket Opened">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-ticket" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M15 5l0 2" /><path d="M15 11l0 2" /><path d="M15 17l0 2" /><path d="M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-3a2 2 0 0 0 0 -4v-3a2 2 0 0 1 2 -2" /></svg>
                                </span>
                                <span class="nav-link-title">Ticket Opened</span>
                            </a>
                        </li>
                        <li class="nav-item @if(Request::segment(4) == 'close') active @else @endif">
                            <a class="nav-link" href="{{ url('/console/ticket/list/close') }}" title="Ticket Closed">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-ticket" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M15 5l0 2" /><path d="M15 11l0 2" /><path d="M15 17l0 2" /><path d="M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-3a2 2 0 0 0 0 -4v-3a2 2 0 0 1 2 -2" /></svg>
                                </span>
                                <span class="nav-link-title">Ticket Closed</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>

@forelse($data as $raw)
    <div class="page-body">
        <div class="container-xl">
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

            @if(session()->has('fraud'))
                <div class="alert alert-important alert-warning alert-dismissible" role="alert">
                    <div class="d-flex">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 9v4"></path><path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z"></path><path d="M12 16h.01"></path></svg>
                        </div>
                        <div>
                            {{ session('fraud') }}
                        </div>
                    </div>
                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header row g-1">
                    <div class="col-12 col-sm-auto me-auto mb-3 mb-sm-0">
                        <h3 class="card-title">Ticket ID : <span class="badge border border-secondary">{{ $raw->ticket_number }}</span></h3>
                    </div>

                    <div class="col-auto d-print-none">
                        <a href="#">
                            <button type="button" class="btn btn-info" style="float:right;">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-download"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 11l5 5l5 -5" /><path d="M12 4l0 12" /></svg>
                                Download SPK
                            </button>
                        </a>
                    </div>

                    @if(session('role_id') != 7)
                    <div class="col-auto d-print-none">
                        <a href="{{ url('/console/ticket/set_close/'.$raw->id) }}">
                            <button type="button" class="btn btn-warning" style="float:right;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-autofit-right" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M20 12v-6a2 2 0 0 0 -2 -2h-12a2 2 0 0 0 -2 2v8" /><path d="M4 18h17" /><path d="M18 15l3 3l-3 3" /></svg>
                                Close Ticket
                            </button>
                        </a>
                    </div>
                    @endif
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="row g-3 g-sm-1 g-md-3">
                                <div class="col-12 col-sm-3 col-lg-2">
                                    <div class="datagrid-title">Status</div>
                                    <span class="badge bg-azure text-azure-fg">{{ $raw->status_name }}</span>
                                </div>
                                <div class="col-12 col-sm-2 col-lg-1 col-xl-2">
                                    <div class="datagrid-title">Priority</div>
                                    <div class="datagrid-content">

                                        @if($raw->priority == 'High')
                                            <span class="badge bg-red text-red-fg">High</span>
                                        @endif

                                        @if($raw->priority == 'Low')
                                            <span class="badge bg-azure text-azure-fg">Low</span>
                                        @endif

                                        @if($raw->priority == 'Medium')
                                            <span class="badge bg-yellow text-yellow-fg">Medium</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 col-sm-3">
                                    <div class="datagrid-title">Department</div>
                                    <label class="form-label">{{ $raw->department_name }}</label>
                                </div>
                                <div class="col-12 col-sm-4 col-lg-3">
                                    <div class="datagrid-title">Customer Name</div>
                                    <label class="form-label">{{ $raw->customer_name }}</label>
                                </div>
                                <div class="col-12 col-lg-3 col-xl-2 ms-auto">
                                    <div class="datagrid-title">Created Date</div>
                                    <label class="form-label">{{ $raw->created_at }}</label>
                                </div>
                            </div>
                            <hr class="my-3 border-0 pt-1 bg-primary" />
                        </div>
                        <div class="col-12 d-sm-flex justify-content-between gap-1">
                            @if($raw->attachment)
                                <a href="{{ url('/console/ticket/attachment/download/'.$raw->attachment) }}">
                                    <button type="button" class="btn btn-outline-primary w-100"
                                        style="width:220px !important;">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/printer -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-link" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M9 15l6 -6" />
                                            <path d="M11 6l.463 -.536a5 5 0 0 1 7.071 7.072l-.534 .464" />
                                            <path
                                                d="M13 18l-.397 .534a5.068 5.068 0 0 1 -7.127 0a4.972 4.972 0 0 1 0 -7.071l.524 -.463" />
                                        </svg>
                                        Download Attachments
                                    </button>
                                </a>
                            @else
                            @endif

                            <div class="mt-3 mt-sm-0">
                                @if($signed_spk_is_empty = true)
                                    <div class="input-group">
                                        <input type="file" class="form-control">
                                        <button class="btn btn-teal">Upload Signed SPK</button>
                                    </div>

                                @else
                                    <button class="btn btn-outline-teal">
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-download"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 11l5 5l5 -5" /><path d="M12 4l0 12" /></svg>
                                        Download Signed SPK
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <br />

                    <div>
                        <div class="form-label">Subject :</div>
                        <h3>{{ $raw->title }}</h3>
                    </div>

                    <div>
                        <div class="form-label">Message :</div>
                        <div class="chat-bubble chat-bubble-me">{{ $raw->message }}</div>
                    </div>
                </div>
                <div class="card-footer bg-muted-lt">
                    <form enctype="multipart/form-data" method="POST" action="/console/ticket/reply" id="form-ticket">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="ticket_id" value="{{ $raw->id }}" />

                        <h3 class="card-title">Reply Ticket</h3>

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Message</label>
                                <textarea class="form-control" name="message" rows="5" required="required" placeholder="Reply Message"></textarea>
                            </div>
                            <div class="col-12">
                                <div class="row g-3">
                                    <div class="col-12 col-sm-5 col-md-3 col-lg-2">
                                        <div class="form-label">Status</div>
                                        <select class="form-select" name="status_ticket">
                                            <option selected value="2">Admin Reply</option>
                                            <option value="4">Closed</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-7 col-md-6 col-xxl-5">
                                        <div class="form-label">Upload Attachments</div>
                                        <input type="file" name="upload" class="form-control">
                                    </div>
                                    <div class="col-12 col-md-3 col-lg-4 col-xxl-5 mt-4 mt-md-0 text-md-end align-self-md-end">
                                        <input type="submit" class="btn btn-primary" value="Reply Ticket" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            </br>

            <div class="fs-3 fw-bold my-3">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-history"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 8l0 4l2 2" /><path d="M3.05 11a9 9 0 1 1 .5 4m-.5 5v-5h5" /></svg>
                Ticket History
            </div>

            @forelse($reply as $rep)
                <div class="card my-2 shadow-sm">
                    <div class="ribbon bg-muted-lt">{{ $rep->created_at }}</div>
                    <div class="card-body">
                        <div class="row g-3 mt-3 mt-md-0">
                            <div class="col-12 col-md-3 border-end border-1">
                                <div class="row g-2">
                                    <div class="col-auto col-md-3 col-xl-2">
                                        @if(empty($rep->created_by_position) === true)
                                        <div class="avatar bg-info text-white">
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                                        </div>
                                        @else
                                        <div class="avatar bg-orange text-white">
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user-shield"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 21v-2a4 4 0 0 1 4 -4h2" /><path d="M22 16c0 4 -2.5 6 -3.5 6s-3.5 -2 -3.5 -6c1 0 2.5 -.5 3.5 -1.5c1 1 2.5 1.5 3.5 1.5z" /><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /></svg>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-auto col-md-9 col-xl-10">
                                        <div class="font-weight-medium">{{ $rep->created_by_name }}</div>
                                        @if($rep->created_by_position == '')
                                            <div class="text-secondary small">Customer</div>
                                        @else
                                            <div class="text-secondary small">{{ $rep->created_by_position }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-7 col-xl-8">
                                <div class="text-secondary p-md-2">{{ $rep->message }}</div>
                            </div>
                        </div>
                    </div>
                    @if($rep->attachment)
                        <div class="card-footer py-3">
                            <a href="@if($rep->attachment) {{ url('/console/ticket/attachment/download/'.$rep->attachment) }} @else # @endif" class="rounded btn btn-sm btn-outline-cyan">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-link" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M9 15l6 -6" /><path d="M11 6l.463 -.536a5 5 0 0 1 7.071 7.072l-.534 .464" /><path d="M13 18l-.397 .534a5.068 5.068 0 0 1 -7.127 0a4.972 4.972 0 0 1 0 -7.071l.524 -.463" /></svg>
                                Download Attachments
                            </a>
                        </div>
                    @endif
                </div>
            @empty
            @endforelse

            <div class="card-footer d-flex align-items-center">
                <ul class="pagination m-0 ms-auto">
                    {{ $reply->appends(request()->query())->links() }}
                </ul>
            </div>

        </div>



    </div>
@empty
@endforelse

<style>
    .navbar-overlap:after {
        height: 0px !important;
    }

    .btnactive {
        background-color: #206bc4;
        color: #fff;
    }

</style>

<script type="text/javascript">
    $(document).ready(function () {
                $(".bton("
                    click ", function ()    this.form.submit();
                }

</script>



@endsection
