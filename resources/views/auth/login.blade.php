@extends('layouts.auth-split')

@section('title', 'Login')

@section('content')

    <div class="w-100 px-lg-5 px-4">

        <div class="mx-auto" style="max-width:420px;">

            <h2 class="fw-bold mb-2">
                Welcome Back
            </h2>

            <p class="text-muted mb-4">
                Sign in to continue.
            </p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label small text-muted mb-1" for="email">Email/Username/Employee ID</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror" required autofocus>

                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                <div class="mb-3">
                    <label class="form-label small text-muted mb-1" for="password">Password</label>
                    <div class="input-group ">
                        <input type="password" name="password" id="password"
                            class="form-control @error('password') is-invalid @enderror" required>

                        {{-- Wrapped in input-group-text and set up for clean pointer styling --}}
                        <span class="input-group-text cursor-pointer" id="toggle-password-visibility">
                            <i class="fas fa-eye-slash text-muted" id="password-icon"></i>
                        </span>

                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    {{-- <label class="form-label small text-muted mb-1">Security Verification</label> --}}
                    <div class="row g-2">
                        <div class="col-6">
                            <input type="text" name="captcha"
                                class="form-control  @error('captcha') is-invalid @enderror" placeholder="Enter captcha"
                                required autocomplete="off">
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <div class="border rounded bg-light text-center pyx-1 cursor-pointer"
                                    id="captcha-img-container">
                                    <img src="{{ captcha_src('default') }}"
                                        onclick="this.src='/captcha/default?'+Math.random()" id="captchaCode" alt=""
                                        class="captcha " title="Refresh Captcha" style="cursor: pointer;">

                                </div>
                                <button type="button" class="btn btn-sm btn-secondary" id="reload-captcha"
                                    title="Refresh Captcha">
                                    <i class="fas fa-sync-alt "></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @error('captcha')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>



                <button class="btn btn-primary w-100 fw-bold" type="submit">

                    <i class="fas fa-sign-in-alt me-2"></i>

                    Login

                </button>

            </form>

            @if (Route::has('register'))
                <div class="text-center mt-4">

                    Don't have an account?

                    <a href="{{ route('register') }}" class="fw-bold text-decoration-none">
                        Register
                    </a>

                </div>
            @endif

        </div>

    </div>

@endsection

@push('scripts')
    <script>
        document.getElementById('toggle-password-visibility').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('password-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const reloadBtn = document.getElementById('reload-captcha');
            const container = document.getElementById('captcha-img-container');

            if (reloadBtn && container) {
                reloadBtn.addEventListener('click', function() {
                    // Add a small spinning utility trick for UI feedback
                    const icon = reloadBtn.querySelector('i');
                    icon.classList.add('fa-spin');

                    fetch('/reload-captcha')
                        .then(response => response.json())
                        .then(data => {
                            container.innerHTML = data.captcha;
                            icon.classList.remove('fa-spin');
                        })
                        .catch(error => {
                            console.error('Error refreshing captcha:', error);
                            icon.classList.remove('fa-spin');
                        });
                });
            }
        });
    </script>
@endpush
