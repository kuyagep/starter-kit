@extends('layouts.main')

@section('title', 'My Profile')
@section('content-header', 'My Profile')

{{-- Added structural CSRF meta setup if it isn't defined inside layouts.main --}}
@section('meta')
    <meta class="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            {{-- Session Flash Messages --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="icon fas fa-check"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row">
                {{-- LEFT COLUMN: PROFILE CARD --}}
                <div class="col-md-4">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                    src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=0D8ABC&color=fff&size=256' }}"
                                    alt="Profile Avatar">
                            </div>

                            <h3 class="profile-username text-center">
                                {{ auth()->user()->name }}
                            </h3>

                            <p class="text-muted text-center mb-0">
                                {{ auth()->user()->email }}
                            </p>
                            <p class="text-center mt-0">
                                <span class="badge badge-secondary">@ {{ auth()->user()->username }}</span>
                            </p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Employee ID</b>
                                    <span class="float-right text-muted">{{ auth()->user()->employee_id ?? 'N/A' }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Assigned Office</b>
                                    <span class="float-right text-muted">
                                        {{ auth()->user()->office->name ?? 'Unassigned' }}
                                        <span
                                            class="badge badge-secondary ml-1">{{ auth()->user()->office->office_type ?? '' }}</span>
                                        @if (auth()->user()->office?->isSchool())
                                            <small class="d-block text-right text-secondary">School ID:
                                                {{ auth()->user()->office->school_id }}</small>
                                        @endif
                                    </span>
                                </li>
                                <li class="list-group-item">
                                    <b>Account Status</b>
                                    <span class="float-right">
                                        <span
                                            class="badge badge-{{ auth()->user()->status === 'active' ? 'success' : (auth()->user()->status === 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst(auth()->user()->status) }}
                                        </span>
                                    </span>
                                </li>
                                <li class="list-group-item">
                                    <b>Mobile Number</b>
                                    <span
                                        class="float-right text-muted">{{ auth()->user()->mobile_number ?? 'Not Provided' }}</span>
                                </li>
                                <li class="list-group-item">
                                    <b>Roles</b>
                                    <span class="float-right">
                                        @forelse (auth()->user()->roles as $role)
                                            <span class="badge badge-primary">{{ $role->name }}</span>
                                        @empty
                                            <span class="text-muted small">No roles assigned</span>
                                        @endforelse
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- RIGHT COLUMN: FORMS --}}
                <div class="col-md-8">
                    {{-- Update Profile Details --}}
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Update Profile Details</h3>
                        </div>

                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="card-body">

                                {{-- SECTION: NAME BREAKDOWN --}}
                                <h5 class="text-primary border-bottom pb-2 mb-3">Name Details</h5>
                                <div class="row">
                                    <div class="col-md-2 form-group">
                                        <label class="form-label small text-muted mb-1" for="prefix">Prefix</label>
                                        <input type="text" name="prefix" id="prefix"
                                            class="form-control @error('prefix') is-invalid @enderror"
                                            value="{{ old('prefix', auth()->user()->prefix) }}"
                                            placeholder="e.g., Mr., Ms.">
                                        @error('prefix')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label class="form-label small text-muted mb-1" for="first_name">First Name</label>
                                        <input type="text" name="first_name" id="first_name"
                                            class="form-control @error('first_name') is-invalid @enderror"
                                            value="{{ old('first_name', auth()->user()->first_name) }}" required>
                                        @error('first_name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label class="form-label small text-muted mb-1" for="middle_name">Middle
                                            Name</label>
                                        <input type="text" name="middle_name" id="middle_name"
                                            class="form-control @error('middle_name') is-invalid @enderror"
                                            value="{{ old('middle_name', auth()->user()->middle_name) }}">
                                        @error('middle_name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label class="form-label small text-muted mb-1" for="last_name">Last Name</label>
                                        <input type="text" name="last_name" id="last_name"
                                            class="form-control @error('last_name') is-invalid @enderror"
                                            value="{{ old('last_name', auth()->user()->last_name) }}" required>
                                        @error('last_name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label class="form-label small text-muted mb-1" for="suffix">Suffix</label>
                                        <input type="text" name="suffix" id="suffix"
                                            class="form-control @error('suffix') is-invalid @enderror"
                                            value="{{ old('suffix', auth()->user()->suffix) }}"
                                            placeholder="e.g., Jr., III">
                                        @error('suffix')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- SECTION: AUTH & DETAILS --}}
                                <h5 class="text-primary border-bottom pb-2 mt-3 mb-3">Profile Information</h5>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="form-label small text-muted mb-1" for="username">Username</label>
                                        <input type="text" name="username" id="username"
                                            class="form-control @error('username') is-invalid @enderror"
                                            value="{{ old('username', auth()->user()->username) }}" required>
                                        @error('username')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form-label small text-muted mb-1" for="email">Email
                                            address</label>
                                        <input type="email" id="email" class="form-control"
                                            value="{{ auth()->user()->email }}" disabled>
                                        <small class="text-muted">Contact administrator</small>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label class="form-label small text-muted mb-1" for="gender">Gender</label>
                                        <select name="gender" id="gender"
                                            class="form-control @error('gender') is-invalid @enderror">
                                            <option value="">Select Gender</option>
                                            <option value="Male"
                                                {{ old('gender', auth()->user()->gender) === 'Male' ? 'selected' : '' }}>
                                                Male</option>
                                            <option value="Female"
                                                {{ old('gender', auth()->user()->gender) === 'Female' ? 'selected' : '' }}>
                                                Female</option>
                                            <option value="Other"
                                                {{ old('gender', auth()->user()->gender) === 'Other' ? 'selected' : '' }}>
                                                Other</option>
                                        </select>
                                        @error('gender')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="form-label small text-muted mb-1" for="mobile_number">Mobile
                                            Number</label>
                                        <input type="text" name="mobile_number" id="mobile_number"
                                            class="form-control @error('mobile_number') is-invalid @enderror"
                                            value="{{ old('mobile_number', auth()->user()->mobile_number) }}">
                                        @error('mobile_number')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="form-label small text-muted mb-1" for="birthdate">Birthdate</label>
                                        <input type="date" name="birthdate" id="birthdate"
                                            class="form-control @error('birthdate') is-invalid @enderror"
                                            value="{{ old('birthdate', auth()->user()->birthdate ? \Carbon\Carbon::parse(auth()->user()->birthdate)->format('Y-m-d') : '') }}">
                                        @error('birthdate')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label class="form-label small text-muted mb-1" for="religion">Religion</label>
                                        <input type="text" name="religion" id="religion"
                                            class="form-control @error('religion') is-invalid @enderror"
                                            value="{{ old('religion', auth()->user()->religion) }}">
                                        @error('religion')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="form-label small text-muted mb-1" for="disability">Disability
                                            Status</label>
                                        <input type="text" name="disability" id="disability"
                                            class="form-control @error('disability') is-invalid @enderror"
                                            value="{{ old('disability', auth()->user()->disability) }}">
                                        @error('disability')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="form-label small text-muted mb-1" for="ethnic_group">Ethnic
                                            Group</label>
                                        <input type="text" name="ethnic_group" id="ethnic_group"
                                            class="form-control @error('ethnic_group') is-invalid @enderror"
                                            value="{{ old('ethnic_group', auth()->user()->ethnic_group) }}">
                                        @error('ethnic_group')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label class="form-label small text-muted mb-1" for="avatar">Change Avatar
                                            Image</label>
                                        <div class="custom-file">
                                            <input type="file" name="avatar" id="avatar"
                                                class="custom-file-input @error('avatar') is-invalid @enderror">
                                            <label class="custom-file-label" for="avatar">Choose file...</label>
                                        </div>
                                        @error('avatar')
                                            <span class="text-danger small d-block mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- SECTION: ADDRESS ALIGNMENT --}}
                                <h5 class="text-primary border-bottom pb-2 mt-3 mb-3">Address Details</h5>
                                <div class="row">
                                    <!-- Province Select -->
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label for="province-select" class="small text-muted mb-1">Province</label>
                                            <select name="province_id" id="province-select"
                                                class="form-control @error('province_id') is-invalid @enderror"
                                                style="width: 100%;">
                                                <option value="" selected disabled>Select Province</option>
                                                @foreach ($provinces as $province)
                                                    <option value="{{ $province->province_id }}">{{ $province->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('province_id')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- City Select -->
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label class="form-label small text-muted mb-1">City / Municipality</label>
                                            <select name="city_id" id="city-select"
                                                class="form-control @error('city_id') is-invalid @enderror" disabled>
                                                <option value="" selected disabled>Select City/Municipality first
                                                </option>
                                            </select>
                                            @error('city_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Barangay Select -->
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group">
                                            <label class="form-label small text-muted mb-1">Barangay</label>
                                            <select name="barangay_id" id="barangay-select"
                                                class="form-control @error('barangay_id') is-invalid @enderror" disabled>
                                                <option value="" selected disabled>Select Barangay first</option>
                                            </select>
                                            @error('barangay_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-2 mb-3">
                                    <div class="col-12">
                                        <label class="form-label small text-muted mb-1">Purok / Zone / Street</label>
                                        <input type="text" name="purok" value="{{ old('purok') }}"
                                            class="form-control @error('purok') is-invalid @enderror"
                                            placeholder="e.g., Purok 3, Roxas St.">
                                        @error('purok')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div> {{-- Closes card-body --}}

                            <div class="card-footer text-right">
                                <button class="btn btn-primary px-4">
                                    <i class="fas fa-save mr-1"></i> Save Profile Details
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Change Password --}}
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Change Password</h3>
                        </div>

                        <form action="{{ route('profile.password') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-label small text-muted mb-1" for="current_password">Current
                                        Password</label>
                                    <input type="password" name="current_password" id="current_password"
                                        class="form-control @error('current_password') is-invalid @enderror" required>
                                    @error('current_password')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label small text-muted mb-1" for="password">New Password</label>
                                    <input type="password" name="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" required>
                                    @error('password')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label small text-muted mb-1" for="password_confirmation">Confirm
                                        Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control" required>
                                </div>
                            </div>

                            <div class="card-footer text-right">
                                <button class="btn btn-warning text-dark px-4">
                                    <i class="fas fa-key mr-1"></i> Change Password
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Permissions --}}
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Assigned System Permissions</h3>
                        </div>
                        <div class="card-body">
                            @forelse (auth()->user()->getAllPermissions() as $permission)
                                <span class="badge badge-success mb-1 py-2 px-2">
                                    <i class="fas fa-check-circle mr-1"></i> {{ $permission->name }}
                                </span>
                            @empty
                                <span class="text-muted">No explicit permissions assigned to this account.</span>
                            @endforelse
                        </div>
                    </div>
                </div> {{-- Closes right column col-md-8 --}}
            </div> {{-- Closes structural row --}}
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Live listener for your dynamic layout custom-file inputs
            $(document).on('change', '#avatar', function(e) {
                if (e.target.files.length > 0) {
                    var fileName = e.target.files[0].name;
                    $(this).next('.custom-file-label').text(fileName);
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const provinceSelect = document.getElementById('province-select');
            const citySelect = document.getElementById('city-select');
            const barangaySelect = document.getElementById('barangay-select');

            // Get the CSRF token from the meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            // 1. When Province Changes -> Fetch Cities
            provinceSelect.addEventListener('change', function() {
                const provinceId = this.value;

                citySelect.disabled = true;
                barangaySelect.disabled = true;
                citySelect.innerHTML = '<option value="" selected disabled>Loading cities...</option>';
                barangaySelect.innerHTML =
                    '<option value="" selected disabled>Select Barangay first</option>';

                fetch(`/address/cities/${provinceId}`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken // Added CSRF Token
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Fetched Cities:', data);
                        citySelect.innerHTML =
                            '<option value="" selected disabled>Select City/Municipality</option>';
                        data.forEach(city => {
                            citySelect.innerHTML +=
                                `<option value="${city.city_id}">${city.name}</option>`;
                        });
                        citySelect.disabled = false;
                    })
                    .catch(() => {
                        citySelect.innerHTML =
                            '<option value="" selected disabled>Error loading records</option>';
                    });
            });

            // 2. When City Changes -> Fetch Barangays
            citySelect.addEventListener('change', function() {
                const cityId = this.value;

                barangaySelect.disabled = true;
                barangaySelect.innerHTML =
                    '<option value="" selected disabled>Loading barangays...</option>';

                fetch(`/address/barangays/${cityId}`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken // Added CSRF Token
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        barangaySelect.innerHTML =
                            '<option value="" selected disabled>Select Barangay</option>';
                        data.forEach(barangay => {
                            barangaySelect.innerHTML +=
                                `<option value="${barangay.id}">${barangay.name}</option>`;
                        });
                        barangaySelect.disabled = false;
                    })
                    .catch(() => {
                        barangaySelect.innerHTML =
                            '<option value="" selected disabled>Error loading records</option>';
                    });
            });
        });
    </script>
@endpush
