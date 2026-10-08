@extends('adminlte::page')

@section('title', 'Tambah Penjualan')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <div class="d-flex align-items-center">
                <h1 class="font-weight-bold text-dark mb-0" style="font-size: 2rem; line-height: 1;">
                    Tambah Penjualan
                </h1>
            </div>
            <div class="text-muted small mt-2">
                <a href="{{ url('/') }}" class="text-muted text-decoration-none">Home</a>
                <i class="fas fa-chevron-right mx-1" style="font-size: 0.6rem;"></i>
                <a href="{{ route('sales.index') }}" class="text-muted text-decoration-none">Penjualan</a>
                <i class="fas fa-chevron-right mx-1" style="font-size: 0.6rem;"></i>
                <span>Tambah Penjualan</span>
            </div>
        </div>
    </div>
@stop

@section('content')
    <form action="{{ route('sales.store') }}" method="POST" id="sale-form">
        @csrf

        {{-- Header Informasi Faktur --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
                    <div class="mr-3 d-flex align-items-center justify-content-center bg-light rounded-circle"
                        style="width: 38px; height: 38px;">
                        <i class="fas fa-file-invoice text-secondary"></i>
                    </div>
                    <div>
                        <h5 class="m-0 font-weight-bold text-dark">Informasi Faktur Penjualan</h5>
                        <small class="text-muted">Masukkan detail header faktur transaksi penjualan</small>
                    </div>
                </div>

                <div class="row">
                    {{-- Nomor Faktur (Auto-generated & Readonly) --}}
                    <div class="col-md-4 form-group mb-3 mb-md-0">
                        <label class="font-weight-normal text-secondary small">No. Faktur</label>
                        <input type="text" name="invoice_number" class="form-control font-weight-bold bg-light"
                            value="{{ $invoiceNumber }}" readonly style="border-radius: 8px;">
                    </div>

                    {{-- Tanggal Penjualan --}}
                    <div class="col-md-4 form-group mb-3 mb-md-0">
                        <label for="date" class="font-weight-normal text-secondary small">Tanggal Penjualan <span
                                class="text-danger">*</span></label>
                        <input type="date" name="date" class="form-control" id="date"
                            value="{{ old('date', $todayDate) }}" required style="border-radius: 8px;">
                    </div>

                    {{-- Nama Pembeli --}}
                    <div class="col-md-4 form-group mb-0">
                        <label for="customer_name" class="font-weight-normal text-secondary small">Nama Pembeli <span
                                class="text-danger">*</span></label>
                        <input type="text" name="customer_name"
                            class="form-control @error('customer_name') is-invalid @enderror" id="customer_name"
                            placeholder="Contoh: Toko Jaya Medan" value="{{ old('customer_name') }}" required
                            style="border-radius: 8px;" autofocus>
                        @error('customer_name')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Detail Barang --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                    <div class="d-flex align-items-center">
                        <div class="mr-3 d-flex align-items-center justify-content-center bg-light rounded-circle"
                            style="width: 38px; height: 38px;">
                            <i class="fas fa-boxes text-secondary"></i>
                        </div>
                        <div>
                            <h5 class="m-0 font-weight-bold text-dark">Item Barang</h5>
                            <small class="text-muted">Pilih produk yang akan dijual</small>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-dark btn-sm px-3 rounded-lg font-weight-medium"
                        id="btn-add-item">
                        <i class="fas fa-plus mr-1"></i> Tambah Item
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-borderless align-middle" id="items-table">
                        <thead>
                            <tr class="text-secondary small border-bottom">
                                <th style="min-width: 250px;">NAMA BARANG</th>
                                <th style="width: 130px;">STOK TERSEDIA</th>
                                <th style="width: 130px;">BANYAKNYA (pcs)</th>
                                <th style="width: 180px;">HARGA SATUAN (Rp)</th>
                                <th style="width: 180px;">SUBTOTAL (Rp)</th>
                                <th style="width: 50px;"></th>
                            </tr>
                        </thead>
                        <tbody id="items-container">
                            {{-- Row Item Pertama --}}
                            <tr class="item-row">
                                <td class="py-2 px-1">
                                    <select name="items[0][product_id]" class="form-control product-select" required
                                        style="border-radius: 6px;">
                                        <option value="">-- Pilih Barang --</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" data-stock="{{ $product->amount }}"
                                                data-price="{{ $product->unit_price }}">
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="py-2 px-1 align-middle">
                                    <input type="text" class="form-control stock-display text-center bg-light"
                                        value="-" readonly style="border-radius: 6px;">
                                </td>
                                <td class="py-2 px-1">
                                    <input type="number" name="items[0][amount]"
                                        class="form-control amount-input text-center" value="1" min="1" required
                                        style="border-radius: 6px;">
                                </td>
                                <td class="py-2 px-1">
                                    <input type="number" step="0.01" name="items[0][unit_price]"
                                        class="form-control price-input text-right bg-light" placeholder="0"
                                        min="0" readonly required style="border-radius: 6px;">
                                </td>
                                <td class="py-2 px-1">
                                    <input type="text"
                                        class="form-control subtotal-display text-right font-weight-semibold bg-light"
                                        value="Rp. 0" readonly style="border-radius: 6px;">
                                </td>
                                <td class="py-2 px-1 align-middle text-center">
                                    <button type="button" class="btn btn-link text-danger p-0 btn-remove-item"
                                        style="display: none;">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Ringkasan Total & Diskon --}}
                <div class="row justify-content-end mt-4 pt-3 border-top">
                    <div class="col-md-5 col-lg-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-secondary small font-weight-medium">Sub Total:</span>
                            <span class="font-weight-bold text-dark" id="display-subtotal">Rp. 0</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-secondary small font-weight-medium">Diskon (%):</span>
                            <div class="input-group input-group-sm" style="width: 120px;">
                                <input type="number" name="discount_percent" id="discount_percent"
                                    class="form-control text-right" value="0" min="0" max="100"
                                    style="border-radius: 6px 0 0 6px;">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-white" style="border-radius: 0 6px 6px 0;">%</span>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-secondary small font-weight-medium">Potongan Diskon:</span>
                            <span class="text-muted small" id="display-discount-amount">- Rp. 0</span>
                        </div>

                        <hr class="my-2">

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="font-weight-bold text-dark">Total Akhir:</span>
                            <span class="h4 font-weight-bold text-dark mb-0" id="display-total">Rp. 0</span>
                        </div>
                    </div>
                </div>

                {{-- Footer Tombol --}}
                <div class="d-flex justify-content-end align-items-center mt-3 pt-3 border-top">
                    <a href="{{ route('sales.index') }}"
                        class="btn btn-light border mr-2 px-4 rounded-lg font-weight-semibold">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-dark px-4 rounded-lg font-weight-semibold"
                        style="background-color: #0f172a; border: none;">
                        <i class="fas fa-save mr-2"></i> Simpan Penjualan
                    </button>
                </div>
            </div>
        </div>
    </form>
@stop

@section('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@stop

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let itemIndex = 1;
            const productsData = @json($products);

            const container = document.getElementById('items-container');
            const btnAdd = document.getElementById('btn-add-item');
            const discountInput = document.getElementById('discount_percent');

            // Fungsi Hitung Matematika Faktur
            function calculateTotals() {
                let grandSubtotal = 0;

                document.querySelectorAll('.item-row').forEach(row => {
                    const amountInput = row.querySelector('.amount-input');
                    const selectProduct = row.querySelector('.product-select');
                    const selectedOption = selectProduct.options[selectProduct.selectedIndex];
                    const stock = parseInt(selectedOption.getAttribute('data-stock')) || 0;

                    let amount = parseFloat(amountInput.value) || 0;

                    // Batasi jika melebihi stok yang ada
                    if (amount > stock && stock > 0) {
                        alert(`Stok tidak mencukupi! Stok yang tersedia hanya ${stock} pcs.`);
                        amountInput.value = stock;
                        amount = stock;
                    }

                    const price = parseFloat(row.querySelector('.price-input').value) || 0;
                    const subtotal = amount * price;

                    grandSubtotal += subtotal;
                    row.querySelector('.subtotal-display').value = 'Rp. ' + new Intl.NumberFormat('id-ID')
                        .format(subtotal);
                });

                const discountPercent = parseFloat(discountInput.value) || 0;
                const discountAmount = (grandSubtotal * discountPercent) / 100;
                const finalTotal = grandSubtotal - discountAmount;

                document.getElementById('display-subtotal').textContent = 'Rp. ' + new Intl.NumberFormat('id-ID')
                    .format(grandSubtotal);
                document.getElementById('display-discount-amount').textContent = '- Rp. ' + new Intl.NumberFormat(
                    'id-ID').format(discountAmount);
                document.getElementById('display-total').textContent = 'Rp. ' + new Intl.NumberFormat('id-ID')
                    .format(finalTotal);
            }

            // Update info stok dan harga saat barang dipilih
            function updateRowProductData(row) {
                const selectProduct = row.querySelector('.product-select');
                const selectedOption = selectProduct.options[selectProduct.selectedIndex];
                const stock = selectedOption.getAttribute('data-stock') || '-';
                const price = selectedOption.getAttribute('data-price') || 0;

                row.querySelector('.stock-display').value = stock !== '-' ? `${stock} pcs` : '-';
                row.querySelector('.price-input').value = price;

                const amountInput = row.querySelector('.amount-input');
                if (stock !== '-') {
                    amountInput.max = stock;
                }

                calculateTotals();
            }

            // Tampilkan/Sembunyikan Tombol Hapus
            function toggleRemoveButtons() {
                const rows = document.querySelectorAll('.item-row');
                rows.forEach(row => {
                    const btnRemove = row.querySelector('.btn-remove-item');
                    btnRemove.style.display = rows.length > 1 ? 'inline-block' : 'none';
                });
            }

            // Event listener saat memilih produk di baris
            container.addEventListener('change', function(e) {
                if (e.target.classList.contains('product-select')) {
                    updateRowProductData(e.target.closest('.item-row'));
                }
            });

            // Tambah Baris Baru
            btnAdd.addEventListener('click', function() {
                let optionsHtml = '<option value="">-- Pilih Barang --</option>';
                productsData.forEach(p => {
                    optionsHtml +=
                        `<option value="${p.id}" data-stock="${p.amount}" data-price="${p.unit_price}">${p.name}</option>`;
                });

                const newRow = document.createElement('tr');
                newRow.className = 'item-row';
                newRow.innerHTML = `
                    <td class="py-2 px-1">
                        <select name="items[${itemIndex}][product_id]" class="form-control product-select" required style="border-radius: 6px;">
                            ${optionsHtml}
                        </select>
                    </td>
                    <td class="py-2 px-1 align-middle">
                        <input type="text" class="form-control stock-display text-center bg-light" value="-" readonly style="border-radius: 6px;">
                    </td>
                    <td class="py-2 px-1">
                        <input type="number" name="items[${itemIndex}][amount]" class="form-control amount-input text-center" value="1" min="1" required style="border-radius: 6px;">
                    </td>
                    <td class="py-2 px-1">
                        <input type="number" step="0.01" name="items[${itemIndex}][unit_price]" class="form-control price-input text-right bg-light" placeholder="0" min="0" readonly required style="border-radius: 6px;">
                    </td>
                    <td class="py-2 px-1">
                        <input type="text" class="form-control subtotal-display text-right font-weight-semibold bg-light" value="Rp. 0" readonly style="border-radius: 6px;">
                    </td>
                    <td class="py-2 px-1 align-middle text-center">
                        <button type="button" class="btn btn-link text-danger p-0 btn-remove-item">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                `;

                container.appendChild(newRow);
                itemIndex++;
                toggleRemoveButtons();
            });

            // Hapus Baris Item
            container.addEventListener('click', function(e) {
                if (e.target.closest('.btn-remove-item')) {
                    e.target.closest('.item-row').remove();
                    calculateTotals();
                    toggleRemoveButtons();
                }
            });

            // Event Listener Rekalkulasi
            container.addEventListener('input', calculateTotals);
            discountInput.addEventListener('input', calculateTotals);
        });
    </script>
@stop
