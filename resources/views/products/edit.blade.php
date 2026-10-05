@extends('adminlte::page')

@section('title', 'Edit Product')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <div class="d-flex align-items-center">
                <h1 class="font-weight-bold text-dark mb-0" style="font-size: 2rem; line-height: 1;">
                    Edit Produk
                </h1>
            </div>
            <div class="text-muted small mt-2">
                <a href="{{ url('/') }}" class="text-muted text-decoration-none">Home</a>
                <i class="fas fa-chevron-right mx-1" style="font-size: 0.6rem;"></i>
                <a href="{{ route('products.index') }}" class="text-muted text-decoration-none">Produk</a>
                <i class="fas fa-chevron-right mx-1" style="font-size: 0.6rem;"></i>
                <span>Edit Produk</span>
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
                            <i class="fas fa-edit text-secondary"></i>
                        </div>
                        <div>
                            <h5 class="m-0 font-weight-bold text-dark">Edit Produk</h5>
                            <small class="text-muted">Perbarui data produk yang dipilih</small>
                        </div>
                    </div>

                    <form action="{{ route('products.update', $product->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Nama Barang --}}
                        <div class="form-group mb-3">
                            <label for="name" class="font-weight-normal text-secondary">Nama Barang <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-right-0"><i
                                            class="fas fa-tag text-muted"></i></span>
                                </div>
                                <input type="text" name="name"
                                    class="form-control border-left-0 @error('name') is-invalid @enderror" id="name"
                                    value="{{ old('name', $product->name) }}" required autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- Jumlah Barang (Amount) --}}
                        <div class="form-group mb-3">
                            <label for="amount" class="font-weight-normal text-secondary">Jumlah Barang (Stok) <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-right-0"><i
                                            class="fas fa-cubes text-muted"></i></span>
                                </div>
                                <input type="number" name="amount"
                                    class="form-control border-left-0 @error('amount') is-invalid @enderror" id="amount"
                                    value="{{ old('amount', $product->amount) }}" min="0" required>
                                @error('amount')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- Harga Satuan (Unit Price) --}}
                        <div class="form-group mb-4">
                            <label for="unit_price" class="font-weight-normal text-secondary">Harga Satuan (Rp) <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span
                                        class="input-group-text bg-white border-right-0 font-weight-semibold text-muted">Rp</span>
                                </div>
                                <input type="number" step="0.01" name="unit_price"
                                    class="form-control border-left-0 @error('unit_price') is-invalid @enderror"
                                    id="unit_price" value="{{ old('unit_price', $product->unit_price) }}" min="0"
                                    required>
                                @error('unit_price')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                            <a href="{{ route('products.index') }}" class="btn btn-light border mr-2 px-4">
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
