@extends('layouts.console')
@section('container')



<!-- Page header -->
<div class="page-header d-print-none text-white">
    <div class="container-xl">
        <div class="row g-3 align-items-center">
            <div class="col-auto col-sm-7 col-md-6 col-lg-auto">
                <div class="d-flex gap-2 align-items-center justify-content-between justify-content-sm-start">
                    <div>
                        <div class="page-pretitle">Sales</div>
                        <h2 class="page-title">Pipeline</h2>
                    </div>
                </div>
            </div>
            <div class="col-auto col-sm-5 col-md-6 col-lg-auto ms-auto d-print-none">
                <div class="d-flex gap-2 justify-content-end">
                    <a class="btn btn-light ms-auto ms-sm-0" data-bs-toggle="offcanvas" href="#offcanvasStart"
                        role="button" aria-controls="offcanvasStart" id="btn-filter" title="Filter">
                        <svg style="margin-right:10px" xmlns="http://www.w3.org/2000/svg"
                            class="icon icon-tabler icon-tabler-filter-search m-0" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M11.36 20.213l-2.36 .787v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414" />
                            <path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                            <path d="M20.2 20.2l1.8 1.8" /> </svg>
                        <span class="d-sm-none d-md-inline">&nbsp;Filter</span>
                    </a>
                    @if(session('role_id') != 2)
                        <a href="#" id="btn-create-so" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modal-addpipeline" title="Create New pipeline">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" /></svg>
                            <span class="d-none d-lg-inline">&nbsp;Create New pipeline</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

    <div class="container-xl">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Records</h3>
            </div>

            @if(session()->has('success'))
                <div class="alert alert-important alert-info alert-dismissible" style="border-radius:0px;" role="alert">
                    <div class="d-flex">
                        <div>
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

            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Created By</th>
                            <th>Customer Name</th>
                            <th>Service Name</th>
                            <th>Date Created</th>
                            <th class="text-end" colspan="3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $raw)
                            <tr>
                                <td class="py-2">{{ $loop->iteration }}</td>
                                <td class="py-1"><span class="badge text-bg-success">{{ $raw->first_name }}
                                        {{ $raw->last_name }}</span></td>
                                <td class="py-1"><b>name :{{ $raw->pic_name }}</b></br>Telp : {{ $raw->telp }}<br />
                                    Email : {{ $raw->email }}</td>
                                <td class="py-2">
                                    {{ $raw->product_name ?? '-' }}
                                    <div class="text-secondary small">{{ $raw->product_plan }}</div>
                                </td>
                                <td class="py-1">{{ $raw->created_at }}</td>
                                <td class="py-2 text-end">
                                    <button class="btn btnedit btn-outline-primary" pipeline_id="{{ $raw->id }}"
                                        title="Detail">Detail</button>
                                    <button id="btn-create-so" class="btn btn-outline-teal" data-bs-toggle="modal"
                                        pipeline_id="{{ $raw->id }}" data-bs-target="#modal-report"
                                        title="Create SO">Create SO</button>
                                    <a href="{{ url('/console/pipeline/reject/'.$raw->id) }}"
                                        class="btn btn-outline-danger" title="Remove">Remove</a>
                                </td>
                            </tr>
                        @empty

                            <tr>
                                <td colspan="8">

                                    <div class="empty">
                                        <p class="empty-title">No results found</p>
                                        <p class="empty-subtitle text-secondary">
                                            Try adjusting your search or filter to find what you're looking for.
                                        </p>
                                        <div class="empty-action">
                                            <a href="#" class="btn btn-primary" data-bs-target="#modal-addpipeline"
                                                data-bs-toggle="modal">
                                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M12 5l0 14"></path>
                                                    <path d="M5 12l14 0"></path>
                                                </svg>
                                                Add your first Pipeline
                                            </a>
                                        </div>
                                    </div>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex align-items-center">
                <ul class="pagination m-0 ms-auto">
                    {{ $data->appends(request()->query())->links() }}
                </ul>
            </div>
        </div>
    </div>

</div>


@include('component.modal.add-salesorder-pipeline')
@include('component.modal.add-pipeline')
@include('component.modal.edit-pipeline')
@include('component.canvas.filter-pipeline')


<script>
    let map,
        marker;

    // Initializes google map
    function initMap() {

        console.log('Initializing map..');

        // Define map initial parameters
        const myLatlng = new google.maps.LatLng(-6.2749879, 106.8298682);
        const mapOptions = {
            zoom: 14,
            center: myLatlng,
            streetViewControl: true,
            fullscreenControl: true,
            mapTypeId: google.maps.MapTypeId.ROADMAP
            // mapTypeId: 'hybrid'
        }

        // Create map in "map" div
        map = new google.maps.Map(document.getElementById('map'), mapOptions);

        // Create marker
        marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            draggable: false,
            title: "Lokasi Customer"
        });

    }

    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('#form-pipeline').find("input[name='_token']").first().val()
            }
        });

        $('.btnedit').click(function () {

            var pipeline_id = $(this).attr('pipeline_id');
            $.ajax({
                type: 'POST',
                url: "{{ route('pipeline_detail') }}",
                data: {
                    pipeline_id: pipeline_id
                },
                success: function (data) {

                    $('#modal-editpipeline').modal('show');
                    $('.pipeline_id').val(data.id);
                    $('.pic_name').val(data.pic_name);
                    $('.sales_pic').val(data.first_name + ' ' + data.last_name);
                    $('.telp').val(data.telp);
                    $('.email').val(data.email);

                    if (data.pipeline_type == "submission") {
                        $('.submission').show();
                        $('.general').hide();

                        $(".position_name,.place_of_bussines,.exist_product,.price_product")
                            .attr("disabled", true);

                        $('.nama_jalan').val(data.nama_jalan);
                        $('.rt').val(data.rt);
                        $('.rw').val(data.rw);
                        $('.kelurahan').val(data.kelurahan);
                        $('.kecamatan').val(data.kecamatan);
                        $('.kabupaten').val(data.kabupaten);
                        $('.link_maps').val(data.link_maps);
                        $('.jenis_bangunan').val(data.jenis_bangunan);
                        $('.prod').html(data.product_name + ' ' + data.product_plan +
                            ' Rp. ' + numberWithCommas(data.price));

                        let ll = data.link_maps.split("=");
                        ll = ll[1].split(",");
                        console.log(ll[1]);

                        const latlng = new google.maps.LatLng(ll[0], ll[1]);
                        marker.setPosition(latlng);
                        map.setCenter(latlng);
                    } else {
                        $('.general').show();
                        $('.submission').hide();

                        $(".position_name,.place_of_bussines,.exist_product,.price_product")
                            .attr("disabled", false);

                        $('.position_name').val(data.position_name);
                        $('.place_of_bussines').val(data.place_of_bussines);
                        $('.area').val(data.area);
                        $('.exist_product').val(data.exist_product);
                        $('.price_product').val(data.price_product);
                        $('.bandwidth_product').val(data.bandwidth_product);
                        $('.keterangan').val(data.keterangan);
                    }
                }
            });
        });


        $(document).on('click', '#btn-create-so', function (e) {
            e.preventDefault();

            var pipeline_id = $(this).attr('pipeline_id');
            $.ajax({
                type: 'POST',
                url: "{{ route('pipeline_detail') }}",
                data: {
                    pipeline_id: pipeline_id
                },
                success: function (data) {
                    $('.pipeline_id').val(data.id);
                    $('.customer_name').val(data.pic_name);
                    $('.sales_pic').val(data.first_name + ' ' + data.last_name);
                    $('.customer_phone').val(data.telp);
                    $('.customer_email').val(data.email);

                    if (data.pipeline_type == "submission") {
                        $('.submission').show();
                        $('.general').hide();
                        // $('#select-product').val(1).change();
                        $('input[name="nama-jalan"]').val(data.nama_jalan);
                        $('input[name="rt"]').val(data.rt);
                        $('input[name="rw"]').val(data.rw);
                        $('input[name="kelurahan"]').val(data.kelurahan);
                        $('input[name="kecamatan"]').val(data.kecamatan);
                        $('input[name="kabupaten"]').val(data.kabupaten);
                        $('input[name="link-maps"]').val(data.link_maps);
                        $('input[name="jenis-bangunan"]').val(data.jenis_bangunan);
                        $('input[name="product_plan"]').val(data.product_id);
                        $('input[name="product_price"]').val(data.price);
                        $('.prod').html(data.product_name + ' ' + data.product_plan +
                            ' Rp. ' + numberWithCommas(data.price));
                        $("#select-product,#product_price").attr("disabled", true);
                        $(".input-submission").attr("disabled", false);
                    } else {
                        $('.general').show();
                        $('.submission').hide();
                        $("#select-product,#product_price").attr("disabled", false);
                        $(".input-submission").attr("disabled", true);
                    }
                }
            });

            var el;
            window.TomSelect && (new TomSelect(el = document.getElementById('select-product'), {
                copyClassesToDropdown: false,
                dropdownParent: '.modal-body',
                controlInput: '<input>',
                render: {
                    item: function (data, escape) {
                        if (data.customProperties) {
                            return '<div><span class="dropdown-item-indicator">' + data
                                .customProperties + '</span>' + escape(data.text) +
                                '</div>';
                        }
                        return '<div>' + escape(data.text) + '</div>';
                    },
                    option: function (data, escape) {
                        if (data.customProperties) {
                            return '<div><span class="dropdown-item-indicator">' + data
                                .customProperties + '</span>' + escape(data.text) +
                                '</div>';
                        }
                        return '<div>' + escape(data.text) + '</div>';
                    },
                },
            }));
        });
    });

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

</script>

<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCipnUAqfyCjK73IWhXYIdYwXQpQwt-Mmc&callback=initMap&v=weekly"
    async></script>

@endsection
