@extends('layouts.app')

@section('title', 'Daftar Admin')

@push('styles')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endpush

@section('content')
    <!-- BEGIN: Content -->
    <div id="main-content">
        <div class="page-heading">
            <!-- Page Title & Breadcrumb -->
            <div class="page-title">
                <div class="row align-items-center">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Daftar Admin</h3>
                        <p class="text-subtitle text-muted">
                            Halaman untuk melihat dan mengelola admin.
                        </p>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Daftar Admin
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Admins Table Section -->
            <section class="section">
                <div class="card mt-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Data Admin</h4>
                        <a href="{{ route('admins.create') }}" class="btn btn-primary btn-sm">Tambah Admin</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="adminsTable">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Depan</th>
                                        <th>Nama Belakang</th>
                                        <th>Email</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($admins as $admin)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $admin['first_name'] }}</td>
                                            <td>{{ $admin['last_name'] }}</td>
                                            <td>{{ $admin['email'] }}</td>
                                            <td>
                                                <a href="{{ route('admins.edit', $admin['id']) }}"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                                <form method="POST" action="{{ route('admins.destroy', $admin['id']) }}"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Hapus admin ini?')">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">Tidak ada data admin</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- END: Content -->
@endsection

@push('scripts')
    <script src="{{ asset('assets/extensions/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net/js/jquery.dataTables.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#adminsTable').DataTable({
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
                order: [
                    [0, "asc"]
                ],
                columnDefs: [{
                        orderable: false,
                        targets: 4
                    } // Kolom aksi tidak bisa di-sort
                ]
            });
        });
    </script>
@endpush
