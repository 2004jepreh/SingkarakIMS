<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'old_stock',
        'new_stock',
        'type',
        'party_name',
    ];

    public static function record($productId, $oldStock, $newStock, $type, $partyName = null)
    {
        if ($oldStock != $newStock) {
            self::create([
                'product_id' => $productId,
                'old_stock'  => $oldStock,
                'new_stock'  => $newStock,
                'type'       => $type,
                'party_name' => $partyName,
            ]);
        }
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
