@extends('auth.layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="row min-vh-100">

        <!-- Left side: Login form -->
        <div class="col-lg-6 d-flex flex-column justify-content-center text-white p-5 bg-dark">
            <div class="mx-auto" style="max-width: 380px; width: 100%;">

                <div class="text-center mb-4">
                    <p class="text-muted">
                        Don't have an account?
                        <a href="{{ route('register.form') }}" class="text-white fw-bold">Register</a>
                    </p>
                    <h4 class="fw-bold text-white">Login to your account</h4>
                    <p class="text-muted">Please enter your details to login.</p>
                </div>

                <!-- Google login button (placeholder) -->
                <div class="d-grid mb-3">
                    <a href="#" class="btn btn-dark border rounded py-2">
                        <span class="fw-semibold" style="font-size: .875rem">G Continue with Google</span>
                    </a>
                </div>

                <div class="d-flex align-items-center mb-3 text-muted">
                    <hr class="flex-grow-1 border-secondary">
                    <span class="mx-2" style="font-size: .75rem">Or continue with</span>
                    <hr class="flex-grow-1 border-secondary">
                </div>

                <!-- Form login -->
                <form method="POST" action="{{ route('login.submit') }}">
                    @csrf
                    {{-- Email/Login field --}}
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="email" class="form-label text-white">Email Address</label>
                            <input type="text" id="email" name="email" value="{{ old('email') }}"
                                class="form-control bg-black text-white border-dark @error('email') is-invalid @enderror"
                                placeholder="you@example.com" required autofocus>

                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Password field --}}
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="password" class="form-label text-white">Password</label>
                            <input type="password" id="password" name="password"
                                class="form-control bg-black text-white border-dark @error('password') is-invalid @enderror"
                                placeholder="••••••••" required>

                            {{-- Tampilkan error field password --}}
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-light fw-semibold text-dark" style="font-size: .875rem">Login</button>
                    </div>
                </form>

                {{-- Error umum dari backend (contoh: "The login field is required." atau "Invalid credentials") --}}
                @if ($errors->has('general'))
                    <div class="alert alert-danger mt-3 small">
                        {{ $errors->first('general') }}
                    </div>
                @endif

                <div class="text-center mt-4 small text-muted">
                    © 2025, Algo Admin.
                    <span class="ms-2"><i class="bi bi-globe"></i> ENG</span>
                </div>
            </div>
        </div>
        <!-- Right side: Info panel -->
        <div
            class="col-lg-6 d-none d-lg-flex flex-column justify-content-center bg-xlight text-dark p-5 rounded-start-4 rounded-end-4 h-95vh">
            <div class="mx-auto" style="max-width: 400px; width: 100%;">
                <div class="mb-5">
                    <i class="bi bi-command fs-2"></i>
                    <h2 class="fw-bold mt-3">Algo Admin</h2>
                    <p class="text-dark">Design. Build. Launch. Repeat.</p>
                </div>
                <div class="row">
                    <div class="col-6">
                        <h6 class="fw-bold">Ready to launch?</h6>
                        <p class="text-dark">Clone the repo, install dependencies, and your dashboard is live in
                            minutes.</p>
                    </div>
                    <div class="col-6">
                        <h6 class="fw-bold">Need help?</h6>
                        <p class="text-dark">Check out the docs or open an issue on GitHub, community support is just
                            a click away.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
