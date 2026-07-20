<div class="modal modal-blur fade" id="modal-adduser" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <form method="POST" action="/console/admin/create" id="form-adduser">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                <div class="modal-header">
                    <h5 class="modal-title">New Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" name="first_name" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="last_name" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">

                        <label class="form-label">User Email</label>
                        <input type="text" class="form-control" name="user_email" placeholder="Input Your Email"
                            required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">User Phone</label>
                        <input type="number" class="form-control" name="phone" placeholder="Input Your Phone" required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">User Password</label>
                        <input type="password" class="form-control" name="user_password"
                            placeholder="Input Your Password" required>

                    </div>

                    <div class="mb-3">
                        <label class="form-label">User Role</label>
                        <select type="text" name="user_role" class="form-select" required>
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
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>

            </form>

        </div>
    </div>
</div>


<!-- <form style="display:none" method="POST" action="/" id="form-like">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
</form> -->

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
