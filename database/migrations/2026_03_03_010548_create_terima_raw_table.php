<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('terima_raw', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_urut');
            $table->integer('hari');
            $table->date('tanggal');
            $table->string('nomor_tiket');
            $table->string('nopol');
            $table->string('transporter');
            $table->string('nama_supplier');
            $table->string('nama_barang');
            $table->decimal('gross', 10, 2);
            $table->decimal('tara', 10, 2);
            $table->decimal('netto', 10, 2);
            $table->decimal('total_per_hari', 10, 2)->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            
            $table->index('tanggal');
            $table->index('nomor_tiket')->unique();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('terima_raw');
    }
};