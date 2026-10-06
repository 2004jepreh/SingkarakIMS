@extends('adminlte::page')

@section('title', 'Tambah Role')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <div class="d-flex align-items-center">
                <h1 class="font-weight-bold text-dark mb-0" style="font-size: 2rem; line-height: 1;">
                    Tambah Role
                </h1>
            </div>
            <div class="text-muted small mt-2">
                <a href="{{ url('/') }}" class="text-muted text-decoration-none">Home</a>
                <i class="fas fa-chevron-right mx-1" style="font-size: 0.6rem;"></i>
                <a href="{{ route('roles.index') }}" class="text-muted text-decoration-none">Role</a>
                <i class="fas fa-chevron-right mx-1" style="font-size: 0.6rem;"></i>
                <span>Tambah Role</span>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 8px;">
                <div class="card-body p-4">

                    <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                        <div class="mr-3 d-flex align-items-center justify-content-center bg-light rounded-circle"
                            style="width: 40px; height: 40px;">
                            <i class="fas fa-user-shield text-secondary"></i>
                        </div>
                        <div>
                            <h5 class="m-0 font-weight-bold text-dark">Detail Role</h5>
                            <small class="text-muted">Masukkan nama role dan berikan permission</small>
                        </div>
                    </div>

                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf

                        <div class="form-group mb-4">
                            <label for="name" class="font-weight-normal text-secondary">Nama Role <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-right-0"><i
                                            class="fas fa-tag text-muted"></i></span>
                                </div>
                                <input type="text" name="name"
                                    class="form-control border-left-0 @error('name') is-invalid @enderror" id="name"
                                    placeholder="Contoh: admin, kasir, manager" value="{{ old('name') }}" required
                                    autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Section Checkbox Permissions --}}
                        <div class="form-group mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="font-weight-normal text-secondary mb-0">Berikan Permission</label>
                                <button type="button" class="btn btn-link btn-sm p-0 text-decoration-none"
                                    id="selectAll">Pilih Semua</button>
                            </div>

                            <div class="p-3 border rounded-lg bg-light" style="max-height: 250px; overflow-y: auto;">
                                <div class="row">
                                    @forelse($permissions as $perm)
                                        <div class="col-md-6 col-lg-4 mb-2">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input perm-checkbox" type="checkbox"
                                                    name="permissions[]" id="perm_{{ $perm->id }}"
                                                    value="{{ $perm->id }}">
                                                <label for="perm_{{ $perm->id }}"
                                                    class="custom-control-label font-weight-normal text-dark"
                                                    style="cursor: pointer;">
                                                    {{ $perm->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-12 text-center text-muted py-2">
                                            Belum ada permission yang tersedia di database.
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                            <a href="{{ route('roles.index') }}" class="btn btn-light border mr-2 px-4">
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

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let allChecked = false;
            $('#selectAll').on('click', function() {
                allChecked = !allChecked;
                $('.perm-checkbox').prop('checked', allChecked);
                $(this).text(allChecked ? 'Batalkan Semua' : 'Pilih Semua');
            });
        });
    </script>
@stop
