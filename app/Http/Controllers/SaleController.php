<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;
use App\Models\StockLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::latest()->paginate(10);
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        // Penomoran Faktur Berurutan (misal: SKR0000001)
        $latest = Sale::latest()->first();
        if (!$latest) {
            $invoiceNumber = 'SKR0000001';
        } else {
            $number = (int) substr($latest->invoice_number, 3);
            $invoiceNumber = 'SKR' . str_pad($number + 1, 7, '0', STR_PAD_LEFT);
        }

        // Hanya tampilkan produk yang stoknya > 0
        $products = Product::where('amount', '>', 0)->get();
        $todayDate = date('Y-m-d');

        return view('sales.create', compact('invoiceNumber', 'products', 'todayDate'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name'    => 'required|string|max:255',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'items'            => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.amount'   => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        // Validasi Awal: Cek Ketersediaan Stok Sebelum Eksekusi Transaksi
        foreach ($request->items as $index => $item) {
            $product = Product::find($item['product_id']);

            if (!$product) {
                return back()->withInput()->withErrors([
                    "items.{$index}.product_id" => "Produk tidak ditemukan dalam sistem."
                ]);
            }

            if ($product->amount < $item['amount']) {
                return back()->withInput()->withErrors([
                    'items' => "Stok untuk produk '{$product->name}' tidak mencukupi! Stok saat ini: {$product->amount} pcs, diminta: {$item['amount']} pcs."
                ]);
            }
        }

        DB::transaction(function () use ($request) {
            $subtotalFaktur = 0;
            $saleDetails = [];

            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);

                $oldStock = $product->amount;
                // Kurangi stok produk
                $product->decrement('amount', $item['amount']);
                $newStock = $product->fresh()->amount;

                // Catat Log Stok Penjualan Otomatis dengan Nama Pembeli
                StockLog::record($product->id, $oldStock, $newStock, 'penjualan', $request->customer_name);

                $itemSubtotal = $item['amount'] * $item['unit_price'];
                $subtotalFaktur += $itemSubtotal;

                $saleDetails[] = [
                    'product_id' => $product->id,
                    'amount'     => $item['amount'],
                    'unit_price' => $item['unit_price'],
                    'subtotal'   => $itemSubtotal,
                ];
            }

            $discountPercent = $request->discount_percent ?? 0;
            $discountAmount = ($subtotalFaktur * $discountPercent) / 100;
            $totalAkhir = $subtotalFaktur - $discountAmount;

            $sale = Sale::create([
                'invoice_number'   => $request->invoice_number,
                'date'             => $request->date ?? date('Y-m-d'),
                'customer_name'    => $request->customer_name,
                'subtotal'         => $subtotalFaktur,
                'discount_percent' => $discountPercent,
                'discount_amount'  => $discountAmount,
                'total'            => $totalAkhir,
            ]);

            foreach ($saleDetails as $detail) {
                $detail['sale_id'] = $sale->id;
                SaleDetail::create($detail);
            }
        });

        return redirect()->route('sales.index')
            ->with('success', 'Transaksi penjualan berhasil disimpan.');
    }

    public function show(Sale $sale)
    {
        $sale->load('details.product');
        return view('sales.show', compact('sale'));
    }

    public function destroy(Sale $sale)
    {
        DB::transaction(function () use ($sale) {
            foreach ($sale->details as $detail) {
                if ($detail->product) {
                    $oldStock = $detail->product->amount;
                    // Kembalikan stok yang batal dijual
                    $detail->product->increment('amount', $detail->amount);
                    $newStock = $detail->product->fresh()->amount;

                    // Catat Log Penambahan Stok dari Penjualan Batal/Hapus
                    StockLog::record($detail->product->id, $oldStock, $newStock, 'penjualan', $sale->customer_name);
                }
            }

            $sale->delete();
        });

        return redirect()->route('sales.index')
            ->with('success', 'Transaksi penjualan berhasil dihapus dan stok produk telah dikembalikan.');
    }
}
