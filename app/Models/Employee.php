<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'salary',
        'salary_type',
        'incentive',
        'incentive_type',
        'payday_date',
    ];

    /**
     * Relasi ke model Loan (Satu karyawan bisa memiliki banyak riwayat pinjaman)
     */
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    /**
     * Helper untuk mengambil pinjaman yang masih aktif (belum lunas)
     */
    public function activeLoan()
    {
        return $this->hasOne(Loan::class)->where('status', 'active');
    }
}
