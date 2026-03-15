<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lap_kas', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('nomor_bukti'); // nomor bukti transaksi
            $table->text('keterangan');
            $table->decimal('debet', 15, 2)->default(0); // uang masuk
            $table->decimal('kredit', 15, 2)->default(0); // uang keluar
            $table->decimal('saldo', 15, 2)->default(0); // running balance
            
            // Relasi ke transaksi asal (nullable)
            $table->foreignId('jual_material_id')->nullable()->constrained('jual_material')->nullOnDelete();
            $table->foreignId('aju_kas_id')->nullable()->constrained()->nullOnDelete();
            
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            
            $table->index('tanggal');
            $table->index('nomor_bukti');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lap_kas');
    }
};