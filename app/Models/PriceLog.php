<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PriceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'old_price',
        'new_price',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Accessor format rupiah harga baru
    protected function formattedNewPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Rp. ' . number_format($this->new_price, 0, ',', '.')
        );
    }

    // Accessor format rupiah harga lama
    protected function formattedOldPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->old_price ? 'Rp. ' . number_format($this->old_price, 0, ',', '.') : '-'
        );
    }
}
