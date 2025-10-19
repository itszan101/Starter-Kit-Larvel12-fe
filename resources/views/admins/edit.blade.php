@extends('layouts.app')

@section('title', 'Edit Admin')

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

            <!-- Form Edit Admin -->
            <section class="section">
                <div class="card mt-4">
                    <div class="card-body">
                        <form action="{{ route('admins.update', $admin['id']) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="first_name" class="form-label">Nama Depan</label>
                                <input type="text" name="first_name" id="first_name" class="form-control"
                                    value="{{ $admin['first_name'] }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Nama Belakang</label>
                                <input type="text" name="last_name" id="last_name" class="form-control"
                                    value="{{ $admin['last_name'] }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ $admin['email'] }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password <small>(Kosongkan jika tidak ingin
                                        diubah)</small></label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control" autocomplete="new-password">
                            </div>
                            <button type="submit" class="btn btn-primary">Perbarui</button>
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
