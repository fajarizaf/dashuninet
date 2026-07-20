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
                        <h2 class="page-title">Reward Management</h2>
                    </div>
                </div>
            </div>
            <div class="col-auto">
                <div class="d-flex gap-2">
                    @if(session('role_id') != 2)
                    <a href="#" id="btn-create-so" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-addreward">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                        <span class="d-none d-sm-inline">&nbsp;Create New Reward</span>
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
                            <th>Reward Name</th>
                            <th>Description</th>
                            <th class="text-center">Reward Point</th>
                            <th class="text-center">Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse($data as $raw)
                        <tr>
                            <td class="py-2">{{$loop->iteration}}</td>
                            <td class="py-2">{{$raw->reward_name}}</td>
                            <td class="py-2">{{$raw->reward_description}}</td>
                            <td class="py-2 text-center">
                                <span class="badge text-primary border border-primary">{{$raw->reward_point}}</span>
                            </td>
                            <td class="py-2 text-center text-capitalize">
                                @php
                                    $stat = $raw->status;

                                    if (in_array($stat, ['Activated', 'active', 'Completed']) === true) {
                                        $badgeColor = 'text-bg-success';
                                    } elseif (in_array($stat, ['Deactivated', 'deactive']) === true) {
                                        $badgeColor = 'text-bg-danger';
                                    } elseif ($stat == 'Pending') {
                                        $badgeColor = 'text-bg-secondary';
                                    } elseif ($stat == 'In Progress') {
                                        $badgeColor = 'text-bg-teal';
                                    } elseif (in_array($stat, ['Terminated', 'Deleted']) === true) {
                                        $badgeColor = 'border border-danger text-danger';
                                    } elseif ($stat == 'Dismentle') {
                                        $badgeColor = 'text-bg-yellow';
                                    } elseif ($stat == 'Canceled') {
                                        $badgeColor = 'text-bg-orange';
                                    } else {
                                        $badgeColor = '';
                                    }
                                @endphp
                                <span class="badge {{$badgeColor}}">{{$raw->status ?? '-'}}</span>
                            </td>
                            <td class="py-2 text-end">
                                <button class="btn btn-outline-primary btnedit" reward_id="{{$raw->id}}" title="Edit">Edit</button>
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
                                        <a href="#" class="btn btn-primary" data-bs-target="#modal-addreward"
                                            data-bs-toggle="modal">
                                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M12 5l0 14"></path>
                                                <path d="M5 12l14 0"></path>
                                            </svg>
                                            Add your first Reward
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


@include('component.modal.add-reward')
@include('component.modal.edit-reward')


<script>

        $(document).ready(function () {

            $.ajaxSetup({
                headers: {

                    'X-CSRF-TOKEN': $('#form-reward').find('input[name="_token"]').first().val()

                }
            });

            $('.btnedit').click(function () {

                var reward_id = $(this).attr('reward_id');

                $.ajax({

                    type: 'POST',
                    url: "{{ route('reward_detail') }}",
                    data: { reward_id: reward_id },
                    success: function (data) {

                        $('#modal-editreward').modal('show');
                        $('.reward_id').val(data.id);
                        $('.reward_name').val(data.reward_name);
                        $('.reward_point').val(data.reward_point);
                        $('.reward_description').val(data.reward_description);
                        $('.status').val(data.status);
                        $('#cover').attr('src', '<?= env('BACKEND_URL') . '/image/get/ums/' ?>' + data.reward_cover);

                    }

                });

            });


            $(document).on('click', '#btn-create-so', function (e) {
                e.preventDefault();

                var reward_id = $(this).attr('reward_id');

                $.ajax({

                    type: 'POST',
                    url: "{{ route('reward_detail') }}",
                    data: { reward_id: reward_id },
                    success: function (data) {

                        $('.reward_id').val(data.id);
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
                                return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                            }
                            return '<div>' + escape(data.text) + '</div>';
                        },
                        option: function (data, escape) {
                            if (data.customProperties) {
                                return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                            }
                            return '<div>' + escape(data.text) + '</div>';
                        },
                    },
                }));


            });




        });
    </script>


@endsection
