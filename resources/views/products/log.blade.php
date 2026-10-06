@extends('adminlte::page')

@section('title', 'Log - ' . $product->name)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <div class="d-flex align-items-center">
                <h1 class="font-weight-bold text-dark mb-0" style="font-size: 2rem; line-height: 1;">
                    Log <span class="mx-1">-</span> {{ $product->name }}
                </h1>
            </div>
            <div class="text-muted small mt-2">
                <a href="{{ url('/') }}" class="text-muted text-decoration-none">Home</a>
                <i class="fas fa-chevron-right mx-1" style="font-size: 0.6rem;"></i>
                <a href="{{ route('products.index') }}" class="text-muted text-decoration-none">Produk</a>
                <i class="fas fa-chevron-right mx-1" style="font-size: 0.6rem;"></i>
                <span>Log</span>
            </div>
        </div>
        <div>
            <a href="{{ route('products.index') }}"
                class="btn btn-dark btn-md px-3 font-weight-semibold shadow-sm rounded-lg"
                style="background-color: #0f172a; border: none;">
                <i class="fas fa-arrow-left mr-1" style="font-size: 0.8rem;"></i> Kembali
            </a>
        </div>
    </div>
@stop

@section('content')
    {{-- TABEL 1: PERUBAHAN HARGA --}}
    <div class="card border-0 shadow-sm rounded-lg overflow-hidden mb-4">
        <div class="card-header bg-white border-bottom py-3 px-4">
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mr-3 text-secondary"
                    style="width: 38px; height: 38px; background-color: #f1f5f9 !important;">
                    <i class="fas fa-file-invoice-dollar" style="font-size: 0.95rem;"></i>
                </div>
                <div>
                    <h5 class="m-0 font-weight-bold text-dark">Perubahan Harga</h5>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="border-collapse: separate;">
                    <thead style="background-color: #f8fafc; color: #475569;">
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <th class="py-3 px-4 font-weight-bold border-0" style="width: 60px;">#</th>
                            <th class="py-3 px-4 font-weight-bold border-0">Tanggal</th>
                            <th class="py-3 px-4 font-weight-bold border-0">Harga Lama</th>
                            <th class="py-3 px-4 font-weight-bold border-0">Harga Baru</th>
                        </tr>
                    </thead>
                    <tbody style="color: #334155;">
                        @forelse($priceLogs as $index => $log)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td class="py-3 px-4 text-muted align-middle" style="font-size: 0.9rem;">
                                    {{ $index + 1 }}
                                </td>
                                <td class="py-3 px-4 align-middle text-dark font-weight-medium" style="font-size: 0.9rem;">
                                    {{ $log->created_at->translatedFormat('d M Y') }}
                                </td>
                                <td class="py-3 px-4 align-middle text-muted" style="font-size: 0.9rem;">
                                    {{ $log->formatted_old_price }}
                                </td>
                                <td class="py-3 px-4 align-middle text-dark font-weight-bold" style="font-size: 0.95rem;">
                                    {{ $log->formatted_new_price }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="fas fa-history fa-2x mb-2 text-secondary" style="opacity: 0.3;"></i>
                                    <p class="mb-0 small">Belum ada riwayat perubahan harga untuk produk ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- TABEL 2: PERUBAHAN STOK --}}
    <div class="card border-0 shadow-sm rounded-lg overflow-hidden mb-4">
        <div class="card-header bg-white border-bottom py-3 px-4">
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mr-3 text-secondary"
                    style="width: 38px; height: 38px; background-color: #f1f5f9 !important;">
                    <i class="fas fa-boxes" style="font-size: 0.95rem;"></i>
                </div>
                <div>
                    <h5 class="m-0 font-weight-bold text-dark">Perubahan Stok</h5>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="border-collapse: separate;">
                    <thead style="background-color: #f8fafc; color: #475569;">
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <th class="py-3 px-4 font-weight-bold border-0" style="width: 60px;">#</th>
                            <th class="py-3 px-4 font-weight-bold border-0">Tanggal</th>
                            <th class="py-3 px-4 font-weight-bold border-0">Supplier / Pembeli</th>
                            <th class="py-3 px-4 font-weight-bold border-0">Stok Lama</th>
                            <th class="py-3 px-4 font-weight-bold border-0">Stok Baru</th>
                            <th class="py-3 px-4 font-weight-bold border-0" style="width: 150px;">Tipe</th>
                        </tr>
                    </thead>
                    <tbody style="color: #334155;">
                        @forelse($stockLogs as $index => $log)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td class="py-3 px-4 text-muted align-middle" style="font-size: 0.9rem;">
                                    {{ $index + 1 }}
                                </td>
                                <td class="py-3 px-4 align-middle text-dark font-weight-medium" style="font-size: 0.9rem;">
                                    {{ $log->created_at->translatedFormat('d M Y') }}
                                </td>
                                <td class="py-3 px-4 align-middle font-weight-medium text-dark" style="font-size: 0.9rem;">
                                    {{ $log->party_name ?? '-' }}
                                </td>
                                {{-- Satuan diubah dari unit menjadi pcs --}}
                                <td class="py-3 px-4 align-middle text-muted" style="font-size: 0.9rem;">
                                    {{ $log->old_stock }} pcs
                                </td>
                                <td class="py-3 px-4 align-middle text-dark font-weight-bold" style="font-size: 0.95rem;">
                                    {{ $log->new_stock }} pcs
                                </td>
                                <td class="py-3 px-4 align-middle">
                                    @if ($log->type == 'pembelian')
                                        <span class="badge badge-success px-2.5 py-1.5 font-weight-normal"
                                            style="font-size: 0.8rem;">Pembelian</span>
                                    @elseif($log->type == 'penjualan')
                                        <span class="badge badge-danger px-2.5 py-1.5 font-weight-normal"
                                            style="font-size: 0.8rem;">Penjualan</span>
                                    @else
                                        <span class="badge badge-secondary px-2.5 py-1.5 font-weight-normal"
                                            style="font-size: 0.8rem;">Edit</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-history fa-2x mb-2 text-secondary" style="opacity: 0.3;"></i>
                                    <p class="mb-0 small">Belum ada riwayat perubahan stok untuk produk ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@stop
