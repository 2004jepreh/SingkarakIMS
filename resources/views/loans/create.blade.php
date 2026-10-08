@extends('adminlte::page')

@section('title', 'Tambah Pinjaman')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <div class="d-flex align-items-center">
                <h1 class="font-weight-bold text-dark mb-0" style="font-size: 2rem; line-height: 1;">
                    Tambah Pinjaman
                </h1>
            </div>
            <div class="text-muted small mt-2">
                <a href="{{ url('/') }}" class="text-muted text-decoration-none">Home</a>
                <i class="fas fa-chevron-right mx-1" style="font-size: 0.6rem;"></i>
                <a href="{{ route('employees.index') }}" class="text-muted text-decoration-none">Daftar Gaji</a>
                <i class="fas fa-chevron-right mx-1" style="font-size: 0.6rem;"></i>
                <span>Tambah Pinjaman</span>
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
                            <i class="fas fa-hand-holding-usd text-secondary"></i>
                        </div>
                        <div>
                            <h5 class="m-0 font-weight-bold text-dark">Form Pinjaman Karyawan</h5>
                            <small class="text-muted">Masukkan nominal pinjaman/kasbon baru ke dalam sistem</small>
                        </div>
                    </div>

                    <form action="{{ route('loans.store') }}" method="POST">
                        @csrf

                        {{-- Pilih Karyawan --}}
                        <div class="form-group mb-3">
                            <label for="employee_id" class="font-weight-normal text-secondary">Pilih Karyawan <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-right-0"><i
                                            class="fas fa-user text-muted"></i></span>
                                </div>
                                <select name="employee_id" id="employee_id"
                                    class="form-control border-left-0 @error('employee_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Karyawan --</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ old('employee_id', request('employee_id')) == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->name }} (Gaji Pokok: Rp.
                                            {{ number_format($employee->salary, 0, ',', '.') }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('employee_id')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- Nominal Pinjaman --}}
                        <div class="form-group mb-4">
                            <label for="amount" class="font-weight-normal text-secondary">Nominal Pinjaman (Rp) <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span
                                        class="input-group-text bg-white border-right-0 font-weight-semibold text-muted">Rp</span>
                                </div>
                                <input type="number" name="amount"
                                    class="form-control border-left-0 @error('amount') is-invalid @enderror" id="amount"
                                    placeholder="Contoh: 300000" value="{{ old('amount') }}" min="1000" required>
                                @error('amount')
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
