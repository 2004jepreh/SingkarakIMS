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
     * Accessor untuk memformat harga satuan ke Rupiah
     */
    protected function formattedUnitPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Rp. ' . number_format($this->unit_price, 0, ',', '.')
        );
    }
}
