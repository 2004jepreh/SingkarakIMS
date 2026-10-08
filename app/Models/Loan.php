<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'amount',
        'remaining_amount',
        'status',
    ];

    /**
     * Relasi balik ke Employee
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Relasi ke LoanPayment (Satu pinjaman memiliki banyak riwayat cicilan)
     */
    public function payments()
    {
        return $this->hasMany(LoanPayment::class);
    }

    /**
     * Accessor untuk format Rupiah jumlah pinjaman awal
     */
    protected function formattedAmount(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Rp. ' . number_format($this->amount, 0, ',', '.')
        );
    }

    /**
     * Accessor untuk format Rupiah sisa pinjaman
     */
    protected function formattedRemainingAmount(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Rp. ' . number_format($this->remaining_amount, 0, ',', '.')
        );
    }
}
