<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Product;
use App\Models\StockLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::latest()->paginate(10);
        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $latest = Purchase::latest()->first();
        if (!$latest) {
            $invoiceNumber = 'SKR0000001';
        } else {
            $number = (int) substr($latest->invoice_number, 3);
            $invoiceNumber = 'SKR' . str_pad($number + 1, 7, '0', STR_PAD_LEFT);
        }

        $products = Product::all();
        $todayDate = date('Y-m-d');

        return view('purchases.create', compact('invoiceNumber', 'products', 'todayDate'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'invoice_number'         => 'required|string|unique:purchases,invoice_number',
            'date'                   => 'required|date',
            'supplier_name'          => 'required|string|max:255',
            'discount_percent'       => 'nullable|numeric|min:0|max:100',
            'items'                  => 'required|array|min:1',
            'items.*.product_name'   => 'required|string|max:255',
            'items.*.amount'         => 'required|integer|min:1',
            'items.*.unit_price'     => 'required|numeric|min:0',
            'items.*.discount_percent' => 'nullable|numeric|min:0|max:100',
        ]);

        DB::transaction(function () use ($request) {
            $subtotalFaktur = 0;
            $purchaseDetails = [];

            foreach ($request->items as $item) {
                $product = Product::where('name', $item['product_name'])->first();

                if ($product) {
                    $oldStock = $product->amount;
                    $product->increment('amount', $item['amount']);
                    $newStock = $product->fresh()->amount;

                    // Catat Log Stok Pembelian dengan Nama Supplier
                    StockLog::record($product->id, $oldStock, $newStock, 'pembelian', $request->supplier_name);
                } else {
                    $product = Product::create([
                        'name'       => $item['product_name'],
                        'amount'     => $item['amount'],
                        'unit_price' => 0,
                    ]);

                    // Catat Log Stok Produk Baru dengan Nama Supplier
                    StockLog::record($product->id, 0, $item['amount'], 'pembelian', $request->supplier_name);
                }

                // Perhitungan Diskon Per Produk (Item Level)
                $itemAmount          = $item['amount'];
                $itemUnitPrice       = $item['unit_price'];
                $itemGrossTotal      = $itemAmount * $itemUnitPrice;
                $itemDiscountPercent = $item['discount_percent'] ?? 0;
                $itemDiscountAmount  = ($itemGrossTotal * $itemDiscountPercent) / 100;

                // Subtotal per produk adalah total kotor dikurangi diskon per produk
                $itemSubtotal = $itemGrossTotal - $itemDiscountAmount;
                $subtotalFaktur += $itemSubtotal;

                $purchaseDetails[] = [
                    'product_id'       => $product->id,
                    'amount'           => $itemAmount,
                    'unit_price'       => $itemUnitPrice,
                    'discount_percent' => $itemDiscountPercent,
                    'discount_amount'  => $itemDiscountAmount,
                    'subtotal'         => $itemSubtotal,
                ];
            }

            // Perhitungan Diskon Faktur Keseluruhan (Overall Level)
            $discountPercent = $request->discount_percent ?? 0;
            $discountAmount  = ($subtotalFaktur * $discountPercent) / 100;
            $totalAkhir      = $subtotalFaktur - $discountAmount;

            $purchase = Purchase::create([
                'invoice_number'   => $request->invoice_number,
                'date'             => $request->date ?? date('Y-m-d'),
                'supplier_name'    => $request->supplier_name,
                'subtotal'         => $subtotalFaktur,
                'discount_percent' => $discountPercent,
                'discount_amount'  => $discountAmount,
                'total'            => $totalAkhir,
            ]);

            foreach ($purchaseDetails as $detail) {
                $detail['purchase_id'] = $purchase->id;
                PurchaseDetail::create($detail);
            }
        });

        return redirect()->route('purchases.index')
            ->with('success', 'Transaksi pembelian berhasil disimpan.');
    }

    public function show(Purchase $purchase)
    {
        $purchase->load('details.product');
        return view('purchases.show', compact('purchase'));
    }

    public function destroy(Purchase $purchase)
    {
        DB::transaction(function () use ($purchase) {
            foreach ($purchase->details as $detail) {
                if ($detail->product) {
                    $oldStock = $detail->product->amount;
                    $detail->product->decrement('amount', $detail->amount);
                    $newStock = $detail->product->fresh()->amount;

                    // Catat Log Pengurangan Stok dari Pembelian Batal/Hapus
                    StockLog::record($detail->product->id, $oldStock, $newStock, 'pembelian', $purchase->supplier_name);
                }
            }

            $purchase->delete();
        });

        return redirect()->route('purchases.index')
            ->with('success', 'Transaksi pembelian berhasil dihapus dan stok produk telah disesuaikan kembali.');
    }
}
