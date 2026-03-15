<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('piutang', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('nama_debitur'); // nama yang berhutang
            $table->string('jenis_transaksi'); // Batu Splite, Abu, dll
            $table->date('tanggal_invoice');
            $table->string('nomor_invoice')->nullable();
            $table->decimal('nominal', 15, 2);
            $table->date('tanggal_jatuh_tempo')->nullable();
            $table->integer('over_due')->default(0);
            
            // Pembayaran
            $table->enum('status', ['pending', 'approved', 'paid'])->default('pending');
            $table->date('tanggal_bayar')->nullable();
            $table->decimal('cash_bayar', 15, 2)->nullable();
            $table->decimal('transfer_bayar', 15, 2)->nullable();
            $table->decimal('sisa', 15, 2)->nullable();
            
            // Relasi ke jual material (asal piutang)
            $table->foreignId('jual_material_id')->nullable()->constrained('jual_material')->nullOnDelete();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            
            $table->index('tanggal');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('piutang');
    }
};