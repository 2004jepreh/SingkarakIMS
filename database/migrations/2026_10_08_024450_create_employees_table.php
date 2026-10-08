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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('salary', 15, 2);
            $table->enum('salary_type', ['weekly', 'monthly']); // Jenis gaji: per minggu / per bulan
            $table->decimal('incentive', 15, 2)->default(0);
            $table->enum('incentive_type', ['weekly', 'monthly']); // Jenis insentif: per minggu / per bulan
            $table->date('payday_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
