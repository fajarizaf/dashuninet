@extends('layouts.console')
@section('container')



<!-- Page header -->
<div class="page-header d-print-none text-white">
    <div class="container-xl">
        <div class="row g-3 align-items-center justify-content-between">
            <div class="col-auto">
                <div class="d-flex gap-2 align-items-center justify-content-between justify-content-sm-start">
                    <div>
                        <div class="page-pretitle">Administrator</div>
                        <h2 class="page-title">Banner Management</h2>
                    </div>
                </div>
            </div>
            <div class="col-auto">
                <div class="d-flex gap-2">
                    @if(session('role_id') != 2)
                    <a href="#" id="btn-create-so" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-addbanner">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                        <span class="d-none d-sm-inline">&nbsp;Create New Banner</span>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

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

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Records</h3>
            </div>

            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Banner</th>
                            <th>Banner Name</th>
                            <th class="text-center">Category</th>
                            <th class="text-center">Is Hidden</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse($data as $raw)
                            <tr>
                                <td class="py-2">{{$loop->iteration}}</td>
                                <td class="py-2">
                                    <div class="d-flex py-1 align-items-center">
                                        <img style="max-width: 300px;max-height: 150px;"
                                            src="{{ env('BACKEND_URL') }}/image/get/ums/{{ $raw->banner_link }}" />
                                    </div>
                                </td>
                                <td class="py-2">{{ $raw->banner_name }}</td>
                                <td class="py-2 text-center text-capitalize"><span class="badge">{{ $raw->category }}</span></td>
                                <td class="py-2 text-center"><span class="badge {{($raw->is_hidden === 'No') ? 'text-bg-danger' : 'text-bg-success'}}">{{ $raw->is_hidden }}</div></td>
                                <td class="py-2 text-end">
                                    <button class="btn btn-outline-primary btnedit" banner_id="{{ $raw->id }}" class="Edit">Edit</button>
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
                                            <a href="#" class="btn btn-primary" data-bs-target="#modal-addbanner"
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
                                                Add your first Banner
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


@include('component.modal.add-banner')
@include('component.modal.edit-banner')


<script>
    $(document).ready(function () {

        $.ajaxSetup({
            headers: {

                'X-CSRF-TOKEN': $('#form-banner').find('input[name="_token"]').first().val()

            }
        });

        $('.btnedit').click(function () {

            var banner_id = $(this).attr('banner_id');

            $.ajax({

                type: 'POST',
                url: "{{ route('banner_detail') }}",
                data: {
                    banner_id: banner_id
                },
                success: function (data) {

                    $('#modal-editbanner').modal('show');
                    $('.banner_id').val(data.id);
                    $('.banner_name').val(data.banner_name);
                    $('.category').val(data.category);
                    $('.is_hidden').val(data.is_hidden);
                    $('#cover').attr('src', '<?= env('BACKEND_URL') . '/image/get/ums/' ?>' + data.banner_link);

                }

            });

        });


        $(document).on('click', '#btn-create-so', function (e) {
            e.preventDefault();

            var banner_id = $(this).attr('banner_id');

            $.ajax({

                type: 'POST',
                url: "{{ route('banner_detail') }}",
                data: {
                    banner_id: banner_id
                },
                success: function (data) {

                    $('.banner_id').val(data.id);
                    $('.customer_name').val(data.pic_name);
                    $('.customer_phone').val(data.telp);
                    $('.customer_email').val(data.email);

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

</script>


@endsection
