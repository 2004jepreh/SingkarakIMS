@extends('adminlte::page')

@section('title', 'Penjualan')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <div class="d-flex align-items-center">
                <h1 class="font-weight-bold text-dark mb-0" style="font-size: 2rem; line-height: 1;">
                    Penjualan <span class="mx-1">-</span> <span id="total-count">{{ $sales->total() }}</span>
                </h1>
            </div>
            <div class="text-muted small mt-2">
                <a href="{{ url('/') }}" class="text-muted text-decoration-none">Home</a>
                <i class="fas fa-chevron-right mx-1" style="font-size: 0.6rem;"></i>
                <span>Penjualan</span>
            </div>
        </div>

        {{-- Search Bar & Tombol Tambah Penjualan Menyatu --}}
        <div class="d-flex align-items-center">
            <div class="input-group mr-2" style="width: 280px;">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-white border-right-0 shadow-sm"
                        style="border-radius: 8px 0 0 8px; border-color: #cbd5e1;">
                        <i class="fas fa-search text-muted" style="font-size: 0.85rem;"></i>
                    </span>
                </div>
                <input type="text" id="sale-search" class="form-control border-left-0 shadow-sm"
                    placeholder="Cari faktur/pembeli (min. 3)..."
                    style="border-radius: 0 8px 8px 0; border-color: #cbd5e1; font-size: 0.875rem;">
            </div>

            @can('create-sales')
                <a href="{{ route('sales.create') }}"
                    class="btn btn-dark btn-md px-3 font-weight-semibold shadow-sm rounded-lg text-nowrap"
                    style="background-color: #0f172a; border: none; height: calc(2.25rem + 2px); display: inline-flex; align-items: center;">
                    <i class="fas fa-plus mr-1" style="font-size: 0.8rem;"></i> Tambah Penjualan
                </a>
            @endcan
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

    <div class="card border-0 shadow-sm rounded-lg overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="border-collapse: separate;">
                    <thead style="background-color: #f8fafc; color: #475569;">
                        <tr style="border-bottom: 1px solid #e2e8f0;">
                            <th class="py-3 px-4 font-weight-bold border-0" style="width: 60px;">#</th>
                            <th class="py-3 px-4 font-weight-bold border-0">No. Faktur</th>
                            <th class="py-3 px-4 font-weight-bold border-0">Tanggal</th>
                            <th class="py-3 px-4 font-weight-bold border-0">Nama Pembeli</th>
                            <th class="py-3 px-4 font-weight-bold border-0">Diskon</th>
                            <th class="py-3 px-4 font-weight-bold border-0">Total Penjualan</th>
                            <th class="py-3 px-4 font-weight-bold border-0" style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="sale-table-body" style="color: #334155;">
                        @forelse($sales as $index =>$sale)
                            <tr class="sale-row" style="border-bottom: 1px solid #f1f5f9;">
                                <td class="py-3 px-4 text-muted align-middle" style="font-size: 0.9rem;">
                                    {{ $sales->firstItem() + $index }}
                                </td>
                                <td class="py-3 px-4 align-middle">
                                    <span class="font-weight-bold text-dark invoice-number"
                                        style="font-size: 0.95rem;">{{ $sale->invoice_number }}</span>
                                </td>
                                <td class="py-3 px-4 align-middle text-muted" style="font-size: 0.9rem;">
                                    {{ \Carbon\Carbon::parse($sale->date)->translatedFormat('d M Y') }}
                                </td>
                                <td class="py-3 px-4 align-middle font-weight-medium text-dark customer-name"
                                    style="font-size: 0.9rem;">
                                    {{ $sale->customer_name }}
                                </td>
                                <td class="py-3 px-4 align-middle text-muted" style="font-size: 0.85rem;">
                                    @if ($sale->discount_percent > 0)
                                        <span class="badge badge-light border px-2 py-1">
                                            {{ number_format($sale->discount_percent, 0) }}% (Rp.
                                            {{ number_format($sale->discount_amount, 0, ',', '.') }})
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="py-3 px-4 align-middle font-weight-bold text-dark" style="font-size: 0.95rem;">
                                    {{ $sale->formatted_total }}
                                </td>
                                <td class="py-3 px-4 align-middle">
                                    <div class="d-inline-flex align-items-center">
                                        <a href="{{ route('sales.show', $sale->id) }}"
                                            class="btn btn-dark btn-sm px-3 mr-1 font-weight-normal shadow-sm rounded text-nowrap d-inline-flex align-items-center justify-content-center"
                                            style="background-color: #0f172a; border: none; font-size: 0.8rem; height: 31px;">
                                            <i class="fas fa-eye mr-1" style="font-size: 0.75rem;"></i> Detail
                                        </a>

                                        @can('delete-sales')
                                            <button type="button"
                                                class="btn btn-outline-danger btn-sm px-2 shadow-sm rounded btn-delete"
                                                data-action="{{ route('sales.destroy', $sale->id) }}"
                                                data-name="{{ $sale->invoice_number }}"
                                                style="font-size: 0.8rem; border-color: #cbd5e1;">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr id="empty-row">
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fas fa-shopping-cart fa-2x mb-2 text-secondary" style="opacity: 0.3;"></i>
                                    <p class="mb-0 small">Belum ada transaksi penjualan yang tercatat.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($sales->hasPages())
            <div class="card-footer bg-white border-0 py-3" id="pagination-wrapper">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="small text-muted">
                        Menampilkan {{ $sales->firstItem() }} sampai {{ $sales->lastItem() }} dari
                        {{ $sales->total() }} data
                    </span>
                    <div>
                        {{ $sales->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Modal Konfirmasi Hapus --}}
    @can('delete-sales')
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 400px;">
                <div class="modal-content border-0 shadow-lg rounded-lg">
                    <div class="modal-body p-4 text-center">
                        <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3 text-danger"
                            style="width: 56px; height: 56px; background-color: #fef2f2 !important;">
                            <i class="fas fa-exclamation-triangle fa-lg"></i>
                        </div>
                        <h5 class="font-weight-bold text-dark mb-1">Hapus Transaksi Penjualan?</h5>
                        <p class="text-muted small mb-4" id="deleteModalText">Apakah Anda yakin ingin menghapus transaksi ini?
                            Stok produk akan dikembalikan otomatis.</p>

                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-light border px-4 mr-2 rounded-lg font-weight-semibold"
                                data-dismiss="modal" data-bs-dismiss="modal" id="btnCancelDelete">Batal</button>
                            <form id="deleteForm" action="" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger px-4 rounded-lg font-weight-semibold"
                                    style="background-color: #ef4444; border: none;">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan
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
        document.addEventListener('DOMContentLoaded', function() {
            // --- FILTER SEARCH BAR (MIN 3 KARAKTER) ---
            const searchInput = document.getElementById('sale-search');
            const rows = document.querySelectorAll('.sale-row');
            const paginationWrapper = document.getElementById('pagination-wrapper');
            const tableBody = document.getElementById('sale-table-body');

            let noResultRow = document.createElement('tr');
            noResultRow.id = 'no-result-row';
            noResultRow.innerHTML = `
            <td colspan="7" class="text-center py-5 text-muted">
                <i class="fas fa-search fa-2x mb-2 text-secondary" style="opacity: 0.3;"></i>
                <p class="mb-0 small">Tidak ada transaksi penjualan yang cocok dengan pencarian.</p>
            </td>
        `;

            searchInput.addEventListener('keyup', function() {
                const query = this.value.toLowerCase().trim();

                if (document.getElementById('no-result-row')) {
                    document.getElementById('no-result-row').remove();
                }

                if (query.length < 3) {
                    rows.forEach(row => row.style.display = '');
                    if (paginationWrapper) paginationWrapper.style.display = 'block';
                    return;
                }

                if (paginationWrapper) paginationWrapper.style.display = 'none';

                let visibleCount = 0;

                rows.forEach(row => {
                    const invoice = row.querySelector('.invoice-number').textContent.toLowerCase();
                    const customer = row.querySelector('.customer-name').textContent.toLowerCase();

                    if (invoice.includes(query) || customer.includes(query)) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                if (visibleCount === 0 && rows.length > 0) {
                    tableBody.appendChild(noResultRow);
                }
            });

            // --- MODAL DELETE ---
            @can('delete-sales')
                $('.btn-delete').on('click', function() {
                    const actionUrl = $(this).data('action');
                    const itemName = $(this).data('name');
                    $('#deleteForm').attr('action', actionUrl);
                    $('#deleteModalText').html('Apakah Anda yakin ingin menghapus faktur <strong>"' +
                        itemName +
                        '"</strong>? Stok produk yang ada pada faktur ini akan dikembalikan.');
                    $('#deleteModal').modal('show');
                });

                $('#btnCancelDelete, [data-dismiss="modal"], [data-bs-dismiss="modal"]').on('click', function() {
                    $('#deleteModal').modal('hide');
                });
            @endcan
        });
    </script>
@stop
