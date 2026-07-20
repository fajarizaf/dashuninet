@extends('layouts.console')
@section('container')

@include('component.canvas.navbar-customer')

<div class="page-body">

    <div class="container-xl">


        <br />

        <form method="POST" action="{{ url('/console/invoices/batch_publish') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <div class="card">

                <div class="card-header d-flex align-items-center">
                    <h3 class="card-title">My Downline Member</h3>
                    <ul class="pagination m-0 ms-auto">
                        {{ $data->appends(request()->query())->links() }}
                    </ul>
                </div>


                @if(session()->has('success'))
                    <div class="alert alert-important alert-info alert-dismissible" style="border-radius:0px;"
                        role="alert">
                        <div class="d-flex">
                            <div>
                                <!-- Download SVG icon from http://tabler-icons.io/i/info-circle -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M5 12l5 5l10 -10"></path>
                                </svg>
                            </div>
                            <div>
                                {{ session('success') }}
                            </div>
                        </div>
                        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
                @endif

                @if(session()->has('failed'))
                    <div class="alert alert-important alert-danger alert-dismissible" style="border-radius:0px;"
                        role="alert">
                        <div class="d-flex">
                            <div>
                                <!-- Download SVG icon from http://tabler-icons.io/i/info-circle -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M5 12l5 5l10 -10"></path>
                                </svg>
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
                                <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M12 9v4"></path>
                                    <path
                                        d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z">
                                    </path>
                                    <path d="M12 16h.01"></path>
                                </svg>
                            </div>
                            <div>
                                {{ session('fraud') }}
                            </div>
                        </div>
                        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
                @endif


            </div>
        </form>

        <br />

        <div class="row row-cards">

            @forelse($data as $cus)

                <div class="col-md-12 col-lg-6">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-auto">
                                    @if($cus->customer_photo != '')
                                        <span class="avatar avatar-xl rounded"
                                            style="background-image: url('{{ env('BACKEND_URL') }}/image/get/ums/{{ $cus->customer_photo }}')"></span>
                                    @else
                                        <span class="avatar avatar-xl mb-3 rounded" style="">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-user-circle">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                                <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                                <path
                                                    d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                                            </svg> </span>
                                    @endif
                                </div>
                                <div class="col">
                                    <table class="tables">
                                        <tbody>
                                            <tr>
                                                <td>Member Name</td>
                                                <td>&nbsp; :&nbsp;</td>
                                                <td>{{ $cus->customer_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Member Status</td>
                                                <td>&nbsp; :&nbsp;</td>
                                                <td>{{ $cus->status }}</td>
                                            </tr>
                                            <tr>
                                                <td>Downline</td>
                                                <td>&nbsp; :&nbsp;</td>
                                                <td>{{ $cus->count_downline }} Member</td>
                                            </tr>
                                            <tr>
                                                <td>Total Subscription</td>
                                                <td>&nbsp; :&nbsp;</td>
                                                <td>{{ $cus->count_order }} Subscription</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-auto text-right">
                                    <button type="button" class="btn btn-sm mb-3">{{ $cus->product_name }}
                                        member</button>
                                    <div class="mb-1">Member Point :</div>
                                    <div class="mb-3 h2">{{ (int) $cus->points }}</div>
                                    <a class="btn btn-primary"
                                        href="{{ url('/console/customer/detail/'.$cus->id) }}">Detail</a>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            @empty
                <p class="text-center">No Data Downline Member</p>
            @endforelse

        </div>

        <br />


        <div class="card-footer d-flex align-items-center">
            <ul class="pagination m-0 ms-auto">
                {{ $data->appends(request()->query())->links() }}
            </ul>
        </div>


    </div>

</div>

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
        $(".btn_filter").on("click", function () {
            this.form.submit();
        });
    });

</script>

<script>
    $(document).ready(function () {

        $.ajaxSetup({
            headers: {

                'X-CSRF-TOKEN': $('#form-pipeline').find('input[name="_token"]').first().val()

            }
        });

    });

</script>




@endsection
