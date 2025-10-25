@extends('layouts.app')

@section('title', 'Daftar Admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('assets/compiled/css/table-datatable-jquery.css') }}">
@endpush

@section('content')
    <!-- BEGIN: Content -->
    <div id="main-content">
        <div class="page-heading">
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

            <!-- Basic Tables start -->
            <section class="section">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="table1">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Gender</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($admins as $index => $admin)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $admin['first_name'] }} {{ $admin['last_name'] }}</td>
                                            <td>{{ $admin['email'] }}</td>
                                            <td>{{ $admin['birth_date'] ?? '-' }}</td>
                                            <td>{{ ucfirst($admin['gender'] ?? '-') }}</td>
                                            <td>
                                                <a href="{{ route('admins.edit', $admin['id']) }}"
                                                    class="btn btn-warning btn-sm me-1">
                                                    Edit
                                                </a>

                                                <!-- Tombol untuk buka modal hapus -->
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $admin['id'] }}">
                                                    Hapus
                                                </button>

                                                <!-- Modal Konfirmasi Hapus -->
                                                <div class="modal fade" id="deleteModal{{ $admin['id'] }}" tabindex="-1"
                                                    aria-labelledby="deleteModalLabel{{ $admin['id'] }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-danger text-white">
                                                                <h5 class="modal-title" id="deleteModalLabel{{ $admin['id'] }}">
                                                                    Konfirmasi Hapus
                                                                </h5>
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Apakah Anda yakin ingin menghapus admin
                                                                    <strong>{{ $admin['first_name'] }}
                                                                        {{ $admin['last_name'] }}</strong>?
                                                                </p>
                                                                <p class="text-danger fw-bold mb-2">
                                                                    Aksi ini tidak dapat dibatalkan.
                                                                </p>
                                                                <div class="mb-3">
                                                                    <label for="confirmText{{ $admin['id'] }}"
                                                                        class="form-label">
                                                                        Ketik <strong>" hapus data ini "</strong> untuk
                                                                        melanjutkan:
                                                                    </label>
                                                                    <input type="text" class="form-control confirm-input"
                                                                        id="confirmText{{ $admin['id'] }}"
                                                                        placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light-secondary btn-sm"
                                                                    data-bs-dismiss="modal">
                                                                    Batal
                                                                </button>

                                                                <form method="POST"
                                                                    action="{{ route('admins.destroy', $admin['id']) }}"
                                                                    class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm delete-btn"
                                                                        disabled>
                                                                        Hapus
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Akhir Modal -->
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data admin</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Basic Tables end -->
        </div>
    </div>
    <!-- END: Content -->
@endsection

@push('scripts')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/datatables.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Untuk setiap modal hapus
            document.querySelectorAll('.modal').forEach(modal => {
                const input = modal.querySelector('.confirm-input');
                const deleteBtn = modal.querySelector('.delete-btn');

                if (input && deleteBtn) {
                    input.addEventListener('input', function () {
                        if (this.value.trim() === "hapus data ini") {
                            deleteBtn.removeAttribute('disabled');
                        } else {
                            deleteBtn.setAttribute('disabled', true);
                        }
                    });
                }
            });
        });
    </script>
@endpush
