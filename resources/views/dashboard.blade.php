@extends('adminlte::page')

@section('title', 'Home')

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
                        <img src="{{ asset('images/supine.jpeg') }}" alt="Profile SingkarakIMS" class="w-100 h-100"
                            style="object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Layout Card Dashboard: Inventory (Col-6) + Pembelian (Col-3) + Penjualan (Col-3) --}}
    <div class="row">

        {{-- 1. Card Manajemen Inventory (Col-6 Asli / Semula) --}}
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm modern-card-premium"
                style="border-radius: 20px; overflow: hidden; position: relative;">

                {{-- Accent Line Blue --}}
                <div style="height: 4px; background: linear-gradient(90deg, #3b82f6 0%, #8b5cf6 100%);"></div>

                <div class="card-body p-4 d-flex flex-column" style="position: relative;">

                    {{-- Watermark Icon --}}
                    <i class="fas fa-boxes"
                        style="position: absolute; right: -20px; bottom: -20px; font-size: 10rem; color: #f8fafc; z-index: 0; transform: rotate(-15deg);"></i>

                    <div class="position-relative" style="z-index: 1;">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div class="d-flex align-items-center">
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

                        <div class="mb-4">
                            <div class="d-flex align-items-baseline">
                                <h2 class="font-weight-bold text-dark mb-0"
                                    style="font-size: 3rem; line-height: 1; letter-spacing: -2px;">
                                    {{ \App\Models\Product::count() }}
                                </h2>
                                <span class="text-muted font-weight-medium ml-2" style="font-size: 1rem;">item</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-3 border-top d-flex justify-content-between align-items-center position-relative"
                        style="z-index: 1;">
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

        {{-- 2. Card Pembelian (Full Gradient Emerald) --}}
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm gradient-card-emerald h-100"
                style="border-radius: 20px; overflow: hidden; position: relative;">

                {{-- Decorative Background Circle --}}
                <div
                    style="position: absolute; top: -40px; right: -40px; width: 160px; height: 160px; border-radius: 50%; background: rgba(255,255,255,0.08);">
                </div>
                <div
                    style="position: absolute; top: 20px; right: 10px; width: 80px; height: 80px; border-radius: 50%; background: rgba(255,255,255,0.05);">
                </div>

                <div class="card-body p-4 d-flex flex-column justify-content-between position-relative" style="z-index: 1;">
                    <div>
                        {{-- Header Icon & Status Badge --}}
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center justify-content-center"
                                style="width: 52px; height: 52px; border-radius: 14px; background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3);">
                                <i class="fas fa-file-invoice-dollar text-white" style="font-size: 1.3rem;"></i>
                            </div>
                            <span class="badge px-3 py-2 font-weight-medium text-white"
                                style="background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); border-radius: 10px; font-size: 0.7rem; border: 1px solid rgba(255,255,255,0.2);">
                                <i class="fas fa-arrow-down mr-1"></i> Stok Masuk
                            </span>
                        </div>

                        {{-- Title & Info --}}
                        <h5 class="font-weight-bold text-white mb-1" style="font-size: 1.2rem;">Pembelian</h5>
                        <p class="text-white small mb-4" style="opacity: 0.85;">Transaksi barang masuk dari supplier</p>

                        {{-- Value Stat Glass Box --}}
                        <div class="p-3 mb-4"
                            style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); border-radius: 14px;">
                            <span class="text-white d-block mb-1 font-weight-medium text-uppercase"
                                style="font-size: 0.7rem; letter-spacing: 0.8px; opacity: 0.8;">
                                Total Transaksi
                            </span>
                            <div class="d-flex align-items-baseline">
                                <h2 class="font-weight-bold mb-0 text-white"
                                    style="letter-spacing: -1.5px; font-size: 2.5rem; line-height: 1;">
                                    {{ class_exists('\App\Models\Purchase') ? \App\Models\Purchase::count() : 0 }}
                                </h2>
                                <span class="text-white ml-2 font-weight-medium"
                                    style="font-size: 0.9rem; opacity: 0.85;">faktur</span>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons Stack --}}
                    <div>
                        <a href="{{ route('purchases.create') }}"
                            class="btn btn-block btn-sm py-2 font-weight-bold mb-2 d-flex align-items-center justify-content-center"
                            style="background-color: #ffffff; border: none; color: #059669; border-radius: 10px; transition: all 0.3s ease;">
                            <i class="fas fa-plus-circle mr-2" style="font-size: 0.85rem;"></i> Tambah Pembelian
                        </a>
                        <a href="{{ route('purchases.index') }}"
                            class="btn btn-block btn-sm py-2 font-weight-medium text-white d-flex align-items-center justify-content-center"
                            style="border-radius: 10px; border: 1px solid rgba(255,255,255,0.4); background: transparent; transition: all 0.3s ease;">
                            Lihat Semua Pembelian
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. Card Penjualan (Full Gradient Amber/Gold) --}}
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm gradient-card-amber h-100"
                style="border-radius: 20px; overflow: hidden; position: relative;">

                {{-- Decorative Background Circle --}}
                <div
                    style="position: absolute; top: -40px; right: -40px; width: 160px; height: 160px; border-radius: 50%; background: rgba(255,255,255,0.1);">
                </div>
                <div
                    style="position: absolute; top: 20px; right: 10px; width: 80px; height: 80px; border-radius: 50%; background: rgba(255,255,255,0.08);">
                </div>

                <div class="card-body p-4 d-flex flex-column justify-content-between position-relative" style="z-index: 1;">
                    <div>
                        {{-- Header Icon & Status Badge --}}
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center justify-content-center"
                                style="width: 52px; height: 52px; border-radius: 14px; background: rgba(255,255,255,0.25); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.4);">
                                <i class="fas fa-receipt text-white" style="font-size: 1.3rem;"></i>
                            </div>
                            <span class="badge px-3 py-2 font-weight-medium text-white"
                                style="background: rgba(255,255,255,0.25); backdrop-filter: blur(10px); border-radius: 10px; font-size: 0.7rem; border: 1px solid rgba(255,255,255,0.3);">
                                <i class="fas fa-arrow-up mr-1"></i> Stok Keluar
                            </span>
                        </div>

                        {{-- Title & Info --}}
                        <h5 class="font-weight-bold text-white mb-1"
                            style="font-size: 1.2rem; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">Penjualan</h5>
                        <p class="text-white small mb-4" style="opacity: 0.9;">Transaksi barang keluar ke pembeli</p>

                        {{-- Value Stat Glass Box --}}
                        <div class="p-3 mb-4"
                            style="background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3); border-radius: 14px;">
                            <span class="text-white d-block mb-1 font-weight-medium text-uppercase"
                                style="font-size: 0.7rem; letter-spacing: 0.8px; opacity: 0.9;">
                                Total Transaksi
                            </span>
                            <div class="d-flex align-items-baseline">
                                <h2 class="font-weight-bold mb-0 text-white"
                                    style="letter-spacing: -1.5px; font-size: 2.5rem; line-height: 1; text-shadow: 0 1px 2px rgba(0,0,0,0.1);">
                                    {{ class_exists('\App\Models\Sale') ? \App\Models\Sale::count() : 0 }}
                                </h2>
                                <span class="text-white ml-2 font-weight-medium"
                                    style="font-size: 0.9rem; opacity: 0.9;">faktur</span>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons Stack --}}
                    <div>
                        <a href="{{ route('sales.create') }}"
                            class="btn btn-block btn-sm py-2 font-weight-bold mb-2 d-flex align-items-center justify-content-center"
                            style="background-color: #ffffff; border: none; color: #b45309; border-radius: 10px; transition: all 0.3s ease;">
                            <i class="fas fa-plus-circle mr-2" style="font-size: 0.85rem;"></i> Tambah Penjualan
                        </a>
                        <a href="{{ route('sales.index') }}"
                            class="btn btn-block btn-sm py-2 font-weight-medium text-white d-flex align-items-center justify-content-center"
                            style="border-radius: 10px; border: 1px solid rgba(255,255,255,0.5); background: transparent; transition: all 0.3s ease;">
                            Lihat Semua Penjualan
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@stop

@section('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Efek Hover Card Premium (Inventory) */
        .modern-card-premium {
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            background-color: #ffffff;
        }

        .modern-card-premium:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08) !important;
        }

        /* ==== CARD PEMBELIAN: FULL GRADIENT EMERALD ==== */
        .gradient-card-emerald {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .gradient-card-emerald:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(16, 185, 129, 0.35) !important;
        }

        /* ==== CARD PENJUALAN: FULL GRADIENT AMBER/GOLD ==== */
        .gradient-card-amber {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 50%, #d97706 100%);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .gradient-card-amber:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(245, 158, 11, 0.4) !important;
        }

        /* Efek Hover Link Lihat Detail */
        .hover-link-modern:hover {
            color: #3b82f6 !important;
        }

        .hover-link-modern:hover i {
            transform: translateX(4px);
        }

        /* Efek Hover Tombol Inventory */
        .btn-modern-primary {
            transition: all 0.3s ease;
        }

        .btn-modern-primary:hover {
            background-color: #1e293b !important;
            box-shadow: 0 8px 15px rgba(15, 23, 42, 0.3) !important;
            transform: translateY(-2px);
        }

        /* Hover Tombol Putih di Card Gradient */
        .gradient-card-emerald .btn-block:hover,
        .gradient-card-amber .btn-block:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }
    </style>
@stop
