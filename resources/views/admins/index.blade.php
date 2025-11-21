@extends('layouts.app')

@section('title', 'Daftar Admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('assets/compiled/css/table-datatable-jquery.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('assets/extensions/toastify-js/src/toastify.css') }}">
@endpush

@section('content')
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row align-items-center">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <div class="d-inline-flex align-items-center gap-2">
                            <h3 class="mb-0">Daftar Admin</h3>
                            <a href="{{ route('admins.create') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-circle me-1"></i> Create User
                            </a>
                        </div>
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

            <!-- Tabel -->
            <section class="section">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="table1">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Gender</th>
                                        <th>Role</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($admins as $index => $admin)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $admin['first_name'] }} {{ $admin['last_name'] }}</td>
                                            <td>{{ $admin['email'] }}</td>
                                            <td>{{ ucfirst($admin['gender'] ?? '-') }}</td>
                                            <td>{{ $admin['roles'][0]['name'] ?? '-' }}</td>
                                            <td>
                                                <button type="button" class="btn icon btn-primary btn-sm me-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#assignRoleModal{{ $admin['id'] }}">
                                                    <i class="bi bi-key"></i>
                                                </button>
                                                <a href="{{ route('admins.edit', $admin['id']) }}"
                                                    class="btn btn-warning btn-sm me-1">
                                                    Edit
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm me-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $admin['id'] }}">
                                                    Hapus
                                                </button>
                                                <a href="{{ route('admins.download-sk', $admin['id']) }}"
                                                    class="btn btn-info btn-sm me-1">
                                                    Download SK
                                                </a>

                                                <!-- Modal Konfirmasi Hapus -->
                                                <div class="modal fade" id="deleteModal{{ $admin['id'] }}" tabindex="-1"
                                                    aria-labelledby="deleteModalLabel{{ $admin['id'] }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-danger text-white">
                                                                <h5 class="modal-title"
                                                                    id="deleteModalLabel{{ $admin['id'] }}">
                                                                    Konfirmasi Hapus
                                                                </h5>
                                                                <button type="button" class="btn-close btn-close-white"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                                @php
                                                                    $fullName = trim(
                                                                        $admin['first_name'] .
                                                                            ' ' .
                                                                            $admin['last_name'],
                                                                    );
                                                                    $confirmText = 'Hapus data ' . $fullName;
                                                                @endphp

                                                                <p>Apakah Anda yakin ingin menghapus admin
                                                                    <strong>{{ $fullName }}</strong>?
                                                                </p>
                                                                <p class="text-danger fw-bold mb-2">Aksi ini tidak dapat
                                                                    dibatalkan.</p>

                                                                <div class="mb-3">
                                                                    <label for="confirmText{{ $admin['id'] }}"
                                                                        class="form-label">
                                                                        Ketik <strong>"{{ $confirmText }}"</strong> untuk
                                                                        melanjutkan:
                                                                    </label>
                                                                    <input type="text" class="form-control confirm-input"
                                                                        id="confirmText{{ $admin['id'] }}"
                                                                        data-confirm-text="{{ strtolower($confirmText) }}"
                                                                        placeholder=''>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button"
                                                                    class="btn btn-light-secondary btn-sm"
                                                                    data-bs-dismiss="modal">Batal</button>

                                                                <form method="POST"
                                                                    action="{{ route('admins.destroy', $admin['id']) }}"
                                                                    class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-danger btn-sm delete-btn" disabled>
                                                                        Hapus
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Akhir Modal -->
                                                <!-- Modal Assign Role -->
                                                <div class="modal fade" id="assignRoleModal{{ $admin['id'] }}"
                                                    tabindex="-1" aria-labelledby="assignRoleLabel{{ $admin['id'] }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-warning text-dark">
                                                                <h5 class="modal-title"
                                                                    id="assignRoleLabel{{ $admin['id'] }}">
                                                                    Atur Role untuk: {{ $admin['first_name'] }}
                                                                    {{ $admin['last_name'] }}
                                                                </h5>
                                                                <button type="button" class="btn-close btn-close-dark"
                                                                    data-bs-dismiss="modal"></button>
                                                            </div>

                                                            <form method="POST"
                                                                action="{{ route('admins.assign-role', $admin['id']) }}">
                                                                @csrf
                                                                @method('PUT')

                                                                <div class="modal-body">
                                                                    <p class="text-muted mb-2">Pilih satu role yang akan
                                                                        diberikan kepada pengguna ini:</p>
                                                                    <div class="row">
                                                                        @foreach ($availableRoles as $role)
                                                                            @php
                                                                                $roleName = strtolower($role['name']);
                                                                                $isChecked = in_array(
                                                                                    $role['name'],
                                                                                    array_column(
                                                                                        $admin['roles'],
                                                                                        'name',
                                                                                    ),
                                                                                );
                                                                            @endphp
                                                                            <div class="col-md-6 mb-2">
                                                                                <div class="form-check">
                                                                                    <input
                                                                                        class="form-check-input single-role-checkbox"
                                                                                        type="checkbox" name="roles[]"
                                                                                        value="{{ $roleName }}"
                                                                                        id="role-{{ $admin['id'] }}-{{ $loop->index }}"
                                                                                        {{ $isChecked ? 'checked' : '' }}>
                                                                                    <label class="form-check-label"
                                                                                        for="role-{{ $admin['id'] }}-{{ $loop->index }}">
                                                                                        {{ $role['name'] }}
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button"
                                                                        class="btn btn-light-secondary btn-sm"
                                                                        data-bs-dismiss="modal">
                                                                        Batal
                                                                    </button>
                                                                    <button type="submit"
                                                                        class="btn btn-warning text-dark btn-sm">
                                                                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                                                                    </button>
                                                                </div>
                                                            </form>
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
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/toastify-js/src/toastify.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/datatables.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.modal').forEach(modal => {
                const input = modal.querySelector('.confirm-input');
                const deleteBtn = modal.querySelector('.delete-btn');

                if (input && deleteBtn) {
                    const requiredText = input.dataset.confirmText.trim().toLowerCase();
                    input.addEventListener('input', function() {
                        const userText = this.value.trim().toLowerCase();
                        deleteBtn.disabled = userText !== requiredText;
                    });
                }
            });
        });
    </script>

    {{-- Toastify hanya untuk success --}}
    @if (session('success'))
        <script>
            Toastify({
                text: {!! json_encode(session('success')) !!},
                duration: 5000,
                gravity: "bottom",
                position: "right",
                backgroundColor: "#198754",
                close: true,
                style: {
                    borderRadius: "8px",
                    fontSize: "14px",
                    boxShadow: "0 2px 10px rgba(0,0,0,0.1)",
                    padding: "10px 16px"
                }
            }).showToast();
        </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Batasi hanya satu checkbox aktif per modal
            document.querySelectorAll('.modal').forEach(modal => {
                const checkboxes = modal.querySelectorAll('.single-role-checkbox');
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        if (this.checked) {
                            checkboxes.forEach(cb => {
                                if (cb !== this) cb.checked = false;
                            });
                        }
                    });
                });
            });
        });
    </script>

@endpush
