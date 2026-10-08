<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class LoanPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'amount_paid',
        'payment_date',
    ];

    /**
     * Relasi balik ke Loan
     */
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    /**
     * Accessor untuk format Rupiah jumlah yang dibayar
     */
    protected function formattedAmountPaid(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Rp. ' . number_format($this->amount_paid, 0, ',', '.')
        );
    }
}
