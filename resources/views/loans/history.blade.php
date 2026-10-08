@extends('adminlte::page')

@section('title', 'Riwayat Pinjaman - ' . $loan->employee->name)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <div class="d-flex align-items-center">
                <h1 class="font-weight-bold text-dark mb-0" style="font-size: 2rem; line-height: 1;">
                    Riwayat Pinjaman <span class="mx-1">-</span> {{ $loan->employee->name }}
                </h1>
            </div>
            <div class="text-muted small mt-2">
                <a href="{{ url('/') }}" class="text-muted text-decoration-none">Home</a>
                <i class="fas fa-chevron-right mx-1" style="font-size: 0.6rem;"></i>
                <a href="{{ route('employees.index') }}" class="text-muted text-decoration-none">Daftar Gaji</a>
                <i class="fas fa-chevron-right mx-1" style="font-size: 0.6rem;"></i>
                <span>Riwayat Pinjaman</span>
            </div>
        </div>
        <div>
            <a href="{{ route('employees.index') }}"
                class="btn btn-light border btn-md px-3 font-weight-semibold shadow-sm rounded-lg mr-1">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
            @if ($loan->status == 'active')
                <button type="button" class="btn btn-dark btn-md px-3 font-weight-semibold shadow-sm rounded-lg"
                    style="background-color: #0f172a; border: none;"
                    onclick="openPayModal({{ $loan->id }}, '{{ $loan->employee->name }}', {{ $loan->remaining_amount }})">
                    <i class="fas fa-hand-holding-usd mr-1"></i> Bayar Cicilan
                </button>
            @endif
        </div>
    </div>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-lg mb-3" role="alert">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Ringkasan Pinjaman Minimalis --}}
    <div class="row mb-4">
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card border-0 shadow-sm rounded-lg h-100" style="border-radius: 12px;">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mr-3 text-secondary"
                        style="width: 48px; height: 48px; background-color: #f1f5f9 !important;">
                        <i class="fas fa-wallet" style="font-size: 1.1rem;"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block font-weight-medium">Pinjaman Awal</span>
                        <h4 class="font-weight-bold text-dark mb-0">{{ $loan->formatted_amount }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card border-0 shadow-sm rounded-lg h-100" style="border-radius: 12px;">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mr-3 text-secondary"
                        style="width: 48px; height: 48px; background-color: #f1f5f9 !important;">
                        <i class="fas fa-receipt" style="font-size: 1.1rem;"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block font-weight-medium">Sisa Pinjaman Saat Ini</span>
                        <h4 class="font-weight-bold text-dark mb-0">{{ $loan->formatted_remaining_amount }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-lg h-100" style="border-radius: 12px;">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mr-3 text-secondary"
                        style="width: 48px; height: 48px; background-color: #f1f5f9 !important;">
                        <i class="fas fa-info-circle" style="font-size: 1.1rem;"></i>
                    </div>
                    <div>
                        <span class="text-muted small d-block font-weight-medium">Status Pinjaman</span>
                        <h5 class="font-weight-bold mb-0 mt-1">
                            @if ($loan->status == 'active')
                                {{-- Kotak Status Belum Lunas Dibuat Kuning --}}
                                <span class="badge badge-warning text-dark font-weight-bold px-2.5 py-1.5"
                                    style="border-radius: 6px;">
                                    Belum Lunas
                                </span>
                            @else
                                <span class="badge badge-success font-weight-medium px-2.5 py-1.5"
                                    style="border-radius: 6px;">
                                    Lunas
                                </span>
                            @endif
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Riwayat Pembayaran --}}
    <div class="card border-0 shadow-sm rounded-lg overflow-hidden">
        <div class="card-header bg-white border-bottom py-3 px-4">
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mr-2 text-secondary"
                    style="width: 32px; height: 32px;">
                    <i class="fas fa-history" style="font-size: 0.85rem;"></i>
                </div>
                <div>
                    <h5 class="m-0 font-weight-bold text-dark" style="font-size: 1rem;">Riwayat Potongan / Pembayaran
                        Cicilan</h5>
                    <small class="text-muted">Total {{ $loan->payments->count() }} transaksi tercatat</small>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #f8fafc; color: #475569;">
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <th class="py-3 px-4 font-weight-bold border-0" style="width: 60px;">#</th>
                            <th class="py-3 px-4 font-weight-bold border-0">Tanggal Pembayaran</th>
                            <th class="py-3 px-4 font-weight-bold border-0 text-right">Nominal Dicicil</th>
                        </tr>
                    </thead>
                    <tbody style="color: #334155;">
                        @forelse($loan->payments as $index => $payment)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td class="py-3 px-4 text-muted align-middle" style="font-size: 0.9rem;">
                                    {{ $index + 1 }}
                                </td>
                                <td class="py-3 px-4 align-middle text-dark font-weight-medium">
                                    {{ \Carbon\Carbon::parse($payment->payment_date)->translatedFormat('d F Y') }}
                                    <small
                                        class="text-muted d-block">{{ \Carbon\Carbon::parse($payment->payment_date)->format('l') }}</small>
                                </td>
                                <td class="py-3 px-4 align-middle text-right">
                                    {{-- Nominal Dicicil Dalam Kotak Bubble Berwarna Hijau --}}
                                    <span class="badge px-3 py-2 font-weight-semibold"
                                        style="background-color: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; border-radius: 8px; font-size: 0.875rem;">
                                        + {{ $payment->formatted_amount_paid }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted">
                                    <i class="fas fa-history fa-2x mb-2 text-secondary" style="opacity: 0.3;"></i>
                                    <p class="mb-0 small">Belum ada riwayat pembayaran cicilan untuk pinjaman ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Input Pembayaran Cicilan --}}
    <div class="modal fade" id="payModal" tabindex="-1" role="dialog" aria-labelledby="payModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg rounded-lg">
                <div class="modal-header border-bottom py-3 px-4">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mr-3 text-secondary"
                            style="width: 36px; height: 36px;">
                            <i class="fas fa-hand-holding-usd" style="font-size: 0.9rem;"></i>
                        </div>
                        <div>
                            <h5 class="modal-title font-weight-bold text-dark" id="payModalLabel"
                                style="font-size: 1.1rem;">Bayar Cicilan / Kasbon</h5>
                            <small class="text-muted">Catat pembayaran cicilan karyawan</small>
                        </div>
                    </div>
                    <button type="button" class="close btn-close-modal" aria-label="Close" style="outline: none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="payForm" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="p-3 bg-light rounded-lg mb-3" style="border-radius: 8px;">
                            <span class="text-muted small d-block">Karyawan</span>
                            <strong id="payEmployeeName" class="text-dark font-weight-bold"
                                style="font-size: 1rem;"></strong>
                        </div>

                        <div class="form-group mb-3">
                            <label for="amount_paid" class="font-weight-normal text-secondary small">Nominal Bayar (Rp)
                                <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span
                                        class="input-group-text bg-white border-right-0 font-weight-semibold text-muted">Rp</span>
                                </div>
                                <input type="number" name="amount_paid" id="amount_paid"
                                    class="form-control border-left-0" required min="1000">
                            </div>
                            <small class="text-muted mt-1 d-block">Maksimal bayar: <span id="payMaxAmount"
                                    class="font-weight-bold text-dark"></span></small>
                        </div>

                        <div class="form-group mb-0">
                            <label for="payment_date" class="font-weight-normal text-secondary small">Tanggal Potongan /
                                Bayar <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white border-right-0"><i
                                            class="fas fa-calendar-alt text-muted"></i></span>
                                </div>
                                <input type="date" name="payment_date" id="payment_date"
                                    class="form-control border-left-0" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top bg-light py-3 px-4">
                        <button type="button"
                            class="btn btn-light border px-4 rounded-lg font-weight-medium btn-close-modal">Batal</button>
                        <button type="submit" class="btn btn-dark px-4 rounded-lg font-weight-medium"
                            style="background-color: #0f172a; border: none;">
                            <i class="fas fa-save mr-1"></i> Simpan Cicilan
                        </button>
                    </div>
                </form>
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
            border-color: #cbd5e1;
        }
    </style>
@stop

@section('js')
    <script>
        function openPayModal(id, name, remaining) {
            $('#payForm').attr('action', '/loans/' + id + '/pay');
            $('#payEmployeeName').text(name);
            $('#amount_paid').attr('max', remaining).val(remaining > 100000 ? 100000 : remaining);
            $('#payMaxAmount').text('Rp. ' + new Intl.NumberFormat('id-ID').format(remaining));
            $('#payModal').modal('show');
        }

        document.addEventListener('DOMContentLoaded', function() {
            $(document).on('click', '.btn-close-modal, [data-dismiss="modal"], [data-bs-dismiss="modal"]',
                function() {
                    $('#payModal').modal('hide');
                });
        });
    </script>
@stop
