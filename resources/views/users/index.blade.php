@extends('layouts.main')

@section('title', 'User Management')
@section('content-header', 'User Management')

@section('header-action')
    <button type="button" class="btn btn-success " id="btn-add-user">
        <i class="fas fa-plus me-1"></i> Add New User
    </button>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card border-1 border-light">
            <div class="card-header">
                {{-- <h3 class="card-title text-secondary font-weight-bold mb-0">Registered Users</h3> --}}
                <h3 class="card-title mt-1">
                    <i class="fas fa-users mr-1"></i> Registered Users
                </h3>

                <div class="card-tools" style="max-width: 800px;">
                    <!-- Real-time Filter Search Input Bar Component -->
                    <div class="input-group" style="max-width: 800px;">
                        <input type="text" id="user-search-input" class="form-control"
                            placeholder="Search name or email account...">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-search text-sm"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover  align-middle mb-0" id="users-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Assigned Roles</th>
                                <th>Status</th>
                                <th style="width: 100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr id="user-row-{{ $user->id }}">
                                    <td class="user-name"><strong>{{ $user->name }}</strong></td>
                                    <td class="user-username">{{ $user->username ?? 'N/A' }}</td>
                                    <td class="user-email">{{ $user->email }}</td>
                                    <td>
                                        @forelse($user->roles as $role)
                                            <span class="badge badge-info px-2 py-1 mr-1 text-xs">{{ $role->name }}</span>
                                        @empty
                                            <span class="badge badge-secondary px-2 py-1 text-xs">Standard Guest User</span>
                                        @endforelse
                                    </td>
                                    <td>
                                        @if ($user->status === 'active')
                                            <span class="badge badge-success px-2 py-1">Active</span>
                                        @elseif($user->status === 'pending')
                                            <span class="badge badge-warning px-2 py-1 animate-pulse">Awaiting
                                                Approval</span>
                                        @else
                                            <span class="badge badge-danger px-2 py-1">Suspended</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($user->status === 'pending')
                                            <button class="btn btn-success btn-sm font-weight-bold btn-toggle-status"
                                                data-id="{{ $user->id }}" data-status="active">
                                                <i class="fas fa-user-check"></i> Approve
                                            </button>
                                        @endif
                                        <!-- Assign Roles Launch Control Trigger Button Component -->
                                        <button class="btn btn-primary btn-sm font-weight-bold btn-assign-role"
                                            data-id="{{ $user->id }}" data-name="{{ $user->name }}"
                                            data-roles="{{ json_encode($user->roles->pluck('name')) }}">
                                            <i class="fas fa-user-shield mr-1"></i> Roles
                                        </button>
                                        <div class="btn-group">
                                            <button class="btn btn-primary btn-sm btn-view" data-id="{{ $user->id }}">
                                                <i class="fas fa-eye mr-1"></i>
                                            </button>
                                            <button class="btn btn-info btn-sm btn-edit text-white"
                                                data-id="{{ $user->id }}">
                                                <i class="fas fa-pencil-alt mr-1"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $user->id }}"
                                                data-url="{{ route('users.destroy', $user) }}">
                                                <i class="fas fa-trash mr-1"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr id="empty-row">
                                    <td colspan="5" class="text-center py-5">
                                        <i class="fas fa-users fa-3x text-muted mb-3"></i><br>
                                        <span class="text-secondary font-weight-bold">No records found.</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- NEW: READ-ONLY SHOW DETAILS MODAL        -->
    <!-- ========================================== -->
    <div class="modal fade" id="showUserModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-user-card mr-2"></i>User Profile Details</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <!-- Avatar block wrapper -->
                    <div class="mb-3">
                        <img id="show-avatar" src="" class="img-circle elevation-2" alt="User Image"
                            style="width: 100px; height: 100px; object-fit: cover;">
                    </div>
                    <h4 id="show-name" class="font-weight-bold mb-1"></h4>
                    <p id="show-username" class="text-muted mb-3"></p>
                    <hr>

                    <!-- Quick facts definition table layout -->
                    <table class="table table-sm table-borderless text-left mb-0">

                        <tr>
                            <th>Employee ID:</th>
                            <td id="show-employee-id"></td>
                        </tr>
                        <tr>
                            <th>Email Address:</th>
                            <td id="show-email"></td>
                        </tr>
                        <tr>
                            <th>Phone Number:</th>
                            <td id="show-phone"></td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td id="show-status"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default w-100" data-dismiss="modal">Close Profile</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ADMINLTE COMPATIBLE SHARED FORM MODAL (CREATE / EDIT) -->
    <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="userForm">
                    <input type="hidden" id="user_id" name="user_id">

                    {{-- Dynamic theme headers popular in AdminLTE panels --}}
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalTitle">Add User</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <!-- Inline Server Validation Error Alert panel matching AdminLTE callouts -->
                        <div class="alert alert-danger d-none" id="form-errors"></div>

                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="John Doe" required>
                        </div>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username"
                                placeholder="johndoe" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="johndoe@company.com" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password <span class="text-muted small id-helper">(Leave blank if
                                    updating)</span></label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>

                        <div class="form-group">
                            <label for="status">System Status</label>
                            <select class="form-control custom-select" id="status" name="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btn-save">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SINGLE GLOBAL ROLE SELECTION CONTROL MODAL INTERACTION CANVAS -->
    <div class="modal fade" id="modal-role-assignment" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-navy text-white">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-shield-alt mr-2"></i> Alter Security Access
                        Enclosures</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-role-assignment">
                    @method('PUT')
                    <div class="modal-body">
                        <p class="text-muted text-sm mb-3">Adjust authorization clearance boundaries for: <strong
                                id="display-user-name" class="text-dark"></strong></p>

                        <div class="form-group">
                            <label class="font-weight-bold text-secondary mb-2">Available Operational Role Profiles</label>
                            <div class="role-checkbox-container p-3 border rounded bg-light"
                                style="max-height: 250px; overflow-y: auto;">
                                @foreach ($roles as $role)
                                    <div class="custom-control custom-checkbox mb-2">
                                        <input class="custom-control-input role-checkbox" type="checkbox" name="roles[]"
                                            id="role-chk-{{ $role->id }}" value="{{ $role->name }}">
                                        <label
                                            class="custom-control-label font-weight-bold text-dark text-sm cursor-pointer"
                                            for="role-chk-{{ $role->id }}">
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light text-right">
                        <button type="button" class="btn btn-default font-weight-bold btn-sm"
                            data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success font-weight-bold btn-sm shadow-sm"
                            id="btn-save-roles">
                            <i class="fas fa-check mr-1"></i> Apply Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            // Automatically link header tokens to all underlying jQuery requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.btn-toggle-status').on('click', function() {
                const userId = $(this).data('id');
                const targetStatus = $(this).data('status');

                $.ajax({
                    url: `/users/${userId}/status`,
                    type: "PATCH",
                    data: {
                        _token: "{{ csrf_token() }}",
                        status: targetStatus
                    },
                    success: function(res) {
                        SystemAlert.toast('success', res.message);
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    }
                });
            });

            // --- NEW: TRIGGER VIEW / SHOW PROFILE MODAL VIA AJAX ---
            $(document).on('click', '.btn-view', function() {
                let userId = $(this).data('id');

                $.get(`/users/${userId}`, function(user) {
                    // Populate read-only elements
                    $('#show-id').text(user.id);
                    $('#show-name').text(user.name);
                    $('#show-username').text('@' + user.username);
                    $('#show-email').text(user.email);
                    $('#show-employee-id').text(user.employee_id || 'N/A');
                    $('#show-phone').text(user.phone || 'N/A');

                    // Dynamic AdminLTE Badge handling inside details view
                    let badgeClass = user.status === 'active' ? 'badge-success' : 'badge-secondary';
                    $('#show-status').html(
                        `<span class="badge ${badgeClass}">${user.status.toUpperCase()}</span>`);

                    // Fallback dummy profile illustration handling if avatar field value isn't loaded
                    let avatarUrl = user.avatar ? `/storage/${user.avatar}` :
                        'https://adminlte.io/themes/v3/dist/img/user2-160x160.jpg';
                    $('#show-avatar').attr('src', avatarUrl);

                    $('#showUserModal').modal('show');
                });
            });

            // --- TRIGGER CREATE MODAL ---
            $('#btn-add-user').click(function() {
                $('#userForm')[0].reset();
                $('#user_id').val('');
                $('#modalTitle').text('Add New User');
                $('.id-helper').addClass('d-none');
                $('#password').attr('required', true);
                $('#form-errors').addClass('d-none').html('');
                $('#userModal').modal('show'); // Bootstrap 4 Modal implementation
            });

            // --- TRIGGER EDIT MODAL ---
            $(document).on('click', '.btn-edit', function() {
                let userId = $(this).data('id');
                $('#form-errors').addClass('d-none').html('');

                $.get(`/users/${userId}`, function(user) {
                    $('#user_id').val(user.id);
                    $('#name').val(user.name);
                    $('#username').val(user.username);
                    $('#email').val(user.email);
                    $('#status').val(user.status);

                    $('#modalTitle').text('Edit User Data');
                    $('.id-helper').removeClass('d-none');
                    $('#password').attr('required', false).val('');
                    $('#userModal').modal('show');
                });
            });

            // --- PROCESS FORM SUBMISSION (CREATE & UPDATE) ---
            $('#userForm').submit(function(e) {
                e.preventDefault();
                $('#btn-save').prop('disabled', true).text('Processing...');
                $('#form-errors').addClass('d-none').html('');

                let id = $('#user_id').val();
                let url = id ? `/users/${id}` : '/users';
                let method = id ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    type: method,
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        $('#userModal').modal('hide');
                        $('#btn-save').prop('disabled', false).text('Save Changes');

                        let badgeClass = response.user.status === 'active' ? 'badge-success' :
                            'badge-secondary';
                        let statusText = response.user.status.charAt(0).toUpperCase() + response
                            .user.status.slice(1);

                        let rowHtml = `
                        <tr id="user-row-${response.user.id}">
                            <td class="user-name"><strong>${response.user.name}</strong></td>
                            <td class="user-username">${response.user.username}</td>
                            <td class="user-email">${response.user.email}</td>
                            <td class="user-status"><span class="badge ${badgeClass}">${statusText}</span></td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm btn-view" data-id="${response.user.id}"><i class="fas fa-eye mr-1"></i> </button>
                                    <button class="btn btn-info btn-sm btn-edit text-white" data-id="${response.user.id}"><i class="fas fa-pencil-alt mr-1"></i> </button>
                                    <button class="btn btn-danger btn-sm btn-delete" data-id="${response.user.id}" data-url="/users/${response.user.id}"><i class="fas fa-trash mr-1"></i> </button>
                                </div>
                            </td>
                        </tr>`;

                        if (id) {
                            $(`#user-row-${id}`).replaceWith(rowHtml);
                        } else {
                            $('#empty-row').remove();
                            $('#users-table tbody').prepend(rowHtml);
                        }
                        SystemAlert.toast('success', 'User save successfully.');
                        // Swal.fire({
                        //     icon: 'success',
                        //     title: 'Saved!',
                        //     text: response.message,
                        //     timer: 1500,
                        //     showConfirmButton: false
                        // });
                    },
                    error: function(xhr) {
                        $('#btn-save').prop('disabled', false).text('Save Changes');
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorList = '<ul class="mb-0">';
                            $.each(errors, function(key, value) {
                                errorList += `<li>${value[0]}</li>`;
                            });
                            errorList += '</ul>';
                            $('#form-errors').removeClass('d-none').html(errorList);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Something unexpected failed.'
                            });
                        }
                    }
                });
            });

            // --- REMOVE USER ROW (DELETE) ---
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                let button = $(this);
                let userId = button.data('id');
                let url = button.data('url');
                let row = $('#user-row-' + userId);

                Swal.fire({
                    title: 'Delete User?',
                    text: 'This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Delete'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            dataType: 'json',
                            success: function(response) {
                                row.fadeOut(400, function() {
                                    $(this).remove();
                                    if ($('#users-table tbody tr').length ===
                                        0) {
                                        $('#users-table tbody').append(`
                                        <tr id="empty-row">
                                            <td colspan="5" class="text-center py-5">
                                                <i class="fas fa-users fa-3x text-muted mb-3"></i><br>No users found.
                                            </td>
                                        </tr>`);
                                    }
                                });
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: response.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: xhr.responseJSON?.message ||
                                        'Access denied.'
                                });
                            }
                        });
                    }
                });
            });

            let currentUserId = null;

            // Trigger Intercept Event Layer: Open Role Dialog and Pre-Check active roles
            $('.btn-assign-role').on('click', function() {
                currentUserId = $(this).data('id');
                const userName = $(this).data('name');
                const assignedRolesArray = $(this).data('roles'); // Plucked collection parsing

                // Update textual headers inside modal wrapper layout frame context
                $('#display-user-name').text(userName);

                // Reset all internal checkboxes before applying target profile array filters
                $('.role-checkbox').prop('checked', false);

                // Loop checkboxes and cross reference checked arrays matching roles
                $('.role-checkbox').each(function() {
                    if (assignedRolesArray.includes($(this).val())) {
                        $(this).prop('checked', true);
                    }
                });

                // Fire Modal Popup
                $('#modal-role-assignment').modal('show');
            });

            // Form Event Listener Submission Pipeline
            $('#form-role-assignment').submit(function(e) {
                e.preventDefault();

                if (!currentUserId) return;

                $('#btn-save-roles').prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin mr-1"></i> Synchronizing Framework...');

                $.ajax({
                    url: `/users/${currentUserId}/assign-roles`,
                    type: "POST", // Managed via Blade @method('PUT') parser spoofing tags safely
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        $('#modal-role-assignment').modal('hide');
                        $('#btn-save-roles').prop('disabled', false).html(
                            '<i class="fas fa-check mr-1"></i> Apply Changes');

                        // Fire dynamic notification confirmation via Toastr system layer
                        SystemAlert.toast('success', response.message);

                        // Refresh UI layout to print newly applied badge changes out
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    },
                    error: function(xhr) {
                        $('#btn-save-roles').prop('disabled', false).html(
                            '<i class="fas fa-check mr-1"></i> Apply Changes');
                        SystemAlert.toast('error',
                            'Role matrix sync transaction failure encountered.');
                    }
                });
            });

            // Instant User Matrix Row Filtering Engine
            $('#user-search-input').on('keyup', function() {
                let value = $(this).val().toLowerCase().trim();

                // Target table rows inside the user table body
                $('#users-table tbody tr').filter(function() {
                    // Check text content inside the specific row match
                    let toggle = $(this).text().toLowerCase().indexOf(value) > -1;
                    $(this).toggle(toggle);
                });

                // Optional: Display a fallback row if the entire table is hidden
                toggleNoResultsRow(value);
            });

            function toggleNoResultsRow(searchVal) {
                let visibleRows = $('#users-table tbody tr:visible').not('#no-results-row').length;

                // Remove existing fallback if any
                $('#no-results-row').remove();

                if (visibleRows === 0 && searchVal !== '') {
                    $('#users-table tbody').append(`
                <tr id="no-results-row">
                    <td colspan="5" class="text-center py-4 text-muted">
                        <i class="fas fa-search-minus fa-2x mb-2 d-block text-gray"></i>
                        No users found matching operational parameter "<strong>${searchVal}</strong>"
                    </td>
                </tr>
            `);
                }
            }
        });
    </script>
@endpush
