@extends('layouts.main')

@section('title', 'Data Management')
@section('content-header', 'Data Management')

@section('header-action')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="card card-outline card-navy shadow-sm">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="masterDataTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active font-weight-bold" id="schools-tab" data-toggle="pill" href="#panel-schools"
                            role="tab"><i class="fas fa-school mr-1"></i> Schools</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" id="districts-tab" data-toggle="pill" href="#panel-districts"
                            role="tab"><i class="fas fa-map-marked-alt mr-1"></i> Districts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" id="offices-tab" data-toggle="pill" href="#panel-offices"
                            role="tab"><i class="fas fa-building mr-1"></i> Administrative Offices</a>
                    </li>
                </ul>
            </div>

            <div class="card-body p-0">
                <div class="tab-content" id="masterDataTabsContent">

                    <!-- SCHOOLS TAB PANEL -->
                    <div class="tab-pane fade show active p-3" id="panel-schools" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0 text-secondary font-weight-bold">Registered Educational Facilities</h5>
                            <!-- Action Control Group Block -->
                            <div class="btn-group shadow-sm">
                                <a href="{{ route('export.schools.excel') }}"
                                    class="btn btn-default btn-sm font-weight-bold text-success">
                                    <i class="fas fa-file-excel mr-1"></i> Export Excel
                                </a>
                                <a href="{{ route('export.schools.pdf') }}"
                                    class="btn btn-default btn-sm font-weight-bold text-danger">
                                    <i class="fas fa-file-pdf mr-1"></i> Export PDF
                                </a>
                                <button class="btn btn-success btn-sm font-weight-bold btn-create-entity"
                                    data-type="school">
                                    <i class="fas fa-plus mr-1"></i> Add School
                                </button>
                            </div>
                        </div>
                        <table class="table table-hover table-striped mb-0" id="table-schools">
                            <thead>
                                <tr>
                                    <th>School Code</th>
                                    <th>Facility Name</th>
                                    <th>Assigned District</th>
                                    <th style="width: 180px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schools as $school)
                                    <tr id="school-row-{{ $school->id }}">
                                        <td><code>{{ $school->school_code }}</code></td>
                                        <td class="name-field">{{ $school->name }}</td>
                                        <td class="relation-field">{{ $school->district->name ?? 'Unassigned' }}</td>
                                        <td>
                                            <button class="btn btn-info btn-sm btn-edit-entity" data-type="school"
                                                data-id="{{ $school->id }}"><i class="fas fa-pencil-alt"></i></button>
                                            <button class="btn btn-danger btn-sm btn-delete-entity" data-type="school"
                                                data-id="{{ $school->id }}"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- DISTRICTS TAB PANEL -->
                    <div class="tab-pane fade p-3" id="panel-districts" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0 text-secondary font-weight-bold">Jurisdiction Districts</h5>
                            <button class="btn btn-success btn-sm btn-create-entity" data-type="district"><i
                                    class="fas fa-plus mr-1"></i> Add District</button>
                        </div>
                        <table class="table table-hover table-striped mb-0" id="table-districts">
                            <thead>
                                <tr>
                                    <th>District Code</th>
                                    <th>District Name</th>
                                    <th style="width: 180px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($districts as $district)
                                    <tr id="district-row-{{ $district->id }}">
                                        <td><code>{{ $district->code }}</code></td>
                                        <td class="name-field">{{ $district->name }}</td>
                                        <td>
                                            <button class="btn btn-info btn-sm btn-edit-entity" data-type="district"
                                                data-id="{{ $district->id }}"><i class="fas fa-pencil-alt"></i></button>
                                            <button class="btn btn-danger btn-sm btn-delete-entity" data-type="district"
                                                data-id="{{ $district->id }}"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- OFFICES TAB PANEL -->
                    <div class="tab-pane fade p-3" id="panel-offices" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0 text-secondary font-weight-bold">HQ & Branch Locations</h5>
                            <button class="btn btn-success btn-sm btn-create-entity" data-type="office"><i
                                    class="fas fa-plus mr-1"></i> Add Office</button>
                        </div>
                        <table class="table table-hover table-striped mb-0" id="table-offices">
                            <thead>
                                <tr>
                                    <th>Office Department</th>
                                    <th>Building/Location Mapping</th>
                                    <th style="width: 180px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($offices as $office)
                                    <tr id="office-row-{{ $office->id }}">
                                        <td class="name-field">{{ $office->name }}</td>
                                        <td class="location-field text-muted">{{ $office->building_location ?? 'N/A' }}
                                        </td>
                                        <td>
                                            <button class="btn btn-info btn-sm btn-edit-entity" data-type="office"
                                                data-id="{{ $office->id }}"><i class="fas fa-pencil-alt"></i></button>
                                            <button class="btn btn-danger btn-sm btn-delete-entity" data-type="office"
                                                data-id="{{ $office->id }}"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- DYNAMIC PROCESSING OVERLAY MODAL -->
    <div class="modal fade" id="entityModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="entityForm">
                    <input type="hidden" id="entity_id">
                    <input type="hidden" id="entity_type">

                    <div class="modal-header bg-navy text-white">
                        <h5 class="modal-title" id="modalTitle">Entity Management</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger d-none" id="form-errors"></div>

                        <div id="dynamic-fields-container">
                            <!-- Content injected via JavaScript dynamically based on data-type context tracking -->
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btn-save">Persist Record</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // --- FIELD SCHEMA DEFINITIONS GENERATOR ---
            function buildFormSchema(type, data = {}) {
                let html = '';
                if (type === 'school') {
                    html = `
                    <div class="form-group">
                        <label>School Facility Name</label>
                        <input type="text" class="form-control" name="name" value="${data.name || ''}" required>
                    </div>
                    <div class="form-group">
                        <label>School Identity Code</label>
                        <input type="text" class="form-control" name="school_code" value="${data.school_code || ''}" required>
                    </div>
                    <div class="form-group">
                        <label>Target District Jurisdiction</label>
                        <select class="form-control" name="district_id" id="form-select-district" required>
                            <option value="">-- Associate District --</option>
                            @foreach ($districts as $d)
                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>`;
                } else if (type === 'district') {
                    html = `
                    <div class="form-group">
                        <label>District Structural Title</label>
                        <input type="text" class="form-control" name="name" value="${data.name || ''}" required>
                    </div>
                    <div class="form-group">
                        <label>District Key Code</label>
                        <input type="text" class="form-control" name="code" value="${data.code || ''}" required>
                    </div>`;
                } else if (type === 'office') {
                    html = `
                    <div class="form-group">
                        <label>Office / Department Title</label>
                        <input type="text" class="form-control" name="name" value="${data.name || ''}" required>
                    </div>
                    <div class="form-group">
                        <label>Building & Location Context Details</label>
                        <input type="text" class="form-control" name="building_location" value="${data.building_location || ''}">
                    </div>`;
                }
                $('#dynamic-fields-container').html(html);
                if (type === 'school' && data.district_id) {
                    $('#form-select-district').val(data.district_id);
                }
            }

            // --- OPEN MODAL FOR CREATION LOOP ---
            $(document).on('click', '.btn-create-entity', function() {
                let type = $(this).data('type');
                $('#entityForm')[0].reset();
                $('#entity_id').val('');
                $('#entity_type').val(type);
                $('#modalTitle').text(`Register New ${type.toUpperCase()}`);
                $('#form-errors').addClass('d-none').html('');
                buildFormSchema(type);
                $('#entityModal').modal('show');
            });

            // --- OPEN MODAL FOR UPDATE LOOP (EDIT) ---
            $(document).on('click', '.btn-edit-entity', function() {
                let type = $(this).data('type');
                let id = $(this).data('id');
                $('#form-errors').addClass('d-none').html('');

                $.get(`/master-data/${type}/${id}`, function(entity) {
                    $('#entity_id').val(entity.id);
                    $('#entity_type').val(type);
                    $('#modalTitle').text(`Modify ${type.toUpperCase()} Metadata`);
                    buildFormSchema(type, entity);
                    $('#entityModal').modal('show');
                });
            });

            // --- UNIFIED PERSISTENCE HANDLER (CREATE / UPDATE) ---
            $('#entityForm').submit(function(e) {
                e.preventDefault();
                $('#btn-save').prop('disabled', true).text('Writing updates...');

                let id = $('#entity_id').val();
                let type = $('#entity_type').val();
                let url = id ? `/master-data/${type}/${id}` : `/master-data/${type}`;
                let method = id ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    type: method,
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(res) {
                        $('#entityModal').modal('hide');
                        $('#btn-save').prop('disabled', false).text('Persist Record');

                        let targetTableBody = $(`#table-${type}s tbody`);
                        let rowHtml = '';

                        // Construct dynamically matching target subschema markup rules
                        if (type === 'school') {
                            rowHtml = `
                        <tr id="school-row-${res.data.id}">
                            <td><code>${res.data.school_code}</code></td>
                            <td class="name-field">${res.data.name}</td>
                            <td class="relation-field">${res.data.district ? res.data.district.name : 'Unassigned'}</td>
                            <td>
                                <button class="btn btn-info btn-sm btn-edit-entity" data-type="school" data-id="${res.data.id}"><i class="fas fa-pencil-alt"></i></button>
                                <button class="btn btn-danger btn-sm btn-delete-entity" data-type="school" data-id="${res.data.id}"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>`;
                        } else if (type === 'district') {
                            rowHtml = `
                        <tr id="district-row-${res.data.id}">
                            <td><code>${res.data.code}</code></td>
                            <td class="name-field">${res.data.name}</td>
                            <td>
                                <button class="btn btn-info btn-sm btn-edit-entity" data-type="district" data-id="${res.data.id}"><i class="fas fa-pencil-alt"></i></button>
                                <button class="btn btn-danger btn-sm btn-delete-entity" data-type="district" data-id="${res.data.id}"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>`;
                        } else if (type === 'office') {
                            rowHtml = `
                        <tr id="office-row-${res.data.id}">
                            <td class="name-field">${res.data.name}</td>
                            <td class="location-field text-muted">${res.data.building_location || 'N/A'}</td>
                            <td>
                                <button class="btn btn-info btn-sm btn-edit-entity" data-type="office" data-id="${res.data.id}"><i class="fas fa-pencil-alt"></i></button>
                                <button class="btn btn-danger btn-sm btn-delete-entity" data-type="office" data-id="${res.data.id}"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>`;
                        }

                        if (id) {
                            $(`#${type}-row-${id}`).replaceWith(rowHtml);
                        } else {
                            targetTableBody.prepend(rowHtml);
                        }

                        Swal.fire({
                            icon: 'success',
                            title: 'Dataset Updated',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                    },
                    error: function(xhr) {
                        $('#btn-save').prop('disabled', false).text('Persist Record');
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
                                title: 'Fault Triggered',
                                text: 'Master data table constraints broken.'
                            });
                        }
                    }
                });
            });

            // --- HARD DATA RETRACTION HANDLER (DELETE) ---
            $(document).on('click', '.btn-delete-entity', function() {
                let type = $(this).data('type');
                let id = $(this).data('id');
                let row = $(`#${type}-row-${id}`);

                Swal.fire({
                    title: `Purge this ${type.toUpperCase()}?`,
                    text: "Deleting master structural units may orphan nested database relational mapping values permanently.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Delete Structural Element'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/master-data/${type}/${id}`,
                            type: 'DELETE',
                            success: function(res) {
                                row.fadeOut(350, function() {
                                    $(this).remove();
                                });
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Purged',
                                    text: res.message,
                                    timer: 1200,
                                    showConfirmButton: false
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'System Constraint Block',
                                    text: xhr.responseJSON?.message ||
                                        'Access violation.'
                                });
                            }
                        });
                    }
                });
            });

        });
    </script>
@endpush
