@extends('layouts.console')
@section('container')

<script src="{{ URL::asset('assets/dist/libs/tinymce/tinymce.min.js') }}"
    referrerpolicy="origin"></script>
<!-- <link rel="stylesheet" href="{{ URL::asset('assets/dist/libs/tinymce/morris.css') }}"> -->


<!-- Page header -->
<div class="page-header d-print-none text-white">
    <div class="container-xl">
        <div class="row g-3 align-items-center justify-content-between">
            <div class="col-auto">
                <div class="d-flex gap-2 align-items-center justify-content-between justify-content-sm-start">
                    <div>
                        <div class="page-pretitle">Administrator</div>
                        <h2 class="page-title">Docs Management</h2>
                    </div>
                </div>
            </div>
            <div class="col-auto">
                <div class="d-flex gap-2">
                    <a class="btn btn-light ms-auto ms-sm-0" data-bs-toggle="offcanvas" href="#offcanvasStart" role="button" aria-controls="offcanvasStart" id="btn-filter">
                        <svg style="margin-right:10px" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-filter-search m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M11.36 20.213l-2.36 .787v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414" /><path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M20.2 20.2l1.8 1.8" /> </svg>
                        <span class="d-none d-sm-inline">&nbsp;Filter</span>
                    </a>
                    @if(session('role_id') != 2)
                    <a href="#" id="btn-create-so" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-adddocumentation">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                        <span class="d-none d-sm-inline">&nbsp;Create New Documentation</span>
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
                            <th>Title</th>
                            <th class="text-center">Platform</th>
                            <th class="text-center">Type</th>
                            <th class="text-center">Visibility</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse($data as $raw)
                            <tr>
                                <td class="py-2">{{ $loop->iteration }}</td>
                                <td class="py-2">{{ $raw->title }}</td>
                                <td class="py-2 text-center text-capitalize"><span class="badge">{{ $raw->app }}</span></td>
                                <td class="py-2 text-center text-capitalize"><span class="badge">{{ $raw->type }}</span></td>
                                <td class="py-2 text-center">{{ $raw->visibility ?? '-' }}</td>
                                <td class="py-2 text-end">
                                    <button class="btn btn-outline-primary btnedit" documentation_id="{{ $raw->id }}">Edit</button>
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
                                            <a href="#" class="btn btn-primary" data-bs-target="#modal-adddocumentation"
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
                                                Add your first Documentation
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


@include('component.modal.add-documentation')
@include('component.modal.edit-documentation')
@include('component.canvas.filter-documentation')


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const example_image_upload_handler = (blobInfo, progress) => new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', "{{ route('documentation_img') }}");
            xhr.setRequestHeader('X-CSRF-TOKEN', $('#form-documentation').find(
                'input[name="_token"]').first().val());

            xhr.upload.onprogress = (e) => {
                progress(e.loaded / e.total * 100);
            };

            xhr.onload = () => {
                if (xhr.status === 403) {
                    reject({
                        message: 'HTTP Error: ' + xhr.status,
                        remove: true
                    });
                    return;
                }

                if (xhr.status < 200 || xhr.status >= 300) {
                    reject('HTTP Error: ' + xhr.status);
                    return;
                }

                const json = JSON.parse(xhr.responseText);

                if (!json || typeof json.location != 'string') {
                    reject('Invalid JSON: ' + xhr.responseText);
                    return;
                }

                resolve(json.location);
            };

            xhr.onerror = () => {
                reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
            };

            const formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());

            xhr.send(formData);
        });

        let options = {
            selector: '#tinymce-mytextarea',
            height: 300,
            menubar: false,
            statusbar: false,
            toolbar: 'undo redo | formatselect | ' +
                'bold italic image | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | strikethrough forecolor backcolor | fontsizeselect | ',
            plugins: 'image code preview searchreplace directionality  visualchars image link table charmap pagebreak nonbreaking  insertdatetime advlist lists wordcount ',
            content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; -webkit-font-smoothing: antialiased; }',
            automatic_uploads: true,
            images_upload_handler: example_image_upload_handler,
        }

        tinyMCE.init(options);

        let options2 = {
            selector: '#tinymce-mytextarea2',
            height: 350,
            menubar: false,
            statusbar: false,
            toolbar: 'undo redo | formatselect | ' +
                'bold italic image | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | strikethrough forecolor backcolor | fontsizeselect | ',
            plugins: 'image code preview searchreplace directionality  visualchars image link table charmap pagebreak nonbreaking  insertdatetime advlist lists wordcount ',
            content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; -webkit-font-smoothing: antialiased; }',
            automatic_uploads: true,
            // images_upload_url: "{{ route('documentation_img') }}",
            images_upload_handler: example_image_upload_handler,
        }

        tinyMCE.init(options2);

    })

    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('#form-documentation').find('input[name="_token"]').first().val()
            }
        });

        $('.btnedit').click(function () {

            var documentation_id = $(this).attr('documentation_id');

            $.ajax({

                type: 'POST',
                url: "{{ route('documentation_detail') }}",
                data: {
                    documentation_id: documentation_id
                },
                success: function (data) {

                    $('#modal-editdocumentation').modal('show');
                    $('.documentation_id').val(data.id);
                    $('.title').val(data.title);
                    $('.type').val(data.type);
                    $('.app').val(data.app);
                    $('.categori').val(data.cat);
                    $('.is_visible').val(data.is_visible);
                    $('.content').val(data.content);
                    tinyMCE.activeEditor.setContent(data.content);
                }

            });

        });

    });

</script>

@endsection
