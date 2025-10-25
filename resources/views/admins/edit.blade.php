@extends('layouts.app')

@section('title', 'Edit Admin')

@push('styles')
    <!-- Tambahkan CSS khusus jika diperlukan -->
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
            <section id="multiple-column-form">
                <div class="row match-height">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Form Edit Admin</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form class="form" action="{{ route('admins.update', $admin['id']) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <!-- Nama Depan -->
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="first_name">Nama Depan</label>
                                                    <input type="text" id="first_name" name="first_name"
                                                        class="form-control"
                                                        placeholder="Masukkan nama depan"
                                                        value="{{ $admin['first_name'] }}" required>
                                                </div>
                                            </div>

                                            <!-- Nama Belakang -->
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="last_name">Nama Belakang</label>
                                                    <input type="text" id="last_name" name="last_name"
                                                        class="form-control"
                                                        placeholder="Masukkan nama belakang"
                                                        value="{{ $admin['last_name'] }}" required>
                                                </div>
                                            </div>

                                            <!-- Email -->
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="email" id="email" name="email"
                                                        class="form-control"
                                                        placeholder="Masukkan email"
                                                        value="{{ $admin['email'] }}" required>
                                                </div>
                                            </div>

                                            <!-- Gender -->
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="gender">Gender</label>
                                                    <select id="gender" name="gender" class="form-select" required>
                                                        <option value="">-- Pilih Gender --</option>
                                                        <option value="male" {{ $admin['gender'] === 'male' ? 'selected' : '' }}>Laki-laki</option>
                                                        <option value="female" {{ $admin['gender'] === 'female' ? 'selected' : '' }}>Perempuan</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Password -->
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="password">Password <small>(Kosongkan jika tidak diubah)</small></label>
                                                    <input type="password" id="password" name="password"
                                                        class="form-control" placeholder="Isi jika ingin ubah password">
                                                </div>
                                            </div>

                                            <!-- Konfirmasi Password -->
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="password_confirmation">Konfirmasi Password</label>
                                                    <input type="password" id="password_confirmation"
                                                        name="password_confirmation" class="form-control"
                                                        placeholder="Ulangi password baru">
                                                </div>
                                            </div>

                                            <!-- Tombol -->
                                            <div class="col-12 d-flex justify-content-end mt-3">
                                                <button type="submit" class="btn btn-primary btn-sm me-1 mb-1">Perbarui</button>
                                                <a href="{{ route('admins.list') }}" class="btn btn-light-secondary btn-sm me-1 mb-1">Kembali</a>
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
@endpush
