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
        Schema::create('um_lemburs', function (Blueprint $table) {
            $table->id();
            $table->date('periode'); // Bulan dan tahun (misal: 2025-12-01 untuk Desember 2025)
            $table->string('nama');
            $table->string('jabatan');
            
            // Jam lembur per hari (1-31)
            $table->decimal('hari_1', 5, 2)->default(0);
            $table->decimal('hari_2', 5, 2)->default(0);
            $table->decimal('hari_3', 5, 2)->default(0);
            $table->decimal('hari_4', 5, 2)->default(0);
            $table->decimal('hari_5', 5, 2)->default(0);
            $table->decimal('hari_6', 5, 2)->default(0);
            $table->decimal('hari_7', 5, 2)->default(0);
            $table->decimal('hari_8', 5, 2)->default(0);
            $table->decimal('hari_9', 5, 2)->default(0);
            $table->decimal('hari_10', 5, 2)->default(0);
            $table->decimal('hari_11', 5, 2)->default(0);
            $table->decimal('hari_12', 5, 2)->default(0);
            $table->decimal('hari_13', 5, 2)->default(0);
            $table->decimal('hari_14', 5, 2)->default(0);
            $table->decimal('hari_15', 5, 2)->default(0);
            $table->decimal('hari_16', 5, 2)->default(0);
            $table->decimal('hari_17', 5, 2)->default(0);
            $table->decimal('hari_18', 5, 2)->default(0);
            $table->decimal('hari_19', 5, 2)->default(0);
            $table->decimal('hari_20', 5, 2)->default(0);
            $table->decimal('hari_21', 5, 2)->default(0);
            $table->decimal('hari_22', 5, 2)->default(0);
            $table->decimal('hari_23', 5, 2)->default(0);
            $table->decimal('hari_24', 5, 2)->default(0);
            $table->decimal('hari_25', 5, 2)->default(0);
            $table->decimal('hari_26', 5, 2)->default(0);
            $table->decimal('hari_27', 5, 2)->default(0);
            $table->decimal('hari_28', 5, 2)->default(0);
            $table->decimal('hari_29', 5, 2)->default(0);
            $table->decimal('hari_30', 5, 2)->default(0);
            $table->decimal('hari_31', 5, 2)->default(0);
            
            // Total dan upah
            $table->decimal('total_jam', 8, 2)->default(0);
            $table->decimal('upah_per_jam', 15, 2)->default(20000); // Default 20.000
            $table->decimal('total_upah', 15, 2)->default(0);
            
            // Keterangan tambahan (izin/sakit, tanggal merah, tidak bekerja)
            $table->text('keterangan')->nullable();
            
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            
            // Index untuk pencarian
            $table->index('periode');
            $table->index('nama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('um_lemburs');
    }
};