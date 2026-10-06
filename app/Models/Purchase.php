<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'date',
        'supplier_name',
        'subtotal',
        'discount_percent',
        'discount_amount',
        'total',
    ];

    public function details()
    {
        return $this->hasMany(PurchaseDetail::class);
    }

    // Accessor format rupiah
    protected function formattedTotal(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Rp. ' . number_format($this->total, 0, ',', '.')
        );
    }
}
