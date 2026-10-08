<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'amount',
        'unit_price',
    ];

    /**
     * Relasi ke model PriceLog (Satu produk memiliki banyak log harga)
     */
    public function priceLogs()
    {
        return $this->hasMany(PriceLog::class)->latest();
    }

    public function stockLogs()
    {
        return $this->hasMany(StockLog::class);
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }

    /**
     * Accessor untuk memformat harga satuan ke Rupiah
     */
    protected function formattedUnitPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Rp. ' . number_format($this->unit_price, 0, ',', '.')
        );
    }
}
