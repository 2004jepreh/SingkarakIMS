<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 15, 2); // Nominal pinjam awal (misal: 300000)
            $table->decimal('remaining_amount', 15, 2); // Sisa pinjaman (berkurang terus dari 300000 -> 200000 -> 100000 -> 0)
            $table->enum('status', ['active', 'paid_off'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
