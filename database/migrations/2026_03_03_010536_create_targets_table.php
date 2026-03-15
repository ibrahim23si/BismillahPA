<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('targets', function (Blueprint $table) {
            $table->id();
            $table->enum('tipe', ['produksi', 'penjualan']); // jenis target
            $table->enum('periode', ['harian', 'mingguan', 'bulanan']);
            $table->decimal('tonase_target', 10, 2); // target dalam ton
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->text('keterangan')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            
            // Index untuk pencarian
            $table->index(['tipe', 'periode']);
            $table->index(['tanggal_mulai', 'tanggal_selesai']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('targets');
    }
};