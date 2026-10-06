<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PriceLog;
use App\Models\StockLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar semua produk.
     */
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    /**
     * Menampilkan form untuk menambah produk baru.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Menyimpan produk baru ke database dan mencatat log harga pertama.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'amount'     => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
        ]);

        $product = Product::create([
            'name'       => $request->name,
            'amount'     => $request->amount,
            'unit_price' => $request->unit_price,
        ]);

        // Catat log saat penambahan produk baru
        PriceLog::create([
            'product_id' => $product->id,
            'old_price'  => null,
            'new_price'  => $request->unit_price,
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit produk.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Memperbarui data produk di database dan mencatat log jika harga berubah.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'amount'     => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $product) {
            $oldPrice = $product->unit_price;
            $newPrice = $request->unit_price;

            $oldStock = $product->amount;
            $newStock = $request->amount;

            // 1. Update data produk
            $product->update([
                'name'       => $request->name,
                'amount'     => $request->amount,
                'unit_price' => $request->unit_price,
            ]);

            // 2. Jika harga berubah, catat ke PriceLog
            if ($oldPrice != $newPrice) {
                PriceLog::create([
                    'product_id' => $product->id,
                    'old_price'  => $oldPrice,
                    'new_price'  => $newPrice,
                ]);
            }

            // 3. Jika stok berubah dari edit manual, catat otomatis ke StockLog dengan tipe 'edit'
            if ($oldStock != $newStock) {
                StockLog::record($product->id, $oldStock, $newStock, 'edit', '-');
            }
        });

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Menampilkan riwayat perubahan harga satuan produk.
     */
    public function log(Product $product)
    {
        // Fetch Price Logs
        $priceLogs = $product->priceLogs()->latest()->get();

        // Fetch Stock Logs
        $stockLogs = $product->stockLogs()->latest()->get();

        return view('products.log', compact('product', 'priceLogs', 'stockLogs'));
    }

    /**
     * Menghapus produk dari database.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
