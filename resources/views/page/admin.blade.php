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
                        <h2 class="page-title">User Administrator</h2>
                    </div>
                </div>
            </div>
            <div class="col-auto">
                <div class="d-flex gap-2">
                    <a class="btn btn-light ms-auto ms-sm-0" data-bs-toggle="offcanvas" href="#offcanvasStart"
                        role="button" aria-controls="offcanvasStart" id="btn-filter">
                        <svg style="margin-right:10px" xmlns="http://www.w3.org/2000/svg"
                            class="icon icon-tabler icon-tabler-filter-search m-0" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M11.36 20.213l-2.36 .787v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414" />
                            <path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                            <path d="M20.2 20.2l1.8 1.8" /> </svg>
                        <span class="d-none d-sm-inline">&nbsp;Filter</span>
                    </a>
                    @if(session('role_id') != 2)
                        <a href="#" id="btn-create-so" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modal-adduser">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" /></svg>
                            <span class="d-none d-sm-inline">&nbsp;Create New User</span>
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
            <div class="alert alert-important alert-danger alert-dismissible" style="border-radius:0px;" role="alert">
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

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Records</h3>
            </div>

            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User Name</th>
                            <th>Email Address</th>
                            <th>Phone Number</th>
                            <th class="text-center">Account Role</th>
                            <th class="text-center">Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse($data as $raw)
                            <tr>
                                <td class="py-2">{{ $loop->iteration }}</td>
                                <td class="py-2">{{ $raw->first_name }} {{ $raw->last_name }}</td>
                                <td class="py-2">
                                    <a class="link-primary" href="mailto:{{ $raw->user_email }}"
                                        title="Send mail to {{ $raw->user_email }}">{{ $raw->user_email }}</a>
                                </td>
                                <td class="py-2">{{ $raw->phone }}</td>
                                <td class="py-2 text-center">
                                    <span class="badge bg-blue-lt">{{ $raw->role_name }}</span>
                                </td>
                                <td class="py-2 text-center">
                                    <label class="form-check form-check-single form-switch p-0 d-inline-block">
                                        @if($raw->is_active == '1')
                                            <input class="form-check-input btn-active" type="checkbox" checked
                                                value="{{ $raw->id }}">&nbsp;Active
                                        @else
                                            <input class="form-check-input btn-deactive" type="checkbox"
                                                value="{{ $raw->id }}">&nbsp;Active
                                        @endif
                                    </label>
                                </td>
                                <td class="py-2 text-end">
                                    <div user_id="{{ $raw->id }}" class="btnedit btn btn-outline-primary"
                                        title="Edit">Edit</div>
                                </td>
                            </tr>
                        @empty

                            <tr>
                                <td class="py-2" colspan="8">

                                    <div class="empty">
                                        <p class="empty-title">No results found</p>
                                        <p class="empty-subtitle text-secondary">
                                            Try adjusting your search or filter to find what you're looking for.
                                        </p>
                                        <div class="empty-action">
                                            <a href="#" class="btn btn-primary" data-bs-target="#modal-addrouter"
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
                                                Add your first User
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

    @include('component.modal.add-user')
    @include('component.modal.edit-user')
    @include('component.canvas.filter-user')

    <script>
        $(document).ready(function () {

            $.ajaxSetup({
                headers: {

                    'X-CSRF-TOKEN': $('#form-edit').find('input[name="_token"]').first().val()

                }
            });

            $('.btnedit').click(function () {

                var user_id = $(this).attr('user_id');

                $.ajax({

                    type: 'POST',
                    url: "{{ route('user_detail') }}",
                    data: {
                        user_id: user_id
                    },
                    success: function (data) {

                        $('#modal-edituser').modal('show');
                        $('.edit_user_id').val(user_id);
                        $('.edit_first_name').val(data.first_name);
                        $('.edit_last_name').val(data.last_name);
                        $('.edit_user_email').val(data.user_email);
                        $('.edit_phone').val(data.phone);
                        $(".edit_user_role").val(data.role_id).change();


                    }

                });

            });


            $('.btn-active').change(function () {

                var user_id = this.value;

                $.ajax({

                    type: 'POST',
                    url: "{{ route('set_admin_deactive') }}",
                    data: {
                        user_id: user_id
                    },
                    success: function (data) {

                        window.location.reload();

                    }

                });

            });


            $('.btn-deactive').change(function () {

                var user_id = this.value;

                $.ajax({

                    type: 'POST',
                    url: "{{ route('set_admin_active') }}",
                    data: {
                        user_id: user_id
                    },
                    success: function (data) {

                        window.location.reload();

                    }

                });

            });

        });

    </script>



    @endsection
