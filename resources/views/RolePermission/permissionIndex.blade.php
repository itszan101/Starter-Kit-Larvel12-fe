@extends('layouts.app')

@section('title', 'Daftar Permissions')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('assets/compiled/css/table-datatable-jquery.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('assets/extensions/toastify-js/src/toastify.css') }}">
@endpush

@section('content')
    <!-- BEGIN: Content -->
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title">
                <div class="row align-items-center">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <div class="d-inline-flex align-items-center gap-2">
                            <h3 class="mb-0">Daftar Permissions</h3>
                            <!-- Tombol Create Permission -->
                            <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#addPermissionModal">
                                <i class="bi bi-plus-circle me-1"></i> Create Permission
                            </a>
                        </div>
                        <p class="text-subtitle text-muted mt-2">
                            Halaman untuk melihat dan mengelola Permission.
                        </p>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Daftar Permission
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Basic Tables start -->
            <section class="section">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="table1">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Permission</th>
                                        <th>Guard</th>
                                        <th>Dibuat Pada</th>
                                        <th>Terakhir Diperbarui</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($permissions as $index => $permission)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $permission['name'] }}</td>
                                            <td>{{ $permission['guard_name'] ?? 'web' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($permission['created_at'])->format('d M Y H:i') }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($permission['updated_at'])->format('d M Y H:i') }}
                                            </td>
                                            <td>
                                                <!-- Tombol Hapus -->
                                                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#deletePermissionModal"
                                                    data-id="{{ $permission['id'] }}"
                                                    data-name="{{ $permission['name'] }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data permission</td>
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

    <!-- Modal Konfirmasi Hapus Permission -->
    <div class="modal fade" id="deletePermissionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p>
                        Apakah Anda yakin ingin menghapus permission
                        <strong id="permissionName"></strong>?
                    </p>

                    <p class="text-danger fw-bold mb-2">
                        Aksi ini tidak dapat dibatalkan.
                    </p>

                    <div class="mb-3">
                        <label class="form-label text-sm">
                            Ketik <strong id="confirmLabel"></strong> untuk konfirmasi:
                        </label>
                        <input type="text" class="form-control confirm-input text-sm" placeholder="">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">
                        Batal
                    </button>

                    <form method="POST" id="deletePermissionForm">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-light-secondary btn-sm delete-btn" disabled>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Permission -->
    <div class="modal fade" id="addPermissionModal" tabindex="-1" aria-labelledby="addPermissionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('permissions.store') }}">
                    @csrf
                    <div class="modal-header text-white">
                        <h5 class="modal-title">Tambah Permission Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label class="form-label text-sm text-primary">Nama Permission</label>
                        <input type="text" name="name" class="form-control text-sm text-primary" placeholder="Contoh: user.view" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/datatables.js') }}"></script>
    <script src="{{ asset('assets/extensions/toastify-js/src/toastify.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/toastify.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Saat modal ditampilkan, baru pasang event listener ke input-nya
            document.querySelectorAll('.modal').forEach(modal => {
                modal.addEventListener('shown.bs.modal', function() {
                    const input = modal.querySelector('.confirm-input');
                    const deleteBtn = modal.querySelector('.delete-btn');
                    const expectedText = modal.dataset.confirmText?.toLowerCase().trim();

                    if (input && deleteBtn && expectedText) {
                        // Reset state awal setiap kali modal dibuka
                        input.value = '';
                        deleteBtn.disabled = true;

                        input.addEventListener('input', function() {
                            const value = this.value.trim().toLowerCase();
                            deleteBtn.disabled = (value !== expectedText);
                        });
                    }
                });
            });
        });
    </script>

    @if (session('success') || session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if (session('success'))
                    Toastify({
                        text: {!! json_encode(session('success')) !!}, // gunakan json_encode untuk auto escape
                        duration: 5000,
                        gravity: "bottom",
                        position: "right",
                        backgroundColor: "#198754",
                        stopOnFocus: true,
                        className: "toastify-success",
                        close: true,
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
                        text: {!! json_encode(session('error')) !!}, // << gunakan ini agar tanda kutip tidak jadi &#039;
                        duration: 5000,
                        gravity: "bottom",
                        position: "right",
                        backgroundColor: "#f3616d",
                        stopOnFocus: true,
                        className: "toastify-error",
                        close: true,
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
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('deletePermissionModal');
            const nameEl = modal.querySelector('#permissionName');
            const labelEl = modal.querySelector('#confirmLabel');
            const input = modal.querySelector('.confirm-input');
            const btn = modal.querySelector('.delete-btn');
            const form = modal.querySelector('#deletePermissionForm');

            modal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.dataset.id;
                const name = button.dataset.name;

                const confirmText = `hapus permission ${name}`.toLowerCase();

                nameEl.textContent = name;
                labelEl.textContent = `"Hapus permission ${name}"`;
                input.placeholder = `Hapus permission ${name}`;
                input.value = '';
                btn.disabled = true;

                form.action = `/permissions/${id}`; // SESUAI route delete lu

                input.oninput = function() {
                    btn.disabled = input.value.trim().toLowerCase() !== confirmText;
                };
            });
        });
    </script>
@endpush
