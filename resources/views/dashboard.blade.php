@extends('adminlte::page')

@section('title', 'Dashboard Inventory')

@section('content_header')
    {{-- Content Header dikosongkan agar Hero Banner menyatu rapi di bagian paling atas --}}
@stop

@section('content')
    {{-- Hero Banner Sambutan Toko Singkarak --}}
    <br>
    <div class="card border-0 shadow-sm text-white mb-4 overflow-hidden"
        style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); border-radius: 16px;">
        <div class="card-body p-4 p-md-5 position-relative">
            <div class="row align-items-center">
                <div class="col-lg-8 z-index-1">
                    <span class="badge px-3 py-2 mb-3 font-weight-normal text-white"
                        style="background-color: rgba(255, 255, 255, 0.1); backdrop-filter: blur(4px); border: 1px solid rgba(255, 255, 255, 0.15); font-size: 0.8rem; border-radius: 20px;">
                        <i class="fas fa-store mr-1 text-info"></i> Singkarak Inventory Management System
                    </span>

                    <h1 class="display-5 font-weight-bold mb-2">
                        Selamat Datang Kembali, {{ auth()->user()->name ?? 'Admin' }}! 👋
                    </h1>

                    <p class="lead text-light mb-0"
                        style="opacity: 0.85; font-size: 1.05rem; font-weight: 300; max-width: 650px;">
                        Sistem pencatatan dan pengelolaan stok barang Toko Singkarak. Pantau ketersediaan produk dan
                        kelancaran operasional toko dengan rapi dan terkontrol.
                    </p>
                </div>

                {{-- Foto Profil di Bagian Kanan --}}
                <div class="col-lg-4 d-none d-lg-flex justify-content-end align-items-center">
                    <div class="rounded-circle overflow-hidden shadow-lg border"
                        style="width: 130px; height: 130px; border-color: rgba(255, 255, 255, 0.2) !important;">
                        <img src="{{ asset('images/profile.png') }}" alt="Profile SingkarakIMS" class="w-100 h-100"
                            style="object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Card Manajemen Produk (Desain Premium & Modern) --}}
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 modern-card-premium"
                style="border-radius: 20px; overflow: hidden; position: relative;">

                {{-- Top Gradient Accent Line --}}
                <div style="height: 4px; background: linear-gradient(90deg, #3b82f6 0%, #8b5cf6 100%);"></div>

                <div class="card-body p-4 d-flex flex-column" style="position: relative;">

                    {{-- Decorative Background Icon (Watermark) --}}
                    <i class="fas fa-boxes"
                        style="position: absolute; right: -20px; bottom: -20px; font-size: 10rem; color: #f8fafc; z-index: 0; transform: rotate(-15deg);"></i>

                    <div class="position-relative" style="z-index: 1;">
                        {{-- Header: Icon + Badge --}}
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div class="d-flex align-items-center">
                                {{-- Icon dengan Gradient Background --}}
                                <div class="d-flex align-items-center justify-content-center mr-3 shadow-sm"
                                    style="width: 60px; height: 60px; border-radius: 16px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                                    <i class="fas fa-box-open text-white" style="font-size: 1.5rem;"></i>
                                </div>
                                <div>
                                    <h5 class="font-weight-bold text-dark mb-0"
                                        style="font-size: 1.15rem; letter-spacing: -0.3px;">
                                        Manajemen Inventory
                                    </h5>
                                    <span class="text-muted small font-weight-medium">Jumlah Produk</span>
                                </div>
                            </div>
                        </div>

                        {{-- Statistik Besar --}}
                        <div class="mb-4">
                            <div class="d-flex align-items-baseline">
                                <h2 class="font-weight-bold text-dark mb-0"
                                    style="font-size: 3rem; line-height: 1; letter-spacing: -2px;">
                                    {{ \App\Models\Product::count() }}
                                </h2>
                                <span class="text-muted font-weight-medium ml-2" style="font-size: 1rem;">item</span>
                            </div>
                        </div>

                        {{-- Footer: Action Buttons --}}
                        <div class="pt-3 border-top d-flex justify-content-between align-items-center">
                            <a href="{{ route('products.index') }}"
                                class="text-muted small font-weight-bold text-decoration-none hover-link-modern d-flex align-items-center">
                                Lihat Detail
                                <i class="fas fa-arrow-right ml-2"
                                    style="font-size: 0.7rem; transition: transform 0.3s ease;"></i>
                            </a>
                            <a href="{{ route('products.create') }}"
                                class="btn btn-sm px-4 py-2 font-weight-medium shadow-sm btn-modern-primary"
                                style="background-color: #0f172a; border: none; border-radius: 10px; color: #fff;">
                                <i class="fas fa-plus mr-1" style="font-size: 0.75rem;"></i> Tambah
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Efek Hover Modern untuk Card Premium */
        .modern-card-premium {
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            background-color: #ffffff;
        }

        .modern-card-premium:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08) !important;
        }

        /* Efek Hover Link Lihat Detail */
        .hover-link-modern:hover {
            color: #3b82f6 !important;
        }

        .hover-link-modern:hover i {
            transform: translateX(4px);
        }

        /* Efek Hover Tombol Tambah */
        .btn-modern-primary {
            transition: all 0.3s ease;
        }

        .btn-modern-primary:hover {
            background-color: #1e293b !important;
            box-shadow: 0 8px 15px rgba(15, 23, 42, 0.3) !important;
            transform: translateY(-2px);
        }
    </style>
@stop
