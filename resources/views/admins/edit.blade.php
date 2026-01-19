@extends('layouts.app')

@section('title', 'Edit Admin')

@push('styles')
    <!-- Tambahkan CSS khusus jika diperlukan -->
    <link rel="stylesheet" crossorigin href="{{ asset('assets/extensions/toastify-js/src/toastify.css') }}">
    <style>
        .avatar-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .avatar-box {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            overflow: hidden;
            position: relative;
            cursor: pointer;
            background: #f9fafb;
        }

        .avatar-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 28px;
            opacity: 0;
            transition: opacity .2s ease;
        }

        .avatar-box:hover .avatar-overlay {
            opacity: 1;
        }

        .avatar-title {
            margin-top: 12px;
            margin-bottom: 0;
            font-weight: 600;
        }

        .avatar-subtitle {
            color: #6b7280;
            font-size: 0.875rem;
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
                        <h3>Edit Admin</h3>
                        <p class="text-subtitle text-muted">
                            Perbarui data admin.
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
                                    Edit Admin
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Multiple Column Form -->
            <section class="section">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Edit Admin</h4>
                            </div>

                            <div class="card-body">
                                <form action="{{ route('admins.update', $admin['id']) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="row g-4">

                                        {{-- AVATAR --}}
                                        <div class="col-lg-4">
                                            <div class="avatar-wrapper text-center">

                                                <label for="profile_picture" class="avatar-box">
                                                    <img id="avatarPreview"
                                                        src="{{ $admin['profile_picture'] ? asset('storage/' . $admin['profile_picture']) : 'https://i.pravatar.cc/300' }}"
                                                        alt="Avatar">

                                                    <div class="avatar-overlay">
                                                        <i class="bi bi-camera-fill"></i>
                                                    </div>
                                                </label>

                                                <p class="avatar-title">Foto Profil</p>
                                                <small class="avatar-subtitle">Klik untuk mengganti</small>

                                                <input type="file" id="profile_picture" name="profile_picture"
                                                    class="d-none" accept="image/*" onchange="previewAvatar(this)">
                                            </div>
                                        </div>

                                        {{-- FORM --}}
                                        <div class="col-lg-8">
                                            <div class="row g-3">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Nama Depan</label>
                                                        <input type="text" name="first_name" class="form-control"
                                                            value="{{ old('first_name', $admin['first_name']) }}" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Nama Belakang</label>
                                                        <input type="text" name="last_name" class="form-control"
                                                            value="{{ old('last_name', $admin['last_name']) }}" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Email</label>
                                                        <input type="email" name="email" class="form-control"
                                                            value="{{ old('email', $admin['email']) }}" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Gender</label>
                                                        <select name="gender" class="form-select" required>
                                                            <option value="male"
                                                                {{ $admin['gender'] == 'male' ? 'selected' : '' }}>
                                                                Laki-laki</option>
                                                            <option value="female"
                                                                {{ $admin['gender'] == 'female' ? 'selected' : '' }}>
                                                                Perempuan
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Password <small>(opsional)</small></label>
                                                        <input type="password" name="password" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Konfirmasi Password</label>
                                                        <input type="password" name="password_confirmation"
                                                            class="form-control">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end mt-4">
                                        <a href="{{ route('admins.list') }}"
                                            class="btn btn-sm btn-light-outline-secondary me-2">Kembali</a>
                                        <button class="btn btn-sm btn-outline-primary">Perbarui</button>
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
            if (!input.files || !input.files[0]) return;

            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('avatarPreview').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if (session('success'))
                Toastify({
                    text: {!! json_encode(session('success')) !!},
                    duration: 5000,
                    gravity: "bottom",
                    position: "right",
                    backgroundColor: "#28a745",
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
