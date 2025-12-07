@extends('layouts.app')

@section('title', 'Page Test')

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
                        <h3>Selamat Datang di Page test ajaa</h3>
                        <p class="text-subtitle text-muted">
                            Navbar will appear on the top of the page.
                        </p>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('dashboard') }}">Test</a>
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
                        <p>Nge tes Page Example</p>

                        <!-- Tombol pemanggil modal -->
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                            Edit Profile
                        </button>
                    </div>
                </div>
            </div>

            <!-- Edit Profile Modal -->
            <div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Edit Profile</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body p-4">

                            <div class="page-title mb-4">
                                <div class="row">
                                    <div class="col-12 col-md-6 order-md-1 order-last">
                                        <h3>Account Profile</h3>
                                        <p class="text-subtitle text-muted">
                                            A page where users can change profile information
                                        </p>
                                    </div>
                                    <div class="col-12 col-md-6 order-md-2 order-first">
                                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                                <li class="breadcrumb-item active" aria-current="page">Profile</li>
                                            </ol>
                                        </nav>
                                    </div>
                                </div>
                            </div>

                            <section class="section">
                                <div class="row">

                                    <!-- Avatar + Name -->
                                    <div class="col-12 col-lg-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-center align-items-center flex-column">

                                                    <div class="avatar avatar-2xl">
                                                        <img src="{{ $profile['profile_picture'] ?? 'https://i.pravatar.cc/150' }}"
                                                            alt="Avatar" class="rounded">
                                                    </div>

                                                    <h3 class="mt-3">
                                                        {{ $profile['first_name'] ?? '' }} {{ $profile['last_name'] ?? '' }}
                                                    </h3>

                                                    <p class="text-small text-muted">
                                                        {{ $profile['job_title'] ?? 'Member' }}
                                                    </p>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Form -->
                                    <div class="col-12 col-lg-8">
                                        <div class="card">
                                            <div class="card-body">

                                                <form method="POST" enctype="multipart/form-data">
                                                    @csrf

                                                    <div class="form-group mb-3">
                                                        <label class="form-label">First Name</label>
                                                        <input type="text" name="first_name" class="form-control"
                                                            placeholder="Your First Name"
                                                            value="{{ $profile['first_name'] ?? '' }}">
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <label class="form-label">Last Name</label>
                                                        <input type="text" name="last_name" class="form-control"
                                                            placeholder="Your Last Name"
                                                            value="{{ $profile['last_name'] ?? '' }}">
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <label class="form-label">Email</label>
                                                        <input type="email" name="email" class="form-control"
                                                            placeholder="Your Email" value="{{ $profile['email'] ?? '' }}">
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <label class="form-label">Phone</label>
                                                        <input type="text" name="phone" class="form-control"
                                                            placeholder="Your Phone" value="{{ $profile['phone'] ?? '' }}">
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <label class="form-label">Birth Date</label>
                                                        <input type="date" name="birth_date" class="form-control"
                                                            value="{{ $profile['birth_date'] ?? '' }}">
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <label class="form-label">Gender</label>
                                                        <select name="gender" class="form-control">
                                                            <option value="male"
                                                                {{ ($profile['gender'] ?? '') === 'male' ? 'selected' : '' }}>
                                                                Male</option>
                                                            <option value="female"
                                                                {{ ($profile['gender'] ?? '') === 'female' ? 'selected' : '' }}>
                                                                Female</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <label class="form-label">Profile Picture</label>
                                                        <input type="file" name="profile_picture"
                                                            class="form-control">
                                                    </div>

                                                    <div class="form-group mt-4">
                                                        <button type="submit" class="btn btn-primary">
                                                            Save Changes
                                                        </button>
                                                    </div>

                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </section>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        </div>

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
