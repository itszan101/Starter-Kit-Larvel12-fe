@extends('auth.layouts.auth')

@section('title', 'Register')

@section('content')
    <div class="row min-vh-100">

        <!-- Left side: Login form -->
        <div class="col-lg-6 d-flex flex-column justify-content-center text-white p-5">
            <div class="mx-auto" style="max-width: 380px; width: 100%;">

                <div class="text-center mb-4">
                    <p class="text-muted">Already have an account? <a href="{{ route('login') }}"
                            class="text-white fw-bold">Login</a></p>
                    <h4 class="fw-bold">Create your account</h4>
                    <p class="text-muted">Please enter your details to register.</p>
                </div>

                <!-- Google login button -->
                <div class="d-grid mb-3">
                    <a href="#" class="btn btn-dark border rounded py-2">
                        <span class="fw-semibold" style="font-size: .875rem">G Continue with Google</span>
                    </a>
                </div>

                <div class="d-flex align-items-center mb-3 text-muted">
                    <hr class="flex-grow-1 border-secondary">
                    <span class="mx-2 small" style="font-size: .75rem">Or continue with</span>
                    <hr class="flex-grow-1 border-secondary">
                </div>

                <!-- Form register -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- First Name --}}
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="first_name" class="form-label text-white">First Name</label>
                            <input type="text"
                                class="form-control bg-black text-white border-dark @error('first_name') is-invalid @enderror"
                                id="first_name" name="first_name" value="{{ old('first_name') }}" placeholder="John"
                                required>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Last Name --}}
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="last_name" class="form-label text-white">Last Name</label>
                            <input type="text"
                                class="form-control bg-black text-white border-dark @error('last_name') is-invalid @enderror"
                                id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="Doe" required>
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="email" class="form-label text-white">Email Address</label>
                            <input type="email"
                                class="form-control bg-black text-white border-dark @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com"
                                required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Birth Date --}}
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="birth_date" class="form-label text-white">Birth Date</label>
                            <input type="date"
                                class="form-control bg-black text-white border-dark @error('birth_date') is-invalid @enderror"
                                id="birth_date" name="birth_date" value="{{ old('birth_date') }}" required>
                            @error('birth_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Gender --}}
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="gender" class="form-label text-white">Gender</label>
                            <select
                                class="form-control bg-black text-white border-dark @error('gender') is-invalid @enderror"
                                id="gender" name="gender" required>
                                <option value="" disabled selected>-- Pilih Gender --</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki
                                </option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan
                                </option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="password" class="form-label text-white">Password</label>
                            <input type="password"
                                class="form-control bg-black text-white border-dark @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="••••••••" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Confirm Password --}}
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="password_confirmation" class="form-label text-white">Confirm Password</label>
                            <input type="password" class="form-control bg-black text-white border-dark"
                                id="password_confirmation" name="password_confirmation" placeholder="••••••••" required>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-xlight fw-semibold text-dark" style="font-size: .875rem">Register</button>
                    </div>
                </form>

                {{-- Error umum --}}
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
                        <p class="small text-dark">Clone the repo, install dependencies, and your dashboard is live in
                            minutes.</p>
                    </div>
                    <div class="col-6">
                        <h6 class="fw-bold">Need help?</h6>
                        <p class="small text-dark">Check out the docs or open an issue on GitHub, community support is just
                            a click away.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
