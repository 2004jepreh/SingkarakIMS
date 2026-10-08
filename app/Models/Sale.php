<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'date',
        'customer_name',
        'subtotal',
        'discount_percent',
        'discount_amount',
        'total',
    ];

    /**
     * Relasi ke SaleDetail (Satu Penjualan punya banyak Item Detail Penjualan)
     */
    public function details()
    {
        return $this->hasMany(SaleDetail::class);
    }

    /**
     * Helper accessor untuk format rupiah total
     */
    public function getFormattedTotalAttribute()
    {
        return 'Rp. ' . number_format($this->total, 0, ',', '.');
    }
}
