@extends('layouts.auth-split')

@section('title', 'Official Government Registration')

@section('content')

    <div class="w-100">

        <div class="mx-auto" style="max-width:650px;">

            <h2 class="fw-bold mb-2 text-center">
                Applicant's Registration
            </h2>

            <p class="text-muted mb-4 text-center">
                Please provide accurate data in compliance with official record-keeping standards.
            </p>

            {{-- Wizard Progress Bar --}}
            <div class="position-relative mb-5">
                <div class="progress" style="height: 4px;">
                    <div class="progress-bar" id="wizard-progress" role="progressbar" style="width: 0%;" aria-valuenow="0"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="d-flex justify-content-between position-absolute top-50 start-0 translate-middle-y w-100">
                    <button type="button" class="btn btn-sm btn-primary rounded-pill step-indicator"
                        style="width: 2rem; height: 2rem;">1</button>
                    <button type="button" class="btn btn-sm btn-secondary rounded-pill step-indicator"
                        style="width: 2rem; height: 2rem;">2</button>
                    <button type="button" class="btn btn-sm btn-secondary rounded-pill step-indicator"
                        style="width: 2rem; height: 2rem;">3</button>
                </div>
            </div>

            <form method="POST" action="{{ route('register') }}" id="wizard-form">
                @csrf

                {{-- STEP 1: Personal Information --}}
                <div class="wizard-step">
                    <h5 class="text-primary mb-3 fw-semibold border-bottom pb-2">1. Personal Information</h5>

                    <div class="row g-2 mb-3">
                        <div class="col-md-2">
                            <label class="form-label small text-muted">Prefix</label>
                            <select name="prefix" class="form-select @error('prefix') is-invalid @enderror">
                                <option value="" selected disabled>-</option>
                                <option value="Mr." {{ old('prefix') == 'Mr.' ? 'selected' : '' }}>Mr.</option>
                                <option value="Ms." {{ old('prefix') == 'Ms.' ? 'selected' : '' }}>Ms.</option>
                                <option value="Mrs." {{ old('prefix') == 'Mrs.' ? 'selected' : '' }}>Mrs.</option>
                            </select>
                            @error('prefix')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small text-muted">Last Name</label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}"
                                class="form-control @error('last_name') is-invalid @enderror">
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small text-muted">First Name</label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}"
                                class="form-control @error('first_name') is-invalid @enderror" autofocus>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-1">
                            <label class="form-label small text-muted">Suffix</label>
                            <input type="text" name="suffix" value="{{ old('suffix') }}" placeholder="Jr"
                                class="form-control @error('suffix') is-invalid @enderror">
                            @error('suffix')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small text-muted">Middle Name</label>
                            <input type="text" name="middle_name" value="{{ old('middle_name') }}"
                                class="form-control @error('middle_name') is-invalid @enderror">
                            @error('middle_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>




                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-sm-12 col-md-6">
                            <label class="form-label small text-muted">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <label class="form-label small text-muted">Mobile Number (PH)</label>
                            <div class="input-group">
                                <span class="input-group-text">+63</span>
                                <input type="tel" name="mobile_number" value="{{ old('mobile_number') }}"
                                    class="form-control @error('mobile_number') is-invalid @enderror"
                                    placeholder="9123456789" pattern="9\d{9}"
                                    title="Please enter a valid 10-digit PH mobile number starting with 9">
                            </div>
                            @error('mobile_number')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Birthdate</label>
                            <input type="date" name="birthdate" value="{{ old('birthdate') }}"
                                class="form-control @error('birthdate') is-invalid @enderror">
                            @error('birthdate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted">Religion</label>
                            <input type="text" name="religion" value="{{ old('religion') }}"
                                placeholder="e.g., Roman Catholic"
                                class="form-control @error('religion') is-invalid @enderror">
                            @error('religion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Disability Status</label>
                            <select name="disability" class="form-select @error('disability') is-invalid @enderror">
                                <option value="No Data" {{ old('disability') == 'No Data' ? 'selected' : '' }}>No Data
                                </option>
                                <option value="No" {{ old('disability', 'No') == 'No' ? 'selected' : '' }}>No</option>
                                <option value="Yes" {{ old('disability') == 'Yes' ? 'selected' : '' }}>Yes</option>
                            </select>
                            @error('disability')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Ethnic Group</label>
                            <input list="ethnic_groups" name="ethnic_group" value="{{ old('ethnic_group') }}"
                                class="form-control @error('ethnic_group') is-invalid @enderror"
                                placeholder="Type or select an option...">
                            <datalist id="ethnic_groups">
                                <option value="None">
                                <option value="Mandaya">
                                <option value="Bicolano">
                                <option value="Ilocano">
                                <option value="Cebuano">
                                <option value="Kalagan">
                                <option value="Manobo">
                                <option value="Bisaya">
                                <option value="Bagobo">
                                <option value="Tausug">
                            </datalist>
                            @error('ethnic_group')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>

                {{-- STEP 2: Address Details --}}
                <div class="wizard-step d-none">
                    <h5 class="text-primary mb-3 fw-semibold border-bottom pb-2">2. Address Details</h5>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Province</label>
                            <select name="province_id" id="province-select"
                                class="form-select @error('province_id') is-invalid @enderror" required>
                                <option value="" selected disabled>Select Province</option>
                                {{-- Loop through initial provinces passed from your controller --}}
                                @foreach ($provinces ?? [] as $province)
                                    <option value="{{ $province->province_id }}">{{ $province->name }}</option>
                                @endforeach
                            </select>
                            @error('province_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted">City / Municipality</label>
                            <select name="city_id" id="city-select"
                                class="form-select @error('city_id') is-invalid @enderror" required disabled>
                                <option value="" selected disabled>Select City/Municipality first</option>
                            </select>
                            @error('city_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Barangay</label>
                            <select name="barangay_id" id="barangay-select"
                                class="form-select @error('barangay_id') is-invalid @enderror" required disabled>
                                <option value="" selected disabled>Select Barangay first</option>
                            </select>
                            @error('barangay_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted">Purok / Zone / Street</label>
                            <input type="text" name="purok" value="{{ old('purok') }}"
                                class="form-control @error('purok') is-invalid @enderror"
                                placeholder="e.g., Purok 3, Roxas St.">
                            @error('purok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- STEP 3: Account Credentials --}}
                <div class="wizard-step d-none">
                    <h5 class="text-primary mb-3 fw-semibold border-bottom pb-2">3. Account Credentials</h5>

                    <div class="mb-3">
                        <label class="form-label small text-muted">Username</label>
                        <input type="text" name="username" value="{{ old('username') }}"
                            class="form-control @error('username') is-invalid @enderror" required>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Password</label>
                            <input type="password" name="password" id="password"
                                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                title="Must contain at least one number, one uppercase, one lowercase letter, and at least 8 or more characters"
                                class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small text-muted">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" required>
                        </div>
                    </div>

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="togglePassword">
                        <label class="form-check-label small text-muted" for="togglePassword">
                            Show Passwords
                        </label>
                    </div>
                </div>

                {{-- Wizard Navigation Controls --}}
                <div class="d-flex justify-content-between mt-4 border-top pt-3">
                    <button type="button" class="btn btn-secondary px-4 invisible" id="prev-btn">
                        <i class="fas fa-arrow-left me-2"></i> Previous
                    </button>
                    <button type="button" class="btn btn-primary px-4" id="next-btn">
                        Next <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                    <button type="submit" class="btn btn-success px-4 d-none" id="submit-btn">
                        <i class="fas fa-user-plus me-2"></i> Register Account
                    </button>
                </div>

            </form>

            <div class="text-center mt-4">
                Already have an account?
                <a href="{{ route('login') }}" class="text-decoration-none fw-bold">Login</a>
            </div>

        </div>

    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const steps = document.querySelectorAll('.wizard-step');
            const indicators = document.querySelectorAll('.step-indicator');
            const progressBar = document.getElementById('wizard-progress');
            const prevBtn = document.getElementById('prev-btn');
            const nextBtn = document.getElementById('next-btn');
            const submitBtn = document.getElementById('submit-btn');
            const form = document.getElementById('wizard-form');

            let currentStep = 0;

            function updateWizard() {
                // Show/hide correct section fields
                steps.forEach((step, idx) => {
                    step.classList.toggle('d-none', idx !== currentStep);
                });

                // Update visual round pill steps
                indicators.forEach((indicator, idx) => {
                    if (idx <= currentStep) {
                        indicator.classList.replace('btn-secondary', 'btn-primary');
                    } else {
                        indicator.classList.replace('btn-primary', 'btn-secondary');
                    }
                });

                // Update thin connecting progress bar line
                const progressPercentage = (currentStep / (steps.length - 1)) * 100;
                progressBar.style.width = `${progressPercentage}%`;

                // Handle conditional visibility of Action Control Buttons
                prevBtn.classList.toggle('invisible', currentStep === 0);

                if (currentStep === steps.length - 1) {
                    nextBtn.classList.add('d-none');
                    submitBtn.classList.remove('d-none');
                } else {
                    nextBtn.classList.remove('d-none');
                    submitBtn.classList.add('d-none');
                }
            }

            function validateCurrentStep() {
                const inputs = steps[currentStep].querySelectorAll('input, select');
                let valid = true;
                inputs.forEach(input => {
                    if (!input.checkValidity()) {
                        input.reportValidity();
                        valid = false;
                    }
                });
                return valid;
            }

            nextBtn.addEventListener('click', function() {
                if (validateCurrentStep() && currentStep < steps.length - 1) {
                    currentStep++;
                    updateWizard();
                }
            });

            prevBtn.addEventListener('click', function() {
                if (currentStep > 0) {
                    currentStep--;
                    updateWizard();
                }
            });

            // Master checkbox event rule for password rendering text toggle
            document.getElementById('togglePassword').addEventListener('change', function() {
                let type = this.checked ? 'text' : 'password';
                document.getElementById('password').type = type;
                document.getElementById('password_confirmation').type = type;
            });

            updateWizard();
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
