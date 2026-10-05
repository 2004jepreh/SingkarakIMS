@extends('adminlte::page')

@section('title', 'Edit Permission')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <div class="d-flex align-items-center">
                <h1 class="font-weight-bold text-dark mb-0" style="font-size: 2rem; line-height: 1;">
                    Edit Permission
                </h1>
            </div>
            <div class="text-muted small mt-2">
                <a href="{{ url('/') }}" class="text-muted text-decoration-none">Home</a>
                <i class="fas fa-chevron-right mx-1" style="font-size: 0.6rem;"></i>
                <a href="{{ route('permissions.index') }}" class="text-muted text-decoration-none">Permission</a>
                <i class="fas fa-chevron-right mx-1" style="font-size: 0.6rem;"></i>
                <span>Edit Permission</span>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm" style="border-radius: 8px;">
                <div class="card-body p-4">

                    {{-- Header Form Minimalis --}}
                    <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                        <div class="mr-3 d-flex align-items-center justify-content-center bg-light rounded-circle"
                            style="width: 40px; height: 40px;">
                            <i class="fas fa-edit text-secondary"></i>
                        </div>
                        <div>
                            <h5 class="m-0 font-weight-bold text-dark">Edit Permission</h5>
                            <small class="text-muted">Perbarui detail permission yang sudah ada</small>
                        </div>
                    </div>

                    <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-4">
                            <label for="name" class="font-weight-normal text-secondary">Nama Permission <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-right-0"><i
                                            class="fas fa-tag text-muted"></i></span>
                                </div>
                                <input type="text" name="name"
                                    class="form-control border-left-0 @error('name') is-invalid @enderror" id="name"
                                    placeholder="Contoh: create-users" value="{{ old('name', $permission->name) }}" required
                                    autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <small class="form-text text-muted mt-2">
                                Gunakan format huruf kecil dan tanda hubung (contoh: <code>edit-item</code>).
                            </small>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                            <a href="{{ route('permissions.index') }}" class="btn btn-light border mr-2 px-4">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-dark px-4"
                                style="background-color: #343a40; border-color: #343a40;">
                                <i class="fas fa-sync-alt mr-2"></i> Perbarui
                            </button>
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
        /* Styling tambahan agar input terlihat menyatu dengan ikon */
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

        /* Memperbaiki border saat input group focus */
        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control {
            border-color: #80bdff;
        }
    </style>
@stop
