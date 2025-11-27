@extends('layouts.app')

@section('title', 'Tambah Admin')

@push('styles')
    <!-- Tambahkan CSS khusus jika perlu -->
    <link rel="stylesheet" crossorigin href="{{ asset('assets/extensions/toastify-js/src/toastify.css') }}">
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

            <!-- Multiple Column Form -->
            <section id="multiple-column-form">
                <div class="row match-height">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Form Tambah Admin</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form class="form" action="{{ route('admins.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">

                                            <!-- First Name -->
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="first_name">Nama Depan</label>
                                                    <input type="text" id="first_name" name="first_name"
                                                        class="form-control @error('first_name') is-invalid @enderror"
                                                        value="{{ old('first_name') }}" placeholder="Masukkan nama depan"
                                                        required>
                                                    @error('first_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Last Name -->
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="last_name">Nama Belakang</label>
                                                    <input type="text" id="last_name" name="last_name"
                                                        class="form-control @error('last_name') is-invalid @enderror"
                                                        value="{{ old('last_name') }}" placeholder="Masukkan nama belakang"
                                                        required>
                                                    @error('last_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Email -->
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="email" id="email" name="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        value="{{ old('email') }}" placeholder="Masukkan email" required>
                                                    @error('email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Birth Date -->
                                            <div class="col-md-2 col-12">
                                                <div class="form-group">
                                                    <label for="birth_date">Tanggal Lahir</label>
                                                    <input type="date" id="birth_date" name="birth_date"
                                                        class="form-control @error('birth_date') is-invalid @enderror"
                                                        value="{{ old('birth_date') }}" required>
                                                    @error('birth_date')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Gender -->
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="gender">Gender</label>
                                                    <select id="gender" name="gender"
                                                        class="form-select @error('gender') is-invalid @enderror" required>
                                                        <option value="" disabled selected>-- Pilih Gender --</option>
                                                        <option value="male"
                                                            {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki
                                                        </option>
                                                        <option value="female"
                                                            {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan
                                                        </option>
                                                    </select>
                                                    @error('gender')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Profile Picture -->
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="profile_picture">Foto Profil</label>
                                                    <input type="file" id="profile_picture" name="profile_picture"
                                                        class="form-control @error('profile_picture') is-invalid @enderror">
                                                    @error('profile_picture')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Password -->
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="password">Password</label>
                                                    <input type="password" id="password" name="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        placeholder="••••••••" required>
                                                    @error('password')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Confirm Password -->
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="password_confirmation">Konfirmasi Password</label>
                                                    <input type="password" id="password_confirmation"
                                                        name="password_confirmation" class="form-control"
                                                        placeholder="Ulangi password" required>
                                                </div>
                                            </div>

                                            <!-- Tombol -->
                                            <div class="col-12 d-flex justify-content-end mt-3">
                                                <button type="submit"
                                                    class="btn btn-primary btn-sm me-1 mb-1">Simpan</button>
                                                <a href="{{ route('admins.list') }}"
                                                    class="btn btn-light-secondary btn-sm me-1 mb-1">Kembali</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End Multiple Column Form -->
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Tambahkan JS khusus jika perlu -->
    <script src="{{ asset('assets/extensions/toastify-js/src/toastify.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if (session('error'))
                Toastify({
                    text: {!! json_encode(session('error')) !!},
                    duration: 5000,
                    gravity: "bottom",
                    position: "right",
                    backgroundColor: "#f3616d",
                    close: true,
                    stopOnFocus: true,
                    style: {
                        borderRadius: "8px",
                        fontSize: "14px",
                        boxShadow: "0 2px 10px rgba(0,0,0,0.1)",
                        padding: "10px 16px"
                    }
                }).showToast();
            @endif
        });
    </script>
@endpush
