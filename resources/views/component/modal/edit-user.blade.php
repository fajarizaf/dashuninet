<div class="modal modal-blur fade" id="modal-edituser" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <form method="POST" action="/console/admin/update" id="form-salesorder">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="user_id" value="" class="edit_user_id" />

                <div class="modal-header">
                    <h5 class="modal-title">Update Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control edit_first_name" name="first_name" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control edit_last_name" name="last_name" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">

                        <label class="form-label">User Email</label>
                        <input type="text" class="form-control edit_user_email" disabled name="user_email"
                            placeholder="Input Your Email" required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">User Phone</label>
                        <input type="number" class="form-control edit_phone" name="phone"
                            placeholder="Input Your Password" required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">New Password</label>
                        <input type="text" class="form-control" name="user_password">

                    </div>

                    <div class="mb-3">
                        <label class="form-label">User Role</label>
                        <select type="text" name="user_role" class="form-select edit_user_role" required>
                            <option value="">-- Select --</option>
                            @forelse($role as $em)
                                <option value="{{ $em->id }}">{{ $em->role_name }}
                                @empty
                                <option value="">No Role Found</option>
                            @endforelse
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <a href="#" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>

            </form>

        </div>
    </div>
</div>


<form style="display:none" method="POST" action="/" id="form-like">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
</form>

<style type="text/css">
    .modal-body .ts-dropdown {
        top: 310px !important;
    }

    .header-field {
        padding: 10px;
        background: #f5f8fc;
    }

    .header-field>.card-title {
        font-size: 14px;
    }

</style>


<script type="text/javascript">
    $(document).ready(function () {

        $.ajaxSetup({
            headers: {

                'X-CSRF-TOKEN': $('#form-like  ').find('input[name="_token"]').first().val()

            }
        });

        $(".choose-plan").html(
            '<div class="alert alert-important alert-info alert-dismissible" role="alert"><div class="d-flex"><div><!-- Download SVG icon from http://tabler-icons.io/i/info-circle --><svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path><path d="M12 9h.01"></path><path d="M11 12h1v4h1"></path></svg></div><div>Select the product first</div></div><a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a></div>'
        );

        $('#select-product').on('change', function () {

            var group_id = this.value

            $.ajax({

                type: 'POST',
                url: "{{ route('get_product_plan') }}",
                data: {
                    group_id: group_id
                },
                success: function (data) {

                    if (data.length != 0) {
                        $(".choose-plan").html('');
                        for (var i = 0; i < data.length; i++) {
                            $(".choose-plan").append(
                                '<div class="col-lg-6" style="padding-top:calc(var(--tblr-gutter-x) * .5);padding-bottom:calc(var(--tblr-gutter-x) * .5)"><label class="form-selectgroup-item"><input type="radio" name="product_plan" value="' +
                                data[i]['id'] +
                                '" class="form-selectgroup-input product-plan" required><span class="form-selectgroup-label d-flex align-items-center p-3"><span class="me-3"><span class="form-selectgroup-check"></span></span><span class="form-selectgroup-label-content"><span class="form-selectgroup-title strong mb-1">' +
                                data[i]['product_name'] +
                                ' - <span class="text-secondary">' + data[i][
                                    'product_plan'
                                ] +
                                '</span></span><span class="d-block text-secondary">' +
                                data[i]['product_desc'] +
                                '</span></span></span></label></div>');
                        }
                    } else {
                        $(".choose-plan").html(
                            '<div class="alert alert-info" role="alert"><div class="d-flex"><div><!-- Download SVG icon from http://tabler-icons.io/i/info-circle --><svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path><path d="M12 9h.01"></path><path d="M11 12h1v4h1"></path></svg></div><div><h4 class="alert-title">Empty Product Plan</h4><div class="text-secondary">Produk belum tersedia untuk saat ini</div></div></div></div>'
                        );
                    }

                }

            });

        });


        $('.choose-plan').on('change', '.product-plan', function () {

            var product_id = this.value

            $.ajax({

                type: 'POST',
                url: "{{ route('get_product_field') }}",
                data: {
                    product_id: product_id
                },
                success: function (data) {

                    $.ajax({

                        type: 'POST',
                        url: "{{ route('get_product_price') }}",
                        data: {
                            product_id: product_id
                        },
                        success: function (data) {

                            if (data.price != 0) {
                                $("#product_price").val(data.price);
                            } else {
                                $("#product_price").val(
                                    'Product price not found');
                            }

                        }

                    });

                    if (data.length != 0) {
                        $(".input-product-field").html('');
                        for (var i = 0; i < data.length; i++) {
                            $(".input-product-field").append(
                                '<div class="mb-3"><label class="form-label">' + data[i]
                                ['field_name'] +
                                '</label><input required type="text" name="' + data[i][
                                    'field_slug'
                                ] +
                                '" class="form-control" data-mask-visible="true" placeholder="input ' +
                                data[i]['field_name'] + '" autocomplete="off"></div>');
                        }
                    } else {
                        $(".choose-plan").html(
                            '<div class="alert alert-info" role="alert"><div class="d-flex"><div><!-- Download SVG icon from http://tabler-icons.io/i/info-circle --><svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path><path d="M12 9h.01"></path><path d="M11 12h1v4h1"></path></svg></div><div><h4 class="alert-title">No Product Available</h4><div class="text-secondary">Produk belum tersedia untuk saat ini</div></div></div></div>'
                        );
                    }

                }

            });

        });

    });

</script>
