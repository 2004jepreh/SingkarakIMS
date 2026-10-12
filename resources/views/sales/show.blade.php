@extends('adminlte::page')

{{-- Menyetel Title agar nama file PDF otomatis sesuai Nomor Faktur saat Save as PDF --}}
@section('title', $sale->invoice_number)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <div class="d-flex align-items-center">
                <h1 class="font-weight-bold text-dark mb-0" style="font-size: 1.8rem; line-height: 1;">
                    Faktur Penjualan <span class="mx-1">-</span> {{ $sale->invoice_number }}
                </h1>
            </div>
            <div class="text-muted small mt-2">
                <a href="{{ url('/') }}" class="text-muted text-decoration-none">Home</a>
                <i class="fas fa-chevron-right mx-1" style="font-size: 0.6rem;"></i>
                <a href="{{ route('sales.index') }}" class="text-muted text-decoration-none">Penjualan</a>
                <i class="fas fa-chevron-right mx-1" style="font-size: 0.6rem;"></i>
                <span>Faktur Penjualan</span>
            </div>
        </div>
        <div>
            <a href="{{ route('sales.index') }}"
                class="btn btn-light border btn-md px-3 font-weight-semibold shadow-sm rounded-lg mr-1">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
            <button onclick="window.print()" class="btn btn-dark btn-md px-3 font-weight-semibold shadow-sm rounded-lg"
                style="background-color: #0f172a; border: none;">
                <i class="fas fa-print mr-1"></i> Cetak
            </button>
        </div>
    </div>
@stop

@section('content')
    <div class="card border-0 shadow-sm rounded-lg overflow-hidden" id="printable-invoice">
        <div class="card-body p-4 p-md-5">

            {{-- Header Judul Tengah: Badge Kotak Hitam FAKTUR PENJUALAN --}}
            <div class="text-center mb-4">
                <span class="badge badge-dark px-4 py-2 font-weight-normal"
                    style="background-color: #0f172a; font-size: 1.15rem; letter-spacing: 1px;">
                    FAKTUR PENJUALAN
                </span>
            </div>

            {{-- Baris Informasi Sejajar di Atas Garis Tabel --}}
            <div class="row align-items-end mb-4 pb-3 border-bottom">
                {{-- Kiri: Toko Singkarak & Nomor Faktur (Ukuran Kecil) --}}
                <div class="col-sm-4 mb-3 mb-sm-0">
                    <h2 class="font-weight-bold text-dark mb-0" style="font-size: 1.75rem; line-height: 1.2;">Toko Singkarak
                    </h2>
                    <p class="text-muted small mb-0 font-weight-medium mt-1" style="font-size: 0.9rem;">
                        No. Faktur: {{ $sale->invoice_number }}
                    </p>
                </div>

                {{-- Tengah: Tanggal Faktur (Sederet dengan Nomor Faktur) --}}
                <div class="col-sm-4 text-center mb-3 mb-sm-0">
                    <p class="text-muted small mb-0 font-weight-medium" style="font-size: 0.9rem;">
                        Tanggal: {{ \Carbon\Carbon::parse($sale->date)->translatedFormat('d F Y') }}
                    </p>
                </div>

                {{-- Kanan: Kepada Yth: Nama Pembeli & Lokasi --}}
                <div class="col-sm-4 text-sm-right">
                    <small class="text-muted d-block font-weight-medium mb-1">Kepada Yth:</small>

                    @php
                        // Memisahkan berdasarkan karakter tanda hubung (-), koma (,), atau spasi otomatis
                        $delimiterPattern = '/\s*[\-\,]\s*/';
                        $nameParts = preg_split($delimiterPattern, trim($sale->customer_name), 2);

                        $customerName = trim($nameParts[0] ?? $sale->customer_name);
                        $customerLocation = isset($nameParts[1]) ? trim($nameParts[1]) : null;
                    @endphp

                    {{-- Baris 1: Nama Pembeli --}}
                    <h3 class="font-weight-bold text-dark mb-0" style="font-size: 1.6rem; line-height: 1.2;">
                        {{ $customerName }}
                    </h3>

                    {{-- Baris 2: Lokasi / Kota (Jika ada) --}}
                    @if ($customerLocation)
                        <h5 class="font-weight-bold text-secondary mb-0 mt-1" style="font-size: 1.15rem;">
                            {{ $customerLocation }}
                        </h5>
                    @endif
                </div>
            </div>

            {{-- Tabel Item Barang --}}
            <div class="table-responsive mb-4">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #f8fafc; color: #475569;">
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <th class="py-3 px-3 font-weight-bold border-0" style="width: 50px;">No.</th>
                            <th class="py-3 px-3 font-weight-bold border-0">Nama Barang</th>
                            <th class="py-3 px-3 font-weight-bold border-0 text-center" style="width: 100px;">Banyaknya</th>
                            <th class="py-3 px-3 font-weight-bold border-0 text-center" style="width: 150px;">Harga Satuan
                            </th>
                            <th class="py-3 px-3 font-weight-bold border-0 text-center" style="width: 100px;">Diskon
                            </th>
                            <th class="py-3 px-3 font-weight-bold border-0 text-center" style="width: 140px;">Potongan</th>
                            <th class="py-3 px-3 font-weight-bold border-0 text-center" style="width: 160px;">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody style="color: #334155;">
                        @foreach ($sale->details as $index => $detail)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td class="py-3 px-3 text-muted align-middle" style="font-size: 0.9rem;">
                                    {{ $index + 1 }}
                                </td>
                                <td class="py-3 px-3 align-middle font-weight-bold text-dark" style="font-size: 0.95rem;">
                                    {{ $detail->product->name ?? '-' }}
                                </td>
                                <td class="py-3 px-3 align-middle text-center" style="font-size: 0.9rem;">
                                    <span class="badge badge-light border px-2 py-1 font-weight-normal">
                                        {{ $detail->amount }} pcs
                                    </span>
                                </td>
                                <td class="py-3 px-3 align-middle text-center text-muted" style="font-size: 0.9rem;">
                                    Rp. {{ number_format($detail->unit_price, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-3 align-middle text-center text-muted" style="font-size: 0.9rem;">
                                    {{ $detail->discount_percent > 0 ? number_format($detail->discount_percent, 0) . '%' : '-' }}
                                </td>
                                <td class="py-3 px-3 align-middle text-center text-muted" style="font-size: 0.9rem;">
                                    {{ $detail->discount_amount > 0 ? '- Rp. ' . number_format($detail->discount_amount, 0, ',', '.') : '-' }}
                                </td>
                                <td class="py-3 px-3 align-middle text-center font-weight-semibold text-dark"
                                    style="font-size: 0.9rem;">
                                    Rp. {{ number_format($detail->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Ringkasan Total Faktur --}}
            <div class="row justify-content-end mb-5">
                <div class="col-md-5 col-lg-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-secondary small font-weight-medium">Sub Total:</span>
                        <span class="font-weight-semibold text-dark">Rp.
                            {{ number_format($sale->subtotal, 0, ',', '.') }}</span>
                    </div>

                    @if ($sale->discount_percent > 0)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-secondary small font-weight-medium">Diskon
                                ({{ number_format($sale->discount_percent, 0) }}%):</span>
                            <span class="text-danger small">- Rp.
                                {{ number_format($sale->discount_amount, 0, ',', '.') }}</span>
                        </div>
                    @endif

                    <hr class="my-2">

                    <div class="d-flex justify-content-between align-items-center">
                        <span class="font-weight-bold text-dark">Total Akhir:</span>
                        <span class="h4 font-weight-bold text-dark mb-0">Rp.
                            {{ number_format($sale->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Area Tanda Tangan: Diterima Oleh (Kiri) & Hormat Kami (Kanan) --}}
            <div class="row justify-content-between mt-5 pt-3">
                {{-- Kiri: Diterima Oleh --}}
                <div class="col-md-3 col-sm-4 text-center">
                    <p class="mb-5 font-weight-medium text-dark">Diterima Oleh,</p>
                    <br>
                    <p class="mt-4 mb-0 text-muted">( ............................................ )</p>
                </div>

                {{-- Kanan: Hormat Kami --}}
                <div class="col-md-3 col-sm-4 text-center">
                    <p class="mb-5 font-weight-medium text-dark">Hormat Kami,</p>
                    <br>
                    <p class="mt-4 mb-0 text-muted">( ............................................ )</p>
                </div>
            </div>

        </div>
    </div>
@stop

@section('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media print {
            @page {
                size: portrait;
                margin: 0;
            }

            body {
                padding: 15mm;
            }

            body * {
                visibility: hidden;
            }

            #printable-invoice,
            #printable-invoice * {
                visibility: visible;
            }

            #printable-invoice {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                border: none !important;
                box-shadow: none !important;
            }

            .btn,
            nav,
            .main-sidebar,
            .main-header,
            .content-header {
                display: none !important;
            }
        }
    </style>
@stop
