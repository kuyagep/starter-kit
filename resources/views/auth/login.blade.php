@extends('layouts.auth-split')

@section('title', 'Login')

@section('content')

    <div class="w-100 px-lg-5 px-4">

        <div class="mx-auto" style="max-width:420px;">

            <!-- Branding Logo Section (Uses System Settings fallback) -->
            <div class="mb-4 text-center text-lg-start">
                <a href="{{ url('/') }}">
                    <img src="{{ !empty($settings['app_logo']) ? asset('storage/' . $settings['app_logo']) : 'http://127.0.0.1:8000/v1/images/division_logo_blue.png' }}"
                        alt="{{ $settings['app_name'] ?? 'System Logo' }}" class="img-fluid" style="max-height: 90px;">
                </a>
            </div>

            <!-- Header Text -->
            <div class="mb-4">
                <h3 class="fw-bold text-dark mb-1">Welcome back</h3>
                <p class="text-muted small">Please enter your credentials to access your account.</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="needs-validation">
                @csrf

                <!-- Email / Username / Employee ID -->
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary mb-1" for="email">
                        Email, Username, or Employee ID
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0">
                            <i class="fas fa-user"></i>
                        </span>
                        <input type="text" name="email" id="email" value="{{ old('email') }}"
                            class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror"
                            placeholder="e.g. user@domain.com or EMP-100" required autofocus>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Password Input -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label small fw-semibold text-secondary mb-0" for="password">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="small text-decoration-none fw-semibold">
                                Forgot password?
                            </a>
                        @endif
                    </div>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password" id="password"
                            class="form-control border-start-0 border-end-0 px-0 @error('password') is-invalid @enderror"
                            placeholder="••••••••" required>
                        <button class="btn btn-outline-default border-start-0 border" type="button"
                            id="toggle-password-visibility" tabindex="-1">
                            <i class="fas fa-eye-slash text-muted" id="password-icon"></i>
                        </button>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Security Verification / Captcha -->
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary mb-1">Security Check</label>
                    <div class="row g-2 align-items-center">
                        <div class="col-7">
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted border-end-0">
                                    <i class="fas fa-shield-alt"></i>
                                </span>
                                <input type="text" name="captcha"
                                    class="form-control border-start-0 ps-0 @error('captcha') is-invalid @enderror"
                                    placeholder="Enter captcha code" required autocomplete="off">
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="d-flex align-items-center justify-content-between border rounded bg-white p-1">
                                <div id="captcha-img-container" class="w-100 text-center cursor-pointer">
                                    <img src="{{ captcha_src('default') }}"
                                        onclick="this.src='/captcha/default?'+Math.random()" id="captchaCode"
                                        alt="Captcha Code" class="captcha img-fluid" title="Click to refresh"
                                        style="cursor: pointer; max-height: 34px;">
                                </div>
                                <button type="button" class="btn btn-sm btn-light text-secondary border-0 ms-1"
                                    id="reload-captcha" title="Refresh Captcha">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @error('captcha')
                        <div class="invalid-feedback d-block small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember Me Checkbox -->
                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember"
                        {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label small text-muted" for="remember">Keep me signed in on this device</label>
                </div>

                <!-- Submit Button -->
                <button class="btn btn-primary w-100 py-2 fw-bold shadow-sm" type="submit" id="btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i> Sign In
                </button>

            </form>

            <!-- Registration Link -->
            @if (Route::has('register'))
                <div class="text-center mt-4">
                    <span class="small text-muted">Don't have an account yet?</span>
                    <a href="{{ route('register') }}" class="fw-bold text-decoration-none small ms-1">
                        Create an account
                    </a>
                </div>
            @endif

            <!-- Footer Meta Info -->
            <div class="text-center mt-5 pt-3 border-top">
                <p class="small text-muted mb-0">
                    &copy; {{ date('Y') }} {{ $settings['app_name'] ?? 'DRMS Core' }}. All rights reserved.
                </p>
            </div>

        </div>

    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle Password Visibility
            const togglePasswordBtn = document.getElementById('toggle-password-visibility');
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('password-icon');

            if (togglePasswordBtn) {
                togglePasswordBtn.addEventListener('click', function() {
                    const isPassword = passwordInput.type === 'password';
                    passwordInput.type = isPassword ? 'text' : 'password';
                    passwordIcon.classList.toggle('fa-eye-slash', !isPassword);
                    passwordIcon.classList.toggle('fa-eye', isPassword);
                });
            }

            // Reload Captcha with UI Loading Feedback
            const reloadBtn = document.getElementById('reload-captcha');
            const container = document.getElementById('captcha-img-container');

            if (reloadBtn && container) {
                reloadBtn.addEventListener('click', function() {
                    const icon = reloadBtn.querySelector('i');
                    icon.classList.add('fa-spin');

                    fetch('/reload-captcha')
                        .then(response => response.json())
                        .then(data => {
                            container.innerHTML = data.captcha;
                        })
                        .catch(error => {
                            console.error('Captcha reload error:', error);
                        })
                        .finally(() => {
                            icon.classList.remove('fa-spin');
                        });
                });
            }
        });
    </script>
@endpush
