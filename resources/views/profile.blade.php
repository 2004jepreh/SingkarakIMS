@extends('adminlte::page')

@section('title', 'Edit Profile')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <div class="d-flex align-items-center">
                <h1 class="font-weight-bold text-dark mb-0" style="font-size: 2rem; line-height: 1;">
                    Edit Profile
                </h1>
            </div>
            <div class="text-muted small mt-1">
                <a href="{{ url('/') }}" class="text-muted text-decoration-none">Home</a>
                <i class="fas fa-chevron-right mx-1" style="font-size: 0.6rem;"></i>
                <span>Profile</span>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-11 col-lg-9">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-4 p-md-5">

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-lg mb-4"
                            role="alert">
                            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row align-items-center">

                            {{-- Kolom Kiri: Form Input --}}
                            <div class="col-md-7 border-right-md pr-md-4">
                                <h5 class="font-weight-bold text-dark mb-4">Edit your profile</h5>

                                {{-- Name --}}
                                <div class="form-group mb-3">
                                    <label for="name" class="font-weight-normal text-secondary small">Full name</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-right-0"><i
                                                    class="fas fa-user text-muted"></i></span>
                                        </div>
                                        <input type="text" name="name"
                                            class="form-control border-left-0 @error('name') is-invalid @enderror"
                                            id="name" value="{{ old('name', $user->name) }}" required>
                                        @error('name')
                                            <span class="invalid-feedback"
                                                role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div class="form-group mb-3">
                                    <label for="email" class="font-weight-normal text-secondary small">Email</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-right-0"><i
                                                    class="fas fa-envelope text-muted"></i></span>
                                        </div>
                                        <input type="email" name="email"
                                            class="form-control border-left-0 @error('email') is-invalid @enderror"
                                            id="email" value="{{ old('email', $user->email) }}" required>
                                        @error('email')
                                            <span class="invalid-feedback"
                                                role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Password --}}
                                <div class="form-group mb-3">
                                    <label for="password" class="font-weight-normal text-secondary small">New Password
                                        <small class="text-muted">(Leave blank to keep current)</small></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-right-0"><i
                                                    class="fas fa-lock text-muted"></i></span>
                                        </div>
                                        <input type="password" name="password"
                                            class="form-control border-left-0 @error('password') is-invalid @enderror"
                                            id="password" placeholder="New password">
                                        @error('password')
                                            <span class="invalid-feedback"
                                                role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Password Confirmation --}}
                                <div class="form-group mb-4">
                                    <label for="password_confirmation"
                                        class="font-weight-normal text-secondary small">Confirm New Password</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-right-0"><i
                                                    class="fas fa-check-circle text-muted"></i></span>
                                        </div>
                                        <input type="password" name="password_confirmation"
                                            class="form-control border-left-0" id="password_confirmation"
                                            placeholder="Confirm new password">
                                    </div>
                                </div>
                            </div>

                            {{-- Kolom Kanan: Preview Profil (Placeholder Gambar Anjing) --}}
                            <div class="col-md-5 text-center mt-4 mt-md-0 pl-md-4">
                                <div class="position-relative d-inline-block mb-3">
                                    <img src="{{ asset('images/profile.png') }}" alt="Profile Preview"
                                        class="rounded-circle shadow-sm border"
                                        style="width: 130px; height: 130px; object-fit: cover;">
                                </div>

                                <h5 class="font-weight-bold text-dark mb-1">{{ $user->name }}</h5>
                                <p class="text-muted small mb-2">{{ $userRole }}</p>

                                <div class="badge badge-light border px-3 py-2 text-muted font-weight-normal"
                                    style="font-size: 0.8rem; border-radius: 20px;">
                                    <i class="fas fa-envelope mr-1"></i> {{ $user->email }}
                                </div>
                            </div>

                        </div>

                        {{-- Footer Buttons --}}
                        <div class="d-flex justify-content-end align-items-center mt-4 pt-3 border-top">
                            <div>
                                <a href="{{ url('/') }}"
                                    class="btn btn-light border mr-2 px-4 rounded-lg font-weight-semibold">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-dark px-4 rounded-lg font-weight-semibold"
                                    style="background-color: #0f172a; border: none;">
                                    Save changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .input-group-text {
            border-right: none;
            background-color: #fff;
        }

        .form-control {
            border-left: none;
            box-shadow: none !important;
        }

        .form-control:focus {
            border-color: #ced4da;
        }

        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control {
            border-color: #80bdff;
        }

        @media (min-width: 768px) {
            .border-right-md {
                border-right: 1px dashed #e2e8f0 !important;
            }
        }
    </style>
@stop
