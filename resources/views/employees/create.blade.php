@extends('adminlte::page')

@section('title', 'Tambah Karyawan')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <div class="d-flex align-items-center">
                <h1 class="font-weight-bold text-dark mb-0" style="font-size: 2rem; line-height: 1;">
                    Tambah Karyawan
                </h1>
            </div>
            <div class="text-muted small mt-2">
                <a href="{{ url('/') }}" class="text-muted text-decoration-none">Home</a>
                <i class="fas fa-chevron-right mx-1" style="font-size: 0.6rem;"></i>
                <a href="{{ route('employees.index') }}" class="text-muted text-decoration-none">Daftar Gaji</a>
                <i class="fas fa-chevron-right mx-1" style="font-size: 0.6rem;"></i>
                <span>Tambah Karyawan</span>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm" style="border-radius: 8px;">
                <div class="card-body p-4">

                    <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                        <div class="mr-3 d-flex align-items-center justify-content-center bg-light rounded-circle"
                            style="width: 40px; height: 40px;">
                            <i class="fas fa-user-plus text-secondary"></i>
                        </div>
                        <div>
                            <h5 class="m-0 font-weight-bold text-dark">Detail Karyawan</h5>
                            <small class="text-muted">Masukkan informasi karyawan baru ke dalam sistem</small>
                        </div>
                    </div>

                    <form action="{{ route('employees.store') }}" method="POST">
                        @csrf

                        {{-- Nama Karyawan --}}
                        <div class="form-group mb-3">
                            <label for="name" class="font-weight-normal text-secondary">Nama Karyawan <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-right-0"><i
                                            class="fas fa-user text-muted"></i></span>
                                </div>
                                <input type="text" name="name"
                                    class="form-control border-left-0 @error('name') is-invalid @enderror" id="name"
                                    placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- Gaji Pokok & Tipe Gaji --}}
                        <div class="row">
                            <div class="col-md-7 form-group mb-3">
                                <label for="salary" class="font-weight-normal text-secondary">Gaji Pokok (Rp) <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span
                                            class="input-group-text bg-white border-right-0 font-weight-semibold text-muted">Rp</span>
                                    </div>
                                    <input type="number" name="salary"
                                        class="form-control border-left-0 @error('salary') is-invalid @enderror"
                                        id="salary" placeholder="Contoh: 2000000" value="{{ old('salary') }}"
                                        min="0" required>
                                    @error('salary')
                                        <span class="invalid-feedback"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-5 form-group mb-3">
                                <label for="salary_type" class="font-weight-normal text-secondary">Tipe Gaji <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-right-0"><i
                                                class="fas fa-clock text-muted"></i></span>
                                    </div>
                                    <select name="salary_type" id="salary_type"
                                        class="form-control border-left-0 @error('salary_type') is-invalid @enderror"
                                        required>
                                        <option value="weekly" {{ old('salary_type') == 'weekly' ? 'selected' : '' }}>Per
                                            Minggu</option>
                                        <option value="monthly" {{ old('salary_type') == 'monthly' ? 'selected' : '' }}>Per
                                            Bulan</option>
                                    </select>
                                    @error('salary_type')
                                        <span class="invalid-feedback"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Insentif & Tipe Insentif --}}
                        <div class="row">
                            <div class="col-md-7 form-group mb-3">
                                <label for="incentive" class="font-weight-normal text-secondary">Insentif (Rp) <span
                                        class="text-muted">(Opsional)</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span
                                            class="input-group-text bg-white border-right-0 font-weight-semibold text-muted">Rp</span>
                                    </div>
                                    <input type="number" name="incentive"
                                        class="form-control border-left-0 @error('incentive') is-invalid @enderror"
                                        id="incentive" placeholder="0" value="{{ old('incentive', 0) }}" min="0">
                                    @error('incentive')
                                        <span class="invalid-feedback"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-5 form-group mb-3">
                                <label for="incentive_type" class="font-weight-normal text-secondary">Tipe Insentif <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-right-0"><i
                                                class="fas fa-coins text-muted"></i></span>
                                    </div>
                                    <select name="incentive_type" id="incentive_type"
                                        class="form-control border-left-0 @error('incentive_type') is-invalid @enderror"
                                        required>
                                        <option value="weekly" {{ old('incentive_type') == 'weekly' ? 'selected' : '' }}>
                                            Per Minggu</option>
                                        <option value="monthly"
                                            {{ old('incentive_type') == 'monthly' ? 'selected' : '' }}>Per Bulan</option>
                                    </select>
                                    @error('incentive_type')
                                        <span class="invalid-feedback"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Tanggal Gajian --}}
                        <div class="form-group mb-4">
                            <label for="payday_date" class="font-weight-normal text-secondary">Tanggal Gajian <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-right-0"><i
                                            class="fas fa-calendar-alt text-muted"></i></span>
                                </div>
                                <input type="date" name="payday_date"
                                    class="form-control border-left-0 @error('payday_date') is-invalid @enderror"
                                    id="payday_date" value="{{ old('payday_date', date('Y-m-d')) }}" required>
                                @error('payday_date')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                            <a href="{{ route('employees.index') }}" class="btn btn-light border mr-2 px-4">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-dark px-4"
                                style="background-color: #343a40; border-color: #343a40;">
                                <i class="fas fa-save mr-2"></i> Simpan
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
    </style>
@stop
