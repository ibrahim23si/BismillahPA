<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produksi_raw', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_produksi');
            $table->decimal('total_output', 10, 2); // tonase output
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->decimal('total_jam_operasional', 5, 2); // auto calculate
            $table->decimal('produktivitas_per_jam', 10, 2); // auto calculate (ton/jam)
            $table->text('keterangan')->nullable(); // downtime dll
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            
            $table->index('tanggal_produksi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produksi_raw');
    }
};