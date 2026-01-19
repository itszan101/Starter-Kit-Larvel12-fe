@extends('layouts.app')

@section('title', 'Tambah Admin')

@push('styles')
    <!-- Tambahkan CSS khusus jika perlu -->
    <link rel="stylesheet" crossorigin href="{{ asset('assets/extensions/toastify-js/src/toastify.css') }}">
    <style>
        .avatar-upload {
            cursor: pointer;
        }

        .avatar-upload img {
            width: 128px;
            height: 128px;
            object-fit: cover;
        }

        .avatar-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: .2s ease;
        }

        .avatar-upload:hover .avatar-overlay {
            opacity: 1;
        }

        .avatar-overlay i {
            color: #fff;
            font-size: 1.5rem;
        }
    </style>
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
            <section class="section">
                <div class="row justify-content-center">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0"></h4>
                            </div>

                            <div class="card-body">
                                <form action="{{ route('admins.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="row g-4">

                                        {{-- LEFT : AVATAR --}}
                                        <div class="col-12 col-lg-4">
                                            <div class="text-center">

                                                <div class="avatar avatar-2xl mx-auto mb-3 position-relative avatar-upload"
                                                    onclick="document.getElementById('profile_picture').click()">

                                                    <img src="{{ asset('assets/compiled/jpg/2.jpg') }}" id="avatarPreview"
                                                        class="rounded-circle border" alt="Avatar">

                                                    <div class="avatar-overlay">
                                                        <i class="bi bi-camera"></i>
                                                    </div>
                                                </div>

                                                <h6 class="mb-1">Foto Profil</h6>
                                                <small class="text-muted">Klik avatar untuk upload</small>

                                                <input type="file" id="profile_picture" name="profile_picture"
                                                    class="d-none @error('profile_picture') is-invalid @enderror"
                                                    accept="image/*" onchange="previewAvatar(this)">

                                                @error('profile_picture')
                                                    <div class="text-danger small mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- RIGHT : FORM --}}
                                        <div class="col-12 col-lg-8">
                                            <div class="row g-3">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Nama Depan</label>
                                                        <input type="text" name="first_name"
                                                            class="form-control @error('first_name') is-invalid @enderror"
                                                            value="{{ old('first_name') }}" required>
                                                        @error('first_name')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Nama Belakang</label>
                                                        <input type="text" name="last_name"
                                                            class="form-control @error('last_name') is-invalid @enderror"
                                                            value="{{ old('last_name') }}" required>
                                                        @error('last_name')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Email</label>
                                                        <input type="email" name="email"
                                                            class="form-control @error('email') is-invalid @enderror"
                                                            value="{{ old('email') }}" required>
                                                        @error('email')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Tanggal Lahir</label>
                                                        <input type="date" name="birth_date"
                                                            class="form-control @error('birth_date') is-invalid @enderror"
                                                            value="{{ old('birth_date') }}" required>
                                                        @error('birth_date')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Gender</label>
                                                        <select name="gender"
                                                            class="form-select @error('gender') is-invalid @enderror"
                                                            required>
                                                            <option value="" disabled selected>Pilih Gender</option>
                                                            <option value="male"
                                                                {{ old('gender') === 'male' ? 'selected' : '' }}>Laki-laki
                                                            </option>
                                                            <option value="female"
                                                                {{ old('gender') === 'female' ? 'selected' : '' }}>
                                                                Perempuan
                                                            </option>
                                                        </select>
                                                        @error('gender')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Password</label>
                                                        <input type="password" name="password"
                                                            class="form-control @error('password') is-invalid @enderror"
                                                            required>
                                                        @error('password')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Konfirmasi Password</label>
                                                        <input type="password" name="password_confirmation"
                                                            class="form-control" required>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                    {{-- ACTION --}}
                                    <div class="d-flex justify-content-end mt-4">
                                        <a href="{{ route('admins.list') }}"
                                            class="btn btn-sm btn-outline-light-secondary me-2">Kembali</a>
                                        <button type="submit" class="btn btn-sm btn-outline-primary">Simpan</button>
                                    </div>

                                </form>
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
        function previewAvatar(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader()
                reader.onload = e => {
                    document.getElementById('avatarPreview').src = e.target.result
                }
                reader.readAsDataURL(input.files[0])
            }
        }
    </script>

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
