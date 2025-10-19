@extends('layouts.app')

@section('title', 'Tambah Admin')

@push('styles')
    <!-- Tambahkan CSS khusus jika perlu -->
@endpush

@section('content')
    <div id="main-content">
        <div class="page-heading">
            <!-- Page Title & Breadcrumb -->
            <div class="page-title">
                <div class="row align-items-center">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Tambah Admin</h3>
                        <p class="text-subtitle text-muted">
                            Masukkan data admin baru.
                        </p>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admins.list') }}">Daftar Admin</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Tambah Admin
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Form Create Admin -->
            <section class="section">
                <div class="card mt-4">
                    <div class="card-body">
                        <form action="{{ route('admins.store') }}" method="POST">
                            @csrf
                            {{-- First Name --}}
                            <div class="mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text"
                                    class="form-control @error('first_name') is-invalid @enderror"
                                    id="first_name" name="first_name" value="{{ old('first_name') }}" placeholder="John"
                                    required>
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Last Name --}}
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text"
                                    class="form-control @error('last_name') is-invalid @enderror"
                                    id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="Doe"
                                    required>
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com"
                                    required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Birth Date --}}
                            <div class="mb-3">
                                <label for="birth_date" class="form-label">Birth Date</label>
                                <input type="date"
                                    class="form-control @error('birth_date') is-invalid @enderror"
                                    id="birth_date" name="birth_date" value="{{ old('birth_date') }}" required>
                                @error('birth_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Gender --}}
                            <div class="mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select
                                    class="form-control @error('gender') is-invalid @enderror"
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

                            {{-- Password --}}
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="••••••••" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Confirm Password --}}
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control"
                                    id="password_confirmation" name="password_confirmation" placeholder="••••••••" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('admins.list') }}" class="btn btn-secondary">Kembali</a>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Tambahkan JS khusus jika perlu -->
@endpush
