@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<!-- Tambahkan CSS khusus jika perlu -->
@endpush

@section('content')
<!-- BEGIN: Content -->
<div id="main-content">
    <div class="page-heading">
        <!-- Page Title & Breadcrumb -->
        <div class="page-title">
            <div class="row align-items-center">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Selamat Datang di Dashboard</h3>
                    <p class="text-subtitle text-muted">
                        Navbar will appear on the top of the page.
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Main
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-9">
                <!-- Welcome Section -->
                <div class="mb-4">
                    <p>Dashboard Page Example</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Content -->
@endsection

@push('scripts')
<!-- Tambahkan JS khusus jika perlu -->
@endpush
