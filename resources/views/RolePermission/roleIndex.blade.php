@extends('layouts.app')

@section('title', 'Daftar Role')

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
                            <h3 class="mb-0">Daftar Role</h3>
                            <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#addRoleModal">
                                <i class="bi bi-plus-circle me-1"></i> Create Role
                            </a>
                        </div>
                        <p class="text-subtitle text-muted mt-2">
                            Halaman untuk melihat dan mengelola Role.
                        </p>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Daftar Role</li>
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
                                        <th>Nama Role</th>
                                        <th>Dibuat Pada</th>
                                        <th>Terakhir Diperbarui</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($roles as $index => $role)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $role['name'] }}</td>
                                            <td>{{ \Carbon\Carbon::parse($role['created_at'])->format('d M Y H:i') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($role['updated_at'])->format('d M Y H:i') }}</td>
                                            <td>
                                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#viewModal" data-role-id="{{ $role['id'] }}">
                                                    <i class="bi bi-eye"></i>
                                                </button>

                                                <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#permissionModal" data-role-id="{{ $role['id'] }}">
                                                    <i class="bi bi-key"></i>
                                                </button>

                                                <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal" data-role-id="{{ $role['id'] }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data role</td>
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

    {{-- === Modal View === --}}
    @foreach ($roles as $role)
        @php
            $roleData = collect($rolePermissions)->firstWhere('role', $role['name']) ?? [];
        @endphp

        <div class="modal fade role-view-modal" id="viewModal-{{ $role['id'] }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header text-white">
                        <h5 class="modal-title">Detail Role: {{ $role['name'] }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Nama Role:</strong> {{ $role['name'] }}</p>
                        <hr>
                        @if (!empty($roleData['permissions']))
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($roleData['permissions'] as $perm)
                                    <span class="badge bg-light text-dark text-sm border">
                                        {{ $perm }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted fst-italic">Tidak ada permission</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- === Modal Permission === --}}
    @foreach ($roles as $role)
        @php
            $roleData = collect($rolePermissions)->firstWhere('role', $role['name']) ?? [];
            $rolePerms = $roleData['permissions'] ?? [];
        @endphp

        <div class="modal fade role-permission-modal" id="permissionModal-{{ $role['id'] }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <form method="POST" action="{{ route('roles.update.permissions') }}" class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Kelola Permission: {{ $role['name'] }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <input type="hidden" name="role_name" value="{{ $role['name'] }}">

                    <div class="modal-body">
                        <div class="row">
                            @foreach ($permissions as $perm)
                                @php
                                    $permName = is_array($perm) ? $perm['name'] : $perm;
                                @endphp
                                <div class="col-md-4 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]"
                                            value="{{ $permName }}"
                                            {{ in_array($permName, $rolePerms) ? 'checked' : '' }}>
                                        <label class="form-check-label text-sm text-primary">
                                            {{ $permName }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger btn-sm" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary btn-sm">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

    {{-- === Modal Delete === --}}
    @foreach ($roles as $role)
        <div class="modal fade role-delete-modal" id="deleteModal-{{ $role['id'] }}" tabindex="-1"
            data-role-name="{{ strtolower('hapus role ' . $role['name']) }}">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus permission
                            <strong>{{ $role['name'] }}</strong>?
                        </p>
                        <p class="text-danger fw-bold mb-2">
                            Aksi ini tidak dapat dibatalkan.
                        </p>

                        <div class="mb-3">
                            <label class="form-label text-sm">
                                Ketik <strong>"Hapus role
                                    {{ $role['name'] }}"</strong> untuk
                                konfirmasi:
                            </label>
                            <input type="text" class="form-control text-sm confirm-input"
                                id="confirmText{{ $role['id'] }}" placeholder="Hapus role {{ $role['name'] }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form method="POST" action="{{ route('roles.delete', $role['id']) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm delete-btn" disabled>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Modal Tambah Role -->
    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-white">
                    <h5 class="modal-title" id="addRoleModalLabel">Tambah Role Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <form method="POST" action="{{ route('roles.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="roleName" class="form-label fw-semibold text-sm">Nama Role</label>
                            <input type="text" name="name" id="roleName" class="form-control text-sm"
                                placeholder="Contoh: manager" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary btn-sm"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="bi bi-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Akhir Modal Tambah Role -->
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
            // Untuk semua modal hapus
            document.querySelectorAll('.modal').forEach(modal => {
                const input = modal.querySelector('.confirm-input');
                const deleteBtn = modal.querySelector('.delete-btn');
                const expectedText = modal.dataset.roleName; // "hapus role manager", dsb

                if (input && deleteBtn && expectedText) {
                    input.addEventListener('input', function() {
                        const value = this.value.trim().toLowerCase();
                        deleteBtn.disabled = (value !== expectedText);
                    });
                }
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

            document.querySelectorAll('[data-role-id]').forEach(btn => {
                btn.addEventListener('click', function() {

                    const id = this.dataset.roleId;
                    const target = this.dataset.bsTarget;

                    if (!target) return;

                    const modalId = target + '-' + id;
                    const modalEl = document.querySelector(modalId);

                    if (modalEl) {
                        bootstrap.Modal.getOrCreateInstance(modalEl).show();
                    }
                });
            });

            document.querySelectorAll('.role-delete-modal').forEach(modal => {
                const input = modal.querySelector('.confirm-input');
                const btn = modal.querySelector('.delete-btn');
                const expected = modal.dataset.roleName;

                input.addEventListener('input', () => {
                    btn.disabled =
                        input.value.trim().toLowerCase() !== expected;
                });
            });

        });
    </script>

@endpush
