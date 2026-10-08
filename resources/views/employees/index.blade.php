@extends('adminlte::page')

@section('title', 'Daftar Gaji')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <div class="d-flex align-items-center">
                <h1 class="font-weight-bold text-dark mb-0" style="font-size: 2rem; line-height: 1;">
                    Daftar Gaji <span class="mx-1">-</span> <span id="total-count">{{ $employees->total() }}</span>
                </h1>
            </div>
            <div class="text-muted small mt-2">
                <a href="{{ url('/') }}" class="text-muted text-decoration-none">Home</a>
                <i class="fas fa-chevron-right mx-1" style="font-size: 0.6rem;"></i>
                <span>Daftar Gaji</span>
            </div>
        </div>

        {{-- Search Bar & Tombol Tambah Karyawan Menyatu --}}
        <div class="d-flex align-items-center">
            <div class="input-group mr-2" style="width: 280px;">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-white border-right-0 shadow-sm"
                        style="border-radius: 8px 0 0 8px; border-color: #cbd5e1;">
                        <i class="fas fa-search text-muted" style="font-size: 0.85rem;"></i>
                    </span>
                </div>
                <input type="text" id="employee-search" class="form-control border-left-0 shadow-sm"
                    placeholder="Cari nama karyawan (min. 3 karakter)..."
                    style="border-radius: 0 8px 8px 0; border-color: #cbd5e1; font-size: 0.875rem;">
            </div>

            <a href="{{ route('employees.create') }}"
                class="btn btn-dark btn-md px-3 font-weight-semibold shadow-sm rounded-lg text-nowrap"
                style="background-color: #0f172a; border: none; height: calc(2.25rem + 2px); display: inline-flex; align-items: center;">
                <i class="fas fa-plus mr-1" style="font-size: 0.8rem;"></i> Tambah Karyawan
            </a>
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
                            <th class="py-3 px-4 font-weight-bold border-0">Nama Karyawan</th>
                            <th class="py-3 px-4 font-weight-bold border-0">Gaji Pokok</th>
                            <th class="py-3 px-4 font-weight-bold border-0">Insentif</th>
                            <th class="py-3 px-4 font-weight-bold border-0">Tanggal Gajian</th>
                            <th class="py-3 px-4 font-weight-bold border-0">Status Pinjaman</th>
                            <th class="py-3 px-4 font-weight-bold border-0" style="width: 220px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="employee-table-body" style="color: #334155;">
                        @forelse($employees as $index =>$employee)
                            <tr class="employee-row" style="border-bottom: 1px solid #f1f5f9;">
                                <td class="py-3 px-4 text-muted align-middle" style="font-size: 0.9rem;">
                                    {{ $employees->firstItem() + $index }}
                                </td>
                                <td class="py-3 px-4 align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mr-3 text-secondary"
                                            style="width: 36px; height: 36px; background-color: #f1f5f9 !important;">
                                            <i class="fas fa-user" style="font-size: 0.85rem;"></i>
                                        </div>
                                        <div>
                                            <span class="font-weight-bold text-dark d-block employee-name"
                                                style="font-size: 0.95rem;">{{ $employee->name }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4 align-middle font-weight-semibold text-dark"
                                    style="font-size: 0.9rem;">
                                    Rp. {{ number_format($employee->salary, 0, ',', '.') }}
                                    <span class="badge badge-light border text-muted px-2 py-1 font-weight-normal ml-1"
                                        style="font-size: 0.75rem;">
                                        {{ $employee->salary_type == 'weekly' ? 'Mingguan' : 'Bulanan' }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 align-middle font-weight-semibold text-dark"
                                    style="font-size: 0.9rem;">
                                    Rp. {{ number_format($employee->incentive, 0, ',', '.') }}
                                    <span class="badge badge-light border text-muted px-2 py-1 font-weight-normal ml-1"
                                        style="font-size: 0.75rem;">
                                        {{ $employee->incentive_type == 'weekly' ? 'Mingguan' : 'Bulanan' }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 align-middle text-muted" style="font-size: 0.9rem;">
                                    {{ \Carbon\Carbon::parse($employee->payday_date)->translatedFormat('d F Y') }}
                                </td>
                                <td class="py-3 px-4 align-middle">
                                    @if ($employee->activeLoan)
                                        <span class="badge badge-warning px-2.5 py-1.5 font-weight-normal">
                                            Sisa: Rp.
                                            {{ number_format($employee->activeLoan->remaining_amount, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 align-middle">
                                    <div class="d-inline-flex align-items-center">
                                        {{-- Tombol Pinjaman --}}
                                        @if ($employee->activeLoan)
                                            <a href="{{ route('loans.history', $employee->activeLoan->id) }}"
                                                class="btn btn-outline-warning btn-sm px-2 mr-1 shadow-sm rounded"
                                                title="Riwayat / Bayar Cicilan"
                                                style="font-size: 0.8rem; border-color: #cbd5e1;">
                                                <i class="fas fa-hand-holding-usd text-warning"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('loans.create', ['employee_id' => $employee->id]) }}"
                                                class="btn btn-outline-secondary btn-sm px-2 mr-1 shadow-sm rounded"
                                                title="Tambah Pinjaman Baru"
                                                style="font-size: 0.8rem; border-color: #cbd5e1;">
                                                <i class="fas fa-hand-holding-usd text-secondary"></i>
                                            </a>
                                        @endif

                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('employees.edit', $employee->id) }}"
                                            class="btn btn-dark btn-sm px-3 mr-1 font-weight-normal shadow-sm rounded"
                                            style="background-color: #0f172a; border: none; font-size: 0.8rem;">
                                            <i class="fas fa-edit mr-1" style="font-size: 0.75rem;"></i> Edit
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        <button type="button"
                                            class="btn btn-outline-danger btn-sm px-2 shadow-sm rounded btn-delete"
                                            data-action="{{ route('employees.destroy', $employee->id) }}"
                                            data-name="{{ $employee->name }}"
                                            style="font-size: 0.8rem; border-color: #cbd5e1;">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr id="empty-row">
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fas fa-users fa-2x mb-2 text-secondary" style="opacity: 0.3;"></i>
                                    <p class="mb-0 small">Belum ada data karyawan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($employees->hasPages())
            <div class="card-footer bg-white border-0 py-3" id="pagination-wrapper">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="small text-muted">
                        Menampilkan {{ $employees->firstItem() }} sampai {{ $employees->lastItem() }} dari
                        {{ $employees->total() }} data
                    </span>
                    <div>
                        {{ $employees->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Modal Konfirmasi Hapus Minimalis --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 400px;">
            <div class="modal-content border-0 shadow-lg rounded-lg">
                <div class="modal-body p-4 text-center">
                    <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3 text-danger"
                        style="width: 56px; height: 56px; background-color: #fef2f2 !important;">
                        <i class="fas fa-exclamation-triangle fa-lg"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-1">Hapus Karyawan?</h5>
                    <p class="text-muted small mb-4" id="deleteModalText">Apakah Anda yakin ingin menghapus data karyawan
                        ini?
                        Tindakan ini tidak dapat dibatalkan.</p>

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
            // --- LOGIK SEARCH BAR REALTIME (FILTER 3 KARAKTER) ---
            const searchInput = document.getElementById('employee-search');
            const rows = document.querySelectorAll('.employee-row');
            const paginationWrapper = document.getElementById('pagination-wrapper');
            const tableBody = document.getElementById('employee-table-body');

            let noResultRow = document.createElement('tr');
            noResultRow.id = 'no-result-row';
            noResultRow.innerHTML = `
            <td colspan="7" class="text-center py-5 text-muted">
                <i class="fas fa-search fa-2x mb-2 text-secondary" style="opacity: 0.3;"></i>
                <p class="mb-0 small">Tidak ada karyawan yang cocok dengan pencarian.</p>
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
                    const nameText = row.querySelector('.employee-name').textContent.toLowerCase();

                    if (nameText.includes(query)) {
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
            $('.btn-delete').on('click', function() {
                const actionUrl = $(this).data('action');
                const itemName = $(this).data('name');
                $('#deleteForm').attr('action', actionUrl);
                $('#deleteModalText').html('Apakah Anda yakin ingin menghapus <strong>"' + itemName +
                    '"</strong>? Tindakan ini tidak dapat dibatalkan.');
                $('#deleteModal').modal('show');
            });

            $('#btnCancelDelete, [data-dismiss="modal"], [data-bs-dismiss="modal"]').on('click', function() {
                $('#deleteModal').modal('hide');
            });
        });
    </script>
@stop
