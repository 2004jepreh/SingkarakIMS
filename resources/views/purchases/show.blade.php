@extends('adminlte::page')

{{-- Menyetel Title agar nama file PDF otomatis sesuai Nomor Faktur saat Save as PDF --}}
@section('title', $purchase->invoice_number)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <div class="d-flex align-items-center">
                <h1 class="font-weight-bold text-dark mb-0" style="font-size: 1.8rem; line-height: 1;">
                    Faktur Pembelian <span class="mx-1">-</span> {{ $purchase->invoice_number }}
                </h1>
            </div>
            <div class="text-muted small mt-2">
                <a href="{{ url('/') }}" class="text-muted text-decoration-none">Home</a>
                <i class="fas fa-chevron-right mx-1" style="font-size: 0.6rem;"></i>
                <a href="{{ route('purchases.index') }}" class="text-muted text-decoration-none">Pembelian</a>
                <i class="fas fa-chevron-right mx-1" style="font-size: 0.6rem;"></i>
                <span>Faktur Pembelian</span>
            </div>
        </div>
        <div>
            <a href="{{ route('purchases.index') }}" class="btn btn-light border btn-md px-3 font-weight-semibold shadow-sm rounded-lg mr-1">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
            <button onclick="window.print()" class="btn btn-dark btn-md px-3 font-weight-semibold shadow-sm rounded-lg" style="background-color: #0f172a; border: none;">
                <i class="fas fa-print mr-1"></i> Cetak
            </button>
        </div>
    </div>
@stop

@section('content')
    <div class="card border-0 shadow-sm rounded-lg overflow-hidden" id="printable-invoice">
        {{-- Header Faktur --}}
        <div class="card-body p-4 p-md-5">
            <div class="row align-items-center mb-4 pb-3 border-bottom">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <span class="badge badge-dark px-3 py-1 font-weight-normal mb-2" style="background-color: #0f172a;">FAKTUR PEMBELIAN</span>
                    <h3 class="font-weight-bold text-dark mb-1">{{ $purchase->invoice_number }}</h3>
                    <p class="text-muted small mb-0">Tanggal: {{ \Carbon\Carbon::parse($purchase->date)->translatedFormat('d F Y') }}</p>
                    <p class="text-muted small mb-0">Supplier: <strong>{{ $purchase->supplier_name }}</strong></p>
                </div>
                <div class="col-sm-6 text-sm-right">
                    <small class="text-muted d-block font-weight-medium">Kepada Yth:</small>
                    <h5 class="font-weight-bold text-dark mb-0">Toko Singkarak</h5>
                </div>
            </div>

            {{-- Tabel Item Barang --}}
            <div class="table-responsive mb-4">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #f8fafc; color: #475569;">
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <th class="py-3 px-4 font-weight-bold border-0" style="width: 50px;">No.</th>
                            <th class="py-3 px-4 font-weight-bold border-0">Nama Barang</th>
                            <th class="py-3 px-4 font-weight-bold border-0 text-center" style="width: 120px;">Banyaknya</th>
                            <th class="py-3 px-4 font-weight-bold border-0 text-right" style="width: 180px;">Harga Satuan</th>
                            <th class="py-3 px-4 font-weight-bold border-0 text-right" style="width: 200px;">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody style="color: #334155;">
                        @foreach($purchase->details as $index => $detail)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td class="py-3 px-4 text-muted align-middle" style="font-size: 0.9rem;">
                                    {{ $index + 1 }}
                                </td>
                                <td class="py-3 px-4 align-middle font-weight-bold text-dark" style="font-size: 0.95rem;">
                                    {{ $detail->product->name ?? '-' }}
                                </td>
                                <td class="py-3 px-4 align-middle text-center" style="font-size: 0.9rem;">
                                    <span class="badge badge-light border px-2 py-1 font-weight-normal">
                                        {{ $detail->amount }} pcs
                                    </span>
                                </td>
                                <td class="py-3 px-4 align-middle text-right text-muted" style="font-size: 0.9rem;">
                                    Rp. {{ number_format($detail->unit_price, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-4 align-middle text-right font-weight-semibold text-dark" style="font-size: 0.9rem;">
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
                        <span class="font-weight-semibold text-dark">Rp. {{ number_format($purchase->subtotal, 0, ',', '.') }}</span>
                    </div>

                    @if($purchase->discount_percent > 0)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-secondary small font-weight-medium">Discount ({{ number_format($purchase->discount_percent, 0) }}%):</span>
                            <span class="text-danger small">- Rp. {{ number_format($purchase->discount_amount, 0, ',', '.') }}</span>
                        </div>
                    @endif

                    <hr class="my-2">

                    <div class="d-flex justify-content-between align-items-center">
                        <span class="font-weight-bold text-dark">Total:</span>
                        <span class="h4 font-weight-bold text-dark mb-0">Rp. {{ number_format($purchase->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Area Tanda Tangan & Hormat Kami --}}
            <div class="row justify-content-end mt-5 pt-3">
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
                margin: 0; /* Menghilangkan margin halaman bawaan untuk menyembunyikan header/footer URL & nomor halaman */
            }

            body {
                padding: 15mm; /* Memberi jarak aman agar isi konten faktur tidak mepet ke pinggir kertas */
            }

            body * { visibility: hidden; }
            #printable-invoice, #printable-invoice * { visibility: visible; }
            #printable-invoice { position: absolute; left: 0; top: 0; width: 100%; border: none !important; box-shadow: none !important; }
            .btn, nav, .main-sidebar, .main-header, .content-header { display: none !important; }
        }
    </style>
@stop
