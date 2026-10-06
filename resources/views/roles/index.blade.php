@extends('adminlte::page')

@section('title', 'Role')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <div class="d-flex align-items-center">
                <h1 class="font-weight-bold text-dark mb-0" style="font-size: 2rem; line-height: 1;">
                    Role <span class="mx-1">-</span> {{ $roles->total() }}
                </h1>
            </div>
            <div class="text-muted small mt-2">
                <a href="{{ url('/') }}" class="text-muted text-decoration-none">Home</a>
                <i class="fas fa-chevron-right mx-1" style="font-size: 0.6rem;"></i>
                <span>Role</span>
            </div>
        </div>
        <div>
            <a href="{{ route('roles.create') }}" class="btn btn-dark btn-md px-3 font-weight-semibold shadow-sm rounded-lg"
                style="background-color: #0f172a; border: none;">
                <i class="fas fa-plus mr-1" style="font-size: 0.8rem;"></i> Tambah Role
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
                            <th class="py-3 px-4 font-weight-bold border-0">Nama</th>
                            <th class="py-3 px-4 font-weight-bold border-0">Permission</th>
                            <th class="py-3 px-4 font-weight-bold border-0" style="width: 200px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="color: #334155;">
                        @forelse($roles as $index => $role)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td class="py-3 px-4 text-muted align-middle" style="font-size: 0.9rem;">
                                    {{ $roles->firstItem() + $index }}
                                </td>
                                <td class="py-3 px-4 align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mr-3 text-secondary"
                                            style="width: 36px; height: 36px; background-color: #f1f5f9 !important;">
                                            <i class="fas fa-user-shield" style="font-size: 0.85rem;"></i>
                                        </div>
                                        <div>
                                            <span class="font-weight-bold text-dark d-block"
                                                style="font-size: 0.95rem;">{{ $role->name }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4 align-middle">
                                    @forelse($role->permissions as $perm)
                                        <span
                                            class="badge badge-light border text-muted px-2 py-1 mr-1 mb-1 font-weight-normal"
                                            style="font-size: 0.75rem;">
                                            {{ $perm->name }}
                                        </span>
                                    @empty
                                        <span class="text-muted small">Tidak ada permission yang diberikan</span>
                                    @endforelse
                                </td>
                                <td class="py-3 px-4 align-middle">
                                    <div class="d-inline-flex align-items-center">
                                        <a href="{{ route('roles.edit', $role->id) }}"
                                            class="btn btn-dark btn-sm px-3 mr-1 font-weight-normal shadow-sm rounded"
                                            style="background-color: #0f172a; border: none; font-size: 0.8rem;">
                                            <i class="fas fa-edit mr-1" style="font-size: 0.75rem;"></i> Edit
                                        </a>
                                        <button type="button"
                                            class="btn btn-outline-danger btn-sm px-2 shadow-sm rounded btn-delete"
                                            data-action="{{ route('roles.destroy', $role->id) }}"
                                            data-name="{{ $role->name }}"
                                            style="font-size: 0.8rem; border-color: #cbd5e1;">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2 text-secondary" style="opacity: 0.3;"></i>
                                    <p class="mb-0 small">Belum ada role yang tersedia.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($roles->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="small text-muted">
                        Menampilkan {{ $roles->firstItem() }} sampai {{ $roles->lastItem() }} dari {{ $roles->total() }}
                        data
                    </span>
                    <div>
                        {{ $roles->links() }}
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
                    <h5 class="font-weight-bold text-dark mb-1">Hapus Role?</h5>
                    <p class="text-muted small mb-4" id="deleteModalText">Apakah Anda yakin ingin menghapus role ini?
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
@stop

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
